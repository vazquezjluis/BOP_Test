
<div class="span12" style="margin-left: 0">
    <form action="<?php echo base_url();?>index.php/menuPersonal/editar" id="formMenuPersonal" method="post">

    <div class="span12" style="margin-left: 0">
        
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-lock"></i>
                </span>
                <h5>Editar Permiso</h5>
            </div>
            <div class="widget-content">
                
            <div class="span4">
                <label>Descripcion</label>
                <input name="descripcion" type="text" id="descripcion" class="span12" value="<?php echo $result->descripcion; ?>" />
                <input type="hidden" name="idMenuPersonal" value="<?php echo $result->idMenuPersonal; ?>">
            </div>


    
            <div class="form-actions">
                <div class="span12">
                    <div class="span6 offset3">
                        <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Modificar</button>
                        <a href="<?php echo base_url() ?>index.php/menuPersonal" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
                    </div>
                </div>
            </div>
           
            </div>
        </div>

                   
    </div>

</form>

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
