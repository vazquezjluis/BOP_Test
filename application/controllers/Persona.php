<?php

class Persona extends CI_Controller {
    

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
//
//        if(!$this->permission->checkPermission($this->session->userdata('permiso'),'cPermiso')){
//          $this->session->set_flashdata('error','Usted no tiene permisos para configurar el inventario del sistema.');
//          redirect(base_url());
//        }

        $this->load->model('persona_model', '', TRUE);
        $this->load->model('archivos_model', '', TRUE);
        $this->load->model('capacitacion_model', '', TRUE);
        $this->load->model('licencia_model', '', TRUE);
        $this->load->model('premio_model', '', TRUE);
        $this->load->model('lenox_model', '', TRUE);
    }
	
    function index(){
        $this->visualizar();
    }

    function gestionar(){
        
        $this->load->library('pagination');

        $config['base_url'] = base_url().'index.php/persona/gestionar/';
        $config['total_rows'] = $this->persona_model->count('persona');
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
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config); 	

        //$this->data['results'] = $this->articulo_model->get('articulos','*',' estado !=90',$this->input->get('per_page'),$config['per_page']);
        //$config['per_page'],$this->input->get('per_page'),$where
        $this->data['results'] = $this->persona_model->list_persona($config['per_page'],$this->input->get('per_page'),'');//'*',' estado !=90',$this->input->get('per_page'),$config['per_page']);
                  
        $this->data['view'] = 'rrhh/persona/persona';
       	$this->load->view('tema/header',$this->data);

    }
	
    function agregar() {

        if(!$this->permission->checkPermission($this->session->userdata('permiso'),'cArticulos')){
           $this->session->set_flashdata('error','Usted no tiene permisos para agregar articulos.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('articulos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $precioCompra = $this->input->post('precioCompra');
            $precioCompra = str_replace(",","", $precioCompra);
            $precioVenta = $this->input->post('precioVenta');
            $precioVenta = str_replace(",", "", $precioVenta);
            if (count($this->input->post('tipoModelo'))){
                $modelos = implode("-_-", $this->input->post('tipoModelo'));
            }else{
                $modelos='';
            }
            
            $data = array(
                'nombre' => set_value('nombre'),
                'descripcion' => set_value('descripcion'),
                'categoria' => set_value('categoria'),
                'precioCompra' => $precioCompra,
                'precioVenta' => $precioVenta,
                'stock' => set_value('stock'),
                'stockMinimo' => set_value('stockMinimo'),
                'salida' => set_value('salida'),
                'entrada' => set_value('entrada'),
                'tipo_modelo' => $modelos,
            );
            
            //agrega el articulo
            if ($this->articulo_model->add('articulos', $data) == TRUE) {
                ///agrear el movimiento incinial del articulo
                $data_movimiento = array(
                    "articulo"=>$this->db->insert_id(),
                    "cantidad"=> set_value('stock'),
                    "fecha_hora"=>date('Y-m-d h:m:s'),
                    "movimiento"=>'#ingreso al sistema',
                    "usuario"=>$this->session->userdata('id'),
                    "locacion"=>'stock',
                    
                );
                if ($this->movimiento_articulo_model->add('movimiento_articulo', $data_movimiento) == TRUE){}
                $this->session->set_flashdata('success','Articulo agregado con exito!');
                redirect(base_url() . 'index.php/articulo/agregar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Error #MN1233 al agregar el articulo.</p></div>';
            }
        }
        $this->data['modelos'] = $this->maquinas_model->get_modelos();
        $this->data['view'] = 'inventario/articulos/agregarArticulo';
        $this->load->view('tema/header',$this->data);

    }

    function editar() {
        

        if(!$this->permission->checkPermission($this->session->userdata('permiso'),'eArticulos')){
           $this->session->set_flashdata('error','Usted no tiene permisos para editar el articulo.');
           redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('articulos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $precioCompra = $this->input->post('precioCompra');
            $precioCompra = str_replace(",","", $precioCompra);
            $precioVenta = $this->input->post('precioVenta');
            $precioVenta = str_replace(",", "", $precioVenta);
            if (count($this->input->post('tipoModelo'))){
                $modelos = implode("-_-", $this->input->post('tipoModelo'));
            }else{
                $modelos='';
            }
            $data = array(
                'nombre' => $this->input->post('nombre'),
                'descripcion' => $this->input->post('descripcion'),
                'categoria' => $this->input->post('categoria'),
                'precioCompra' => $precioCompra,
                'precioVenta' => $precioVenta,
                'stock' => $this->input->post('stock'),
                'stockMinimo' => $this->input->post('stockMinimo'),
                'salida' => set_value('salida'),
                'entrada' => set_value('entrada'),  
                'tipo_modelo' => $modelos
            );
            //antes de modificar obtengo el articulo para saber cuantas unidades habie previamente
            $este_articulo = $this->articulo_model->getById($this->input->post('idArticulo'));
            $stock_previo  = $este_articulo->stock;
            $diferencia = 0;
            $movimiento = '';
            if ($stock_previo!= $this->input->post('stock')){
                if($stock_previo > $this->input->post('stock')){
                    //quita unidades del stock
                    $diferencia = $stock_previo - $this->input->post('stock');
                    $movimiento = '#Quita unidades';
                }else{
                    //agregar unidades al stock
                    $diferencia = $this->input->post('stock') - $stock_previo  ;
                    $movimiento = '#Agrega unidades';
                }
            };
            if ($this->articulo_model->edit('articulos', $data, 'idArticulo', $this->input->post('idArticulo')) == TRUE) {
                $data_movimiento = array(
                    "articulo"=>$this->input->post('idArticulo'),
                    "cantidad"=> $diferencia,
                    "fecha_hora"=>date('Y-m-d h:m:s'),
                    "movimiento"=>$movimiento,
                    "usuario"=>$this->session->userdata('id'),
                    "locacion"=>'stock',
                    
                );
                if ($diferencia!=0){
                    $this->movimiento_articulo_model->add('movimiento_articulo', $data_movimiento);
                    $this->session->set_flashdata('success','Articulo editado con exito!');
                    
                }
                redirect(base_url() . 'index.php/articulo/editar/'.$this->input->post('idArticulo'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al editar el articulo</p></div>';
            }
        }

        $this->data['result'] = $this->articulo_model->getById($this->uri->segment(3));
        $this->data['modelos'] = $this->maquinas_model->get_modelos();
        $this->data['view'] = 'inventario/articulos/editarArticulo';
        $this->load->view('tema/header', $this->data);
        

    }
	
    function desactivar(){
        
        $id =  $this->input->post('id');
        if ($id == null){
            $this->session->set_flashdata('error','Ocurrio un error al intentar eliminar el articulo.');            
            redirect(base_url().'index.php/permisos/gestionar/');
        }
        $data = array(
          'estado' => 90
        );
        if($this->articulo_model->edit('articulos',$data,'idArticulo',$id)){
          $this->session->set_flashdata('success','Articulo eliminado con exito!');  
        }
        else{
          $this->session->set_flashdata('error','Error al eliminar el articulo!');  
        }         
        
                  
        redirect(base_url().'index.php/articulo/gestionar/');
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
            
            $this->data['result'] = $this->persona_model->get('persona','*','id = '.$this->input->get('buscar'));
            
            if (count($this->data['result'])){
                //obtiene la imagen del empleado
                $this->data['url_img'] = $this->archivos_model->get('documentos','url',' funcionalidad = "persona" AND sector = 2 AND referencia = '.$this->data['result'][0]->id);
                //obtengo las capacitaciones del empleado
                $this->data['capacitacion'] = $this->capacitacion_model->getPersonaCapacitacion(0,0,' capacitacion_persona.idPersona = '.$this->data['result'][0]->id);
                $this->data['licencia'] = $this->licencia_model->getPersonaLicencia(' licencia_persona.idPersona = '.$this->data['result'][0]->id);
                $this->data['premio'] = $this->premio_model->getPremioPersona('premio_persona.estado = 1 AND premio_persona.idPersona = '.$this->data['result'][0]->id);
                
            }
            else{
                $this->data['custom_error'] = 'Error al obtener los datos del empleado.';
                $this->data['result'] = null;
            }
        }
        
        //$this->data['lenox_persona'] = $this->lenox_model->get_all();
        //echo "<pre>";
        //var_dump($this->data['lenox_persona']);
        //echo "</pre>";
        $this->data['view'] = 'rrhh/persona/visualizar';
        $this->load->view('tema/header', $this->data);
    }
}


/* End of file permissoes.php */
/* Location: ./application/controllers/permissoes.php */
