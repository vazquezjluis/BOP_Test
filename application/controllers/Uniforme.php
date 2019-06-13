<?php

class Uniforme extends CI_Controller {
    

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

        
        $this->load->model('uniforme_model', '', TRUE);
        $this->load->model('bejerman_model', '', TRUE);
        $this->load->model('consola_model', '', TRUE);
        $this->load->model('archivos_model', '', TRUE);
    }
	
    function index(){
        $this->gestionar();
    }

    function gestionar(){
        
        $this->load->library('pagination');

        $config['base_url'] = base_url().'index.php/uniforme/gestionar/';
        $config['total_rows'] = $this->bejerman_model->get_articulo('',true);
        
        $this->data['results'] = $this->bejerman_model->get_articulo(' ',false);
       
        $this->data['view'] = 'rrhh/uniforme/uniforme';
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
        $this->data['result'] = $this->uniforme_model->get('uniforme','*',
                'uniforme.idUniforme= '.$this->uri->segment(3));
        
        $this->data['view'] = 'rrhh/uniforme/visualizar';
        $this->load->view('tema/header', $this->data);

        
    }
	
    function agregar() {

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        if ($this->form_validation->run('uniforme') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            
            
            $data = array(
                'prenda' => $this->input->post('prenda'),
                'tipo_prenda' => $this->input->post('tipo_prenda'),
                'talle' => $this->input->post('talle'),
                'cantidad' => $this->input->post('cantidad'),
                'estado'=>1
            );

            if ($this->uniforme_model->add('uniforme', $data) == TRUE) {
                
                $id_uniforme = $this->db->insert_id();
                $acciones = array(
                    'usuario' => $this->session->userdata('id'),
                    'accion_id' => 1,
                    'accion' => 'Agrega el uniforme : '.$id_uniforme,
                    'modulo' => 2,
                    'fecha_registro' => date('Y-m-d h:i:s')
                );
                
                if ($this->consola_model->add('consola',$acciones) == TRUE){
                    $this->session->set_flashdata('success', 'prenda agregada con exito!');
                    //redirect(base_url() . 'index.php/permisos/agregar/');
                }
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al guardar la prenda.</p></div>';
            }
        }

        $this->data['view'] = 'rrhh/uniforme/agregarUniforme';
        $this->load->view('tema/header', $this->data);

    }

    function editar() {

        
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        if ($this->form_validation->run('uniforme') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            
            $data = array(    
                'prenda' => $this->input->post('prenda'),
                'tipo_prenda' => $this->input->post('tipo_prenda'),
                'talle' => $this->input->post('talle'),
                'cantidad' => $this->input->post('cantidad'),
                'estado'=>1
                    
            );

            if ($this->uniforme_model->edit('uniforme', $data, 'idUniforme', $this->input->post('idUniforme')) == TRUE) {
                $acciones = array(
                        'usuario' => $this->session->userdata('id'),
                        'accion_id' => 2,
                        'accion' => 'Edita al uniforme '.$this->input->post('idUniforme'),
                        'modulo' => 2,
                        'fecha_registro' => date('Y-m-d h:i:s')
                    );
                if ($this->consola_model->add('consola',$acciones) == TRUE){
                    $this->session->set_flashdata('success', 'Uniforme editado con éxito!');
//                    redirect(base_url() . 'index.php/permisos/editar/'.$this->input->post('idPermiso'));
                }
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al editar la prenda.</p></div>';
            }
        }

        $this->data['result'] = $this->uniforme_model->getById($this->uri->segment(3));
        
        $this->data['view'] = 'rrhh/uniforme/editarUniforme';
        $this->load->view('tema/header', $this->data);

    }
	
    function desactivar(){
        
        $id =  $this->input->post('id');
        if ($id == null){
            $this->session->set_flashdata('error','Ocurrio un error al intentar eliminar  el candidato.');            
            redirect(base_url().'index.php/uniforme/');
        }
        $data = array(
          'estado' => 0
        );
        if($this->uniforme_model->edit('uniforme',$data,'idUniforme',$id)){
          $this->session->set_flashdata('success','Prenda eliminada con exito!');  
        }
        else{
          $this->session->set_flashdata('error','Error al eliminar la prenda!');  
        }         
        
                  
        redirect(base_url().'index.php/uniforme/');
    }
    
    function vincular(){
        
        $this->load->library('form_validation');    
        $this->data['custom_error'] = '';	
        if ($this->form_validation->run('vincular_uniforme') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : false);
        } 
        else
        {    
            //datos
            $data_uniforme_persona = array(
                'idUniforme' => $this->input->post('uniforme_id'),
                'idPersona' => $this->input->post('persona_id'),
                'f_proceso' => date('Y-m-d'),
                'descripcion' => $this->input->post('descripcion'),
                'usuario' => $this->session->userdata('id')
            );
            
            if ($this->uniforme_model->add('uniforme_has_persona',$data_uniforme_persona) == TRUE)
                {   
                    $id_uniforme_persona = $this->db->insert_id();
                     
                        $acciones = array(
                            'usuario' => $this->session->userdata('id'),
                            'accion_id' => 1,
                            'accion' => 'Vincula el uniforme: '.$this->input->post('uniforme_id').' con la persona '.$this->input->post('persona_id'),
                            'modulo' => 2,
                            'fecha_registro' => date('Y-m-d')
                        );
                        if ($this->consola_model->add('consola',$acciones) == TRUE){        
                            $this->session->set_flashdata('success','uniforme vinculado con éxito!');
                            //redirect(base_url().'index.php/licencia/vincular');
                        }
                        if ($this->input->post('desde_persona')!==NULL){
                            redirect(base_url().'index.php/persona/visualizar?buscar='.$this->input->post('persona_id'));
                        }
                    
                }
            else
            {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al guardar la consola del vinculo del uniforme.</p></div>';
            }
            
        }
        
        
        $this->data['uniforme'] = $this->bejerman_model->get_articulo(" ",false);
        $this->data['view'] = 'rrhh/uniforme/vincularPrenda';
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
                    if ($documento==''){
                        $documento='CV';
                    }
                    $data = array(
                        'documento' => $documento,
                        'descripcion' => "El usuario: ".$this->session->userdata('id')." adjunta un CV ",
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
    
    function eliminarPrendaPersona(){
        $id =  $this->input->post('id');
        $idPersona =  $this->input->post('idPersona');
        if ($id == null){
            $this->session->set_flashdata('error','Ocurrio un error al intentar eliminar la prenda.');            
            redirect(base_url().'index.php/uniforme/');
        }
        $data = array(
          'estado' => 0
        );
        if($this->uniforme_model->edit('uniforme_has_persona',$data,'idUniforme_has_persona',$id)){
          $this->session->set_flashdata('success','Prenda eliminada con exito!');  
        }
        else{
          $this->session->set_flashdata('error','Error al eliminar la prenda!');  
        }         
        redirect(base_url().'index.php/persona/visualizar?buscar='.$idPersona);
    }
}


/* End of file permissoes.php */
/* Location: ./application/controllers/permissoes.php */