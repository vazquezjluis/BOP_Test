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
                        <label for="descripcion" class="control-label">Descripcion <span class="required">*</span></label>
                        <div class="controls">
                            <textarea  required="required" id="descripcion" type="text" name="descripcion"><?php echo set_value('descripcion'); ?></textarea>   
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="imagen" class="control-label">Imagen <span class="required">*</span></label>
                        <div class="controls">
                            <img  class="span2"  id="imgSalida">
                            <label class="btn span3" id="lbl_file" style="margin: 0px;" ><span class="icon icon-camera"></span>  Cargar imagen    
                            <input id="file-input" accept="image/*" type="file" required="true" name="userfile" style="display: none;" capture/>
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label  class="control-label">Fecha y hora <span class="required">*</span></label>
                        <div class="controls">
                            <input type="date" name="f_premio" id="f_premio">
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar</button>
                                <a href="<?php echo base_url() ?>index.php/rrhh/premio" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
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
                  descripcion:{ required: true},
                  
            },
            messages: {
                  descripcion :{ required: 'Campo Requerido.'},
                  nombre :{ required: 'Campo Requerido'}
                  
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


