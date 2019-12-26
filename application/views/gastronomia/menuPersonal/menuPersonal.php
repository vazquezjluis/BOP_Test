<script  src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<?php  if ($this->permission->checkPermission($this->session->userdata('permiso'),'cMenu')){
//    if (in_array(date("w"),array(0,6))){?>

    <div class="span12">
        <div class="span3">
               <a href="<?php echo base_url();?>index.php/menuPersonal/agregar" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar nuevo Menu</a>
        </div>
        <div class="span3">
            <a href="#modal-valor" role="button" data-toggle="modal" class="btn btn"> Cambiar valores del menu del proveedor $ <?php if (count($importe_externo)) {echo $importe_externo[0]->importe_externo;}else{ echo "-";}?></a>
        </div>

        <?php  if ($this->permission->checkPermission($this->session->userdata('permiso'),'vImporMenu')){
//    if (in_array(date("w"),array(0,6))){?>
        <div class="span3">
            <a href="<?php echo base_url();?>index.php/importador/menu" class="btn btn-primary pull-right"><i class="icon-plus icon-white"></i> Importar Excel </a>
        </div>
    </div>
<div class="span12 " style="margin: 1% 0% 1% 0%;">
    <?php

    $dia        = array();
    $cantidad   = 0;
    $tiempo     = '';
    if (isset($parametroMenu)){
        $dia        = explode(',',$parametroMenu[0]->dia);
        $cantidad   = $parametroMenu[0]->cantidad;
        $tiempo     = $parametroMenu[0]->tiempo;
    }


    ?>
    <form action="<?php echo base_url() ?>index.php/menuPersonal/addParameters" method="post">


    <div class="span12 well">

        <div class="span2">
            <label><input type="checkbox" name="dia[]" value="lu" <?php if(in_array('lu', $dia)){ echo "checked";}?>    style="margin-top: 0px;"> Lunes</label>
            <label><input type="checkbox" name="dia[]" value="ma" <?php if(in_array('ma', $dia)){ echo "checked";}?>   style="margin-top: 0px;"> Martes</label>
            <label><input type="checkbox" name="dia[]" value="mi" <?php if(in_array('mi', $dia)){ echo "checked";}?>     style="margin-top: 0px;"> Miercoles</label>
            <label><input type="checkbox" name="dia[]" value="ju" <?php if(in_array('ju', $dia)){ echo "checked";}?>   style="margin-top: 0px;"> Jueves</label>
            <label><input type="checkbox" name="dia[]" value="vi" <?php if(in_array('vi', $dia)){ echo "checked";}?>  style="margin-top: 0px;"> Viernes</label>
        </div>
        <div class="span2" style="margin-left:0px">
            <label><input type="checkbox" name="dia[]" value="sa" <?php if(in_array('sa', $dia)){ echo "checked";}?> style="margin-top: 0px;"> Sabado</label>
            <label><input type="checkbox" name="dia[]" value="do" <?php if(in_array('do', $dia)){ echo "checked";}?>  style="margin-top: 0px;"> Domingo</label>
        </div>

        <div class="span6" style="margin-left:0px">
            <div class="form-control">
                <div class="span12">
                    <div class="span3">
                        Cantidad
                        <input type="number" style="max-width: 60px;"id="cantidad" value="<?php echo $cantidad;?>" required="required"name="cantidad" />
                    </div>

                    <div class="span1">
                        <input type="radio" <?php if($tiempo == "dia"){ echo "checked";}?> style="margin-top: 0px;" name="tiempo" value="dia" id="dias">Dias
                    </div>
                    <div class="span1">
                        <input type="radio" <?php if($tiempo == "semana"){ echo "checked";}?> style="margin-top: 0px;" name="tiempo" value="semana" id="semana">Sem.
                    </div>
                    <div class="span1">
                        <input type="radio" <?php if($tiempo == "mes"){ echo "checked";}?> style="margin-top: 0px;" name="tiempo" value="mes" id="meses">Meses
                    </div>
                </div>
                <div class="span12" style="margin-left: 0px;">
                    <hr>
                </div>
                <div class="span8" style="margin-left: 0px;">
                    <button  class="btn btn-default">Guardar parametros</button>
                    <?php // echo " Hoy ".date_format(new DateTime(), date('d/m/Y'));?>
<!--                    <p>
                        <span class="icon-arrow-right">
                        Cantidad de dias, semanas o meses que el empleado puede programar su plato,
                        a partir del </span>
                    </p>-->

                </div>
            </div>

        </div>

            <!--<a href="#modal-fechaLimite" role="button" data-toggle="modal" class="btn btn"> Fecha límite para programar el menu <?php if (count($fechaLimiteProgramado)) {echo  date('d/m/Y',strtotime($fechaLimiteProgramado[0]->fecha));}else{ echo "-";}?></a>-->
    </div>

    </form>
</div>

    <?php // }else{
        }
        ?>
        <!--<div class="alert alert-danger">Solo se puede cargar menú los dias Sabados o Domingos.</div>-->
    <?php
//    }
}
?>
<form class="" action="" method="post">
<?php
// //  if ($data) {  ?>
<!-- <div class = "alert alert-success"> <?php echo $statusMsg;?> </div> -->
<?php// var_dump($statusMsg);
//exit;?>
<?php  //}

