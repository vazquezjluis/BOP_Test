<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>

<?php 
if (isset($_GET['persona'])){
    $get = "?buscar=".$_GET['persona'];
}else{
    $get = '';
}

?>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <br>
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-list-alt"></i>
                </span>
                <h5>Desempeño <?php if (isset($_GET['persona'])){  echo "de ".strtoupper($_GET['persona_str']);} ?> </h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">'.$custom_error.'</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formDesempeno" enctype="multipart/form-data" method="post" class="form-horizontal" >
                    
                    <input name="idPersona" id="idPersona" type="hidden" value="<?php echo $_GET['persona']; ?>">
                    
                    <table class="table table-bordered">
                        <tr>
                            <th><b>Habilidades Técnicas</b></th>
                            <th><b>Regular</b></th>
                            <th><b>Buena</b></th>
                            <th><b>Muy Buena</b></th>
                        </tr>
                        <tr>
                            <td>Conocimiento Operativo de Tareas del Area</td>
                            <td><label><input type="radio" name="con_operativo" value="R"></label></td>
                            <td><label><input type="radio" name="con_operativo" value="B"></label></td>
                            <td><label><input type="radio" name="con_operativo" value="MB"></label></td>
                        </tr>
                        <tr>
                            <td>Conocimiento Técnico de Tareas del Area</td>
                            <td><label><input type="radio" name="con_tecnico" value="R"></label></td>
                            <td><label><input type="radio" name="con_tecnico" value="B"></label></td>
                            <td><label><input type="radio" name="con_tecnico" value="MB"></label></td>
                        </tr>
                        
                        
                        
                        <tr>
                            <th><b>Conducta</b></th>
                            <th><b>Regular</b></th>
                            <th><b>Buena</b></th>
                            <th><b>Muy Buena</b></th>
                        </tr>
                        <tr>
                            <td>Presencia, Prolijidad y Uso del uniforme</td>
                            <td><label><input type="radio" name="precencia_prolijidad" value="R"></label></td>
                            <td><label><input type="radio" name="precencia_prolijidad" value="B"></label></td>
                            <td><label><input type="radio" name="precencia_prolijidad" value="MB"></label></td>
                        </tr>
                        <tr>
                            <td>Cumplimiento de las normas generales del área y de la empresa</td>
                            <td><label><input type="radio" name="cumplimiento_normas" value="R"></label></td>
                            <td><label><input type="radio" name="cumplimiento_normas" value="B"></label></td>
                            <td><label><input type="radio" name="cumplimiento_normas" value="MB"></label></td>
                        </tr>
                        <tr>
                            <td>Puntualidad</td>
                            <td><label><input type="radio" name="puntualidad" value="R"></label></td>
                            <td><label><input type="radio" name="puntualidad" value="B"></label></td>
                            <td><label><input type="radio" name="puntualidad" value="MB"></label></td>
                        </tr>
                        <tr>
                            <td>Cumplimiento de modalidad de trabajo</td>
                            <td><label><input type="radio" name="cumplimiento_modalidad_trabajo" value="R"></label></td>
                            <td><label><input type="radio" name="cumplimiento_modalidad_trabajo" value="B"></label></td>
                            <td><label><input type="radio" name="cumplimiento_modalidad_trabajo" value="MB"></label></td>
                        </tr>
                        
                        <tr>
                            <th><b>Competencias</b></th>
                            <th><b>Regular</b></th>
                            <th><b>Buena</b></th>
                            <th><b>Muy Buena</b></th>
                        </tr>
                        <tr>
                            <td>Vocabulario</td>
                            <td><label><input type="radio" name="vocabulario" value="R"></label></td>
                            <td><label><input type="radio" name="vocabulario" value="B"></label></td>
                            <td><label><input type="radio" name="vocabulario" value="MB"></label></td>
                        </tr>
                        <tr>
                            <td>Trabajo en equipo</td>
                            <td><label><input type="radio" name="trabajo_equipo" value="R"></label></td>
                            <td><label><input type="radio" name="trabajo_equipo" value="B"></label></td>
                            <td><label><input type="radio" name="trabajo_equipo" value="MB"></label></td>
                        </tr>
                        <tr>
                            <td>Capacidad de Organizacion</td>
                            <td><label><input type="radio" name="capacidad_organizacion" value="R"></label></td>
                            <td><label><input type="radio" name="capacidad_organizacion" value="B"></label></td>
                            <td><label><input type="radio" name="capacidad_organizacion" value="MB"></label></td>
                        </tr>
                        <tr>
                            <td>Vocacion de servicio</td>
                            <td><label><input type="radio" name="vocacion_servicio" value="R"></label></td>
                            <td><label><input type="radio" name="vocacion_servicio" value="B"></label></td>
                            <td><label><input type="radio" name="vocacion_servicio" value="MB"></label></td>
                        </tr>
                        <tr>
                            <td>Capacidad de analisis y organizacion</td>
                            <td><label><input type="radio" name="capacidad_analisis" value="R"></label></td>
                            <td><label><input type="radio" name="capacidad_analisis" value="B"></label></td>
                            <td><label><input type="radio" name="capacidad_analisis" value="MB"></label></td>
                        </tr>
                        <tr>
                            <td colspan="4">Observacion:<br><textarea rows="6" name="obs" style="width:90%;"></textarea></td>
                        </tr>
                        
                        
                    </table>
                    
                    

                    
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar</button>
                                <?php 
                                    if (isset($_GET['persona'])){
                                        ?>
                                        <a href="javascript:history.back()" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
                                    <?php
                                    }else{
                                        ?>
                                        <!--<a href="<?php // echo base_url() ?>index.php/capacitacion/listadoVinculo" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>-->
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
          
          $("#cancel").hide();
          $("#persona").autocomplete({
            source: "<?php echo base_url(); ?>index.php/licencia/autoCompletePersona",
            minLength: 1,
            select: function( event, ui ) {
                 $("#persona_id").val(ui.item.id);
                 $("#persona").attr("readonly",true);
                 $("#cancel").show();
                }
          });
          
          $("#cancel").click(function(){
              $("#persona_id").val("");
              $("#persona").val("");
              $("#persona").attr("readonly",false);
              $(this).hide();
          });
          
          
          
      });
      
        
 

</script>


