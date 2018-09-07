<?php

class Laboratorio extends CI_Controller {
    

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

        if(!$this->permission->checkPermission($this->session->userdata('permiso'),'vLaboratorio')){
          $this->session->set_flashdata('error','Usted no tiene permisos para ver los tickets del sistema.');
          redirect(base_url());
        }

        $this->load->model('laboratorio_model', '', TRUE);
        $this->load->model('consola_model', '', TRUE);
        $this->load->model('usuarios_model', '', TRUE);
    }
	
    function index(){
        $this->gestionar();
    }

    function gestionar(){
        
        $this->load->library('pagination');

        $config['base_url'] = base_url().'index.php/laboratorio/gestionar/';
        $config['total_rows'] = $this->laboratorio_model->count('articulos_laboratorio');
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
        
        if ($this->input->get('articulo')!=''){//descripcion
             $where.= ' AND articulo_str(articulo_laboratorio.articulo) LIKE "%'.$this->input->get('articulo').'%" ';
        }
        if ($this->input->get('estado')==2){//descripcion
             $where.= ' AND estado = 2 ';
        }else{
            $where.= ' AND estado = 1 ';
        }
        
        
        //Obtiene articulos
        $this->data['results'] = $this->laboratorio_model->get(
                'articulos_laboratorio','articulos_laboratorio.*,'
                . 'articulo_str(articulos_laboratorio.articulo) as articulo_str,'
                . 'usuario_str(articulos_laboratorio.usuario) as usuario_str,'
                . 'usuario_str(articulos_laboratorio.asignado) as asignado_str',$where,$config['per_page'],$this->uri->segment(3));
       
        
        //Obtiene el listado de usuarios
        $this->data['results_usuario'] = $this->usuarios_model->get(
                'usuarios','usuarios.idUsuario,usuario.nombre','',$config['per_page'],$this->uri->segment(3));
        
        $this->data['view'] = 'laboratorio/laboratorio';
       	$this->load->view('tema/header',$this->data);
	
    }
	
    function agregar() {
        
        
        $this->load->library('form_validation');    
        $this->data['custom_error'] = '';
        $idMaquina =  $this->input->post('idMaquina'); 
        $id_ticket = 0;
        //datos propios del ticket
        $data_ticket = array(
            'solicita'=> $this->session->userdata('id'),
            'idAsignado' => '0',
            'referencia' => $this->input->post('referencia'),
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
                //verifica si tiene fallas
                
                if(count($this->input->post('fallas'))){
                    foreach ($this->input->post('fallas') as $falla){
                        //uso la fucion del model para cargar la falla a la maquina
                        $data_adicional = array(
                            'maquina'=>$this->input->post('referencia'),
                            'falla'=>$falla,
                            'fecha_registro'=>date('Y-m-d h:i:s'),
                            'estado'=>1,
                            'usuario'=>$this->session->userdata('id'),
                            'ticket'=>$id_ticket
                        );
        
                        $this->ticket_model->add('fallas_maquinas', $data_adicional);
                    }
                }
                redirect(base_url().'index.php/maquinas/gestionar/');
                break;
        }
        
           
        
                    
        $this->load->model('maquinas_model');
//        $this->data['maquinas'] = $this->maquinas_model->getActive('maquinas','maquinas.idmaquina,maquinas.nombre');   
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
        $this->data['result'] = $this->laboratorio_model->get('articulos_laboratorio',
                    'articulos_laboratorio.*,'
                .   'articulo_str(articulos_laboratorio.articulo)as articulo_str,'
                .   'usuario_str(articulos_laboratorio.asignado)as asignado_str,'
                .   'usuario_str(articulos_laboratorio.usuario)as solicita_str,'
                
                .   'permiso_str(articulos_laboratorio.asignado)as permiso_asignado,'
                .   'permiso_str(articulos_laboratorio.usuario)as permiso_solicita',
                'articulos_laboratorio.idArticuloLaboratorio= '.$this->uri->segment(3));
        
        //Obtiene los datos de las novedades
        $this->load->model('novedades_model', '', TRUE);
        $this->data['result_novedades'] = $this->novedades_model->get('novedades',
                    'novedades.*,'
                .   'usuario_str(novedades.usuario)as usuario_str,'
                .   'permiso_str(novedades.usuario)as permiso_str',
                'novedades.referencia = '.$this->uri->segment(3).' AND novedades.tipo = "L"','asc');
        
        //Obtiene los usuarios
        $this->load->model('usuarios_model', '', TRUE);
        $this->data['result_usuarios'] = $this->usuarios_model->get();
        
        
        
        $this->data['view'] = 'laboratorio/visualizar';
        $this->load->view('tema/header', $this->data);

        
    }
}


/* End of file permissoes.php */
/* Location: ./application/controllers/permissoes.php */
