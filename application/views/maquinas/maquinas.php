<!--<link rel="stylesheet" href="<?php // echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />-->
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>


<?php if($this->permission->checkPermission($this->session->userdata('permiso'),'cMaquina')){ ?>
  <a href="<?php echo base_url()?>index.php/maquinas/agregar" class="btn btn-success">
      <i class="icon-plus icon-white"></i> Agregar nueva Máquina</a><br><br>
<?php } ?>
<form method="get" id="formBuscar" action="<?php echo current_url(); ?>">
    <div class=" span6">
        <div class="control-group">
            <div class="controls">
                <label for="buscar" class="control-label">UID<span class="required">*</span></label>
                <input type="text" name="buscar" required="true"  id="buscar"  placeholder="Escriba el codigo de UID"  value="<?php echo $this->input->get('buscar'); ?>" >
                <button class="btn" style="margin-bottom: 10px;margin-left: -4px;"><i class="icon-search"></i> Buscar</button>
            </div>	
        </div>
                
    </div>
</form><br>
            
            
      
<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-desktop"></i>
            </span>
            <h5>Máquinas</h5>

        </div> 
        <div class="widget-content nopadding">
            <div class="alert alert-info">Prueba buscar una maquina por su UID (nro_egm)</div>
        </div>
    </div>

<?php }else{
	

?>
<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-desktop"></i>
         </span>
        <h5>Datos de la Maquina</h5>

     </div>

<div class="widget-content nopadding">


<table class="table">
    <thead>
        <tr>
            <th>Máquina</th>
            <th>Estado</th>
            <th style="width: 25%;">Accion</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        foreach ($results as $r) {
            //Estado
            if($r->estado == 1){//activo
                $estado = ' checked ';
                $class = 'switch_2';
                $class_2= ' style="margin-top:10%;padding:5%;width:10px;height:10px; background-color:green;border-radius:10px;"';
                }
            else{//fuera de servicio
                $class= ' switch ';
                $class_2= ' style="margin-top:10%;padding:5%;width:10px;height:10px; background-color:red;border-radius:10px;"';
                $estado = ' ';
            }
            //Fallo
            $tickets='';
            if(isset($r->tickets) and $r->tickets!=''){
                $mis_tickets = explode("-_-", $r->tickets);
                $tickets='<div class="span4 warning">';
                foreach ($mis_tickets as $t){
                    $t = explode(":", $t);
                    $tickets.='<a href="'.base_url().'index.php/ticket/visualizar/'.$t[0].'">'
                            . '     <i class="icon-warning-sign" style="color: #f89406;"></i>'
                            . '</a>';
                }
                                
                $tickets.='</div> ';
            } 
            
            echo '<tr>';
            echo '';
            echo '<td>
                    <div class="span4">
                        <b>UID: </b><span style="font-size:16px;color:#49afcd;">'.$r->nro_egm.'</span><br>
                        <b>Fabricante: </b>'.$r->fabricante.'<br>
                        <b>Modelo: </b>'.$r->modelo.'<br>
                    </div>
                    <div class="span4">
                        <b>Juego: </b>'.$r->juego.'<br>
                        <b>Serie: </b>'.$r->nro_serie.'<br>
                    </div>  ';
            if($this->permission->checkPermission($this->session->userdata('permiso'),'vTicket')){
                    echo $tickets;
            }
            echo'</td>';
            echo '<td>'; 
                        if($this->permission->checkPermission($this->session->userdata('permiso'),'eMaquina')){ 
                          echo' <label class="span4" style="margin-top:5%;">
                                     <input type="checkbox" value="'.$r->estado.'" '.$estado.'  id="estado_'.$r->idMaquina.'" style="display:none;" />
                                        <div class="'.$class.' tip-top" data-maquina="'.$r->idMaquina.'" id="estado_'.$r->idMaquina.'" id=title="Cambiar estado"></div>
                                    </label> ';
                        }else{
                            echo '<div '.$class_2.'></div>';
                        }
                        echo'</td><td>';
                        echo '<a href="'.base_url().'index.php/maquinas/visualizar/'.$r->idMaquina.'" style="margin-top:5%;;margin-right: 1%;" class="btn tip-top" title="Ver detalle"><i class="icon-eye-open"></i></a>'; 
                        
                        if($this->permission->checkPermission($this->session->userdata('permiso'),'eMaquina')){ 
                            echo '<a href="'.base_url().'index.php/maquinas/editar/'.$r->idMaquina.'" style="margin-top:5%;" class="btn btn-info tip-top" title="Editar Maquina"><i class="icon-pencil icon-white"></i></a>';
                        }
                        if($this->permission->checkPermission($this->session->userdata('permiso'),'dMaquina')){
                            echo '<a href="#modal-excluir" class="btn btn-danger tip-top " maquina="'.$r->idMaquina.'" style="margin-top:5%;" role="button" data-toggle="modal"   title="Eliminar Maquina">
                                            <i class="icon-remove icon-white"></i></a>';
                        }             
                        if($this->permission->checkPermission($this->session->userdata('permiso'),'cTicket')){
                            echo '<a href="#modal-ticket" class="btn btn-default tip-top " style="margin-top:5%;" role="button" data-toggle="modal" maquina="'.$r->idMaquina.'" ticketPrevio="'.$r->tickets.'" estado_maquina="'.$r->estado.'" >
                                            <i class="icon-tag"></i></a>';
                        }             
                        echo'
                  </td>';
            
            
            echo '</tr>';
            
        }?>
        <tr>
            
        </tr>
    </tbody>
</table>
</div>
</div>
<?php  echo $this->pagination->create_links();
}?>



 
<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/maquinas/eliminar" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Eliminar maquina</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idMaquina" name="id" value="" />
    <h5 style="text-align: center">Realmente desea eliminar esta maquina?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Eliminar</button>
  </div>
  </form>
