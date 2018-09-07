
        
<form method="get" action="#">
<!--            <div class="span2">
                <a href="#" class="btn btn-success span12"><i class="icon-plus icon-white"></i> Crear Ticket</a>
            </div>-->

        <div class="span12" >
            <div class="span12" >
                <div class="span4">
                    <label>Descripcion</label>
                    <input type="text" name="descripcion"  id="descripcion"  placeholder="Descripcion"  value="<?php echo $this->input->get('descripcion'); ?>" >
                </div>
                <div class="span4">
                    <label>Estado</label>
                    <select name="estado" id="estado" >
                        <option value="">Selecione estado</option>
                        <option value="1" <?php if($this->input->get('estado')==1){ echo "selected";} ?>>Abierto</option>
                        <option value="2" <?php if($this->input->get('estado')==2){ echo "selected";} ?>>Resuelto</option>
                        <option value="3" <?php if($this->input->get('estado')==3){ echo "selected";} ?>>Cerrado</option>
                        <option value="4" <?php if($this->input->get('estado')==4){ echo "selected";} ?>>Cancelado</option>
                    </select>
                </div>            
                <div class="span4">
                    <label>emisor</label>
                    <select name="emisor" id="emisor" >
                        <option value="">Seleccione emisor</option>
                        <?php 
                        foreach($results_usuario as $ru){
                            echo "<option value='".$ru->idUsuarios."' "   ;
                            if ($ru->idUsuarios == $this->input->get('emisor')){
                                echo " selected ";
                            }
                            echo ">".$ru->nombre."</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            
            <div class="span12" style="margin-left: 0px;">
                <div class="span4">
                    <label>Desde</label>
                    <input type="date" name="desde"  id="desde"  value="<?php echo $this->input->get('desde');?>">
                </div>
                <div class="span4">
                    <label>Hasta</label>
                    <input type="date" name="hasta"  id="hasta"  value="<?php echo $this->input->get('hasta');?>" >
                </div>
                <div class="span4">
                    <label>&nbsp;</label>
                    <button class="span6 btn"> <i class="icon-search"></i> </button>
                </div>
            </div>
        </div>
    </form>
  
<!--<a href="<?php // echo base_url();?>index.php/ticket/agregar" class="btn btn-success">-->
    <!--<i class="icon-plus icon-white"></i> Agregar nuevo Ticket</a>-->
<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-lock"></i>
            </span>
            <h5>Ticekts</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>F. Solicitud</th>
                        <th>Descripcion</th>
                        <th>Referencia</th>
                        <th>Solicita</th>
                        <th>Prioridad</th>
                        <th>F. Proceso</th>
                        <th>Asignado</th>
                        <th>Estado</th>
                        <th>Ver</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="10">No hay Tickets encontrados</td>
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
            <i class="icon-tags"></i>
         </span>
        <h5>Tickets</h5>

     </div>

<div class="widget-content nopadding">

    
<div style="overflow-x:auto;">
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>F. Solicitud</th>
            <th>Solicita</th>
            <th>Descripcion</th>
            <th>Referencia</th>
            <th>Prioridad</th>
            <th>Asignado</th>
            <th>Estado</th>
            <th>Ver</th>
        </tr>
    </thead>
    <tbody>
        
        <?php 
            $estado = array(
                1=>"Abierto",
                2=>"Resuelto",
                3=>"Cerrado",
                4=>"Cancelado"
            );
            $prioridad = array(
                0=>array("success","baja"),
                1=>array("important","alta"),
                2=>array("warning","media"),
                3=>array("",""),
                4=>array("",""),
                ''=>array("","")
            );
            foreach ($results as $r) {
            $link_ini = '<a href="'.base_url().'index.php/ticket/detalle/'.$r->idTicket.'class="btn btn-info tip-top" title="Editar Permiso">';
            $link_fin = '</a>';
            echo '<tr">';
            echo '<td>'.$r->idTicket.'</td>';
            echo '<td>'.date('d/m/Y H:m:s',strtotime($r->f_solicitud)).'</td>';
            echo '<td> '.$r->solicita.'</td>';
            echo '<td> '.$r->descripcion.'</td>';
            echo '<td> '.$r->referencia.'</td>';
            echo '<td><span class="badge badge-'.$prioridad[$r->prioridad][0].'">'.$prioridad[$r->prioridad][1].'</span></td>';
            echo '<td>'.$r->asignado.'</td>';
            echo '<td>'.$estado[$r->estado].'</td>';
            echo '<td><a href="'.base_url().'index.php/ticket/visualizar/'.$r->idTicket.'" style="margin-right: 1%" class="btn tip-top" title="Detalles"><i class="icon-eye-open"></i></a></td>';
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
  <form action="<?php echo base_url() ?>index.php/permisos/desactivar" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Desactivar Permiso</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idPermiso" name="id" value="" />
    <h5 style="text-align: center">Realmente desea desactivar este permiso?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Desactivar</button>
  </div>
  </form>
</div>


