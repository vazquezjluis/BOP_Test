<?php

class Premio extends CI_Controller {
    

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

        if(!$this->permission->checkPermission($this->session->userdata('permiso'),'vPremios')){
          $this->session->set_flashdata('error','Usted no tiene permisos para configurar los premios del sistema.');
          redirect(base_url());
        }

        
        $this->load->model('premio_model', '', TRUE);
        $this->load->model('consola_model', '', TRUE);
    }
	
    function index(){
        $this->gestionar();
    }

    function gestionar(){
        
        $this->load->library('pagination');

        $config['base_url'] = base_url().'index.php/premio/gestionar/';
        $config['total_rows'] = $this->premio_model->count('premio');
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

		  $this->data['results'] = $this->premio_model->get(
                          'premio',
                          'idPremio,nombre,descripcion',' premio.estado = 1',$config['per_page'],$this->uri->segment(3));
       
	    $this->data['view'] = 'rrhh/premio/premio';
       	$this->load->view('tema/header',$this->data);
	
    }
	
    function agregar() {

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            
            
            $data = array(
                'nombre' => $this->input->post('nombre'),
                'descripcion' => $this->input->post('descripcion'),
                'f_registro' => date('Y-m-d')
            );

            if ($this->premio_model->add('premio', $data) == TRUE) {
                $acciones = array(
                    'usuario' => $this->session->userdata('id'),
                    'accion_id' => 1,
                    'accion' => 'Agrega el premio : '.$this->input->post('nombre'),
                    'modulo' => 2,
                    'fecha_registro' => date('Y-m-d h:i:s')
                );
                
                if ($this->consola_model->add('consola',$acciones) == TRUE){
                    $this->session->set_flashdata('success', 'Premio agregados con exito!');
                    //redirect(base_url() . 'index.php/permisos/agregar/');
                }
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error.</p></div>';
            }
           
        }

        $this->data['view'] = 'rrhh/premio/agregarPremio';
        $this->load->view('tema/header', $this->data);

    }

    function editar() {

        
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('nombre', 'nombre', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            
            $data = array(
                'nombre' => $this->input->post('nombre'),
                'descripcion' => $this->input->post('descripcion'),
                
            );

            if ($this->premio_model->edit('premio', $data, 'idPremio', $this->input->post('idPremio')) == TRUE) {
                $acciones = array(
                        'usuario' => $this->session->userdata('id'),
                        'accion_id' => 2,
                        'accion' => 'Edita al premio '.$this->input->post('idPremio'),
                        'modulo' => 2,
                        'fecha_registro' => date('Y-m-d h:i:s')
                    );
                if ($this->consola_model->add('consola',$acciones) == TRUE){
                    $this->session->set_flashdata('success', 'Premio editado con éxito!');
//                    redirect(base_url() . 'index.php/permisos/editar/'.$this->input->post('idPermiso'));
                }
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error.</p></div>';
            }
        }

        $this->data['result'] = $this->premio_model->getById($this->uri->segment(3));
        $this->data['view'] = 'rrhh/premio/editarPremio';
        $this->load->view('tema/header', $this->data);

    }
	
    function desactivar(){
        
        $id =  $this->input->post('id');
        if ($id == null){
            $this->session->set_flashdata('error','Ocurrio un error al intentar desactivar el permiso.');            
            redirect(base_url().'index.php/premio/');
        }
        $data = array(
          'estado' => 0
        );
        if($this->premio_model->edit('premio',$data,'idPremio',$id)){
          $this->session->set_flashdata('success','premio desactivado con exito!');  
        }
        else{
          $this->session->set_flashdata('error','Error al desactivar el permiso!');  
        }         
        
                  
        redirect(base_url().'index.php/premio/');
    }
    
    function vincular(){
        
        //
        
        
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';	
        if ($this->form_validation->run('vincular_premio') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : false);
        } 
        else
        {    
            //datos
            $data_premio_persona = array(
                'idPremio' => $this->input->post('premio'),
                'idPersona' => $this->input->post('persona_id'),
                'descripcion' => $this->input->post('descripcion'),
                'fecha_registro' => date('Y-m-d'),
                'fecha_entrega' => $this->input->post('f_entrega'),                
                'usuario' => $this->session->userdata('id')
            );
            
            if ($this->premio_model->add('premio_persona',$data_premio_persona) == TRUE)
                {   
                    $id_premio_persona = $this->db->insert_id();
                    $acciones = array(
                        'usuario' => $this->session->userdata('id'),
                        'accion_id' => 1,
                        'accion' => 'Vincula el premio: '.$this->input->post('idPremio').' con la persona '.$this->input->post('persona_id'),
                        'modulo' => 2,
                        'fecha_registro' => date('Y-m-d')
                    );
                    if ($this->consola_model->add('consola',$acciones) == TRUE){
                                
                        $this->session->set_flashdata('success','premio vinculado con éxito!');
                            //redirect(base_url().'index.php/licencia/vincular');
                        }
                    }
            else
            {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al guardar la consola del vinculo de la licencia.</p></div>';
            }
            
        }
        
        
        $this->data['premio'] = $this->premio_model->get("premio","*","estado = 1");
        $this->data['view'] = 'rrhh/premio/vincularPremio';
        $this->load->view('tema/header',$this->data);
   
       
    }	
    
}


/* End of file permissoes.php */
/* Location: ./application/controllers/permissoes.php */
