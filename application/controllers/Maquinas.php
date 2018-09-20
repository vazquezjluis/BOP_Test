<?php

class Maquinas extends CI_Controller {
    

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

        if(!$this->permission->checkPermission($this->session->userdata('permiso'),'vMaquina')){
          $this->session->set_flashdata('error','Usted no tiene permisos para ver las maquinas.');
          redirect(base_url());
        }

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('maquinas_model', '', TRUE);
        $this->load->model('consola_model', '', TRUE);
        $this->load->model('fallas_model', '', TRUE);
        $this->load->model('fallas_maquinas_model', '', TRUE);
        $this->load->model('archivos_model', '', TRUE);
        $this->load->model('articulos_maquinas_model', '', TRUE);
        $this->load->model('articulo_model', '', TRUE);
        $this->data['menuConfiguraciones'] = 'Maquinas';
    }
	
    function index(){
//        $this->gestionar();
        $this->visualizar();
    }
//
//    function gestionar(){
//        
//        $buscar = $this->input->get('buscar');
//        $this->load->library('pagination');
//        if ($buscar == null){
//            
//            $config['base_url'] = base_url().'index.php/maquinas/gestionar/';
//            $config['total_rows'] = $this->maquinas_model->count('maquinas');
//            $config['per_page'] = 10;
//            $config['next_link'] = 'Próxima';
//            $config['prev_link'] = 'Anterior';
//            $config['full_tag_open'] = '<div class="pagination alternate"><ul>';
//            $config['full_tag_close'] = '</ul></div>';
//            $config['num_tag_open'] = '<li>';
//            $config['num_tag_close'] = '</li>';
//            $config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
//            $config['cur_tag_close'] = '</b></a></li>';
//            $config['prev_tag_open'] = '<li>';
//            $config['prev_tag_close'] = '</li>';
//            $config['next_tag_open'] = '<li>';
//            $config['next_tag_close'] = '</li>';
//            $config['first_link'] = 'Primera';
//            $config['last_link'] = 'Última';
//            $config['first_tag_open'] = '<li>';
//            $config['first_tag_close'] = '</li>';
//            $config['last_tag_open'] = '<li>';
//            $config['last_tag_close'] = '</li>';
//
//            $this->pagination->initialize($config); 	
//            $this->data['results']=0;
//                    
////            //obtiene los datos de las maquinas
////            $this->data['results'] = $this->maquinas_model->getMaquinas_fallas($config['per_page'],$this->uri->segment(3));
////            //obtengo los datos de las fallas para mostrarlos en el popup de los tickets
////            $this->data['results_fallas'] = $this->fallas_model->get('fallas','*', ' estado=1');
//
//        }else{
//            $this->data['results'] = $this->maquinas_model->searchMaquiinas_fallas($buscar);
//            $this->data['results_fallas'] = $this->fallas_model->get('fallas','*', ' estado=1');
//        }
//        
//	$this->data['view'] = 'maquinas/maquinas';
//            $this->load->view('tema/header',$this->data);
//    }
	
    function agregar() {

        $this->load->library('form_validation');    
        $this->data['custom_error'] = '';
                
                
        if ($this->form_validation->run('maquinas') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : false);
             
        } else
        {     
            $data = array(
                    'nro_egm' => set_value('nro_egm'),
                    'fabricante' => set_value('fabricante'),
                    'modelo' => set_value('modelo'),
                    'p_pago' => set_value('p_pago'),
                    'denom' => set_value('denom'),
                    'juego' => set_value('juego'),
                    'nro_serie' => set_value('nro_serie'),
                    'programa' => set_value('programa'),
                    'credito' => set_value('credito'),
                    'estado' => 1
                    
            );
           
                    if ($this->maquinas_model->add('maquinas',$data) == TRUE)
                    {   
                            $acciones = array(
                                'usuario' => $this->session->userdata('id'),
                                'accion_id' => 1,
                                'accion' => 'Agrega la maquina: '.set_value('nro_egm').'-_-'.set_value('fabricante').'-_-'.set_value('modelo').'-_-'.set_value('juego'),
                                'modulo' => 1,
                                'fecha_registro' => date('Y-m-d')
                            );
                            if ($this->consola_model->add('consola',$acciones) == TRUE){
                                
                                $this->session->set_flashdata('success','Maquina registrada con éxito!');
                                redirect(base_url().'index.php/maquinas/agregar/');
                            }
                    }
                    else
                    {
                            $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al agregar la maquina.</p></div>';

                    }
            }
        
        $this->load->model('maquinas_model');
