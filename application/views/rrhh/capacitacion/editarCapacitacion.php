<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Editar Capacitacion</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formCapacitacion" method="post" class="form-horizontal" >
                    <div class="control-group">
                        <?php echo form_hidden('idCapacitacion',$result->idCapacitacion) ?>
                        <label for="titulo" class="control-label">Titulo<span class="required">*</span></label>
                        <div class="controls">
                            <input id="titulo" type="text" name="titulo" value="<?php echo $result->titulo; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="descripcion" class="control-label">Descripcion<span class="required">*</span></label>
                        <div class="controls">
                            <input id="descripcion" type="text" name="descripcion" value="<?php echo $result->descripcion; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="f_inicio" class="control-label">Inicio</label>
                        <div class="controls">
                            <input id="f_inicio" type="date" name="f_inicio" value="<?php echo $result->f_inicio; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="finaliza" class="control-label">Finaliza</label>
                        <div class="controls">
                            <input id="f_fin" type="date" name="f_fin" value="<?php echo $result->f_fin; ?>"  />
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label  class="control-label">Estado*</label>
                        <div class="controls">
                            <select name="estado" id="estado">
                                <?php if($result->estado == 1){$ativo = 'selected'; $inativo = '';} else{$ativo = ''; $inativo = 'selected';} ?>
                                <option value="1" <?php echo $ativo; ?>>Activo</option>
                                <option value="0" <?php echo $inativo; ?>>Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <!--ASOCIAR PERSONAS O SECTORES-->
                    <?php 
                    $personas_sector_dump = explode('-_-', $result->persona_sector);
                    $personas = $personas_sector_dump[0];
                    $sectores = $personas_sector_dump[1];
                    $sectores = explode('|', $sectores);
                    $personas = explode('|', $personas);
                    
echo "<pre>";
var_dump($personas);
var_dump($sectores);
echo "</pre>";
die();
                    ?>
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
                                                
//                                                if($personas){
//                                                  foreach ($personas as $persona){                                  
//                                                      echo '<tr><td colspan="2">'
//                                                      . '<label>'
//                                                              . '<input type="checkbox" name="persona[]" style="vertical-align: middle;position: relative;bottom: 3px;" value="'.$persona->id.'-'.$persona->nombre.', '.$persona->apellido.' "> '.$persona->nombre.', '.$persona->apellido.'</label>'
//                                                              . '</td></tr>';
//                                                  }
//                                                }
//                                
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
//                                                if($sector){
//                                                  foreach ($sector as $sec){                                  
//                                                      echo '<tr><td colspan="2"><label><input type="checkbox" name="sector[]" style="vertical-align: middle;position: relative;bottom: 3px;" value="'.$sec->PUESTO_TRABAJO.'"> '.$sec->PUESTO_TRABAJO.'</label></td></tr>';
//                                                  }
//                                                }
                                
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
                                <a href="<?php echo base_url() ?>index.php/usuarios" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
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

           $('#formUsuario').validate({
            rules : {
                  nombre:{ required: true},
                  email:{ required: true,email:true}
            },
            messages: {
                  nombre :{ required: 'Campo Requerido.'},
                  email:{ required: 'Campo Requerido.',email:'Ingrese un correo electrónico válido.'}

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


