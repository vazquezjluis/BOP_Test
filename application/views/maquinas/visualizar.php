<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<div class="span12" style="margin-left: 0px;">
<form method="get" id="formBuscar" action="<?php echo current_url(); ?>">
    
        <div class="control-group">
            <div class="controls">
                <label for="buscar" class="control-label">Ultimos 4 numeros del UID<span class="required">*</span></label>
                <input type="text" name="buscar" maxlength="4" required="true"  id="buscar"  placeholder="Escriba el codigo de UID"  value="<?php echo $this->input->get('buscar'); ?>" >
                <button class="btn" style="margin-bottom: 10px;margin-left: -4px;"><i class="icon-search"></i> Buscar</button>
            </div>	
        </div>                
    
</form>
</div>
<?php if ( isset($custom_error)) {
    if($custom_error!=''){
        echo '<div class="span12"><div class="alert alert-danger">' . $custom_error . '</div></div>';
    }
    
} ?>
<?php
if (isset($result)){
    
?>
    <div class="widget-box">
       <div class="widget-title">
          <ul class="nav nav-tabs">
             <li class="active"><a data-toggle="tab" href="#tab1">Datos de la maquina</a></li>
             <li><a data-toggle="tab" href="#tab2">Historial de fallas</a></li>
             <li><a data-toggle="tab" href="#tab3">Historial de partes</a></li>

          </ul>
       </div>
       <div class="widget-content tab-content">
          <div id="tab1" class="tab-pane active" style="min-height: 300px">
              <div class="span12 nopadding">
                  <!--IMAGEN DE LA MAQUINAS-->
                <div class="span4"> 
                    <?php  if (isset($url_img[0]->url)){$url = $url_img[0]->url;
                        }else{$url=  base_url()."assets/img/sin_imagen.jpg";} ?>
                    <img src="<?php echo $url?>" class="span12" style="max-height: 200px;"  id="imgSalida"><br>
                   <form action="<?php echo base_url(); ?>index.php/Archivos/agregar/" id="formArquivo" enctype="multipart/form-data" method="post"  >
                      <input type="hidden" name="nombre" value="Maquina: <?php echo $result[0]->idMaquina;?>,UID: <?php echo $result[0]->nro_egm;?> ">
                      <input type="hidden" name="descripcion" value="modifica la imagen de la maquina">
                      <input type="hidden" name="funcionalidad" value="maquina">
                      <input type="hidden" name="sector" value="1">
                      <input type="hidden" name="referencia" value="<?php echo $result[0]->idMaquina; ?>">
                      <label class="btn span12" id="lbl_file" style="margin: 0px;" ><span class="icon icon-camera"></span>  Cambiar imagen
                      <input id="file-input" accept="image/*" type="file" required="true" name="userfile" style="display: none;" capture/>
                      </label>
                      <button type="submit" id="guardar_imagen" style="display: none;margin: 0px;" class="span12 btn btn-success"> Guardar</button>
                   </form>
                </div>
                  
                <!--DATOS DE LA MAQUINA-->
                <div class="span8" style="font-size: 14px;">
                    <?php 
                      if($result[0]->estado == 1){
                          $estado = ' checked ';
                          $class = 'switch_2';
                          }
                      else{
                          $class= ' switch ';
                          $estado = ' ';
                      }
                      echo '<div class="span4">
                                <b>UID: </b>'.$result[0]->nro_egm.'<br>
                                <b>Fabricante: </b>'.$result[0]->fabricante.'<br>
                                <b>Modelo: </b>'.$result[0]->modelo.'<br>
                                <b>Denominacion: </b>'.$result[0]->denom.'<br>
                                <b>Juego: </b>'.$result[0]->juego.'<br>
                                <b>Serie: </b>'.$result[0]->nro_serie.'<br>
                                <b>% Pago: </b>'.$result[0]->p_pago.'<br>
                            </div>
                            <div class="span4">
                                <b>Programa: </b>'.$result[0]->programa.'<br>
                                <b>Apuesta mínima: </b>'.$result[0]->ap_minima.'<br>
                                <b>Apuesta máxima: </b>'.$result[0]->ap_maxima.'<br>
                                <b>Cantidad de lilneas: </b>'.$result[0]->cant_lineas.'<br>
                                <b>Tipo: </b>'.$result[0]->tipo_juego.'<br>
                                <b>Crédito: </b>'.$result[0]->credito.'<br>
                            </div>
                            <div class="span4">
                                 <label style="margin-top:3%;">
                                     <input type="checkbox" value="'.$result[0]->estado.'" '.$estado.'  id="estado_'.$result[0]->idMaquina.'" style="display:none;" />
                                     <div class="'.$class.' tip-top" data-maquina="'.$result[0]->idMaquina.'" id="estado_'.$result[0]->idMaquina.'" id=title="Cambiar estado"></div>
                                 </label>';
                       if($this->permission->checkPermission($this->session->userdata('permiso'),'eMaquina')){ 
                            echo '<a href="'.base_url().'index.php/maquinas/editar/'.$result[0]->idMaquina.'" style="margin-top:5%;" class="btn btn-info tip-top" title="Editar Maquina"><i class="icon-pencil icon-white"></i></a>';
                        }
                        if($this->permission->checkPermission($this->session->userdata('permiso'),'dMaquina')){
                            echo '<a href="#modal-excluir" class="btn btn-danger tip-top " maquina="'.$result[0]->idMaquina.'" style="margin-top:5%;" role="button" data-toggle="modal"   title="Eliminar Maquina">
                                            <i class="icon-remove icon-white"></i></a>';
                        }
                        if($this->permission->checkPermission($this->session->userdata('permiso'),'cTicket')){
                            echo '<a href="#modal-ticket" class="btn btn-default tip-top " style="margin-top:5%;" role="button" data-toggle="modal" maquina="'.$result[0]->idMaquina.'" ticketPrevio="'.$result[0]->tickets.'" estado_maquina="'.$result[0]->estado.'" >
                                            <i class="icon-tag"></i> Generar un Ticket</a>';
                        }  
                       echo'     </div>';
                      ?>  
                </div>  
                     
              </div>
              <div class="span12 nopadding" style="margin-left: 0px;"><hr></div>
              <div class="span12" style="margin-left: 0px;" >
                  <!--PARTES-->
                  <div class="span6">
                      <?php
                      if ($articulos_maquinas){
                          echo "<table  class='table table-bordered'>
                                    <tr><td ><b> Partes en la maquina</b></td></tr>
                                    ";
                          foreach ($articulos_maquinas as $am){
                              echo "<tr> 
                                     <td>".$am->articulo."</td> 
                                    </tr>";           
                          }
                          echo "</table>";
                      }else{
                          echo "<div class='alert alert-danger'>Maquina sin partes!</div>";
                      }
                      ?>
                  </div>
                  <!--FALLAS-->
                  <div class="span6">
                      <?php
                        if (!$fallas_maquina){
                            echo '<div class="alert alert-success">Maquina sin fallas  <i class="icon-thumbs-up"></i> </div>';
                        }else{
                            
                            echo '<table class="table table-bordered " >
                                    <tr><td  colspan="2" class="alert alert-danger" style="text-align:center;" ><strong>Fallas activas</strong></td></tr>';      
                            foreach ($fallas_maquina as $f){ 
                                
                                echo'
                                <tr>
                                   <td>#'.$f->falla.' '.$f->descripcion.'</td>
                                   <td><a href="'.base_url().'index.php/ticket/visualizar/'.$f->ticket.'"><span class="icon-share-alt"></span> #Ticket: '.$f->ticket.'</a></td>
                                </tr>';
                            }
                            echo '</table>';
                        }
                        ?>
                  </div>
              </div>

          </div>
          <!--Tab 2 FALLAS-->
          <div id="tab2" class="tab-pane" style="min-height: 300px">

                <table class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Falla</th>
                        <th>Usuario</th>
                        <th>Fecha registro</th>
                        <th>Ticket</th>
                    </tr>
                <?php
                if(!isset($historial_fallas) ){
                    echo '<tr><td> <div class="alert alert-info">No hay fallas en el historial.</div></td></tr>';
                }else{
                    foreach($historial_fallas as $hf){
                        echo '<tr>
                                <td>'.$hf->idFallas_maquinas.'</td>
                                <td>'.$hf->descripcion.'</td>
                                <td>'.$hf->usuario.'</td>
                                <td>'.$hf->fecha_registro.'</td>
                                <td>#'.$hf->ticket.'</td>
                              </tr>';
                    }

                }
                ?>    
                </table>
          </div>
          
          <!--Tab 3 PARTES-->
          <div id="tab3" class="tab-pane" style="min-height: 300px">

                <table class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Parte</th>
                        <th>Fecha salida</th>
                        <th>Usuario</th>
                    </tr>
                <?php
                if(!isset($historial_partes) ){
                    echo '<tr><td> <div class="alert alert-info">No hay partes en el historial.</div></td></tr>';
                }else{
                    foreach($historial_partes as $hp){
                        
                        echo '<tr>
                                <td>'.$hp->idArticuloMaquina.'</td>
                                <td>'.$hp->articulo.'</td>
                                <td>'.$hp->fecha_salida.'</td>
                                <td>#'.$hp->usuario_salida.'</td>
                              </tr>';
                    }

                }
                ?>    
                </table>
          </div>
       </div>
    </div>
<?php 
}
?>

