<?php  if ($this->permission->checkPermission($this->session->userdata('permiso'),'cMenu')){ ?>
    <a href="<?php echo base_url();?>index.php/menuPersonal/agregar" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar nuevo Menu</a>
<?php
}
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
                        <th>Estado</th>
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
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
     
            
            if($r->fecha_menu == date('Y-m-d')){$estado = '<div class="alert alert-success">Activo</div>';}else{$estado = '<div class="alert alert-danger">Inactivo</div>';}
            echo '<tr>';
            echo '<td>'.$r->idMenuPersonal.'</td>';
            echo '<td>'.$r->descripcion.'</td>';
            echo '<td>'.date('d/m/Y',strtotime($r->fecha_menu)).'</td>';
            echo '<td>'.$estado.'</td>';
            echo '<td>';
            //if ($this->permission->checkPermission($this->session->userdata('permiso'),'eMenu')){
              //  if ($r->estado == 1){
                //    echo '<a href="#modal-excluir" role="button" data-toggle="modal" menu="'.$r->idMenuPersonal.'" class="btn btn-danger tip-top" title="desactivar Menu"><i class="icon-remove icon-white"></i></a>';
                //}else{
                  //  echo '<a href="#modal-activar"role="button" data-toggle="modal" menu="'.$r->idMenuPersonal.'"  class="btn tip-top" title="Activar"><i class="icon-ok icon-white"></i></a>';
               // }
            //}    
            echo '&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;';
            //if ($this->permission->checkPermission($this->session->userdata('permiso'),'eMenu')){
              //  echo '<a href="'.base_url().'index.php/menuPersonal/editar/'.$r->idMenuPersonal.'" class="btn btn-info tip-top" title="Editar Permiso"><i class="icon-pencil icon-white"></i></a>';
           // }
            if ($this->permission->checkPermission($this->session->userdata('permiso'),'dMenu')){
                echo '<a href="#modal-eliminar" role="button" data-toggle="modal" menu="'.$r->idMenuPersonal.'" class="btn btn-danger tip-top" title="Eliminar Menu"><i class="icon-trash icon-white"></i></a>';
            }
            echo '      </td>';
            echo '</tr>';
        }?>
        <tr>
            
        </tr>
    </tbody>
</table>
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
$(document).ready(function(){

   $(document).on('click', 'a', function(event) {       
        var menu = $(this).attr('menu');
        $('#idMenu').val(menu);
        $('#idMenu_eliminar').val(menu);
        $('#idMenu_activar').val(menu);

    });

});

</script>
