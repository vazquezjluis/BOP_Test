<?php

class Sala extends CI_Controller {
    

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
		
        
        $this->load->model('consola_model', '', TRUE);
        $this->load->model('sala_model', '', TRUE);
    }

    function index(){
        $this->calendario();
    }

    function gestionar(){
        $this->data['results'] = $this->sala_model->get('sala','*',' estado != 0 ');       
        echo json_encode($this->data['results']);
    }
	
    function calendario(){
       	
        $this->data['view'] = 'sala/calendario';
       	$this->load->view('tema/header',$this->data);
    }
    function agregar(){ 
        $this->load->library('form_validation');    
        $this->data['custom_error'] = '';
		
//        if ($this->form_validation->run('sala') == false)
//        {
//             $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : false);
//        } else
//        {   
            
            $data = array(
                    'title'         => $this->input->post('title'),
                    'descripcion'   => $this->input->post('descripcion'),
                    'color'         => $this->input->post('color'),
                    'textColor'     => $this->input->post('textColor'),
                    'start'         => $this->input->post('start'),
                    'end'           => $this->input->post('end'),
                    'estado'        => 1,
                    'f_creacion'    => date('Y-m-d'),
                    'usuario'       => $this->session->userdata('id')
            );
            if ($this->sala_model->add('sala',$data) == TRUE)
            {   
                
                echo json_encode($data);
            }
            else
            {
                
            }
//        }
       
    }	
    
    function editar(){  
            $data = array(
                    'title'         => $this->input->post('title'),
                    'descripcion'   => $this->input->post('descripcion'),
                    'color'         => $this->input->post('color'),
                    'textColor'     => $this->input->post('textColor'),
                    'start'         => $this->input->post('start'),
                    'end'           => $this->input->post('end')
            );
            if ($this->sala_model->edit('sala',$data,'idSala',$this->input->post('idSala')) == TRUE)
            {
                echo json_encode($data);
            }
            else
            {
            }
    }
	
    public function eliminar(){
            $data = array(
                'estado'         => 0
            );
            if ($this->sala_model->edit('sala',$data,'idSala',$this->input->post('idSala')) == TRUE)
            {
                echo json_encode($data);
            }
            else
            {
            }
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
