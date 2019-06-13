<?php
class Maquinas_model extends CI_Model {


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
        $this->db->order_by('idMaquina','desc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
    
    function getMaquinas_fallas($perpage=0,$start=0,$one=false,$array='array',$where=''){
        
        $this->db->from('maquinas');
        $this->db->select('maquinas.*,GROUP_CONCAT(distinct concat(fallas.idFallas,"-",fallas.descripcion,"-",fallas.tipo)) as falla, GROUP_CONCAT(DISTINCT CONCAT (ticket.idTicket,": ",ticket.descripcion) SEPARATOR "-_-") as tickets, GROUP_CONCAT( distinct articulo_str(articulos_maquinas.articulo)) as partes');
        $this->db->join('fallas_maquinas', 'fallas_maquinas.maquina= maquinas.idMaquina and fallas_maquinas.estado = 1', 'left');
        $this->db->join('fallas', 'fallas.idFallas= fallas_maquinas.falla and fallas_maquinas.estado = 1  ', 'left');
        $this->db->join('articulos_maquinas', 'articulos_maquinas.maquina= maquinas.idMaquina ', 'left');
        $this->db->join('ticket', 'ticket.sector = 1 and  ticket.referencia = maquinas.idMaquina and ticket.estado = 1 ', 'left');
        if ($where !=''){
            $this->db->where('maquinas.estado != 90 AND '.$where);
        }  else {
            $this->db->where('maquinas.estado != 90 ');
        }
        $this->db->group_by('maquinas.idMaquina');
        $this->db->order_by('maquinas.idMaquina','desc');
        $this->db->limit($perpage,$start);
        $query = $this->db->get();
        $result =  !$one  ? $query->result() : $query->row();
        
        return $result;
    }
    function repMaquinas_fallas($perpage = 0,$start = 0,$where=''){
        
        $this->db->from('maquinas');
        $this->db->select('maquinas.*,GROUP_CONCAT(distinct concat(fallas.descripcion,"<br>")) as falla, GROUP_CONCAT(DISTINCT CONCAT (ticket.idTicket,": ",ticket.descripcion) SEPARATOR "-_-") as tickets, GROUP_CONCAT( distinct articulo_str(articulos_maquinas.articulo)) as partes');
        $this->db->join('fallas_maquinas', 'fallas_maquinas.maquina= maquinas.nro_egm and fallas_maquinas.estado = 1', 'left');
        $this->db->join('fallas', 'fallas.idFallas= fallas_maquinas.falla ', 'left');
        $this->db->join('articulos_maquinas', 'articulos_maquinas.maquina= maquinas.nro_egm and articulos_maquinas.estado = 0 ', 'left');
        $this->db->join('ticket', 'ticket.sector = 1 and  ticket.referencia = maquinas.idMaquina and ticket.estado = 1 ', 'left');
        if ($where !=''){
            $this->db->where('maquinas.estado != 90 AND '.$where);
        }  else {
            $this->db->where('maquinas.estado != 90 ');
        }
        $this->db->group_by('maquinas.idMaquina');
        $this->db->order_by('maquinas.nro_egm','desc');
        $this->db->limit($perpage,$start);
        $query = $this->db->get();
        
        return $query->result();
    }
    function count_Maquinas_fallas($where=''){
        
        $this->db->from('maquinas');
        $this->db->select('maquinas.*,GROUP_CONCAT(distinct concat(fallas.idFallas,"-",fallas.descripcion,"-",fallas.tipo)) as falla, GROUP_CONCAT(DISTINCT CONCAT (ticket.idTicket,": ",ticket.descripcion) SEPARATOR "-_-") as tickets, GROUP_CONCAT( distinct articulo_str(articulos_maquinas.articulo)) as partes');
        $this->db->join('fallas_maquinas', 'fallas_maquinas.maquina= maquinas.idMaquina and fallas_maquinas.estado = 1', 'left');
        $this->db->join('fallas', 'fallas.idFallas= fallas_maquinas.falla and fallas_maquinas.estado = 1  ', 'left');
        $this->db->join('articulos_maquinas', 'articulos_maquinas.maquina= maquinas.idMaquina ', 'left');
        $this->db->join('ticket', 'ticket.sector = 1 and  ticket.referencia = maquinas.idMaquina and ticket.estado = 1 ', 'left');
        if ($where !=''){
            $this->db->where('maquinas.estado != 90 AND '.$where);
        }  else {
            $this->db->where('maquinas.estado != 90 ');
        }
        $this->db->group_by('maquinas.idMaquina');
        $this->db->order_by('maquinas.idMaquina','desc');
        
        $query = $this->db->get();
        
        return $query->result();
    }
    
    
    
    function get_modelos($one=false,$where=''){
        
        $this->db->from('maquinas');
        $this->db->select('modelo');
        
        if ($where !=''){
            $this->db->where($where);
        }  
        $this->db->group_by('maquinas.modelo');
        $this->db->order_by('maquinas.modelo','desc');
        $query = $this->db->get();
        $result =  !$one  ? $query->result() : $query->row();
        
        return $result;
    }
    
     public function searchMaquiinas_fallas($buscar,$one=false){
        $this->db->from('maquinas');
        $this->db->select('maquinas.*,GROUP_CONCAT(distinct concat(fallas.idFallas,"-",fallas.descripcion,"-",fallas.tipo)) as falla, GROUP_CONCAT(DISTINCT CONCAT (ticket.idTicket,": ",ticket.descripcion) SEPARATOR "-_-") as tickets');
        $this->db->join('fallas_maquinas', 'fallas_maquinas.maquina= maquinas.idMaquina and fallas_maquinas.estado = 1', 'left');
        $this->db->join('fallas', 'fallas.idFallas= fallas_maquinas.falla ', 'left');
        $this->db->join('ticket', 'ticket.sector = 1 and  ticket.referencia = maquinas.idMaquina  and ticket.estado = 1', 'left');
        if($buscar != null){
            $this->db->like('nro_egm',$buscar);
        }
        $this->db->where('maquinas.estado != 90 ');
        $this->db->group_by('maquinas.idMaquina');
        $this->db->order_by('maquinas.idMaquina','desc');
        $this->db->limit(10);
        
        $query = $this->db->get();
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
        
    }

    function getActive($table,$fields){
        
        $this->db->select($fields);
        $this->db->from($table);
        //$this->db->where('estado',1);
        $query = $this->db->get();
        return $query->result();
    }

    function getById($id){
        $this->db->where('idMaquina',$id);
        $this->db->limit(1);
        return $this->db->get('maquinas')->row();
    }
    
    function getByEgm($egm){
        $this->db->where('nro_egm',$egm);
        $this->db->limit(1);
        return $this->db->get('maquinas')->row();
    }
    
    function getFabricantes(){
        
        $this->db->select('fabricante');
        $this->db->from('maquinas');
        $this->db->group_by('fabricante');
        $query = $this->db->get();
        return $query->result();
    }
    
    function getModelos(){
        
        $this->db->select('modelo');
        $this->db->from('maquinas');
        $this->db->group_by('modelo');
        $query = $this->db->get();
        return $query->result();
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
        
        $this->db->where($fieldID, $ID);
       
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0)
		{
			return TRUE;
		}
		
		return FALSE;       
    }
    function edit_import($table,$data,$where){
        
        $this->db->where($where);
       
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
    
    function count_fuera_servicio($table){
            return $this->db->count_all($table);
    }
    
    public function search($buscar){
        
        if($buscar != null){
            $this->db->like('nro_egm',$buscar);
        }

        $this->db->limit(10);
        return $this->db->get('maquinas')->result();
    }
   
    
    
}

/* End of file permisos_model.php */
/* Location: ./application/models/permissoes_model.php */
