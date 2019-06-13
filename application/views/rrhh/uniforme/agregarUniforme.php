<?php if (count($_POST)>0){
     
    echo "<script>history.back();</script>";
}?>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Datos de la Prenda</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">'.$custom_error.'</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formCandidato" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <div class="control-group">
                        <label  class="control-label">Prenda<span class="required">*</span></label>
                        <div class="controls">
                            <input id="prenda" type="text" name="prenda" value="<?php echo set_value('prenda'); ?>" required="required" />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label  class="control-label">Tipo de prenda<span class="required">*</span></label>
                        <div class="controls">
                            <select name="tipo_prenda" id="tipo_prenda">
                                <option value="camisa">Camisa</option>
                                <option value="pantalon">Pantalon</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label  class="control-label">Talle<span class="required">*</span></label>
                        <div class="controls">
                            <input id="talle" type="text" name="talle" value="<?php echo set_value('talle'); ?>" required="required" />
                        </div>
                    </div>
                    
                    
                    <div class="control-group">
                        <label  class="control-label">Cantidad<span class="required">*</span></label>
                        <div class="controls">
                            <input id="cantidad" type="text" name="cantidad" value="<?php echo set_value('cantidad'); ?>" required="required" />
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar</button>
                                <!--<button class="btn btn-default" onclick="history.back()"><i class="icon-arrow-left"></i> Volver</button>-->
                                
                                <a href="<?php  echo base_url() ?>index.php/uniforme" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
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
          
//           $('#formCandidato').validate({
//            rules : {
//                  nombre:{ required: true},
//                  apellido:{ required: true},
//                  contacto:{required:true}
//                  
//            },
//            messages: {
//                  nombre :{ required: 'Campo Requerido'},
//                  apellido :{ required: 'Campo Requerido'},
//                  contacto :{ required: 'Campo Requerido'}
//            },
//
//            errorClass: "help-inline",
//            errorElement: "span",
//            highlight:function(element, errorClass, validClass) {
//                $(element).parents('.control-group').addClass('error');
//            },
//            unhighlight: function(element, errorClass, validClass) {
//                $(element).parents('.control-group').removeClass('error');
//                $(element).parents('.control-group').addClass('success');
//            }
//           });

      });
</script>


