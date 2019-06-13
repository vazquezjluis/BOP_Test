
<?php


$prioridad = array(
    0=>array("success","baja"),
    1=>array("important"," Urgente !"),
    2=>array("warning","media"),
    3=>array("",""),
    4=>array("",""),
    ''=>array("","")
); ?>
<div class="widget-box">
    <div class="widget-title">
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#tab1">
                    Ticket <?php echo $result[0]->idTicket; ?>
                    <?php echo '  <span class="badge badge-'.$prioridad[$result[0]->prioridad][0].'">'.$prioridad[$result[0]->prioridad][1].'</span>';?>
                </a>
            </li>
            <div class="buttons">
                    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'eCliente')){
                        echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'index.php/clientes/editar/'.$result->idClientes.'"><i class="icon-pencil icon-white"></i> Editar</a>'; 
                    } ?>
                    
            </div>
        </ul>
    </div>          
    <div class="widget-content tab-content">
        <div id="tab1" class="tab-pane active" style="min-height: 300px">
        <table class="table table-bordered " style="background-color: #FFF;">
            <tbody>
                <tr>
                    <td style="text-align: right"><strong>Descripcion</strong></td>
                    <td><?php echo $result[0]->descripcion; ?></td>
                    <td rowspan="5"><img src="<?php 
                    if(isset($img[0]->url)){echo $img[0]->url;}else{echo base_url()."assets/img/sin_imagen.jpg"; }?>" style="max-height: 200px;"></td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Solicitado</strong></td>
                    <td><?php echo date('d/m/Y H:m:s',  strtotime($result[0]->f_solicitud)) ?></td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Solicita</strong></td>
                    <td><?php echo $result[0]->solicita_str.' ['.$result[0]->permiso_solicita.']' ?></td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Asignado</strong></td>
                    <td><?php echo $result[0]->asignado_str.' - '.$result[0]->permiso_asignado.'' ?></td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Referencia</strong></td>
                    <td><?php echo $link_referencia;?></td>
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
                            echo "<strong>".$rn->usuario_str." [".$rn->permiso_str."] </strong> - ".date('d/m/Y H:m:s',  strtotime($result[0]->f_proceso));
                            echo "<hr>";
                        }
                    }else{
                        echo "<p style='color:red'>No hay novedades !</p>";
                        echo "<hr>";
                    }
                    ?>


                    <?php if ( $result[0]->estado !=1 ){ ?>
                    <form id="formReabrir" action="<?php echo base_url()?>index.php/novedades/agregar" method="post" novalidate="novalidate">
                        <input type="hidden" name="referencia" value="<?php echo $result[0]->idTicket ?>"> 
                        <input type="hidden" name="maquina" value="<?php echo $ref; ?>" >
                        <input type="hidden" name="tipo" value="T">
                        <input type="hidden" name="descripcion" value="Ticket reabierto">
                        <input type="hidden" name="estado" value="1">
                        <input type="hidden" name="asignado" value="<?php echo $result[0]->idAsignado ?>">
                        <button class="btn btn-success align-left">Reabrir el ticket</button>

                    </form>

                    <?php }else{ ?>

                    <form id="formNovedad" action="<?php echo base_url()?>index.php/novedades/agregar" method="post" >

                        <input type="hidden" name="referencia" value="<?php echo $result[0]->idTicket ?>">    
                        <input type="hidden" name="tipo" value="T">
                        <input type="hidden" name="maquina" value="<?php echo $ref; ?>" >

                        <div class="span12" style="margin-left: 0"> 
                            <div class="control-group">
                                <label for="descripcion" class="control-label">Novedad <span class="required">*</span>:</label>
                                <div class="controls">
                                    <textarea class="span12" id="descripcion" type="text" rows="8" name="descripcion"></textarea>
                                </div>
                            </div>
                        </div>
                        <?php
                        //Resolucion del ticket en relevamiento de partes
                        //Este apartado solo se muestra cuando el ticket tiene referencia a una maquina
                        if(strpos($link_referencia, "#Maquina:")!==false){
                            
                            if(count($articulos) or count($articulos_maquinas)){
                               echo "<div class='span12' style='background-color:#fcf8e3;margin-left: 0;padding:1% 0 0 1%;' >
                                        <input type='hidden' value='".$ref."' name='maquina'>
                                        <label> 
                                            <input type='checkbox' id='relevamiento_partes' style='vertical-align: middle;position: relative;bottom: 3px;'> Relevamiento de partes para esta máquina
                                        </label>
                                    </div>
                                    <div class='span12' style='background-color:#fcf8e3;margin-left: 0;margin-bottom:10px;;padding:1% 0 0 1%;' >
                                        <div class='span6' id='p1' style='display:none;'>
                                            <label><strong>Parte que entra:</strong></label>
                                            <table class='table table-bordered' style='width:90%;' id='modelos'>
                                                <tbody>";
                                            if(count($articulos)){ 
                                                foreach ($articulos as $art){                                  
                                                echo '<tr> 
                                                        <td style="padding-bottom:0px;">
                                                            <label>
                                                                <input type="checkbox" class="articulo" id="art_'.$art->idArticulo.'" name="entra['.$art->idArticulo.']" style="vertical-align: middle;position: relative;bottom: 3px;" value="0" articulo="'.$art->idArticulo.'"> '
                                                        . '         '.$art->nombre.' <i id="stk_'.$art->idArticulo.'" total="'.$art->stock.'">('.$art->stock.' en stock )</i></label> </td>
                                                        <td style="padding-bottom:0px;"><label style="padding-bottom:0px;"><input type="number" id="'.$art->idArticulo.'" disabled class="cantidad"  value="" min="1" style="width:50px;"> </td>
                                                      </tr>';
                                                }
                                            }
                                
                                        echo"               
                                                </tbody>
                                            </table>
                                        </div> ";
                                
                                echo"   <div class='span6' id='p2' style='display:none;'>
                                            <label><strong>Parte que sale:</strong></label>
                                            ";
                                        if(count($articulos_maquinas)){
                                        echo "<table class='table table-bordered' id=''>
                                                <tbody>";
                                            foreach ($articulos_maquinas as $mov_art){                                  
                                                echo '<tr> 
                                                        <td style="padding-bottom:0px;">
                                                            <label>
                                                                <input type="checkbox" class="mov_articulo" id="mov_art_'.$mov_art->articulo.'" name="sale['.$mov_art->articulo.']" style="vertical-align: middle;position: relative;bottom: 3px;" value="'.$mov_art->cantidad.'" articulo="'.$mov_art->articulo.'"> '
                                                                .$mov_art->articulo_str.' 
                                                            </label> 
                                                        </td>
                                                        <td style="padding-bottom:0px;"><label style="padding-bottom:0px;">
                                                            <input type="number" id="mov_'.$mov_art->articulo.'" disabled min="1" max="'.$mov_art->cantidad.'" class="mov_cantidad"  value="'.$mov_art->cantidad.'"  style="width:50px;"> 
                                                        </td>
                                                        <td style="padding-bottom:0px;">
                                                            <select name="locacion['.$mov_art->articulo.']" id="locacion_'.$mov_art->articulo.'" disabled>
                                                                <option value="">Enviar a</option>
                                                                <option value="laboratorio">Laboratorio</option>
                                                                <option value="stock">Stock</option>
                                                                <option value="scrap">Scrap</option>
                                                                <option value="baja">Baja</option>
                                                            </select> 
                                                        </td>
                                                      </tr>';
                                                }
                                            echo "  
                                                </tbody>
                                            </table>
                                        ";
                                            
                                        }else{
                                            echo "No hay articulos";
                                        }
                                echo "   </div>
                                    </div>";
                            }
                            
                        }
                        ?>
                        <div class="span12" >
                            <div class="span3" > 
                                <div class="control-group">
                                    <label for="estado">Nuevo Estado</label>
                                    <div class="controls">
                                        <select name="estado" id="estado" >
                                            <option value="">Selecione estado</option>
                                            <option value="1" <?php if ($result[0]->estado==1){ echo "selected";}?>>Abierto</option>
                                            <option value="2" <?php if ($result[0]->estado==2){ echo "selected";}?>>Resuelto</option>
                                            <!--<option value="3" <?php // if ($result[0]->estado==3){ echo "selected";}?>>Cerrado</option>-->
                                            <!--<option value="4" <?php // if ($result[0]->estado==4){ echo "selected";}?>>Cancelado</option>-->
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="span3" > 
                                <label for="asignado">Asignar a:</label>
                                <select name="asignado" id="asignado" >
                                    <option value=""></option>
                                    <?php
                                    foreach ($result_usuarios as $ru){
                                        echo '<option value="'.$ru->idUsuarios.'"';
                                        if ($ru->idUsuarios == $result[0]->idAsignado){
                                            echo " selected ";
                                        }
                                        echo  '>'.$ru->nombre.' ['.$ru->permiso.']</option>';
                                    }
                                    ?>
                                </select>
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
          
           $("#relevamiento_partes").change(function(e){
                if ($(this).is(':checked') ) {//checkbox seleccionado
                    $("#p1").show();
                    $("#p2").show();
                    $("#p_lista").show();
                }else{
                    $("#p1").hide();
                    $("#p2").hide();
                    $("#p_lista").hide();
                }
           });
          
          $(".articulo").change(function(e){
              var mi_art = $(this).attr('articulo');
              if ($(this).is(':checked')){
                  $("#"+mi_art).removeAttr('disabled');
                  $("#"+mi_art).attr('required','required');
              }else{
                  $(this).val(0);
                  $("#"+mi_art).val('');
                  $("#stk_"+mi_art).text("("+$("#stk_"+mi_art).attr('total')+") en stock");
                  $("#stk_"+mi_art).css("color","#666");
                  $("#"+mi_art).attr('disabled','disabled');
                  $("#"+mi_art).removeAttr('required');
              }
          });
          //asigna los valores al input
          $(".cantidad").on("keyup click",function(e){
              if ($(this).val()!=''){
                var stock =parseInt($("#stk_"+$(this).attr('id')).attr('total')) - parseInt($(this).val());
                
                if (stock < 0){
                    $("#stk_"+$(this).attr('id')).css("color","#b94a48");
                }else{
                    $("#stk_"+$(this).attr('id')).css("color","#666");
                }
              }else{
                var stock = $("#stk_"+$(this).attr('id')).attr('total');  
              }
              $("#stk_"+$(this).attr('id')).text("("+stock+") en stock");
              $("#art_"+$(this).attr('id')).val($(this).val());
          });
          
          $(".mov_articulo").change(function(e){
              var mi_art = $(this).attr('articulo');
              if ($(this).is(':checked')){
                  $("#mov_"+mi_art).removeAttr('disabled');
                  $("#locacion_"+mi_art).removeAttr('disabled');
                  $("#mov_"+mi_art).attr('required','required');
                  $("#locacion_"+mi_art).attr('required','required');
              }else{
                  $(this).val(0);
                  $("#mov_"+mi_art).attr('disabled','disabled');
                  $("#locacion_"+mi_art).attr('disabled','disabled');
                  $("#mov_"+mi_art).removeAttr('required');
                  $("#locacion_"+mi_art).removeAttr('required');
              }
          });
          
          //asigna los valores al input
          $(".mov_cantidad").on("keyup click",function(e){
              var art = $(this).attr('id').split('_');
              $("#mov_art_"+art[1]).val($(this).val());
          });
          
           $("#asignado").change(function(){
               //var texto_anterior = $("#descripcion").text();
               //$("#descripcion").text(texto_anterior+" Asignado a "+$('#asignado option:selected').text());
               $("#descripcion").text(" Asignado a "+$('#asignado option:selected').text());
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