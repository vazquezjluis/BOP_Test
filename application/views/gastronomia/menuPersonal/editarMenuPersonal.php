

<div class="row-fluid" style="margin-top:0">
    <div class="span12" >

        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-lock"></i>
                </span>
                <h5>Editar Menu</h5>
            </div>

            <div class="widget-content nopadding">

                  <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">'.$custom_error.'</div>';
                } ?>
                <form action="<?php echo base_url();?>index.php/menuPersonal/editar" id="formMenuPersonal"  class="form-horizontal" method="post">

                    <div class="control-group">
                        <label for="descripcion" class="control-label">Plato</label>
                        <div class="controls">
                            <input name="descripcion" type="text" id="descripcion"  value="<?php echo $result->descripcion; ?>" />
                            <input type="hidden" name="idMenuPersonal" value="<?php echo $result->idMenuPersonal; ?>">
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="fecha_menu" class="control-label">Fecha del menu</label>
                        <div class="controls">
                            <input name="fecha_menu" type="date" id="fecha_menu"  value="<?php echo $result->fecha_menu; ?>" />
                        </div>
                    </div>

                     <div class="control-group">
                        <label  class="control-label">Tipo de Menu<span class="required">*</span></label>
                        <div class="controls">
                            <select  name="tipo_menu" id="tipo_menu"  required="required">
                                <option value="externo" <?php if ($result->tipo_menu=='externo' or $result->tipo_menu=='') echo 'selected'; ?>>Externo (Proveedor)</option>
                                <option value="interno" <?php if ($result->tipo_menu=='interno') echo 'selected'; ?>>Interno (Refrigerios del Bingo)</option>
                            </select>
                        </div>
                    </div>

                    <?php
                    if ($result->tipo_menu == "externo"){
                     ?>
                    <div class="control-group">
                        <label for="valor" class="control-label">Valor </label>
                        <div class="controls ">
                            <div class="alert alert-info span9">Este es un menu externo por lo tanto su valor solo puede ser modificado desde el panel.</div>
                        </div>
                    </div>


                    <?php
                    }else{
                    ?>
                    <div class="control-group">
                        <label for="valor" class="control-label">Valor $</label>
                        <div class="controls">
                            <input name="valor" type="number" id="valor"     value="<?php echo $result->valor; ?>" />
                        </div>
                    </div>
                    <?php }?>
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Modificar</button>
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



    $("#formMenuPersonal").validate({
        rules :{
            descripcion: {required: true}
        },
        messages:{
            descripcion: {required: 'Campo obligatorio'}
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
