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
                } 
                ?>
                <form action="<?php echo current_url(); ?>" id="formCapacitacion" method="post"  >
                     <!--Tema , capacitador, institucion-->
                    <div class="span12" style="padding: 1%">
                        <div class="span3 control-group">
                            <label for="tema" >Tema<span class="required">*</span></label>
                            <select id="tema" name="tema" required="required" >
                                <option value="">Seleccione</option>
                                <?php
                                if (isset($tema)){
                                    foreach ($tema as $t){
                                        echo "<option value='".$t->idTema."'>".$t->nombre."</option>";
                                    }
                                }
                                ?>                                
                            </select>
                            <a href="<?php echo base_url()?>index.php/tema/agregar" class="btn btn-default btn-mini"><i class="icon-plus icon-white"></i> Agregar nueva Tema</a>
                        </div>
                        
                        <div class="span2 control-group">
                            <label for="modalidad" class="control-label">Modalidad<span class="required">*</span></label>
                            <label ><input style="margin-left: 10px;margin-top: 0px;" type="radio"  name="modalidad" value="taller"> Taller</label>
                            <label ><input style="margin-left: 10px;margin-top: 0px;" type="radio"  name="modalidad" value="seminario"> Seminario</label>
                            <label ><input style="margin-left: 10px;margin-top: 0px;" type="radio"  name="modalidad" value="curso" > Curso</label>
                        </div>
                        <div class="span2 control-group">
                            <label for="evaluacion" class="control-label">Evaluacion<span class="required">*</span></label>
                            <label ><input style="margin-left: 10px;margin-top: 0px;" type="radio"  name="evaluacion" value="no"> No</label>
                            <label ><input style="margin-left: 10px;margin-top: 0px;" type="radio"  name="evaluacion"  value="si"> Si</label>
                        </div>
                        <div class="span2 control-group">
                            <label for="tipo" class="control-label">Tipo<span class="required">*</span></label>
                            <label ><input style="margin-left: 10px;margin-top: 0px;" type="radio"  name="tipo" value="interno"> Interno</label>
                            <label ><input style="margin-left: 10px;margin-top: 0px;" type="radio"  name="tipo" value="externo" > Externo</label>
                        </div>
                        <div class="span2 control-group">
                            <label for="obligatorio" class="control-label">Obligatorio<span class="required">*</span></label>
                            <label ><input style="margin-left: 10px;margin-top: 0px;" type="radio"  name="obligatorio" value="si"> Si</label>
                            <label ><input style="margin-left: 10px;margin-top: 0px;" type="radio"  name="obligatorio" value="no"> No</label>
                        </div>
                    </div>
                    
                    <div class="span12" style="padding: 1%; margin-left: 0px;">
                        <div class="span6 control-group">
                            <label for="descripcion" class="control-label">Descripcion<span class="required">*</span></label>
                            <textarea id="descripcion" class="span12" rows="5"  type="text" name="descripcion" value="<?php echo set_value('descripcion'); ?>"  ></textarea>
                        </div>
                        <div class="span3 control-group">
                            <label for="institucion" >Institucion<span class="required">*</span></label>                            
                            <select id="institucion" name="institucion" required="required" >
                                <option value="">Seleccione</option>
                                <?php
                                if (isset($institucion)){
                                    foreach ($institucion as $i){
                                        echo "<option value='".$i->idInstitucion."'>".$i->nombre."</option>";
                                    }
                                }
                                ?>                                
                            </select>
                            <a href="<?php echo base_url()?>index.php/institucion/agregar" class="btn btn-default btn-mini"><i class="icon-plus icon-white"></i> Agregar nueva institucion</a>
                        </div>
                        <div class="span3 control-group">
                            <label for="sector" >Sector<span class="required">*</span></label>                            
                            <select id="sector" name="sector" required="required" >
                                <option value="t">Todos</option>
                                <?php
                                if (isset($sector)){
                                    foreach ($sector as $s){
                                        echo "<option value='".$s->id."'>".$s->descripcion."</option>";
                                    }
                                }
                                ?>                                
                            </select>
                        </div>
                    </div> 
                    
                     <!--inicio, fin, cupo, capacitador-->
                    <div class="span12" style="padding: 1%; margin-left: 0px;">
                        <div class="span3 control-group ">
                            <label for="f_inicio" class="control-label">Fecha Inicio<span class="required">*</span></label>
                            <input id="f_inicio" type="date" name="f_inicio"  required="required" />
                        </div>
                        <div class="span3 control-group">
                            <label for="f_fin" class="control-label">Fecha Finalizacion<span class="required">*</span></label>
                            <input id="f_fin" type="date" name="f_fin"  required="required" />
                        </div>
                        <div class="span1 control-group">
                            <label for="cupo" >Cupo<span class="required">*</span></label>
                            <input id="cupo" type="number" style="width: 80%"  name="cupo"  required="required" />
                        </div>
                        <div class="span4 control-group">
                            <label for="capacitador" >Capacitador/es<span class="required">*</span></label>
                            <input id="capacitador" type="text" style="width: 80%" placeholder="Nombre y Apellido" name="capacitador"  />
                            
                        </div>
<!--                        <div class="span1">
                            <label>&nbsp;</label>
                            <button id="agregar_fecha" style="margin-bottom: 10px;" class="btn btn-primary"><b>+</b></button>
                        </div>-->
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

           $('#formCapacitacion').validate({
            rules : {
                  tema:{ required: true},
                  institucion:{required:true},
                  obligatorio:{required:true},
                  evaluacion:{required:true},
                  modalidad:{required:true},
                  tipo:{required:true},
                  descripcion:{required:true},
                  capacitador:{required:true},
                  f_inicio:{required:true},
                  f_fin:{required:true},
                  cupo:{requerido:true}
            },
            messages: {
                  tema :{ required: 'Campo Requerido.'},
                  institucion:{required:'Campo Requerido.'},
                  obligatorio:{required:''},
                  evaluacion:{required:''},
                  modalidad:{required:''},
                  tipo:{required:''},
                  descripcion:{required:'Campo Requerido.'},
                  capacitador:{required:'Campo Requerido.'},
                  f_inicio:{required:'Fecha Requerida.'},
                  f_fin:{required:'Fecha Requerida.'},
                  cupo:{required:'Campo Requerido.'}
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