//        $this->data['maquinas'] = $this->maquinas_model->getActive('maquinas','maquinas.idmaquina,maquinas.nombre');   
        $this->data['view'] = 'maquinas/agregarMaquina';
        $this->load->view('tema/header',$this->data);
   
    }
    
    function agregarFalla() {
        $data = array(
            'maquina'=>$_GET['maquina'],
            'falla'=>$_GET['id'],
            'fecha_registro'=>date('Y-m-d h:i:s'),
            'estado'=>1,
            'usuario'=>$this->session->userdata('id')
        );
        
        if ($this->maquinas_model->add('fallas_maquinas', $data) == TRUE) {
            $acciones = array(
                'usuario' => $this->session->userdata('id'),
                'accion_id' => 1,
                'accion' => 'Agrega el Falla : '.$_GET['id'],
                'modulo' => 2,
                'fecha_registro' => date('Y-m-d h:i:s')
            );

            if ($this->consola_model->add('consola',$acciones) == TRUE){
                return true;
            }
        } else {
            return false;
            
        }
        

    }

    function editar() {

        
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

//        $this->form_validation->set_rules('nombre', 'nombre', 'trim|required');
        
        if ($this->form_validation->run('maquinas') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            
            
            $nro_egm = $this->input->post('nro_egm');
            $fabricante = $this->input->post('fabricante');
            $modelo = $this->input->post('modelo');
            $p_pago = $this->input->post('p_pago');
            $denom = $this->input->post('denom');
            $juego= $this->input->post('juego');
            $nro_serie= $this->input->post('nro_serie');
            $programa= $this->input->post('programa');
            $credito= $this->input->post('credito');
            $estado = $this->input->post('estado');
            
            $ap_minima = $this->input->post('ap_minima');
            $ap_maxima = $this->input->post('ap_maxima');
            $cant_lineas = $this->input->post('cant_lineas');
            $tipo = $this->input->post('tipo_juego');

            $data = array(
                'nro_egm' => $nro_egm,
                'fabricante' => $fabricante,
                'modelo' => $modelo,
                'p_pago' => $p_pago,
                'denom' => $denom,
                'juego' => $juego,
                'nro_serie' => $nro_serie,
                'programa' => $programa,
                'credito' => $credito,
                'estado' => $estado,
                'ap_minima' => $ap_minima,
                'ap_maxima' => $ap_maxima,
                'cant_lineas' => $cant_lineas,
                'tipo_juego' => $tipo
            );
            
            if ($this->maquinas_model->edit('maquinas', $data, 'idMaquina', $this->input->post('idMaquina')) == TRUE) {
                $acciones = array(
                        'usuario' => $this->session->userdata('id'),
                        'accion_id' => 2,
                        'accion' => 'Edita la maquina '.$this->input->post('idMaquina').': '.$nro_egm.' - '.$fabricante,
                        'modulo' => 2,
                        'fecha_registro' => date('Y-m-d h:i:s')
                    );
                if ($this->consola_model->add('consola',$acciones) == TRUE){
                    $this->session->set_flashdata('success', 'Máquina editada con éxito!');
                    redirect(base_url() . 'index.php/maquinas/editar/'.$this->input->post('idMaquina'));
                }
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al editar la maquina.</p></div>';
            }
        }

        $this->data['result'] = $this->maquinas_model->getById($this->uri->segment(3));
        $this->data['view'] = 'maquinas/editarMaquina';
        $this->load->view('tema/header', $this->data);

    }
	
    function eliminar(){
        
        $id =  $this->input->post('id');
        
        if ($id == null){
            $this->session->set_flashdata('error','Ocurrio un error al intentar eliminar la máquina.');            
            redirect(base_url().'index.php/maquinas/gestionar/');
        }
        $data = array(
          'estado' => '90'
        );
        if($this->maquinas_model->edit('maquinas',$data,'idMaquina',$id)){
          $this->session->set_flashdata('success','Maquina eliminada con exito!');  
        }
        else{
          $this->session->set_flashdata('error','Error al desactivar el permiso!');  
        }         
        redirect(base_url().'index.php/maquinas/gestionar/');
    }
    
    function quitarFalla(){
        
        $falla =  $_GET['falla'];
        $maquina =  $_GET['maquina'];
        $data = array(
          'estado' => 0
        );
        if($this->maquinas_model->edit('fallas_maquinas',$data,'falla ='.$falla.' AND maquina ='.$maquina)){
            //          $this->session->set_flashdata('success','Falla quitada con exito!');  
        }
        else{
          $this->session->set_flashdata('error','Error al quitar la falla!');  
        }         
        
        //        redirect(base_url().'index.php/permisos/gestionar/');
    }
    function habilitar(){
        $estado = $_GET['habilitado'];
        $maquina = $_GET['maquina'];
        $data = array(
          'estado' => $estado
        );
        if($this->maquinas_model->edit('maquinas',$data,'idMaquina ='.$maquina)){
        //          $this->session->set_flashdata('success','Falla quitada con exito!');  
        }
        else{
          $this->session->set_flashdata('error','Error al quitar la falla!');  
        }         
        
    }
    
    function visualizar(){
        //Para detectar el dispositivo y la version
        $this->load->library('user_agent');
        
        
        if($this->agent->is_mobile()){
            $this->data['movil'] =true;
        }else{
            $this->data['movil'] =false;
        }
        
        if(!$this->input->get('buscar') || !is_numeric($this->input->get('buscar'))){
            
        }else{
            
        

//        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){
//           $this->session->set_flashdata('error','Você não tem permissão para visualizar clientes.');
//           redirect(base_url());
//        }

            $this->data['custom_error'] = '';
            
            $this->data['result'] = $this->maquinas_model->getMaquinas_fallas(0,0,false,'array','  nro_egm = 240'.$this->input->get('buscar'));
            
            if (count($this->data['result'])){
                //obtiene la imagen de la maquina
                $this->data['url_img'] = $this->archivos_model->get('documentos','url',' funcionalidad = "maquina" AND sector = 1 AND referencia = '.$this->data['result'][0]->idMaquina);
                //obteingo las fallas de tickets en estado abierto (1)
                //$this->data['maquinas_fallas'] = $this->fallas_model->getMaquinas_fallas(0,0,false,'array',' AND idMaquina = '.$this->uri->segment(3));
                $this->data['fallas_maquina'] = $this->fallas_maquinas_model->get('fallas_maquinas','idFallas_maquinas,ticket,falla,fallas_str(falla) as descripcion, usuario_str(usuario) as usuario,fecha_registro',' estado = 1 AND  maquina = '.$this->data['result'][0]->nro_egm);
                $this->data['historial_fallas'] = $this->fallas_maquinas_model->get('fallas_maquinas','idFallas_maquinas,ticket,fallas_str(falla) as descripcion, usuario_str(usuario) as usuario,fecha_registro',' estado = 0 AND  maquina = '.$this->data['result'][0]->nro_egm);
                $this->data['articulos_maquinas'] = $this->articulos_maquinas_model->get('articulos_maquinas','articulos_maquinas.*, articulo_str(articulo) as articulo_str',' estado = 0 AND maquina = '.$this->data['result'][0]->nro_egm);
                $this->data['historial_partes'] = $this->articulos_maquinas_model->get('articulos_maquinas','articulos_maquinas.*, articulo_str(articulo) as articulo_str, usuario_str(usuario_salida) as usuario_salida',' estado = 1 AND maquina = '.$this->data['result'][0]->nro_egm);
                
                //Si la referencia es hacia una maquina entonces
                //Obtengo los articulos asociados al modelo de la maquina
                $this->data['articulos'] = $this->articulo_model->list_articulo_generico(' having tipo_modelo LIKE "%'.$this->data['result'][0]->modelo.'%" AND stock >0 ');
                //Obtiene el articulo que se encuantra en la maquina
//                $this->data['articulos_maquinas'] = $this->articulos_maquinas_model->get("articulos_maquinas","articulos_maquinas.*,articulo_str(articulos_maquinas.articulo) as articulo_str"," maquina=".$this->data['result'][0]->nro_egm." AND cantidad > 0");
            }
            else{
                $this->data['custom_error'] = 'El UID <strong>240'.$this->input->get('buscar').' </strong>no existe en la base de datos.';
                $this->data['result'] = null;
            }
            

            
            
        }
        
        //obtengo los datos de las fallas para mostrarlos en el popup de los tickets
        $this->data['results_fallas'] = $this->fallas_model->get('fallas','*', ' estado=1');
        
        $this->data['view'] = 'maquinas/visualizar';
        $this->load->view('tema/header', $this->data);
    }
    
    
}


/* End of file permissoes.php */
/* Location: ./application/controllers/permissoes.php */
