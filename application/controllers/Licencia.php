<?php

class Licencia extends CI_Controller {
    

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
        if(!$this->permission->checkPermission($this->session->userdata('permiso'),'vLicencia')){
          $this->session->set_flashdata('error','Usted no tiene permisos para configurar las licencias.');
          redirect(base_url());
        }

        
        $this->load->model('licencia_model', '', TRUE);
        $this->load->model('consola_model', '', TRUE);
        $this->load->model('persona_model', '', TRUE);
        $this->load->model('archivos_model', '', TRUE);
        $this->load->model('sector_model', '', TRUE);
        
    }

    function index(){
        $this->data['view'] = 'rrhh/licencia/licencia';
       	$this->load->view('tema/header',$this->data);
    }

    function listadoLicencia(){
        
        $this->load->library('pagination');
    
        $config['base_url'] = base_url().'index.php/licencia/listadoLicencia/';
        $config['total_rows'] = $this->licencia_model->countLicenciaActiva();
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

        $this->data['results'] = $this->licencia_model->get($config['per_page'],$this->uri->segment(3));
        
       
        $this->data['view'] = 'rrhh/licencia/listadoLicencia';
       	$this->load->view('tema/header',$this->data);

       
		
    }
    function listadoVinculo(){
        
        $this->load->library('pagination');
    
        $config['base_url'] = base_url().'index.php/licencia/listadoVinculo/';
        $config['total_rows'] = $this->licencia_model->countLicenciaVinculoActiva();
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

        $this->data['results'] = $this->licencia_model->get_licencia_persona($config['per_page'],$this->uri->segment(3));
        
       
        $this->data['view'] = 'rrhh/licencia/listadoVinculo';
       	$this->load->view('tema/header',$this->data);

       
		
    }
	
    function agregar(){  
          
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('licencia') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : false);
        } else
        {     
            
            
            $data = array(
                    'titulo' => $this->input->post('titulo'),
                    'descripcion' => $this->input->post('descripcion'),
                    'dias' => $this->input->post('dias'),
                    'estado' => 1
            );
            
            if ($this->licencia_model->add('licencia',$data) == TRUE)
                {   
                    $acciones = array(
                        'usuario' => $this->session->userdata('id'),
                        'accion_id' => 1,
                        'accion' => 'Agrega la licencia: '.set_value('titulo'),
                        'modulo' => 2,
                        'fecha_registro' => date('Y-m-d')
                    );
                    if ($this->consola_model->add('consola',$acciones) == TRUE){
                                
                        $this->session->set_flashdata('success','Licencia registrado con éxito!');
                            redirect(base_url().'index.php/licencia/agregar/');
                        }
                    }
                    else
                    {
                        $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al guardar la consola de la licencia.</p></div>';
                    }
            }
        
        $this->data['view'] = 'rrhh/licencia/agregarLicencia';
        $this->load->view('tema/header',$this->data);
   
       
    }	
    
    function editar(){  
        
        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','El registro no puede ser encontrado, el parámetro no fue pasado correctamente.');
            redirect('bingoOasis');
        }

        $this->load->library('form_validation');    
        $this->data['custom_error'] = '';
        $this->form_validation->set_rules('titulo', 'Titulo', 'trim|required');
