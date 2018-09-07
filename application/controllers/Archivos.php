<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Archivos extends CI_Controller {

    /**
     * author: Jose Vazquez
     * email: vazquezjluis@yahoo.com
     * 
     */

	public function __construct(){
		parent::__construct();
        if( (!session_id()) || (!$this->session->userdata('conectado'))){
            redirect('bingoOasis/login');
        }

        $this->load->helper(array('codegen_helper'));
        $this->load->model('archivos_model','',TRUE);
        $this->load->model('maquinas_model','',TRUE);
        $this->data['menuArquivos'] = 'Arquivos';
	}

    public function index(){
        $this->gerenciar();
    }
	public function gerenciar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vArquivo')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar arquivos.');
           redirect(base_url());
        }

		$this->load->library('pagination');

        $pesquisa = $this->input->get('pesquisa');
        $de = $this->input->get('data');
        $ate = $this->input->get('data2');

        if($pesquisa == null && $de == null && $ate == null){

            
                   
            $config['base_url'] = base_url().'index.php/arquivos/gerenciar';
            $config['total_rows'] = $this->arquivos_model->count('documentos');
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
            $config['first_link'] = 'Primeira';
            $config['last_link'] = 'Última';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            
            $this->pagination->initialize($config);     
            
            $this->data['results'] = $this->arquivos_model->get('documentos','idDocumentos,documento,descricao,file,path,url,cadastro,categoria,tamanho,tipo','',$config['per_page'],$this->uri->segment(3));
        
        }
        else{

            if($de != null){

                $de = explode('/', $de);
                $de = $de[2].'-'.$de[1].'-'.$de[0];

                if($ate != null){
                    $ate = explode('/', $ate);
                    $ate = $ate[2].'-'.$ate[1].'-'.$ate[0]; 
                }
                else{
                    $ate = $de;
                }
            }

            $this->data['results'] = $this->arquivos_model->search($pesquisa, $de, $ate);
        }

       	$this->data['view'] = 'arquivos/arquivos';
		$this->load->view('tema/topo',$this->data);
	}


	public function agregar() {

//        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aArquivo')){
//          $this->session->set_flashdata('error','Você não tem permissão para adicionar arquivos.');
//          redirect(base_url());
//        }

//        $this->load->library('form_validation');
//        $this->data['custom_error'] = '';
//
//        $this->form_validation->set_rules('nome', '', 'trim|required');


//        if ($this->form_validation->run() == false) {
//            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
//        } else {
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

    public function editar() {

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }
        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eArquivo')){
          $this->session->set_flashdata('error','Você não tem permissão para editar arquivos.');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('nome', '', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            $data = $this->input->post('data');
            if($data == null){
                $data = date('Y-m-d');
            }
            else{
                $data = explode('/',$data);
                $data = $data[2].'-'.$data[1].'-'.$data[0];
            }

            $data = array(
                'documento' => $this->input->post('nome'),
                'descricao' => $this->input->post('descricao'),
                'cadastro' => $data,           
            );

            if ($this->arquivos_model->edit('documentos', $data, 'idDocumentos', $this->input->post('idDocumentos')) == TRUE) {
                $this->session->set_flashdata('success','Alterações efetuadas com sucesso!');
                redirect(base_url() . 'index.php/arquivos/editar/'.$this->input->post('idDocumentos'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }


        $this->data['result'] = $this->arquivos_model->getById($this->uri->segment(3));
        $this->data['view'] = 'arquivos/editarArquivo';
        $this->load->view('tema/topo', $this->data);

    }


    public function download($id = null){
    	
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vArquivo')){
          $this->session->set_flashdata('error','Você não tem permissão para visualizar arquivos.');
          redirect(base_url());
        }

    	if($id == null || !is_numeric($id)){
    		$this->session->set_flashdata('error','Erro! O arquivo não pode ser localizado.');
            redirect(base_url() . 'index.php/arquivos/');
    	}

    	$file = $this->arquivos_model->getById($id);

    	$this->load->library('zip');

    	$path = $file->path;

		$this->zip->read_file($path); 

		$this->zip->download('file'.date('d-m-Y-H.i.s').'.zip');
    }


    public function excluir(){
    	if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dArquivo')){
          $this->session->set_flashdata('error','Você não tem permissão para excluir arquivos.');
          redirect(base_url());
        }

    	$id = $this->input->post('id');
    	if($id == null || !is_numeric($id)){
    		$this->session->set_flashdata('error','Erro! O arquivo não pode ser localizado.');
            redirect(base_url() . 'index.php/arquivos/');
    	}

    	$file = $this->arquivos_model->getById($id);

    	$this->db->where('idDocumentos', $id);
        
        if($this->db->delete('documentos')){

        	$path = $file->path;
	    	unlink($path);

	    	$this->session->set_flashdata('success','Arquivo excluido com sucesso!');
	        redirect(base_url() . 'index.php/arquivos/');
        }
        else{

        	$this->session->set_flashdata('error','Ocorreu um erro ao tentar excluir o arquivo.');
            redirect(base_url() . 'index.php/arquivos/');
        }


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

/* End of file arquivos.php */
/* Location: ./application/controllers/arquivos.php */