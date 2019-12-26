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
        $this->load->model('articulo_model', '', TRUE);
        $this->load->model('maquinas_model', '', TRUE);
        $this->load->model('laboratorio_model', '', TRUE);
        $this->load->model('usuarios_model', '', TRUE);

    }

    public function index() {
        if( (!session_id()) || (!$this->session->userdata('conectado'))){
            redirect('bingoOasis/login');
        }



//        if (  $this->permission->checkPermission($this->session->userdata('permiso'),'vSala') == false and
//              $this->permission->checkPermission($this->session->userdata('permiso'),'vPersonas') == false and
//              $this->permission->checkPermission($this->session->userdata('permiso'),'vCapacitacion') ==false and
//              $this->permission->checkPermission($this->session->userdata('permiso'),'vPremios') ==false and
//              $this->permission->checkPermission($this->session->userdata('permiso'),'vPedido') == false and
//              $this->permission->checkPermission($this->session->userdata('permiso'),'vMaquina') == false and
//              $this->permission->checkPermission($this->session->userdata('permiso'),'vLaboratorio') == false and
//              $this->permission->checkPermission($this->session->userdata('permiso'),'vRep_maquinas') == false and
//                $this->permission->checkPermission($this->session->userdata('permiso'),'vArticulos') == false and
//                $this->permission->checkPermission($this->session->userdata('permiso'),'vImporMaquinas') == false and
//                $this->permission->checkPermission($this->session->userdata('permiso'),'vImporMenu') ==  false and
//                $this->permission->checkPermission($this->session->userdata('permiso'),'cUsuario') == false and
//                $this->permission->checkPermission($this->session->userdata('permiso'),'cPermiso') == false and
//                $this->permission->checkPermission($this->session->userdata('permiso'),'cPedido') == true
//                ){
//
                   // $this->data['menuPanel'] = 'Panel';
                   // $this->data['view'] = 'gastronomia/pedidos';
                   // $this->load->view('tema/header',  $this->data);
//                }
//                else{
                    //Estadisticas del sistema
                    //obtiene cantidad de articulos
                    $this->count_articulos();
                    //obtiene la cantidad de tickets activos
                    $this->count_ticket(1);
                    //cuenta las maquinas fuera de servicio
                    $this->count_maquinas(0);
                    //cuenta las maquinas funcionando
                    $this->count_maquinas_fuera(1);
                    //cuenta los laboratorios en proceso
                    $this->count_laboratorio(1);
                    // obtiene los tivekt abiertos y cerrados
                    $this->reporte_ticket("abierto_cerrado");
                    //Maquinas fuera de servicio
                    $this->data['menuPanel'] = 'Panel';
                    if (  $this->permission->checkPermission($this->session->userdata('permiso'),'vInicioEmpleado')) {
                        redirect(base_url() . 'index.php/pedido/pedidos');
                    } else {
                        $this->data['view'] = 'bingoOasis/panel';
                    }
                    
                    $this->load->view('tema/header',  $this->data);
                    //Obtiene total de usuarios

//                }

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
       $this->form_validation->set_rules('email','E-mail','valid_email|required|trim');
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

    function count_maquinas ($estado = 1){
      $estado = 1;
        $where = ' estado = '.$estado;
        $this->data['count_maquinas'] = count($this->maquinas_model->get('maquinas','idMaquina',$where));
    }

    function count_maquinas_fuera($estado = 1){
      $estado = 0;
        $where = ' estado = '.$estado;
        $this->data['count_maquinas_fuera'] = count($this->maquinas_model->get('maquinas', 'idMaquina', $where));
    }

    function count_laboratorio ($estado = 0 ){
        $where = ' estado = '.$estado;
        $this->data['count_laboratorio'] = count($this->laboratorio_model->get('articulos_laboratorio','idArticuloLaboratorio',$where));
    }
    function count_articulos (){
        $this->data['count_articulos'] = count($this->articulo_model->get('articulos', 'idArticulo'));
    }



    function reporte_ticket($ref){
        switch ($ref){
            case "abierto_cerrado":
            $hoy = date('Y-m-d', strtotime("+1 days"));
            $mes_anterior = date("Y-m-d", strtotime("-1 months"));
                $sql = "SELECT count(estado) AS 'estado','abierto' AS estado_str
                        FROM ticket WHERE f_solicitud BETWEEN '$mes_anterior' AND '$hoy' AND estado LIKE 1
                        UNION
                        SELECT count(estado) AS 'estado','cerrado' AS estado_str
                        FROM ticket WHERE  f_solicitud BETWEEN '$mes_anterior' AND '$hoy' AND estado LIKE 2";
                // var_dump($sql);
                $data = $this->ticket_model->indicador($sql);
                // var_dump($data);
                // exit;
                break;
        }
        $this->data[$ref] = $data;
    }

    function reporte_maquina($ref){
        switch ($ref){
            case "abierto_cerrado":
                $sql = 'SELECT count(estado) AS "estado","funcionando" AS estado_str
                        FROM maquinas WHERE estado LIKE 1
                        UNION
                        SELECT count(estado) AS "estado","fuera_de_servicio" AS estado_str
                        FROM maquinas estado LIKE 0';
                var_dump($sql);
                exit;
                $data = $this->maquinas_model->indicador($sql);
                break;
        }
        $this->data[$ref] = $data;
    }
}
