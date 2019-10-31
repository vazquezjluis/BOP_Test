<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Editar Candidato</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formCandidato" method="post" class="form-horizontal" >
                    <div class="control-group">
                        <?php echo form_hidden('idSeleccion_personal',$result->idSeleccion_personal) ?>
                        <label for="candidato" class="control-label">Nombre<span class="required">*</span></label>
                        <div class="controls">
                            <input id="nombre" type="text" name="nombre" value="<?php echo $result->nombre; ?>"  />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="apellido" class="control-label">Apellido<span class="required">*</span></label>
                        <div class="controls">
                            <input id="apellido" type="text" name="apellido" value="<?php echo $result->apellido; ?>"  />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="domicilio" class="control-label">Domicilio<span class="required">*</span></label>
                        <div class="controls">
                            <input id="domicilio" type="text" name="domicilio" value="<?php echo $result->domicilio; ?>"  />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="contacto" class="control-label">Contacto<span class="required">*</span></label>
                        <div class="controls">
                            <input id="contacto" type="text" name="contacto" value="<?php echo $result->contacto; ?>"  />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label  class="control-label">Fuente de reclutamiento <span class="required">*</span></label>
                        <div class="controls">
                            <select name="fuente_reclutamiento" id="fuente_reclutamiento">
                                <option value="Webs Laborales" <?php if($result->fuente_reclutamiento=='Webs Laborales'){ echo "selected";} ?>>Webs Laborales</option>
                                <option value="Entrevista Espontanea" <?php if($result->fuente_reclutamiento=='Entrevista Espontanea'){ echo "selected";} ?>>Entrevista Espontanea</option>
                                <option value="Referido" <?php if($result->fuente_reclutamiento=='Referido'){ echo "selected";} ?>>Referido</option>
                                <option value="Consultora" <?php if($result->fuente_reclutamiento=='Consultora'){ echo "selected";} ?>>Consultora</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label  class="control-label">Estado <span class="required">*</span></label>
                        <div class="controls">
                            <select name="meta_estado" id="meta_estado">
                                <option value="Citado a entrevista" <?php if($result->meta_estado=='Citado a entrevista'){ echo "selected";} ?>>Citado a entrevista</option>
                                <option value="2da entrevista" <?php if($result->meta_estado=='2da entrevista'){ echo "selected";} ?>>2da entrevista</option>
                                <option value="Psicotecnico" <?php if($result->meta_estado=='Psicotecnico'){ echo "selected";} ?>>Psicotecnico</option>
                                <option value="Ingreso" <?php if($result->meta_estado=='Ingreso'){ echo "selected";} ?>>Ingreso</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label  class="control-label">Fecha<span class="required">*</span></label>
                        <div class="controls">
                            <input id="fecha_meta_Estado" type="datetime-local" name="fecha_meta_estado" value="<?php echo str_replace("AR","",date('Y-m-dTH:m', strtotime($result->fecha_meta_estado))); ?>" required="required" />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label  class="control-label">Sector <span class="required">*</span></label>
                        <div class="controls">
                            <?php if (isset($sector)) { ?>
                            <select name="sector" id="sector">
                                <?php 
                                     foreach ($sector as $s){
                                         ?>
                                <option value="<?php echo $s->id; ?>" <?php if ($s->id == $result->sector ){ echo "selected";}?>><?php echo $s->descripcion; ?></option>
                                <?php
                                     }
                                ?>
                            </select>
                            <?php } else { echo "error al obtener los sectores..." ;} ?>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="descripcion" class="control-label">Descripcion<span class="required">*</span></label>
                        <div class="controls">
                            <textarea  id="descripcion" type="text" name="descripcion"><?php echo $result->descripcion; ?></textarea>   
                        </div>
                    </div>
                     
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Modificar</button>
                                <!--<button onclick="history.back()" class="btn"/><i class="icon-arrow-left"></i>Volver</button>-->
                                <a href="<?php echo base_url() ?>index.php/seleccion_personal/" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
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



