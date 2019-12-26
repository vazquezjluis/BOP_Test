<?php

class Fallas extends CI_Controller {


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

        $this->load->model('fallas_model', '', TRUE);
        $this->load->model('consola_model', '', TRUE);
        $this->load->model('articulo_model', '', TRUE);
    }

    function index(){
        $this->gestionar();
    }

    function gestionar(){
<<<<<<< HEAD

        // $this->load->library('pagination');
        //
        // $config['base_url'] = base_url().'index.php/fallas/gestionar/';
        // $config['total_rows'] = $this->fallas_model->count('fallas');
        // $config['per_page'] = 10;
        // $config['next_link'] = 'Próxima';
        // $config['prev_link'] = 'Anterior';
        // $config['full_tag_open'] = '<div class="pagination alternate"><ul>';
        // $config['full_tag_close'] = '</ul></div>';
        // $config['num_tag_open'] = '<li>';
        // $config['num_tag_close'] = '</li>';
        // $config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
        // $config['cur_tag_close'] = '</b></a></li>';
        // $config['prev_tag_open'] = '<li>';
        // $config['prev_tag_close'] = '</li>';
        // $config['next_tag_open'] = '<li>';
        // $config['next_tag_close'] = '</li>';
        // $config['first_link'] = 'Primera';
        // $config['last_link'] = 'Última';
        // $config['first_tag_open'] = '<li>';
        // $config['first_tag_close'] = '</li>';
        // $config['last_tag_open'] = '<li>';
        // $config['last_tag_close'] = '</li>';
        //
        // $this->pagination->initialize($config);

        $this->data['results'] = $this->fallas_model->get('fallas','*',' estado != 90 ',$this->uri->segment(3));

        //$this->data['results_articulo'] = $this->articulo_model->list_articulo_generico();
        $this->data['results_articulo'] = array();



=======
        
        $this->load->library('pagination');
    
        $config['base_url'] = base_url().'index.php/fallas/gestionar/';
        $config['total_rows'] = $this->fallas_model->count('fallas');
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
        $this->data['results'] = $this->fallas_model->get('fallas','*',' estado != 90 ',$config['per_page'],$this->uri->segment(3));       
		
        //$this->data['results_articulo'] = $this->articulo_model->list_articulo_generico();       
        $this->data['results_articulo'] = array();
>>>>>>> 78135b1e18f6bbb996b5ba058a1d6101a538c44b
		$this->data['view'] = 'fallas/fallas';
       	$this->load->view('tema/header',$this->data);

    }

    function agregar(){
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';

        if ($this->form_validation->run('fallas') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : false);
        } else
        {
            if (count($this->input->post('articulo'))){
                $articulo = implode("-_-", $this->input->post('articulo'));
            }else{
                $articulo='';
            }
            $data = array(
                    'tipo' => set_value('tipo'),
                    'descripcion' => set_value('descripcion'),
                    'gravedad' => set_value('gravedad'),
                    'estado' => 1,
                    'articulo'=>$articulo
            );
            if ($this->fallas_model->add('fallas',$data) == TRUE)
            {


                $acciones = array(
                    'usuario' => $this->session->userdata('id'),
                    'accion_id' => 1,
                    'accion' => 'Agrega la falla: '.set_value('tipo').' - '.set_value('descripcion'),
                    'modulo' => 1,
                    'fecha_registro' => date('Y-m-d')
                );
                if ($this->consola_model->add('consola',$acciones) == TRUE){

                    $this->session->set_flashdata('success','Falla registrada con éxito!');
                    redirect(base_url().'index.php/fallas/agregar/');
                }
            }
            else
            {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al agregar la falla.</p></div>';
            }
        }

        $this->load->model('fallas_model');
        $this->load->model('articulo_model');
        $this->data['articulos'] = $this->articulo_model->list_articulo_generico();
        $this->data['fallas'] = $this->fallas_model->get('fallas','*');
	$this->data['view'] = 'fallas/agregarFalla';
        $this->load->view('tema/header',$this->data);


    }

    function editar(){


        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $this->form_validation->set_rules('tipo', 'Tipo', 'trim|required');
        $this->form_validation->set_rules('descripcion', 'Descripcion', 'trim|required');;

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else
        {
                if (count($this->input->post('articulo'))){
                    $articulo = implode("-_-", $this->input->post('articulo'));
                }else{
                    $articulo='';
                }
                $data = array(
                    'tipo' => $this->input->post('tipo'),
                    'descripcion' => $this->input->post('descripcion'),
                    'gravedad' => $this->input->post('gravedad'),
                    'estado' => $this->input->post('estado'),
                    'articulo' => $articulo
                );

                if ($this->fallas_model->edit('fallas',$data,'idFallas',$this->input->post('idFallas')) == TRUE)
			{
                            $acciones = array(
                                'usuario' => $this->session->userdata('id'),
                                'accion_id' => 2,
                                'accion' => 'Edita la falla: '.set_value('descripcion').' - '.set_value('tipo'),
                                'modulo' => 1,
                                'fecha_registro' => date('Y-m-d h:i:s')
                            );
                            if ($this->consola_model->add('consola',$acciones) == TRUE){
                                $this->session->set_flashdata('success','Falla  editada con éxito!');
				redirect(base_url().'index.php/fallas/editar/'.$this->input->post('idFallas'));
                            }
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error</p></div>';

			}
		}

		$this->data['result'] = $this->fallas_model->getById($this->uri->segment(3));

		$this->load->model('articulo_model');
                $this->data['articulos'] = $this->articulo_model->list_articulo_generico();

		$this->data['view'] = 'fallas/editarFalla';
                $this->load->view('tema/header',$this->data);


    }

    public function eliminar(){

            $ID =  $this->uri->segment(3);
            $this->usuarios_model->delete('usuarios','idUsuarios',$ID);
            redirect(base_url().'index.php/usuarios/gestionar/');
    }
    function get_articulo_asociado($articulo){
        $articulos = explode("-_-", $articulo);
        if(count($articulos)){
            $this->load->model('articulo_model', '', TRUE);
            foreach ($articulos as $art){
                $return[$art]= $this->articulo_model->getById($art);
            }
        }
        return $return;
    }
    function desactivar(){

        $id =  $this->input->post('id');
        if ($id == null){
            $this->session->set_flashdata('error','Ocurrio un error al intentar eliminar la falla.');
            redirect(base_url().'index.php/fallas/gestionar/');
        }
        $data = array(
          'estado' => 90
        );
        if($this->fallas_model->edit('fallas',$data,'idFallas',$id)){
          $this->session->set_flashdata('success','Falla eleiminada con exito!');
        }
        else{
          $this->session->set_flashdata('error','Error al eliminar la falla!');
        }


        redirect(base_url().'index.php/fallas/gestionar/');
    }

    public function autoCompleteFallas_logica(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->fallas_model->autoCompleteFallasLogica($q);
        }

    }

    public function autoCompleteFallas_fisica(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->fallas_model->autoCompleteFallasFisica($q);
        }

    }

    public function tipo_fallas(){
        $this->data['result'] = $this->fallas_model->get('fallas','*',' fallas.tipo = "'.$_GET['tipo'].'"');

        $html='';
        if(count($this->data['result'])){
            foreach ($this->data['result'] as $r){
                $html.='<tr><td><input type="checkbox" name="fallas[]" value="'.$r->idFallas.'"></td><td>'.$r->descripcion.'</td></tr>';
            }
        }
        echo $html;
    }
}
