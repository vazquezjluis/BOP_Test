<!--<table class="table table-bordered" style="background-color: #FFF;">
    <tbody>
    <tr>
        <td><a  href="<?php // echo base_url()?>index.php/capacitacion/listadoVinculo"><label><i class="icon-user"></i>&nbsp;-&nbsp;Capacitacion de personas&nbsp;&nbsp;<i class="icon-arrow-right"></i></label></a></td>
    </tr>
    <tr>
        <td><label><a  href="<?php // echo base_url()?>index.php/capacitacion/listadoCapacitacion"><i class="icon-folder-open"></i>&nbsp;-&nbsp;Capacitacion ABM</a>&nbsp;&nbsp;<i class="icon-arrow-right"></i></label></td>
    </tr>
    </tbody>
</table>-->


<a href="<?php echo base_url()?>index.php/capacitacion/agregar" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar nuevo Curso o Capacitacion</a>
<?php
if(!$results){?>
<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
        </span>
        <h5>Capacitacion</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Titulo</th>
            <th>Descripcion</th>
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
        <h5>Capacitacion</h5>

     </div>

<div class="widget-content nopadding">

<div style="overflow-x:auto;">
    <table class="table table-bordered" >
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Tema</th>
            <th>Descripcion</th>
            <th>Modalidad</th>
            <th></th>
            
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            
            echo '<tr>';
            echo '<td>'.$r->idCapacitacion.'</td>';
            echo '<td>'.$r->temaNombre.'</td>';
            echo '<td>'.$r->descripcion.'</td>';
            echo '<td>'.$r->modalidad.'</td>';
            
            echo '<td>
                      <a href="'.base_url().'index.php/capacitacion/editar/'.$r->idCapacitacion.'" class="btn btn-info tip-top" title="Editar Usuário"><i class="icon-pencil icon-white"></i></a>
                          <a href="#modal-excluir" role="button" data-toggle="modal" capacitacion_del="'.$r->idCapacitacion.'" class="btn btn-danger tip-top" title="Eliminar Capacitacion"><i class="icon-remove icon-white"></i></a>
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
  <form action="<?php echo base_url() ?>index.php/capacitacion/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Eliminar Capacitacion</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idCapacitacion" name="id" value="" />
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
        var capacitacion = $(this).attr('capacitacion_del');
        $('#idCapacitacion').val(capacitacion);

    });

});

</script>

