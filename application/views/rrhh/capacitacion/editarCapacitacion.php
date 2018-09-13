<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Editar Capacitacion</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formCapacitacion" method="post"  >
                    
                    <?php echo form_hidden('idCapacitacion',$result->idCapacitacion) ?>
                     <!--Tema , capacitador, institucion-->
                    <div class="span12" style="padding: 1%">
                        <div class="span4">
                            <label for="titulo" >Tema<span class="required">*</span></label>
                            <input id="tema" type="text" name="tema" value="<?php echo $result->tema; ?>" required="required"  />
                        </div>
                        <div class="span4">
                            <label for="capacitador" >Capacitador<span class="required">*</span></label>
                            <input id="capacitador" type="text" placeholder="Nombre y Apellido" name="capacitador" value="<?php echo $result->capacitador; ?>"  />
                        </div>
                        <div class="span4">
                            <label for="institucion" >Institucion<span class="required">*</span></label>
                            <input id="institucion" type="text" placeholder="Area o establecimiento" name="institucion" value="<?php echo $result->institucion; ?>"  />
                        </div>
                    </div>
                    
                     <!--inicio, fin, institucion-->
                    <div class="span12" style="padding: 1%; margin-left: 0px;">
                        <div class="span4">
                            <label for="f_inicio" class="control-label">Fecha Inicio<span class="required">*</span></label>
                            <input id="f_inicio" type="date" name="f_inicio" value="<?php echo $result->f_inicio; ?>" required="required" />
                        </div>
                        <div class="span4">
                            <label for="f_fin" class="control-label">Fecha Finalizacion<span class="required">*</span></label>
                            <input id="f_fin" type="date" name="f_fin" value="<?php echo $result->f_fin; ?>" required="required" />
                        </div>
                        <div class="span4">
                            <label for="cupo" >Cupo<span class="required">*</span></label>
                            <input id="cupo" type="number" placeholder="" name="cupo" value="<?php echo $result->cupo; ?>" required="required" />
                        </div>
                    </div>
                     
                     
                    <div class="span12" style="padding: 1%; margin-left: 0px;">
                        <div class="span4">
                            <label for="modalidad" class="control-label">Modalidad<span class="required">*</span></label>
                            <label class="label "><input style="margin-left: 10px;" <?php if ($result->modalidad == "modalidad" ){ echo 'checked="true"';} ?> type="radio"  name="modalidad" value="taller"> Taller</label>
                            <label class="label "><input style="margin-left: 10px;" <?php if ($result->modalidad == "seminario" ){ echo 'checked="true"';} ?> type="radio"  name="modalidad" value="seminario"> Seminario</label>
                            <label class="label "><input style="margin-left: 10px;" <?php if ($result->modalidad == "curso" ){ echo 'checked="true"';} ?> type="radio"  name="modalidad" value="curso"> Curso</label>
                        </div>
                        <div class="span4">
                            <label for="evaluacion" class="control-label">Evaluacion<span class="required">*</span></label>
                            <label class="label "><input style="margin-left: 10px;" type="radio" <?php if ($result->evaluacion == "no" ){ echo 'checked="true"';}  ?> name="evaluacion" value="no"> No</label>
                            <label class="label "><input style="margin-left: 10px;" type="radio" <?php if ($result->evaluacion== "si" ){ echo 'checked="true"';}  ?> name="evaluacion" value="si"> Si</label>
                        </div>
                        <div class="span4">
                            <label for="tipo" class="control-label">Tipo<span class="required">*</span></label>
                            <label class="label "><input style="margin-left: 10px;" type="radio" <?php if ($result->tipo== "interno" ){ echo 'checked="true"';}  ?>  name="tipo" value="interno"> Interno</label>
                            <label class="label "><input style="margin-left: 10px;" type="radio" <?php if ($result->tipo == "externo" ){ echo 'checked="true"';}  ?> name="tipo" value="externo"> Externo</label>
                        </div>
                        
                    </div>
                     
                    <div class="span12" style="padding: 1%; margin-left: 0px;">
                        <div class="span6">
                            <label for="descripcion" class="control-label">Descripcion<span class="required">*</span></label>
                            <textarea id="descripcion" class="span12" rows="5"  type="text" name="descripcion"   ><?php echo $result->descripcion ;?></textarea>
                        </div>
                    </div> 
                    
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Modificar</button>
                                <a href="<?php echo base_url() ?>index.php/capacitacion" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
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

           $('#formUsuario').validate({
            rules : {
                  nombre:{ required: true},
                  email:{ required: true,email:true}
            },
            messages: {
                  nombre :{ required: 'Campo Requerido.'},
                  email:{ required: 'Campo Requerido.',email:'Ingrese un correo electrónico válido.'}

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


