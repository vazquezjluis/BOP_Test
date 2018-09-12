<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>



<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Vincular Licencia</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">'.$custom_error.'</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formVinculoLicencia" enctype="multipart/form-data" method="post" class="form-horizontal" >
                    <div class="control-group">
                        <label  class="control-label">Persona <span class="required">*</span></label>
                        <div class="controls" id="persona_select">
                            <div class="input-append span6">
                                <input name="persona"  class="input-block-level" id="persona" value="<?php echo set_value('persona'); ?>" type="text" required="required">
                                <button id="cancel" type="button" class="btn btn-success" >Limpiar</button>
                            </div>
                        </div>
                        <input name="persona_id" id="persona_id" type="hidden" value="0">
                    </div>
                    
                    <div class="control-group">
                        <label  class="control-label">Licencia <span class="required">*</span></label>
                        <div class="controls">
                            <select name="licencia" id="licencia" required="required">
                                <option value="">Seleccione</option>
                                
                                <?php
                                 foreach ($licencia as $lic){
                                     echo "<option value='".$lic->idLicencia."'  ";
                                     if (set_value('licencia')==$lic->idLicencia){
                                         echo " selected ";
                                     }
                                     echo ">".$lic->titulo."</option>";
                                 }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="descripcion" class="control-label">Descripcion <span class="required">*</span></label>
                        <div class="controls">
                            <textarea id="descripcion" type="text" name="descripcion"  required="required" ></textarea>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="dias" class="control-label">Dias<span class="required">*</span></label>
                        <div class="controls">
                            <input id="descripcion" type="number" name="dias"  required="required" />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="documento" class="control-label">Adjuntar comprobante <span class="required"></span></label>
                        <div class="controls">
                            <input id="file-input" accept="image/*" type="file" required="true" name="userfile[]" multiple=""  />
                        </div>
                    </div>

                    
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar</button>
                                <a href="<?php echo base_url() ?>index.php/licencia" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
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


