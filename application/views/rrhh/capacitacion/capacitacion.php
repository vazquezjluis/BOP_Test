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
            <th>Inicio</th>
            <th>Finaliza</th>
            <th>Ver Personas que participan </th>
            
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
            <th>Titulo</th>
            <th>Descripcion</th>
            <th>Inicio</th>
            <th>Finaliza</th>
            <th>Ver Personas que participan </th>
            <th></th>
            
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            $personas_sector = '';
            /* Obtengo las personas y los sectores */
            if ($r->persona_sector!='' AND $r->persona_sector!=null){
                if ($r->persona_sector == 'T'){
                    //todas las personas del bingo 
                }else{
                    $sector_personas = explode('-_-', $r->persona_sector);
                    $pos = strpos($sector_personas[0], 'persona');
                    if ($pos === false) {
                        //hay personas
                        
                        $personas_sector .="<br>".$sector_personas[1];
                    } else {
                        //hay solo sectores
                        $personas_sector .="<br>".$sector_personas[0];
                        $personas_sector .="<br> ";
                        
                        $personas_sector .="<br>".$sector_personas[1];
                        
                    }
                }
                
            }else{
                $personas_sector.="Todas";
            }
            echo '<tr>';
            echo '<td>'.$r->idCapacitacion.'</td>';
            echo '<td>'.$r->titulo.'</td>';
            echo '<td>'.$r->descripcion.'</td>';
            echo '<td>'.$r->f_inicio.'</td>';
            echo '<td>'.$r->f_fin.'</td>';
            echo '<td style="max-width:300px;">'.$personas_sector.'</td>';
            
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
