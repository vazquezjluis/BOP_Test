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
                <form action="<?php echo current_url(); ?>" id="formUsuario" method="post" class="form-horizontal" >
                    <div class="control-group">
                        <label for="titulo" class="control-label">Titulo<span class="required">*</span></label>
                        <div class="controls">
                            <input id="titulo" type="text" name="titulo" value="<?php echo set_value('titulo'); ?>"  />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="descripcion" class="control-label">Descripcion<span class="required">*</span></label>
                        <div class="controls">
                            <input id="descripcion" type="text" name="descripcion" value="<?php echo set_value('descripcion'); ?>"  />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="f_inicio" class="control-label">Fecha Inicio<span class="required">*</span></label>
                        <div class="controls">
                            <input id="f_inicio" type="date" name="f_inicio" value="<?php echo set_value('f_inicio'); ?>"  />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="f_fin" class="control-label">Fecha Finalizacion<span class="required">*</span></label>
                        <div class="controls">
                            <input id="f_fin" type="date" name="f_fin" value="<?php echo set_value('f_fin'); ?>"  />
                        </div>
                    </div>

                    
                    <div class="control-group">
                        <label  class="control-label">Estado*</label>
                        <div class="controls">
                            <select name="estado" id="estado">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <!--ASOCIAR PERSONAS O SECTORES-->
                    <div class="control-group">
                        <label for="persona" class="control-label">Asociar a Personas o Sectores</label>
                        <div class="controls">
                            <div class="span6">
                                <div class="accordion" id="accordion">
                                <div class="accordion-group widget-box">
                                  <div class="accordion-heading">
                                      <div class="widget-title tipoModelo" data-tipo="persona">
                                          <span class="icon"><i class="icon-list"></i></span>
                                          <h5 id="filtrar_text">Mostrar personas</h5>
                                          
                                      </div>
                                  </div>
                                </div>
                                <div class="accordion-body">
                                    <div class="widget-content" style="border:1px solid #cccc;height: 150px;overflow-y:scroll; ">
                                        <table class="table" id="personas">
                                            <thead>
                                                <tr>
                                                    <td><input  type="text" id="filtrar" placeholder="Filtrar"></td>
                                                    <td>
                                                        <label>
                                                            <input name="marcarTodos1" type="checkbox" value="1" id="marcarTodos1" />
                                                            <span class="lbl"> Marcar Todos</span>
                                                        </label></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                if($personas){
                                                  foreach ($personas as $persona){                                  
                                                      echo '<tr><td colspan="2"><label><input type="checkbox" name="persona[]" style="vertical-align: middle;position: relative;bottom: 3px;" value="'.$persona->id.'-'.$persona->nombre.', '.$persona->apellido.' "> '.$persona->nombre.', '.$persona->apellido.'</label></td></tr>';
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
                    <div class="control-group">
                        <label for="persona" class="control-label">Asociar a Personas o Sectores</label>
                        <div class="controls">
                            <div class="span6">
                                <div class="accordion" id="accordion">
                                <div class="accordion-group widget-box">
                                  <div class="accordion-heading">
                                      <div class="widget-title tipoModelo" data-tipo="sector">
                                          <span class="icon"><i class="icon-list"></i></span>
                                          <h5 id="filtrar_text">Mostrar Sector</h5>
                                          
                                      </div>
                                  </div>
                                </div>
                                <div class="accordion-body">
                                    <div class="widget-content" style="border:1px solid #cccc;height: 150px;overflow-y:scroll; ">
                                        <table class="table" id="sectores">
                                            <thead>
                                                <tr>
                                                    <td><input  type="text" id="filtrar" placeholder="Filtrar"></td>
                                                    <td>
                                                        <label>
                                                            <input name="marcarTodos2" type="checkbox" value="1" id="marcarTodos2" />
                                                            <span class="lbl"> Marcar Todos</span>
                                                        </label></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                if($sector){
                                                  foreach ($sector as $sec){                                  
                                                      echo '<tr><td colspan="2"><label><input type="checkbox" name="sector[]" style="vertical-align: middle;position: relative;bottom: 3px;" value="'.$sec->PUESTO_TRABAJO.'"> '.$sec->PUESTO_TRABAJO.'</label></td></tr>';
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




