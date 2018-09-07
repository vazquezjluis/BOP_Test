<!--<a href="<?php // echo base_url();?>index.php/maquinas/agregar" class="btn btn-success">-->
            <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'cFallas')){ ?>
              <a href="<?php echo base_url()?>index.php/fallas/agregar" class="btn btn-success">
                <i class="icon-plus icon-white"></i> Agregar nueva Falla</a>
            <?php } ?>


<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-lock"></i>
            </span>
            <h5>Fallas</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tipo</th>
                        <th>Descripcion</th>
                        <th>Gravedad</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">No hay fallas cargadas</td>
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
        <h5>Fallas disponibles</h5>

     </div>

<div class="widget-content nopadding">

<div style="overflow-x:auto;">
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Tipo</th>
            <th>Descripcion</th>
            <th>Estado</th>
            <th>Gravedad</th>
            <th>Articulo/s asociado/s</th>
            <th style="width: 25%;">Accion</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $articulos = array();
        if (isset($results_articulo)){
            foreach ($results_articulo as $ra){
                $articulos [$ra->idArticulo]= $ra->nombre;
            }
        }
        
        $gravedad = array(
            1=>array("important","Grave"),
            2=>array("warning","Media"),
            3=>array("success","Menor")
        );
        foreach ($results as $r) {
            if($r->estado == 1){$estado = "Activo";}else{$estado="Inactivo";}
            echo '<tr>';
                echo '<td>'.$r->idFallas.'</td>';
                echo '<td>'.$r->tipo.'</td>';
                echo '<td>'.$r->descripcion.'</td>';
                echo '<td>'.$estado.'</td>';
                echo '<td><span class="label label-'.$gravedad[$r->gravedad][0].'">'.$gravedad[$r->gravedad][1].'</span></td>';
                echo '<td>';
                    if($r->articulo!=''){
                        $str_art = '';
                        $explo = explode("-_-", $r->articulo);
                        foreach ($explo as $e){
                            $str_art.= ", ".$articulos[$e];
                        }
                        echo substr($str_art, 1);
                    }
                echo '</td>';
                echo '<td> ';
                if($this->permission->checkPermission($this->session->userdata('permiso'),'eFallas')){ 
                    echo '<a href="'.base_url().'index.php/fallas/editar/'.$r->idFallas.'" class="btn btn-info tip-top" title="Editar Falla"><i class="icon-pencil icon-white"></i></a>';
                }
                if($this->permission->checkPermission($this->session->userdata('permiso'),'dFallas')){
                    echo '<a href="#modal-excluir" class="btn btn-danger tip-top " role="button" data-toggle="modal" falla="'.$r->idFallas.'"  title="Eliminar Falla">
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
<?php  echo $this->pagination->create_links();
}?>



 
<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/fallas/desactivar" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Eliminar falla</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idFalla" name="id" value="" />
    <h5 style="text-align: center">Realmente desea eliminar esta falla?</h5>
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
        var falla = $(this).attr('falla');
        $('#idFalla').val(falla);

    });

});

</script>

