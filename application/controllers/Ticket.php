<?php

class Ticket extends CI_Controller {
    

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

        if(!$this->permission->checkPermission($this->session->userdata('permiso'),'vTicket')){
          $this->session->set_flashdata('error','Usted no tiene permisos para ver los tickets del sistema.');
          redirect(base_url());
        }

        $this->load->model('ticket_model', '', TRUE);
        $this->load->model('consola_model', '', TRUE);
        $this->load->model('usuarios_model', '', TRUE);
        $this->load->model('maquinas_model', '', TRUE);
        $this->load->model('novedades_model', '', TRUE);
        $this->load->model('archivos_model','',TRUE);
        $this->load->model('archivos_model', '', TRUE);
    }
	
    function index(){
        $this->gestionar();
    }

    function gestionar(){
        
        $this->load->library('pagination');

        $config['base_url'] = base_url().'index.php/ticket/gestionar/';
        $config['total_rows'] = $this->ticket_model->count_activos('ticket');
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
        
        //filtros de busqueda
        $where = ' 1 = 1';
        
        if ($this->input->get('descripcion')!=''){//descripcion
             $where.= ' AND ticket.descripcion LIKE "%'.$this->input->get('descripcion').'%" ';
        }
        if ($this->input->get('referencia')!=''){//descripcion
             $where.= ' AND referencia_str(ticket.sector,ticket.referencia) LIKE "%'.$this->input->get('referencia').'%" ';
        }
        if ($this->input->get('estado')!=''){//estado
             $where.= ' AND ticket.estado = '.$this->input->get('estado');
        }else{
            $where.= ' AND ticket.estado = 1';//por defecto se trae los tickets abiertos
        }
        if ($this->input->get('emisor')!=''){//solicita
             $where.= ' AND ticket.solicita = '.$this->input->get('emisor');
        }
        if ($this->input->get('desde')!='' and $this->input->get('hasta')!=''){
            $where.=' AND date(ticket.f_solicitud) BETWEEN "'.$this->input->get('desde').'" AND "'.$this->input->get('hasta').'"';
        }else{
            if ($this->input->get('desde')!=''){//solicita
             $where.= ' AND date(ticket.f_solicitud) >= "'.$this->input->get('desde').'" ';
            }
            if ($this->input->get('hasta')!=''){//solicita
                 $where.= ' AND date(ticket.f_solicitud) <= "'.$this->input->get('hasta').'" ';
            }
        }
        
        //Obtiene los tickets
        $this->data['results'] = $this->ticket_model->get(
                'ticket',
                  'ticket.idTicket,'
                . 'ticket.f_solicitud,'
                . 'ticket.descripcion,'
                . 'usuario_str(ticket.solicita) as solicita,'
                . 'ticket.prioridad,'
                . 'ticket.sector,'
                . 'usuario_str(ticket.idAsignado) as asignado ,'
                . 'referencia_str(ticket.sector,ticket.referencia) as referencia ,'
                . 'ticket.estado',$where,$config['per_page'],$this->uri->segment(3));
//        if (count($this->data['results'])){
//            if ($this->referencia($this->data['results'][0]->idTicket)){
//                //ok
//            }
//        }
        
        //Obtiene el listado de usuarios
        $this->data['results_usuario'] = $this->usuarios_model->get(
                'usuarios','usuarios.idUsuario,usuario.nombre','',$config['per_page'],$this->uri->segment(3));
        
        $this->data['view'] = 'ticket/ticket';
       	$this->load->view('tema/header',$this->data);
	
    }
	
    function agregar() {
        
        
        $this->load->library('form_validation');    
        $this->data['custom_error'] = '';
        $idMaquina =  $this->input->post('referencia'); //el id de la maquina
        $id_ticket = 0;
        //datos propios del ticket
        $data_ticket = array(
            'solicita'=> $this->session->userdata('id'),
            'idAsignado' => '0',
            'referencia' => $this->input->post('referencia'),//guarda el id de la maquina como referencia
            'descripcion' => $this->input->post('descripcion'),
            'prioridad' => $this->input->post('prioridad'),
            'estado' => 1,//solicitado
            'f_solicitud' => date('Y-m-d H:m:s'),
            'modulo' => '',
            'submodulo' => '',
            'categoria' => '',
            'tipo' => $this->input->post('tipo'),//ticket, bug, mejora
            'f_proceso' => date('Y-m-d H:m:s'),
            'sector' => $this->input->post('sector')
        );
        
        if ($this->ticket_model->add('ticket',$data_ticket) == TRUE)
        {   
            $id_ticket = $this->db->insert_id();
                    
            $acciones = array(
                'usuario' => $this->session->userdata('id'),
                'accion_id' => 1,
                'accion' => 'Agrega el ticket: '.set_value('titulo'),
                'modulo' => 1,
                'fecha_registro' => date('Y-m-d')
            );
            if ($this->consola_model->add('consola',$acciones) == TRUE){

                $this->session->set_flashdata('success','Ticket registrado con éxito!');
                
            }
        }
        else
        {
            $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al agregar el ticket.</p></div>';

        }
        
        //por cada sector
        switch ($this->input->post('sector')){
            case 1://tecnicos
                //cargo los modelos necesarios
                $this->load->model('movimiento_articulo_model', '', TRUE);
                $this->load->model('articulo_model', '', TRUE);
                $this->load->model('articulos_maquinas_model', '', TRUE);
                $this->load->model('maquinas_model', '', TRUE);
                
                $mi_maquina = $this->maquinas_model->getById($idMaquina);
                
                //verifica si tiene fallas    
                if(count($this->input->post('fallas'))){
                    foreach ($this->input->post('fallas') as $falla){
                        //uso la fucion del model para cargar la falla a la maquina
                        $data_adicional = array(
                            'maquina'=>$mi_maquina->nro_egm,
                            'falla'=>$falla,
                            'fecha_registro'=>date('Y-m-d h:i:s'),
                            'estado'=>1,
                            'usuario'=>$this->session->userdata('id'),
                            'ticket'=>$id_ticket
                        );
        
                        $this->ticket_model->add('fallas_maquinas', $data_adicional);
                    }
                }
                
                
                //verifica si el usuario cambia el estado de la maquina a "fuera de servicio"
                $estado = $this->input->post('estado');
                if ($estado==1){
                    $data_edit_maquina = array(
                        'estado'=>0
                    );
                    if($this->maquinas_model->edit('maquinas', $data_edit_maquina, 'idMaquina',$idMaquina) == TRUE) {
                        //ok maquina editada con exito
                        //entonces generamos una evolucion acerca del cambio de estado de la maquina
                        $data_novedad = array(
                            'usuario'=> $this->session->userdata('id'),
                            'tipo' => 'T',
                            'referencia' => $id_ticket,
                            'texto' => '#Máquina fuera de servicio.',
                            'estado' => 1,//visible
                            'f_proceso' => date('Y-m-d H:i:s')
                        );
                        if ($this->novedades_model->add('novedades',$data_novedad) == TRUE){
                            //se agregó la novedad
                        }else{
                            //die('Ocurrio un error al ingresar la novedad sobre  el cambio de estado desde el ticket')
                        }
        
                    }else{
                        //die('Ocurrio un error al cambiar el estado de la maquina en el ticket')
                    }
                }
                
                //#RELEVAMIENTO DE PARTES (ARTICULOS)
                $this->input->post('entra') == NULL ? $arr_entra = array():$arr_entra = $this->input->post('entra');
                $this->input->post('sale') == NULL ? $arr_sale = array():$arr_sale = $this->input->post('sale');
                if (count($arr_entra) or count($arr_sale)){
                        $mi_maquina = $this->maquinas_model->getByEgm($mi_maquina->nro_egm);
                        $texto = '#Relevamiento de partes : <br>';
                        
                        //Partes que ENTRAN a la maquina
                        if (count($arr_entra)){
                           $texto.=" Entra ";
                           foreach ($arr_entra as $codigo_generico=>$cantidad){//cantidad siempre es 1
                                    //obtengo el primer articulo con el mismo codigo generico 
                                    $articulos = $this->articulo_model->list_articulo_generico(" having codigo = '".$codigo_generico."'");
                                    
                                    $este_articulo = $this->articulo_model->get('articulos','*',' stock = 1 AND idArticulo in ('.$articulos[0]->id.')');
            
                                    $texto.="[".$este_articulo[0]->nombre." x 1 ]";
                                    $data_mov_articulo = array(
                                       "articulo" =>$este_articulo[0]->codigo,
                                       "cantidad" =>1,
                                       "fecha_hora"=>date('Y-m-d H:m:s'),
                                       "movimiento"=>'stock > M#'.$mi_maquina->nro_egm,
                                       "usuario" => $this->session->userdata('id'),
                                       "locacion" =>"M#".$mi_maquina->nro_egm   
                                    );

                                    if ($this->movimiento_articulo_model->add('movimiento_articulo',$data_mov_articulo) == TRUE){ 

                                        //$this->session->set_flashdata('success','Novedades registrado con éxito!');
                                    }else{
                                        $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al agregar la parte que entra en el relevamiento.</p></div>';
                                    }
                                    //modificamos el stock del articulo que entra

                                    $nuevo_stock = $este_articulo[0]->stock - 1;
                                    $stock_articulo = array(
                                        "stock" =>$nuevo_stock
                                    );
                                    if ($this->articulo_model->edit('articulos',$stock_articulo,'idArticulo',$este_articulo[0]->idArticulo) == TRUE){   
                                       // $this->session->set_flashdata('success','Articulo modificado con éxito!');
                                    }else{
                                        $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al modificar el articulo.</p></div>';
                                    }
                                    
                                    //guardo en articulos_maquina el codigo del articulo y el estado
                                    $data_art_maquina = array(
                                            "articulo"=>$este_articulo[0]->codigo,
                                            "maquina"=>$mi_maquina->nro_egm,
                                            "cantidad"=>1,
                                            "estado"=>0,//activo
                                            "usuario"=>$this->session->userdata('id'),
                                            "fecha_hora"=>date("Y-m-d h:i:s")
                                        );
                                    if ($this->articulos_maquinas_model->add("articulos_maquinas",$data_art_maquina)==TRUE){
                                            
                                    }else{
                                        die("Error: #434vvd# No se pudo agregar el articulo a la maquina, articulo ".$este_articulo[0]->codigo);
                                    }
                                   
                           }
                        }
                        
                        //Partes que SALEN de la maquina
                        if (count($arr_sale)){
                           $texto.=" Sale ";
                           foreach ($arr_sale as $codigo_generico=>$sale_cantidad){
                               
                                    //obtengo el articulo
                                    $este_articulo = $this->articulos_maquinas_model->get('articulos_maquinas','*',' maquina = '.$mi_maquina->nro_egm.' and articulo like "%'.$codigo_generico.'%"');

                                    $texto.="[".$este_articulo[0]->articulo." x 1 ]";

                                    $data_mov_articulo = array(
                                        "articulo" =>$este_articulo[0]->articulo,
                                        "cantidad" =>1,
                                        "fecha_hora"=>date('Y-m-d H:i:s'),
                                        "movimiento"=>'M#'.$mi_maquina->nro_egm.' > laboratorio',
                                        "usuario" => $this->session->userdata('id'),
                                        "locacion" => "laboratorio" 
                                    );
                                    $nueva_locacion = "laboratorio";
                                    
                                    if ($this->movimiento_articulo_model->add('movimiento_articulo',$data_mov_articulo) == TRUE){ 
                                        //crea el registro del movimiento del articulo
                                        switch ($nueva_locacion){
                                            case "laboratorio":
                                                $this->load->model('laboratorio_model', '', TRUE);
                                                
                                                $data_laboratorio = array(
                                                        "articulo"=>$este_articulo[0]->articulo,
                                                        "maquina"=>$mi_maquina->nro_egm,
                                                        "cantidad"=>1,
                                                        "usuario"=>$this->session->userdata('id'),
                                                        "fecha_hora"=>date('Y-m-d H:i:s'),
                                                        "asignado"=>"",
                                                        "estado"=>1
                                                    );
                                                $this->laboratorio_model->add("articulos_laboratorio",$data_laboratorio);
                                                
                                            break;
                                            case "scrap":
                                            break;
                                            case "baja":
                                            break;
                                                
                                        }

                                    }else{
                                        $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al agregar la parte que entra en el relevamiento.</p></div>';
                                    }
                                    
                                        
                                    $data_art_maquina = array(
                                        "estado"=>1,
                                        "usuario_salida"=>$this->session->userdata('id'),
                                        "fecha_salida"=>date("Y-m-d h:i:s"),
                                    );
                                    if ($this->articulos_maquinas_model->edit("articulos_maquinas",$data_art_maquina,'articulo',$este_articulo[0]->articulo)==TRUE){

                                    }else{
                                        die("error: #3k4j53 el id ,".$articulos_maquinas[0]->idArticuloMaquina." articulo ".$este_articulo->idArticulo." no se puede modificar");
                                    }
                               
                           }
                        }
                        
                        $data = array(
                            'usuario'=> $this->session->userdata('id'),
                            'tipo' => $this->input->post('tipo'),
                            'referencia' => $this->input->post('referencia'),
                            'texto' => $texto,
                            'estado' => 1,//visible
                            'f_proceso' => date('Y-m-d H:i:s')
                        );
                        if ($this->novedades_model->add('novedades',$data) == TRUE)
                        {   
                            //mensaje ok!
                        }
                        else
                        {
                            $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al agregar la novedad del relevamiento de partes.</p></div>';
                        }
                    }
                
                    
                //AGREGAR ARCHIVOS - IMAGENES - FOTOS
                $archivo = $this->do_upload();
                if(count($archivo)>1){
                    $file = $archivo['file_name'];
                    $path = $archivo['full_path'];
                    $url = base_url().'assets/archivos/'.date('d-m-Y').'/'.$file;
                    $tamano = $archivo['file_size'];
                    $tipo = $archivo['file_ext'];

                    $data = $this->input->post('data');

                    if($data == null){
                        $data = date('Y-m-d H:i:s');
                    }
                    else{
                        $data = explode('/',$data);
                        $data = $data[2].'-'.$data[1].'-'.$data[0];
                    }
                    $data = array(
                        'documento' => $this->input->post('nombre'),
                        'descripcion' => "El usuario: ".$this->session->userdata('id')." ".$this->input->post('descripcion'),
                        'file' => $file,
                        'path' => $path,
                        'url' => $url,
                        'fecha' => $data,
                        'size' => $tamano,
                        'tipo' => $tipo,
                        'sector' => $this->input->post('sector'),
                        'referencia' => $id_ticket,
                        'funcionalidad'=>$this->input->post('funcionalidad')
                    );
            
                }
                //redirecciona hacia el sector de donde viene la referencia
                switch ($this->input->post('funcionalidad')){
            case "maquina"://maquinas
                //si se va a modificar la imagen de la maquina
                $busca = $this->archivos_model->get('documentos','idDocumentos',' funcionalidad = "maquina" and sector = 1 AND referencia ='.$this->input->post('referencia'));

                if (count($busca)){
                    foreach ($busca as $b){
                        $this->archivos_model->delete('documentos','idDocumentos',$b->idDocumentos);
                    }
                }
                $maquina = $this->maquinas_model->get('maquinas','nro_egm',' idMaquina = '.$this->input->post('referencia'));
                $redirect =base_url() . 'index.php/maquinas/visualizar?buscar='.substr($maquina[0]->nro_egm,-4); 

                break;
            case "ticket"://maquinas
                //si se va a modificar la imagen de la maquina
                $busca = $this->archivos_model->get('documentos','idDocumentos','funcionalidad = "maquina" and sector = 1 AND referencia ='.$this->input->post('referencia'));

                if (count($busca)){
                    foreach ($busca as $b){
                        $this->archivos_model->delete('documentos','idDocumentos',$b->idDocumentos);
                    }
                }
                $maquina = $this->maquinas_model->get('maquinas','nro_egm',' idMaquina = '.$this->input->post('referencia'));
                $redirect =base_url() . 'index.php/maquinas/visualizar?buscar='.substr($maquina[0]->nro_egm,-4); 

                break;
            //preparado para otros sector
        }
        
                if(count($archivo)>1){//significa que el archivo fue cargado a la ruta
                    if ($this->archivos_model->add('documentos', $data) == TRUE) {
                        $this->session->set_flashdata('success','Archivo agregado con exito!');
                    } else {
                        $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al guardar los datos del archivo en la BD.</p></div>';
                    }
                }else{
        //            $error = $archivo["error"];//retorna un string con el error del archivo
                    $this->data['custom_error'] = '<div class="form_error"><p></p></div>';//retorna un string con el error del archivo
                }    
                    redirect($redirect);   

                        redirect(base_url().'index.php/maquinas?buscar='.$this->input->post('buscar'));
                        break;
                }
        
           
        
                    
        $this->load->model('maquinas_model');
        $this->data['view'] = 'maquinas/gestionar';
        $this->load->view('tema/header',$this->data);
        redirect(base_url().'index.php/ticket/gestionar/');
   
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
                
                  'vTicket' => $this->input->post('vTicket'),
                  'eTicket' => $this->input->post('eTicket'),
                  'dTicket' => $this->input->post('dTicket'),
                  'cTicket' => $this->input->post('cTicket'),
                
                  'vManuales' => $this->input->post('vManuales')

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
    
    public function visualizar(){

//        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
//            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
//            redirect('mapos');
//        }

        if(!$this->permission->checkPermission($this->session->userdata('permiso'),'vTicket')){
           $this->session->set_flashdata('error','Usted no tiene permiso para visualizar Tickets.');
           redirect(base_url());
        }

        $this->data['custom_error'] = '';
        
        //Obtiene los datos del ticket
        $this->data['result'] = $this->ticket_model->get('ticket',
                    'ticket.*,'
                .   'usuario_str(ticket.idAsignado)as asignado_str,'
                .   'usuario_str(ticket.solicita)as solicita_str,'
                
                .   'permiso_str(ticket.idAsignado)as permiso_asignado,'
                .   'permiso_str(ticket.solicita)as permiso_solicita',
                'ticket.idTicket = '.$this->uri->segment(3));
        
        //Obtiene los datos de las novedades
        $this->load->model('novedades_model', '', TRUE);
        $this->data['result_novedades'] = $this->novedades_model->get('novedades',
                    'novedades.*,'
                .   'usuario_str(novedades.usuario)as usuario_str,'
                .   'permiso_str(novedades.usuario)as permiso_str',
                'novedades.referencia = '.$this->uri->segment(3).' AND novedades.tipo = "T"','asc');
        
        //Obtiene los usuarios
        $this->load->model('usuarios_model', '', TRUE);
        //obtiene la imagen
        
        $this->data['img'] = $this->archivos_model->get('documentos','url',' funcionalidad = "ticket" AND sector = 1 AND referencia = '.$this->data['result'][0]->idTicket);
        
        $this->data['result_usuarios'] = $this->usuarios_model->get();
        
        //Obtiene los datod de la referencia
        if ($this->referencia($this->uri->segment(3))){
            //ok
        }
//        switch ($this->data['result'][0]->sector){
//            case 1://maquinas
//                $this->load->model('maquinas_model', '', TRUE);
//                $this->load->model('fallas_maquinas_model', '', TRUE);
//                $this->load->model('articulo_model', '', TRUE);
//                $this->load->model('movimiento_articulo_model', '', TRUE);
//                $this->load->model('articulos_maquinas_model', '', TRUE);
//                //obtiene la maquina de referencia
//                $referencia = $this->maquinas_model->get('maquinas','*',' idMaquina = '.$this->data['result'][0]->referencia);
//                
//                if (count($referencia)){
//                    $div_falla = '';
//                    //Verificamos si existen fallas para esta maquina
//                    $maquinas_fallas = $this->fallas_maquinas_model->get('fallas_maquinas','*','maquina = '.$this->data['result'][0]->referencia.' AND ticket = '.$this->uri->segment(3));
//                    if (count($maquinas_fallas)){
//                        $this->load->model('fallas_model','',TRUE);
//                        foreach ($maquinas_fallas as $mf){
//                            $falla = $this->fallas_model->getById($mf->falla);
//                            $div_falla .= '<div  class="falla_'.strtolower($falla->tipo).' badge">'.$falla->descripcion.'</div>';
//                        }
//                    }
//                    $this->data['ref'] =$referencia[0]->idMaquina; 
//                    $this->data['link_referencia'] = "<a href='".base_url()."index.php/maquinas?buscar=".substr($referencia[0]->nro_egm,-4)."'>"
//                        . " <span class='icon-share-alt'></span> #Maquina: ".$referencia[0]->nro_egm." - ".$referencia[0]->fabricante." (".$referencia[0]->juego.") ".$div_falla."</a>";
//                    
//                    //Si la referencia es hacia una maquina entonces
//                    //Obtengo los articulos asociados al modelo de la maquina
//                    $this->data['articulos'] = $this->articulo_model->get('articulos','*','tipo_modelo LIKE "%'.$referencia[0]->modelo.'%" AND stock >0 ');
//                    //Obtiene el articulo que se encuantra en la maquina
//                    $this->data['articulos_maquinas'] = $this->articulos_maquinas_model->get("articulos_maquinas","articulos_maquinas.*,articulo_str(articulos_maquinas.articulo) as articulo_str"," maquina=".$referencia[0]->idMaquina." AND cantidad > 0");
//
//                }else{
//                    $this->data['link_referencia']="<i style='color:red'>El ticket no tiene referencia</i>";
//                }
//                
//                        
//                break;
//        }
        
        
        $this->data['view'] = 'ticket/visualizar';
        
        $this->load->view('tema/header', $this->data);

        
    }
    
    public function referencia($idTicket){
        
        $ticket = $this->ticket_model->get('ticket',
                    'ticket.*,',    
                'ticket.idTicket = '.$idTicket);
       
        
        switch ($ticket[0]->sector){
            case 1://maquinas
                $this->load->model('maquinas_model', '', TRUE);
                $this->load->model('fallas_maquinas_model', '', TRUE);
                $this->load->model('articulo_model', '', TRUE);
                $this->load->model('movimiento_articulo_model', '', TRUE);
                $this->load->model('articulos_maquinas_model', '', TRUE);
                //obtiene la maquina de referencia
                $referencia = $this->maquinas_model->get('maquinas','*',' idMaquina = '.$ticket[0]->referencia);
                
                if (count($referencia)){
                    $div_falla = '';
                    //Verificamos si existen fallas para esta maquina
                    $maquinas_fallas = $this->fallas_maquinas_model->get('fallas_maquinas','*','maquina = '.$referencia[0]->nro_egm.' AND ticket = '.$idTicket);
                    if (count($maquinas_fallas)){
                        $this->load->model('fallas_model','',TRUE);
                        foreach ($maquinas_fallas as $mf){
                            $falla = $this->fallas_model->getById($mf->falla);
                            $div_falla .= '<div  class="falla_'.strtolower($falla->tipo).' badge">'.$falla->descripcion.'</div>';
                        }
                    }
                    $this->data['ref'] =$referencia[0]->idMaquina; 
                    $this->data['link_referencia'] = "<a href='".base_url()."index.php/maquinas?buscar=".substr($referencia[0]->nro_egm,-4)."'>"
                        . " <span class='icon-share-alt'></span> #Maquina: ".$referencia[0]->nro_egm." - ".$referencia[0]->fabricante." (".$referencia[0]->juego.") ".$div_falla."</a>";
                    
                    //Si la referencia es hacia una maquina entonces
                    //Obtengo los articulos asociados al modelo de la maquina
                    $this->data['articulos'] = $this->articulo_model->list_articulo_generico(' having tipo_modelo LIKE "%'.$referencia[0]->modelo.'%" AND stock >0 ');
                    //Obtiene el articulo que se encuantra en la maquina
                    $this->data['articulos_maquinas'] = $this->articulos_maquinas_model->get("articulos_maquinas","articulos_maquinas.*"," maquina=".$referencia[0]->nro_egm." AND cantidad > 0 AND estado = 0 ");
                    
                    return true;
                }else{
                    $this->data['link_referencia']="<i style='color:red'>El ticket no tiene referencia</i>";
                    return false;
                }
                
                        
                break;
        }
    }
    
    public function agregar_archivo() {
     
        $archivo = $this->do_upload();
        if(count($archivo)>1){
            $file = $archivo['file_name'];
            $path = $archivo['full_path'];
            $url = base_url().'assets/archivos/'.date('d-m-Y').'/'.$file;
            $tamano = $archivo['file_size'];
            $tipo = $archivo['file_ext'];

            $data = $this->input->post('data');

            if($data == null){
                $data = date('Y-m-d H:i:s');
            }
            else{
                $data = explode('/',$data);
                $data = $data[2].'-'.$data[1].'-'.$data[0];
            }

            $data = array(
                'documento' => $this->input->post('nombre'),
                'descripcion' => "El usuario: ".$this->session->userdata('id')." ".$this->input->post('descripcion'),
                'file' => $file,
                'path' => $path,
                'url' => $url,
                'fecha' => $data,
                'size' => $tamano,
                'tipo' => $tipo,
                'sector' => $this->input->post('sector'),
                'referencia' => $this->input->post('referencia'),
                'funcionalidad'=>$this->input->post('funcionalidad')
            );
            
        }
            //redirecciona hacia el sector de donde viene la referencia
        switch ($this->input->post('funcionalidad')){
            case "maquina"://maquinas
                //si se va a modificar la imagen de la maquina
                $busca = $this->archivos_model->get('documentos','idDocumentos',' funcionalidad = "maquina" and sector = 1 AND referencia ='.$this->input->post('referencia'));

                if (count($busca)){
                    foreach ($busca as $b){
                        $this->archivos_model->delete('documentos','idDocumentos',$b->idDocumentos);
                    }
                }
                $maquina = $this->maquinas_model->get('maquinas','nro_egm',' idMaquina = '.$this->input->post('referencia'));
                $redirect =base_url() . 'index.php/maquinas/visualizar?buscar='.substr($maquina[0]->nro_egm,-4); 

                break;
            case "ticket"://maquinas
                //si se va a modificar la imagen de la maquina
                $busca = $this->archivos_model->get('documentos','idDocumentos','funcionalidad = "maquina" and sector = 1 AND referencia ='.$this->input->post('referencia'));

                if (count($busca)){
                    foreach ($busca as $b){
                        $this->archivos_model->delete('documentos','idDocumentos',$b->idDocumentos);
                    }
                }
                $maquina = $this->maquinas_model->get('maquinas','nro_egm',' idMaquina = '.$this->input->post('referencia'));
                $redirect =base_url() . 'index.php/maquinas/visualizar?buscar='.substr($maquina[0]->nro_egm,-4); 

                break;
            //preparado para otros sector
        }
        
//        die();
        if(count($archivo)>1){//significa que el archivo fue cargado a la ruta
            if ($this->archivos_model->add('documentos', $data) == TRUE) {
                $this->session->set_flashdata('success','Archivo agregado con exito!');

            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al guardar los datos del archivo en la BD.</p></div>';

            }
        }else{
//            $error = $archivo["error"];//retorna un string con el error del archivo
            $this->data['custom_error'] = '<div class="form_error"><p></p></div>';//retorna un string con el error del archivo
        }    
            redirect($redirect);  
         
           
           
              
//
//        $this->data['view'] = 'arquivos/adicionarArquivo';
//        $this->load->view('tema/topo', $this->data);

    }
    
    public function do_upload(){

//        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aArquivo')){
//          $this->session->set_flashdata('error','Você não tem permissão para adicionar arquivos.');
//          redirect(base_url());
//        }
	
    	$date = date('d-m-Y');

        $config['upload_path'] = './assets/archivos/'.$date;
        $config['allowed_types'] = 'txt|jpg|jpeg|gif|png|pdf|PDF|JPG|JPEG|GIF|PNG';
        $config['max_size']     = 0;
        $config['max_width']  = '10000';
        $config['max_height']  = '10000';
        $config['encrypt_name'] = true;

        
        if (!is_dir('./assets/archivos/'.$date)) {
            mkdir('./assets/archivos/' . $date, 0777, TRUE);
        }

        $this->load->library('upload', $config);
        
        if ( ! $this->upload->do_upload()){
            $error = array('error' => $this->upload->display_errors());
        
            $this->session->set_flashdata('error',$this->upload->display_errors());
//            redirect(base_url() . 'index.php/arquivos/adicionar/');
            return $error;
        }
        else{
                //$data = array('upload_data' => $this->upload->data());
            return $this->upload->data();
        }
    }
}


/* End of file permissoes.php */
/* Location: ./application/controllers/permissoes.php */
