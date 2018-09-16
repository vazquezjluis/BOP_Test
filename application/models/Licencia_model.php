<?php
class Licencia_model extends CI_Model {


    /**
     * author: Jose Luis Vazquez 
     * email: vazquezjluis@yahoo.com
     * celular : (54) 1165792663
     */
    
    function __construct() {
        parent::__construct();
    }

    

    function get($perpage=0,$start=0,$one=false){
        
        $this->db->from('licencia');
        $this->db->select('*');
        $this->db->where('estado',1);
        $this->db->limit($perpage,$start);
        //$this->db->join('capacitacion', 'usuarios.permisos_id = permisos.idPermiso', 'left');
  
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
    function get_licencia_persona($perpage=0,$start=0,$one=false){
        
        $this->db->from('licencia_persona');
        $this->db->select('licencia_persona.*, '
                . ' licencia_str(licencia_persona.idLicencia) AS licencia, '
                . ' persona_str(licencia_persona.idPersona) AS persona');
        $this->db->where('estado',1);
        $this->db->order_by('idLicenciaPersona','ASC');
        $this->db->limit($perpage,$start);
        //$this->db->join('capacitacion', 'usuarios.permisos_id = permisos.idPermiso', 'left');
  
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
    
    function getPersonaLicencia($where=''){
        $this->db->from('licencia_persona');
        $this->db->select('licencia_persona.*,licencia.*, licencia_persona.descripcion as lpdesc ,licencia_persona.dias as dias_tomados,licencia.dias as dias_corresponde,'
                . ' licencia_str(licencia_persona.idLicencia) AS licencia, '
                . ' persona_str(licencia_persona.idPersona) AS persona');
        if ($where !=''){
            $this->db->where('licencia_persona.estado = 1 AND '.$where);
        }else{
            $this->db->where('licencia_persona.estado = 1 ');
        }
        
        $this->db->order_by('idLicenciaPersona','ASC');
        $this->db->join('licencia', 'licencia.idLicencia = licencia_persona.idLicencia');
  
        $query = $this->db->get();
        
        return $query->result();
    }

     function getAllTipos(){
        $this->db->where('estado',1);
        return $this->db->get('tiposUsuario')->result();
    }

    function getById($id){
        $this->db->where('idLicencia',$id);
        $this->db->limit(1);
        return $this->db->get('licencia')->row();
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
    function countLicenciaActiva(){
        $this->db->from('licencia');
        $this->db->select('*');
        $this->db->where('estado',1);
        $query = $this->db->get();
        return count($query->result());
    }
    function countLicenciaVinculoActiva(){
        $this->db->from('licencia_persona');
        $this->db->select('*');
        $this->db->where('estado',1);
        $query = $this->db->get();
        return count($query->result());
    }
}