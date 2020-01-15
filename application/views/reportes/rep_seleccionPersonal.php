<!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" /> -->
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.dataTables.min.js" ></script>
<!-- <link href="<?php  echo base_url()?>assets/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/> -->
<style>
    input[type=text],input[type=submit], input[type=date],select {
            width: 100%;
            height: 25px;

            box-sizing: border-box;

}

</style>
<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-lock"></i>
            </span>
            <h5>Ticekts</h5>

        </div>

        <div class="widget-content nopadding">
            <table id="registrostickets" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre y apellido</th>
                        <th>Domicilio</th>
                        <th>Contacto</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="10">No hay Tickets encontrados</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php }else{


?>
<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-tags"></i>
         </span>
        <h5>Tickets</h5>

     </div>

<div class="widget-content nopadding">


<div style="overflow-x:auto;">
<table id="registrostickets" class="table table-striped">
    <thead>
        <tr>
            <th>Nombre y apellido</th>
            <th>Domicilio</th>
            <th>Contacto</th>
            <th>Estado</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>

        <?php
            foreach ($results as $r) {
            echo '<tr">';
            echo '<td>'.$r->nombre.' '.$r->apellido.'</td>';
            echo '<td> '.$r->domicilio.'</td>';
            echo '<td> '.$r->contacto.'</td>';
            echo '<td>'.$r->meta_estado.'</td>';
            echo '<td>'.$r->f_proceso.'</td>';

            echo '</tr>';
        }?>
    </tbody>
</table>
</div>
</div>
</div>
<?php 
}
?>
<script>
$(document).ready(function(){
//tabla de datos
          $('#registrostickets').dataTable( {
            "bInfo": false,
            "bLengthChange": false,
            "nTHead":false
          } );

});

</script>
