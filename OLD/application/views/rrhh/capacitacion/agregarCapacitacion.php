<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Datos de Capacitacion</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">'.$custom_error.'</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formUsuario" method="post"  >
                     <!--Tema , capacitador, institucion-->
                    <div class="span12" style="padding: 1%">
                        <div class="span4">
                            <label for="titulo" >Tema<span class="required">*</span></label>
                            <input id="tema" type="text" name="tema" value="<?php echo set_value('tema'); ?>" required="required"  />
                        </div>
                        <div class="span4">
                            <label for="capacitador" >Capacitador<span class="required">*</span></label>
                            <input id="capacitador" type="text" placeholder="Nombre y Apellido" name="capacitador" value="<?php echo set_value('capacitador'); ?>"  />
                        </div>
                        <div class="span4">
                            <label for="institucion" >Institucion<span class="required">*</span></label>
                            <input id="institucion" type="text" placeholder="Area o establecimiento" name="institucion" value="<?php echo set_value('institucion'); ?>"  />
                        </div>
                    </div>
                    
                     <!--inicio, fin, institucion-->
                    <div class="span12" style="padding: 1%; margin-left: 0px;">
                        <div class="span4">
                            <label for="f_inicio" class="control-label">Fecha Inicio<span class="required">*</span></label>
                            <input id="f_inicio" type="date" name="f_inicio" value="<?php echo set_value('f_inicio'); ?>" required="required" />
                        </div>
                        <div class="span4">
                            <label for="f_fin" class="control-label">Fecha Finalizacion<span class="required">*</span></label>
                            <input id="f_fin" type="date" name="f_fin" value="<?php echo set_value('f_fin'); ?>" required="required" />
                        </div>
                        <div class="span4">
                            <label for="cupo" >Cupo<span class="required">*</span></label>
                            <input id="cupo" type="number" placeholder="" name="cupo" value="<?php echo set_value('cupo'); ?>" required="required" />
                        </div>
                    </div>
                     
                     
                    <div class="span12" style="padding: 1%; margin-left: 0px;">
                        <div class="span4">
                            <label for="modalidad" class="control-label">Modalidad<span class="required">*</span></label>
                            <label class="label "><input style="margin-left: 10px;" type="radio"  name="modalidad" value="taller"> Taller</label>
                            <label class="label "><input style="margin-left: 10px;" type="radio"  name="modalidad" value="seminario"> Seminario</label>
                            <label class="label "><input style="margin-left: 10px;" type="radio"  name="modalidad" value="curso"> Curso</label>
                        </div>
                        <div class="span4">
                            <label for="evaluacion" class="control-label">Evaluacion<span class="required">*</span></label>
                            <label class="label "><input style="margin-left: 10px;" type="radio"  name="evaluacion" value="no"> No</label>
                            <label class="label "><input style="margin-left: 10px;" type="radio"  name="evaluacion" value="si"> Si</label>
                        </div>
                        <div class="span4">
                            <label for="tipo" class="control-label">Tipo<span class="required">*</span></label>
                            <label class="label "><input style="margin-left: 10px;" type="radio"  name="tipo" value="interno"> Interno</label>
                            <label class="label "><input style="margin-left: 10px;" type="radio"  name="tipo" value="externo"> Externo</label>
                        </div>
                        
                    </div>
                     
                    <div class="span12" style="padding: 1%; margin-left: 0px;">
                        <div class="span6">
                            <label for="descripcion" class="control-label">Descripcion<span class="required">*</span></label>
                            <textarea id="descripcion" class="span12" rows="5"  type="text" name="descripcion" value="<?php echo set_value('descripcion'); ?>"  ></textarea>
                        </div>
                    </div>
                    
                               

                    
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar</button>
                                <a href="<?php echo base_url() ?>index.php/capacitacion" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
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
          
        $("#marcarTodos1").change(function () {
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
              $("#personas tbody tr").each(function(){
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

           $('#formUsuario').validate({
            rules : {
                  titulo:{ required: true}
            },
            messages: {
                  titulo :{ required: 'Campo Requerido.'}
                  
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




