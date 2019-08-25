

<div class="container">
    <div class="row">
        <div class="span4" style="margin:0px;"><br>
            
            <form class="form-inline" action="<?php echo base_url();?>index.php/pedido/agregar" id="formPedido" method="post">

                <!--<div class="span12" style="padding: 0px; margin:0px;">-->
                    <!--<div class="span8">-->
                        <div class="btn-group">
                            <input name="legajo" id="legajo"  style="height: 34px; width:200px;font-size: 18px; " type="number"  class="solo-numero"  placeholder="Ingrese su LEGAJO">                        
                            
                            
                        </div>    
                        
                            <br>
                            <div class="btn-group" >
                                <input type="button" style="padding-left: 30px;padding-right: 30px;" class="btn  btn-default btn-large teclado"  value="1">
                                <input type="button" style="padding-left: 30px;padding-right: 30px;" class="btn  btn-default btn-large teclado"  value="2">
                                <input type="button" style="padding-left: 30px;padding-right: 30px;" class="btn  btn-default btn-large teclado"  value="3">
                            </div><br>
                            <div class="btn-group" >
                                <input type="button" style="padding-left: 30px;padding-right: 30px;" class="btn  btn-default btn-large teclado"  value="4">
                                <input type="button" style="padding-left: 30px;padding-right: 30px;" class="btn  btn-default btn-large teclado"  value="5">
                                <input type="button" style="padding-left: 30px;padding-right: 30px;" class="btn  btn-default btn-large teclado"  value="6">
                            </div><br>
                            <div class="btn-group" >
                                <input type="button" style="padding-left: 30px;padding-right: 30px;" class="btn  btn-default btn-large teclado"  value="7">
                                <input type="button" style="padding-left: 30px;padding-right: 30px;" class="btn  btn-default btn-large teclado"  value="8">
                                <input type="button" style="padding-left: 30px;padding-right: 30px;" class="btn  btn-default btn-large teclado"  value="9">
                            </div><br>
                            <div class="btn-group" >
                                <input type="button" style="padding-left: 24px;padding-right: 24px;" class="btn  btn-default btn-large resetAll"  value="<<" >
                                <input type="button" style="padding-left: 30px;padding-right: 30px;" class="btn  btn-default btn-large teclado"  value="0">
                                <input type="button" style="padding-left: 30px;padding-right: 30px;" class="btn  btn-default btn-large reset"  value="<">
                            </div>
                            <br>
                            <br>
                            <input type="button" name="borrar" style="font-size: 18px; width: 105px;"  id="borrar" class="btn  btn-danger btn-large"  value="Salir">
                            <input type="button" name="buscar" style="font-size: 18px; width: 105px;"  id="buscar" class="btn  btn-success btn-large"  value="Buscar">
                    <!--</div>-->
                    <!--<div class="span4">-->
                        
                    <!--</div>-->
                <!--</div>-->
                <!--<div class="span12" id="empleado">Ingrese su legajo.</div>-->
                <input type="hidden" id="persona" name="persona" value="">
                <input type="hidden" id="idPersona" name="idPersona" value="">
                <input type="hidden" id="persona_str" name="persona_str" value="">
            </form>
        </div>
<!--    </div>
    <br>
    Calendario
    <div class="row">-->
        <div class="span8" style="">
            <h4 id="empleado"></h4>
            <div id="calendarioWeb"></div>
        </div>    
    </div>
    
</div>



<!--Modal para crear, modificar y eliminar-->
<div id="modalEventos" class="modal hide fade" style="color: #00000;" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
  
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 style="color:#000000" id="tituloEvento"></h4>
  </div>
  <div class="modal-body">
     <div class="control-group form-inline">
        <div class="controls">
            <!--Color de etiqueta <input type="color" style="max-width: 50px;"name="txtColor" id="txtColor" value="#3688dc">-->
        </div>
    </div> 
      
    <div class="control-group">
        <div id="menus"></div>
    </div>
      <div class="control-group" id="rtaEliminacion" style="display: none;">
          <h4>Seleccione un motivo de cancelacion</h4>
        <label class="btn btn-danger">
            <input class="confirmarEliminacion" type="radio" style="margin-top: 0px;margin-right: 10px;" name='descripcion' data-descripcion="Cambio de turno">Cambio de turno
        </label>
        <label class="btn btn-danger">
            <input class="confirmarEliminacion" type="radio" style="margin-top: 0px;margin-right: 10px;" name='descripcion' data-descripcion="Falta del empleado">Falta del empleado
        </label>
    </div>
    
    <input type="hidden" name="fecha" id="fecha">
    <input type="hidden" name="txtID" id="txtID" value="">
  </div>
  <div class="modal-footer">
      <button class="btn btn-primary btn-large pull-left" style="display:none;" id="confirmarPedido" >Pedir este Menú</button>
      <div class="btn-group">
        <button class="btn btn-large" data-dismiss="modal"  aria-hidden="true">Cancelar</button>      
        <button class="btn btn-success btn-large" id="btnAgregar">Guardar</button>
        <button class="btn btn-danger btn-large" id="btnEliminar">Borrar</button>
      </div>
      
      
  </div>
  
