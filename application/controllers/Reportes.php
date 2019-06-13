<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
  /** archivos necesarios */
require_once APPPATH . 'libraries/Classes/PHPExcel.php';
require_once APPPATH . 'libraries/Classes/PHPExcel/Reader/Excel2007.php';
class Reportes extends CI_Controller{


    /**
     * author: 
     * 
     */
    
    public function __construct() {
        parent::__construct();
        if( (!session_id()) || (!$this->session->userdata('conectado'))){
          redirect('bingoOasis/login');
        }
        
        $this->load->model('maquinas_model', '', TRUE);
        $this->load->model('fallas_model', '', TRUE);
        $this->load->model('ticket_model', '', TRUE);
        $this->load->model('usuarios_model', '', TRUE);

    }

    public function maquinas(){
        $where = " 1=1 ";
            if($this->input->get('uid')!=''){
                $where .= " AND maquinas.nro_egm  LIKE '%".$this->input->get('uid')."%' ";
            }
            if($this->input->get('modelo')!=''){
                $where .= " AND maquinas.modelo  LIKE '%".$this->input->get('modelo')."%' ";                
            }
            if($this->input->get('fabricante')!=''){
                $where .= " AND maquinas.fabricante LIKE '%".$this->input->get('fabricante')."%' ";
            }
            if($this->input->get('estado')!=''){
                $where .= " AND maquinas.estado = ".$this->input->get('estado');
            }
        
        
        $this->load->library('pagination');
        
            $config['base_url'] = base_url().'index.php/reportes/maquinas/';
            $config['total_rows'] = count($this->maquinas_model->count_Maquinas_fallas($where));
            $config['per_page'] = 25;
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
            $config['page_query_string'] = TRUE;

            $this->pagination->initialize($config); 	
            $this->data['results']=0;
            
            
            //obtiene los datos de las maquinas
            //                                     function getMaquinas_fallas($perpage=0         ,$start=0              ,,$where='')
            $this->data['results'] = $this->maquinas_model->repMaquinas_fallas($config['per_page'],$this->input->get('per_page'),$where);
            $this->data['maquinas'] = $this->maquinas_model->get('maquinas','*',$where=' maquinas.estado !=90 ');
            $this->data['fabricantes'] = $this->maquinas_model->getFabricantes();
            $this->data['modelos'] = $this->maquinas_model->getModelos();
            $this->data['total'] = count($this->maquinas_model->count_Maquinas_fallas($where));
            //obtengo los datos de las fallas en las maquinas
            //$this->data['results_fallas'] = $this->fallas_model->get('fallas','*', ' estado=1');
            //$this->data['fallas'] = $this->fallas_model->get('fallas','*', ' estado=1');

        
            $this->data['view'] = 'reportes/rep_maquinas';
            $this->load->view('tema/header',$this->data);
    }
    
    public function tickets(){
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
            //
            //$where.= ' AND ticket.estado = 1';//por defecto se trae los tickets abiertos
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
        
        
        $this->load->library('pagination');
        
            $config['base_url'] = base_url().'index.php/reportes/tickets/';
            $config['total_rows'] = count($this->ticket_model->get(
                'ticket',
                  'ticket.idTicket,'
                . 'ticket.f_solicitud,'
                . 'ticket.descripcion,'
                . 'usuario_str(ticket.solicita) as solicita,'
                . 'ticket.prioridad,'
                . 'ticket.sector,'
                . 'usuario_str(ticket.idAsignado) as asignado ,'
                . 'referencia_str(ticket.sector,ticket.referencia) as referencia ,'
                . 'ticket.estado',$where));
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
//            $config['page_query_string'] = TRUE;

            	
            
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
            
            $_SESSION['excel_ticket'] = $this->ticket_model->get(
                'ticket',
                  'ticket.idTicket,'
                . 'ticket.f_solicitud,'
                . 'ticket.descripcion,'
                . 'usuario_str(ticket.solicita) as solicita,'
                . 'ticket.prioridad,'
                . 'ticket.sector,'
                . 'usuario_str(ticket.idAsignado) as asignado ,'
                . 'referencia_str(ticket.sector,ticket.referencia) as referencia ,'
                . 'ticket.estado',$where);
            
            //Obtiene el listado de usuarios
            $this->data['results_usuario'] = $this->usuarios_model->get(
                'usuarios','usuarios.idUsuario,usuario.nombre','',$config['per_page'],$this->uri->segment(3));
        
            $this->data['total'] = count($this->data['results']);
            
            
            
            $this->pagination->initialize($config); 
        
            $this->data['view'] = 'reportes/rep_tickets';
            $this->load->view('tema/header',$this->data);
    }
    public function excel_ticket (){
        $this->load->view('reportes/excel/ticket');
    }

