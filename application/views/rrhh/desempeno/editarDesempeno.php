<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>


<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <br>
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-list-alt"></i>
                </span>
                <h5>Desempeño <?php echo "de ".$result->idPersona; ?> </h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">'.$custom_error.'</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formDesempeno" enctype="multipart/form-data" method="post" class="form-horizontal" >
                    <input name="idPersona" id="idPersona" type="hidden" value="<?php echo $result->idPersona; ?>">
                    <table class="table table-bordered">
                        <tr>
                            <th><b>Habilidades Técnicas</b></th>
                            <th><b>Regular</b></th>
                            <th><b>Buena</b></th>
                            <th><b>Muy Buena</b></th>
                        </tr>
                        <tr>
                            <td>Conocimiento Operativo de Tareas del Area</td>
                            <td><label><input type="radio" name="con_operativo" value="R" <?php if ($result->con_operativo=="R"){echo 'checked="true"';}?>></label></td>
                            <td><label><input type="radio" name="con_operativo" value="B" <?php if ($result->con_operativo=="B"){echo 'checked="true"';}?>></label></td>
                            <td><label><input type="radio" name="con_operativo" value="MB"<?php if ($result->con_operativo=="MB"){echo 'checked="true"';}?>></label></td>
                        </tr>
                        <tr>
                            <td>Conocimiento Técnico de Tareas del Area</td>
                            <td><label><input type="radio" name="con_tecnico" value="R" <?php if ($result->con_tecnico=="R"){echo 'checked="true"';}?>></label></td>
                            <td><label><input type="radio" name="con_tecnico" value="B" <?php if ($result->con_tecnico=="B"){echo 'checked="true"';}?>></label></td>
                            <td><label><input type="radio" name="con_tecnico" value="MB"<?php if ($result->con_tecnico=="MB"){echo 'checked="true"';}?>></label></td>
                        </tr>
                        
                        <tr>
                            <th><b>Conducta</b></th>
                            <th><b>Regular</b></th>
                            <th><b>Buena</b></th>
                            <th><b>Muy Buena</b></th>
                        </tr>
                        <tr>
                            <td>Presencia, Prolijidad y Uso del uniforme</td>
                            <td><label><input type="radio" name="precencia_prolijidad" value="R" <?php if ($result->precencia_prolijidad=="R"){echo 'checked="true"';}?>></label></td>
                            <td><label><input type="radio" name="precencia_prolijidad" value="B" <?php if ($result->precencia_prolijidad=="B"){echo 'checked="true"';}?>></label></td>
                            <td><label><input type="radio" name="precencia_prolijidad" value="MB"<?php if ($result->precencia_prolijidad=="MB"){echo 'checked="true"';}?>></label></td>
                        </tr>
                        <tr>
                            <td>Cumplimiento de las normas generales del área y de la empresa</td>
                            <td><label><input type="radio" name="cumplimiento_normas" value="R" <?php if ($result->cumplimiento_normas=="R"){echo 'checked="true"';}?>></label></td>
                            <td><label><input type="radio" name="cumplimiento_normas" value="B" <?php if ($result->cumplimiento_normas=="B"){echo 'checked="true"';}?>></label></td>
                            <td><label><input type="radio" name="cumplimiento_normas" value="MB"<?php if ($result->cumplimiento_normas=="MB"){echo 'checked="true"';}?>></label></td>
                        </tr>
                        <tr>
                            <td>Puntualidad</td>
                            <td><label><input type="radio" name="puntualidad" value="R" <?php if ($result->puntualidad=="R"){echo 'checked="true"';}?>></label></td>
                            <td><label><input type="radio" name="puntualidad" value="B" <?php if ($result->puntualidad=="B"){echo 'checked="true"';}?>></label></td>
                            <td><label><input type="radio" name="puntualidad" value="MB"<?php if ($result->puntualidad=="MB"){echo 'checked="true"';}?>></label></td>
                        </tr>
                        <tr>
                            <td>Cumplimiento de modalidad de trabajo</td>
                            <td><label><input type="radio" name="cumplimiento_modalidad_trabajo" value="R" <?php if ($result->cumplimiento_modalidad_trabajo=="R"){echo 'checked="true"';}?>></label></td>
                            <td><label><input type="radio" name="cumplimiento_modalidad_trabajo" value="B" <?php if ($result->cumplimiento_modalidad_trabajo=="B"){echo 'checked="true"';}?>></label></td>
                            <td><label><input type="radio" name="cumplimiento_modalidad_trabajo" value="MB"<?php if ($result->cumplimiento_modalidad_trabajo=="MB"){echo 'checked="true"';}?>></label></td>
                        </tr>
                        
                        <tr>
                            <th><b>Competencias</b></th>
                            <th><b>Regular</b></th>
                            <th><b>Buena</b></th>
                            <th><b>Muy Buena</b></th>
                        </tr>
                        <tr>
                            <td>Vocabulario</td>
                            <td><label><input type="radio" name="vocabulario" value="R" <?php if ($result->vocabulario=="R"){echo 'checked="true"';}?>></label></td>
                            <td><label><input type="radio" name="vocabulario" value="B" <?php if ($result->vocabulario=="B"){echo 'checked="true"';}?>></label></td>
                            <td><label><input type="radio" name="vocabulario" value="MB"<?php if ($result->vocabulario=="MB"){echo 'checked="true"';}?>></label></td>
                        </tr>
                        <tr>
                            <td>Trabajo en equipo</td>
                            <td><label><input type="radio" name="trabajo_equipo" value="R" <?php if ($result->trabajo_equipo=="R"){echo 'checked="true"';}?>></label></td>
                            <td><label><input type="radio" name="trabajo_equipo" value="B" <?php if ($result->trabajo_equipo=="B"){echo 'checked="true"';}?>></label></td>
                            <td><label><input type="radio" name="trabajo_equipo" value="MB"<?php if ($result->trabajo_equipo=="MB"){echo 'checked="true"';}?>></label></td>
                        </tr>
                        <tr>
                            <td>Capacidad de Organizacion</td>
                            <td><label><input type="radio" name="capacidad_organizacion" value="R" <?php if ($result->capacidad_organizacion=="R"){echo 'checked="true"';}?>></label></td>
                            <td><label><input type="radio" name="capacidad_organizacion" value="B" <?php if ($result->capacidad_organizacion=="B"){echo 'checked="true"';}?>></label></td>
                            <td><label><input type="radio" name="capacidad_organizacion" value="MB"<?php if ($result->capacidad_organizacion=="MB"){echo 'checked="true"';}?>></label></td>
                        </tr>
                        <tr>
                            <td>Vocacion de servicio</td>
                            <td><label><input type="radio" name="vocacion_servicio" value="R" <?php if ($result->vocacion_servicio=="R"){echo 'checked="true"';}?>></label></td>
                            <td><label><input type="radio" name="vocacion_servicio" value="B" <?php if ($result->vocacion_servicio=="B"){echo 'checked="true"';}?>></label></td>
                            <td><label><input type="radio" name="vocacion_servicio" value="MB"<?php if ($result->vocacion_servicio=="MB"){echo 'checked="true"';}?>></label></td>
                        </tr>
                        <tr>
                            <td>Capacidad de analisis y organizacion</td>
                            <td><label><input type="radio" name="capacidad_analisis" value="R" <?php if ($result->capacidad_analisis=="R"){echo 'checked="true"';}?>></label></td>
                            <td><label><input type="radio" name="capacidad_analisis" value="B" <?php if ($result->capacidad_analisis=="B"){echo 'checked="true"';}?>></label></td>
                            <td><label><input type="radio" name="capacidad_analisis" value="MB" <?php if ($result->capacidad_analisis=="MB"){echo 'checked="true"';}?>></label></td>
                        </tr>
                        <tr>
                            <td colspan="4">Observacion:<br><textarea rows="6" name="obs" style="width:90%;"><?php echo $result->obs;?></textarea></td>
                        </tr>
                        
                    </table>
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-primary"><i class="icon-plus icon-white"></i> Modificar</button>
                              
                                <a href="<?php echo base_url() ?>index.php/persona/visualizar?buscar=<?php echo $result->idPersona;?>" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
                                
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


