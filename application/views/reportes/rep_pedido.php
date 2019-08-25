
<style>
    input[type=text],input[type=submit], input[type=date],select {
            width: 100%;
            height: 25px;
            
            box-sizing: border-box;
            
}
    
</style>        
<form method="get" action="#">
<!--            <div class="span2">
                <a href="#" class="btn btn-success span12"><i class="icon-plus icon-white"></i> Crear Ticket</a>
            </div>-->

        <div class="span12" >
            <div class="span12" >
                <div class="span2">
                    <label>Legajo</label>
                    <input type="text"  name="legajo"  id="persona"  placeholder="Legajo"  value="<?php echo $this->input->get('legajo'); ?>" >
                </div>
                <div class="span2">
                    <label>Persona</label>
                    <input type="text" name="persona"  id="persona"  placeholder="Empleado"  value="<?php echo $this->input->get('persona'); ?>" >
                </div>
                <div class="span2">
                    <label>Estado</label>
                    <select name="estado" id="estado" >
                        <option value="">Selecione estado</option>
                        <option value="1" <?php if($this->input->get('estado')==1){ echo "selected";} ?>>Pedido</option>
                        <option value="2" <?php if($this->input->get('estado')==2){ echo "selected";} ?>>Listo</option>
                        <option value="3" <?php if($this->input->get('estado')==3){ echo "selected";} ?>>Entregado</option>
                        <option value="4" <?php if($this->input->get('estado')==4){ echo "selected";} ?>>Cancelado</option>
                    </select>
                </div>            
                <div class="span2">
                    <label>Nota</label>
                    <input type="text" name="nota"  id="nota"  placeholder="Nota"  value="<?php echo $this->input->get('nota'); ?>" >
                </div>
                <div class="span2">
                    <label>Desde</label>
                    <input type="date" name="desde"  id="desde"  value="<?php echo $this->input->get('desde');?>">
                </div>
                <div class="span2">
                    <label>Hasta</label>
                    <input type="date" name="hasta"  id="hasta"  value="<?php echo $this->input->get('hasta');?>" >
                </div>
            </div>
            
            <div class="span12" style="margin-left: 0px;">
                <div class="span6">
                    <a href="<?php echo base_url();?>index.php/reportes/excel_pedido" class="btn btn-success"><i class="icon-download icon-white"></i>&nbsp; Descargar Excel</a>
                </div>
                <div class="span6">
                    <button class="btn pull-right"> <i class="icon-refresh"></i>&nbsp; Actualizar </button>
                </div>
                
            </div>
            <div class="span12"></div>
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
            <h5>Pedidos</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Legajo</th>
                        <th>Persona</th>
                        <th>Plato</th>
                        <th>Estado</th>
                        <th>Nota</th>
                        <th>Fecha Pedido</th>
                        <th>valor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="10">No hay Pedidos encontrados</td>
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
        <h5>Pedidos</h5>

     </div>

<div class="widget-content nopadding">

    
<div style="overflow-x:auto;">
<table class="table table-striped">
    <thead>
        <tr>
            <th>Legajo</th>
            <th>Persona</th>
            <th>Plato</th>
            <th>Estado</th>
            <th>Nota</th>
            <th>Fecha Pedido</th>
            <th>valor</th>
        </tr>
    </thead>
    <tbody>
        
        <?php 
            
            foreach ($results as $r) {
            echo '<tr>';
            echo '<td> '.$r->legajo.'</td>';
            echo '<td> '.$r->persona.'</td>';
            echo '<td> '.$r->plato.'</td>';
            echo '<td> '.$r->estado.'</td>';
            echo '<td> '.$r->nota.'</td>';
            echo '<td> '.date('d/m/Y',strtotime($r->f_pedido)).'</td>';
            echo '<td> '.$r->valor.'</td>';
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



 

