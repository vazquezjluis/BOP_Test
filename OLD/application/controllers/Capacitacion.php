<?php

class Capacitacion extends CI_Controller {
    

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
        if(!$this->permission->checkPermission($this->session->userdata('permiso'),'vCapacitacion')){
          $this->session->set_flashdata('error','Usted no tiene permisos para configurar las capacitaciones.');
          redirect(base_url());
        }

        
        $this->load->model('capacitacion_model', '', TRUE);
        $this->load->model('consola_model', '', TRUE);
        
    }

    function index(){
        $this->gestionar();
    }

    function gestionar(){
        
        $this->load->library('pagination');
    
        $config['base_url'] = base_url().'index.php/capacitacion/gestionar/';
        $config['total_rows'] = $this->capacitacion_model->count('capacitacion');
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

        $this->data['results'] = $this->capacitacion_model->get($config['per_page'],$this->uri->segment(3));
        
       
        $this->data['view'] = 'rrhh/capacitacion/capacitacion';
       	$this->load->view('tema/header',$this->data);

       
		
    }
	
    function agregar(){  
          
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('capacitacion') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : false);
        } else
        {     
            
            $data = array(
                    'tema' => $this->input->post('tema'),
                    'descripcion' => $this->input->post('descripcion'),
                    'f_inicio' => $this->input->post('f_inicio'),
                    'f_fin' => $this->input->post('f_fin'),
                    'estado' => 1,
                    'f_registro' => date('Y-m-d'),
                    'usuario' => $this->session->userdata('id'),
                    'institucion' => $this->input->post('institucion'),
                    'modalidad' => $this->input->post('modalidad'),
                    'cupo' => $this->input->post('cupo'),
                    'capacitador' => $this->input->post('capacitador'),
                    'tipo' => $this->input->post('tipo'),
                    'evaluacion' => $this->input->post('evaluacion')
            );
            
            if ($this->capacitacion_model->add('capacitacion',$data) == TRUE)
                {   
                    $acciones = array(
                        'usuario' => $this->session->userdata('id'),
                        'accion_id' => 1,
                        'accion' => 'Agrega la capacitacion: '.set_value('titulo'),
                        'modulo' => 2,
                        'fecha_registro' => date('Y-m-d')
                    );
                    if ($this->consola_model->add('consola',$acciones) == TRUE){
                                
                        $this->session->set_flashdata('success','Usuario registrado con éxito!');
//                            redirect(base_url().'index.php/usuarios/agregar/');
                        }
                    }
            else
            {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al guardar la consola de la capacitacion.</p></div>';
            }
        }
        $this->load->model('persona_model');  
        $this->data['view'] = 'rrhh/capacitacion/agregarCapacitacion';
        $this->load->view('tema/header',$this->data);
   
       
    }	
    
    function editar(){  
        
        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','El registro no puede ser encontrado, el parámetro no fue pasado correctamente.');
            redirect('bingoOasis');
        }

        $this->load->library('form_validation');    
        $this->data['custom_error'] = '';
        $this->form_validation->set_rules('tema', 'tema', 'trim|required');
//        $this->form_validation->set_rules('descripcion', 'Descripcion', 'trim|required');
        
        if ($this->form_validation->run() == false)
        {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        } else
        { 
            //datos que vienen del formulario
            $data = array(
                    'tema' => $this->input->post('tema'),
                    'descripcion' => $this->input->post('descripcion'),
                    'f_inicio' => $this->input->post('f_inicio'),
                    'f_fin' => $this->input->post('f_fin'),
                    'f_registro' => date('Y-m-d'),
                    'usuario' => $this->session->userdata('id'),
                    'institucion' => $this->input->post('institucion'),
                    'modalidad' => $this->input->post('modalidad'),
                    'cupo' => $this->input->post('cupo'),
                    'capacitador' => $this->input->post('capacitador'),
                    'tipo' => $this->input->post('tipo'),
                    'evaluacion' => $this->input->post('evaluacion')
            );
            
            if ($this->capacitacion_model->edit('capacitacion',$data,'idCapacitacion',$this->input->post('idCapacitacion')) == TRUE)
                {
                    $acciones = array(
                        'usuario' => $this->session->userdata('id'),
                        'accion_id' => 2,
                        'accion' => 'Edita la capacitacipon: '.$this->input->post('idCapacitacion').' - '.$this->input->post('titulo')." # ".$this->input->post('descripcioon'),
                        'modulo' => 2,
                        'fecha_registro' => date('Y-m-d h:i:s')
                    );
                    if ($this->consola_model->add('consola',$acciones) == TRUE){
                        $this->session->set_flashdata('success','Capacitacion editada con éxito!');
//                        redirect(base_url().'index.php/usuarios/editar/'.$this->input->post('idUsuarios'));
                    }
                }
                else
                {
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error</p></div>';
                }
        }

        $this->data['result'] = $this->capacitacion_model->getById($this->uri->segment(3));
        
        $this->data['view'] = 'rrhh/capacitacion/editarCapacitacion';
        $this->load->view('tema/header',$this->data);
			
      
    }
	
    public function excluir(){
        $id =  $this->input->post('id');
        if ($id == null){
            $this->session->set_flashdata('error','Ocurrio un error al intentar eliminar la capacitacion.');            
            redirect(base_url().'index.php/capacitacion/gestionar/');
        }
        $data = array(
          'estado' => 0
        );
        
         if($this->capacitacion_model->edit('capacitacion',$data,'idCapacitacion',$id)){
          $this->session->set_flashdata('success','Capacitacion eliminada!');  
        }
        else{
          $this->session->set_flashdata('error','Error al eliminar la capacitacion!');  
        }  
//            $this->capacitacion_model->delete('capacitacion','idCapacitacion',$id);             
            redirect(base_url().'index.php/capacitacion');
    }
}

