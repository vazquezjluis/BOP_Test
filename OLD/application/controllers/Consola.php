<?php

class Consola extends CI_Controller {
    

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

        if(!$this->permission->checkPermission($this->session->userdata('permiso'),'cConsola')){
          $this->session->set_flashdata('error','Usted no tiene permisos para revisar la consola.');
          redirect(base_url());
        }

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('consola_model', '', TRUE);
        $this->data['menuConfiguraciones'] = 'Consola';
    }
	
    function index(){
        $this->gestionar();
    }

    function gestionar(){
        
        $this->load->library('pagination');

        $config['base_url'] = base_url().'index.php/consola/gestionar/';
        $config['total_rows'] = $this->consola_model->count('consola');
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

		  $this->data['results'] = $this->consola_model->get(
                          'consola',
                          'idConsola,modulo,fecha_registro,accion,accion_id,usuario','',$config['per_page'],$this->uri->segment(3));
                 
	    $this->data['view'] = 'consola/consola';
       	$this->load->view('tema/header',$this->data);
	
    }
	
    function agregar($accion,$accion_id,$usuario,$modulo) {

        $registro = date('Y-m-d h:i:s');
        $data = array(
            'usuario' => $usuario,
            'fecha_registro' => $registro,
            'accion' => $accion,
            'modulo' => $modulo,
            'accion_id' => $accion_id
        );

        $this->consola_model->add('consola', $data);
    }

}


/* End of file permissoes.php */
/* Location: ./application/controllers/permissoes.php */
