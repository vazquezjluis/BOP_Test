<?php
class Pedido_model extends CI_Model {


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
        $this->db->from($table);$this->db->order_by('f_registro','desc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }

        $query = $this->db->get();

        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
    function get_reporte($table,$where='',$perpage=0,$start=0,$one=false,$array='array'){

        $order = ' ORDER BY pedido.f_registro ';
        if($start == 0 and $perpage == 0){
            $limit = ' ';
        }else if($start == 0){
            $limit = ' limit '.$perpage.' ';
        }
        else{
            $limit = ' limit '.$start.','.$perpage.' ';
        }


        $SQL = '  SELECT
                            pedido.legajo,
                            pedido.persona_str AS persona,
                            menu_personal.descripcion AS plato,
                            CASE pedido.estado
                    WHEN 1 THEN
                            "pedido"
                    WHEN 2 THEN
                            "listo"
                    WHEN 3 THEN
                            "entregado"
                    WHEN 4 THEN
                            "cancelado"
                    END AS estado,
                     pedido.descripcion AS nota,
                     pedido.f_registro AS f_pedido,
                     CASE pedido.estado
                    WHEN 1 THEN
                            "2"
                    WHEN 2 THEN
                            "2"
                    WHEN 3 THEN
                            "2"
                    WHEN 4 THEN
                            "0"
                    END AS valor
                    FROM
                            pedido
                    INNER JOIN menu_personal ON menu_personal.idMenuPersonal  = pedido.idMenu '.$where.$order.$limit;

        $query = $this->db->query($SQL);
        return $query->result();

        return $result;
    }

    public function estado_str($estado){
        $estado_str = '';
        switch ($estado){
            case '1':
                $estado_str = 'pendiente';
                break;
            case '2':
                $estado_str = 'listo';
                break;
            case '3':
                $estado_str = 'entregado';
                break;
            case '4':
                $estado_str = 'devuelto';
                break;
            default :
                $estado_str = 'error:estado no encontrado';
                break;
        }

        return $estado_str;
    }

    function getEstudioPersona($where=''){

        $this->db->select(' estudio.*,idEstudio_persona,fecha_registro,institucion_str(estudio_persona.idEstudio) as institucion');
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
        $this->db->where('idPedido',$id);
        $this->db->limit(1);
        return $this->db->get('pedido')->row();
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
