<?php
class CalendarioMenu_model extends CI_Model {


    /**
     * author: Jose Luis Vazquez 
     * email: vazquezjluis@yahoo.com
     * celular : (54) 1165792663
     */
    
    function __construct() {
        parent::__construct();
    }

    function get_reporte($table,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $order = ' ORDER BY calendariomenu.f_registro ';
        if($start == 0 and $perpage == 0){
            $limit = ' ';
        }else if($start == 0){
            $limit = ' limit '.$perpage.' ';
        }
        else{
            $limit = ' limit '.$start.','.$perpage.' ';
        }
        
        $SQL = '  SELECT legajo,persona_str as persona, title as plato, f_registro, start FROM calendariomenu '.$where.$order.$limit;
       
//        echo "<pre>";
//        var_dump($SQL);
//        echo "</pre>";
        $query = $this->db->query($SQL);
        return $query->result();
        
        
        
        return $result;
    }
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idEstudio','desc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
    function getEstudioPersona($where=''){
        
        $this->db->select(' estudio.*,idEstudio_persona,fecha_registro,documentos.url,institucion_str(estudio.institucion) as institucion, titulo_str(estudio.titulo) as titulo, estudio_persona.estado_str');
        $this->db->from("estudio_persona");
        $this->db->join('estudio', 'estudio.idEstudio = estudio_persona.idEstudio', 'inner');
        $this->db->join('documentos', 'documentos.referencia = estudio_persona.idEstudio_persona AND documentos.funcionalidad = "estudio_persona" AND documentos.documento = "estudio" ', 'left');
        //$this->db->order_by('estudio_persona.fecha_registro','desc');
        if($where){
            $this->db->where($where);
        }
        $query = $this->db->get();
        
        return $query->result();
    }
    function get_calendario($where=''){
        
        $this->db->select('*');
        $this->db->from("calendarioMenu");
        if($where){
            $this->db->where($where);
        }
        $query = $this->db->get();
        
        return $query->result();
    }

    function getActive($table,$fields){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->where('estado',1);
        $query = $this->db->get();
        return $query->result();;
    }

    function getById($id){
        $this->db->where('idEstudio',$id);
        $this->db->limit(1);
        return $this->db->get('estudio')->row();
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
		return $this->db->count_all($table);
	}
}

/* End of file permisos_model.php */
/* Location: ./application/models/permissoes_model.php */