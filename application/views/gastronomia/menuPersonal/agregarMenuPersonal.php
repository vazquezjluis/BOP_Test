    
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Datos del Menu</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">'.$custom_error.'</div>';
                } ?>
                <form action="<?php echo base_url();?>index.php/menuPersonal/agregar" id="formMenu" method="post" class="form-horizontal" >
                    
                    
                    <div class="control-group">
                        <label for="descripcion" class="control-label">Descripcion <span class="required">*</span></label>
                        <div class="controls">
                            <input id="descripcion" type="text" name="descripcion" value="<?php echo set_value('descripcion'); ?>" required="required" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label  class="control-label">Fecha del Menu<span class="required">*</span></label>
                        <div class="controls">
                            <input name="fecha_menu" type="date" id="fecha_menu"   required="required">
                        </div>
                    </div>
                    

                    <div class="control-group">
                        <label  class="control-label">Tipo de Menu<span class="required">*</span></label>
                        <div class="controls">
                            <select  name="tipo_menu" id="tipo_menu"  required="required">
                                <option value="externo">Externo (Proveedor)</option>
                                <option value="interno">Interno (Refrigerios del Bingo)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="valor" class="control-label">Valor $</label>
                        <div class="controls">
                            <input name="valor" type="number" id="valor" value="" />
                        </div> 
                    </div> 
                    
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar</button>
                                <a href="<?php echo base_url() ?>index.php/menuPersonal" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>






<script type="text/javascript" src="<?php echo base_url()?>assets/js/validate.js"></script>
<script type="text/javascript">
    $(document).ready(function(){


 
    $("#formMenu").validate({
        rules :{
            descripcion: {required: true}
        },
        messages:{
            descripcion: {required: 'Campo obligatorio'}
        }
    });     

        

    });
</script>

