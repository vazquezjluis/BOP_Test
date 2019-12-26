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
            <h5>Acciones</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Usuario</th>
                        <th>Fecha de registro</th>
                        <th>Modulo</th>
                        <th>Accion</th>
                        <th>Texto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">No hay acciones </td>
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
            <i class="icon-lock"></i>
         </span>
        <h5>Acciones</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered " id="registrosconsola">
    <thead>
        <tr>
            <th>#</th>
            <th>Usuario</th>
            <th>Fecha de registro</th>
            <th>Modulo</th>
            <th>Accion</th>
            <th>Texto</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            switch($r->modulo){
                case 1: $modulo = 'Usuarios';
                    break;
                case 2: $modulo = 'Permisos';
                    break;
            }
            switch($r->accion_id){
                case 1: $accion_id = 'Agrega';
                    break;
                case 2: $accion_id = 'Edita';
                    break;
                case 3: $accion_id = 'Desactiva';
                    break;
            }
            echo '<tr>';
            echo '<td>'.$r->idConsola.'</td>';
            echo '<td>'.$r->usuario.'</td>';
            echo '<td>'.date('d/m/Y h:i:s',strtotime($r->fecha_registro)).'</td>';
            echo '<td>'.$modulo.'</td>';
            echo '<td>'.$accion_id.'</td>';
            echo '<td>'.$r->accion.'</td>';
            echo '</tr>';
        }?>
    </tbody>
</table>
</div>
</div>
<?php //echo $this->pagination->create_links();
}?>




<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/permisos/desactivar" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Desactivar Permiso</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idPermiso" name="id" value="" />
    <h5 style="text-align: center">Realmente desea desactivar este permiso?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Desactivar</button>
  </div>
  </form>
</div>


<script type="text/javascript">
$(document).ready(function(){
//tbla de datos
          $('#registrosconsola').dataTable( {
            "bInfo": false,
            "bLengthChange": false,
            "nTHead":false
          } );

});

</script>
