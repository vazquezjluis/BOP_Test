<?php
class Persona_model extends CI_Model {


    /**
     * author: Jose Luis Vazquez 
     * email: vazquezjluis@yahoo.com
     * celular : (54) 1165792663
     */
    
    function __construct() {
        parent::__construct();
    }
    function get_persona($sql=''){
        $bd_lenox =  $this->load->database('lenox',TRUE);
        
        if ($sql !=''){
            $query = $bd_lenox->query(' SELECT CLIENTES.* FROM CLIENTES '.$sql);
        }else{
            $query = $bd_lenox->query(' SELECT CLIENTES.* FROM CLIENTES');
        }
        
        $persona_info =  $query->result();
        
        
        return $persona_info;
    }
    
    function get_sanciones($persona,$mes_actual=false){
        $bd_lenox =  $this->load->database('lenox',TRUE);
        
        $sql='SELECT
                aus.fecha AS fecha,
                nov.codigo AS codigoBejerman,
                nov.descripcion AS novedad,
                aus.comentario AS comentario,
                aus.justificada
            FROM
                AUSENCIAS aus
                INNER JOIN NOVEDADES nov ON aus.id_novedad = nov.id
                INNER JOIN CLIENTES clie ON clie.id = aus.id_cliente
            WHERE
            aus.id_cliente = '.$persona.'
            AND nov.id IN (6,7,18)'; 
        
        if ($mes_actual) {
            $sql.=' AND MONTH(aus.fecha) = MONTH(SYSDATETIME()) ';
        }
        
        $sql.=' ORDER BY aus.fecha DESC';
        
        
        $query = $bd_lenox->query($sql);//APERCIBIMIENTO,SUSPENSION
                
        $sansion_info =  $query->result();
        
        
        return $sansion_info;
    }
    
    function get_ausencia($persona,$mes_actual=false){
        $bd_lenox =  $this->load->database('lenox',TRUE);
            
        $sql='
        SELECT
            aus.fecha AS fecha,
            nov.codigo AS codigoBejerman,
            nov.descripcion AS novedad
        FROM
            AUSENCIAS aus
            INNER JOIN NOVEDADES nov ON aus.id_novedad = nov.id
            INNER JOIN CLIENTES clie ON clie.id = aus.id_cliente
        WHERE
        aus.id_cliente = '.$persona.'
        AND nov.id IN (6, 21) '; 

        if ($mes_actual) {
            $sql.=' AND MONTH(aus.fecha) = MONTH(SYSDATETIME()) ';
        }

        $sql.=' ORDER BY aus.fecha DESC';
            /*
             * 6-INASISTENCIA
             * 21- INASISTENCIA JUSTIFICADA
             */
        $query = $bd_lenox->query($sql);
        
        $sansion_info =  $query->result();
        
        
        return $sansion_info;
    }
    
    function get_licencias($persona,$mes_actual=false){
        $bd_lenox =  $this->load->database('lenox',TRUE);
            
        $sql='
        SELECT
        aus.id as idBejerman,
            aus.fecha AS fecha,
            nov.codigo AS codigoBejerman,
            nov.descripcion AS novedad,
            aus.COMENTARIO
        FROM
            AUSENCIAS aus
            INNER JOIN NOVEDADES nov ON aus.id_novedad = nov.id
            INNER JOIN CLIENTES clie ON clie.id = aus.id_cliente
        WHERE
        aus.id_cliente = '.$persona.'
        AND nov.id IN (10,11,12,13,14,15,16,17,19) '; 

        if ($mes_actual) {
            $sql.=' AND MONTH(aus.fecha) = MONTH(SYSDATETIME()) ';
        }

        $sql.=' ORDER BY aus.fecha DESC';
        
        $query = $bd_lenox->query($sql);
        
        $sansion_info =  $query->result();
        
        
        return $sansion_info;
    }
    
    
    function get_licencia_comprobante($persona){
        
        $sql='SELECT documentos.url,licencia_persona.idLicencia FROM documentos
            INNER JOIN licencia_persona ON licencia_persona.idLicenciaPersona = documentos.referencia
            WHERE licencia_persona.idPersona = '.$persona.'
            AND documentos.sector = 2
            AND documentos.documento = "Vinculo licencia_persona"';

        
        $query = $this->db->query($sql);
        
        $info =  $query->result();
        
        
        return $info;
        
        
    }
  
    
   function get_uniforme($where=''){
        $this->db->from('uniforme_has_persona');
        $this->db->select('uniforme_has_persona.*,usuario_str(uniforme_has_persona.usuario) as usuario');
        if ($where !=''){
            $this->db->where('uniforme_has_persona.estado = 1 AND '.$where);
        }else{
            $this->db->where('uniforme_has_persona.estado = 1 ');
        }
        
        $this->db->order_by('idUniforme_has_persona','ASC');
//        $this->db->join('uniforme', 'uniforme.idUniforme = uniforme_has_persona.idUniforme');
  
        $query = $this->db->get();
        
        return $query->result();
    }
    
