<?php

class Permisos extends CI_Controller {


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

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('permisos_model', '', TRUE);
        $this->load->model('sector_model', '', TRUE);
        $this->load->model('consola_model', '', TRUE);
        $this->data['menuConfiguraciones'] = 'Permisos';
    }

    function index(){
        $this->gestionar();
    }

    function gestionar(){

        // $this->load->library('pagination');
        //
        // $config['base_url'] = base_url().'index.php/permisos/gestionar/';
        // $config['total_rows'] = $this->permisos_model->count('permisos');
        // $config['per_page'] = 10;
        // $config['next_link'] = 'Próxima';
        // $config['prev_link'] = 'Anterior';
        // $config['full_tag_open'] = '<div class="pagination alternate"><ul>';
        // $config['full_tag_close'] = '</ul></div>';
        // $config['num_tag_open'] = '<li>';
        // $config['num_tag_close'] = '</li>';
        // $config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
        // $config['cur_tag_close'] = '</b></a></li>';
        // $config['prev_tag_open'] = '<li>';
        // $config['prev_tag_close'] = '</li>';
        // $config['next_tag_open'] = '<li>';
        // $config['next_tag_close'] = '</li>';
        // $config['first_link'] = 'Primera';
        // $config['last_link'] = 'Última';
        // $config['first_tag_open'] = '<li>';
        // $config['first_tag_close'] = '</li>';
        // $config['last_tag_open'] = '<li>';
        // $config['last_tag_close'] = '</li>';
        //
        // $this->pagination->initialize($config);

		  $this->data['results'] = $this->permisos_model->get(
                          'permisos',
                          'idPermiso,nombre,fecha_registro,estado',' estado = 1',$this->uri->segment(3));

	    $this->data['view'] = 'permisos/permisos';
       	$this->load->view('tema/header',$this->data);

    }

    function agregar() {

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            $nombrePermiso = $this->input->post('nombre');
            $registro = date('Y-m-d');
            $estado = 1;

            $permisos = array(
                  'cUsuario' => $this->input->post('cUsuario'),
                  'cPermiso' => $this->input->post('cPermiso'),
                  'cConsola' => $this->input->post('cConsola'),
                  'cBackup' => $this->input->post('cBackup'),

                  'vMaquina' => $this->input->post('vMaquina'),
                  'eMaquina' => $this->input->post('eMaquina'),
                  'dMaquina' => $this->input->post('dMaquina'),
                  'cMaquina' => $this->input->post('cMaquina'),

                  'vArticulos' => $this->input->post('vArticulos'),
                  'eArticulos' => $this->input->post('eArticulos'),
                  'dArticulos' => $this->input->post('dArticulos'),
                  'cArticulos' => $this->input->post('cArticulos'),

                  'vCategorias' => $this->input->post('vCategorias'),
                  'eCategorias' => $this->input->post('eCategorias'),
                  'dCategorias' => $this->input->post('dCategorias'),
                  'cCategorias' => $this->input->post('cCategorias'),

                  'vFallas' => $this->input->post('vFallas'),
                  'eFallas' => $this->input->post('eFallas'),
                  'dFallas' => $this->input->post('dFallas'),
                  'cFallas' => $this->input->post('cFallas'),

                  'vSala' => $this->input->post('vSala'),
                  'eSala' => $this->input->post('eSala'),
                  'dSala' => $this->input->post('dSala'),
                  'cSala' => $this->input->post('cSala'),

                  'vDesempeno' => $this->input->post('vDesempeno'),
                  'eDesempeno' => $this->input->post('eDesempeno'),
                  'dDesempeno' => $this->input->post('dDesempeno'),
                  'cDesempeno' => $this->input->post('cDesempeno'),

                  'vTitulo' => $this->input->post('vTitulo'),
                  'eTitulo' => $this->input->post('eTitulo'),
                  'dTitulo' => $this->input->post('dTitulo'),
                  'cTitulo' => $this->input->post('cTitulo'),

                  'vAvisoTicket' => $this->input->post('vAvisoTicket'),

                  'vEstudio' => $this->input->post('vEstudio'),
                  'eEstudio' => $this->input->post('eEstudio'),
                  'dEstudio' => $this->input->post('dEstudio'),
                  'cEstudio' => $this->input->post('cEstudio'),

                  'vMenu' => $this->input->post('vMenu'),
                  'eMenu' => $this->input->post('eMenu'),
                  'dMenu' => $this->input->post('dMenu'),
                  'cMenu' => $this->input->post('cMenu'),

                  'vPedido' => $this->input->post('vPedido'),
                  'ePedido' => $this->input->post('ePedido'),
                  'dPedido' => $this->input->post('dPedido'),
                  'cPedido' => $this->input->post('cPedido'),

                  'vTicket' => $this->input->post('vTicket'),
                  'cTicket' => $this->input->post('cTicket'),

                  'vLaboratorio' => $this->input->post('vLaboratorio'),

                  'vManuales' => $this->input->post('vManuales'),

                  'vImporMaquinas' => $this->input->post('vImporMaquinas'),
                  'vImporArticulos' => $this->input->post('vImporArticulos'),
                  'vImporArticulos_maq' => $this->input->post('vImporArticulos_maq'),
                  'vImporMenu' => $this->input->post('vImporMenu'),

                  'vPersonas' => $this->input->post('vPersonas'),
                  'vLicencia' => $this->input->post('vLicencia'),
                  'vCapacitacion' => $this->input->post('vCapacitacion'),
                  'vPremios' => $this->input->post('vPremios'),

                  'vRep_maquinas' => $this->input->post('vRep_maquinas'),
                  'vRep_ticket' => $this->input->post('vRep_ticket'),
                  'vRep_pedido' => $this->input->post('vRep_pedido')

            );
            $sectores = $this->sector_model->get_sector();

            foreach ($sectores as $sector){

                $permisos[str_replace(" ","",str_replace(".","",$sector->descripcion))]=$this->input->post(str_replace(" ","",str_replace(".","",$sector->descripcion)));
            }

            $permisos = serialize($permisos);

            $data = array(
                'nombre' => $nombrePermiso,
                'fecha_registro' => $registro,
                'permisos' => $permisos,
                'estado' => $estado
            );

            if ($this->permisos_model->add('permisos', $data) == TRUE) {
                $acciones = array(
                    'usuario' => $this->session->userdata('id'),
                    'accion_id' => 1,
                    'accion' => 'Agrega el permiso : '.$nombrePermiso.' - '.$permisos,
                    'modulo' => 2,
                    'fecha_registro' => date('Y-m-d h:i:s')
                );

                if ($this->consola_model->add('consola',$acciones) == TRUE){
                    $this->session->set_flashdata('success', 'Permisos agregados con exito!');
                    redirect(base_url() . 'index.php/permisos/agregar/');
                }
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error.</p></div>';
            }
        }
        $this->data['sectores'] = $this->sector_model->get_sector();
        $this->data['view'] = 'permisos/agregarPermiso';
        $this->load->view('tema/header', $this->data);

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
                  'cBackup'  => $this->input->post('cBackup'),

                  'vMaquina' => $this->input->post('vMaquina'),
                  'eMaquina' => $this->input->post('eMaquina'),
                  'dMaquina' => $this->input->post('dMaquina'),
                  'cMaquina' => $this->input->post('cMaquina'),

                  'vFallas' => $this->input->post('vFallas'),
                  'eFallas' => $this->input->post('eFallas'),
                  'dFallas' => $this->input->post('dFallas'),
                  'cFallas' => $this->input->post('cFallas'),

                  'vSala' => $this->input->post('vSala'),
                  'eSala' => $this->input->post('eSala'),
                  'dSala' => $this->input->post('dSala'),
                  'cSala' => $this->input->post('cSala'),

                  'vDesempeno' => $this->input->post('vDesempeno'),
                  'eDesempeno' => $this->input->post('eDesempeno'),
                  'dDesempeno' => $this->input->post('dDesempeno'),
                  'cDesempeno' => $this->input->post('cDesempeno'),

                  'vTitulo' => $this->input->post('vTitulo'),
                  'eTitulo' => $this->input->post('eTitulo'),
                  'dTitulo' => $this->input->post('dTitulo'),
                  'cTitulo' => $this->input->post('cTitulo'),

                  'vAvisoTicket' => $this->input->post('vAvisoTicket'),

                  'vEstudio' => $this->input->post('vEstudio'),
                  'eEstudio' => $this->input->post('eEstudio'),
                  'dEstudio' => $this->input->post('dEstudio'),
                  'cEstudio' => $this->input->post('cEstudio'),

                  'vMenu' => $this->input->post('vMenu'),
                  'eMenu' => $this->input->post('eMenu'),
                  'dMenu' => $this->input->post('dMenu'),
                  'cMenu' => $this->input->post('cMenu'),
