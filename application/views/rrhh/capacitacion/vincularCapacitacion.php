<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>

<?php 
if (isset($_GET['persona'])){
    $get = "?buscar=".$_GET['persona'];
}else{
    $get = '';
}

?>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Vincular Capacitacion  <?php if (isset($_GET['persona'])){  echo "a ".strtoupper($_GET['persona_str']);} ?> </h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">'.$custom_error.'</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formVinculoLicencia" enctype="multipart/form-data" method="post" class="form-horizontal" >
                    <?php if (!isset($_GET['persona'])){?>
                    <div class="control-group">
                        <label  class="control-label">
                            <label class="btn btn-default btn-mini"><input style="margin-left: 10px;margin-top:  -2px;" type="radio" checked="true" name="autocompleta" value="1"> Persona</label>
                            <label class="btn btn-default btn-mini"><input style="margin-left: 10px;;margin-top:  -2px;" type="radio" disabled="true" name="autocompleta" value="2"> Sector </label>
                            
                        </label>
                        <div class="controls" id="persona_select">
                            <div class="input-append span6">
                                <input name="persona" placeholder="escribe el nombre del empleado"  class="input-block-level" id="persona" value="<?php echo set_value('persona'); ?>" type="text" required="required">
                                <button id="cancel" type="button" class="btn btn-success" >Limpiar</button>
                            </div>
                        </div>
                        <input name="persona_id" id="persona_id" type="hidden" value="0">
                    </div>
                    <?php }
                    else{
                        echo '<input name="desde_persona"  type="hidden" value="1">';
                        echo '<input name="persona_id" id="persona_id" type="hidden" value="'.$_GET['persona'].'">';
                    }
                    ?>
                    <div class="control-group">
                        <label  class="control-label">Capacitacion <span class="required">*</span></label>
                        <div class="controls">
                            <div class="input-append span6">
                            <select name="capacitacion" id="capacitacion" required="required" class="input-block-level">
                                <option value="">Seleccione</option>
                                
                                <?php
                                                
                                 foreach ($capacitacion as $cap){
                                     echo "<option value='".$cap->idCapacitacion."'  ";
                                     if (set_value('capacitacion')==$cap->idCapacitacion){
                                         echo " selected ";
                                     }
                                     echo ">".$cap->temaNombre."</option>";
                                 }
                                ?>
                            </select>
                            </div>
                            <a href="<?php echo base_url()?>index.php/capacitacion/agregar" class="btn btn-default btn-mini"><i class="icon-plus icon-white"></i> Agregar nuevo Curso o Capacitacion</a>
                        </div>
                    </div>
                    
                    

                    
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar</button>
                                <?php 
                                    if (isset($_GET['persona'])){
                                        ?>
                                        <a href="javascript:history.back()" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
                                    <?php
                                    }else{
                                        ?>
                                        <a href="<?php echo base_url() ?>index.php/capacitacion/listadoVinculo" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
                                        <?php
                                    }

                                    ?>
                                
                                
                            </div>
                        </div>
                    </div>
                    
                        

                </form>
            </div>
        </div>
    </div>
</div>


<script  src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
      $(document).ready(function(){
          
          $("#cancel").hide();
          $("#persona").autocomplete({
            source: "<?php echo base_url(); ?>index.php/licencia/autoCompletePersona",
            minLength: 1,
            select: function( event, ui ) {
                 $("#persona_id").val(ui.item.id);
                 $("#persona").attr("readonly",true);
                 $("#cancel").show();
                }
          });
          
          $("#cancel").click(function(){
              $("#persona_id").val("");
              $("#persona").val("");
              $("#persona").attr("readonly",false);
              $(this).hide();
          });
          
          
          
      });
      
        
 

</script>


