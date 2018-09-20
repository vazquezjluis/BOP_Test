<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Datos de la falla</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">'.$custom_error.'</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formFallas" method="post" class="form-horizontal" >
                    <div class="control-group">
                        <label  class="control-label">Tipo de falla <span class="required">*</span></label>
                        <div class="controls">
                            <select name="tipo" id="tipo">
                                <option value="LOGICA">LÓGICA</option>
                                <option value="FISICA">FÍSICA</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="descripcion" class="control-label">Descripcion <span class="required">*</span></label>
                        <div class="controls">
                            <input id="descripcion" type="text" name="descripcion" value="<?php echo set_value('descripcion'); ?>" required="required" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label  class="control-label">Gravedad<span class="required">*</span></label>
                        <div class="controls">
                            <label class="label label-important"><input style="margin-left: 10px;" type="radio" name="gravedad" value="1"> Mayor</label>
                            <label class="label label-warning"><input style="margin-left: 10px;" type="radio"  name="gravedad" value="2"> Media</label>
                            <label class="label label-success"><input style="margin-left: 10px;" type="radio"  name="gravedad" value="3"> Menor</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="articulo" class="control-label">Asociar a artuculos</label>
                        <div class="controls">
                            <div class="span6">
                                <div class="accordion" id="accordion">
                                <div class="accordion-group widget-box">
                                  <div class="accordion-heading">
                                      <div class="widget-title tipoModelo" data-tipo="articulo">
                                          <span class="icon"><i class="icon-list"></i></span>
                                          <h5 id="filtrar_text">Mostrar articulos</h5>
                                          
                                      </div>
                                  </div>
                                </div>
                                <div class="accordion-body">
                                    <div class="widget-content" style="border:1px solid #cccc;height: 150px;overflow-y:scroll; ">
                                        <table class="table" id="articulos">
                                            <thead>
                                                <tr>
                                                    <td><input  type="text" id="filtrar" placeholder="Filtrar"></td>
                                                    <td>
                                                        <label>
                                                            <input name="marcarTodos" type="checkbox" value="1" id="marcarTodos" />
                                                            <span class="lbl"> Marcar Todos</span>
                                                        </label>
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                if($articulos){
                                                  foreach ($articulos as $articulo){                                  
                                                      echo '<tr><td colspan="2"><label><input type="checkbox" name="articulo[]" style="vertical-align: middle;position: relative;bottom: 3px;" value="'.$articulo->codigo.'"> '.$articulo->codigo.'</label></td></tr>';
                                                  }
                                                }
                                
                                                ?>
                                            </tbody>
                                        </table>
                                </div>
                            </div>
                            </div>
                            </div>
                        </div>
                    </div> 
                    
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar</button>
                                <a href="<?php echo base_url() ?>index.php/fallas" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
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
           
           $('#formFallas').validate({
            rules : {
                  descripcion:{ required: true},
                  gravedad:{ required: true}
            },
            messages: {
                  descripcion :{ required: 'Campo Requerido.'},
                  gravedad :{ required: ''}
                  
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


