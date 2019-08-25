<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Datos del Titulo</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if (isset($custom_error) and  $custom_error!= '') {
                    echo '<div class="alert alert-danger">'.$custom_error.'</div>';
                } 
                ?>
                <form action="<?php echo current_url(); ?>" id="formInstitucion" method="post" class="form-horizontal" >
                    
                        <div class="control-group">
                            <label class="control-label" for="institucion" >Titulo<span class="required">*</span></label>
                            <div class="controls">
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
                                    if (isset($_GET['estudio']) OR isset($_POST['estudio'])){
                                        
                                        echo '<input type="hidden" name="estudio" value="';
                                        if (isset($_GET['estudio'])){
                                            echo $_GET['estudio'].'">';                                            
                                        }
                                        if (isset($_POST['estudio'])){
                                            echo $_POST['estudio'].'">';                                            
                                        }
                                        ?>
                                        <a href="<?php echo base_url()?>index.php/estudio/agregar" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
                                <?php  }else{   ?>
                                        <a href="<?php echo base_url()?>index.php/titulo" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
                                <?php    }
                                    ?>
                                
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




