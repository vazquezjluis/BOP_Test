<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.dataTables.min.js" ></script>
<link href="<?php  echo base_url()?>assets/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
<style>
    input[type=text],input[type=submit], input[type=date],select {
            width: 100%;
            height: 25px;

            box-sizing: border-box;

}

</style>


<form method="get" id="formBuscar" action="#">
    <div class="span12">
        <div class="span2">
          <label>Apuesta minima</label>
          <input type="number" min="0" name="ap_minima"  id="ap_minima"  placeholder=" Apuesta Minima"  value="<?php echo $this->input->get('ap_minima'); ?>" >
        </div>
        <div class="span2">
            <label>Apuesta maxima</label>
            <input type="number" min="0" name="ap_maxima"  id="ap_maxima"  placeholder=" Apuesta Maxima"  value="<?php echo $this->input->get('ap_maxima'); ?>" >
        </div>

        <div class="span3">
            <label>&nbsp;</label>
            <button class="btn" style="margin-bottom: 10px;margin-left: -4px;"><i class="icon-search"></i> Buscar</button>
        </div>
    </div>
</form><br>


<?php

if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-desktop"></i>
            </span>
            <h5>Máquinas</h5>

        </div>
        <div class="widget-content nopadding">
            <div class="alert alert-info">Prueba buscar una maquina por su UID (nro_egm)</div>
        </div>
    </div>

<?php }else{


?>
<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-desktop"></i>
         </span>
        <h5>Listado de Maquinas  - <?php echo $total." registros."?></h5>

     </div>

<div class="widget-content nopadding">

<div style="overflow-x:auto;">
<table class="table" id="registrosmaquinas">
    <thead>
        <tr>
            <td><strong>Máquina</strong></td>
            <td><strong>Modelo</strong></td>
            <td><strong>Fabricante</strong></td>
            <td><strong>Tickets abiertos</strong></td>
            <td><strong>Fallas activas</strong></td>
            <td><strong>Partes</strong></td>
            <td><strong>Estado</strong></td>
            <td><strong>Apuesta minima</strong></td>
            <td><strong>Apuesta maxima</strong></td>
            <td><strong>Ver</strong></td>
        </tr>
    </thead>
    <tbody>
        <?php

        foreach ($results as $r) {
            //Estado
            if($r->estado == 1){//activo
                $class_2= ' style="margin-top:10%;padding:5%;width:10px;height:10px; background-color:green;border-radius:10px;"';
                }
            else{//fuera de servicio
                $class_2= ' style="margin-top:10%;padding:5%;width:10px;height:10px; background-color:red;border-radius:10px;"';
                $estado = ' ';
            }

            if ($r->partes!=''){
                $class_3= ' style="margin-top:10%;padding:5%;width:10px;height:10px; background-color:green;"';
            }else{
                $class_3= ' style="margin-top:10%;padding:5%;width:10px;height:10px; background-color:red;"';
            }
            //Fallo
            $tickets='';
            if(isset($r->tickets) and $r->tickets!=''){
                $mis_tickets = explode("-_-", $r->tickets);
                $tickets='';
                foreach ($mis_tickets as $t){
                    $t = explode(":", $t);
                    $tickets.=",".$t[0];
                }
            }

            echo '<tr>';
            echo '<td>
                        <b>UID: </b>'.$r->nro_egm.' <br>
                        <b>Juego: </b>'.$r->juego.'<br>
                        <b>Serie: </b>'.$r->nro_serie.'  ';
            //if($this->permission->checkPermission($this->session->userdata('permiso'),'vTicket')){

            //}
            echo'</td>';
            echo'<td>'.$r->modelo.'</td>';
            echo'<td>'.$r->fabricante.'</td>';
            echo'<td>'.$tickets.'</td>';
            echo'<td>'.$r->falla.'</td>';
            echo'<td><div '.$class_3.'></div></td>';
            echo '<td>';

            echo '<div '.$class_2.'></div>';
            echo'<td>'.$r->ap_minima.'</td>';
            echo'<td>'.$r->ap_maxima.'</td>';
                    echo'</td><td>';
                    echo '<a href="'.base_url().'index.php/maquinas?buscar='.substr($r->nro_egm, 3).'" style="margin-top:5%;;margin-right: 1%;" class="btn tip-top" title="Ver detalle"><i class="icon-eye-open"></i></a>';

            echo'
                  </td>';


            echo '</tr>';

        }?>
    </tbody>
</table>
</div>
</div>
</div>
<?php  //echo $this->pagination->create_links();
}?>
<script>
$(document).ready(function(){
//tbla de datos
          $('#registrosmaquinas').dataTable( {
            "bInfo": false,
            "bLengthChange": false,
            "nTHead":false
          } );

});

</script>
