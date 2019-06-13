<?php
class Desempeno_model extends CI_Model {


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
        $this->db->select('capacitacion.idCapacitacion,tema.nombre as temaNombre,capacitacion.modalidad,capacitacion.descripcion');
        $this->db->where('capacitacion.estado',1);
        $this->db->limit($perpage,$start);
        $this->db->order_by(" idCapacitacion ","  ASC ");
        $this->db->join('institucion', 'institucion.idInstitucion = capacitacion.institucion', 'inner');
        $this->db->join('tema', 'tema.idTema = capacitacion.tema', 'inner');
  
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
    function getDesempenoPersona($where = '',$one=false){
        
        $this->db->from('desempeno');
        $this->db->select('desempeno.*, '
                . ' persona_str(desempeno.idPersona) as persona, usuario_str(desempeno.usuario) as usuario ');
        if ($where !=''){
            $this->db->where('desempeno.estado = 1 AND '.$where);
        }else{
            $this->db->where('desempeno.estado',1);
        }
//        $this->db->limit($perpage,$start);
        $this->db->order_by(" idDesempeno ","  ASC ");
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
        $this->db->where('idDesempeno',$id);
        $this->db->limit(1);
        return $this->db->get('desempeno')->row();
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