<!-- NUEVO TICKET-->
<div id="modal-ticket" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <form id="formTicket" action="<?php echo base_url()?>index.php/ticket/agregar" enctype="multipart/form-data" method="post">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">Solicitud de Ticket</h3>
        </div>

        <div class="modal-body">
            
            <div id="ticket_previos"></div>
            <div class="new">
                  
                <input  id="sector"   type="hidden" name="sector" value="1">
                <input  id="tipo" type="hidden" name="tipo" value="1">
                <input  id="referencia" type="hidden" name="referencia" value="1">
                <input  id="buscar" type="hidden" name="buscar" value="<?php echo $this->input->get('buscar'); ?>">
                
                <!--Archivo-->
                <?php  $url=  base_url()."assets/img/sin_imagen.jpg"; 
                 $nombre ="ticket_de_Maquina_".$result[0]->idMaquina."_UID_".$result[0]->nro_egm;
                ?>
                <img src="<?php echo $url;?>" class="span12" style="max-height: 200px;margin-left: 0;"  id="img_t1"><br>
                <input type="hidden" name="nombre" value="<?= $nombre;?>">
                <input type="hidden" name="descripcion" value="Agrega una imagen en el ticket">
                <input type="hidden" name="funcionalidad" value="ticket">
                <input type="hidden" name="sector" value="1">
                <!--<input id="t_file_1" accept="image/*" type="file" required="true" name="userfile"  />-->
                <label class="btn span12" id="lbl_file" style="margin: 0px;" ><span class="icon icon-camera"></span>  Tomar foto
                        <input id="t_file_1" accept="image/*" type="file"  name="userfile" style="display: none;" capture/>
                </label>
                
                 <!--Datos propios del modulo-->
                <div class="span12" style="margin-left: 0"> 
                   
                  <div class="accordion" id="accordion">
                        <div class="accordion-group widget-box">
                          <div class="accordion-heading">
                              <div class="widget-title tipoFalla" data-tipo="FISICA">
                                <span class="icon"><i class="icon-list"></i></span><h5>Adherir Falla Fisica</h5>
                              </div>
                          </div>
                        </div>
                        <div class="accordion-body">
                            <div class="widget-content">
                            <table class="table table-bordered">
                              <?php 
                              foreach ($results_fallas as $rf){
                                  if ($rf->tipo == 'FISICA'){
                                      echo '<tr><td><label><input art="'.$rf->articulo.'" type="checkbox" class="falla" name="fallas[]" gravedad="'.$rf->gravedad.'" style="vertical-align: middle;position: relative;bottom: 3px;" value="'.$rf->idFallas.'" desc="'.$rf->descripcion.'">  '.$rf->descripcion.'</label></td></tr>';
                                  }
                              }
                              ?>
                            </table>
                            </div>
                        </div>
                        <div class="accordion-group widget-box">
                          <div class="accordion-heading">
                              <div class="widget-title tipoFalla" data-tipo="LOGICA">
                                <span class="icon"><i class="icon-list"></i></span><h5>Adherir Falla Logica</h5>
                              </div>
                          </div>
                        </div>
                        <div class="accordion-body">
                            <div class="widget-content">
                                <table class="table table-bordered">
                                    <?php 
                                    foreach ($results_fallas as $rf){
                                        if ($rf->tipo == 'LOGICA'){
                                            echo '<tr><td><label><input art="'.$rf->articulo.'" type="checkbox"  class="falla" name="fallas[]" gravedad="'.$rf->gravedad.'" style="vertical-align: middle;position: relative;bottom: 3px;" desc="'.$rf->descripcion.'" value="'.$rf->idFallas.'">  '.$rf->descripcion.'</label></td></tr>';
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                  </div>	
              </div>
                 
                <!--Prioridad-->
                <div class="span12" style="margin-left: 0">
                    <div class="control-group">
                        <table class="table">
                            <tr>
                                <td style="border-top:0px;;">
                                    <div id="fuera_de_servicio" class="span12" style="display: none;">
                                        <label><input type="checkbox" id="out_of_service" name="estado" style="vertical-align: middle;position: relative;bottom: 3px;" value="1"> Máquina fuera de servicio</label>
                                    </div> 
                                </td>
                            </tr>
                            <tr><td style="color:#be5856;"><label><input style="vertical-align: middle;position: relative;bottom: 3px;"   type="radio" value="1" name="prioridad" id="pri1">   Prioridad Alta</label></td></tr>
                            <tr><td style="color:#cbaa6f;"><label><input style="vertical-align: middle;position: relative;bottom: 3px;"  type="radio"   value="2" name="prioridad" id="pri2"> Prioridad  Media</label></td></tr>
                            <tr><td style="color:#549255;"><label><input  style="vertical-align: middle;position: relative;bottom: 3px;" type="radio" value="3" name="prioridad" id="pri3">   Prioridad Baja</label></td></tr>
                        </table>
                   </div>                        
                </div>                        
                <?php
                
                //relevamiento de partes
                if(count($articulos) or count($articulos_maquinas)){
                               echo "<div class='span12' id='releva_partes' style='background-color:#fcf8e3;margin-left: 0;padding:1% 0 0 1%;margin-bottom:0px;display:none;' >
                                        <label style='margin-bottom:0px;'> 
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
                                                echo '<tr id="tr_entra_'.$art->codigo.'" style="display:none"> 
                                                        <td style="padding-bottom:0px;">
                                                            <label>
                                                                <input type="checkbox" class="articulo" id="art_'.$art->codigo.'" name="entra['.$art->codigo.']" style="vertical-align: middle;position: relative;bottom: 3px;" value="1" articulo="'.$art->codigo.'"> 
                                                                 '.$art->codigo.' </label> 
                                                        </td>
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
                                                
                                                //por defecto el articulo que sale de la maquina, se dirige al laboratorio
                                                echo '<tr id="tr_sale_'.str_replace(substr($mov_art->articulo, -3), "", $mov_art->articulo).'" style="display:none"> 
                                                        <td style="padding-bottom:0px;">
                                                            <label>
                                                                <input type="checkbox" class="mov_articulo" id="mov_art_'.$mov_art->articulo.'" name="sale['.$mov_art->articulo.']" style="vertical-align: middle;position: relative;bottom: 3px;" value="1" articulo="'.$mov_art->articulo.'"> '
                                                                .$mov_art->articulo.' (la parte irá al labratorio)
                                                                
                                                            </label> 
                                                        </td>
                                                      </tr>';
                                                }
                                            echo "  
                                                </tbody>
                                            </table>
                                            <input type='hidden' name='locacion' value='laboratorio'/>
                                        ";
                                            
                                        }else{
                                            echo "No hay articulos la maquina no tiene partes asociadas.";
                                        }
                                echo "   </div>
                                    </div>";
                            }
               
                ?>
                <!--Descripcion-->
                <div class="span12" style="margin-left: 0"> 
                    <div class="control-group">
                        <label for="descripcion" class="control-label">Breve descripcion </label>
                        <div class="controls">
                            <textarea class="span12" id="descripcion" type="text" name="descripcion" ></textarea>
                        </div>	
                    </div>	
                </div>
            </div>  
        </div>

  <div class="modal-footer">
      <div class="new">
        <input type="button" id="ver_ticket_previos" class="btn" style="display: none; float: left;" value="Ver ticket relacionados" />
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <button class="btn btn-success">Agregar Ticket</button>
      </div>
  </div>
  </form>
