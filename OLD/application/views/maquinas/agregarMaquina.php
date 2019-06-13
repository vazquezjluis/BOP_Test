<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Datos de la máquina</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">'.$custom_error.'</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formMaquina" method="post" class="form-horizontal" >
                    <div class="control-group">
                        <label for="nro_egm" class="control-label">UID/Nro.EGM <span class="required">*</span></label>
                        <div class="controls">
                            <input id="nro_egm" type="number" name="nro_egm" value="<?php echo set_value('nro_egm'); ?>" required="required" />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="fabricante" class="control-label">Fabricante <span class="required">*</span></label>
                        <div class="controls">
                            <input id="fabricante" type="text" name="fabricante" value="<?php echo set_value('fabricante'); ?>" required="required" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="modelo" class="control-label">Modelo <span class="required">*</span></label>
                        <div class="controls">
                            <input id="modelo" type="text" name="modelo" value="<?php echo set_value('modelo'); ?>"  required="required"/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="p_pago" class="control-label">% Pago <span class="required">*</span></label>
                        <div class="controls">
                            <input id="p_pago" type="text" name="p_pago" value="<?php echo set_value('p_pago'); ?>" required="required" />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="denom" class="control-label">Denominación <span class="required">*</span></label>
                        <div class="controls">
                            <input id="denom" type="text" name="denom" value="<?php echo set_value('denom'); ?>"  required="required"/>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="juego" class="control-label">Juego <span class="required">*</span></label>
                        <div class="controls">
                            <input id="juego" type="text" name="juego" value="<?php echo set_value('juego'); ?>"  required="required"/>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="nro_serie" class="control-label">Nro. Serie <span class="required">*</span></label>
                        <div class="controls">
                            <input id="nro_serie" type="text" name="nro_serie" value="<?php echo set_value('nro_serie'); ?>"  required="required"/>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="programa" class="control-label">Programa <span class="required">*</span></label>
                        <div class="controls">
                            <input id="programa" type="text" name="programa" value="<?php echo set_value('programa'); ?>"  required="required"/>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="credito" class="control-label">Crédito <span class="required">*</span></label>
                        <div class="controls">
                            <input id="credito" type="text" name="credito" value="<?php echo set_value('credito'); ?>"  required="required"/>
                        </div>
                    </div>


                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar</button>
                                <a href="<?php echo base_url() ?>index.php/maquinas" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
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

           $('#formMaquina').validate({
            rules : {
                  nro_egm:{ required: true},
                  fabricante:{ required: true},
                  modelo:{ required: true},
                  p_pago:{ required: true},
                  denom:{ required: true},
                  juego:{ required: true},
                  nro_serie:{ required: true},
                  programa:{ required: true},
                  credito:{ required: true}
            },
            messages: {
                  nro_egm :{ required: 'Campo Requerido.'},
                  fabricante:{ required: 'Campo Requerido.'},
                  modelo:{ required: 'Campo Requerido.'},
                  p_pago:{ required: 'Campo Requerido.'},
                  denom:{ required: 'Campo Requerido.'},
                  juego:{ required: 'Campo Requerido.'},
                  nro_serie:{ required: 'Campo Requerido.'},
                  programa:{ required: 'Campo Requerido.'},
                  credito:{ required: 'Campo Requerido.'}
                  
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


