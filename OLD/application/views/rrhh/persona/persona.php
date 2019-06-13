<!--<a href="<?php // echo base_url();?>index.php/maquinas/agregar" class="btn btn-success">-->
<?php // if($this->permission->checkPermission($this->session->userdata('permiso'),'cArticulos')){ ?>
  <!--<a href="<?php // echo base_url()?>index.php/articulo/agregar" class="btn btn-success">-->
    <!--<i class="icon-plus icon-white"></i> Agregar nuevo Articulo</a>-->
<?php // } ?>


<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-barcode"></i>
            </span>
            <h5>Persona</h5>

        </div>

        <div class="widget-content nopadding">
            
            <div class="quick-actions_homepage">
                <p>No hay personas cargadas en el sistema</p>
            </div>

        </div>
    </div>

<?php }else{
	

?>
<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-barcode"></i>
         </span>
        <h5>Personas</h5>
        
     </div>

<div class="widget-content nopadding">
<div style="overflow-x:auto;">
<table class="table table-bordered">
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Puesto</th>
        <th></th>
    </tr>
        <?php 
        foreach ($results as $r) {
//            if($r->estado == 1){$estado = "Activo";}else{$estado="Inactivo";}
//            if($r->categoria == 1){$categoria = "Electrónica";}else{$categoria="";}
            echo '<tr>';
                echo '<td>'.$r->id.'</td>';
                echo '<td>'.$r->nombre.'</td>';
                echo '<td>'.$r->apellido.'</td>';
                echo '<td>'.$r->PUESTO_TRABAJO.'</td>';
                
                echo '<td> ';
                 echo '<a href="'.base_url().'index.php/persona/visualizar/'.$r->id.'"  class="btn tip-top" title="Ver detalle"><i class="icon-eye-open"></i></a>'; 
                 
//                if($this->permission->checkPermission($this->session->userdata('permiso'),'eArticulos')){ 
//                    echo '<a href="'.base_url().'index.php/articulo/editar/'.$r->idArticulo.'" class="btn btn-info tip-top" title="Editar Articulo"><i class="icon-pencil icon-white"></i></a>';
//                }
//                if($this->permission->checkPermission($this->session->userdata('permiso'),'dArticulos')){
//                    echo '<a href="#modal-excluir" class="btn btn-danger tip-top " role="button" data-toggle="modal" articulo="'.$r->idArticulo.'"  title="Eliminar Articulo">
//                                    <i class="icon-remove icon-white"></i></a>';
//                }             
                echo'</td>';
            echo '</tr>';
            
        }?>
    </tbody>
</table>
</div>
</div>
</div>
<?php   echo $this->pagination->create_links(); 
}?>



 
<!-- Modal --
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php //  echo base_url() ?>index.php/articulo/desactivar" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Eliminar Articulo</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idArticulo" name="id" value="" />
    <h5 style="text-align: center">Realmente desea eliminar este articulo?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Eliminar</button>
  </div>
  </form>
</div -->
<script type="text/javascript">
//$(document).ready(function(){
//
//   $(document).on('click', 'a', function(event) {       
//        var articulo = $(this).attr('articulo');
//        $('#idArticulo').val(articulo);
//
//    });
//
//});

</script>

