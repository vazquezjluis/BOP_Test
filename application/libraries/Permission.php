<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Permission Class
 *
 * Biblioteca para controle de permissões
 *
 * @author		Jose Luis Vazquez
 * @copyright	        Copyright (c) 2018, Jose Luis Vazquez.
 * @since		Version 1.0
 * v... Visualizar
 * e... Editar
 * d... Deletar o Desabilitar
 * c... Registrar
 */



class Permission{

    var $Permission = array();
    var $table = 'permisos';//Nombre de tabla donde se almacenan los permisos
    var $pk = 'idPermiso';// Nombre de la clave primaria de la tabla
    var $select = 'permisos';// Campo donde se encuentra la matriz de permisos.

    public function  __construct() {
        log_message('debug', "Permission Class Initialized");
        $this->CI =& get_instance();
        $this->CI->load->database();

    }

    public function checkPermission($idPermiso = null,$atividade = null){
        if($idPermiso == null || $atividade == null){
            return false;
        }
        
        // Si los permisos no se cargan , solicita la carga
        if($this->Permission == null){
            // Si no carga devuelve falso
            if(!$this->loadPermission($idPermiso)){
                return false;
            }
        }

        if(is_array($this->Permission[0])){

        
            if(array_key_exists($atividade, $this->Permission[0])){
                // compara a atividade requisitada com a permissão.
                if ($this->Permission[0][$atividade] == 1) {
                    return true;
                } 
                return false;

            }
            return false;
        }
        return false;


    }
    private function loadPermission($id = null){

        if($id != null){
            $this->CI->db->select($this->table.'.'.$this->select);
            $this->CI->db->where($this->pk,$id);
            $this->CI->db->limit(1);
            $array = $this->CI->db->get($this->table)->row_array();
            
            if(count($array) > 0){

                $array = unserialize($array[$this->select]);
                //Asigna permisos al atributo permiso
                $this->Permission = array($array);
                return true;
            }
            return false;
            
        }
        return false;


    }
}