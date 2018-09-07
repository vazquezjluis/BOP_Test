
        
<form method="get" action="#">
<!--            <div class="span2">
                <a href="#" class="btn btn-success span12"><i class="icon-plus icon-white"></i> Crear Ticket</a>
            </div>-->
            <div class="span12" >
                <div class="span3">
                    <!--<label>Articulo</label>-->
                    <input type="text" name="articulo"  id="articulo"  placeholder="Articulo o Parte"  value="<?php echo $this->input->get('articulo'); ?>" >
                </div>
                <div class="span3">
                    <!--<label>Articulo</label>-->
                    <select id="estado" name="estado">
                        <option <?php if ($this->input->get('estado')==1){ echo "selected";} ?> value="1">Averiados</option>
                        <option <?php if ($this->input->get('estado')==2){ echo "selected";} ?> value="2">Reparados</option>
                    </select>
                    
                </div>
                <div class="span2">
                    <!--<label>&nbsp;</label>-->
                    <button class="span6 btn"> <i class="icon-search"></i> </button>
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
            <h5>Partes, Articulos o Dispositivos en Labororatorio</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                       <th>#</th>
                        <th>Articulo/Parte</th>
                        <th>Fecha Ingreso</th>
                        <th>Emisor</th>
                        <th>Asignado</th>
                        <th>Ver</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="10">No hay Articulos o partes en el laboratorio</td>
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
        <h5>Labororatorio</h5>

     </div>

<div class="widget-content nopadding">

    
<div style="overflow-x:auto;">
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Articulo/Parte</th>
            <th>Fecha Ingreso</th>
            <th>Emisor</th>
            <th>Asignado</th>
            <th>Estado</th>
            <th>Ver</th>
        </tr>
    </thead>
    <tbody>
        
        <?php 
            $estado = array(
                1=>"Averiado",
                2=>"Reparado"
            );
            foreach ($results as $r) {
                
            echo '<tr">';
            echo '<td>'.$r->idArticuloLaboratorio.'</td>';
            echo '<td> '.$r->articulo_str.'</td>';
            echo '<td>'.date('d/m/Y H:m:s',strtotime($r->fecha_hora)).'</td>';
            echo '<td>'.$r->usuario_str.'</td>';
            echo '<td>'.$r->asignado_str.'</td>';
            echo '<td>'.$estado[$r->estado].'</td>';
            echo '<td><a href="'.base_url().'index.php/laboratorio/visualizar/'.$r->idArticuloLaboratorio.'" style="margin-right: 1%" class="btn tip-top" title="Detalles"><i class="icon-eye-open"></i></a></td>';
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





