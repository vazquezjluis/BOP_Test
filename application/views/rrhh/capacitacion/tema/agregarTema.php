<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Datos del Tema</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if (isset($custom_error) and  $custom_error!= '') {
                    echo '<div class="alert alert-danger">'.$custom_error.'</div>';
                } 
                ?>
                <form action="<?php echo current_url(); ?>" id="formTema" method="post"  >
                     
                    <div class="span12" style="padding: 1%">
                        <div class="span3">
                            <label for="tema" >Tema<span class="required">*</span></label>
                            <input  type="text" id="nombre" name="nombre" required="required" >    
                        </div>
                    </div> 
                    
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar</button>
                                <?php 
                                if (isset($idCapacitacion)){
                                    ?>
                                <a href="<?php echo base_url()?>index.php/capacitacion/editar/<?php echo $idCapacitacion;?>" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
                                <?php
                                }else{
                                    ?>
                                <a href="<?php echo base_url()?>index.php/capacitacion/agregar" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
                                <?php
                                }
                                ?>
                                
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
          
      });
</script>




