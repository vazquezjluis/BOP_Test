
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>


<div class="span12" style="margin-left: 0px;">
<form method="get" id="formBuscar" action="<?php echo current_url(); ?>">
    
        <div class="control-group">
            <label  class="control-label">Persona <span class="required">*</span></label>
            <div class="controls" id="persona_select">
                <div class="input-append span6">
                    <input  placeholder="Escribe aquí el apellido o nombre del empleado" class="input-block-level" id="persona" value="" type="text" required="required">
                    
                </div>
            </div>
            <input name="buscar" id="persona_id" type="hidden" value="0">
        </div>
        
    
</form>
</div>
<?php if ( isset($custom_error)) {
    if($custom_error!=''){
        echo '<div class="span12"><div class="alert alert-danger">' . $custom_error . '</div></div>';
    }
    
} ?>
<?php
if (isset($result)){
    
?>
    <div class="widget-box">
       <div class="widget-title">
          <ul class="nav nav-tabs">
             <li class="active"><a data-toggle="tab" href="#tab1">Datos del empleado</a></li>
             <li><a data-toggle="tab" href="#tab2">Licencias</a></li>
             <li><a data-toggle="tab" href="#tab3">Capacitaciones</a></li>
             <li><a data-toggle="tab" href="#tab4">Premios</a></li>
             <li><a data-toggle="tab" href="#tab5">Sanciones</a></li>

          </ul>
       </div>
       <div class="widget-content tab-content">
          <!--DATOS DEL EMPLEADO--> 
          <div id="tab1" class="tab-pane active" style="min-height: 300px">
              <div class="span12 nopadding">
                  <!--IMAGEN DEL EMPLEADO-->
                <div class="span4"> 
                    <?php  if (isset($url_img[0]->url)){$url = $url_img[0]->url;
                        }else{$url=  base_url()."assets/img/sin_imagen.jpg";} ?>
                    <img src="<?php echo $url?>" class="span12" style="max-height: 200px;"  id="imgSalida"><br>
                   <form action="<?php echo base_url(); ?>index.php/Archivos/agregar/" id="formArquivo" enctype="multipart/form-data" method="post"  >
                      <input type="hidden" name="nombre" value="Persona: <?php echo $result[0]->id;?>,legajo: <?php echo $result[0]->legajo;?> ">
                      <input type="hidden" name="descripcion" value="modifica la imagen del empleado">
                      <input type="hidden" name="funcionalidad" value="persona">
                      <input type="hidden" name="sector" value="2">
                      <input type="hidden" name="referencia" value="<?php echo $result[0]->id; ?>">
                      <label class="btn span12" id="lbl_file" style="margin: 0px;" ><span class="icon icon-camera"></span>  Cambiar imagen
                      <input id="file-input" accept="image/*" type="file" required="true" name="userfile" style="display: none;" capture/>
                      </label>
                      <button type="submit" id="guardar_imagen" style="display: none;margin: 0px;" class="span12 btn btn-success"> Guardar</button>
                   </form>
                </div>
                  
                <!--DATOS DEL EMPLEADO-->
                <div class="span8" style="font-size: 14px;">
                    <?php 
                      
                      echo '<div class="span4">
                                <b>Legajo: </b>'.$result[0]->legajo.'<br>
                                <b>Nombre: </b>'.$result[0]->nombre.'<br>
                                <b>Apellido: </b>'.$result[0]->apellido.'<br>
                                <b>DNI: </b>'.$result[0]->dni.'<br>
                                <b>Ingreso: </b>'.$result[0]->fecha_ingreso.'<br>
                                <b>Direccion: </b>'.$result[0]->direccion.'<br>
                            </div>
                            <div class="span4">
                            
                            </div>
                            <div class="span4">';
                      
                       echo'</div>';
                      ?>  
                </div>  
                     
              </div>

          </div>
          
          <!--LICENCIAS-->
          <div id="tab2" class="tab-pane" style="min-height: 300px">
              <?php
              if (isset($licencia) and count($licencia)!=0){
                  ;
                ?>
                <table  class='table table-bordered'>
                    <tr><td colspan='2'><b> Licencias del empleado</b></td></tr>
                    <tr>
                        <td><b>#</b></td>
                        <td><b>Titulo</b></td>
                        <td><b>Inicio</b></td>
                        <td><b>Finaliza</b></td>
                        <td><b>Dias</b></td>
                        <td><b>Descripcion</b></td>
                    </tr>
              <?php
                    foreach ($licencia as $c){
                    echo " <tr> 
                                <td>".$c->idLicenciaPersona."</td> 
                                <td>".$c->titulo."</td> 
                                <td>".$c->f_inicio."</td> 
                                <td>".$c->f_fin."</td> 
                                <td>".$c->dias."</td> 
                                <td>".$c->lpdesc."</td> 
                           </tr>";
                    } ?>
                </table>
                    <?php
              }else{
                   echo "<div class='alert alert-danger'>El empleado no tiene capacitaciones</div>";
              }
              ?>
          </div>
          
          <!--CAPACITACIONES-->
          <div id="tab3" class="tab-pane" style="min-height: 300px">
              <?php
              if (isset($capacitacion) and count($capacitacion)!=0){
                ?>
                <table  class='table table-bordered'>
                    <tr><td colspan='2'><b> Capacitaciones del empleado</b></td></tr>
                    <tr>
                        <td><b>#</b></td>
                        <td><b>Tema</b></td>
                        <td><b>Inicio</b></td>
                        <td><b>Finaliza</b></td>
                        <td><b>Capacitador</b></td>
                        <td><b>Institucion</b></td>
                    </tr>
              <?php
                    foreach ($capacitacion as $c){
                    echo " <tr> 
                                <td>".$c->idCapacitacionPersona."</td> 
                                <td>".$c->tema."</td> 
                                <td>".$c->f_inicio."</td> 
                                <td>".$c->f_fin."</td> 
                                <td>".$c->capacitador."</td> 
                                <td>".$c->institucion."</td> 
                           </tr>";
                    } ?>
                </table>
                    <?php
              }else{
                   echo "<div class='alert alert-danger'>El empleado no tiene capacitaciones</div>";
              }
              ?>
          </div>
          
          <!--PREMIOS-->
          <div id="tab4" class="tab-pane" style="min-height: 300px">
              
          </div>
          
          <!--SANCIONES-->
          <div id="tab5" class="tab-pane" style="min-height: 300px">

          </div>
       </div>
    </div>
<?php 
}
?>


<script type="text/javascript">
$(document).ready(function(){
          $("#cancel").hide();
          $("#persona").autocomplete({
            source: "<?php echo base_url(); ?>index.php/licencia/autoCompletePersona",
            minLength: 1,
            select: function( event, ui ) {
                    $("#persona_id").val(ui.item.id);
                    $("#formBuscar").submit();
                }
          });
          
      });
      
$(function() {
    
  //#CAPTURA DE IMAGEN DEL EMPLEADO  
  $('#file-input').change(function(e) {
      addImage(e); 
     });

    function addImage(e){
     var file = e.target.files[0],
     imageType = /image.*/;

     if (!file.type.match(imageType))
      return;

     var reader = new FileReader();
     reader.onload = fileOnload;
     reader.readAsDataURL(file);
    }
  
    function fileOnload(e) {
      var result=e.target.result;
      $('#imgSalida').attr("src",result);
      $('#guardar_imagen').show();
      $('#lbl_file').hide();
     }
     
 
});
</script>