</div>

<!--Modal Error-->
<div id="modalError" class="modal hide fade" style="color: #00000;" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
  
  <div class="modal-body">    
    <div class="control-group">
        <div class="alert alert-danger"><h4>No es posible programar un menu en fechas pasadas.</h4></div>
    </div>
  </div>
  <div class="modal-footer">
      <button class="btn btn-primary btn-large" data-dismiss="modal"  aria-hidden="true">Entendido</button>
  </div>
  
</div>

<div id="pedidoRealizado" class="modal hide fade" style="color: #00000;" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
  
  <div class="modal-body">    
    <div class="control-group">
        <div class="alert alert-info">
            <h4>Tu <span id="menuPendiente"></span> se encuentra <span id="estadoMenu"></span></h4>
            
        </div>
    </div>
  </div>
  <div class="modal-footer">
      <button class="btn btn-primary btn-large" data-dismiss="modal"  aria-hidden="true">Entendido</button>
  </div>
  
</div>



<script>
    
 $(document).ready(function (){
     var NuevoEvento;
     
     
      $('.solo-numero').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');
      });
      
      //$(".clockpicker").clockpicker();
      
      function EnviarInformacion(accion,objEvento){
          $.ajax({
              type:'POST',
              url:'<?php echo site_url() ?>/CalendarioMenu/'+accion,
              data:objEvento,
              success:function(msg){
                  if(msg){
                      $("#calendarioWeb").replaceWith('<div id="calendarioWeb"></div>');
                      leer(objEvento.legajo);
                      //$("#calendarioWeb").fullCalendar('refetchEvents');
                      $("#modalEventos").modal('toggle');
                  }
              },
              error:function(){
                  alert("Hay un error...");
              }
          });
      }
      
      function BuscaPedidoRealizado(objEvento){
            $.ajax({
              type:'POST',
              url:'<?php echo site_url() ?>/CalendarioMenu/buscaPedidoRealizado',
              data:objEvento,
              success:function(msg){
                  if(msg){//existe un pedido realizado
                      var html = JSON.parse(msg);
                      $("#estadoMenu").text(html.estadoStr);
                      $("#menuPendiente").text(html.descripcion);
                      
                      $("#modalEventos").modal('hide');
                      $("#pedidoRealizado").modal();
                  }else{
                      $("#estadoMenu").text('');
                      $("#menuPendiente").text('');
                      $("#confirmarPedido").show();
                  }
              },
              error:function(){
                  alert("Hay un error...");
              }
          });
      }
      
      function RecolectarDatosGUI(){
             NuevoEvento = {
                idCalendarioMenu    : $("#txtID").val(),
                legajo              : $("#persona").val(),
                personaStr          : $("#empleado").text(),
                idPersona           : $("#idPersona").val(),
                title               : $("input:radio[name=menu]:checked").attr('data-title'),
                descripcion         : $("input:radio[name=descripcion]:checked").attr('data-descripcion'),
                start               : $("#fecha").val(),
                color               : $("#txtColor").val(),
                //textColor
                //end
                idMenu              : $("input:radio[name=menu]:checked").val()
            } 
      }
      
      function leer(valor){
          if (valor.length>2){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>index.php/persona/calendarioMenuEmpleado?leg="+valor,
                dataType: 'json',
                success: function(data)
                {

                    if (data[0].nombre =="error"){
                        $("#empleado").text('El empleado no existe.');
                        $("#calendarioWeb").replaceWith('<div id="calendarioWeb"></div>');
                    }else{
                        $("#empleado").text(data[0].nombre+" "+data[0].apellido);
                        $("#persona").val(data[0].legajo);
                        $("#idPersona").val(data[0].idPersona);
                        $("#persona_str").val(data[0].nombre+" "+data[0].apellido)
                        
                        //Calendario
                        $("#calendarioWeb").fullCalendar({
                                height:550,
                                header:{
                                    left:'',
                                    center:'title',
                                    //right:'month,basicWeek,basicDay, agendaDay'
                                    right:'today,prev,next'
                                },
                                dayClick:function(date,jsEvent,view){
                                    dayAction(date,data);
                                },
                                events:data,
                                eventClick:function(calEvent,jsEvent,view){
                                    //console.log(calEvent.start._i);
                                    dayAction(calEvent.start,data)
                                }
                        });  

                    }
                }
            });

            $('#borrar').attr("disabled", false);
        }
      }
      
      function limpiar(){
            $("#txtID").val('');
            $("input[name=menu]").attr('checked',false);
            $("input[name=descripcion]").attr('checked',false);
            $("#txtColor").val('');
            $("#rtaEliminacion").hide();
      }
      
      function dayAction(date,data){
          console.log(date);
        var check = moment(date).format('YYYY-MM-DD');
        var today = moment(new Date()).format('YYYY-MM-DD');
                                    
        //Obtiene los menus
        $.ajax({
            url: "<?php echo base_url();?>index.php/menuPersonal/buscarMenu?legajo="+data[0].legajo+"&fecha="+date.format(),
            dataType: 'json',
            success: function(menus){
                if(menus){
                    var list = '';
                    $.each(menus, function(i, item){
    //                                                    console.log(menus[i].descripcion);
                        list+='<label class="alert alert-info btn" style="font-weight: bold;font-size: 14px"><input type="radio" style="height:20px;width: 20px;margin-top: 0px;margin-right: 10px;" name="menu" id="rad_'+menus[i].idMenuPersonal+'" value="'+menus[i].idMenuPersonal+'"  data-title="'+menus[i].descripcion+'">'+menus[i].descripcion+'</label>';
                    });
                    $("#menus").replaceWith('<div id="menus">'+list+'</div>');

                    //botones
                    $("#btnEliminar").show();
                    $("#btnAgregar").show();
                }else{
                    limpiar();
                    //botones
                    $("#btnEliminar").hide();
                    $("#btnAgregar").hide();

                    $("#menus").replaceWith('\
                            <div class="controls" id="menus">\n\
                                <label class="alert alert-danger" style="font-weight: bold;font-size: 14px">Por el momento no tenemos menus programados para este dia.</label>\n\
                            </div>');

                }


            }
        });

        //obtiene los eventos
        $.ajax({
            url: "<?php echo base_url();?>index.php/calendarioMenu/buscarEvento?legajo="+data[0].legajo+"&fecha="+date.format(),
            dataType: 'json',
            success: function(existe){
                if(existe){
                    $("#txtID").val(existe[0].idCalendarioMenu);
                    $("#rad_"+existe[0].idMenu).attr('checked',true);
                    $("#fecha").val(existe[0].start);
                    $("#txtColor").val(existe[0].color);
                    //botones
                    $("#btnEliminar").show();
                    $("#btnAgregar").text('Modificar');
                    $("#btnAgregar").prop('class','btn btn-warning btn-large');

                    if( check == today){
                        RecolectarDatosGUI();
                        BuscaPedidoRealizado(NuevoEvento);

                    }else{
                        $("#confirmarPedido").hide();
                    }

                }else{
                    limpiar();
                    //botones
                    $("#btnEliminar").hide();
                    $("#confirmarPedido").hide();
                    $("#btnAgregar").text('Agregar');
                    $("#btnAgregar").prop('class','btn btn-success btn-large');
                }
            }
        });
        $("#tituloEvento").html(" Menu del dia "+moment(date).format('DD-MM-YYYY'));
        $("#fecha").val(date.format());
        $("#rtaEliminacion").hide();


        if(check >= today){
            $("#modalEventos").modal(); 

        }else{
            $("#modalError").modal();
        }
      }
      
      $("#legajo").keyup(function(){          
          leer(this.value);          
      });
      
      $("#buscar").click(function(){          
          leer($("#legajo").val());          
      });
      $(".teclado").click(function(){  
          var valor = $("#legajo").val();
          valor = valor+$(this).val();
          $("#legajo").val(valor);
      });
      
      $(".reset").click(function(){  
          var valor = $("#legajo").val();
          valor = valor.substring(0,valor.length-1);
          $("#legajo").val(valor);
      });
      $(".resetAll").click(function(){  
          $("#legajo").val('');
      });
      
      $("#btnAgregar").click(function(){          
          RecolectarDatosGUI();
          EnviarInformacion('agregar',NuevoEvento);          
      });
      
      $("#btnEliminar").click(function(){          
          $("#rtaEliminacion").show();          
      });
      
      $(".confirmarEliminacion").click(function(){
          RecolectarDatosGUI();
          EnviarInformacion('eliminar',NuevoEvento);
      });
      
      $("#confirmarPedido").click(function(){
          RecolectarDatosGUI();
          EnviarInformacion('pedir',NuevoEvento);
      });
      
      $("#borrar").click(function(){
            $("#legajo").val('');
            $("#persona").val('');
            $("#idPersona").val('');
            $("#persona_str").val('');
            $("#empleado").text('');
            $("#calendarioWeb").replaceWith('<div id="calendarioWeb"></div>');
      });
      
 });/* Fin del document ready*/
    
 
</script>