<?php

class Licencia extends CI_Controller {
    

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
        if(!$this->permission->checkPermission($this->session->userdata('permiso'),'vLicencia')){
          $this->session->set_flashdata('error','Usted no tiene permisos para configurar las licencias.');
          redirect(base_url());
        }

        
        $this->load->model('licencia_model', '', TRUE);
        $this->load->model('consola_model', '', TRUE);
        $this->load->model('persona_model', '', TRUE);
        
    }

    function index(){
        $this->gestionar();
    }

    function gestionar(){
        
        $this->load->library('pagination');
    
        $config['base_url'] = base_url().'index.php/licencia/gestionar/';
        $config['total_rows'] = $this->licencia_model->count('licencia');
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

        $this->data['results'] = $this->licencia_model->get($config['per_page'],$this->uri->segment(3));
        
       
        $this->data['view'] = 'rrhh/licencia/licencia';
       	$this->load->view('tema/header',$this->data);

       
		
    }
	
    function agregar(){  
          
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('licencia') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : false);
        } else
        {     
            
            
            $data = array(
                    'titulo' => $this->input->post('titulo'),
                    'descripcion' => $this->input->post('descripcion'),
                    'dias' => $this->input->post('dias'),
                    'estado' => 1
            );
            
            if ($this->licencia_model->add('licencia',$data) == TRUE)
                {   
                    $acciones = array(
                        'usuario' => $this->session->userdata('id'),
                        'accion_id' => 1,
                        'accion' => 'Agrega la licencia: '.set_value('titulo'),
                        'modulo' => 2,
                        'fecha_registro' => date('Y-m-d')
                    );
                    if ($this->consola_model->add('consola',$acciones) == TRUE){
                                
                        $this->session->set_flashdata('success','Licencia registrado con éxito!');
                            redirect(base_url().'index.php/licencia/agregar/');
                        }
                    }
                    else
                    {
                        $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al guardar la consola de la licencia.</p></div>';
                    }
            }
        
        $this->data['view'] = 'rrhh/licencia/agregarLicencia';
        $this->load->view('tema/header',$this->data);
   
       
    }	
    
    function editar(){  
        
        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','El registro no puede ser encontrado, el parámetro no fue pasado correctamente.');
            redirect('bingoOasis');
        }

        $this->load->library('form_validation');    
        $this->data['custom_error'] = '';
        $this->form_validation->set_rules('titulo', 'Titulo', 'trim|required');
        $this->form_validation->set_rules('descripcion', 'Descripcion', 'trim|required');
        
        if ($this->form_validation->run() == false)
        {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        } else
        { 

            $data = array(
                'titulo' => $this->input->post('titulo'),
                'descripcion' => $this->input->post('descripcion'),
                'dias' => $this->input->post('dias'),
                'estado' => 1
            );
            
            if ($this->licencia_model->edit('licencia',$data,'idLicencia',$this->input->post('idLicencia')) == TRUE)
                {
                    $acciones = array(
                        'usuario' => $this->session->userdata('id'),
                        'accion_id' => 2,
                        'accion' => 'Edita la licencia: '.$this->input->post('idLicencia').' - '.$this->input->post('titulo')." # ".$this->input->post('descripcioon'),
                        'modulo' => 2,
                        'fecha_registro' => date('Y-m-d h:i:s')
                    );
                    if ($this->consola_model->add('consola',$acciones) == TRUE){
                        $this->session->set_flashdata('success','Licencia editada con éxito!');
                        redirect(base_url().'index.php/licencia/editar/'.$this->input->post('idLicencia'));
                    }
                }
                else
                {
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error</p></div>';
                }
        }

        $this->data['result'] = $this->licencia_model->getById($this->uri->segment(3));
        
        $this->data['view'] = 'rrhh/licencia/editarLicencia';
        $this->load->view('tema/header',$this->data);
			
      
    }
	
    public function eliminar(){
        $id =  $this->input->post('id');
        if ($id == null){
            $this->session->set_flashdata('error','Ocurrio un error al intentar eliminar la Licencia.');            
            redirect(base_url().'index.php/licencia/gestionar/');
        }
        $data = array(
          'estado' => 0
        );
        
        if($this->licencia_model->edit('licencia',$data,'idLicencia',$id)){
          $this->session->set_flashdata('success','Licencia eliminada!');  
        }
        else{
          $this->session->set_flashdata('error','Error al eliminar la licencia!');  
        }  
        redirect(base_url().'index.php/licencia/gestionar/');
    }
    
    function vincular(){
        $valida = 0;
        if (isset($_POST)){
            $valida = $this->validar_vinculo($_POST);
        }
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';	
        if ($this->form_validation->run('vincular_licencia') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : false);
        }elseif($valida!=0)
        {
            $this->data['custom_error'] = '<div class="alert alert-danger">'.$valida.'</div>';
        } 
        else
        {     
            
            
            $data = array(
                    'idLicencia' => $this->input->post('licencia'),
                    'idPersona' => $this->input->post('persona_id'),
                    'dias' => $this->input->post('dias'),
                    'descripcion' => $this->input->post('descripcion'),
                    'fecha_registro' => date('Y-m-d'),
                    'usuario' => $this->session->userdata('id')
            );
            
            if ($this->licencia_model->add('licencia_persona',$data) == TRUE)
                {   
                    $acciones = array(
                        'usuario' => $this->session->userdata('id'),
                        'accion_id' => 1,
                        'accion' => 'Vincula la licencia: '.$this->input->post('idLicencia').' con el usuario '.$this->input->post('idUsuario'),
                        'modulo' => 2,
                        'fecha_registro' => date('Y-m-d')
                    );
                    if ($this->consola_model->add('consola',$acciones) == TRUE){
                                
                        $this->session->set_flashdata('success','Licencia vinculada con éxito!');
                            redirect(base_url().'index.php/licencia/vincular');
                        }
                    }
                    else
                    {
                        $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al guardar la consola del vinculo de la licencia.</p></div>';
                    }
            }
        
        $this->data['licencia'] = $this->licencia_model->get();
        $this->data['view'] = 'rrhh/licencia/vincularLicencia';
        $this->load->view('tema/header',$this->data);
   
       
    }	
    
    public function autoCompletePersona(){
        
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            
            $this->persona_model->autoCompletePersona($q);
        }

    }
    
    function validar_vinculo($post){
        if (!isset($post["persona_id"])){ return "campo persona invalida.";}
        if (!isset($post["licencia"])){ return "campo licencia invalida.";}
        if (!isset($post["dias"])){ return "campo dias invalido.";}
        $licencia = $this->licencia_model->getById($post["licencia"]);
        if ($post["dias"] > $licencia->dias ){ return "La cantidad de dias tomados excede el total de la licencia seleccionada.";}
        
        return 0;
    }
    
    
    
}

