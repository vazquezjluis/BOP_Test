<!--<a href="<?php // echo base_url();?>index.php/maquinas/agregar" class="btn btn-success">-->
<?php // if($this->permission->checkPermission($this->session->userdata('permiso'),'cArticulos')){ ?>
  <a href="<?php  echo base_url()?>index.php/seleccion_personal/agregar" class="btn btn-success">
    <i class="icon-plus icon-white"></i> Agregar nuevo Candidato</a>
<?php // } ?>


<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-barcode"></i>
            </span>
            <h5>Candidatos</h5>

        </div>

        <div class="widget-content nopadding">
            
            <div class="quick-actions_homepage">
                <p>No hay candidatos</p>
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
        <h5>Candidatos</h5>
        
     </div>

<div class="widget-content nopadding">
<div style="overflow-x:auto;">
<table class="table table-bordered">
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Domicilio</th>
        <th>Contacto</th>
        <th>Descripcion</th>
        <th>Estado</th>
        <th></th>
    </tr>
        <?php 
        foreach ($results as $r) {
//            if($r->estado == 1){$estado = "Activo";}else{$estado="Inactivo";}
//            if($r->categoria == 1){$categoria = "Electrónica";}else{$categoria="";}
            echo '<tr>';
                echo '<td>'.$r->idSeleccion_personal.'</td>';
                echo '<td>'.$r->nombre.'</td>';
                echo '<td>'.$r->apellido.'</td>';
                echo '<td>'.$r->domicilio.'</td>';
                echo '<td>'.$r->contacto.'</td>';
                echo '<td>'.$r->descripcion.'</td>';
                echo '<td>'.$r->meta_estado.' - '.date('d/m/Y H:m:s',  strtotime($r->fecha_meta_estado)).'</td>';
                
                echo '<td> ';
                 echo '<a href="'.base_url().'index.php/seleccion_personal/visualizar/'.$r->idSeleccion_personal.'"  class="btn tip-top" title="Ver detalle"><i class="icon-eye-open"></i></a>'; 
                 
//                if($this->permission->checkPermission($this->session->userdata('permiso'),'vPremios')){ 
                    echo '<a href="'.base_url().'index.php/seleccion_personal/editar/'.$r->idSeleccion_personal.'" class="btn btn-info tip-top" title="Editar Candidato"><i class="icon-pencil icon-white"></i></a>';
//                }
//                if($this->permission->checkPermission($this->session->userdata('permiso'),'vPremios')){
                    echo '<a href="#modal-excluir" class="btn btn-danger tip-top " role="button" data-toggle="modal" candidato="'.$r->idSeleccion_personal.'"  title="Eliminar candidato">
                                    <i class="icon-remove icon-white"></i></a>';
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



 

<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php   echo base_url() ?>index.php/seleccion_personal/desactivar" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Eliminar Candidato</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idCandidato" name="id" value="" />
    <h5 style="text-align: center">Realmente desea eliminar este candidato?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Eliminar</button>
  </div>
  </form>
</div>
<script type="text/javascript">
$(document).ready(function(){

   $(document).on('click', 'a', function(event) {       
        var candidato = $(this).attr('candidato');
        $('#idCandidato').val(candidato);

    });

});

</script>

