<?php

class Titulo extends CI_Controller {
    

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
        if(!$this->permission->checkPermission($this->session->userdata('permiso'),'vTitulo')){
          $this->session->set_flashdata('error','Usted no tiene permisos para configurar los titulos.');
          redirect(base_url());
        }

        $this->load->model('titulo_model', '', TRUE);
        $this->load->model('consola_model', '', TRUE);
        
    }

    function index(){
        $this->gestionar();
    }

    function gestionar(){
        
        $this->load->library('pagination');
    
        $config['base_url'] = base_url().'index.php/titulo/gestionar/';
        $config['total_rows'] = count($this->titulo_model->getActive('titulo','*'));
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
        $this->data['results'] = $this->titulo_model->get('titulo','*',' estado = 1 ',$config['per_page'],$this->uri->segment(3));       
		
	$this->data['view'] = 'rrhh/titulo/titulo';
       	$this->load->view('tema/header',$this->data);

    }
	
    function agregar(){  
          
//        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
//		
//        if ($this->form_validation->run('capacitacion') == false)
//        {
//             $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : false);
//        } else
//        {    
        
            if ($this->input->post('nombre')!=''){
                $data = array(
                    'nombre' => $this->input->post('nombre'),
                    'estado' => 1
                );

                if ($this->titulo_model->add('titulo',$data) == TRUE)
                    {   
                        $acciones = array(
                            'usuario' => $this->session->userdata('id'),
                            'accion_id' => 1,
                            'accion' => 'Agrega el titulo : '.$this->input->post('nombre'),
                            'modulo' => 2,
                            'fecha_registro' => date('Y-m-d')
                        );
                        if ($this->consola_model->add('consola',$acciones) == TRUE){
                            $this->session->set_flashdata('success','titulo registrado con éxito!');
    //                            redirect(base_url().'index.php/usuarios/agregar/');
                        }
                    }
                else
                {
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al guardar la consola del titulo.</p></div>';
                }
    }
//        }
    
        $this->data['view'] = 'rrhh/titulo/agregarTitulo';
        $this->load->view('tema/header',$this->data);
   
       
    }	
    
    function editar(){  
        
        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','El registro no puede ser encontrado, el parámetro no fue pasado correctamente.');
            redirect('bingoOasis');
        }

        $this->load->library('form_validation');    
        $this->data['custom_error'] = '';
        $this->form_validation->set_rules('nombre', 'nombre', 'trim|required');
//        $this->form_validation->set_rules('descripcion', 'Descripcion', 'trim|required');
        
        if ($this->form_validation->run() == false)
        {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        } else
        { 
            //datos que vienen del formulario
            $data = array(
                    'nombre' => $this->input->post('nombre')
            );
            
            if ($this->titulo_model->edit('titulo',$data,'idTitulo',$this->input->post('idTitulo')) == TRUE)
                {
                    $acciones = array(
                        'usuario' => $this->session->userdata('id'),
                        'accion_id' => 2,
                        'accion' => 'Edita el Titulo: '.$this->input->post('idTitulo').' - '.$this->input->post('nombre'),
                        'modulo' => 2,
                        'fecha_registro' => date('Y-m-d h:i:s')
                    );
                    if ($this->consola_model->add('consola',$acciones) == TRUE){
                        $this->session->set_flashdata('success','Titulo editado con éxito!');
//                        redirect(base_url().'index.php/usuarios/editar/'.$this->input->post('idUsuarios'));
                    }
                }
                else
                {
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al editar el titulo comuniquese con el administrador</p></div>';
                }
        }

        $this->data['result'] = $this->titulo_model->getById($this->uri->segment(3));
        
        $this->data['view'] = 'rrhh/titulo/editarTitulo';
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
	
    public function desactivar(){
        $id =  $this->input->post('id');
        if ($id == null){
            $this->session->set_flashdata('error','Ocurrio un error al intentar eliminar la capacitacion.');            
            redirect(base_url().'index.php/rrhh/titulo/titulo');
        }
        $data = array(
          'estado' => 0
        );
        
         if($this->titulo_model->edit('titulo',$data,'idTitulo',$id)){
          $this->session->set_flashdata('success','Titulo eliminado!');  
        }
        else{
          $this->session->set_flashdata('error','Error al eliminar el titulo!');  
        }  
//            $this->capacitacion_model->delete('capacitacion','idCapacitacion',$id);             
            redirect(base_url().'index.php/titulo');
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

