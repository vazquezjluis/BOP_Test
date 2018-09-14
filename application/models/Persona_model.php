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
    
    public function autoCompletePersona($q){

        $this->db->select('persona.*');
        $this->db->limit(10);
//        $this->db->like(' apellido ', $q);
//        $this->db->like(' nombre ', $q);
       $this->db->where(' apellido LIKE "%'.$q.'%"'
               . ' OR nombre LIKE "%'.$q.'%" '
               . ' OR legajo LIKE "%'.$q.'%"');
        $query = $this->db->get('persona');
        
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>"[".$row['legajo']." - ".$row['apellido']." ".$row['nombre']."]",'id'=>$row['id']);
            }
            
            echo json_encode($row_set);
        }
    }
}

/* End of file fallas_model.php */
/* Location: ./application/models/permissoes_model.php */