<<<<<<< HEAD

=======
                  'vInicioEmpleado' => $this->input->post('vInicioEmpleado'),
                
>>>>>>> 78135b1e18f6bbb996b5ba058a1d6101a538c44b
                  'vPedido' => $this->input->post('vPedido'),
                  'ePedido' => $this->input->post('ePedido'),
                  'dPedido' => $this->input->post('dPedido'),
                  'cPedido' => $this->input->post('cPedido'),

                  'vArticulos' => $this->input->post('vArticulos'),
                  'eArticulos' => $this->input->post('eArticulos'),
                  'dArticulos' => $this->input->post('dArticulos'),
                  'cArticulos' => $this->input->post('cArticulos'),

                  'vCategorias' => $this->input->post('vCategorias'),
                  'eCategorias' => $this->input->post('eCategorias'),
                  'dCategorias' => $this->input->post('dCategorias'),
                  'cCategorias' => $this->input->post('cCategorias'),

                  'vTicket' => $this->input->post('vTicket'),
                  'cTicket' => $this->input->post('cTicket'),

                  'vLaboratorio' => $this->input->post('vLaboratorio'),

                  'vManuales' => $this->input->post('vManuales'),

                  'vImporMaquinas' => $this->input->post('vImporMaquinas'),
                  'vImporArticulos' => $this->input->post('vImporArticulos'),
                  'vImporArticulos_maq' => $this->input->post('vImporArticulos_maq'),
                  'vImporMenu' => $this->input->post('vImporMenu'),

                  'vPersonas' => $this->input->post('vPersonas'),
                  'vLicencia' => $this->input->post('vLicencia'),
                  'vCapacitacion' => $this->input->post('vCapacitacion'),
                  'vPremios' => $this->input->post('vPremios'),

                  'vRep_maquinas' => $this->input->post('vRep_maquinas'),
                  'vRep_ticket' => $this->input->post('vRep_ticket'),
                  'vRep_pedido' => $this->input->post('vRep_pedido'),

            );

            $sectores = $this->sector_model->get_sector();

            foreach ($sectores as $sector){

                $permisos[str_replace(" ","",str_replace(".","",$sector->descripcion))]=$this->input->post(str_replace(" ","",str_replace(".","",$sector->descripcion)));
            }

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
        $this->data['sectores'] = $this->sector_model->get_sector();
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
}


/* End of file permissoes.php */
/* Location: ./application/controllers/permissoes.php */
