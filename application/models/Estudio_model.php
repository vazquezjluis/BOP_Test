<?php
class Estudio_model extends CI_Model {


    /**
     * author: Jose Luis Vazquez 
     * email: vazquezjluis@yahoo.com
     * celular : (54) 1165792663
     */
    
    function __construct() {
        parent::__construct();
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
        
        $this->db->select(' estudio.*,idEstudio_persona,fecha_registro,institucion_str(estudio.institucion) as institucion');
        $this->db->from("estudio_persona");
        $this->db->join('estudio', 'estudio.idEstudio = estudio_persona.idEstudio', 'inner');
        //$this->db->order_by('estudio_persona.fecha_registro','desc');
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