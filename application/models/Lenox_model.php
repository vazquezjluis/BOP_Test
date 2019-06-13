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
    function get_persona($sql=''){
        $bd_lenox =  $this->load->database('lenox',TRUE);
        
        if ($sql !=''){
            $query = $bd_lenox->query(' SELECT * FROM [dbo].[CLIENTES] '.$sql);
        }else{
            $query = $bd_lenox->query(' SELECT * FROM [dbo].[CLIENTES]');
        }
        
        $persona_info =  $query->result();
        
        return $persona_info;
    }

}
