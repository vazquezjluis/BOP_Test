<?php

class Seleccion_personal extends CI_Controller {
    

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

        
        $this->load->model('seleccion_personal_model', '', TRUE);
        $this->load->model('consola_model', '', TRUE);
        $this->load->model('archivos_model', '', TRUE);
        $this->load->model('sector_model', '', TRUE);
    }
	
    function index(){
        $this->gestionar();
    }

    function gestionar(){
        
//        $this->load->library('pagination');
//
//        $config['base_url'] = base_url().'index.php/Seleccion_personal/gestionar/';
//        $config['total_rows'] = $this->seleccion_personal_model->count('seleccion_personal');
//        $config['per_page'] = 10;
//        $config['next_link'] = 'Próxima';
//        $config['prev_link'] = 'Anterior';
//        $config['full_tag_open'] = '<div class="pagination alternate"><ul>';
//        $config['full_tag_close'] = '</ul></div>';
//        $config['num_tag_open'] = '<li>';
//        $config['num_tag_close'] = '</li>';
//        $config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
//        $config['cur_tag_close'] = '</b></a></li>';
//        $config['prev_tag_open'] = '<li>';
//        $config['prev_tag_close'] = '</li>';
//        $config['next_tag_open'] = '<li>';
//        $config['next_tag_close'] = '</li>';
//        $config['first_link'] = 'Primera';
//        $config['last_link'] = 'Última';
//        $config['first_tag_open'] = '<li>';
//        $config['first_tag_close'] = '</li>';
//        $config['last_tag_open'] = '<li>';
//        $config['last_tag_close'] = '</li>';
//
//        $this->pagination->initialize($config); 	

		  $this->data['results'] = $this->seleccion_personal_model->get(
                          'seleccion_personal',
                          '*',' seleccion_personal.estado = 1',0,$this->uri->segment(3));
       
         $sector = $this->sector_model->get_sector(' where eliminado != 1 ');
         foreach ($sector as $s){
         
             $this->data['sector'][$s->id] = $s->descripcion;
         }
         
	    $this->data['view'] = 'rrhh/seleccion_personal/seleccion_personal';
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
        if ($this->form_validation->run('seleccion_personal') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
          
            
            $data = array(
                'nombre' => $this->input->post('nombre'),
                'apellido' => $this->input->post('apellido'),
                'domicilio' => $this->input->post('domicilio'),
                'contacto' => $this->input->post('contacto'),
                'fuente_reclutamiento'=>$this->input->post('fuente_reclutamiento'),
                'descripcion' => $this->input->post('descripcion'),
                'sector' => $this->input->post('sector'),
                'estado'=>1,
                'meta_estado' => $this->input->post('meta_estado'),
                'fecha_meta_estado' => $this->input->post('fecha_meta_estado'),
                'f_proceso' => date('Y-m-d')
            );

            if ($this->seleccion_personal_model->add('seleccion_personal', $data) == TRUE) {
                
                $id_seleccion_personal = $this->db->insert_id();
                $acciones = array(
                    'usuario' => $this->session->userdata('id'),
                    'accion_id' => 1,
                    'accion' => 'Agrega el candidato : '.$this->input->post('nombre').' '.$this->input->post('apellido'),
                    'modulo' => 2,
                    'fecha_registro' => date('Y-m-d h:i:s')
                );
                
                if ($this->consola_model->add('consola',$acciones) == TRUE){
                    $this->session->set_flashdata('success', 'candidato agregados con exito!');
                    //redirect(base_url() . 'index.php/permisos/agregar/');
                }
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error.</p></div>';
            }
           //si existen archivos
            if (isset($_FILES)){
              if ($this->adjuntar_archivo($id_seleccion_personal,"seleccion_personal") ==TRUE){
                  //archivos cargados con exito
              }else{
                  $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al guardar el CV.</p></div>';
              }
            }
        }

        $this->data['sector'] = $this->sector_model->get_sector(' where eliminado != 1 ');
        $this->data['view'] = 'rrhh/seleccion_personal/agregarCandidato';
        $this->load->view('tema/header', $this->data);

    }

    function editar() {

        
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        if ($this->form_validation->run('seleccion_personal') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            
            $data = array(                    
                'nombre' => $this->input->post('nombre'),
                'apellido' => $this->input->post('apellido'),
                'domicilio' => $this->input->post('domicilio'),
                'contacto' => $this->input->post('contacto'),
                'fuente_reclutamiento'=>$this->input->post('fuente_reclutamiento'),
                'descripcion' => $this->input->post('descripcion'),
                'sector' => $this->input->post('sector'),
                'estado'=>1,
                'meta_estado'=>$this->input->post('meta_estado'),
                'fecha_meta_estado'=>$this->input->post('fecha_meta_estado'),
                'f_proceso' => date('Y-m-d')    
            );

            if ($this->seleccion_personal_model->edit('seleccion_personal', $data, 'idSeleccion_personal', $this->input->post('idSeleccion_personal')) == TRUE) {
                $acciones = array(
                        'usuario' => $this->session->userdata('id'),
                        'accion_id' => 2,
                        'accion' => 'Edita al candidato '.$this->input->post('id_seleccion_personal'),
                        'modulo' => 2,
                        'fecha_registro' => date('Y-m-d h:i:s')
                    );
                if ($this->consola_model->add('consola',$acciones) == TRUE){
                    $this->session->set_flashdata('success', 'Candidato editado con éxito!');
//                    redirect(base_url() . 'index.php/permisos/editar/'.$this->input->post('idPermiso'));
                }
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error.</p></div>';
            }
        }

        $this->data['result'] = $this->seleccion_personal_model->getById($this->uri->segment(3));
        $this->data['sector'] = $this->sector_model->get_sector(' where eliminado != 1 ');
        $this->data['view'] = 'rrhh/seleccion_personal/editarCandidato';
        $this->load->view('tema/header', $this->data);

    }
	
    function desactivar(){
        
        $id =  $this->input->post('id');
        if ($id == null){
            $this->session->set_flashdata('error','Ocurrio un error al intentar eliminar  el candidato.');            
            redirect(base_url().'index.php/seleccion_personal/');
        }
        $data = array(
          'estado' => 0
        );
        if($this->seleccion_personal_model->edit('seleccion_personal',$data,'idSeleccion_personal',$id)){
          $this->session->set_flashdata('success','Candidato eliminado con exito!');  
        }
        else{
          $this->session->set_flashdata('error','Error al eliminar el candidato!');  
        }         
        
                  
        redirect(base_url().'index.php/seleccion_personal/');
    }
    
    function vincular(){
        
        //
        
        
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';	
        if ($this->form_validation->run('vincular_premio') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : false);
        } 
        else
        {    
            //datos
            $data_premio_persona = array(
                'idPremio' => $this->input->post('premio'),
                'idPersona' => $this->input->post('persona_id'),
                'descripcion' => $this->input->post('descripcion'),
//                'tipo' => $this->input->post('tipo'),
                'fecha_registro' => date('Y-m-d'),
                'fecha_entrega' => $this->input->post('f_entrega'),                
                'usuario' => $this->session->userdata('id')
            );
            
            if ($this->premio_model->add('premio_persona',$data_premio_persona) == TRUE)
                {   
                    $id_premio_persona = $this->db->insert_id();
                    $acciones = array(
                        'usuario' => $this->session->userdata('id'),
                        'accion_id' => 1,
                        'accion' => 'Vincula el premio: '.$this->input->post('idPremio').' con la persona '.$this->input->post('persona_id'),
                        'modulo' => 2,
                        'fecha_registro' => date('Y-m-d')
                    );
                    if ($this->consola_model->add('consola',$acciones) == TRUE){        
                        $this->session->set_flashdata('success','premio vinculado con éxito!');
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
        
        
        $this->data['premio'] = $this->premio_model->get("premio","*","estado = 1");
        $this->data['view'] = 'rrhh/premio/vincularPremio';
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
    
}


/* End of file permissoes.php */
/* Location: ./application/controllers/permissoes.php */
