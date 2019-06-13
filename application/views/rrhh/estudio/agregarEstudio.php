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
                <h5>Datos del estudio</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">'.$custom_error.'</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formCandidato" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <div class="control-group">
                        <label  class="control-label">Titulo<span class="required">*</span></label>
                        <div class="controls">
                            <input id="titulo" type="text" name="titulo" value="<?php echo set_value('titulo'); ?>" required="required" />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label  class="control-label">Tipo<span class="required">*</span></label>
                        <div class="controls">
                            <select name="tipo" id="tipo">
                                <option <?php if(set_value('tipo')=="Curso") echo "Selected"; ?> value="Curso">Curso</option>    
                                <option <?php if(set_value('tipo')=="Universitario") echo "Selected"; ?> value="Universitario">Universitario</option>    
                                <option <?php if(set_value('tipo')=="Terciario") echo "Selected"; ?> value="Terciario">Terciario</option>    
                                <option <?php if(set_value('tipo')=="Secundario") echo "Selected"; ?> value="Secundario">Secundario</option>    
                                <option <?php if(set_value('tipo')=="Primario") echo "Selected"; ?> value="Primario">Primario</option>    
                                <option <?php if(set_value('tipo')=="Diploma") echo "Selected"; ?>value="Diploma">Diploma</option>    
                            </select>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label  class="control-label">Institucion <span class="required">*</span></label>
                        <div class="controls">
                            <select name="institucion" id="institucion">
                                <?php 
                                foreach($institucion as $i){
                                    echo "<option value='".$i->idInstitucion."'  ";
                                    if (set_value('institucion')==$i->idInstitucion){
                                        echo " selected ";
                                    }
                                    echo ">".$i->nombre."</option>";
                                }
                                
                                ?>
                            </select>
                            <a href="<?php echo base_url()?>index.php/institucion/agregar?estudio=1" class="btn btn-default btn-mini"><i class="icon-plus icon-white"></i> Agregar nueva institucion</a>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label  class="control-label">Fecha<span class="required">*</span></label>
                        <div class="controls">
                            <input id="fecha" type="date" name="fecha" value="<?php echo set_value('fecha'); ?>" required="required" />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="documento" class="control-label">Adjuntar Titulo <span class="required"></span></label>
                        <div class="controls">
                            <input type="file" class="form-control" name="userFiles[]" required="required"/>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar</button>
                                <!--<button class="btn btn-default" onclick="history.back()"><i class="icon-arrow-left"></i> Volver</button>-->
                                
                                <a href="<?php  echo base_url() ?>index.php/estudio" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
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


