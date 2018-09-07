<?php
class Stock_bejerman_model extends CI_Model {


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
        $this->db->order_by('id_stock_bejerman','desc');
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
    
    function get_articulos_cantidad($table,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select('
                        CONCAT(
                            stock_bejerman.stkart_codgen,
                            stock_bejerman.skart_codEle1,
                            stock_bejerman.skart_codEle2,
                            stock_bejerman.skart_codEle3
                        ) AS codigo, SUM(cantidad) as cantidad, deposito, stock_bejerman.stkart_codgen,
                        stock_bejerman.skart_codEle1,
                        stock_bejerman.skart_codEle2,
                        stock_bejerman.skart_codEle3
                ');
        
        $this->db->from($table);
        $this->db->join('articulo_deposito_importacion', 'articulo_deposito_importacion.cod_deposito = stock_bejerman.deposito', 'inner');
        $this->db->order_by('id_stock_bejerman','desc');
        
        if($where){
            $this->db->where($where);
        }
        $this->db->group_by('codigo');
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    function getById($id){
        $this->db->where('idArticulo',$id);
        $this->db->limit(1);
        return $this->db->get('articulos')->row();
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
    function delete_all($table){
        $this->db->where(' 1 = 1');
        $this->db->delete($table);
        if ($this->db->affected_rows() != '0')
        {
            return TRUE;
        }
		
        return FALSE;        
    }   
	
    function count($table){
        return count($this->get($table,"*"," estado != 90"));
    }
    
}

/* End of file fallas_model.php */
/* Location: ./application/models/permissoes_model.php */