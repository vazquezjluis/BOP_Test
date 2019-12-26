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
<a href="<?php echo base_url()?>index.php/usuarios/agregar" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar nuevo Usuario</a>
<!--<a href="<?php // echo base_url()?>index.php/usuarios/importacion_empleados" class="btn btn-danger"><i class="icon-plus icon-white"></i> Migrar empleados (solo para el administrador) </a>-->
<?php
if(!$results){?>
<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
        </span>
        <h5>Usuários</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Nombre</th>
            <th>Usr</th>
            <th>Email</th>
            <th>Celular</th>
            <th>Nível</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="5">No se encontraron usuarios</td>
        </tr>
    </tbody>
</table>
</div>
</div>


<?php } else{?>

<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
         </span>
        <h5>Usuários</h5>

     </div>

<div class="widget-content nopadding">

<div style="overflow-x:auto;">
    <table class="table table-bordered" id="registrosusuarios">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Nombre</th>
            <th>Usr</th>
            <th>Email</th>
            <th>Celular</th>
            <th>Nível</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {

            echo '<tr>';
            echo '<td>'.$r->idUsuarios.'</td>';
            echo '<td>'.$r->nombre.'</td>';
            echo '<td>'.$r->usr.'</td>';
            echo '<td>'.$r->email.'</td>';
            echo '<td>'.$r->celular.'</td>';
            echo '<td>'.$r->permiso.'</td>';
            echo '<td>
                      <a href="'.base_url().'index.php/usuarios/editar/'.$r->idUsuarios.'" class="btn btn-info tip-top" title="Editar Usuário"><i class="icon-pencil icon-white"></i></a>
                  </td>';
            echo '</tr>';
        }?>
    </tbody>
</table>
</div>
</div>
</div>


<?php //echo $this->pagination->create_links();
}?>
<script>
$(document).ready(function(){
//tbla de datos
          $('#registrosusuarios').dataTable( {
            "bInfo": false,
            "bLengthChange": false,
            "nTHead":false
          } );

});

</script>