if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-lock"></i>
            </span>
            <h5>Menu</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Menu</th>
                        <th>Fecha del menu</th>
                        <th>Tipo</th>
                        <!--<th>Estado</th>-->
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4">No hay permisos encontrados</td>
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
        <h5>Menu</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
            <th>#</th>
            <th>Menu</th>
            <th>Fecha del menu</th>
            <th>Tipo</th>
            <th>Valor</th>
            <th><input type="submit" name ="bulk_delete_submit" value ="DELETE"/></th>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {


            if($r->fecha_menu == date('Y-m-d')){$estado = '<div class="alert alert-success">Activo</div>';}else{$estado = '<div style="color:red;">Inactivo</div>';}
            echo '<tr>';
            echo '<td>'.$r->idMenuPersonal.'</td>';
            echo '<td>'.$r->descripcion.'</td>';
            echo '<td>'.date('d/m/Y',strtotime($r->fecha_menu)).'</td>';
            if ($r->tipo_menu == 'externo'){$color_tipo = 'style="color:blue;"';}else{$color_tipo ='style="color:orange;"';}
            echo '<td '.$color_tipo.'><b>'.$r->tipo_menu.'</b></td>';
            if ($r->tipo_menu == "externo"){
                if (count($importe_externo)) {
                    echo '<td>$ '.$importe_externo[0]->importe_externo.'</td>';}
                else{ echo '<td></td>';}

            }else{
                echo '<td>$ '.$r->valor.'</td>';
            }

            echo '<td>';
            //if ($this->permission->checkPermission($this->session->userdata('permiso'),'eMenu')){
              //  if ($r->estado == 1){
                //    echo '<a href="#modal-excluir" role="button" data-toggle="modal" menu="'.$r->idMenuPersonal.'" class="btn btn-danger tip-top" title="desactivar Menu"><i class="icon-remove icon-white"></i></a>';
                //}else{
                  //  echo '<a href="#modal-activar"role="button" data-toggle="modal" menu="'.$r->idMenuPersonal.'"  class="btn tip-top" title="Activar"><i class="icon-ok icon-white"></i></a>';
               // }
            //}
            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            if ($this->permission->checkPermission($this->session->userdata('permiso'),'eMenu')){
                echo '<a href="'.base_url().'index.php/menuPersonal/editar/'.$r->idMenuPersonal.'" class="btn btn-info tip-top" title="Editar Permiso"><i class="icon-pencil icon-white"></i></a>';
            }
            if ($this->permission->checkPermission($this->session->userdata('permiso'),'dMenu')){
            // <input type="button" onClick="eliminarElemento(document.getElementById('elemento').value);" value="Eliminar Elemento"/>
                  ?>
                        <input type="checkbox" name="check_id[]" id="myCheck" value="<?=$r->idMenuPersonal?>">
                  <?php
                 // echo '<a href="#modal-eliminar" role="button" data-toggle="modal" menu="'.$r->idMenuPersonal.'" class="btn btn-danger tip-top" title="Eliminar Menu"><i class="icon-trash icon-white"></i></a>';
            }
            echo '      </td>';
            echo '</tr>';
        }?>
        <tr>

        </tr>
    </tbody>
