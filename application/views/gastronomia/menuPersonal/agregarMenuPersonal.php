<div class="span12" style="margin-left: 0">
    <form action="<?php echo base_url();?>index.php/menuPersonal/agregar" id="formMenu" method="post">

    <div class="span12" style="margin-left: 0">
        
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-lock"></i>
                </span>
                <h5>Datos del Menu</h5>
            </div>
            <div class="widget-content">
                
                <div class="span6">
                    <label>Descripcion</label>
                    <input name="descripcion" type="text" id="descripcion" class="span12"  required="required"/>

                </div>

    
            <div class="form-actions">
                <div class="span12">
                    <div class="span6 offset3">
                        <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar</button>
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


 
    $("#formMenu").validate({
        rules :{
            descripcion: {required: true}
        },
        messages:{
            descripcion: {required: 'Campo obligatorio'}
        }
    });     

        

    });
</script>

