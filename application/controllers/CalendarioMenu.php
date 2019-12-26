<?php

class CalendarioMenu extends CI_Controller {
    

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

//        if(!$this->permission->checkPermission($this->session->userdata('permiso'),'vPremios')){
//          $this->session->set_flashdata('error','Usted no tiene permisos para configurar los premios del sistema.');
//          redirect(base_url());
//        }

        
        $this->load->model('menuPersonal_model', '', TRUE);
        $this->load->model('consola_model', '', TRUE);
        $this->load->model('calendarioMenu_model', '', TRUE);
        $this->load->model('pedido_model', '', TRUE);
        $this->load->model('valormenu_model', '', TRUE);
    }
	
    function index(){
        //$this->gestionar();
    }
    
    
    
    
    
    function gestionar(){
        
        $this->load->library('pagination');

        $config['base_url'] = base_url().'index.php/estudio/gestionar/';
        $config['total_rows'] = $this->estudio_model->count('estudio');
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

        $this->data['results'] = $this->estudio_model->get('estudio','estudio.*, institucion_str(estudio.institucion) as institucion',' estudio.estado = 1',$config['per_page'],$this->uri->segment(3));
       
	$this->data['view'] = 'rrhh/estudio/estudio';
       	$this->load->view('tema/header',$this->data);
	
    }
    
    public function visualizar(){

//        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
//            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
//            redirect('mapos');
//        }

//        if(!$this->permission->checkPermission($this->session->userdata('permiso'),'vTicket')){
//           $this->session->set_flashdata('error','Usted no tiene permiso para visualizar Tickets.');
//           redirect(base_url());
//        }

        $this->data['custom_error'] = '';
        
        //Obtiene los datos del ticket
        $this->data['result'] = $this->seleccion_personal_model->get('seleccion_personal','*',
                'seleccion_personal.idSeleccion_personal= '.$this->uri->segment(3));
        
        //documentos
        $this->data['cv'] = $this->archivos_model->get('documentos','url',' funcionalidad = "seleccion_personal" AND sector = 2 AND documento="CV" AND estado = "1" AND referencia = '.$this->data['result'][0]->idSeleccion_personal);
       
        $this->data['psicotecnico'] = $this->archivos_model->get('documentos','url',' funcionalidad = "seleccion_personal" AND sector = 2 AND estado = "1" AND documento="psicotecnico" AND referencia = '.$this->data['result'][0]->idSeleccion_personal);
        $this->data['ambiental'] = $this->archivos_model->get('documentos','url',' funcionalidad = "seleccion_personal" AND sector = 2 AND estado = "1" AND documento="ambiental" AND referencia = '.$this->data['result'][0]->idSeleccion_personal);
        $this->data['policial'] = $this->archivos_model->get('documentos','url',' funcionalidad = "seleccion_personal" AND sector = 2 AND estado = "1" AND documento="policial" AND referencia = '.$this->data['result'][0]->idSeleccion_personal);
        
        $this->data['view'] = 'rrhh/seleccion_personal/candidato';
        $this->load->view('tema/header', $this->data);

        
    }
	
    function agregar() {
        $idMenu = $this->input->post('idMenu');
        $legajo = $this->input->post('legajo');
        
        if(isset($idMenu) and isset($legajo)){
            $data = array(
                'legajo'        => $this->input->post('legajo'),
                'persona_str'   => $this->input->post('persona_str'),
                'title'         => $this->input->post('title'),
                'descripcion'   => $this->input->post('descripcion'),
                'start'         => $this->input->post('start'),
                'color'         => $this->input->post('color'),
                'textColor'     => $this->input->post('textColor'),
                'end'           => $this->input->post('end'),
                'idMenu'        => $this->input->post('idMenu'),
                'idMenuBingo'   => $this->input->post('idMenuBingo'),
                'estado'        => 1,
                'f_registro'    => date('Y-m-d h:i:s')
            );
            if ($this->calendarioMenu_model->add('calendarioMenu', $data) == TRUE) {
                //$id_estudio = $this->db->insert_id();
                //$this->data['custom_success'] = 'calendario menu cargado!';
                echo json_encode($data);
            } else {
                //$this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error.</p></div>';
            }
            
        }
    }

    function editar() {

        
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        if ($this->form_validation->run('estudio') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            
            $data = array(                    
                'titulo' => $this->input->post('titulo'),
                'tipo' => $this->input->post('tipo'),
                'institucion' => $this->input->post('institucion'),
                'estado'=>1,
                'fecha'=>$this->input->post('fecha')
            );

            if ($this->estudio_model->edit('estudio', $data, 'idEstudio', $this->input->post('idEstudio')) == TRUE) {
                $acciones = array(
                        'usuario' => $this->session->userdata('id'),
                        'accion_id' => 2,
                        'accion' => 'Edita al estudio '.$this->input->post('idEstudio'),
                        'modulo' => 2,
                        'fecha_registro' => date('Y-m-d h:i:s')
                    );
                if ($this->consola_model->add('consola',$acciones) == TRUE){
                    $this->session->set_flashdata('success', 'Estudio editado con éxito!');
//                    redirect(base_url() . 'index.php/permisos/editar/'.$this->input->post('idPermiso'));
                }
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error.</p></div>';
            }
        }

        $this->data['institucion'] = $this->institucion_model->getActive('institucion','*');
        $this->data['result'] = $this->estudio_model->getById($this->uri->segment(3));
        
        $this->data['view'] = 'rrhh/estudio/editarEstudio';
        $this->load->view('tema/header', $this->data);

    }
	
    function eliminar(){
        
        $id =  $this->input->post('idCalendarioMenu');
        if ($id == null){
            
        }else{
            $data = array(
                'estado'        => 0,
                'descripcion'   => $this->input->post('descripcion')
            );
            if($this->calendarioMenu_model->edit('calendarioMenu',$data,'idCalendarioMenu',$id)){
                echo json_encode($data);
            }
        }
    }
    
    
    function pedir(){
        $idMenuBingo = '';
        $idMenu = '';
        if(isset($_POST['idMenu'])){
            $idMenu = $this->input->post('idMenu');
        }
        if(isset($_POST['idMenuBingo'])){
            $idMenuBingo = $this->input->post('idMenuBingo');
        }
        
        
        $legajo = $this->input->post('legajo');
        $id     = $this->input->post('idCalendarioMenu');
        //Obtengo el valor actual del menu que el empleado esta pidiendo
        $valor_menu= $this->valormenu_model->get('valormenu','importe_interno,importe_externo','valormenu.estado!=0');
        $valor_menu_interno = $this->menuPersonal_model->getById($idMenu);
        if(!isset($valor_menu_interno) ){
            $vmi = 0;
        }else{
            $vmi = $valor_menu_interno->valor;
        }
        if((!isset($idMenu) or $idMenu==NULL) and 
                (!isset($idMenuBingo) or $idMenuBingo==NULL)){
            // si no retorna nada entonces existe un error
            
        } else{
            //Verifica si exite un regitro en el calendario, porque puede dar el caso que el empleado pida directamente
            // sin haber echo una programacion el menu, tratandoce del dia actual
            if (isset($id) and $id !=null){
                //Verifico si existen menus pendientes en estado 1 con fecha actual y el legajos del empleado 
                $this->data["pendiente"] = $this->pedido_model->get("pedido",
                        "pedido.*,persona_str(pedido.persona) as persona, menu_str(pedido.idMenu) as menu",
                        " pedido.f_registro = '".date('Y-m-d')."' and pedido.legajo = ".$this->input->post("legajo"));

                // Si no hay pedidos pendientes  y existe un menu
                if (count($this->data['pendiente'])==0){  
                    
                    
                    // si existe el legajo y el id de menu entonces 
                    
                    if( (isset($idMenu)or isset($idMenuBingo)) and isset($legajo) and count($valor_menu)){
                        
                        
                        $data = array(
                            'legajo'            => $this->input->post('legajo'),
                            'persona'           => $this->input->post('idPersona'),
                            'persona_str'       => $this->input->post('persona_str'),
                            'descripcion'       => '',
                            'idMenu'            => $idMenu,
                            'idMenuBingo'       => $idMenuBingo,
                            'usuario'           => $this->session->userdata('id'),
                            'importe_externo'   => $valor_menu[0]->importe_externo,
                            'importe_interno'   => $vmi,
                            'estado'            =>1,
                            'f_registro'        => date('Y-m-d h:i:s'),
                            'idCalendarioMenu'  => $id
                        );
                        //creacion
                        if ($this->pedido_model->add('pedido', $data) == TRUE) {
                            $data = array('color' => '#da4f49');
                            if($this->calendarioMenu_model->edit('calendarioMenu',$data,'idCalendarioMenu',$id)){
                                echo json_encode($data);
                            }
                        }
                    }
                }


            }
            else{
                
                if(count($valor_menu)){
                    $title = '';
                    $Atitle = $this->menuPersonal_model->getMenuManual(" 1 = 1 AND "
                            . " idMenuPersonal = ".$idMenu);
                    $Btitle = $this->menuPersonal_model->getMenuManual(" 1 = 1 AND "
                            . " idMenuPersonal = ".$idMenuBingo);
                    echo "<pre>";
                    var_dump($Atitle);
                    var_dump($Btitle);
                    echo "</pre>";
                    if(isset($Atitle) and count($Atitle)){
                        $title.=$Atitle[0]->descripcion;
                    }
                    if(isset($Btitle) and count($Btitle)){
                        $title.=" ".$Btitle[0]->descripcion;
                    }
                    //Primero y ante todo guardo el registro en el calendario, direcatemnte con el color rojo
                    $data = array(
                        'legajo'        => $legajo,
                        'persona_str'   => $this->input->post('persona_str'),
                        'title'         => $title,
                        'descripcion'   => $this->input->post('descripcion'),
                        'start'         => $this->input->post('start'),
                        'color'         => '#da4f49',
                        'textColor'     => $this->input->post('textColor'),
                        'end'           => $this->input->post('end'),
                        'idMenu'        => $idMenu,
                        'idMenuBingo'   => $idMenuBingo,
                        'estado'        => 1,
                        'f_registro'    => date('Y-m-d h:i:s')
                    );
                    if ($this->calendarioMenu_model->add('calendarioMenu', $data) == TRUE) {
                        $id = $this->db->insert_id(); // Este es el ID del CalendarioMenu
                        //Luego se crea el pedido en estado 1 pendiente

                        $data_pedido = array(
                                'legajo'            => $legajo,
                                'persona'           => $this->input->post('idPersona'),
                                'persona_str'       => $this->input->post('persona_str'),
                                'descripcion'       => '',
                                'idMenu'            => $idMenu,
                                'idMenuBingo'       => $idMenuBingo,
                                'usuario'           => $this->session->userdata('id'),
                                'estado'            => 1,
                                'f_registro'        => date('Y-m-d h:i:s'),
                                'importe_externo'   => $valor_menu[0]->importe_externo,
                                'importe_interno'   => $vmi,
                                'idCalendarioMenu'  => $id
                            );
                        if ($this->pedido_model->add('pedido', $data_pedido) == TRUE) {
                                // retorna la data del calendario , No la del pedido
                                echo json_encode($data);

                            }
                    } 
                }
        }
    
        }
    }//fin de la funcion
    
    function modificar(){
        
        $idMenu = $this->input->post('idMenu');
        $legajo = $this->input->post('legajo');        
        $id =  $this->input->post('idCalendarioMenu');
        
        if ($id != null and isset($id) and isset($idMenu) and isset($legajo)){
            $data = array(
                'legajo'        => $legajo,
                'persona_str'   => $this->input->post('persona_str'),
                'title'         => $this->input->post('title'),
                'descripcion'   => $this->input->post('descripcion'),
                'start'         => $this->input->post('start'),
                'color'         => $this->input->post('color'),
                'textColor'     => $this->input->post('textColor'),
                'end'           => $this->input->post('end'),
                'idMenu'        => $idMenu,
                'idMenuBingo'   => $this->input->post('idMenuBingo'),
                'f_registro'    => date('Y-m-d h:i:s')
            );
            if($this->calendarioMenu_model->edit('calendarioMenu',$data,'idCalendarioMenu',$id)){
                echo json_encode($data);
            }
        }
    }
    
    function buscarEvento(){
        /* Obtengo el calendario de menu de la persona con su legajo */
        $calendarioMenu = $this->calendarioMenu_model->get_calendario (" legajo = ".$this->input->get('legajo')." AND estado = 1  AND start = '".$this->input->get('fecha')." 00:00:00'");
        
        if(count($calendarioMenu)){
            echo json_encode($calendarioMenu);
        }else{ echo '0';}
        
    }
    
     function buscaPedidoRealizado(){
        
        /* Obtengo el calendario de menu de la persona con su legajo */
        $calendarioMenu = $this->calendarioMenu_model->get_calendario (" legajo = ".$this->input->get('legajo')."   AND start = '".$this->input->get('fecha')." 00:00:00'");
        //var_dump($calendarioMenu);
        if(count($calendarioMenu)){
            /* Obtengo el calendario de menu de la persona con su legajo */
            $pendiente  = $this->pedido_model->get('pedido','pedido.*, menu_str(pedido.idMenu) as menu',' idCalendarioMenu = '.$calendarioMenu[0]->idCalendarioMenu.' AND legajo = '.$this->input->get('legajo'));
            
            if(count($pendiente)){
                $data = array(
                    'descripcion'   => $pendiente[0]->menu,
                    'estadoStr'     => $this->pedido_model->estado_str($pendiente[0]->estado),
                );

                echo json_encode($data);
            }
        }
    }
    
    function vincular(){
        
        //
        
        
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';	
        if ($this->form_validation->run('vincular_estudio') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : false);
        } 
        else
        {    
            //datos
            $data_estudio_persona = array(
                'idEstudio' => $this->input->post('estudio'),
                'idPersona' => $this->input->post('persona_id'),
                'descripcion' => $this->input->post('descripcion'),
                'fecha_registro' => date('Y-m-d'),
                'usuario' => $this->session->userdata('id')
            );
            
            if ($this->estudio_model->add('estudio_persona',$data_estudio_persona) == TRUE)
                {   
                    $id_estudio_persona = $this->db->insert_id();
                    $acciones = array(
                        'usuario' => $this->session->userdata('id'),
                        'accion_id' => 1,
                        'accion' => 'Vincula el estudio: '.$this->input->post('idEstudio').' con la persona '.$this->input->post('persona_id'),
                        'modulo' => 2,
                        'fecha_registro' => date('Y-m-d')
                    );
                    if ($this->consola_model->add('consola',$acciones) == TRUE){        
                        $this->session->set_flashdata('success','estudio vinculado con éxito!');
                        //redirect(base_url().'index.php/licencia/vincular');
                    }
                    if ($this->input->post('desde_persona')!==NULL){
                        redirect(base_url().'index.php/persona/visualizar?buscar='.$this->input->post('persona_id'));
                    }
                        
                }
            else
            {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al guardar la consola del vinculo de la licencia.</p></div>';
            }
            
        }
        
        
        $this->data['estudio'] = $this->estudio_model->get("estudio","*","estado = 1");
        $this->data['view'] = 'rrhh/estudio/vincularEstudio';
        $this->load->view('tema/header',$this->data);
   
       
    }	
    
    function nuevoDocumento(){
        //si existen archivos
        if (isset($_FILES)){
            
          $doc_anterior =   $this->archivos_model->get('documentos','*',' funcionalidad = "seleccion_personal" AND sector = 2 AND documento="'.$this->input->post('documento').'" AND referencia = '.$this->input->post('id'));
          
          if (count($doc_anterior)){
              $data = array(
                  'estado' =>0
              );
              if ($this->archivos_model->edit('documentos',$data,'idDocumentos',$doc_anterior[0]->idDocumentos)==TRUE){
                  //OK
              }else{
                  die("Error al editar el documento");
              }
          }
          if ($this->adjuntar_archivo($this->input->post('id'),"seleccion_personal",$this->input->post('documento')) ==TRUE){
              //archivos cargados con exito
          }else{
              $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al guardar el documento.</p></div>';
          }
        }
//        $this->uri->segment(3)=$this->input->post('id');
        redirect(base_url() . 'index.php/seleccion_personal/visualizar/'.$this->input->post('id'));
    }
    
    function adjuntar_archivo($referencia,$funcionalidad,$documento =''){
        $date = date('d-m-Y');
        $config['upload_path'] = './assets/archivos/'.$date;
        $config['allowed_types'] = 'txt|jpg|jpeg|gif|png|pdf|PDF|JPG|JPEG|GIF|PNG|doc|docx';
        $config['max_size']     = 0;
        $config['max_width']  = '10000';
        $config['max_height']  = '10000';
        $config['encrypt_name'] = true;
        
        if (!is_dir('./assets/archivos/'.$date)) {//si el directorio no exise lo crea
            mkdir('./assets/archivos/' . $date, 0777, TRUE);
        }
        
        $data = array();
        if( !empty($_FILES['userFiles']['name'])){
            $filesCount = count($_FILES['userFiles']['name']);
            for($i = 0; $i < $filesCount; $i++){
                $_FILES['userFile']['name'] = $_FILES['userFiles']['name'][$i];
                $_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$i];
                $_FILES['userFile']['tmp_name'] = $_FILES['userFiles']['tmp_name'][$i];
                $_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$i];
                $_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$i];

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    if ($documento==''){
                        $documento='CV';
                    }
                    $data = array(
                        'documento' => $documento,
                        'descripcion' => "El usuario: ".$this->session->userdata('id')." adjunta un Archivo de Estudio ",
                        'file' => $fileData['file_name'],
                        'path' => $fileData['full_path'],
                        'url' => base_url().'assets/archivos/'.date('d-m-Y').'/'.$fileData['file_name'],
                        'fecha' => date('Y-m-d'),
                        'size' => $fileData['file_size'],
                        'tipo' => $fileData['file_ext'],
                        'sector' => 2,
                        'referencia' => $referencia,
                        'funcionalidad'=>$funcionalidad
                    );
                     if(count($fileData)){//significa que el archivo fue cargado a la ruta
                        if ($this->archivos_model->add('documentos', $data) == TRUE) {
                            $this->session->set_flashdata('success','Archivo agregado con exito!');

                        } else {
                            $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al guardar los datos del archivo en la BD.</p></div>';
                            return false;
                        }
                    }else{
            //            $error = $archivo["error"];//retorna un string con el error del archivo
                        $this->data['custom_error'] = '<div class="form_error"><p></p></div>';//retorna un string con el error del archivo
                        return false;
                    } 
                }
                
            }//fin foreach
            
        }// end if
        return true;
    }//end function
    
    public function eliminarEstudioPersona(){
        $id =  $this->input->post('id');
        $idPersona =  $this->input->post('idPersona');
        if ($id == null){
            $this->session->set_flashdata('error','Ocurrio un error al intentar eliminar el estudio.');            
            redirect(base_url().'index.php/estudio/estudio/');
        }
        $data = array(
          'estado' => 0
        );
        
         if($this->estudio_model->edit('estudio_persona',$data,'idEstudio_persona',$id)){
          $this->session->set_flashdata('success','Estudio eliminado!');  
        }
        else{
          $this->session->set_flashdata('error','Error al eliminar el estudio!');  
        }  
//            $this->capacitacion_model->delete('capacitacion','idCapacitacion',$id);             
            redirect(base_url().'index.php/persona/visualizar?buscar='.$idPersona);
    }
    
    public  function pedido_listo(){
        $id_pedido = $_GET['val'];
        $data = array(
          'estado' => 2,
          'f_listo' =>  date('Y-m-d h:i:s')
        );
        if($this->pedido_model->edit('pedido',$data,'idPedido',$id_pedido)){
            $data = $this->pedido_model->get('pedido','pedido.*,usuario_str(pedido.usuario) as usr, menu_str(pedido.idMenu) as menu',' pedido.idPedido = '.$id_pedido); 
            
            echo $data[0]->persona_str.' '.$data[0]->menu.' '.date('d/m/Y H:m:s',  strtotime($data[0]->f_listo));
            //$this->session->set_flashdata('success','Estudio eliminado!');  
        }else{
            echo "Error ##RRE44565 consulte con el administrador.";
        }
    }
    
    public  function pedido_entregado(){
        $id_pedido = $_GET['val'];
        $data = array(
          'estado' => 3,
          'f_listo' =>  date('Y-m-d h:i:s')
        );
        if($this->pedido_model->edit('pedido',$data,'idPedido',$id_pedido)){
            $data = $this->pedido_model->get('pedido','pedido.*,usuario_str(pedido.usuario) as usr, menu_str(pedido.idMenu) as menu',' pedido.idPedido = '.$id_pedido); 
            
            echo $data[0]->persona_str.' '.$data[0]->menu.' '.date('d/m/Y H:m:s',  strtotime($data[0]->f_listo));
            //$this->session->set_flashdata('success','Estudio eliminado!');  
        }else{
            echo "Error ##RRE44565 consulte con el administrador.";
        }
    }
    
    public  function pedido_devuelto(){
        $id_pedido = $_GET['val'];
        $descripcion = $_GET['desc'];
        $data = array(
          'estado' => 4,
          'descripcion' => $descripcion,
          'f_listo' =>  date('Y-m-d h:i:s')
        );
        if($this->pedido_model->edit('pedido',$data,'idPedido',$id_pedido)){
            $data = $this->pedido_model->get('pedido','pedido.*,usuario_str(pedido.usuario) as usr, menu_str(pedido.idMenu) as menu',' pedido.idPedido = '.$id_pedido); 
            
            echo $data[0]->persona_str.' '.$data[0]->menu.' '.date('d/m/Y H:m:s',  strtotime($data[0]->f_listo));
            //$this->session->set_flashdata('success','Estudio eliminado!');  
        }else{
            echo "Error ##RRE44565 consulte con el administrador.";
        }
    }
    
}


/* End of file permissoes.php */
/* Location: ./application/controllers/permissoes.php */