</div>


<script type="text/javascript">

$( function() {
    $( "#accordion" ).accordion({
      collapsible: true,
      active: false,
      heightStyle: "content"
    });
  } );

$(document).on('click', 'a', function(event) {
        //obtiene el id de maquina desde la maquina
        console.log(this);
        var maquina = $(this).attr('maquina');
        $('#idMaquina').val(maquina);
        $('#referencia').val(maquina);
        
        
        //Si la maquina se encuentra fuera de servicio, entonces el div no se muestra
        if ($(this).attr('estado_maquina') == 1){
            $('#fuera_de_servicio').show();
        }
        
        
        
        //si existe el atributo en el a href y este tiene algun dato entonces significa que hay tickets previos sobre la maquina
        if ($(this).attr('ticketPrevio')!='' && $(this).attr('ticketPrevio')!=undefined){
//            console.log($(this).attr('ticketPrevio'));
//            console.log(maquina);
            $('#referencia').val(maquina);
            
            var html = '<div id="ticket_previos">\n\
                <div class="alert alert-warning">\n\
                <strong>Atencion!</strong> Existen tickets abiertos en esta máquina</div>\n\
                    <table class="table table-bordered">';
            var html_link  = '';
            //obtiene el string del atributo del link a
            var str = $(this).attr('ticketPrevio');
            //explota el string
            var res = str.split("-_-");
            //recorre el array
            for (x=0;x<res.length;x++){
                   //por cada elemento genero un link
                   var id_ticket = res[x].split(":");
                   html_link = html_link +"<tr><td> <a href='<?php echo base_url();?>index.php/ticket/visualizar/"+id_ticket[0]+"' >\n\
                        <span class='icon-share-alt'></span>Ticket nro. "+res[x]+" </a>\n\
                    </td></tr>";
            }
            html = html + html_link;
            html = html + '</table><div class="span12 align-right">\n\
            <input type="button" class="btn btn-warning" id="nuevo_ticket" value="Crear un nuevo Ticket" /></div></div>';
            $("#ticket_previos").replaceWith(html);
            $(".new").hide();
        }
        else{
            $("#ticket_previos").replaceWith("<div id='ticket_previos'></div>");
            $(".new").show();
            $("#ver_ticket_previos").hide();
            
        }
        //Muestra el html del ticket con un boton mas de volver a ver los tickets previos
        $("#nuevo_ticket").click(function(){
            $("#ticket_previos").hide();
            $("#ver_ticket_previos").show();
            $(".new").show();
        });
        
        //Muestra los ticket previos
        $("#ver_ticket_previos").click(function(){
            $(".new").hide();
            $("#ticket_previos").show();
            
        });
 
        
    });//final del ready!
    
