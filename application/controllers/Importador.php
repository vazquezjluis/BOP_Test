<?php
  /** archivos necesarios */
require_once APPPATH . 'libraries/Classes/PHPExcel.php';
require_once APPPATH . 'libraries/Classes/PHPExcel/Reader/Excel2007.php';

class Importador extends CI_Controller {
    

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
          $this->session->set_flashdata('error','Usted no tiene permisos para ver los Importadores del sistema.');
          redirect(base_url());
        }
        
        $this -> load -> helper ( array ( 'form' ,  'url' )); 

//        $this->load->model('laboratorio_model', '', TRUE);
//        $this->load->model('consola_model', '', TRUE);
//        $this->load->model('usuarios_model', '', TRUE);
    }

    function maquinas(){
        $_SESSION['importacion_activa'] = 'maquinas';
        /* Importacion de maquinas*/
        switch ( $this->input->post('tipo')) {
            case 'maquinas':
                //para evitar la recarga de la pagina
                if (isset($_SESSION['filename'])){
                    $this->cancel_import('maquinas');//limpia las sesiones y elimina el archivo temporal
                }
                
                
                $error = '';
                $max_size = 300;
                $file = $_FILES['el_importado']['name'];
                $doc_type = $this->get_type($_FILES['el_importado']['name']);           
		$doc_size = ceil($_FILES['el_importado']['size'] / 1024);
                
                /* valida el tipo de archivo para .xlsx */
                if($doc_type != 'xlsx' ){
                    $error .= 'Por favor seleccione un archivo .xlsx <br/>';
                }
		
                /* valida el peso del archivo */
                if($doc_size > (1024  * $max_size)){
                    $error .= 'El archivo no puede tener mas de 30 MB. \n';
                }
                
                if ($error!=''){
                    $this->session->set_flashdata('error',$error);  
                }else{
                    
                    /* esta variable almacena la ruta del documento */
                    $path =  './assets/archivos/importados/maquinas';
                    
                    /*nombre del archivo*/
                    $expD = explode('-', date('Y-m-d'));$expH = explode(':', date('H:i:s'));
                    $name = $expD[0].$expD[1].$expD[2].$expH[0].$expH[1].$expH[2];
                    $name = 'imp_'.$this->session->userdata('id').'_'.$name.'.'.$doc_type;
                    
                    /* Carga el archivo para ser evaluado*/
                    if ($this->do_upload($name,$path,'csv|xls|xlsx',$max_size,$doc_type == true)){
                        //crea la sesion con la ruta del archivo, si ocurre un error eliminamos el archivo
                        $_SESSION['filename']= $path."/".$name;
                        
                        //valida los encabezados de la primera fila
                        if ($this->valida_encabezado('maquinas',$name,$path,$file)==FALSE){
                            $this->session->set_flashdata('error','Los encabezados son incorrectos, revisa la imagen para ver un ejemplo.');                            
                            $error = 'valida_encabezado';
                            $this->cancel_import('maquinas');
                        }
                        
                        //obtiene los datos
                        if ($this->get_datos_maquinas($name,$path,$file)==false){
                            $this->session->set_flashdata('error',"Ocurrió un error al obtener los datos del archivo excel"); 
                            $error = 'get_datos_maquinas';
                            $this->cancel_import('maquinas');
                        }
                        
                        //valida los datos
                        if ($this->valida_datos_maquina()==false){
                            $this->session->set_flashdata('error',"Ocurrió un error al validar los datos archivo excel"); 
                            $error = 'valida_datos_maquina';
                            $this->cancel_import('maquinas');
                        }
                        
                        //ultimo control de errores
                        if ($error == ''){
                            $this->presubmit_maquinas();
                            $this->data['view'] = 'importador/presubmit_maquinas';
                        }else{
                            $this->data['view'] = 'importador/maquinas';
                        }
                        
                        
                    }  else {
                        $this->session->set_flashdata('error',"Ocurrió un error al subir el archivo para ser analizado"); 
                        $this->data['view'] = 'importador/maquinas';
                        
                    }
                }
                break;

            default:
                $this->data['view'] = 'importador/maquinas';
                break;
        } 
        
        $this->load->view('tema/header',$this->data);
    }
    
    function articulos(){
        $_SESSION['importacion_activa'] = 'articulos';
        $this->load->model('articulo_model', '', TRUE);
        $this->data['results'] = $this->articulo_model->get('articulo_deposito_importacion','*','',false);
        
        /* Importacion de articulos*/
        switch ( $this->input->post('tipo')) {
            case 'articulos':
                //para evitar la recarga de la pagina
                if (isset($_SESSION['filename'])){
                    $this->cancel_import('articulos');//limpia las sesiones y elimina el archivo temporal
                }
                
                
                $error = '';
                $max_size = 300;
                $file = $_FILES['el_importado']['name'];
                $doc_type = $this->get_type($_FILES['el_importado']['name']);           
		$doc_size = ceil($_FILES['el_importado']['size'] / 1024);
                
                /* valida el tipo de archivo para .xlsx */
                if($doc_type != 'xlsx' ){
                    $error .= 'Por favor seleccione un archivo .xlsx <br/>';
                }
		
                /* valida el peso del archivo */
                if($doc_size > (1024  * $max_size)){
                    $error .= 'El archivo no puede tener mas de 30 MB. \n';
                }
                
                if ($error!=''){
                    $this->session->set_flashdata('error',$error);  
                }else{
                    
                    /* esta variable almacena la ruta del documento */
                    $path =  './assets/archivos/importados/articulos';
                    
                    /*nombre del archivo*/
                    $expD = explode('-', date('Y-m-d'));$expH = explode(':', date('H:i:s'));
                    $name = $expD[0].$expD[1].$expD[2].$expH[0].$expH[1].$expH[2];
                    $name = 'imp_'.$this->session->userdata('id').'_'.$name.'.'.$doc_type;
                    
                    /* Carga el archivo para ser evaluado*/
                    if ($this->do_upload($name,$path,'csv|xls|xlsx',$max_size,$doc_type == true)){
                        //crea la sesion con la ruta del archivo, si ocurre un error eliminamos el archivo
                        $_SESSION['filename']= $path."/".$name;
                        
                        //valida los encabezados de la primera fila
                        if ($this->valida_encabezado('articulos',$name,$path,$file)==FALSE){
                            $this->session->set_flashdata('error','Los encabezados son incorrectos, revisa la imagen para ver un ejemplo.');                            
                            $error = 'valida_encabezado';
                            $this->cancel_import('articulos');
                        }
                        
                        //obtiene los datos
                        if ($this->get_datos_articulos($name,$path,$file)==false){
                            $this->session->set_flashdata('error',"Ocurrió un error al obtener los datos del archivo excel"); 
                            $error = 'get_datos_articulos';
                            $this->cancel_import('articulos');
                        }
                        
                        //valida los datos
                        if ($this->valida_datos_articulos()==false){
                            $this->session->set_flashdata('error',"Ocurrió un error al validar los datos archivo excel"); 
                            $error = 'valida_datos_articulos';
                            $this->cancel_import('articulos');
                        }
                        
                        //ultimo control de errores
                        if ($error == ''){
                            $this->presubmit_articulos();
                            $this->data['view'] = 'importador/presubmit_articulos';
                        }else{
                            $this->data['view'] = 'importador/articulos';
                        }
                        
                        
                    }  else {
                        $this->session->set_flashdata('error',"Ocurrió un error al subir el archivo para ser analizado"); 
                        $this->data['view'] = 'importador/articulos';
                        
                    }
                }
                break;

            default:
                $this->data['view'] = 'importador/articulos';
                break;
        } 
        
        $this->load->view('tema/header',$this->data);
    }
    
    function articulos_maquinas(){
        $_SESSION['importacion_activa'] = 'articulos_maquinas';
        $this->load->model('articulo_model', '', TRUE);
        
        
        /* Importacion de articulos*/
        switch ( $this->input->post('tipo')) {
            case 'articulos_maquinas':
                //para evitar la recarga de la pagina
                if (isset($_SESSION['filename'])){
                    $this->cancel_import('articulos_maquinas');//limpia las sesiones y elimina el archivo temporal
                }
                
                
                $error = '';
                $max_size = 300;
                $file = $_FILES['el_importado']['name'];
                $doc_type = $this->get_type($_FILES['el_importado']['name']);           
		$doc_size = ceil($_FILES['el_importado']['size'] / 1024);
                
                /* valida el tipo de archivo para .xlsx */
                if($doc_type != 'xlsx' ){
                    $error .= 'Por favor seleccione un archivo .xlsx <br/>';
                }
		
                /* valida el peso del archivo */
                if($doc_size > (1024  * $max_size)){
                    $error .= 'El archivo no puede tener mas de 30 MB. \n';
                }
                
                if ($error!=''){
                    $this->session->set_flashdata('error',$error);  
                }else{
                    
                    /* esta variable almacena la ruta del documento */
                    $path =  './assets/archivos/importados/articulos_maquinas';
                    
                    /*nombre del archivo*/
                    $expD = explode('-', date('Y-m-d'));$expH = explode(':', date('H:i:s'));
                    $name = $expD[0].$expD[1].$expD[2].$expH[0].$expH[1].$expH[2];
                    $name = 'imp_'.$this->session->userdata('id').'_'.$name.'.'.$doc_type;
                    
                    /* Carga el archivo para ser evaluado*/
                    if ($this->do_upload($name,$path,'csv|xls|xlsx',$max_size,$doc_type == true)){
                        //crea la sesion con la ruta del archivo, si ocurre un error eliminamos el archivo
                        $_SESSION['filename']= $path."/".$name;
                        
                        //valida los encabezados de la primera fila
                        if ($this->valida_encabezado('articulos_maquinas',$name,$path,$file)==FALSE){
                            $this->session->set_flashdata('error','Los encabezados son incorrectos, revisa la imagen para ver un ejemplo.');                            
                            $error = 'valida_encabezado';
                            $this->cancel_import('articulos_maquinas');
                        }
                        
                        //obtiene los datos
                        if ($this->get_datos_articulos_maquinas($name,$path,$file)==false){
                            $this->session->set_flashdata('error',"Ocurrió un error al obtener los datos del archivo excel"); 
                            $error = 'get_datos_articulos';
                            $this->cancel_import('articulos_maquinas');
                        }
                        
                        //valida los datos
                        if ($this->valida_datos_articulos_maquinas()==false){
                            $this->session->set_flashdata('error',"Ocurrió un error al validar los datos archivo excel"); 
                            $error = 'valida_datos_articulos_maquinas';
                            $this->cancel_import('articulos_maquinas');
                        }
                        
                        //ultimo control de errores
                        if ($error == ''){
                            $this->presubmit_articulos_maquinas();
                            $this->data['view'] = 'importador/presubmit_articulos_maquinas';
                        }else{
                            $this->data['view'] = 'importador/articulos_maquinas';
                        }
                        
                        
                    }  else {
                        $this->session->set_flashdata('error',"Ocurrió un error al subir el archivo para ser analizado"); 
                        $this->data['view'] = 'importador/articulos_maquinas';
                        
                    }
                }
                break;

            default:
                $this->data['view'] = 'importador/articulos_maquinas';
                break;
        } 
        
        $this->load->view('tema/header',$this->data);
    }
    
    function persona(){
        $_SESSION['importacion_activa'] = 'persona';
        $this->load->model('persona_model', '', TRUE);
        $this->data['results'] = $this->persona_model->get('persona','*','',false);
        
        /* Importacion de articulos*/
        switch ( $this->input->post('tipo')) {
            case 'persona':
                //para evitar la recarga de la pagina
                if (isset($_SESSION['filename'])){
                    $this->cancel_import('persona');//limpia las sesiones y elimina el archivo temporal
                }
                
                
                $error = '';
                $max_size = 300;
                $file = $_FILES['el_importado']['name'];
                $doc_type = $this->get_type($_FILES['el_importado']['name']);           
		$doc_size = ceil($_FILES['el_importado']['size'] / 1024);
                
                /* valida el tipo de archivo para .xlsx */
                if($doc_type != 'xlsx' ){
                    $error .= 'Por favor seleccione un archivo .xlsx <br/>';
                }
		
                /* valida el peso del archivo */
                if($doc_size > (1024  * $max_size)){
                    $error .= 'El archivo no puede tener mas de 30 MB. \n';
                }
                
                if ($error!=''){
                    $this->session->set_flashdata('error',$error);  
                }else{
                    
                    /* esta variable almacena la ruta del documento */
                    $path =  './assets/archivos/importados/persona';
                    
                    /*nombre del archivo*/
                    $expD = explode('-', date('Y-m-d'));$expH = explode(':', date('H:i:s'));
                    $name = $expD[0].$expD[1].$expD[2].$expH[0].$expH[1].$expH[2];
                    $name = 'imp_'.$this->session->userdata('id').'_'.$name.'.'.$doc_type;
                    
                    /* Carga el archivo para ser evaluado*/
                    if ($this->do_upload($name,$path,'csv|xls|xlsx',$max_size,$doc_type == true)){
                        //crea la sesion con la ruta del archivo, si ocurre un error eliminamos el archivo
                        $_SESSION['filename']= $path."/".$name;
                        
                        //valida los encabezados de la primera fila
                        if ($this->valida_encabezado('persona',$name,$path,$file)==FALSE){
                            $this->session->set_flashdata('error','Los encabezados son incorrectos, revisa la imagen para ver un ejemplo.');                            
                            $error = 'valida_encabezado';
                            $this->cancel_import('articulos');
                        }
                        
                        //obtiene los datos
                        if ($this->get_datos_articulos($name,$path,$file)==false){
                            $this->session->set_flashdata('error',"Ocurrió un error al obtener los datos del archivo excel"); 
                            $error = 'get_datos_persona';
                            $this->cancel_import('articulos');
                        }
                        
                        //valida los datos
                        if ($this->valida_datos_articulos()==false){
                            $this->session->set_flashdata('error',"Ocurrió un error al validar los datos archivo excel"); 
                            $error = 'valida_datos_articulos';
                            $this->cancel_import('articulos');
                        }
                        
                        //ultimo control de errores
                        if ($error == ''){
                            $this->presubmit_articulos();
                            $this->data['view'] = 'importador/presubmit_articulos';
                        }else{
                            $this->data['view'] = 'importador/articulos';
                        }
                        
                        
                    }  else {
                        $this->session->set_flashdata('error',"Ocurrió un error al subir el archivo para ser analizado"); 
                        $this->data['view'] = 'importador/articulos';
                        
                    }
                }
                break;

            default:
                $this->data['view'] = 'importador/articulos';
                break;
        } 
        
        $this->load->view('tema/header',$this->data);
    }
    
    function do_upload($name,$path,$types,$max_size,$type,$max_width = 1024,$max_height = 768) { 
            $config [ 'upload_path' ]           =  $path ; 
            $config [ 'allowed_types' ]         =  $types ; 
            $config [ 'max_size' ]              =  $max_size ; 
            $config [ 'max_width' ]             =  $max_width ; 
            $config [ 'max_height' ]            =  $max_height ;
            $config [ 'file_name' ]             =  $name;

            $this->load->library('upload' , $config );

            if  (  !  $this ->upload ->do_upload ( 'el_importado' )) 
            { 
                    $this->session->set_flashdata('error',$this -> upload -> display_errors ());
                    
            } 
            else 
            { 
                return true;
            } 
    } 
    
    function valida_encabezado($tipo = '',$name,$path,$file){
        //creamos el objeto que debe leer el excel
        $objReader = new PHPExcel_Reader_Excel2007();
        $objPHPExcel = $objReader->load($path."/".$name);

        //número de filas del archivo excel
        $total_rows = $objPHPExcel->getActiveSheet()->getHighestRow();//ejemplo 1,2  
        //numero de columnas
        $total_cols = $objPHPExcel->getActiveSheet()->getHighestColumn();//ejemplo A,B
        
        switch ($tipo){
            case 'maquinas':
                if (trim($objPHPExcel->getActiveSheet()->getCell("A1")->getCalculatedValue())!='Nro. EGM'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("B1")->getCalculatedValue())!='Fabricante'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("C1")->getCalculatedValue())!='Modelo'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("D1")->getCalculatedValue())!='% de Pago'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("E1")->getCalculatedValue())!='Denom.'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("F1")->getCalculatedValue())!='Juego'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("G1")->getCalculatedValue())!='Nro. Serie'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("H1")->getCalculatedValue())!='Programa'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("I1")->getCalculatedValue())!='Credito'){return false;}
                return true;
                break;
            case 'articulos':
                if (trim($objPHPExcel->getActiveSheet()->getCell("A1")->getCalculatedValue())!='stkart_codgen'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("B1")->getCalculatedValue())!='skart_codEle1'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("C1")->getCalculatedValue())!='skart_codEle2'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("D1")->getCalculatedValue())!='skart_codEle3'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("E1")->getCalculatedValue())!='deposito'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("F1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("G1")->getCalculatedValue())!='f_carga_bejerman'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("H1")->getCalculatedValue())!='autor'){return false;}
                
                return true;
                break;
            case 'articulos_maquinas':
                if (trim($objPHPExcel->getActiveSheet()->getCell("A1")->getCalculatedValue())!='nro_egm'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("B1")->getCalculatedValue())!='stkart_codgen'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("C1")->getCalculatedValue())!='skart_codEle1'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("D1")->getCalculatedValue())!='skart_codEle2'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("E1")->getCalculatedValue())!='skart_codEle3'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("F1")->getCalculatedValue())!='cantidad'){return false;}
                
                return true;
                break;
            case 'persona':
                if (trim($objPHPExcel->getActiveSheet()->getCell("A1")->getCalculatedValue())!='id'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("B1")->getCalculatedValue())!='nombre'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("C1")->getCalculatedValue())!='apellido'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("D1")->getCalculatedValue())!=''){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("E1")->getCalculatedValue())!='skart_codEle3'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("F1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("G1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("H1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("I1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("J1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("K1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("L1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("M1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("N1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("O1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("P1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("Q1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("R1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("S1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("T1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("U1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("V1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("W1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("X1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("Y1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("Z1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("AA1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("AB1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("AC1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("AD1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("AE1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("AF1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("AG1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("AH1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("AI1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("AJ1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("AK1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("AL1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("AM1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("AN1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("AO1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("AP1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("AQ1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("AR1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("AS1")->getCalculatedValue())!='cantidad'){return false;}
                if (trim($objPHPExcel->getActiveSheet()->getCell("AT1")->getCalculatedValue())!='cantidad'){return false;}
                
               
                return true;
                break;
            default :
                break;
        }
        return false;
    }
    //*********************
    //FUNCIONES DE MAQUINAS
    function get_datos_maquinas($name,$path,$file){
        
      //creamos el objeto que debe leer el excel
      $objReader = new PHPExcel_Reader_Excel2007();
      $objPHPExcel = $objReader->load($path."/".$name);
 
      //número de filas del archivo excel
      $total_rows = $objPHPExcel->getActiveSheet()->getHighestRow();//ejemplo 1,2  
      //numero de columnas
      $total_cols = $objPHPExcel->getActiveSheet()->getHighestColumn();//ejemplo A,B
      
      //recorre las filas
      for($i = 2; $i <= $total_rows ; $i++){
            
            //guardo los datos en la sesion
            $_SESSION['datos_excel'][$i-2]['nro_egm']     = trim($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()) ;
            $_SESSION['datos_excel'][$i-2]['fabricante']  = trim($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue()) ;
            $_SESSION['datos_excel'][$i-2]['modelo']      = trim($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue()) ;
            $_SESSION['datos_excel'][$i-2]['p_pago']      = trim($objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue()) ;
            $_SESSION['datos_excel'][$i-2]['denom']       = trim($objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue()) ;
            $_SESSION['datos_excel'][$i-2]['juego']       = trim($objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue()) ;
            $_SESSION['datos_excel'][$i-2]['serie']       = trim($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue()) ;
            $_SESSION['datos_excel'][$i-2]['programa']    = trim($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue()) ;
            $_SESSION['datos_excel'][$i-2]['credito']     = trim($objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue()) ;
          
      }
      return true;
        
    }
    
    function valida_datos_maquina(){
        //crea un array para guardar errores
        $_SESSION['errores'] = array();
        $_SESSION['errores']['gral'] = array();
        $_SESSION['errores']['nro_egm'] = array();
        $_SESSION['errores']['nro_egm_length'] = array();
        $_SESSION['errores']['nro_egm_format'] = array();
        $_SESSION['errores']['fabricante_length'] = array();
        $_SESSION['errores']['modelo_length'] = array();
        $_SESSION['errores']['p_pago_length'] = array();
        $_SESSION['errores']['denom_length'] = array();
        $_SESSION['errores']['juego_length'] = array();
        $_SESSION['errores']['serie_length'] = array();
        $_SESSION['errores']['programa_length'] = array();
        $_SESSION['errores']['credito_length'] = array();
        
        for($i = 0; $i < count($_SESSION['datos_excel']); $i++){
            //validacion nro_egm
            if(strlen($_SESSION['datos_excel'][$i]['nro_egm']) != 7 ){
                array_push($_SESSION['errores']['nro_egm_length'], $i);	
                if(!in_array($i, $_SESSION['errores']['gral'])){
                    array_push($_SESSION['errores']['gral'], $i);
                }
            }
            if(!is_numeric($_SESSION['datos_excel'][$i]['nro_egm'])){
                array_push($_SESSION['errores']['nro_egm_format'], $i);
                if(!in_array($i, $_SESSION['errores']['gral'])){
                    array_push($_SESSION['errores']['gral'], $i);
                }
            }
            //validacion fabricante
            if(strlen(trim($_SESSION['datos_excel'][$i]['fabricante'])) == 0 ){
                array_push($_SESSION['errores']['fabricante_length'], $i);	
                if(!in_array($i, $_SESSION['errores']['gral'])){
                    array_push($_SESSION['errores']['gral'], $i);
                }
            }
            //modelo
            if(strlen(trim($_SESSION['datos_excel'][$i]['modelo'])) == 0 ){
                array_push($_SESSION['errores']['modelo_length'], $i);	
                if(!in_array($i, $_SESSION['errores']['gral'])){
                    array_push($_SESSION['errores']['gral'], $i);
                }
            }
            //% de pago
            if(strlen(trim($_SESSION['datos_excel'][$i]['p_pago'])) == 0 ){
                array_push($_SESSION['errores']['p_pago_length'], $i);	
                if(!in_array($i, $_SESSION['errores']['gral'])){
                    array_push($_SESSION['errores']['gral'], $i);
                }
            }
            //Denominacion
            if(strlen(trim($_SESSION['datos_excel'][$i]['denom'])) == 0 ){
                array_push($_SESSION['errores']['denom_length'], $i);	
                if(!in_array($i, $_SESSION['errores']['gral'])){
                    array_push($_SESSION['errores']['gral'], $i);
                }
            }
            //Juego
            if(strlen(trim($_SESSION['datos_excel'][$i]['juego'])) == 0 ){
                array_push($_SESSION['errores']['juego_length'], $i);	
                if(!in_array($i, $_SESSION['errores']['gral'])){
                    array_push($_SESSION['errores']['gral'], $i);
                }
            }
            //Nro_serie
            if(strlen(trim($_SESSION['datos_excel'][$i]['serie'])) == 0 ){
                array_push($_SESSION['errores']['serie_length'], $i);	
                if(!in_array($i, $_SESSION['errores']['gral'])){
                    array_push($_SESSION['errores']['gral'], $i);
                }
            }
            //Programa
            if(strlen(trim($_SESSION['datos_excel'][$i]['programa'])) == 0 ){
                array_push($_SESSION['errores']['programa_length'], $i);	
                if(!in_array($i, $_SESSION['errores']['gral'])){
                    array_push($_SESSION['errores']['gral'], $i);
                }
            }
            //Credito
            if(strlen(trim($_SESSION['datos_excel'][$i]['credito'])) == 0 ){
                array_push($_SESSION['errores']['credito_length'], $i);	
                if(!in_array($i, $_SESSION['errores']['gral'])){
                    array_push($_SESSION['errores']['gral'], $i);
                }
            }
            
            
        }
        return true;
    }
    
    function presubmit_maquinas(){
        $html = '';
        $this->data['result']= array();
       
        if (count($_SESSION['errores']['gral'])){
            foreach($_SESSION['errores']['gral'] as $gral){
                //numero de EGM
                if(in_array($gral, $_SESSION['errores']['nro_egm_format']) 
                    or in_array($gral, $_SESSION['errores']['nro_egm_length'])){
                    $html.= $this->create_update($gral,'text','nro_egm','nro_egm');
                }
                //Fabricante
                if(in_array($gral, $_SESSION['errores']['fabricante_length'])){
                    $html.= $this->create_update($gral,'text','fabricante','fabricante');
                }
                //Modelo
                if(in_array($gral, $_SESSION['errores']['modelo_length'])){
                    $html.= $this->create_update($gral,'text','modelo','modelo');
                }
                //% de pago
                if(in_array($gral, $_SESSION['errores']['p_pago_length'])){
                    $html.= $this->create_update($gral,'text','p_pago','p_pago');
                }
                //Denom
                if(in_array($gral, $_SESSION['errores']['denom_length'])){
                    $html.= $this->create_update($gral,'text','denom','denom');
                }
                //Juego
                if(in_array($gral, $_SESSION['errores']['juego_length'])){
                    $html.= $this->create_update($gral,'text','juego','juego');
                }
                //Serie
                if(in_array($gral, $_SESSION['errores']['serie_length'])){
                    $html.= $this->create_update($gral,'text','serie','serie');
                }
                //Programa
                if(in_array($gral, $_SESSION['errores']['programa_length'])){
                    $html.= $this->create_update($gral,'text','programa','programa');
                }
                //Credito
                if(in_array($gral, $_SESSION['errores']['credito_length'])){
                    $html.= $this->create_update($gral,'text','credito','credito');
                }
            }
            $this->data['html'] = $html;
        }else{
            $this->data['result'] = $this->previo_importacion('maquinas');
        }
    }
    
    //*********************
    //FUNCIONES ARTICULOS
    function get_datos_articulos($name,$path,$file){
      
    //creamos el objeto que debe leer el excel
      $objReader = new PHPExcel_Reader_Excel2007();
      $objPHPExcel = $objReader->load($path."/".$name);
 
      //número de filas del archivo excel
      $total_rows = $objPHPExcel->getActiveSheet()->getHighestRow();//ejemplo 1,2  
      //numero de columnas
      $total_cols = $objPHPExcel->getActiveSheet()->getHighestColumn();//ejemplo A,B
      
      //recorre las filas
      for($i = 2; $i <= $total_rows ; $i++){
            
            //guardo los datos en la sesion
            $_SESSION['datos_excel'][$i-2]['stkart_codgen']   = trim($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()) ;
            $_SESSION['datos_excel'][$i-2]['skart_codEle1']   = trim($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue()) ;
            $_SESSION['datos_excel'][$i-2]['skart_codEle2']   = trim($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue()) ;
            $_SESSION['datos_excel'][$i-2]['skart_codEle3']   = trim($objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue()) ;
            $_SESSION['datos_excel'][$i-2]['deposito']        = trim($objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue()) ;
            $_SESSION['datos_excel'][$i-2]['cantidad']        = trim($objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue()) ;
            $_SESSION['datos_excel'][$i-2]['f_carga_bejerman']= trim($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue()) ;
            $_SESSION['datos_excel'][$i-2]['autor']           = trim($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue()) ;
            
          
      }
      return true;
      
    }
    
    function valida_datos_articulos(){
        //crea un array para guardar errores
        $_SESSION['errores'] = array();
        $_SESSION['errores']['gral'] = array();
        $_SESSION['errores']['stkart_codgen_length'] = array();
        $_SESSION['errores']['cantidad_length'] = array();
        
        for($i = 0; $i < count($_SESSION['datos_excel']); $i++){
            
            //validacion stkart_codgen
            if(strlen(trim($_SESSION['datos_excel'][$i]['stkart_codgen'])) == 0 ){
                array_push($_SESSION['errores']['stkart_codgen_length'], $i);	
                if(!in_array($i, $_SESSION['errores']['gral'])){
                    array_push($_SESSION['errores']['gral'], $i);
                }
            }
            //validacion cantidad
            if(strlen(trim($_SESSION['datos_excel'][$i]['cantidad'])) == 0 ){
                array_push($_SESSION['errores']['cantidad_length'], $i);	
                if(!in_array($i, $_SESSION['errores']['gral'])){
                    array_push($_SESSION['errores']['gral'], $i);
                }
            }
            
        }
        return true;
    }
    
    function presubmit_articulos(){
        $html = '';
        $this->data['result']= array();
       
        if (count($_SESSION['errores']['gral'])){
            foreach($_SESSION['errores']['gral'] as $gral){
                
                //Cantidad
                if(in_array($gral, $_SESSION['errores']['cantidad_length'])){
                    $html.= $this->create_update($gral,'text','cantidad','cantidad');
                }
                //stkart_codgen
                if(in_array($gral, $_SESSION['errores']['stkart_codgen_length'])){
                    $html.= $this->create_update($gral,'text','stkart_codgen','stkart_codgen');
                }
                
            }
            $this->data['html'] = $html;
        }else{
            $this->data['result'] = $this->previo_importacion('articulos');
        }
    }
    
    //*********************
    //FUNCIONES ARTICULOS A MAQUINAS
    function get_datos_articulos_maquinas($name,$path,$file){
      
    //creamos el objeto que debe leer el excel
      $objReader = new PHPExcel_Reader_Excel2007();
      $objPHPExcel = $objReader->load($path."/".$name);
 
      //número de filas del archivo excel
      $total_rows = $objPHPExcel->getActiveSheet()->getHighestRow();//ejemplo 1,2  
      //numero de columnas
      $total_cols = $objPHPExcel->getActiveSheet()->getHighestColumn();//ejemplo A,B
      
      //recorre las filas
      for($i = 2; $i <= $total_rows ; $i++){
            
            //guardo los datos en la sesion
            $_SESSION['datos_excel'][$i-2]['nro_egm']   = trim($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()) ;
            $_SESSION['datos_excel'][$i-2]['cod_articulo']   =  trim($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue()).
                                                                trim($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue()).
                                                                trim($objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue()).
                                                                trim($objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue());            
            $_SESSION['datos_excel'][$i-2]['cantidad']   = trim($objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue()) ;
            
          
      }
      return true;
      
    }
    
    function valida_datos_articulos_maquinas(){
        //crea un array para guardar errores
        $_SESSION['errores'] = array();
        $_SESSION['errores']['gral'] = array();
        $_SESSION['errores']['nro_egm_length'] = array();
        $_SESSION['errores']['nro_egm_format'] = array();
        $_SESSION['errores']['cod_articulo_length'] = array();
        $_SESSION['errores']['cantidad_length'] = array();
        $_SESSION['errores']['cantidad_format'] = array();
        
        
        for($i = 0; $i < count($_SESSION['datos_excel']); $i++){
            
            //valida datos del nro_egm
            if(strlen($_SESSION['datos_excel'][$i]['nro_egm']) != 7 ){
                array_push($_SESSION['errores']['nro_egm_length'], $i);	
                if(!in_array($i, $_SESSION['errores']['gral'])){
                    array_push($_SESSION['errores']['gral'], $i);
                }
            }
            if(!is_numeric($_SESSION['datos_excel'][$i]['nro_egm'])){
                array_push($_SESSION['errores']['nro_egm_format'], $i);
                if(!in_array($i, $_SESSION['errores']['gral'])){
                    array_push($_SESSION['errores']['gral'], $i);
                }
            }
            
            
            //validacion del codigo de articulo
            if(strlen($_SESSION['datos_excel'][$i]['cod_articulo']) == 0 ){
                array_push($_SESSION['errores']['cod_articulo_length'], $i);	
                if(!in_array($i, $_SESSION['errores']['gral'])){
                    array_push($_SESSION['errores']['gral'], $i);
                }
            }
            
            //validacion cantidad
            if(strlen(trim($_SESSION['datos_excel'][$i]['cantidad'])) == 0 ){
                array_push($_SESSION['errores']['cantidad_length'], $i);	
                if(!in_array($i, $_SESSION['errores']['gral'])){
                    array_push($_SESSION['errores']['gral'], $i);
                }
            }
            if(!is_numeric($_SESSION['datos_excel'][$i]['cantidad'])){
                array_push($_SESSION['errores']['cantidad_format'], $i);
                if(!in_array($i, $_SESSION['errores']['gral'])){
                    array_push($_SESSION['errores']['gral'], $i);
                }
            }
            
        }
        return true;
    }
    
    function presubmit_articulos_maquinas(){
        $html = '';
        $this->data['result']= array();
       
        if (count($_SESSION['errores']['gral'])){
            foreach($_SESSION['errores']['gral'] as $gral){
                //numero de EGM
                if(in_array($gral, $_SESSION['errores']['nro_egm_format']) 
                    or in_array($gral, $_SESSION['errores']['nro_egm_length'])){
                    $html.= $this->create_update($gral,'text','nro_egm','nro_egm');
                }
                
                //Cantidad
                if(in_array($gral, $_SESSION['errores']['cantidad_length']) 
                    or in_array($gral, $_SESSION['errores']['cantidad_format'])){
                    $html.= $this->create_update($gral,'text','cantidad','cantidad');
                }
                //codigo de articulo
                if(in_array($gral, $_SESSION['errores']['cod_articulo_length'])){
                    $html.= $this->create_update($gral,'text','cod_articulo','cod_articulo');
                }
                //numero de serie
                if(in_array($gral, $_SESSION['errores']['nro_serie_length'])){
                    $html.= $this->create_update($gral,'text','nro_serie','nro_serie');
                }
                
            }
            $this->data['html'] = $html;
        }else{
            $this->data['result'] = $this->previo_importacion('articulos_maquinas');
        }
    }
    
    //funcion para crear campos para edicion
    function create_update($row, $_type, $field, $field_name){
        $html='<tr><td>';
        $celda = $row+2;
	switch ($_type){
		case 'date':
//			if(in_array($row, $_SESSION['errors'][$field.'_format']))
//						echo 'El formato de la '.$field_name.' no es valido (dd/mm/aaaa)<br/>';
//                        
//			if(in_array($row, $_SESSION['errors'][$field.'_logic']))
//						echo 'La fecha en '.$field_name.' seleccionada es inexistente';
//                        if($f_egreso!="")
//                            echo $f_egreso."<br>";
//                        
//                        if($f_diff_egreso_mayor!="")
//                            echo $f_diff_egreso_mayor."<br>";
			
		break;
                
                case 'datetime':
//			if(in_array($row, $_SESSION['errors'][$field.'_format']))
//						echo 'El formato de la '.$field_name.' no es valido (dd/mm/aaaa 00:00:00)<br/>';
//                        
//			if(in_array($row, $_SESSION['errors'][$field.'_logic']))
//						echo 'La fecha en '.$field_name.' seleccionada es inexistente';
//                        if($f_egreso!="")
//                            echo $f_egreso."<br>";
//                        
//                        if($f_diff_egreso_mayor!="")
//                            echo $f_diff_egreso_mayor."<br>";
			
		break;
                
		case 'text':
                    
                    if(isset($_SESSION['errores'][$field.'_format'])){
			if(in_array($row, $_SESSION['errores'][$field.'_format'])){
                            $html.='El '.$field_name.' contiene caracteres invalidos. Fila  '.$celda.'<br/>';
                        }
                    }
                    if(isset($_SESSION['errores'][$field.'_length'])){
                        if(in_array($row, $_SESSION['errores'][$field.'_length'])){
                            $html.='La cantidad de caracteres del '.$field_name.' no corresponde. Fila '.$celda.' <br>';
                        }
                    }
		break;
		case 'numeric':
//			if((in_array($row, $_SESSION['errors'][$field]) and strlen($_SESSION['file_data'][$row][$field]) > 0 and $field != 'nro_documento') or  $field == 'nro_documento' and strlen($_SESSION['file_data'][$row][$field]) > 5):
//				echo 'El '.$field_name.' no es del formato/largo esperado.<br/>';	
//			elseif($field == 'nro_documento' and strlen($_SESSION['file_data'][$row][$field]) < 6):		
//				echo 'El '.$field_name.' es demasiado corto.<br/>';	
//			endif;
//			if(strlen($_SESSION['file_data'][$row][$field]) == 0 and $field != 'recien_nacido')
//				echo 'No ha ingresado un '.$field_name;
//			elseif($field == 'recien_nacido' and strlen($_SESSION['file_data'][$row][$field]) == 0 )
//				echo 'Es recien nacido? (1 para si, 0 para no)';
//			if(isset( $_SESSION['errors'][$field.'_logic'])):
//				if(in_array($row, $_SESSION['errors'][$field.'_logic'])):
//					echo 'El campo '.$field_name.' debe tener caracteres numericos';
//				endif;
//			endif;
		break;
        }
	$html.= '</td><td><input type="text" required="required" value="'.$_SESSION['datos_excel'][$row][$field].'" id="'.$field.'['.$row.'][]" name="'.$field.'['.$row.'][]"/></td>';
       
        return $html;
    }

    function previo_importacion($tipo){
        $identicos = 0;
        $distintos = 0;
        $nuevos    = 0;
        $bajas     = 0;
        $str_distinto = '';
        $return = array();
        switch ($tipo){
            case "maquinas":
                    //verifica cuales son los registros distintos, iguales o nuevos en el archivo
                    if (count($_SESSION['datos_excel'])){
                        
                        foreach($_SESSION['datos_excel'] as $k=> $datos){
                           
                            if ($this->get_nuevos_iguales("maquinas",$datos['nro_egm'],$datos['serie'],$datos,$k)!=''){
                                $str_distinto.= $this->get_nuevos_iguales("maquinas",$datos['nro_egm'],$datos['serie'],$datos,$k);
                                $distintos ++;
                                $_SESSION['update_import'][$k]['fabricante']  = $datos['fabricante'];
                                $_SESSION['update_import'][$k]['modelo']      = $datos['modelo'];
                                $_SESSION['update_import'][$k]['p_pago']      = $datos['p_pago'];
                                $_SESSION['update_import'][$k]['denom']       = $datos['denom'];
                                $_SESSION['update_import'][$k]['juego']       = $datos['juego'];
                                $_SESSION['update_import'][$k]['programa']    = $datos['programa'];
                                $_SESSION['update_import'][$k]['credito']     = $datos['credito'];
                                $_SESSION['update_import'][$k]['nro_egm']     = $datos['nro_egm'];
                                $_SESSION['update_import'][$k]['nro_serie']     = $datos['serie'];
                            }else{
                                $identicos ++;
                            }
                        }
                        
                        
                    }else{
                        //die()
                    }
                    
                    //verifica que maquina de la base de datos no figura en el excel
                    //en tal caso la maquina cambia de estado a fuera de servicio
                    $this->load->model('maquinas_model', '', TRUE);
                    $maquinas = $this->maquinas_model->get('maquinas','*','');
                    if (count($maquinas)){
                        
                        foreach ($maquinas as $mi_maquina){
                            $baja = 0;
                            foreach($_SESSION['datos_excel'] as $k=> $datos){
                                if($mi_maquina->nro_egm == $datos['nro_egm'] and 
                                        $mi_maquina->nro_serie == $datos['serie']){
                                 //si existe entonces no se encuentra de baja
                                 $baja = 1;   
                                }
                            }
                            if ($baja == 0){
                                $_SESSION['delete_import'][]=$mi_maquina->nro_egm;
                            }
                        }
                    }
                    
                    
                    if(isset($_SESSION['new_import'])){
                        $nuevos = count($_SESSION['new_import']);
                    }
                    if(isset($_SESSION['delete_import'])){
                        $bajas = count($_SESSION['delete_import']);
                    }
                    
                    $return = array(
                            'str_ditintos' => $str_distinto,
                            'distintos' => $distintos,
                            'identicos' => $identicos,
                            'nuevos' => $nuevos,
                            'bajas' => $bajas,
                            'total' => count($_SESSION['datos_excel'])
                        );
                    return  $return;
            break;
            case "articulos":
                    //verifica cuales son los registros distintos, iguales o nuevos en el archivo
                    
                    if (count($_SESSION['datos_excel'])){
                        $this->load->model('stock_bejerman_model', '', TRUE);
                        //El primer ciclo guarda los datos en la tabla de bejerman
                        $this->stock_bejerman_model->delete_all('stock_bejerman');
                        
                        foreach($_SESSION['datos_excel'] as $k=> $datos){
                            //guardamos los datos en la tabla de bejerman
                            $data = array(
                                'stkart_codgen' => $datos["stkart_codgen"],
                                'skart_codEle1' => $datos["skart_codEle1"],
                                'skart_codEle2' => $datos["skart_codEle2"],
                                'skart_codEle3' => $datos["skart_codEle3"],
                                'deposito' => $datos["deposito"],
                                'cantidad' => $datos["cantidad"],
                                'f_carga_bejerman' => $datos["f_carga_bejerman"],
                                'autor' => $datos["autor"],
                            );
                            if ($this->stock_bejerman_model->add('stock_bejerman', $data)) {
                                //agregado con exito    
                            }else{
                                //$errores[] = $datos['nro_egm'];
                            }
                        }
                        //una ves guardados los articulos
                        //obtengo los articulos desde la tabla agrupando por el codigo de referencia
                        $articulos_cantidad = $this->stock_bejerman_model->get_articulos_cantidad('stock_bejerman');
                        
                        foreach ($articulos_cantidad as $art_cant){
                            $codigos = array( 
                                $art_cant->stkart_codgen,
                                $art_cant->skart_codEle1,
                                $art_cant->skart_codEle2,
                                $art_cant->skart_codEle3
                                
                                );
                            $str_distinto.= $this->get_nuevos_iguales("articulos",$art_cant->codigo,$art_cant->cantidad,$codigos);
                            if ($str_distinto!=''){
                                $distintos ++;
                            }else{
                                $identicos ++;
                            }
                        }
                        
                    }else{
                        //die()
                    }
                    
                    if(isset($_SESSION['new_import'])){
                        $nuevos = count($_SESSION['new_import']);
                    }
                    if(isset($_SESSION['update_import'])){
                        $distintos = count($_SESSION['update_import']);
                    }
                    $return = array(
                            'str_ditintos' => $str_distinto,
                            'distintos' => $distintos,
                            'identicos' => $identicos,
                            'nuevos' => $nuevos,
                            'total' => count($articulos_cantidad)
                        );
                    return  $return;
            break;
            case "articulos_maquinas";
                //verifica cuales son los registros distintos, iguales o nuevos en el archivo
                if (count($_SESSION['datos_excel'])){
                    foreach($_SESSION['datos_excel'] as $k=> $datos){
                        $str_distinto.= $this->get_nuevos_iguales("articulos_maquinas",$datos['nro_egm'],$datos['cod_articulo'],$datos,$k);
                        if ($str_distinto!=''){
                            $distintos ++;
                        }else{
                            $identicos ++;
                        }
                    }
                }else{
                    //die()
                }
                    
                    
                    
                if(isset($_SESSION['new_import'])){
                    $nuevos = count($_SESSION['new_import']);
                }
//                if(isset($_SESSION['delete_import'])){
//                    $bajas = count($_SESSION['delete_import']);
//                }

                $return = array(
                        'str_ditintos' => $str_distinto,
                        'distintos' => $distintos,
                        'identicos' => $identicos,
                        'nuevos' => $nuevos,
                        'bajas' => $bajas,
                        'total' => count($_SESSION['datos_excel'])
                    );
                return  $return;
            break;
            default :
                break;
        }
    }
    
    function get_nuevos_iguales($tipo,$dato1='',$dato2='',$array = array(),$key=''){
        $tabla = '';
        $distinto = '';
        switch ($tipo){
            case "maquinas":
                    $this->load->model('maquinas_model', '', TRUE);
                    $maquinas = $this->maquinas_model->get('maquinas','*',' nro_egm = "'.$dato1.'" and nro_serie ="'.$dato2.'"');
                    
                    //registro existente
                    if (count($maquinas)){
                        if (trim($maquinas[0]->fabricante) != trim($array['fabricante'])){
                            $distinto.=" <tr><td> Fabricante </td> <td>".$maquinas[0]->fabricante." </td> <td> ".$array['fabricante']."</td></tr>";
                        }
                        if (trim($maquinas[0]->modelo) != trim($array['modelo'])){
                            $distinto.=" <tr><td> Modelo </td> <td>".$maquinas[0]->modelo." </td> <td> ".$array['modelo']."</td></tr>";
                        }
                        if (trim($maquinas[0]->p_pago) != trim($array['p_pago'])){
                            $distinto.=" <tr><td> % de Pago </td> <td>".$maquinas[0]->p_pago." </td> <td> ".$array['p_pago']."</td></tr>";
                        }
                        if (trim($maquinas[0]->denom) != trim($array['denom'])){
                            $distinto.=" <tr><td> Denom. </td> <td>".$maquinas[0]->denom." </td> <td> ".$array['denom']."</td></tr>";
                        }
                        if (trim($maquinas[0]->juego) != trim($array['juego'])){
                            $distinto.=" <tr><td> Juego </td> <td>".$maquinas[0]->juego." </td> <td> ".$array['juego']."</td></tr>";
                        }
                        if (trim($maquinas[0]->programa) != trim($array['programa'])){
                            $distinto.=" <tr><td> Programa </td> <td>".$maquinas[0]->programa." </td> <td> ".$array['programa']."</td></tr>";
                        }
                        if (trim($maquinas[0]->credito) != trim($array['credito'])){
                            $distinto.=" <tr><td> Credito</td> <td>".$maquinas[0]->credito."</td> <td>".$array['credito']."</td></tr>";
                        }
                        if($distinto !=''){
                            $tabla = '<table cellpadding="4"   style="width:60%;margin-left:3%;margin-bottom:1%;" border="1">
                                        <tr>
                                            <td colspan="3">#<b>Maquina '.$maquinas[0]->nro_egm.'</b></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Actual</td>
                                            <td>Nuevo</td>
                                        </tr>'.$distinto.'</table>';
                            return $tabla;
                        }
                        
                    }
                    //nuevo registro
                    else{
                        $_SESSION['new_import'][$key]['nro_egm']    = $dato1;
                        $_SESSION['new_import'][$key]['fabricante'] = $array['fabricante'];
                        $_SESSION['new_import'][$key]['modelo']     = $array['modelo'];
                        $_SESSION['new_import'][$key]['p_pago']     = $array['p_pago'];
                        $_SESSION['new_import'][$key]['denom']      = $array['denom'];
                        $_SESSION['new_import'][$key]['juego']      = $array['juego'];
                        $_SESSION['new_import'][$key]['nro_serie']  = $dato2;
                        $_SESSION['new_import'][$key]['programa']   = $array['programa'];
                        $_SESSION['new_import'][$key]['credito']    = $array['credito'];
                    }
                    //
                break;
            case "articulos":
                    $this->load->model('articulo_model', '', TRUE);
                    $this->load->model('stock_bejerman_model', '', TRUE);
                    $this->load->model('laboratorio_model', '', TRUE);
                    $this->load->model('articulos_maquinas_model', '', TRUE);
                    
                    $codigo_interno = $dato1;
                    $cantidad = $dato2;
                    //obtengo los articulos con el mismo codigo interno
                    $articulos = $this->articulo_model->get('articulos','*',' codigo = "'.$codigo_interno.'" ');
                    
                    //registro existente
                    if (count($articulos)){
                        $stock_sistema = 0;
                        //obtengo las cantidades del articulo en las otras locaciones
                        //maquinas y laboratorio
                        $laboratorio = $this->laboratorio_model->get('articulos_laboratorio','*',' articulo = '.$articulos[0]->idArticulo);
                        $maquinas = $this->articulos_maquinas_model->get('articulos_maquinas','*',' articulo = '.$articulos[0]->idArticulo);
                        if (count($laboratorio)){
                            foreach ($laboratorio as $lab){
                                $stock_sistema = $stock_sistema + $lab->cantidad;
                            }
                        }
                        if (count($maquinas)){
                            foreach ($maquinas as $maq){
                                $stock_sistema = $stock_sistema + $maq->cantidad;
                            }
                        }
                        $stock_sistema = $stock_sistema + $articulos[0]->stock;
                        
                        if ($stock_sistema != trim($cantidad)){
                            $distinto.=" <tr><td> Cantidad </td> <td>".$stock_sistema." </td> <td> ".$cantidad."</td></tr>";
                        }
                        
                        if($distinto !=''){
                            $tabla = '<table cellpadding="4"   style="width:60%;margin-left:3%;margin-bottom:1%;" border="1">
                                        <tr>
                                            <td colspan="3"># Cod - Articulo <b>'.$array[0].' '.$array[1].' '.$array[2].' '.$array[3].'</b></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Actual (stock + maquinas + laboratorio)</td>
                                            <td>Nuevo del archivo excel</td>
                                        </tr>'.$distinto.'</table>';
                            
                            $diferencia = $cantidad - $stock_sistema;
                            $nuevo_stock = $articulos[0]->stock + $diferencia;

                            $_SESSION['update_import'][$articulos[0]->idArticulo]  = $nuevo_stock;
                            
                            return $tabla;
                            
                        }
                        
                        
                    }
                    //nuevo registro
                    else{
                        $_SESSION['new_import'][$codigo_interno]  = $cantidad.'#'.$array[0].'-'.$array[1].'-'.$array[2].'-'.$array[3];
                        
                    }
                    //
                break;
            case "articulos_maquinas":
                    $this->load->model('articulos_maquinas_model', '', TRUE);
                    $this->load->model('articulo_model', '', TRUE);
                    
                    $uid = $dato1;
                    $cod_articulo = $dato2;
                    
                    //obtengo el articulo con el mismo codigo
                    $articulo = $this->articulo_model->get("articulos","*"," articulos.codigo = '".$cod_articulo."' ");
                    
                    //cuenta si existe el articulo
                    if (count($articulo)){
                        
                        $id_articulo = $articulo[0]->idArticulo ;
                        
                        $articulos_maquinas = $this->articulos_maquinas_model->get('articulos_maquinas','*',' articulo = '.$id_articulo.' and maquina =  '.$uid.' AND estado = 0 ');
                        
                        
//                        if (count($articulos_maquinas)){
//                            $id_registro = $articulos_maquinas[0]->idArticuloMaquina;
//                            $cantidad_en_maquina = $articulos_maquinas[0]->cantidad;
//                            if ($cantidad_en_maquina != trim($array['cantidad'])){
//                                $distinto.=" <tr><td> Cantidad </td> <td>".$cantidad_en_maquina." </td> <td> ".$array['cantidad']."</td></tr>";
//                            }
//                            if($distinto !=''){
//                                $tabla = '<table cellpadding="4"   style="width:60%;margin-left:3%;margin-bottom:1%;" border="1">
//                                            <tr>
//                                                <td colspan="3"># Maquina <b>'.$uid.'</b> -> Articulo <b>'.$cod_articulo.'</b></td>
//                                            </tr>
//                                            <tr>
//                                                <td></td>
//                                                <td>Actual</td>
//                                                <td>Nuevo del archivo excel</td>
//                                            </tr>'.$distinto.'</table>';
//                            
//                                $diferencia = $cantidad_en_maquina - $array['cantidad'];
//                                if ($diferencia<0){
//                                    $diferencia = abs($diferencia);
//                                }
//
//                                //verificamos si la diferencia es suficiente en el stock
//                                if ($articulo[0]->stock >= $diferencia){
//                                    $nuevo_stock = $articulo[0]->stock - $diferencia;
//                                    $data_articulo = array (
//                                        "stock" => $nuevo_stock
//                                    );
//                                    //modificamos el stock 
//                                    if ($this->articulo_model->edit('articulos',$data_articulo,'idArticulo',$articulo[0]->idArticulo)){
//                                        //ok
//                                    }else{/* error*/}
//                                }
//                                $_SESSION['update_import'][$id_registro]  = $array['cantidad'];                            
//                                return $tabla;
//                            }
//                        }
//                        //nuevo registro
//                        else{
                            $_SESSION['new_import'][$key]['maquina']  = $array['nro_egm'];
                            $_SESSION['new_import'][$key]['articulo'] = $cod_articulo;
                            $_SESSION['new_import'][$key]['nombre']   = $articulo[0]->nombre;
                            $_SESSION['new_import'][$key]['cantidad'] = $array['cantidad'];
//                        }
                    }
                    //
                break;    
            default :
                break;
        }
    }
    
//            function index(){
//        $this->gestionar();
//    }

    function cancel_import($tipo=''){
        unset($_SESSION['datos_excel']);
        unset($_SESSION['errores']);
        unset($_SESSION['update_import']);
        unset($_SESSION['new_import']);
        unset($_SESSION['delete_import']);
        if(unlink($_SESSION['filename'])==false){
            die('Ocurrio un error al eliminar el archivo '.$filename.' comuniquese con el administrador para resolver el problema.');
        };
        unset($_SESSION['filename']);
        
        if ($tipo==''){
            $tipo = $_SESSION['importacion_activa'];
        }
        unset($_SESSION['importacion_activa']);
        
        switch ($tipo) {
            case "maquinas":
                redirect(base_url().'index.php/Importador/maquinas/');
                
                break;
            case "articulos":
                redirect(base_url().'index.php/Importador/articulos/');

                break;
            case "articulos_maquinas":
                redirect(base_url().'index.php/Importador/articulos_maquinas/');

                break;

            default:
                break;
        } 
        //redirect(base_url().'index.php/Importador/maquinas/');
    }
    
    function importar(){
        switch ($this->input->post('tipo')){
            case "maquinas":
                $success_update = 0;
                $success_bajas = 0;
                $success_nuevos = 0;
                $errores = array();
                $this->load->model('maquinas_model', '', TRUE);
                
                //modificaciones
                if (isset($_SESSION['update_import']) and count($_SESSION['update_import'])){
                    
                    foreach ($_SESSION['update_import'] as $datos){
                        $data = array(
                            'fabricante' => $datos["fabricante"],
                            'modelo' => $datos["modelo"],
                            'p_pago' => $datos["p_pago"],
                            'denom' => $datos["denom"],
                            'juego' => $datos["juego"],
                            'programa' => $datos["programa"],
                            'credito' => $datos["credito"],
                        );

                        if ($this->maquinas_model->edit_import('maquinas', $data, 'nro_egm = '.$datos['nro_egm'].' AND nro_serie = "'.$datos['nro_serie'].'"') == TRUE) {
                             $success_update ++;
                        }
                        else{
                            $errores[] = $datos['nro_egm'];
                        }    
                    }    
                } 
                //bajas
                if (isset($_SESSION['delete_import']) and count($_SESSION['delete_import'])){
                    
                    foreach ($_SESSION['delete_import'] as $datos){
                        $data = array(
                            "estado" =>0//fuera de servicio
                        );
                        if ($this->maquinas_model->edit_import('maquinas', $data, 'nro_egm = '.$datos) == TRUE) {
                             $success_bajas ++;
                        }
                        else{
                            $errores[] = $datos['nro_egm'];
                        }    
                    }    
                }
                //nuevos
                if (isset($_SESSION['new_import']) and count($_SESSION['new_import'])){
                    
                    foreach ($_SESSION['new_import'] as $datos){
                        $data = array(
                                'nro_egm' => $datos['nro_egm'],
                                'fabricante' => $datos['fabricante'],
                                'modelo' => $datos['modelo'],
                                'p_pago' => $datos['p_pago'],
                                'denom' => $datos['denom'],
                                'juego' => $datos['juego'],
                                'nro_serie' => $datos['nro_serie'],
                                'programa' => $datos['programa'],
                                'credito' => $datos['credito'],
                                'estado' => 1
                        );
           
                        if ($this->maquinas_model->add('maquinas',$data) == TRUE){

                            $success_nuevos ++;
                        }
                        else{
                            $errores[] = $datos['nro_egm'];
                        }    
                    }    
                }
                
                if (count($errores)){
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocurrio un error al importar los UID '. implode(",",$errores).'.</p></div>';
                }
                $this->session->set_flashdata('success', '
                        <strong>'.$success_update.'</strong> registros modificados <br>
                        <strong>'.$success_nuevos.'</strong> registros nuevos <br>
                        <strong>'.$success_bajas.'</strong> registros pasados a fuera de servicio <br>
                        ');
                    
                
                unset($_SESSION['datos_excel']);
                unset($_SESSION['errores']);
                unset($_SESSION['update_import']);
                unset($_SESSION['new_import']);
                unset($_SESSION['delete_import']);
                redirect(base_url() . 'index.php/Importador/maquinas');
                break;
            case "articulos":
                $success_update = 0;
                $success_bajas = 0;
                $success_nuevos = 0;
                $errores = array();
                $this->load->model('articulo_model', '', TRUE);
                $this->load->model('movimiento_articulo_model', '', TRUE);
                $this->load->model('laboratorio_model', '', TRUE);
                $this->load->model('articulos_maquinas_model', '', TRUE);
                //nuevos
                if (isset($_SESSION['new_import']) and count($_SESSION['new_import'])){
                    
                    foreach ($_SESSION['new_import'] as $codigo=> $cantidad){
                        $data_art = array(
                            'nombre' => $codigo,
                            'descripcion' => '',
                            'categoria' => 1,
                            'precioCompra' => '',
                            'precioVenta' => '',
                            'stock' => $cantidad,
                            'stockMinimo' => '',
                            'salida' => '',
                            'entrada' => '',
                            'tipo_modelo' => '',
                            'codigo' => $codigo
                        );
                        if ($this->articulo_model->add('articulos', $data_art)) {
                             //agregado con exito
                            $success_nuevos++;
                            
                            $el_articulo = $this->articulo_model->getById($this->db->insert_id());
                            
                            $movimiento = '#Alta importacion';
                            ;
                            $data_movimiento = array(
                                "articulo"=>$el_articulo->idArticulo,
                                "cantidad"=>  $cantidad,
                                "fecha_hora"=>date('Y-m-d h:m:s'),
                                "movimiento"=>$movimiento,
                                "usuario"=>$this->session->userdata('id'),
                                "locacion"=>'stock',

                            );
                            $this->movimiento_articulo_model->add('movimiento_articulo', $data_movimiento);
                            
                            
                        }
                        else{
                            //$errores[] = $datos['nro_egm'];
                        }    
                    }    
                } 
               
                //modificaciones
                
                if (isset($_SESSION['update_import']) and count($_SESSION['update_import'])){                    
                    
                    foreach ($_SESSION['update_import'] as $idArticulo=> $cantidad){
                        
                        $data_update = array('stock' => $cantidad);
                        $el_articulo = $this->articulo_model->getById($idArticulo);
                        if ($this->articulo_model->edit('articulos', $data_update,'idArticulo',$idArticulo)) {
                             //agregado con exito
                            $success_update++;
                            $movimiento = '';
                            $stock_sistema=0;
                            //obtengo las cantidades del articulo en las otras locaciones
                            //maquinas y laboratorio
                            $laboratorio = $this->laboratorio_model->get('articulos_laboratorio','*',' articulo = '.$idArticulo);
                            $maquinas = $this->articulos_maquinas_model->get('articulos_maquinas','*',' articulo = '.$idArticulo);
                            if (count($laboratorio)){
                                foreach ($laboratorio as $lab){
                                    $stock_sistema = $stock_sistema + $lab->cantidad;
                                }
                            }
                            if (count($maquinas)){
                                foreach ($maquinas as $maq){
                                    $stock_sistema = $stock_sistema + $maq->cantidad;
                                }
                            }
                            $stock_sistema = $stock_sistema + $el_articulo->stock;
                            
                            $diferencia = $stock_sistema-$cantidad;
                            if ($diferencia<0){ 
                                $complemento = -1;
                                $diferencia = $diferencia*$complemento;
                                
                            }      
                            //si el estock del sistema es mayor a la cantidad entonces quita
                            if($stock_sistema > $cantidad){
                                //quita unidades del stock
                                $movimiento = '#Edita-Quita importacion';
                            }else{
                                //agregar unidades al stock
                                $movimiento = '#Edita-Agrega importacion';
                            }
                            
                            $data_movimiento = array(
                                "articulo"=>$idArticulo,
                                "cantidad"=> $diferencia,
                                "fecha_hora"=>date('Y-m-d h:m:s'),
                                "movimiento"=>$movimiento,
                                "usuario"=>$this->session->userdata('id'),
                                "locacion"=>'stock',

                            );
                           
                            
                            $this->movimiento_articulo_model->add('movimiento_articulo', $data_movimiento);
                            
                        }
                        else{
                            //$errores[] = $datos['nro_egm'];
                        }    
                    }    
                } 
               
                $this->session->set_flashdata('success', '
                        <strong>'.$success_update.'</strong> registros modificados <br>
                        <strong>'.$success_nuevos.'</strong> registros <br>
                        <strong>'.$success_bajas.'</strong> registros eliminados <br>
                        ');
                
                
                
                unset($_SESSION['datos_excel']);
                unset($_SESSION['errores']);
                unset($_SESSION['update_import']);
                unset($_SESSION['new_import']);
                unset($_SESSION['delete_import']);
                redirect(base_url() . 'index.php/Importador/articulos');
                break;
            case "articulos_maquinas":
                $success_update = 0;
                $success_bajas = 0;
                $success_nuevos = 0;
                $errores = array();
                $this->load->model('articulo_model', '', TRUE);
                $this->load->model('movimiento_articulo_model', '', TRUE);
                $this->load->model('articulos_maquinas_model', '', TRUE);
                //nuevos
                if (isset($_SESSION['new_import']) and count($_SESSION['new_import'])){
                    
                    foreach ($_SESSION['new_import'] as $val){

                        $data_art = array(
                            'maquina'  =>$val['maquina'],
                            'articulo' =>$val['articulo'],
                            'cantidad' =>$val['cantidad'],
                            'usuario'  =>$this->session->userdata('id'),
                            'fecha_hora' => date('Y-m-d h:i:s')
                        );
                        
                        //agrega a la tabla de articulos maquinas
                        if ($this->articulos_maquinas_model->add('articulos_maquinas', $data_art)) {
                             //agregado con exito
                            $success_nuevos++;
                            //obtengo el articulo y su stock
                            $diff = 0;
                            $el_articulo = $this->articulo_model->list_articulos(0,0," articulos.codigo = '".$val["articulo"]."'");
                            $diff = $el_articulo[0]->stock - $val['cantidad'];
                             
                            $data_art = array(
                                "stock"=> $diff
                            );
                            if($this->articulo_model->edit('articulos',$data_art,'idArticulo',$el_articulo[0]->idArticulo)){
                                $movimiento = '#Articulos_maquinas :';
                                $data_movimiento = array(
                                    "articulo"=>$val['articulo'],
                                    "cantidad"=>$val['cantidad'],
                                    "fecha_hora"=>date('Y-m-d h:m:s'),
                                    "movimiento"=>$movimiento." stock > M#".$val['maquina'],
                                    "usuario"=>$this->session->userdata('id'),
                                    "locacion"=>"M#".$val['maquina']
                                );

                                $this->movimiento_articulo_model->add('movimiento_articulo', $data_movimiento);
                            }
                            
                            
                        }
                        else{
                            //$errores[] = $datos['nro_egm'];
                        }    
                    }    
                } 
               
                //modificaciones
//                if (isset($_SESSION['update_import']) and count($_SESSION['update_import'])){                    
//                    
//                    foreach ($_SESSION['update_import'] as $idArticuloMaquina =>$cantidad){
//                        $data_update = array('cantidad' => $cantidad);
//                        if ($this->articulos_maquinas_model->edit('articulos_maquinas', $data_update,'idArticuloMaquina',$idArticuloMaquina)) {
//                             //agregado con exito
//                            $success_update++;
//                            $articulos_maquinas  = $this->articulos_maquinas_model->get('articulos_maquinas','*',' idArticuloMaquina = '.$idArticuloMaquina);
//                            $articulo            = $this->articulo_model->get('articulos','*',' idArticulo = '.$articulos_maquinas[0]->articulo);
//                            
//                            $data_movimiento = array(
//                                "articulo"=>$articulo[0]->idArticulo,
//                                "cantidad"=> 0,
//                                "fecha_hora"=>date('Y-m-d h:m:s'),
//                                "movimiento"=>"Actualizado desde la importacion de articulos a maquinas",
//                                "usuario"=>$this->session->userdata('id'),
//                                "locacion"=>'M#'.$articulos_maquinas[0]->maquina
//                            );
//                            $this->movimiento_articulo_model->add('movimiento_articulo', $data_movimiento);
//                            
//                        }
//                        else{
//                            //$errores[] = $datos['nro_egm'];
//                        }    
//                    }    
//                } 
               
                $this->session->set_flashdata('success', '
                        <strong>'.$success_update.'</strong> registros modificados <br>
                        <strong>'.$success_nuevos.'</strong> registros <br>
                        ');
                
                
                
                unset($_SESSION['datos_excel']);
                unset($_SESSION['errores']);
                unset($_SESSION['update_import']);
                unset($_SESSION['new_import']);
                unset($_SESSION['delete_import']);
                redirect(base_url() . 'index.php/Importador/articulos_maquinas');
                break;
        }
    }
    
    function modificacion_previa(){
        switch ($this->input->post('tipo')){
            case 'maquinas':
                $post_keys = array_keys($_POST);
                
		foreach($post_keys as $post_key){
                    if ($post_key!='tipo'){
                        $row_numbers = array_keys($_POST[$post_key]);
			foreach($row_numbers as $row_number){
                            $_SESSION['datos_excel'][$row_number][$post_key] = $_POST[$post_key][$row_number][0];
                        }
                    }
                }
                if ($this->valida_datos_maquina()==false){
                    $this->session->set_flashdata('error',"Ocurrió un error al validar los datos archivo excel"); 
                }
                $this->presubmit_maquinas();
                break;
        }
    }
    
    function get_type($file) {
        $file = explode('.', $file);
        $file_count = count($file);
        $file_type = $file[$file_count-1];
        return strtolower($file_type);
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
