<?php if (count($_POST)>0){

    echo "<script>history.back();</script>";
}?>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Datos del premio</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">'.$custom_error.'</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formPremio" method="post" class="form-horizontal" >
                    <div class="control-group">
                        <label  class="control-label">Premio <span class="required">*</span></label>
                        <div class="controls">
                            <input id="nombre" type="text" name="nombre" value="<?php echo set_value('nombre'); ?>" required="required" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="descripcion" class="control-label">Descripcion </label>
                        <div class="controls">
                            <textarea  id="descripcion" type="text" name="descripcion"><?php echo set_value('descripcion'); ?></textarea>
                        </div>
                    </div>

                    <div class="control-group">
                        <label  class="control-label">Tipo <span class="required">*</span></label>
                        <div class="controls">
                            <label class="label label-default"><input style="margin-left: 10px;" type="radio" name="tipo" value="Mensual">Mensual</label>
                            <label class="label label-default"><input style="margin-left: 10px;" type="radio" name="tipo" value="Anual">Anual</label>
                            <label class="label label-default"><input style="margin-left: 10px;" type="radio" name="tipo" value="Otro">Otro</label>
                        </div>

                    </div>

                    <div class="control-group">
                        <label  class="control-label">Meses cumplidos <span class="required">*</span></label>
                        <div class="controls">
                            <input id="mes_cumplido" type="number" style="width: 40px;"  name="mes_cumplido" value="<?php echo set_value('mes_cumplido'); ?>" />
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar</button>
                                <a href="<?=base_url()?>index.php/premio" class="btn btn-default"> Volver </a>

                                <!--<a href="<?php // echo base_url() ?>index.php/premio" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>-->
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

          $("#marcarTodos").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
            });

           $( function() {
            $( "#accordion" ).accordion({
              collapsible: true,
              active: false,
              heightStyle: "content",
              activate: function(){
                    $("#filtrar").keyup(function(){
                        if(!checkTeclaDel(event)){
                            filtrar($(this).val());
                        }
                    });
              }
            });
          });

           function filtrar(cadena){
              $("#articulos tbody tr").each(function(){
                  $(this).removeClass('ocultar');
                  contenido_fila =  $(this).find('td:eq(0)').text();
                  exp = new RegExp(cadena,'gi');
                  coincidencias = contenido_fila.match(exp);
                  if(coincidencias!=null){
                      $(this).addClass('resaltar');
                  }else{
                      $(this).addClass('ocultar');
                  }
              } );
          }

          function mostrarFilas(){
              $("#articulos tbody tr").each(function(){
                  $(this).removeClass('ocultar resaltar');
              });
          }

          function checkTeclaDel(e){

              codigoAscci = e.which;

              if(codigoAscci==8){
                  if($("#filtrar").val().length>0){
                      filtrar($("#filtrar").val());
                  }else{
                      mostrarFilas();
                  }
                  return true;
              }else{
                  return false;
              }
          }

           $('#formPremio').validate({
            rules : {
                  nombre:{ required: true},
                  tipo:{required:true}
//                  descripcion:{ required: true},

            },
            messages: {
//                  descripcion :{ required: 'Campo Requerido.'},
                  nombre :{ required: 'Campo Requerido'},
                  tipo:{required:''}

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
