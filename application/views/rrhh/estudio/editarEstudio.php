<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Editar Estudio</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                    
                }
                echo "<pre>";
                    var_dump( date('d/m/Y',  strtotime($result->fecha)));
                    echo "</pre>";
                ?>
                <form action="<?php echo current_url(); ?>" id="formEstudio" method="post" class="form-horizontal" >
                    <div class="control-group">
                        <?php echo form_hidden('idEstudio',$result->idEstudio) ?>
                        <label for="titulo" class="control-label">Titulo<span class="required">*</span></label>
                        <div class="controls">
                            <input id="titulo" type="text" name="titulo" value="<?php echo $result->titulo; ?>"  />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label  class="control-label">Tipo<span class="required">*</span></label>
                        <div class="controls">
                            <select name="tipo" id="tipo">
                                <option <?php if($result->tipo=="Curso") echo "Selected"; ?> value="Curso">Curso</option>    
                                <option <?php if($result->tipo=="Universitario") echo "Selected"; ?> value="Universitario">Universitario</option>    
                                <option <?php if($result->tipo=="Terciario") echo "Selected"; ?> value="Terciario">Terciario</option>    
                                <option <?php if($result->tipo=="Secundario") echo "Selected"; ?> value="Secundario">Secundario</option>    
                                <option <?php if($result->tipo=="Primario") echo "Selected"; ?> value="Primario">Primario</option>    
                                <option <?php if($result->tipo=="Diploma") echo "Selected"; ?>value="Diploma">Diploma</option>    
                            </select>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label  class="control-label">Institucion<span class="required">*</span></label>
                        <div class="controls">
                            <select name="institucion" id="institucion">
                                <?php 
                                foreach($institucion as $i){
                                    echo "<option value='".$i->idInstitucion."'  ";
                                    if ($result->institucion==$i->idInstitucion){
                                        echo " selected ";
                                    }
                                    echo ">".$i->nombre."</option>";
                                }
                                
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label  class="control-label">Fecha<span class="required">*</span></label>
                        <div class="controls">
                            <input id="fecha" type="date" name="fecha" value="<?php echo $result->fecha; ?>" required="required" />
                        </div>
                    </div>
                    
                     
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Modificar</button>
                                <!--<button onclick="history.back()" class="btn"/><i class="icon-arrow-left"></i>Volver</button>-->
                                <a href="<?php echo base_url() ?>index.php/estudio/" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
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
                  contacto:{ required: true}
            },
            messages: {
                  nombre :{ required: 'Campo Requerido.'},
                  apellido:{ required: 'Campo Requerido.'},
                  contacto:{ required: 'Campo Requerido.'}

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

      });
</script>



