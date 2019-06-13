<?php

class Novedades extends CI_Controller {
    

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

        if(!$this->permission->checkPermission($this->session->userdata('permiso'),'cPermiso')){
          $this->session->set_flashdata('error','Usted no tiene permisos para configurar los permisos del sistema.');
          redirect(base_url());
        }

        $this->load->model('novedades_model', '', TRUE);
        $this->load->model('consola_model', '', TRUE);
        $this->load->model('ticket_model', '', TRUE);
        
    }
	
    function index(){
        $this->gestionar();
    }

    function gestionar(){
        
        $this->load->library('pagination');

        $config['base_url'] = base_url().'index.php/novedades/gestionar/';
        $config['total_rows'] = $this->novedades_model->count('novedades');
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

		  $this->data['results'] = $this->novedades_model->get(
                          'ticket',
                            'ticket.idNovedades,'
                          . 'ticket.f_solicitud,'
                          . 'usuario_str(ticket.solicita) as solicita,'
                          . 'ticket.prioridad,'
                          . 'usuario_str(ticket.idAsignado) as asignado ,'
                          . 'ticket.estado','',$config['per_page'],$this->uri->segment(3));
       
	    $this->data['view'] = 'ticket/ticket';
       	$this->load->view('tema/header',$this->data);
	
    }
	
    function agregar() {
        
        
        $this->load->library('form_validation');    
        $this->data['custom_error'] = ''; 
        //datos propios de la novedad
        $data = array(
            'usuario'=> $this->session->userdata('id'),
            'tipo' => $this->input->post('tipo'),
            'referencia' => $this->input->post('referencia'),
            'texto' => $this->input->post('descripcion'),
            'estado' => 1,//visible
            'f_proceso' => date('Y-m-d H:i:s')
        );
        
       
        //consola   
        if ($this->novedades_model->add('novedades',$data) == TRUE)
        {   
            
            
        }
        else
        {
            $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al agregar la novedad.</p></div>';
        }
        
        //El tipo define para quien pertenece la novedad
        switch ($this->input->post('tipo')){
            case 'T':
                //Se puede cambiar el estado y el usuario asignado
                $this->load->model('ticket_model', '', TRUE);
                $this->load->model('fallas_maquinas_model', '', TRUE);
                $this->load->model('movimiento_articulo_model', '', TRUE);
                $this->load->model('articulo_model', '', TRUE);
                $this->load->model('maquinas_model', '', TRUE);
                $this->load->model('articulos_maquinas_model', '', TRUE);
                
                $data_ticket = array(
                        "estado" => $this->input->post('estado'),
                        "idAsignado" => $this->input->post('asignado'),
                        );
                
                
                if($this->ticket_model->edit('ticket',$data_ticket,'idTicket',$this->input->post('referencia')) == TRUE){
                    $mi_maquina = $this->maquinas_model->getById($this->input->post('maquina'));
                    
                    
                    
                    //#FALLAS
                    //al cambiar el estado del ticke verificamos si existen fallas asociadas
                    $this->data['fallas_activas'] = $this->fallas_maquinas_model->get('fallas_maquinas','*','  maquina = '.$mi_maquina->nro_egm.' AND ticket = '.$this->input->post('referencia')); 
                    
                    if(count($this->data['fallas_activas'])){
                        if($this->input->post('estado')==1){//si el ticket se abre entonces se activan las fallas
                            $data_fallas_maquinas = array("estado" => 1);
                            
                        }else{//si el ticket es distinto de abierto entonces las fallas pasan a estado inactivo
                            $data_fallas_maquinas = array("estado" => 0);
                            //si el estado del ticket es distinto de 1 entonces 
                            //virifico si existen mas tickets abiertos para esta maquina, 
                            //en el caso de que no existan más tickets
                            //la maquina pasa a "activa"
                            $tickes_abiertos = $this->ticket_model->get('ticket','*',' tipo = 1 and referencia = '.$mi_maquina->idMaquina.' and estado = 1 ');
                            if (count($tickes_abiertos) == 0 or $tickes_abiertos == NULL){
                                $estado_maquina = array (
                                    "estado" =>1
                                );
                                if ($this->maquinas_model->edit('maquinas', $estado_maquina, 'idMaquina', $mi_maquina->idMaquina) == TRUE){
                                  //ok  
                                }else{
                                    die(" Error : 3#eerw3 al editar el estado de la maquina.");
                                }
                            }
                        }
                        foreach ($this->data['fallas_activas'] as $fa){//recorro las fallas activas de esa maquina y ese ticket
                            //                      edit($table,$data,$fieldID,$ID){
                            $this->fallas_maquinas_model->edit('fallas_maquinas',$data_fallas_maquinas,'idFallas_maquinas',$fa->idFallas_maquinas);
                        }
                    }
                    
                    //#RELEVAMIENTO DE PARTES (ARTICULOS)
                   $this->input->post('entra') == NULL ? $arr_entra = array():$arr_entra = $this->input->post('entra');
                   $this->input->post('sale') == NULL ? $arr_sale = array():$arr_sale = $this->input->post('sale');
                   
                   if (count($arr_entra) or count($arr_sale)){
                        $texto = '#Relevamiento de partes : <br>';
                        //Partes que ENTRAN a la maquina
                        if (count($arr_entra)){
                           $texto.=" Entra ";
                           foreach ($arr_entra as $articulo=>$cantidad){
                               //Valida si existe una cantidad
                               if ($cantidad > 0 and $cantidad!=''){
                                   $este_articulo = $this->articulo_model->getById($articulo);
                                   $texto.="[".$este_articulo->nombre." x ".$cantidad." ]";
                                   $data_mov_articulo = array(
                                       "articulo" =>$articulo,
                                       "cantidad" =>$cantidad,
                                       "fecha_hora"=>date('Y-m-d H:m:s'),
                                       "movimiento"=>'stock > M#'.$mi_maquina->nro_egm,
                                       "usuario" => $this->session->userdata('id'),
                                       "locacion" =>"M#".$mi_maquina->nro_egm   
                                   );

                                    if ($this->movimiento_articulo_model->add('movimiento_articulo',$data_mov_articulo) == TRUE){ 

                                        $this->session->set_flashdata('success','Novedades registrado con éxito!');
                                    }else{
                                        $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al agregar la parte que entra en el relevamiento.</p></div>';
                                    }
                                    //modificamos el stock del articulo que entra

                                    $nuevo_stock = $este_articulo->stock - $cantidad;
                                    $stock_articulo = array(
                                        "stock" =>$nuevo_stock
                                    );
                                    if ($this->articulo_model->edit('articulos',$stock_articulo,'idArticulo',$este_articulo->idArticulo) == TRUE){   
                                        $this->session->set_flashdata('success','Articulo modificado con éxito!');
                                    }else{
                                        $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al modificar el articulo.</p></div>';
                                    }

                                    //verificamos si existe el articulo en la maquina en la tabla articulos_maquinas
                                    $articulos_maquinas = $this->articulos_maquinas_model->get("articulos_maquinas","*"," estado = 0 AND articulo = ".$este_articulo->idArticulo." and maquina =".$mi_maquina->nro_egm);
                                    if (count($articulos_maquinas)){//si existe el articulo entonces actualiza
                                        //obtengo la cantidad y luego actualizo la nueva cantidad
                                        $nueva_cantidad = $articulos_maquinas[0]->cantidad + $cantidad;
                                        $data_art_maquina = array(
                                            "cantidad"=>$nueva_cantidad,
                                            "usuario"=>$this->session->userdata('id'),
                                            "fecha_hora"=>date("Y-m-d h:i:s")
                                        );
                                        if ($this->articulos_maquinas_model->edit("articulos_maquinas",$data_art_maquina,"idArticuloMaquina",$articulos_maquinas[0]->idArticuloMaquina)==TRUE){
                                            
                                        }else{
                                            die("Error: #434rrd# No se pudo actualizar el articulo a la maquina, ".$articulo." ".$cantidad);
                                        }
                                    }else{//si no existe el articulo lo crea
                                        $data_art_maquina = array(
                                            "articulo"=>$articulo,
                                            "maquina"=>$mi_maquina->nro_egm,
                                            "cantidad"=>$cantidad,
                                            "usuario"=>$this->session->userdata('id'),
                                            "fecha_hora"=>date("Y-m-d h:i:s")
                                        );
                                        if ($this->articulos_maquinas_model->add("articulos_maquinas",$data_art_maquina)==TRUE){
                                            
                                        }else{
                                            die("Error: #434vvd# No se pudo agregar el articulo a la maquina, ".$articulo." ".$cantidad);
                                        }
                                    }
                                   
                               }
                           }
                        }
                        
                        //Partes que SALEN de la maquina
                        if (count($arr_sale)){
                           $texto.=" Sale ";
                           foreach ($arr_sale as $sale_articulo=>$sale_cantidad){
                               
                               if ($sale_cantidad > 0 and $sale_cantidad!=''){
                                   $locacion = $this->input->post('locacion');
                                   $nueva_locacion=$locacion[$sale_articulo];
                                   //obtengo el articulo
                                   $este_articulo = $this->articulo_model->getById($sale_articulo);
                                   
                                   $texto.="[".$este_articulo->nombre." x ".$sale_cantidad." ]";
                                   
                                   $data_mov_articulo = array(
                                       "articulo" =>$sale_articulo,
                                       "cantidad" =>$sale_cantidad,
                                       "fecha_hora"=>date('Y-m-d H:i:s'),
                                       "movimiento"=>'M#'.$mi_maquina->nro_egm.' > '.$nueva_locacion,
                                       "usuario" => $this->session->userdata('id'),
                                       "locacion" => $nueva_locacion 
                                   );

                                    if ($this->movimiento_articulo_model->add('movimiento_articulo',$data_mov_articulo) == TRUE){ 
                                        //crea el registro del movimiento del articulo
                                        switch ($nueva_locacion){
                                            case "laboratorio":
                                                $this->load->model('laboratorio_model', '', TRUE);
                                                $data_laboratorio = array(
                                                    "articulo"=>$sale_articulo,
                                                    "maquina"=>$mi_maquina->idMaquina,
                                                    "cantidad"=>$sale_cantidad,
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

                                        $this->session->set_flashdata('success','Novedades registrado con éxito!');
                                    }else{
                                        $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al agregar la parte que entra en el relevamiento.</p></div>';
                                    }
                                    
                                    
                                    
                                    
                                    //sabemos que este articlo existe en la tabla articulos_maquinas porque "sale"
                                    //por lo tanto solo actualizamos la cantidad
                                    $articulos_maquinas = $this->articulos_maquinas_model->get("articulos_maquinas","*"," maquina = ".$mi_maquina->nro_egm." AND articulo = ".$este_articulo->idArticulo);
                                    if(count($articulos_maquinas)){
                                        $nueva_cantidad = $articulos_maquinas[0]->cantidad - $sale_cantidad;
                                        $data_art_maquina_2 = array(
                                            "cantidad"=>$nueva_cantidad,
                                            "usuario_salida"=>$this->session->userdata('id'),
                                            "fecha_salida"=>date("Y-m-d h:i:s"),
                                            "estado"=>1
                                        );
                                        if ($this->articulos_maquinas_model->edit("articulos_maquinas",$data_art_maquina_2,'idArticuloMaquina',$articulos_maquinas[0]->idArticuloMaquina)==TRUE){
                                            
                                        }else{
                                            die("error: #3k4j53 el id ,".$articulos_maquinas[0]->idArticuloMaquina." articulo ".$este_articulo->idArticulo." no se puede modificar");
                                        }
                                    }else{
                                        die("error: #sd2123 el articulo ".$este_articulo->idArticulo." no existe en la tabla articulos_maquina numero egm = ".$mi_maquina->nro_egm);
                                    }
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
                    
                   redirect(base_url().'index.php/ticket/visualizar/'.$this->input->post('referencia'));
                }
                else{
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al modificar el estado o el asignado del ticket!.</p></div>';
                }
                    
                break;
                
            case 'L'://LABORATORIO
                //carga el modelo del laboratorio
                $this->load->model('laboratorio_model', '', TRUE);  
                //se puede modificar datos de la reparacion    
                $data_laboratorio = array(
                        "estado" => $this->input->post('estado'),
                        "asignado" => $this->input->post('asignado'),
                        );    
                $this->laboratorio_model->edit('articulos_laboratorio',$data_laboratorio,'idArticuloLaboratorio', $this->input->post('referencia'));
                
                //relevamiento de partes dentro del labortorio
                switch ($this->input->post('locacion')){
                    case "stock":
                        
                        
                        if ($this->input->post('total')<$this->input->post('cantidad')){
                            //si la cantidad es mayor entonces hay un error
                            die("Error: #wer452 No puede pasar un cantidad mayor que la que tiene en la reparacion");
                        }elseif($this->input->post('total')==$this->input->post('cantidad')){
                            //si la cantidad es igual al total la reparacion pasa a reparado automaticamente    
                           $estado = 2; 
                        }else{
                           $estado = $this->input->post('estado');
                        }
                        //edito el articulo_laboratorio con la cantidad
                        $new_cantidad = $this->input->post('total') - $this->input->post('cantidad');
                        
                        $data_art_lab = array(
                            "cantidad"=>$new_cantidad,
                            "estado"=>$estado
                        );
                        $this->laboratorio_model->edit('articulos_laboratorio',$data_art_lab,'idArticuloLaboratorio', $this->input->post('referencia'));
                        
                        //sumo la cantidad al stock
                        $this->load->model('articulo_model', '', TRUE); 
                        $este_articulo = $this->articulo_model->getById($this->input->post('articulo'));
                        
                        $nuevo_stock = $este_articulo->stock + $this->input->post('cantidad');
                        $new_data_art = array("stock"=>$nuevo_stock);
                        if($this->articulo_model->edit('articulos',$new_data_art,'idArticulo',$this->input->post('articulo'))==TRUE){
                            //ok
                        }else{
                            die("Error: lkj#242 no se pudo sumar la cantidad al stock");
                        }
                        
                        //genero un nuevo movimiento para este arculo
                        $this->load->model('movimiento_articulo_model', '', TRUE);
                        $data_mov_articulo = array(
                                       "articulo" =>$this->input->post('articulo'),
                                       "cantidad" =>$this->input->post('cantidad'),
                                       "fecha_hora"=>date('Y-m-d H:i:s'),
                                       "movimiento"=>'laboratorio > stock',
                                       "usuario" => $this->session->userdata('id'),
                                       "locacion" =>"stock"
                                   );
                        if($this->movimiento_articulo_model->add('movimiento_articulo',$data_mov_articulo)==true){
                            //ok
                        }else{
                            die("Error: 6sfdgsd no se pudo agregar el movimiento del articulo ");
                        }
                        
                        break;
                    case "scrap":
                        
                        if ($this->input->post('total')<$this->input->post('cantidad')){
                            //si la cantidad es mayor entonces hay un error
                            die("Error: #wer452 No puede pasar un cantidad mayor que la que tiene en la reparacion");
                        }elseif($this->input->post('total')==$this->input->post('cantidad')){
                            //si la cantidad es igual al total la reparacion pasa a reparado automaticamente    
                           $estado = 2; 
                        }else{
                           $estado = $this->input->post('estado');
                        }
                        //edito el articulo_laboratorio con la cantidad
                        $new_cantidad = $this->input->post('total') - $this->input->post('cantidad');
                        
                        $data_art_lab = array(
                            "cantidad"=>$new_cantidad,
                            "estado"=>$estado
                        );
                        $this->laboratorio_model->edit('articulos_laboratorio',$data_art_lab,'idArticuloLaboratorio', $this->input->post('referencia'));
                        
                        
                        //genero un nuevo movimiento para este arculo
                        $this->load->model('movimiento_articulo_model', '', TRUE);
                        $data_mov_articulo = array(
                                       "articulo" =>$this->input->post('articulo'),
                                       "cantidad" =>$this->input->post('cantidad'),
                                       "fecha_hora"=>date('Y-m-d H:i:s'),
                                       "movimiento"=>'laboratorio > scrap',
                                       "usuario" => $this->session->userdata('id'),
                                       "locacion" =>"scrap"
                                   );
                        if($this->movimiento_articulo_model->add('movimiento_articulo',$data_mov_articulo)==true){
                            //ok
                        }else{
                            die("Error: 6sfdgsd no se pudo agregar el movimiento del articulo ");
                        }
                        
                        break;
                    case "baja":
                        
                        if ($this->input->post('total')<$this->input->post('cantidad')){
                            //si la cantidad es mayor entonces hay un error
                            die("Error: #wer452 No puede pasar un cantidad mayor que la que tiene en la reparacion");
                        }elseif($this->input->post('total')==$this->input->post('cantidad')){
                            //si la cantidad es igual al total la reparacion pasa a reparado automaticamente    
                           $estado = 2; 
                        }else{
                           $estado = $this->input->post('estado');
                        }
                        //edito el articulo_laboratorio con la cantidad
                        $new_cantidad = $this->input->post('total') - $this->input->post('cantidad');
                        
                        $data_art_lab = array(
                            "cantidad"=>$new_cantidad,
                            "estado"=>$estado
                        );
                        $this->laboratorio_model->edit('articulos_laboratorio',$data_art_lab,'idArticuloLaboratorio', $this->input->post('referencia'));
                        
                        
                        //genero un nuevo movimiento para este arculo
                        $this->load->model('movimiento_articulo_model', '', TRUE);
                        $data_mov_articulo = array(
                                       "articulo" =>$this->input->post('articulo'),
                                       "cantidad" =>$this->input->post('cantidad'),
                                       "fecha_hora"=>date('Y-m-d H:i:s'),
                                       "movimiento"=>'laboratorio > baja',
                                       "usuario" => $this->session->userdata('id'),
                                       "locacion" =>"baja"
                                   );
                        if($this->movimiento_articulo_model->add('movimiento_articulo',$data_mov_articulo)==true){
                            //ok
                        }else{
                            die("Error: 6sfdgsd no se pudo agregar el movimiento del articulo ");
                        }
                        break;
                    case "maquina":
                        
                        break;
                }        
                
                redirect(base_url().'index.php/laboratorio/visualizar/'.$this->input->post('referencia'));        
             break;
        }
        
        $this->load->view('tema/header',$this->data);
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
                
                  'vNovedades' => $this->input->post('vNovedades'),
                  'eNovedades' => $this->input->post('eNovedades'),
                  'dNovedades' => $this->input->post('dNovedades'),
                  'cNovedades' => $this->input->post('cNovedades'),
                
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

//        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){
//           $this->session->set_flashdata('error','Você não tem permissão para visualizar clientes.');
//           redirect(base_url());
//        }

        $this->data['custom_error'] = '';
        
        //Obtiene los datos del ticket
        $this->data['result'] = $this->ticket_model->get('ticket',
                    'ticket.*,'
                .   'usuario_str(ticket.idAsignado)as asignado_str,'
                .   'usuario_str(ticket.solicita)as solicita_str,'
                
                .   'permiso_str(ticket.idAsignado)as permiso_asignado,'
                .   'permiso_str(ticket.solicita)as permiso_solicita',
                'ticket.idNovedades = '.$this->uri->segment(3));
        
        //Obtiene los datos de las novedades
        $this->load->model('novedades_model', '', TRUE);
        $this->data['result_novedades'] = $this->novedades_model->get('novedades',
                    'novedades.*,'
                .   'usuario_str(novedades.usuario)as usuario_str,'
                .   'permiso_str(novedades.usuario)as permiso_str','novedades.referencia = '.$this->uri->segment(3).' AND novedades.tipo = "T"');
        
        
        $this->data['view'] = 'ticket/visualizar';
        $this->load->view('tema/header', $this->data);

        
    }
}


/* End of file permissoes.php */
/* Location: ./application/controllers/permissoes.php */