    public function personas(){
        $where = " 1=1 ";
//            if($this->input->get('uid')!=''){
//                $where .= " AND maquinas.nro_egm  LIKE '%".$this->input->get('uid')."%' ";
//            }
//            if($this->input->get('modelo')!=''){
//                $where .= " AND maquinas.modelo  LIKE '%".$this->input->get('modelo')."%' ";                
//            }
//            if($this->input->get('fabricante')!=''){
//                $where .= " AND maquinas.fabricante LIKE '%".$this->input->get('fabricante')."%' ";
//            }
//            if($this->input->get('estado')!=''){
//                $where .= " AND maquinas.estado = ".$this->input->get('estado');
//            }
        
        
        $this->load->library('pagination');
        
            $config['base_url'] = base_url().'index.php/reportes/persona/';
            $config['total_rows'] = count($this->persona_model->count_persona($where));
            $config['per_page'] = 25;
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
            $config['page_query_string'] = TRUE;

            $this->pagination->initialize($config); 	
            $this->data['results']=0;
            
            
            //obtiene los datos de las personas
            //                                     function getMaquinas_fallas($perpage=0         ,$start=0              ,,$where='')
            $this->data['results'] = $this->persona_model->repPersona($config['per_page'],$this->input->get('per_page'),$where);
            
        
            $this->data['view'] = 'reportes/rep_personas';
            $this->load->view('tema/header',$this->data);
    }
    
