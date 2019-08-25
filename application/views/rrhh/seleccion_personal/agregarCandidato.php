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
                <h5>Datos del candidato</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">'.$custom_error.'</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formCandidato" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <div class="control-group">
                        <label  class="control-label">Nombre <span class="required">*</span></label>
                        <div class="controls">
                            <input id="nombre" type="text" name="nombre" value="<?php echo set_value('nombre'); ?>" required="required" />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label  class="control-label">Apellido<span class="required">*</span></label>
                        <div class="controls">
                            <input id="apellido" type="text" name="apellido" value="<?php echo set_value('apellido'); ?>" required="required" />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label  class="control-label">Domicilio<span class="required">*</span></label>
                        <div class="controls">
                            <input id="domicilio" type="text" name="domicilio" value="<?php echo set_value('domicilio'); ?>" required="required" />
                        </div>
                    </div>
                    
                    
                    <div class="control-group">
                        <label  class="control-label">Contacto<span class="required">*</span></label>
                        <div class="controls">
                            <input id="contacto" type="text" name="contacto" value="<?php echo set_value('domicilio'); ?>" required="required" />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label  class="control-label">Fuente de reclutamiento <span class="required">*</span></label>
                        <div class="controls">
                            <select name="fuente_reclutamiento" id="fuente_reclutamiento">
                                <option value="Webs Laborales">Webs Laborales</option>
                                <option value="Entrevista Espontanea">Entrevista Espontanea</option>
                                <option value="Referido">Referido</option>
                                <option value="Consultora">Consultora</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label  class="control-label">Estado <span class="required">*</span></label>
                        <div class="controls">
                            <select name="meta_estado" id="meta_estado">
                                <option value="Citado a entrevista">Citado a entrevista</option>
                                <option value="2da entrevista">2da entrevista</option>
                                <option value="Psicotecnico">Psicotecnico</option>
                                <option value="Ingreso">Ingreso</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label  class="control-label">Fecha<span class="required">*</span></label>
                        <div class="controls">
                            <input id="fecha_meta_estado" type="datetime-local" name="fecha_meta_estado" value="<?php echo set_value('fecha_meta_Estado'); ?>" required="required" />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="descripcion" class="control-label">Descripcion </label>
                        <div class="controls">
                            <textarea  id="descripcion" type="text" name="descripcion"><?php echo set_value('descripcion'); ?></textarea>   
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="documento" class="control-label">Adjuntar CV <span class="required"></span></label>
                        <div class="controls">
                            <input type="file" class="form-control" name="userFiles[]" required="required"/>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar</button>
                                <!--<button class="btn btn-default" onclick="history.back()"><i class="icon-arrow-left"></i> Volver</button>-->
                                
                                <a href="<?php  echo base_url() ?>index.php/seleccion_personal" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
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
          
           $('#formCandidato').validate({
            rules : {
                  nombre:{ required: true},
                  apellido:{ required: true},
                  contacto:{required:true}
                  
            },
            messages: {
                  nombre :{ required: 'Campo Requerido'},
                  apellido :{ required: 'Campo Requerido'},
                  contacto :{ required: 'Campo Requerido'}
            },

            errorClass: "help-inline",
            errorElement: "span",
            highlight:function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
           });
           
        $('#file-input').change(function(e) {
            addImage(e); 
           });

            function addImage(e){
             var file = e.target.files[0],
             imageType = /image.*/;

             if (!file.type.match(imageType))
              return;

             var reader = new FileReader();
             reader.onload = fileOnload;
             reader.readAsDataURL(file);
            }

            function fileOnload(e) {
              var result=e.target.result;
              $('#imgSalida').attr("src",result);
              $('#guardar_imagen').show();
              $('#lbl_file').hide();
             }
     

      });
</script>


