<?php

class Institucion extends CI_Controller {
    

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

        $this->load->model('institucion_model', '', TRUE);
        $this->load->model('consola_model', '', TRUE);
        
    }

    function index(){
        $this->data['view'] = 'rrhh/capacitacion/capacitacion';
       	$this->load->view('tema/header',$this->data);
    }

    function listadoCapacitacion(){
        
        $this->load->library('pagination');
    
        $config['base_url'] = base_url().'index.php/capacitacion/listarCapacitacion/';
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
        
       
        $this->data['view'] = 'rrhh/capacitacion/listadoCapacitacion';
       	$this->load->view('tema/header',$this->data);

       
		
    }
    
    function listadoVinculo(){
        
        $this->load->library('pagination');
    
        $config['base_url'] = base_url().'index.php/capacitacion/listarVinculo/';
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

        $this->data['results'] = $this->capacitacion_model->getPersonaCapacitacion($config['per_page'],$this->uri->segment(3));
        
       
        $this->data['view'] = 'rrhh/capacitacion/listadoVinculo';
       	$this->load->view('tema/header',$this->data);

       
		
    }
	
    function agregar(){  
          
//        $this->load->library('form_validation');    
//		$this->data['custom_error'] = '';
//		
//        if ($this->form_validation->run('capacitacion') == false)
//        {
//             $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : false);
//        } else
//        {     
            if ($this->input->post('nombre')!=''){
                $data = array(
                    'nombre' => $this->input->post('nombre'),
                    'direccion' => $this->input->post('direccion'),
                    'telefono' => $this->input->post('telefono'),
                    'email' => $this->input->post('email'),
                    'estado' => 1,
                    'web' => $this->input->post('web')
                );

                if ($this->institucion_model->add('institucion',$data) == TRUE)
                    {   
                        $acciones = array(
                            'usuario' => $this->session->userdata('id'),
                            'accion_id' => 1,
                            'accion' => 'Agrega la institucion: '.$this->input->post('nombre'),
                            'modulo' => 2,
                            'fecha_registro' => date('Y-m-d')
                        );
                        if ($this->consola_model->add('consola',$acciones) == TRUE){
                            $this->session->set_flashdata('success','institucion registrado con éxito!');
    //                            redirect(base_url().'index.php/usuarios/agregar/');
                        }
                    }
                else
                {
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al guardar la consola de la capacitacion.</p></div>';
                }
    }
//        }
        $this->load->model('persona_model');  
        $this->data['view'] = 'rrhh/capacitacion/institucion/agregarInstitucion';
        $this->data['idCapacitacion'] = $this->uri->segment(3);
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
    
    function vincular(){
        $valida = 0;
        
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';	
        if ($this->form_validation->run('vincular_capacitacion') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : false);
        }elseif($valida!=0)
        {
            $this->data['custom_error'] = '<div class="alert alert-danger">'.$valida.'</div>';
        } 
        else
        {    
            //datos
            $data_capacitacion_persona = array(
                'idCapacitacion' => $this->input->post('capacitacion'),
                'idPersona' => $this->input->post('persona_id'),
                'fecha_registro' => date('Y-m-d'),
                'estado' => 1,
                'usuario' => $this->session->userdata('id')
            );
            
            if ($this->capacitacion_model->add('capacitacion_persona',$data_capacitacion_persona) == TRUE)
                {   
                    $id_capacitacion_persona = $this->db->insert_id();
                    $acciones = array(
                        'usuario' => $this->session->userdata('id'),
                        'accion_id' => 1,
                        'accion' => 'Vincula la capacitacion: '.$this->input->post('idCapacitacion').' con el empleado '.$this->input->post('persona_id'),
                        'modulo' => 2,
                        'fecha_registro' => date('Y-m-d')
                    );
                    if ($this->consola_model->add('consola',$acciones) == TRUE){
                                
                        $this->session->set_flashdata('success','Capacitacion vinculada con éxito!');
                            //redirect(base_url().'index.php/licencia/vincular');
                    }
                    if ($this->input->post('desde_persona')!==NULL){
                        redirect(base_url().'index.php/persona/visualizar?buscar='.$this->input->post('persona_id'));
                    }  
                }
            else
            {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al guardar la consola del vinculo de la capacitacion.</p></div>';
            }
            
            
        }
        
        $this->data['capacitacion'] = $this->capacitacion_model->get();
        $this->data['view'] = 'rrhh/capacitacion/vincularCapacitacion';
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
    
    public function eliminarCapacitacionPersona(){
        $id =  $this->input->post('id');
        if ($id == null){
            $this->session->set_flashdata('error','Ocurrio un error al intentar eliminar la capacitacion.');            
            redirect(base_url().'index.php/capacitacion/listadoVinculo/');
        }
        $data = array(
          'estado' => 0
        );
        
         if($this->capacitacion_model->edit('capacitacion_persona',$data,'idCapacitacionPersona',$id)){
          $this->session->set_flashdata('success','Capacitacion eliminada!');  
        }
        else{
          $this->session->set_flashdata('error','Error al eliminar la capacitacion!');  
        }  
//            $this->capacitacion_model->delete('capacitacion','idCapacitacion',$id);             
            redirect(base_url().'index.php/capacitacion/listadoVinculo');
    }
}

