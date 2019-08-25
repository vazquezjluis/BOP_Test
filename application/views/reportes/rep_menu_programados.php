

<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.dataTables.min.js" ></script>
<link href="<?php  echo base_url()?>assets/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
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
                    <a href="<?php echo base_url();?>index.php/reportes/excel_calendariomenu" class="btn btn-success"><i class="icon-download icon-white"></i>&nbsp; Descargar Excel</a>
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
            <h5>Menus programados</h5>

        </div>

        <div class="widget-content nopadding">
            <tableclass="table table-bordered">
                <thead>
                    <tr>
                        <th>Legajo</th>
                        <th>Persona</th>
                        <th>Plato</th>
                        <th>Fecha programado</th>
                        <th>Fecha registrado</th>
                        <!--<th>valor</th>-->
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
        <h5>Menus Programados</h5>

     </div>

<div class="widget-content nopadding">

    
<div style="overflow-x:auto;">
    <table id="registros" class="table table-striped">
    <thead>
        <tr>
            <th>Legajo</th>
            <th>Persona</th>
            <th>Plato</th>
            <th>Fecha programado</th>
            <th>Fecha registrado</th>
            <!--<th>valor</th>-->
        </tr>
    </thead>
    <tbody>
        
        <?php 
            
            foreach ($results as $r) {
            echo '<tr>';
            echo '<td> '.$r->legajo.'</td>';
            echo '<td> '.$r->persona.'</td>';
            echo '<td> '.$r->plato.'</td>';
//            echo '<td> '.$r->estado.'</td>';
//            echo '<td> '.$r->nota.'</td>';
            echo '<td> '.date('d/m/Y',strtotime($r->start)).'</td>';
            echo '<td> '.date('d/m/Y',strtotime($r->f_registro)).'</td>';
//            echo '<td> '.$r->valor.'</td>';
            echo '</tr>';
        }?>
       
    </tbody>
</table>
</div>
</div>
</div>
<?php //echo $this->pagination->create_links();
}
?>
<script>
$(document).ready(function(){
//tbla de datos
          $('#registros').dataTable( {
            "bInfo": false,
            "bLengthChange": false,
            "nTHead":false
          } );

});

</script>


 