</div>

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
                
                <!--Descripcion-->
                <div class="span12" style="margin-left: 0"> 
                    <div class="control-group">
                        <label for="descripcion" class="control-label">Descripcion <span class="required">*</span> (máximo 250 caracteres)</label>
                        <div class="controls">
                            <textarea class="span12" id="descripcion" type="text" name="descripcion" required="true"></textarea>
                        </div>	
                    </div>	
                </div>
                
                
                
                <!--Archivo-->
                <!--<div class="span3" style="margin-left: 0">--> 
<!--                    <div>
                        <button type="button" class="close" style="display: none;" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <img class="imgSalida"  style="display: none;">
                        <label class="btn" style="padding-left:5%;padding-right:5%;"  >    
                            <span class="icon icon-camera"></span>
                            <input class="camara" accept="image/*" onchange="foto(this);"  type="file" required="true" name="foto_imagen[]"  style="display: none;" capture/>
                        </label>
                    </div>-->
                <!--</div>-->	
                <div id="new_imagen"></div>
                
                
                <!--Prioridad-->
                <div class="span12" style="margin-left: 0">
                    <div class="control-group">
                        <table class="table">
                            <tr><td style="border-top:0px; color:#be5856;"><label><input style="vertical-align: middle;position: relative;bottom: 3px;"   type="radio" value="1" name="prioridad">   Prioridad Alta</label></td></tr>
                            <tr><td style="color:#cbaa6f;"><label><input style="vertical-align: middle;position: relative;bottom: 3px;"  type="radio"   value="2" name="prioridad"> Prioridad  Media</label></td></tr>
                            <tr><td style="color:#549255;"><label><input  style="vertical-align: middle;position: relative;bottom: 3px;" type="radio" value="3" name="prioridad">   Prioridad Baja</label></td></tr>
                        </table>
                   </div>                        
                </div>                        
                
                <!--Datos propios del modulo-->
                <div class="span12" style="margin-left: 0"> 
                   
                  <div id="fuera_de_servicio" class="span12" style="margin-left: 5%;display: none;">
                      <label><input type="checkbox" name="estado" style="vertical-align: middle;position: relative;bottom: 3px;" value="1"> Máquina fuera de servicio</label>
                  </div>  
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
                                      echo '<tr><td><label><input type="checkbox" name="fallas[]" style="vertical-align: middle;position: relative;bottom: 3px;" value="'.$rf->idFallas.'">  '.$rf->descripcion.'</label></td></tr>';
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
                                            echo '<tr><td><label><input type="checkbox" name="fallas[]" style="vertical-align: middle;position: relative;bottom: 3px;" value="'.$rf->idFallas.'">  '.$rf->descripcion.'</label></td></tr>';
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
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


$(document).ready(function(){
   
   $( function() {
    $( "#accordion" ).accordion({
      collapsible: true,
      active: false,
      heightStyle: "content"
    });
  } );
   
   $(document).on('click', 'a', function(event) {
        //obtiene el id de maquina desde la maquina
        var maquina = $(this).attr('maquina');
        $('#idMaquina').val(maquina);
        $('#referencia').val(maquina);
        
        //Si la maquina se encuentra fuera de servicio, entonces el div no se muestra
        if ($(this).attr('estado_maquina') == 1){
            $('#fuera_de_servicio').show();
        }
        
        
        
        //si existe el atributo en el a href y este tiene algun dato entonces significa que hay tickets previos sobre la maquina
        if ($(this).attr('ticketPrevio')!='' && $(this).attr('ticketPrevio')!=undefined){
            console.log($(this).attr('ticketPrevio'));
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
//                       alert('Falla agregada');
            }else{
//                       alert('Ocurrio un error al cargar la falla.');
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
    //                       alert('Falla agregada');
                }else{
    //                       alert('Ocurrio un error al cargar la falla.');
                }   
            }); 
    }); 
    
    $('#formTicket').validate({
            rules : {
                  descripcion:{ descripcion: true}
            },
            messages: {
                  descripcion :{ required: 'Campo Requerido.'}
                  
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

});

function foto(element) {
      console.log(element);
      var imagen = $(element).parent().parent().find('img');
      
      $(element).attr("id","");
      $(element).parent().parent().find('img').show();
      $(element).parent().parent().addClass(" alert alert-warning");
      $(element).parent().parent().attr("role","alert");
      
      $(element).parent().parent().find('button').show();//mostramos el boton para cerrar la imagen
      $(element).parent().hide();//ocultamos el boton del archivo
      
      //mostramos la mini imagen en la etiqueta img
      var reader = new FileReader();
      
      reader.onload = function (e) {
        imagen.attr('src', e.target.result);
        imagen.show();
      };
      
      reader.readAsDataURL(element.files[0]);
     
      $('#new_imagen').replaceWith('<div>\n\
                    <button type="button" class="close" style="display: none;" data-dismiss="alert" aria-label="Close">\n\
                        <span aria-hidden="true">&times;</span>\n\
                    </button>\n\
                    <img class="imgSalida"  style="display: none;">\n\
                    <label class="btn" style="padding-left:5%;padding-right:5%;"  >\n\
                        <span class="icon icon-camera"></span>\n\
                        <input class="camara" accept="image/*" onchange="foto(this);"  type="file" required="true" name="foto_imagen[]"  style="display: none;" capture/>\n\
                    </label>\n\
        </div><div id="new_imagen"></div>');
};

</script>
