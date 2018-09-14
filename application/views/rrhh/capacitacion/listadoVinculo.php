<a href="<?php echo base_url()?>index.php/capacitacion/vincular" class="btn btn-success"><i class="icon-resize-small icon-white"></i> Vincular Capacitacion a un empleado</a>
<?php
if(!$results){?>
<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
        </span>
        <h5>Capacitacion de personas</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Empleado</th>
            <th>Capacitacion</th>
            <th>Inicio</th>
            <th>Finaliza</th>
        </tr>
    </thead>
    <tbody>    
        <tr>
            <td colspan="5">No se encontraron capaciaciones</td>
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
        <h5>Capacitacion de personas</h5>

     </div>

<div class="widget-content nopadding">

<div style="overflow-x:auto;">
    <table class="table table-bordered" >
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Persona</th>
            <th>Capacitacion</th>
            <th>Inicio</th>
            <th>Finaliza</th>
            <th>Capacitador</th>
            <th>Modalidad</th>
            <th></th>
            
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            
            echo '<tr>';
            echo '<td>'.$r->idCapacitacionPersona.'</td>';
            echo '<td>'.$r->persona.'</td>';
            echo '<td>'.$r->tema.'</td>';
            echo '<td>'.$r->f_inicio.'</td>';
            echo '<td>'.$r->f_fin.'</td>';
            echo '<td>'.$r->capacitador.'</td>';
            echo '<td>'.$r->modalidad.'</td>';
            
            echo '<td>
                      
                        <a href="#modal-excluir" role="button" data-toggle="modal" capacitacionPersona_del="'.$r->idCapacitacionPersona.'" class="btn btn-danger tip-top" title="Eliminar Capacitacion"><i class="icon-remove icon-white"></i></a>
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
  <form action="<?php echo base_url() ?>index.php/capacitacion/eliminarCapacitacionPersona" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Eliminar Capacitacion</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idCapacitacionPersona" name="id" value="" />
    <h5 style="text-align: center">Realmente desea eliminar esta Capacitacion?</h5>
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
        var capacitacion = $(this).attr('capacitacionPersona_del');
        $('#idCapacitacionPersona').val(capacitacion);

    });

});

</script>

