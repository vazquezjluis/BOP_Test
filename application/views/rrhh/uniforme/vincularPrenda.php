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
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Vincular PRENDA a <?php if (isset($_GET['persona'])){  echo "a ".strtoupper($_GET['persona_str']);} ?> </h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">'.$custom_error.'</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formVinculoUniforme" enctype="multipart/form-data" method="post" class="form-horizontal" >
                    <?php if (!isset($_GET['persona'])){?>
                    <div class="control-group">
                        <label  class="control-label">Persona <span class="required">*</span></label>
                        <div class="controls" id="persona_select">
                            <div class="input-append span6">
                                <input name="persona" placeholder="Escribe aquí el apellido o nombre del empleado" class="input-block-level" id="persona" value="" type="text" required="required">
                                <button id="cancel" type="button" class="btn btn-success" >Limpiar</button>
                            </div>
                        </div>
                        <input name="persona_id" id="persona_id" type="hidden" value="0">
                    </div>
                    <?php }
                    else{
                        echo '<input name="desde_persona"  type="hidden" value="1">';
                        echo '<input name="persona_id" id="persona_id" type="hidden" value="'.$_GET['persona'].'">';
                    }
                    ?>
                    <div class="control-group">
                        <label  class="control-label">Prenda <span class="required">*</span></label>
                        <div class="controls">
                            <select name="uniforme_id" id="uniforme_id" required="required" onchange="cambia_descripcion()">
                                <option value="">Seleccione</option>
                                <?php
                                 foreach ($uniforme as $pre){
                                     echo "<option value='".$pre->cod."'  ";
                                     if (set_value('uniforme')==$pre->cod){
                                         echo " selected ";
                                     }
                                     echo ">".$pre->DescripcionGral." - (".$pre->DescripcionATR1.' '.$pre->DescripcionATR2.' '.$pre->DescripcionATR3.")</option>";
                                 }
                                ?>
                            </select>
                            <!--<a href="<?php // echo base_url()?>index.php/uniforme/agregar" class="btn btn-default btn-mini"><i class="icon-plus icon-white"></i> Agregar nuevo premio</a>-->
                        </div>
                    </div>
                    
                    
                    <div class="control-group">
                        <label for="descripcion" class="control-label">Descripcion </label>
                        <div class="controls">
                            <textarea id="descripcion" type="text" name="descripcion"  readonly="readonly" ></textarea>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar</button>
                                <!--<a href="<?php echo base_url() ?>index.php/persona/visualizar<?php // echo $get;?>" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>-->
                                <a href="javascript:history.back()" class="btn">Volver</a>
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
    
     function cambia_descripcion(){
         var opcion_seleccionada = $("#uniforme_id option:selected").text();
         console.log(opcion_seleccionada);
         $("#descripcion").text(opcion_seleccionada);
     }
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
      
      function calcula_dia(){
        if ($("#fin").val()!='' && $("#inicio").val()!=''){
            if ($("#fin").val()>$("#inicio").val()){
                m1 = new Date($("#inicio").val());
                m2 = new Date($("#fin").val());
                r1 = m1.getTime();
                r2 = m2.getTime();
                r = r2-r1;
                //document.write("Faltan: " + ((((fechaResta / 1000) / 60) / 60) / 24)/365 + " a&ntilde;os. &oacute;<br/>");      
                var dias = (((r / 1000) / 60) / 60) / 24 ;
                console.log(dias);
//                document.write("Faltan: " + (((fechaResta / 1000) / 60) / 60)  + " Horas.  &oacute;<br/>");
//                document.write("Faltan: " + ((fechaResta / 1000) / 60)  + " Minutos.  &oacute;<br/>");
//                document.write("Faltan: " + (fechaResta / 1000)  + " Segundos.");
                $("#dias").val(dias);
            }
            
        }
      }
        
 

</script>


