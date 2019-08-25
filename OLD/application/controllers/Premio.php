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
                          'idPremio,nombre,f_premio,estado','',$config['per_page'],$this->uri->segment(3));
       
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
            
            $nombrePermiso = $this->input->post('nombre');
            $registro = date('Y-m-d');
            $estado = 1;

            
            
            $permisos = serialize($permisos);

            $data = array(
                'nombre' => $nombrePermiso,
                'fecha_registro' => $registro,
                'permisos' => $permisos,
                'estado' => $estado
            );

            if ($this->permisos_model->add('permisos', $data) == TRUE) {
                $acciones = array(
                    'usuario' => $this->session->userdata('id'),
                    'accion_id' => 1,
                    'accion' => 'Agrega el permiso : '.$nombrePermiso.' - '.$permisos,
                    'modulo' => 2,
                    'fecha_registro' => date('Y-m-d h:i:s')
                );
                
                if ($this->consola_model->add('consola',$acciones) == TRUE){
                    $this->session->set_flashdata('success', 'Permisos agregados con exito!');
                    redirect(base_url() . 'index.php/permisos/agregar/');
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
            
            $nombrePermiso = $this->input->post('nombre');
            $estado = $this->input->post('estado');
           /* 
            * v... Visualizar
            * e... Editar
            * d... Deletar 
            * c... Crear
            * 
            */
            $permisos = array(
                  'cUsuario' => $this->input->post('cUsuario'),
                  'cPermiso' => $this->input->post('cPermiso'),
                  'cConsola' => $this->input->post('cConsola'),
                  'cBackup' => $this->input->post('cBackup'),
                
                  'vMaquina' => $this->input->post('vMaquina'),
                  'eMaquina' => $this->input->post('eMaquina'),
                  'dMaquina' => $this->input->post('dMaquina'),
                  'cMaquina' => $this->input->post('cMaquina'),
                
                  'vFallas' => $this->input->post('vFallas'),
                  'eFallas' => $this->input->post('eFallas'),
                  'dFallas' => $this->input->post('dFallas'),
                  'cFallas' => $this->input->post('cFallas'),
                
                  'vArticulos' => $this->input->post('vArticulos'),
                  'eArticulos' => $this->input->post('eArticulos'),
                  'dArticulos' => $this->input->post('dArticulos'),
                  'cArticulos' => $this->input->post('cArticulos'),  
                
                  'vCategorias' => $this->input->post('vCategorias'),
                  'eCategorias' => $this->input->post('eCategorias'),
                  'dCategorias' => $this->input->post('dCategorias'),
                  'cCategorias' => $this->input->post('cCategorias'),  
                
                  'vTicket' => $this->input->post('vTicket'),
                  'cTicket' => $this->input->post('cTicket'),
                
                  'vLaboratorio' => $this->input->post('vLaboratorio'),
                
                  'vManuales' => $this->input->post('vManuales'),
                
                  'vImporMaquinas' => $this->input->post('vImporMaquinas'),
                  'vImporArticulos' => $this->input->post('vImporArticulos'),
                  'vImporArticulos_maq' => $this->input->post('vImporArticulos_maq'),
                  'vImporPersona' => $this->input->post('vImporPersona'),
                
                  'vPersonas' => $this->input->post('vPersonas'),
                  'vLicencias' => $this->input->post('vLicencias'),
                  'vCapacitacion' => $this->input->post('vCapacitacion'),
                  'vPremios' => $this->input->post('vPremios'),
                
                  'vRep_maquinas' => $this->input->post('vRep_maquinas')

            );
            $permisos = serialize($permisos);

            $data = array(
                'nombre' => $nombrePermiso,
                'permisos' => $permisos,
                'estado' => $estado
            );

            if ($this->permisos_model->edit('permisos', $data, 'idPermiso', $this->input->post('idPermiso')) == TRUE) {
                $acciones = array(
                        'usuario' => $this->session->userdata('id'),
                        'accion_id' => 2,
                        'accion' => 'Edita al permiso '.$this->input->post('idPermiso').': '.$nombrePermiso.' - '.$permisos,
                        'modulo' => 2,
                        'fecha_registro' => date('Y-m-d h:i:s')
                    );
                if ($this->consola_model->add('consola',$acciones) == TRUE){
                    $this->session->set_flashdata('success', 'Permiso editado con éxito!');
                    redirect(base_url() . 'index.php/permisos/editar/'.$this->input->post('idPermiso'));
                }
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error.</p></div>';
            }
        }

        $this->data['result'] = $this->permisos_model->getById($this->uri->segment(3));
        $this->data['view'] = 'permisos/editarPermiso';
        $this->load->view('tema/header', $this->data);

    }
	
    function desactivar(){
        
        $id =  $this->input->post('id');
        if ($id == null){
            $this->session->set_flashdata('error','Ocurrio un error al intentar desactivar el permiso.');            
            redirect(base_url().'index.php/permisos/gestionar/');
        }
        $data = array(
          'estado' => false
        );
        if($this->permisos_model->edit('permisos',$data,'idPermiso',$id)){
          $this->session->set_flashdata('success','Permiso desactivado con exito!');  
        }
        else{
          $this->session->set_flashdata('error','Error al desactivar el permiso!');  
        }         
        
                  
        redirect(base_url().'index.php/permisos/gestionar/');
    }
}


/* End of file permissoes.php */
/* Location: ./application/controllers/permissoes.php */