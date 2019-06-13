<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Editar Premio</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formPremio" method="post" class="form-horizontal" >
                    <div class="control-group">
                        <?php echo form_hidden('idPremio',$result->idPremio) ?>
                        <label for="nombre" class="control-label">Premio<span class="required">*</span></label>
                        <div class="controls">
                            <input id="nombre" type="text" name="nombre" value="<?php echo $result->nombre; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="descripcion" class="control-label">Descripcion<span class="required">*</span></label>
                        <div class="controls">
                            <input id="descripcion" type="text" name="descripcion" value="<?php echo $result->descripcion; ?>"  />
                        </div>
                    </div>
                     
                    <div class="control-group">
                        <label  class="control-label">Tipo <span class="required">*</span></label>
                        <div class="controls">
                            <label class="label label-default"><input style="margin-left: 10px;" type="radio" name="tipo" value="Mensual" <?php if($result->tipo == 'Mensual'){?>checked="true"<?php }?> >Mensual</label>
                            <label class="label label-default"><input style="margin-left: 10px;" type="radio" name="tipo" value="Anual" <?php if($result->tipo == 'Anual'){?>checked="true"<?php }?> >Anual</label>
                            <label class="label label-default"><input style="margin-left: 10px;" type="radio" name="tipo" value="Otro" <?php if($result->tipo == 'Otro'){?>checked="true"<?php }?> >Otro</label>
                        </div>
                        
                    </div>
                    
                    <div class="control-group">
                        <label  class="control-label">Meses cumplidos <span class="required">*</span></label>
                        <div class="controls">
                            <input id="mes_cumplido" type="number" style="width: 40px;"  name="mes_cumplido" value="<?php echo $result->mes_cumplido; ?>" />
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Modificar</button>
                                <!--<button onclick="history.back()" class="btn"/><i class="icon-arrow-left"></i>Volver</button>-->
                                <a href="<?php echo base_url() ?>index.php/premio/" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
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
                  titulo:{ required: true},
                  dias:{ required: true}
            },
            messages: {
                  titulo :{ required: 'Campo Requerido.'},
                  dias:{ required: 'Campo Requerido.'}

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