$(document).on('change', 'input[type="checkbox"]', function(event) {
        if($(this).attr("class")=="falla"){
            if ($(this).prop('checked') ) {//check seleccionado
                
              if($(this).attr("gravedad")=="1"){// si se trata de una falla grave
                  //selecciona la maquina fuera de servicio
                  $("#out_of_service").prop('checked',true);
                  $("#pri1").prop('checked',true);
                  
              }
              
              if($(this).attr("art")!=""){//si la falla esta asociadoa a algun articulo
                 $("#releva_partes").show();
                 var articulos = $(this).attr("art").split('-_-');
                 console.log(articulos);
                 for(i=0;i<= articulos.length;i++){
                    $("#tr_entra_"+articulos[i]).show();
                    $("#tr_sale_"+articulos[i]).show();
                 }
              }
              
              
              var text  = $("#descripcion").val();
              text += " ["+$(this).attr('desc')+"]";
              $("#descripcion").val(text);
              
            }else{//checkbox deseleccionado
                var ban = 0;
                var releva = 0;
                // recorro todos los input 
                $(".falla").each(function(){
                    if ($(this).prop('checked')) {
                        if($(this).attr("gravedad")=="1"){// si se trata de una falla grave
                            ban = 1;
                        }
                        
                        if($(this).attr("art")!=""){
                            releva = 1;
                        }
                    }
                    
                });
                
                if (releva == 0){
                    $("#releva_partes").hide();
                }
                
                if (ban == 0){
                    $("#out_of_service").removeAttr('checked');
                    $("#pri1").removeAttr('checked');
                }
                
                var text  = $("#descripcion").val();
                text = text.replace("["+$(this).attr('desc')+"]"," ");
//                text += " -  "+$(this).attr('desc');
                $("#descripcion").val(text);
            }
        }
});//final del check fallas!

