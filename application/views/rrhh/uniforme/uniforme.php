<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.dataTables.min.js" ></script>
<link href="<?php  echo base_url()?>assets/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/>

<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-barcode"></i>
         </span>
        <h5>Prendas</h5>
        
     </div>

<div class="widget-content nopadding">
<div style="overflow-x:auto;">
<table class="table table-bordered" id="registros">
    <thead>
    <tr>
        <th>#</th>
        <th>Descripcion</th>
        <th>Detalles</th>
    </tr>
    </thead>
    <tbody>
        <?php 
        foreach ($results as $r) {
            echo '<tr>';
                echo '<td>'.$r->cod.'</td>';
                echo '<td>'.$r->DescripcionGral.'</td>';
                echo '<td>'.$r->DescripcionATR1.'  '.$r->DescripcionATR2.'  '.$r->DescripcionATR3.'</td>';
            echo '</tr>';
            
        }?> 
    </tbody>
</table>
</div>
</div>
</div>
<script type="text/javascript">
      $(document).ready(function(){
          //tbla de datos
          $('#registros').dataTable( {
            "bInfo": false,
            "bLengthChange": false,
            "nTHead":false
          } );
          
      });
              
 

</script>

