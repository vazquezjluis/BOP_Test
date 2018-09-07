<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class BingoOasis extends CI_Controller {


    /**
     * author: Jose Luis Vazquez 
     * email: vazquezjluis@yahoo.com
     * celular : (54) 1165792663
     */
    
    public function __construct() {
        parent::__construct();
        $this->load->model('BingoOasis_model','',TRUE);
        $this->load->model('maquinas_model','',TRUE);
        $this->load->model('ticket_model', '', TRUE);
        $this->load->model('maquinas_model', '', TRUE);
        $this->load->model('laboratorio_model', '', TRUE);
        
    }

    public function index() {
        if( (!session_id()) || (!$this->session->userdata('conectado'))){
            redirect('bingoOasis/login');
        }

        //Estadisticas del sistema
        //obtiene la cantidad de tickets activos
        $this->count_ticket(1);
        //cuenta las maquinas fuera de servicio
        $this->count_maquinas(0);
        //cuenta los laboratorios en proceso
        $this->count_laboratorio(1);
        
        //Maquinas fuera de servicio
        $this->data['menuPanel'] = 'Panel';
        $this->data['view'] = 'bingoOasis/panel';
        $this->load->view('tema/header',  $this->data);
      
    }

    public function miCuenta() {
        if( (!session_id()) || (!$this->session->userdata('conectado'))){
            redirect('bingoOasis/login');
        }

        $this->data['usuario'] = $this->BingoOasis_model->getById($this->session->userdata('id'));
        $this->data['view'] = 'bingoOasis/miCuenta';
        $this->load->view('tema/header',  $this->data);
     
    }

    public function modificarClave() {
        if( (!session_id()) || (!$this->session->userdata('conectado'))){
            redirect('bingoOasis/login');
        }

        
        $viejaClave = $this->input->post('oldClave');
        $clave = $this->input->post('newClave');
        $result = $this->BingoOasis_model->modificarClave($clave,$viejaClave,$this->session->userdata('id'));
        if($result){
            $this->session->set_flashdata('success','Clave modificada con éxito!');
            redirect(base_url() . 'index.php/bingoOasis/miCuenta');
        }
        else{
            $this->session->set_flashdata('error','Ocurrio un error al modificar su clave!');
            redirect(base_url() . 'index.php/bingoOasis/miCuenta');
            
        }
    }



    public function login(){
        
        $this->load->view('bingoOasis/login');
        
    }
    public function salir(){
        $this->session->sess_destroy();
        redirect('bingoOasis/login');
    }


    public function verificarLogin(){
        
        header('Access-Control-Allow-Origin: '.base_url());
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Content-Type');
        
        $this->load->library('form_validation');
//        $this->form_validation->set_rules('email','E-mail','valid_email|required|trim');
        $this->form_validation->set_rules('clave','Clave','required|trim');
        
        
        if ($this->form_validation->run() == false) {
            $json = array('result' => false, 'message' => validation_errors());
            echo json_encode($json);
        }
        else {
            $usuario = $this->input->post('usuario');
            $password = $this->input->post('clave');
            $this->load->model('BingoOasis_model');
            $user = $this->BingoOasis_model->check_credentials($usuario);
            
            if($user){
                if(password_verify($password, $user->clave)){
                    $session_data = array(
                        'nombre' => $user->nombre,
                        'email' => $user->email,
                        'id' => $user->idUsuarios,
                        'permiso' => $user->permisos_id , 
                        'usuario' => $user->usr , 
                        'conectado' => TRUE);
                    $this->session->set_userdata($session_data);
                    $json = array('result' => true);
                    echo json_encode($json);
                }
                else{
                    $json = array('result' => false, 'message' => 'Los datos de acceso son incorrectos.');
                    echo json_encode($json);
                }
            }
            else{
                $json = array('result' => false, 'message' => 'No encontramos su usuario, por favor verifique sus credenciales.');
                echo json_encode($json);
            }
        }
        die();
    }


    public function backup(){

        if( (!session_id()) || (!$this->session->userdata('conectado'))){
            redirect('bingoOasis/login');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permiso'),'cBackup')){
           $this->session->set_flashdata('error','Usted no tiene permisos para generar un backup.');
           redirect(base_url());
        }

        $this->load->dbutil();
        $prefs = array(
                'format'      => 'zip',
                'foreign_key_checks' => false,
                'filename'    => 'backup'.date('d-m-Y').'.sql'
              );

        $backup = $this->dbutil->backup($prefs);

        $this->load->helper('file');
        write_file(base_url().'backup/backup.zip', $backup);

        $this->load->helper('download');
        force_download('backup'.date('d-m-Y H:m:s').'.zip', $backup);
    }
    
     function count_ticket ($estado = 0){
        $where = ' estado = '.$estado;
        $this->data['count_ticket'] = count($this->ticket_model->get('ticket','idTicket',$where));
        
    }  
    function count_maquinas ($estado = 0){
        $where = ' estado = '.$estado;
        $this->data['count_maquinas'] = count($this->maquinas_model->get('maquinas','idMaquina',$where));
        
    }  
    function count_laboratorio ($estado = 0 ){
        $where = ' estado = '.$estado;
        $this->data['count_laboratorio'] = count($this->laboratorio_model->get('articulos_laboratorio','idArticuloLaboratorio',$where));
        
    } 
    
}