$(function() {
    
  //#CAPTURA DE IMAGEN DE LA MAQUINA  
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
     
  //#CAPTURA DE LA IMAGEN DE LOS TICKETS
  $('#t_file_1').change(function(e) {
      addImage1(e); 
     });
    
    function addImage1(e){
     var file = e.target.files[0],
     imageType = /image.*/;

     if (!file.type.match(imageType))
      return;

     var reader = new FileReader();
     reader.onload = fileOnload1;
     reader.readAsDataURL(file);
    }
   
    function fileOnload1(e) {
      var result=e.target.result;
      $('#img_t1').attr("src",result);
      
     }
   
   
   
  $('#formBuscar').validate({
            rules : {
                  buscar:{ 
                      required: true,
                      minlength:4
                  }
            },
            messages: {
                  buscar :{ 
                      required: 'Se requieren al menos 4 números.',
                      minlength: 'Se requieren al menos 4 números.'
                  }
                  
            },

            errorClass: "help-block",
            errorElement: "span",
            highlight:function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
    });
    
    
    
     $('.switch').click(function(){
        var id_maquina = $(this).attr("data-maquina") ;
        $(this).toggleClass("switchOn"); 
        if( $(this).siblings('input').is(':checked') ) {
             //destildar
             var habilitado = 0;
         }else{
             //tildar
             var habilitado = 1;
         }
         $.ajax({
            url: '<?php echo site_url() ?>/maquinas/habilitar/',
            data: "habilitado="+habilitado+"&maquina="+id_maquina,
            type: 'GET',
            async:false
        })
        .done(function(data) {
            if(data.result == true){
            }else{
            }   
        });    
            
    });  
    $('.switch_2').click(function(){ 
        var id_maquina = $(this).attr("data-maquina") ;
        $(this).toggleClass("switchOn_2"); 
        
           if( $(this).siblings('input').is(':checked') ) {
                //destildar
                var habilitado = 0;
            }else{
                //tildar
                var habilitado = 1;
            }
            $.ajax({
            url: '<?php echo site_url() ?>/maquinas/habilitar/',
            data: "habilitado="+habilitado+"&maquina="+id_maquina,
            type: 'GET',
            async:false
        })
        .done(function(data) {
            if(data.result == true){
            }else{
            }   
        }); 
    }); 
});
 
//muestra el relevamiento de partes   
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
        
        
        
        
        
        
        
   

</script>