</table>
</form >
</div>
</div>
<?php echo $this->pagination->create_links();}?>




<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/menuPersonal/desactivar" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Desactivar Menu</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idMenu" name="id" value="" />
    <h5 style="text-align: center">Realmente desea desactivar este menu?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-info">Desactivar</button>
  </div>
  </form>
</div>


<div id="modal-valor" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/valorMenu/agregar" method="post" class="form-horizontal" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Modificar el valor del menu</h5>
  </div>
  <div class="modal-body">
      <div class="alert alert-info"> Este valor comienza a ser vigente a partir de ahora, los platos ya pedidos conservan su costo. </div>
    <div class="control-group">
        <label for="valor" class="control-label">Valor general para el menu Externo<span class="required">$</span></label>
        <div class="controls">
            <input id="importe_externo" type="number" name="importe_externo" value="" required="required" placeholder="<?php if (count($importe_externo)) {echo "Valor actual $".$importe_externo[0]->importe_externo;}else{ echo " ingrese el valor ";}?>" />
        </div>
        <!--<label for="valor" class="control-label">Menu externo<span class="required">$</span></label>-->
        <div class="controls">
            <input id="importe_interno" type="hidden" name="importe_interno" value="0" />
        </div>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-info">Guardar</button>
  </div>
  </form>
</div>

<div id="modal-fechaLimite" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/fechaLimiteProgramado/agregar" method="post" class="form-horizontal" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Modificar el valor de la fecha Limite de programacion del menu</h5>
  </div>
  <div class="modal-body">
      <div class="alert alert-info">Esta fecha es el límite en el que los empleados pueden programar su menu.<br>
          Si tu pones 30/09/2019 entonces el día 01/10/2019 el empleado no podrá programar su plato</div>
    <div class="control-group">
        <label for="valor" class="control-label">Nueva fecha límite<span class="required">*</span></label>
        <div class="controls">
            <input id="fecha_limite" type="date" name="fecha_limite" value="" required="required"  />
        </div>
        <!--<label for="valor" class="control-label">Menu externo<span class="required">$</span></label>-->
        <div class="controls">
            <input id="importe_interno" type="hidden" name="importe_interno" value="0" />
        </div>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-info">Guardar</button>
  </div>
  </form>
</div>

<div id="modal-eliminar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/menuPersonal/eliminar" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Eliminar Menu</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idMenu_eliminar" name="id" value="" />
    <h5 style="text-align: center">Realmente desea eliminar este menu?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Eliminar</button>
  </div>
  </form>
</div>

<div id="modal-activar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/menuPersonal/activar" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Activar Menu</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idMenu_activar" name="id" value="" />
    <h5 style="text-align: center">Desea activar este menu?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-success">Activar</button>
  </div>
  </form>
</div>


<script type="text/javascript">
// $(document).ready(function(){
//
//    $(document).on('click', 'a', function(event) {
//         var menu = $(this).attr('menu');
//         $('#idMenu').val(menu);
//         $('#idMenu_eliminar').val(menu);
//         $('#idMenu_activar').val(menu);
//1299999 id
//     });
//
// });
// document.getElementById("myCheck").remove();
console.log("holajs");
    function delete_confirm($(checkbox.checked)) {
    // var checkBox = document.getElementById("myCheck");
     if ($(checkbox.checked)){
       console.log("hola");
       var result = confirm ("¿Está seguro de eliminar usuarios seleccionados?");
          // confirm( "¿Está seguro de eliminar usuarios seleccionados?");
        if (result == true) {
             return true ;
        } else {
             return false ;
        }
    } else {
        alert('Seleccione al menos 1 registro para eliminar');
        return  false ;
    }
}

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
