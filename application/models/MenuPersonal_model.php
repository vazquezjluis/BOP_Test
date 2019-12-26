<?php
class MenuPersonal_model extends CI_Model {


    /**
     * author: Jose Luis Vazquez
     * email: vazquezjluis@yahoo.com
     * celular : (54) 1165792663
     */

    function __construct() {
        parent::__construct();
        $this->tblName = 'menu_personal';
    }


    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){

        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('fecha_menu','desc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }

        $query = $this->db->get();

        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    function get_group_fecha($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){

        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('fecha_menu','desc');
        $this->db->group_by('fecha_menu');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }


        $query = $this->db->get();

        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
    function getMenuManual($where=''){

        $this->db->select('*');
        $this->db->from($this->tblName);
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
        $this->db->where('idMenuPersonal',$id);
        $this->db->limit(1);
        return $this->db->get($this->tblName)->row();
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
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function  getRows ($params = array()) {
  echo "hola getrows";
        $this->db->select('*');
        $this->db->from ($this->tblName);

        // obtener datos por condiciones
        if (array_key_exists("where" , $params)) {
            foreach ($params['where'] as $key => $value) {
                $this->db->where($key, $value);
            }
        }

        if (array_key_exists("order_by", $params)) {
            $this->db->order_by($params['order_by']);
        }

        if (array_key_exists ("id" , $params)) {
            $this->db->where ('id' , $params ['id']);
            $query = $this->db->get();
            $result = $query->row_array();
        } else {
            // establece el inicio y el límite
            if (array_key_exists( "start", $params ) &&  array_key_exists ("limit", $params)) {
                $this->db-> limit($params['limit'], $params['start']);
            } elseif (!array_key_exists("start",$params) &&  array_key_exists("limit", $params)) {
                $this->db->$params['limit'];
            }

            if (array_key_exists("returnType", $params) &&  $params['returnType'] ==  'count') {
                $result = $this->db->count_all_results();
            } else {
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)? $query->result_array() : '';
            }
        }

        // devolver exagerado los datos
        return $data;
    }

   function  delete_ ($id) {
        if (is_array($id)) {
        } else {
            $this->db->where('id', $id);
        }
        $delete = $this->db->delete($this->tblName);
        if ($delete === true) {
          return TRUE;
        } else {
          return FALSE;
        }
    }



/* End of file permisos_model.php */
/* Location: ./application/models/permissoes_model.php */
