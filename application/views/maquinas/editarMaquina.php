<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Editar Maquina <?php echo $result->idMaquina; ?></h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formMaquina" method="post" class="form-horizontal" >
                    <div class="control-group">
                        <?php echo form_hidden('idMaquina',$result->idMaquina) ?>
                        <label for="nro_egm" class="control-label">Nro. EGM/UID <span class="required">*</span></label>
                        <div class="controls">
                            <input id="nro_egm" type="number" name="nro_egm" value="<?php echo $result->nro_egm; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="fabricante" class="control-label">Fabricante <span class="required">*</span></label>
                        <div class="controls">
                            <input id="fabricante" type="text" name="fabricante" value="<?php echo $result->fabricante; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="modelo" class="control-label">Modelo <span class="required">*</span></label>
                        <div class="controls">
                            <input id="modelo" type="text" name="modelo" value="<?php echo $result->modelo; ?>"  />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="p_pago" class="control-label">% Pago <span class="required">*</span></label>
                        <div class="controls">
                            <input id="p_pago" type="text" name="p_pago" value="<?php echo $result->p_pago; ?>"  />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="denom" class="control-label">Denominacion <span class="required">*</span></label>
                        <div class="controls">
                            <input id="denom" type="text" name="denom" value="<?php echo $result->denom; ?>"  />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="juego" class="control-label">Juego <span class="required">*</span></label>
                        <div class="controls">
                            <input id="juego" type="text" name="juego" value="<?php echo $result->juego; ?>"  />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="nro_serie" class="control-label">Nro. Serie<span class="required">*</span></label>
                        <div class="controls">
                            <input id="nro_serie" type="text" name="nro_serie" value="<?php echo $result->nro_serie; ?>"  />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="programa" class="control-label">Programa <span class="required">*</span></label>
                        <div class="controls">
                            <input id="programa" type="text" name="programa" value="<?php echo $result->programa; ?>"  />
                        </div>
                    </div>
                    
                    
                    <div class="control-group">
                        <label for="credito" class="control-label">Credito <span class="required">*</span></label>
                        <div class="controls">
                            <input id="credito" type="text" name="credito" value="<?php echo $result->credito; ?>"  />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="ap_minima" class="control-label">Apuesta minima</label>
                        <div class="controls">
                            <input id="ap_minima" type="text" name="ap_minima" value="<?php echo $result->ap_minima; ?>"  />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="ap_maxima" class="control-label">Apuesta maxima</label>
                        <div class="controls">
                            <input id="ap_maxima" type="text" name="ap_maxima" value="<?php echo $result->ap_maxima; ?>"  />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="cat_lineas" class="control-label">Cantidad de lineas</label>
                        <div class="controls">
                            <input id="cant_lineas" type="text" name="cant_lineas" value="<?php echo $result->cant_lineas; ?>"  />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="tipo_juego" class="control-label">Tipo de juego </label>
                        <div class="controls">
                            <select name="tipo_juego" id="tipo_juego">
                                <?php 
                                $monojuego = '';
                                $multijuego = '';
                                if($result->tipo_juego == 'monojuego'){$monojuego = 'selected'; $multijuego = '';} else if($result->tipo_juego =='multijuego'){$monojuego = ''; $multijuego = 'selected';} ?>
                                <option value="" >Seleccione</option>
                                <option value="monojuego" <?php echo $monojuego; ?>>Monojuego</option>
                                <option value="multijuego" <?php echo $multijuego; ?>>Multijuego</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label  class="control-label">Estado <span class="required">*</span></label>
                        <div class="controls">
                            <select name="estado" id="estado">
                                <?php if($result->estado == 1){$ativo = 'selected'; $inativo = '';} else{$ativo = ''; $inativo = 'selected';} ?>
                                <option value="1" <?php echo $ativo; ?>>Activo</option>
                                <option value="0" <?php echo $inativo; ?>>Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Modificar</button>
                                <a href="javascript:history.back()" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
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