//        $this->form_validation->set_rules('descripcion', 'Descripcion', 'trim|required');
        
        if ($this->form_validation->run() == false)
        {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        } else
        { 

            $data = array(
                'titulo' => $this->input->post('titulo'),
                'descripcion' => $this->input->post('descripcion'),
                'dias' => $this->input->post('dias'),
                'estado' => 1
            );
            
            if ($this->licencia_model->edit('licencia',$data,'idLicencia',$this->input->post('idLicencia')) == TRUE)
                {
                    $acciones = array(
                        'usuario' => $this->session->userdata('id'),
                        'accion_id' => 2,
                        'accion' => 'Edita la licencia: '.$this->input->post('idLicencia').' - '.$this->input->post('titulo')." # ".$this->input->post('descripcioon'),
                        'modulo' => 2,
                        'fecha_registro' => date('Y-m-d h:i:s')
                    );
                    if ($this->consola_model->add('consola',$acciones) == TRUE){
                        $this->session->set_flashdata('success','Licencia editada con éxito!');
                        redirect(base_url().'index.php/licencia/editar/'.$this->input->post('idLicencia'));
                    }
                }
                else
                {
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error</p></div>';
                }
        }

        $this->data['result'] = $this->licencia_model->getById($this->uri->segment(3));
        
        $this->data['view'] = 'rrhh/licencia/editarLicencia';
        $this->load->view('tema/header',$this->data);
			
      
    }
	
    public function eliminar(){
        $id =  $this->input->post('id');
        if ($id == null){
            $this->session->set_flashdata('error','Ocurrio un error al intentar eliminar la Licencia.');            
            redirect(base_url().'index.php/licencia/gestionar/');
        }
        $data = array(
          'estado' => 0
        );
        
        if($this->licencia_model->edit('licencia',$data,'idLicencia',$id)){
          $this->session->set_flashdata('success','Licencia eliminada!');  
        }
        else{
          $this->session->set_flashdata('error','Error al eliminar la licencia!');  
        }  
        redirect(base_url().'index.php/licencia/listadoLicencia');
    }
    
    
    public function eliminarLicencia_persona(){
        $id =  $this->input->post('id');
        if ($id == null){
            $this->session->set_flashdata('error','Ocurrio un error al intentar eliminar la Licencia.');            
            redirect(base_url().'index.php/licencia/gestionar/');
        }
        $data = array(
          'estado' => 0
        );
        
        if($this->licencia_model->edit('licencia_persona',$data,'idLicenciaPersona',$id)){
          $this->session->set_flashdata('success','Licencia eliminada!');  
        }
        else{
          $this->session->set_flashdata('error','Error al eliminar la licencia!');  
        }  
        redirect(base_url().'index.php/licencia/listadoVinculo/');
    }
    
    function vincular(){
        $valida = 0;
        if (isset($_POST)){
            $valida = $this->validar_vinculo($_POST);
        }
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';	
        if ($this->form_validation->run('vincular_licencia') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : false);
        }elseif($valida!=0)
        {
            $this->data['custom_error'] = '<div class="alert alert-danger">'.$valida.'</div>';
        } 
        else
        {    
            //datos
            $data_licencia_persona = array(
                'idLicencia' => $this->input->post('licencia'),
                'idPersona' => $this->input->post('persona_id'),
                'dias' => $this->input->post('dias'),
                'descripcion' => $this->input->post('descripcion'),
                'fecha_registro' => date('Y-m-d'),
                'f_inicio' => $this->input->post('inicio'),
                'f_fin' => $this->input->post('fin'),
                'usuario' => $this->session->userdata('id')
            );
            
            if ($this->licencia_model->add('licencia_persona',$data_licencia_persona) == TRUE)
                {   
                    $id_licencia_persona = $this->db->insert_id();
                    $acciones = array(
                        'usuario' => $this->session->userdata('id'),
                        'accion_id' => 1,
                        'accion' => 'Vincula la licencia: '.$this->input->post('idLicencia').' con el usuario '.$this->input->post('idUsuario'),
                        'modulo' => 2,
                        'fecha_registro' => date('Y-m-d')
                    );
                    if ($this->consola_model->add('consola',$acciones) == TRUE){
                                
                        $this->session->set_flashdata('success','Licencia vinculada con éxito!');
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
            
            
            //si existen archivos
            if (isset($_FILES)){
              if ($this->adjuntar_archivo($id_licencia_persona,"licencia_persona") ==TRUE){
                  //archivos cargados con exito
              }else{
                  $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al guardar los documentos.</p></div>';
              }
//            $this->adjuntar_archivo(123456,"licencia_persona");
            }
        }
        
        $this->data['licencia'] = $this->licencia_model->get();
        $this->data['view'] = 'rrhh/licencia/vincularLicencia';
        $this->load->view('tema/header',$this->data);
   
       
    }	
    
    public function autoCompletePersona(){
        
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            
            $sectores_del_usuario='';
            $sectores = $this->sector_model->get_sector();
            foreach ($sectores as $sector){
                 if(!$this->permission->checkPermission($this->session->userdata('permiso'),(string)str_replace(" ","",str_replace(".","",$sector->descripcion)))){
                    //el usuario o tiene permiso en ese sector
                 }else{
                     $sectores_del_usuario.="OR SECTORES.descripcion = '".$sector->descripcion."' ";
                 }
            }
            
            $this->persona_model->autoCompletePersona($q,$sectores_del_usuario);
        }

    }
    
    function validar_vinculo($post){
        if (!isset($post["persona_id"])){ return "campo persona invalida.";}
        if (!isset($post["licencia"])){ return "campo licencia invalida.";}
        if (!isset($post["dias"])){ return "campo dias invalido.";}
        $licencia = $this->licencia_model->getById($post["licencia"]);
        if ($post["dias"] > $licencia->dias ){ return "La cantidad de dias tomados excede el total de la licencia seleccionada.";}
        
        return 0;
    }
    
    
    
    function adjuntar_archivo($referencia,$funcionalidad){
        $date = date('d-m-Y');
        $config['upload_path'] = './assets/archivos/'.$date;
        $config['allowed_types'] = 'txt|jpg|jpeg|gif|png|pdf|PDF|JPG|JPEG|GIF|PNG';
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
                    
                    $data = array(
                        'documento' => 'Vinculo licencia_persona',
                        'descripcion' => "El usuario: ".$this->session->userdata('id')." adjunta un comprobante de licencia",
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

