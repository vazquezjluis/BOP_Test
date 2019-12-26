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
<a href="<?php echo base_url();?>index.php/permisos/agregar" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar nuevo Permiso</a>
<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-lock"></i>
            </span>
            <h5>Permisos</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Fecha de creación</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">No hay permisos encontrados</td>
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
        <h5>Permisos</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered " id="registrospermisos">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Fecha de creación</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            if($r->estado == 1){$estado = 'Activo';}else{$estado = 'Inactivo';}
            echo '<tr>';
            echo '<td>'.$r->idPermiso.'</td>';
            echo '<td>'.$r->nombre.'</td>';
            echo '<td>'.date('d/m/Y',strtotime($r->fecha_registro)).'</td>';
            echo '<td>'.$estado.'</td>';
            echo '<td>
                      <a href="'.base_url().'index.php/permisos/editar/'.$r->idPermiso.'" class="btn btn-info tip-top" title="Editar Permiso"><i class="icon-pencil icon-white"></i></a>
                      <a href="#modal-excluir" role="button" data-toggle="modal" permiso="'.$r->idPermiso.'" class="btn btn-danger tip-top" title="Desactivar Permiso"><i class="icon-remove icon-white"></i></a>
                  </td>';
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

   $(document).on('click', 'a', function(event) {
        var permiso = $(this).attr('permiso');
        $('#idPermiso').val(permiso);

    });

});

$(document).ready(function(){
//tbla de datos
          $('#registrospermisos').dataTable( {
            "bInfo": false,
            "bLengthChange": false,
            "nTHead":false
          } );

});


</script>
