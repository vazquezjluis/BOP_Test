<!--<a href="<?php // echo base_url();?>index.php/maquinas/agregar" class="btn btn-success">-->
<?php  if($this->permission->checkPermission($this->session->userdata('permiso'),'cEstudio')){ ?>
  <a href="<?php  echo base_url()?>index.php/estudio/agregar" class="btn btn-success">
    <i class="icon-plus icon-white"></i> Agregar nuevo Estudio</a>
<?php  } ?>


<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-barcode"></i>
            </span>
            <h5>Estudios</h5>

        </div>

        <div class="widget-content nopadding">
            
            <div class="quick-actions_homepage">
                <p>No hay estudios</p>
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
        <h5>Estudios</h5>
        
     </div>

<div class="widget-content nopadding">
<div style="overflow-x:auto;">
<table class="table table-bordered">
    <tr>
        <th>#</th>
        <th>Titulo</th>
        <th>Tipo</th>
        <th>Institucion</th>
        <th>Fecha</th>
        <th></th>
    </tr>
        <?php 
        foreach ($results as $r) {
//            if($r->estado == 1){$estado = "Activo";}else{$estado="Inactivo";}
//            if($r->categoria == 1){$categoria = "Electrónica";}else{$categoria="";}
            echo '<tr>';
                echo '<td>'.$r->idEstudio.'</td>';
                echo '<td>'.$r->titulo.'</td>';
                echo '<td>'.$r->tipo.'</td>';
                echo '<td>'.$r->institucion.'</td>';
                
                echo '<td>'.$r->fecha.'</td>';
                
                echo '<td> ';
                 
                if($this->permission->checkPermission($this->session->userdata('permiso'),'eEstudio')){ 
                    echo '<a href="'.base_url().'index.php/estudio/editar/'.$r->idEstudio.'" class="btn btn-info tip-top" title="Editar Candidato"><i class="icon-pencil icon-white"></i></a>';
                }
                if($this->permission->checkPermission($this->session->userdata('permiso'),'dEstudio')){
                    echo '<a href="#modal-excluir" class="btn btn-danger tip-top " role="button" data-toggle="modal" candidato="'.$r->idEstudio.'"  title="Eliminar candidato">
                                    <i class="icon-remove icon-white"></i></a>';
                }             
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
  <form action="<?php   echo base_url() ?>index.php/estudio/desactivar" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Eliminar Estudio</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idCandidato" name="id" value="" />
    <h5 style="text-align: center">Realmente desea eliminar este estudio?</h5>
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

