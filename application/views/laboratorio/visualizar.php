
<div class="widget-box">
    <div class="widget-title">
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#tab1">
                    Reparacion #<?php echo $result[0]->idArticuloLaboratorio; ?>
                    
                </a>
            </li>
        </ul>
    </div>          
    <div class="widget-content tab-content">
        <div id="tab1" class="tab-pane active" style="min-height: 300px">
        <table class="table table-bordered " style="background-color: #FFF;">
            <tbody>
                <tr>
                    <td style="text-align: right"><strong>Articulo / Parte</strong></td>
                    <td><?php echo "COD#  - ".$result[0]->articulo ; ?> </td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Solicitado</strong></td>
                    <td><?php echo date('d/m/Y H:m:s',  strtotime($result[0]->fecha_hora)) ?></td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Solicita</strong></td>
                    <td><?php echo $result[0]->solicita_str.' ['.$result[0]->permiso_solicita.']' ?></td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Asignado</strong></td>
                    <td><?php echo $result[0]->asignado_str.' - '.$result[0]->permiso_asignado.'' ?></td>
                </tr>
                


            </tbody>
        </table>  
        <div class="accordion-group widget-box">
            <div class="accordion-heading">
                <div class="widget-title">
                    <a data-parent="#collapse-group" href="#collapseGTwo" data-toggle="collapse">
                        <span class="icon"><i class="icon-list"></i></span><h5>Novedades</h5>
                    </a>
                </div>
            </div>
            <div class="collapse in accordion-body" id="collapseGTwo">
                <div class="widget-content span12">
                    <?php
                    //Evoluciones
                    if (count($result_novedades)){
                        foreach ($result_novedades as $rn){
                            echo $rn->texto;
                            echo "<br>";
                            echo "<strong>".$rn->usuario_str." [".$rn->permiso_str."] </strong> - ".date('d/m/Y H:i:s',  strtotime($rn->f_proceso));
                            echo "<hr>";
                        }
                    }else{
                        echo "<p style='color:red'>No hay novedades !</p>";
                        echo "<hr>";
                    }
                    ?>


                    <?php if ( $result[0]->estado !=1 ){ ?>
                    <form id="formReabrir" action="<?php echo base_url()?>index.php/novedades/agregar" method="post" novalidate="novalidate">
                        <input type="hidden" name="referencia" value="<?php echo $result[0]->idArticuloLaboratorio ;?>"> 
                        
                        <input type="hidden" name="tipo" value="L">
                        <input type="hidden" name="descripcion" value="Reparacion reabierta">
                        <input type="hidden" name="estado" value="1">
                        <input type="hidden" name="articulo" value="<?php echo $result[0]->articulo; ?>">
                        <input type="hidden" name="asignado" value="<?php echo $result[0]->asignado ?>">
                        <button class="btn btn-success align-left">Reabrir la reparacion</button>

                    </form>

                    <?php }else{ ?>

                    <form id="formNovedad" action="<?php echo base_url()?>index.php/novedades/agregar" method="post" >

                        
                        <input type="hidden" name="tipo" value="L">
                        <input type="hidden" name="referencia" value="<?php echo $result[0]->idArticuloLaboratorio; ?>">
                        <input type="hidden" name="articulo" value="<?php echo $result[0]->articulo; ?>">

                        <div class="span12" style="margin-left: 0"> 
                            <div class="control-group">
                                <label for="descripcion" class="control-label">Novedad <span class="required">*</span>:</label>
                                <div class="controls">
                                    <textarea class="span12" id="descripcion" type="text" rows="8" name="descripcion"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="span12" >
                            <div class="span3" > 
                                <div class="control-group">
                                    <label for="estado">Nuevo Estado</label>
                                    <div class="controls">
                                        <select name="estado" id="estado" >
                                            <option value="">Selecione estado</option>
                                            <option value="1" <?php if ($result[0]->estado==1){ echo "selected";}?>>Averiado</option>
                                            <option value="0" <?php if ($result[0]->estado==2){ echo "selected";}?>>Reparado</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="span3" > 
                                <label for="asignado">Asignar a:</label>
                                <select name="asignado" id="asignado" >
                                    <option value="">Seleccione</option>
                                    <?php
                                    foreach ($result_usuarios as $ru){
                                        echo '<option value="'.$ru->idUsuarios.'"';
                                        if ($ru->idUsuarios == $result[0]->asignado){
                                            echo " selected ";
                                        }
                                        echo  '>'.$ru->nombre.' ['.$ru->permiso.']</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="span4" > 
                                <label for="locacion">Enviar el articulo a:</label>
                                <select name="locacion" id="locacion" >
                                    <option value="">Seleccione</option>
                                    <option value="stock">Pañol</option>
<!--                                    <option value="scrap">Scrap</option>
                                    <option value="baja">dar de baja</option>-->
                                    
                                </select>
                                <!--<input type="hidden" id="total" name="total"  value="<?php // echo $result[0]->cantidad; ?>" min="1" style="width:50px;">-->
                                <input type="hidden" name="cantidad" id="cantidad" disabled   value="1" >
                            </div>
                        </div>
                        <div class="span12"> 
                          <button class="btn btn-success align-left">Guardar</button>
                        </div>
                    </form>


                    <?php    
                    }
                    ?>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<script  src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
      $(document).ready(function(){
          
           $("#locacion").change(function(e){
               console.log($(this).val());
               if ($(this).val()!=""){
                    $("#cantidad").removeAttr('disabled')
                }else{
                    $("#cantidad").attr('disabled','disabled')
                }
           });
          
          
           $("#asignado").change(function(){
               var texto_anterior = $("#descripcion").text();
               $("#descripcion").text(texto_anterior+" Asignado a "+$('#asignado option:selected').text());
           });
           
           $("#estado").change(function(){
               var texto_anterior = $("#descripcion").text();
               $("#descripcion").text(texto_anterior+"Se modificó el estado a "+$('#estado option:selected').text());
           });
           
           $('#formNovedad').validate({
            rules : {
                  descripcion:{ required: true},
                  estado:{ required: true}
            },
            messages: {
                  descripcion :{ required: 'Debes agragar una novedad.'},
                  estado :{ required: 'Debes seleccionar un estado.'}
                  
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