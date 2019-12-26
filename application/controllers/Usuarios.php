<?php

class Usuarios extends CI_Controller {
    

    /**
     * author: Jose Luis Vazquez 
     * email: vazquezjluis@yahoo.com
     * celular : (54) 1165792663
     */
    
    function __construct() {

        parent::__construct();
        if( (!session_id()) || (!$this->session->userdata('conectado'))){
            redirect('bingoOasis/login');
        }
        if(!$this->permission->checkPermission($this->session->userdata('permiso'),'cUsuario')){
          $this->session->set_flashdata('error','Usted no tiene permisos para configurar los usuarios.');
          redirect(base_url());
        }

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('usuarios_model', '', TRUE);
        $this->load->model('consola_model', '', TRUE);
        $this->data['menuUsuarios'] = 'Usuários';
        $this->data['menuConfiguraciones'] = 'Configuraciones';
    }

    function index(){
        $this->gestionar();
    }

    function gestionar(){
        
        $this->load->library('pagination');
    
        $config['base_url'] = base_url().'index.php/usuarios/gestionar/';
        $config['total_rows'] = $this->usuarios_model->count('usuarios');
        $config['per_page'] = 10;
        $config['next_link'] = 'Próxima';
        $config['prev_link'] = 'Anterior';
        $config['full_tag_open'] = '<div class="pagination alternate"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';	
        $config['first_link'] = 'Primera';
        $config['last_link'] = 'Última';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        
        $this->pagination->initialize($config); 	

        $this->data['results'] = $this->usuarios_model->get($config['per_page'],$this->uri->segment(3));
       
        $this->data['view'] = 'usuarios/usuarios';
       	$this->load->view('tema/header',$this->data);

       
		
    }
	