    function permite_premio($persona){
        $sansiones= $this->get_sanciones($persona,true);
        $ausencias= $this->get_ausencia($persona,TRUE);
        $persona_dato = $this->get_persona(' WHERE id= '.$persona);
        
    }
            function get_imagen($id){
        $bd_lenox =  $this->load->database('lenox',TRUE);
        /* Execute the query. */  
        $stmt = $bd_lenox->query('SELECT imagen FROM CLIENTES WHERE id = '.$id);  
        
        $persona_info =  $stmt->result();
        header("Content-Type: image/gif");  
        echo $persona_info[0]->imagen; 
    }
    
    function get($table,$fields,$where='',$order_by = true,$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        if ($order_by){
            $this->db->order_by('id','desc');
        }
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

   
    
    function getSector($table,$fields){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->group_by('PUESTO_TRABAJO');
        $query = $this->db->get();
        return $query->result();;
    }
    function getActive($table,$fields){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->where('eliminado',0);
        $query = $this->db->get();
        return $query->result();;
    }
    

    function getById($id){
        $this->db->where('id',$id);
        $this->db->limit(1);
        return $this->db->get('persona')->row();
    }
    
    function add($table,$data){
        $this->db->insert($table, $data);         
        if ($this->db->affected_rows() == '1')
        {
            return TRUE;
        }

        return FALSE;       
    }
    
    function edit($table,$data,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0)
        {
            return TRUE;
        }

        return FALSE;       
    }
    
    function delete($table,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1')
        {
            return TRUE;
        }
		
        return FALSE;        
    }   
	
    function count($table){
        return count($this->get($table,"*"," 1=1 "));
    }
    
     function list_persona($perpage = 0,$start = 0,$where=' '){
        
        $this->db->from('persona');
        $this->db->select('*');
        if ($where !=''){
//            $this->db->where('articulos.estado != 90 AND '.$where);
        }  else {
//            $this->db->where('articulos.estado != 90 ');
        }
        
        $this->db->order_by('persona.id','desc');
        $this->db->limit($perpage,$start);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    public function autoCompleteFallasLogica($q){

        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('descripcion', $q);
        $this->db->where(' estado = 1 AND tipo="logica"');
        $query = $this->db->get('fallas');
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['descripcion'],'id'=>$row['idFallas']);
            }
            echo json_encode($row_set);
        }
    }
    
    public function autoCompletePersona($q,$sectorConPermiso){
        
            $sql = "INNER JOIN SECTOR_POR_EMPRESA ON SECTOR_POR_EMPRESA.id = CLIENTES.id_sector_por_empresa
                    INNER JOIN SECTORES ON SECTORES.id = SECTOR_POR_EMPRESA.id_sector
                    WHERE 1 = 1";
            if($sectorConPermiso !=''){
                $sql.= " AND (".substr($sectorConPermiso,2).")";
            }
        $sql.=    " AND (apellido LIKE '%".$q."%' "
                . " OR nombre LIKE '%".$q."%' "
                . " OR legajo LIKE '%".$q."%') ";
        $persona_info = $this->get_persona($sql);
        
        if(count($persona_info) > 0){
            foreach ($persona_info as $row){
                $row_set[] = array('label'=>"[".$row->legajo." - ".$row->apellido." ".$row->nombre."]",'id'=>$row->id);
            }
            
            echo json_encode($row_set);
        }
    }
}

/* End of file fallas_model.php */
/* Location: ./application/models/permissoes_model.php */