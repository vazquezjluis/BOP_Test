<?php
class ParametroMenu_model extends CI_Model {


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
        $this->db->order_by('idParametroMenu','desc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    function getActive($table,$fields){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->where('estado',1);
        $query = $this->db->get();
        return $query->result();;
    }
    
    function getFalla_tipo($tipo){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->where('estado',1);
        $query = $this->db->get();
        return $query->result();;
    }

    function getById($id){
        $this->db->where('idParametroMenu',$id);
        $this->db->limit(1);
        return $this->db->get('fallas')->row();
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
        return count($this->get($table,"*"," estado != 90 "));
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
    
    public function autoCompleteFallasFisica($q){

        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('descripcion', $q);
        $this->db->where(' estado = 1 AND tipo="fisica" ');
        $query = $this->db->get('fallas');
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['descripcion'],'id'=>$row['idFallas']);
            }
            echo json_encode($row_set);
        }
    }
}

/* End of file fallas_model.php */
/* Location: ./application/models/permissoes_model.php */