    function agregar(){  
          
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('usuarios') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : false);
        } else
        {     
            $data = array(
                    'legajo' => set_value('legajo'),
                    'nombre' => set_value('nombre'),
                    'estado' => set_value('estado'),
                    'usr' => set_value('usr'),
                    'email' => set_value('email'),
                    'clave' => password_hash($this->input->post('clave'),PASSWORD_DEFAULT,array('cost'=>12)),
                    'celular' => set_value('celular'),
                    'permisos_id' => $this->input->post('permisos_id'),
                    'fecha_registro' => date('Y-m-d')
            );
           
                    if ($this->usuarios_model->add('usuarios',$data) == TRUE)
                    {   
                            $acciones = array(
                                'usuario' => $this->session->userdata('id'),
                                'accion_id' => 1,
                                'accion' => 'Agrega al usuario: '.set_value('nombre').' - '.set_value('email'),
                                'modulo' => 1,
                                'fecha_registro' => date('Y-m-d')
                            );
                            if ($this->consola_model->add('consola',$acciones) == TRUE){
                                
                                $this->session->set_flashdata('success','Usuario registrado con éxito!');
                                redirect(base_url().'index.php/usuarios/agregar/');
                            }
                    }
                    else
                    {
                            $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error.</p></div>';

                    }
            }
        
        $this->load->model('permisos_model');
        $this->data['permisos'] = $this->permisos_model->getActive('permisos','permisos.idPermiso,permisos.nombre');   
		$this->data['view'] = 'usuarios/agregarUsuario';
        $this->load->view('tema/header',$this->data);
   
       
    }	
    
    function importacion_empleados() {
        $this->data['custom_error'] = '';
	//Obtengo los datos de la tabla empleados
        //
        if (function_exists("set_time_limit") == TRUE AND @ini_get("safe_mode") == 0)
        {
            @set_time_limit(1000);// change according to your requirement
        }
        $empleados_a_migrar = $this->usuarios_model->get_empleados(" 
            em_estado = 1 
            AND em_pass_activo = 1
            AND em_pass !='' AND LENGTH(em_pass) > 1
            AND em_legajo NOT IN (
                    SELECT legajo FROM usuarios WHERE legajo!=''
            )");
        
        if (count($empleados_a_migrar))
        {
            foreach ($empleados_a_migrar as $r) {
                
                $data = array(
                    'legajo' => $r->em_legajo,
                    'nombre' => $r->em_nombre." ".$r->em_apellido,
                    'estado' => 1,
                    'usr' => $r->em_legajo,
                    'email' => '',
                    'clave' => password_hash($r->em_pass,PASSWORD_DEFAULT,array('cost'=>12)),
                    'celular' => 0,
                    'permisos_id' => 47,//OJO ver el ID que toma en produccon
                    'fecha_registro' => date('Y-m-d')
                );
                $this->usuarios_model->add('usuarios',$data);
                 
            }
        }
         else
        {     
            $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-danger">No existen empleados en la tabla</div>' : false);
        }
        $this->data['view'] = 'usuarios/importacion_empleado';
        $this->load->view('tema/header',$this->data);
    }
    function editar(){  
        
        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','El registro no puede ser encontrado, el parámetro no fue pasado correctamente.');
            redirect('bingoOasis');
        }

        $this->load->library('form_validation');    
        $this->data['custom_error'] = '';
//        $this->form_validation->set_rules('legajo', 'Legajo', 'trim|required');
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');
        $this->form_validation->set_rules('usr', 'Usuario', 'trim|required');
//        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('estado', 'Estado', 'trim|required');
        $this->form_validation->set_rules('permisos_id', 'Permiso', 'trim|required');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else
        { 

            if ($this->input->post('idUsuarios') == 1 && $this->input->post('estado') == 0)
            {
                $this->session->set_flashdata('error','El usuario administrador no puede ser desactivado!');
                redirect(base_url().'index.php/usuarios/editar/'.$this->input->post('idUsuarios'));
            }

            $clave = $this->input->post('clave'); 
            if($clave != null){

                $data = array(
                        'legajo' => $this->input->post('legajo'),
                        'nombre' => $this->input->post('nombre'),
                        'usr' => $this->input->post('usr'),
                        'estado' => $this->input->post('estado'),
                        'email' => $this->input->post('email'),
                        'clave' => password_hash($clave,PASSWORD_DEFAULT,array('cost'=>12)),                        
                        'celular' => $this->input->post('celular'),
                        'permisos_id' => $this->input->post('permisos_id')
                );
            }  

            else{

                $data = array(
                        'legajo' => $this->input->post('legajo'),
                        'estado' => $this->input->post('estado'),
                        'usr' => $this->input->post('usr'),
                        'email' => $this->input->post('email'),
                        'celular' => $this->input->post('celular'),
                        'permisos_id' => $this->input->post('permisos_id')
                );

            }  

           
			if ($this->usuarios_model->edit('usuarios',$data,'idUsuarios',$this->input->post('idUsuarios')) == TRUE)
			{
                            $acciones = array(
                                'usuario' => $this->session->userdata('id'),
                                'accion_id' => 2,
                                'accion' => 'Edita al usuario: '.set_value('nombre').' - '.set_value('email'),
                                'modulo' => 1,
                                'fecha_registro' => date('Y-m-d h:i:s')
                            );
                            if ($this->consola_model->add('consola',$acciones) == TRUE){
                                $this->session->set_flashdata('success','Usuario editado con éxito!');
				redirect(base_url().'index.php/usuarios/editar/'.$this->input->post('idUsuarios'));
                            }
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error</p></div>';

			}
		}

		$this->data['result'] = $this->usuarios_model->getById($this->uri->segment(3));
        $this->load->model('permisos_model');
        $this->data['permisos'] = $this->permisos_model->getActive('permisos','permisos.idPermiso,permisos.nombre'); 

		$this->data['view'] = 'usuarios/editarUsuario';
        $this->load->view('tema/header',$this->data);
			
      
    }
	
    public function excluir(){

            $ID =  $this->uri->segment(3);
            $this->usuarios_model->delete('usuarios','idUsuarios',$ID);             
            redirect(base_url().'index.php/usuarios/gestionar/');
    }
}

