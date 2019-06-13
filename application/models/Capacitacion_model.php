<?php
class Capacitacion_model extends CI_Model {


    /**
     * author: Jose Luis Vazquez 
     * email: vazquezjluis@yahoo.com
     * celular : (54) 1165792663
     */
    
    function __construct() {
        parent::__construct();
    }

    

    function get($perpage=0,$start=0,$one=false){
        
        $this->db->from('capacitacion');
        $this->db->select('capacitacion.idCapacitacion,tema_str(capacitacion.tema) as temaNombre,capacitacion.modalidad,capacitacion.descripcion');
        $this->db->where('capacitacion.estado',1);
        $this->db->limit($perpage,$start);
        $this->db->order_by(" idCapacitacion ","  ASC ");
//        $this->db->join('institucion', 'institucion.idInstitucion = capacitacion.institucion', 'inner');
//        $this->db->join('tema', 'tema.idTema = capacitacion.tema', 'inner');
  
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
    function getPersonaCapacitacion($perpage=0,$start=0,$where = '',$one=false){
        
        $this->db->from('capacitacion_persona');
        $this->db->select('capacitacion_persona.*, '
                . ' persona_str(capacitacion_persona.idPersona) as persona, '
                . ' capacitacion.tema, capacitacion.f_inicio,tema.nombre,institucion.nombre as institucionStr, '
                . ' capacitacion.f_fin, capacitacion.capacitador, capacitacion.modalidad, capacitacion.institucion  ');
        if ($where !=''){
            $this->db->where('capacitacion_persona.estado = 1 AND '.$where);
        }else{
            $this->db->where('capacitacion_persona.estado',1);
        }
        
       $this->db->join('capacitacion',' capacitacion.idCapacitacion = capacitacion_persona.idCapacitacion ');
       $this->db->join('tema', 'tema.idTema = capacitacion.tema', 'inner');
       $this->db->join('institucion', 'institucion.idInstitucion = capacitacion.institucion', 'inner');
        $this->db->limit($perpage,$start);
        $this->db->order_by(" idCapacitacionPersona ","  ASC ");
        //$this->db->join('capacitacion', 'usuarios.permisos_id = permisos.idPermiso', 'left');
  
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

     function getAllTipos(){
        $this->db->where('estado',1);
        return $this->db->get('tiposUsuario')->result();
    }

    function getById($id){
        $this->db->where('idCapacitacion',$id);
        $this->db->limit(1);
        return $this->db->get('capacitacion')->row();
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
     function countActivo($table){
        $this->db->from($table); 
        $this->db->select('count(*)'); 
        $this->db->where('estado',1);
        $query = $this->db->get();
        
        return $query->result();
    }
}