    public function produtos(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de produtos.');
           redirect(base_url());
        }
        $this->data['view'] = 'relatorios/rel_produtos';
       	$this->load->view('tema/topo',$this->data);

    }

    public function maquinasCustom(){
//        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rCliente')){
//           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de clientes.');
//           redirect(base_url());
//        }

//        $dataInicial = $this->input->get('dataInicial');
//        $dataFinal = $this->input->get('dataFinal');
//
//        $data['clientes'] = $this->Relatorios_model->clientesCustom($dataInicial,$dataFinal);
        $data['maquinas'] = "";
        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirClientes', $data);
        $html = $this->load->view('reportes/imprimir/imprimirMaquinas', $data, true);
        pdf_create($html, 'reporte_maquinas' . date('d/m/y'), TRUE);
    
    }

    public function clientesRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de clientes.');
           redirect(base_url());
        }

        $data['clientes'] = $this->Relatorios_model->clientesRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirClientes', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirClientes', $data, true);
        pdf_create($html, 'relatorio_clientes' . date('d/m/y'), TRUE);
    }

    public function produtosRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de produtos.');
           redirect(base_url());
        }

        $data['produtos'] = $this->Relatorios_model->produtosRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirProdutos', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirProdutos', $data, true);
        pdf_create($html, 'relatorio_produtos' . date('d/m/y'), TRUE);
    }

    public function produtosRapidMin(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de produtos.');
           redirect(base_url());
        }

        $data['produtos'] = $this->Relatorios_model->produtosRapidMin();

        $this->load->helper('mpdf');
        $html = $this->load->view('relatorios/imprimir/imprimirProdutos', $data, true);
        pdf_create($html, 'relatorio_produtos' . date('d/m/y'), TRUE);
        
    }

    public function produtosCustom(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de produtos.');
           redirect(base_url());
        }

        $precoInicial = $this->input->get('precoInicial');
        $precoFinal = $this->input->get('precoFinal');
        $estoqueInicial = $this->input->get('estoqueInicial');
        $estoqueFinal = $this->input->get('estoqueFinal');

        $data['produtos'] = $this->Relatorios_model->produtosCustom($precoInicial,$precoFinal,$estoqueInicial,$estoqueFinal);

        $this->load->helper('mpdf');
        $html = $this->load->view('relatorios/imprimir/imprimirProdutos', $data, true);
        pdf_create($html, 'relatorio_produtos' . date('d/m/y'), TRUE);
    }

    public function servicos(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rServico')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de serviços.');
           redirect(base_url());
        }
        $this->data['view'] = 'relatorios/rel_servicos';
       	$this->load->view('tema/topo',$this->data);

    }

    public function servicosCustom(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rServico')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de serviços.');
           redirect(base_url());
        }

        $precoInicial = $this->input->get('precoInicial');
        $precoFinal = $this->input->get('precoFinal');
        $data['servicos'] = $this->Relatorios_model->servicosCustom($precoInicial,$precoFinal);
        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirServicos', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirServicos', $data, true);
        pdf_create($html, 'relatorio_servicos' . date('d/m/y'), TRUE);
    }

    public function servicosRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rServico')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de serviços.');
           redirect(base_url());
        }

        $data['servicos'] = $this->Relatorios_model->servicosRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirServicos', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirServicos', $data, true);
        pdf_create($html, 'relatorio_servicos' . date('d/m/y'), TRUE);
    }

    public function os(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rOs')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de OS.');
           redirect(base_url());
        }
        $this->data['view'] = 'relatorios/rel_os';
       	$this->load->view('tema/topo',$this->data);
    }

    public function osRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rOs')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de OS.');
           redirect(base_url());
        }

        $data['os'] = $this->Relatorios_model->osRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirOs', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirOs', $data, true);
        pdf_create($html, 'relatorio_os' . date('d/m/y'), TRUE);
    }

    public function osCustom(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rOs')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de OS.');
           redirect(base_url());
        }
        
        $dataInicial = $this->input->get('dataInicial');
        $dataFinal = $this->input->get('dataFinal');
        $cliente = $this->input->get('cliente');
        $responsavel = $this->input->get('responsavel');
        $status = $this->input->get('status');
        $data['os'] = $this->Relatorios_model->osCustom($dataInicial,$dataFinal,$cliente,$responsavel,$status);
        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirOs', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirOs', $data, true);
        pdf_create($html, 'relatorio_os' . date('d/m/y'), TRUE);
    }


    public function financeiro(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios financeiros.');
           redirect(base_url());
        }

        $this->data['view'] = 'relatorios/rel_financeiro';
        $this->load->view('tema/topo',$this->data);
    
    }


    public function financeiroRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios financeiros.');
           redirect(base_url());
        }

        $data['lancamentos'] = $this->Relatorios_model->financeiroRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirFinanceiro', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirFinanceiro', $data, true);
        pdf_create($html, 'relatorio_os' . date('d/m/y'), TRUE);
    }

    public function financeiroCustom(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios financeiros.');
           redirect(base_url());
        }

        $dataInicial = $this->input->get('dataInicial');
        $dataFinal = $this->input->get('dataFinal');
        $tipo = $this->input->get('tipo');
        $situacao = $this->input->get('situacao');

        $data['lancamentos'] = $this->Relatorios_model->financeiroCustom($dataInicial,$dataFinal,$tipo,$situacao);
        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirFinanceiro', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirFinanceiro', $data, true);
        pdf_create($html, 'relatorio_financeiro' . date('d/m/y'), TRUE);
    }



    public function vendas(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de vendas.');
           redirect(base_url());
        }

        $this->data['view'] = 'relatorios/rel_vendas';
        $this->load->view('tema/topo',$this->data);
    }

    public function vendasRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de vendas.');
           redirect(base_url());
        }
        $data['vendas'] = $this->Relatorios_model->vendasRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirOs', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirVendas', $data, true);
        pdf_create($html, 'relatorio_vendas' . date('d/m/y'), TRUE);
    }

    public function vendasCustom(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de vendas.');
           redirect(base_url());
        }
        $dataInicial = $this->input->get('dataInicial');
        $dataFinal = $this->input->get('dataFinal');
        $cliente = $this->input->get('cliente');
        $responsavel = $this->input->get('responsavel');

        $data['vendas'] = $this->Relatorios_model->vendasCustom($dataInicial,$dataFinal,$cliente,$responsavel);
        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirOs', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirVendas', $data, true);
        pdf_create($html, 'relatorio_vendas' . date('d/m/y'), TRUE);
    }
    
    
}
