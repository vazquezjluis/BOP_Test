<a href="<?php echo base_url()?>index.php/licencia/vincular" class="btn btn-success"><i class="icon-plus icon-white"></i> Vincular Licencia a un empleado</a>

<?php
if(!$results){?>
<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
        </span>
        <h5>Licencias tomadas</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Empleado</th>
            <th>Licencia</th>
            <th>Dias</th>
        </tr>
    </thead>
    <tbody>    
        <tr>
            <td colspan="5">No se encontraron licencias</td>
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
        <h5>Licencias tomadas</h5>

     </div>

<div class="widget-content nopadding">

<div style="overflow-x:auto;">
    <table class="table table-bordered" >
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Empleado</th>
            <th>Licencia</th>
            <th>Inicia Licencia</th>
            <th>Finaliza</th>
            <th>Dias</th>
            <th></th>
            
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            echo '<tr>';
            echo '<td>'.$r->idLicenciaPersona.'</td>';
            echo '<td>'.$r->persona.'</td>';
            echo '<td>'.$r->licencia.'</td>';
            echo '<td>'.$r->f_inicio.'</td>';
            echo '<td>'.$r->f_fin.'</td>';
            echo '<td>'.$r->dias.'</td>';
            echo '<td>
                        <a href="#modal-excluir" role="button" data-toggle="modal" 
                        licencia_persona_del="'.$r->idLicenciaPersona.'" class="btn btn-danger tip-top" title="Eliminar Licencia"><i class="icon-remove icon-white"></i></a>
                  </td>';
            echo '</tr>';
        }?>
        <tr>
            
        </tr>
    </tbody>
</table>
</div>
</div>
</div>

	
<?php echo $this->pagination->create_links();}?>

<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/licencia/eliminarLicencia_persona" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Eliminar Licencia</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idLicencia_persona" name="id" value="" />
    <h5 style="text-align: center">Realmente desea eliminar esta Licencia?</h5>
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
        var licencia = $(this).attr('licencia_persona_del');
        $('#idLicencia_persona').val(licencia);

    });

});

</script>
