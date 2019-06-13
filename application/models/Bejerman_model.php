<?php 
class Bejerman_model extends CI_Model {


    /**
     * author: Jose Luis Vazquez 
     * email: vazquezjluis@yahoo.com
     * celular : (54) 1165792663
     */
    
    function __construct() {
        parent::__construct();
    }
    function get_articulo($sql='', $count = false){
        $bd_lenox =  $this->load->database('bejerman',TRUE);
        
        if ($sql !=''){
            $query = $bd_lenox->query(" SELECT
                    rtrim(art_CodGen)+rtrim(art_CodEle1)+rtrim(art_CodEle2)+rtrim(art_CodEle3) AS cod,
                    art_CodGen AS CodigoGenerico,
                    art_CodEle1 AS ATR1,
                    art_CodEle2 AS ATR2,
                    art_CodEle3 AS ATR3,
                    art_DescGen AS DescripcionGral,
                    artele_Desc1 AS DescripcionATR1,
                    artele_Desc2 AS DescripcionATR2,
                    artele_Desc3 AS DescripcionATR3
                FROM
                    Articulos
                WHERE
                artda1_Cod LIKE 'RRHH' ".$sql);
        }else{
            $query = $bd_lenox->query(" SELECT
                rtrim(art_CodGen)+rtrim(art_CodEle1)+rtrim(art_CodEle2)+rtrim(art_CodEle3) AS cod,
                art_CodGen AS CodigoGenerico,
                      art_CodEle1 AS ATR1,
                      art_CodEle2 AS ATR2,
                      art_CodEle3 AS ATR3,
                      art_DescGen AS DescripcionGral,
                      artele_Desc1 AS DescripcionATR1,
                      artele_Desc2 AS DescripcionATR2,
                      artele_Desc3 AS DescripcionATR3
              FROM
                      Articulos
              WHERE
                artda1_Cod LIKE 'RRHH'");
        }
        
        $persona_info =  $query->result();
        
        if ($count){
            $persona_info = count($persona_info);
        }
        
        return $persona_info;
    }

}
