<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Editar Falla <?php echo $result->idFallas; ?></h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formFallas" method="post" class="form-horizontal" >
                    
                    
                    <div class="control-group">
                        <?php echo form_hidden('idFallas',$result->idFallas) ?>
                        <label  class="control-label">Tipo de falla <span class="required">*</span></label>
                        <div class="controls">
                            <select name="tipo" id="tipo">
                                <?php if($result->tipo == 'LOGICA'){$activo = 'selected'; $inativo = '';} else{$activo = ''; $inativo = 'selected';} ?>
                                <option value="LOGICA" <?php echo $activo; ?>>LÓGICA</option>
                                <option value="FISICA" <?php echo $inativo; ?>>FÍSICA</option>
                            </select>
                        </div>
                    </div>
                    
                    
                    <div class="control-group">
                        <label  class="control-label">Gravedad<span class="required">*</span></label>
                        <div class="controls">
                            <label class="label label-important"><input style="margin-left: 10px;" type="radio" <?php if($result->gravedad == 1){?>checked="true"<?php }?> name="gravedad" value="1"> Mayor</label>
                            <label class="label label-warning"><input style="margin-left: 10px;" type="radio" <?php if($result->gravedad == 2){?>checked="true"<?php }?> name="gravedad" value="2"> Media</label>
                            <label class="label label-success"><input style="margin-left: 10px;" type="radio" <?php if($result->gravedad == 3){?>checked="true"<?php }?> name="gravedad" value="3"> Menor</label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="gravedad" class="control-label">Descripcion<span class="required">*</span></label>
                        <div class="controls">
                            <input id="descripcion" type="text" name="descripcion" value="<?php echo $result->descripcion; ?>"  />
                        </div>
                    </div>
                    
                    
                    <div class="control-group">
                        <label  class="control-label">Estado <span class="required">*</span></label>
                        <div class="controls">
                            <select name="estado" id="estado">
                                <?php if($result->estado == 1){$ativo = 'selected'; $inativo = '';} else{$ativo = ''; $inativo = 'selected';} ?>
                                <option value="1" <?php echo $ativo; ?>>Activo</option>
                                <option value="0" <?php echo $inativo; ?>>Inactivo</option>
                            </select>
                        </div>
                    </div>
                    
                    <?php
                        $partes_elegidas = array();
                        if ($result->articulo!=''){
                            $partes_elegidas = explode("-_-", $result->articulo);
                        }
                    ?>
                    <div class="control-group">
                        <label for="categoria" class="control-label">Asociar a una o varias partes</label>
                        <div class="controls">
                            <div class="span6">
                                <div class="accordion" id="accordion">
                                <div class="accordion-group widget-box">
                                  <div class="accordion-heading">
                                      <div class="widget-title tipoModelo" data-tipo="modelo">
                                          <span class="icon"><i class="icon-list"></i></span>
                                          <h5 id="filtrar_text"><?php 
                                          if(count($partes_elegidas)==0){ echo "No hay partes asociadas";}else{ echo "Hay ".count($partes_elegidas)." partes seleccionadas";}?>
                                          </h5>
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
                                                  foreach ($articulos as $art){
                                                      $checked = "";
                                                      if (count($partes_elegidas)){
                                                        if (in_array($art->codigo, $partes_elegidas)){
                                                            $checked="checked";
                                                        }
                                                      }
                                                      echo '<tr><td><label><input type="checkbox" '.$checked.' name="articulo[]" style="vertical-align: middle;position: relative;bottom: 3px;" value="'.$art->codigo.'"> '.$art->codigo.'</label></td></tr>';
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
                                <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Modificar</button>
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

           $('#formMaquina').validate({
            rules : {
                  nro_egm:{ required: true},
                  fabricante:{ required: true},
                  modelo:{ required: true},
                  p_pago:{ required: true},
                  denom:{ required: true},
                  juego:{ required: true},
                  nro_serie:{ required: true},
                  programa:{ required: true},
                  credito:{ required: true}
            },
            messages: {
                  nro_egm :{ required: 'Campo Requerido.'},
                  fabricante:{ required: 'Campo Requerido.'},
                  modelo:{ required: 'Campo Requerido.'},
                  p_pago:{ required: 'Campo Requerido.'},
                  denom:{ required: 'Campo Requerido.'},
                  juego:{ required: 'Campo Requerido.'},
                  nro_serie:{ required: 'Campo Requerido.'},
                  programa:{ required: 'Campo Requerido.'},
                  credito:{ required: 'Campo Requerido.'}
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


