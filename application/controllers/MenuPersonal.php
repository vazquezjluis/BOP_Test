<?php

class MenuPersonal extends CI_Controller {


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

        if(!$this->permission->checkPermission($this->session->userdata('permiso'),'vMenu')){
          $this->session->set_flashdata('error','Usted no tiene permisos .');
          redirect(base_url());
        }


        $this->load->model('menuPersonal_model', '', TRUE);
        $this->load->model('valormenu_model', '', TRUE);
        $this->load->model('fechalimiteprogramado_model', '', TRUE);
        $this->load->model('consola_model', '', TRUE);
        $this->load->model('parametroMenu_model', '', TRUE);
        $this->load->model('persona_model', '', TRUE);
    }

    function index(){
        $this->gestionar();
    }

    function buscarMenu(){
        $persona  = $this->persona_model->get_persona(' WHERE legajo ='.$_GET['legajo']);

        $jornada  = $this->persona_model->get_jornada($persona[0]->id );
        $excluido = false;
        $jornadas_excluidas =  array(32,54,95,99,39,15);//ID DE LA TABLA JORNADA DE LENOX
        if (count($jornada)){
            foreach ($jornada as $j) {
                if($j->fecha == $_GET['fecha']){
                  //verifico la jornada
                  if (in_array($j->id_jornada_generica, $jornadas_excluidas)){
                      $excluido = true;
                  }
                }
            }

            if($excluido) {
                $sql = ' menu_personal.fecha_menu = "'.$this->input->get('fecha').'" AND menu_personal.estado = 1 and tipo_menu = "interno" ';
            }else {
                $sql = ' menu_personal.fecha_menu = "'.$this->input->get('fecha').'" AND menu_personal.estado = 1 ';
            }
            $menu = $this->menuPersonal_model->get('menu_personal','menu_personal.*',$sql);

        }


        if(isset($menu) and count($menu)){
            echo json_encode($menu);
        }else{ echo '0';}

    }
    function gestionar(){

        $this->load->library('pagination');

        $config['base_url'] = base_url().'index.php/menuPersonal/gestionar/';
        $config['total_rows'] = count($this->menuPersonal_model->getActive('menu_personal','*'));
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

        $this->data['results'] = $this->menuPersonal_model->get('menu_personal','*',' menu_personal.estado != 0',$config['per_page'],$this->uri->segment(3));
        $this->data['importe_externo'] = $this->valormenu_model->get('valormenu','importe_externo',' valormenu.estado != 0');
        $this->data['fechaLimiteProgramado'] = $this->fechalimiteprogramado_model->get('fechalimiteprogramado','fecha',' fechalimiteprogramado.estado != 0');
        $this->data['parametroMenu'] = $this->parametroMenu_model->get('parametro_menu','*',' parametro_menu.estado!=0 ');

//var_dump($this->data['importe_externo']);//die();
       // $this->data['results'] = $this->menuPersonal_model->get_group_fecha('menu_personal', ' GROUP_CONCAT(CONCAT("#",descripcion,"(",if(ISNULL(tipo_menu),"externo",tipo_menu),")","@") SEPARATOR "  ") as descripcion, fecha_menu, tipo_menu, idMenuPersonal',' menu_personal.estado != 0',$config['per_page'],$this->uri->segment(3));

	$this->data['view'] = 'gastronomia/menuPersonal/menuPersonal';
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

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        if ($this->form_validation->run('menu') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {


            $data = array(
                'descripcion' => $this->input->post('descripcion'),
                'fecha_menu' => $this->input->post('fecha_menu'),
                'tipo_menu' => $this->input->post('tipo_menu'),
                'valor' => $this->input->post('valor'),
                'estado'=>1,
                'f_proceso' => date('Y-m-d h:i:s'),
                'usuario_carga'=>$this->session->userdata('id')
            );


            //$existe = $this->menuPersonal_model->get('menu_personal', '*', ' menu_personal.estado =1 AND menu_personal.fecha_menu = "'.$this->input->post('fecha_menu').'"');



            //if (count($existe)==0 AND in_array(date("w"),array(0,6))){//Solo se puede cargar sabados o domingos
            //if (count($existe)==0){//Carga todos los dias
                if ($this->menuPersonal_model->add('menu_personal', $data) == TRUE) {
                    $id_nuevo = $this->db->insert_id();
                    $acciones = array(
                        'usuario' => $this->session->userdata('id'),
                        'accion_id' => 1,
                        'accion' => 'Agrega el menu : '.$this->input->post('descripcion'),
                        'modulo' => 2,
                        'fecha_registro' => date('Y-m-d h:i:s')
                    );

                    if ($this->consola_model->add('consola',$acciones) == TRUE){
                        $this->session->set_flashdata('success', 'menu agregados con exito!');
                        //redirect(base_url() . 'index.php/permisos/agregar/');
                    }
                } else {
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al cargar un menu.</p></div>';
                }
            //}
            //else{
               // if(!in_array(date("w"),array(0,6))){
                 //   $this->data['custom_error'] = '<div class="form_error"><p>Solo se puede cargar el menu los dias sabados o domingos.</p></div>';
                // }else{
                    //$this->data['custom_error'] = '<div class="form_error"><p>Ya existe un menu para el '.date('d/m/Y',  strtotime($this->input->post('fecha_menu'))).'.</p></div>';
                // }

            //}


        }

        $this->data['view'] = 'gastronomia/menuPersonal/agregarMenuPersonal';
        $this->load->view('tema/header', $this->data);

    }

    function editar() {


        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        if ($this->form_validation->run('menu') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            $data = array(
                'descripcion' => $this->input->post('descripcion'),
                'fecha_menu' => $this->input->post('fecha_menu'),
                'tipo_menu' => $this->input->post('tipo_menu'),
                'valor' => $this->input->post('valor'),
            );

            if ($this->menuPersonal_model->edit('menu_personal', $data, 'idMenuPersonal', $this->input->post('idMenuPersonal')) == TRUE) {
                $acciones = array(
                        'usuario' => $this->session->userdata('id'),
                        'accion_id' => 2,
                        'accion' => 'Edita al menu '.$this->input->post('idEstudio'),
                        'modulo' => 2,
                        'fecha_registro' => date('Y-m-d h:i:s')
                    );
                if ($this->consola_model->add('consola',$acciones) == TRUE){
                    $this->session->set_flashdata('success', 'Menu editado con éxito!');
                    redirect(base_url() . 'index.php/menuPersonal/editar/'.$this->input->post('idMenuPersonal'));
                }
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al editar el menu.</p></div>';
            }
        }

        $this->data['result'] = $this->menuPersonal_model->getById($this->uri->segment(3));

        $this->data['view'] = 'gastronomia/menuPersonal/editarMenuPersonal';
        $this->load->view('tema/header', $this->data);

    }

    function desactivar(){

        $id =  $this->input->post('id');
        if ($id == null){
            $this->session->set_flashdata('error','Ocurrio un error al intentar desactivar  el menu.');
            redirect(base_url().'index.php/menuPersonal/');
        }
        $data = array(
          'estado' => 2
        );
        if($this->menuPersonal_model->edit('menu_personal',$data,'idMenuPersonal',$id)){
          $this->session->set_flashdata('success','Menu desactivado!');
        }
        else{
          $this->session->set_flashdata('error','Error al dersactivar el menu!');
        }


        redirect(base_url().'index.php/menuPersonal/');
    }

    function addParameters() {

        $error = '';
        if (!isset($_POST['dia'])){
            $error.= ' Debe selecconar al menos un dia de la semana. <br>';
        }
        if (!isset($_POST['tiempo'])){
            $error.= ' Debe selecconar dia, semana o mes. <br>';
        }
        if (!isset($_POST['cantidad'])){
            $error.= ' Debe completar el campos cantidad. <br>';
        }

        if($error!=''){
                $this->session->set_flashdata('error',$error);
        }else {
            $data = array(
                'dia'       => implode(',',$this->input->post('dia')),
                'tiempo'    => $this->input->post('tiempo'),
                'cantidad'  => $this->input->post('cantidad'),
                'estado'=>1,
                'f_proceso' => date('Y-m-d h:i:s'),
                'usuario_carga'=>$this->session->userdata('id')
            );

            //primero edito todos los registros en estado 1 a cero
            if($this->parametroMenu_model->edit('parametro_menu',array("estado"=>0),"1","1")){
                if ($this->parametroMenu_model->add('parametro_menu',$data) == TRUE)
                {
                    $acciones = array(
                        'usuario' => $this->session->userdata('id'),
                        'accion_id' => 1,
                        'accion' => 'Agrega el parametro: '.implode(',', $this->input->post('dia')).' - '.$this->input->post('fecha_menu'),
                        'modulo' => 1,
                        'fecha_registro' => date('Y-m-d')
                    );
                    if ($this->consola_model->add('consola',$acciones) == TRUE){
                        $this->session->set_flashdata('success','Parametros registrados con éxito!');
                    }
                }
                else
                {
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al agregar la falla.</p></div>';
                }
            }


        }
        redirect(base_url().'index.php/menuPersonal/');
    }
    function eliminar(){

        $id =  $this->input->get('id');
        if ($id == null){
            $this->session->set_flashdata('error','Ocurrio un error al intentar desactivar  el menu.');
            redirect(base_url().'index.php/menuPersonal/');
        }
        $data = array(
          'estado' => 0
        );
        if($this->menuPersonal_model->edit('menu_personal',$data,'idMenuPersonal',$id)){
          $this->session->set_flashdata('success','Menu eliminado!');
        }
        else{
          $this->session->set_flashdata('error','Error al dersactivar el menu!');
        }


        redirect(base_url().'index.php/menuPersonal/');
    }
    function activar(){

        $id =  $this->input->post('id');
        if ($id == null){
            $this->session->set_flashdata('error','Ocurrio un error al intentar desactivar  el menu.');
            redirect(base_url().'index.php/menuPersonal/');
        }
        $data = array(
          'estado' => 1,
          'f_proceso'=>date('Y-m-d h:i:s')
        );
        if($this->menuPersonal_model->edit('menu_personal',$data,'idMenuPersonal',$id)){

            $activos = $this->menuPersonal_model->get('menu_personal', '*', ' menu_personal.estado =1 ');
            if (count($activos)){
                foreach($activos as $a){
                    $data_edit = array('estado'=>'2');
                    if ($a->idMenuPersonal != $id){
                        $this->menuPersonal_model->edit('menu_personal', $data_edit,'idMenuPersonal',$a->idMenuPersonal);
                    }

                }
            }

          $this->session->set_flashdata('success','Menu activado!');
        }
        else{
          $this->session->set_flashdata('error','Error al dersactivar el menu!');
        }


        redirect(base_url().'index.php/menuPersonal/');
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


}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function delete() {
        $data = array();
        echo "Hola";
        // Si se envía una solicitud de eliminación de registros
        if ($this->input->post('bulk_delete_submit')) {
            // Obtener todas las IDs seleccionadas
            $ids = $this->input->post('check_id');
            var_dump($ids);
            exit;
            echo "hola";
             // Si la matriz de id no está vacía
            if ($ids) {
                // Borra los registros de la base
                 $delete = $this->menuPersonal_model->delete_($ids);

                // Si la eliminación se realiza correctamente
                if ($delete) {
                    $data['statusMsg'] = 'Los usuarios seleccionados se han eliminado con éxito' ;
                } else {
                    $data['statusMsg'] = 'Ocurrió algún problema, inténtalo de nuevo.' ;
                }
            } else {
                $data['statusMsg'] = 'Seleccione al menos 1 registro para eliminar' ;
            }
        }

        // Obtenga datos de usuario de la base
         $data['menuPersonal_model'] = $this->menuPersonal_model->getRows();

        // Pase los datos para ver
        $this->load->view('tema/header', $data);
    }
/* End of file permissoes.php */
/* Location: ./application/controllers/permissoes.php */
