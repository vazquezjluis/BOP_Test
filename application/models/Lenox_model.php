<?php

class Lenox_model extends CI_Model {


    /**
     * author: Jose Luis Vazquez 
     * email: vazquezjluis@yahoo.com
     * celular : (54) 1165792663
     */
    
    function __construct() {
        parent::__construct();
    }
    function get_all(){
        $bd_lenox =  $this->load->database('lenox',TRUE);
        
        $query = $bd_lenox->query(' SELECT * FROM control_fichadas where nombre like "%chris%" and apellido like "%garcia%" order by fichada desc');
        $persona_info =  $query->result();
        
        return $persona_info;
    }

}
