<?php //var_dump($persona);
//var_dump($calendario_menu);?>


<script src="<?php echo base_url()?>assets/js/moment.min.js"></script>
<!-- Full calendar -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fullcalendar.css">
<script src="<?php echo base_url()?>assets/js/fullcalendar.min.js"></script>
<script src="<?php echo base_url()?>assets/js/es.js"></script>

<style>
    .modal {
        border: solid 1px #00000;
    }
    .fc th{
        padding: 10px 0px;
        vertical-align: middle;
        background: #F2F2F2;
    }
    .fc-time { display: none;}
    .fc-content { padding: 5px;}
    .fc-unthemed td.fc-today {
        background: #f2f2f2;
    }

    .lblUnselected{
        border: 1px solid brown;
        padding: 5px;
        margin: 5px;
        border-radius: 5px;
        text-align: center;
    }

    .lblSelected{
        border: 1px solid brown;
        padding: 5px;
        background-color: brown;
        color: white;
        margin: 5px;
        border-radius: 5px;
        text-align: center;

    }
    .lblUnselectedBingo{
        border: 1px solid orangered;
        padding: 5px;
        margin: 5px;
        border-radius: 5px;
        text-align: center;
        width: 25%;
        float: left;
    }
    .lblSelectedBingo{
        border: 1px solid brown;
        padding: 5px;
        background-color: orangered;
        color: white;
        margin: 5px;
        border-radius: 5px;
        text-align: center;
        width: 25%;
        float: left;
    }






</style>



<div class="container">
    <!--<div class="alert alert-info" >Limite de programacion</div>-->
    <div class="row">
            <input type="hidden" id="legajo" name="legajo" value="<?php echo $usuario->legajo; ?>">
            <input type="hidden" id="idPersona" name="idPersona" value="<?php echo $persona[0]->id;?>">
            <input type="hidden" id="persona_str" name="persona_str" value="<?php echo $usuario->nombre; ?>">

<!--    </div>
    <br>
    Calendario
    <div class="row">-->
        <div class="span10" style="">
            <input type="hidden" id="empleado" value="<?php echo $usuario->nombre; ?> ">
            <div id="calendarioWeb"></div>
        </div>
    </div>

</div>

<?php
$dia        = array();
$cantidad   = 0;
$tiempo     ="";
if (isset($parametroMenu)){
    $type = array(
        "dia"    => "day",
        "mes"    => "month",
        "semana" => "week"
    );
    $dia        = explode(",",$parametroMenu[0]->dia);
    $diaCompleto = array();
    if (in_array("lu", $dia))array_push ($diaCompleto, "Lunes");
    if (in_array("ma", $dia))array_push ($diaCompleto, "Martes");
    if (in_array("mi", $dia))array_push ($diaCompleto, "Miercoles");
    if (in_array("ju", $dia))array_push ($diaCompleto, "Jueves");
    if (in_array("vi", $dia))array_push ($diaCompleto, "Viernes");
    if (in_array("sa", $dia))array_push ($diaCompleto, "Sabados");
    if (in_array("do", $dia))array_push ($diaCompleto, "Domingos");

    // Dias en los que el empleado puede cargar su plato
    $day = array();
    if (in_array("lu", $dia))array_push ($day, "Mon");
    if (in_array("ma", $dia))array_push ($day, "Tue");
    if (in_array("mi", $dia))array_push ($day, "Wed");
    if (in_array("ju", $dia))array_push ($day, "Thu");
    if (in_array("vi", $dia))array_push ($day, "Fri");
    if (in_array("sa", $dia))array_push ($day, "Sat");
    if (in_array("do", $dia))array_push ($day, "Sun");

    $cantidad   = $parametroMenu[0]->cantidad;

    //Definir el limite
    $fecha = date('Y-m-j');
    $nuevafecha = strtotime ( '+'.$cantidad.' '.$type[$parametroMenu[0]->tiempo].'', strtotime ( $fecha ) ) ;
    $limite = date ( 'Y-m-j' , $nuevafecha );
    $fecha_= date_create($limite);
}
?>

<!--Modal para crear, modificar y eliminar-->
<div id="modalEventos" data-backdrop="static" data-keyboard="false" class="modal hide fade" style="color: #00000;" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">

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
      <button type="button" class="btn btn-primary btn-large pull-left" style="display:none;" id="confirmarPedido" >Pedir ahora!</button>
      <div class="btn-group">
        <button type="button" class="btn btn-large" data-dismiss="modal"  aria-hidden="true">Cancelar</button>
        <button type="button" class="btn btn-large" id="btnAgregar">Guardar</button>
        <button type="button" class="btn btn-large" id="btnModificar">Modificar</button>
        <button type="button" class="btn btn-danger btn-large" id="btnEliminar">Borrar</button>
      </div>


  </div>

</div>

<!--Modal Error-->
<div id="modalError" data-backdrop="static" data-keyboard="false" class="modal hide fade" style="color: #00000;" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-body">
    <div class="control-group">
        <div class="alert alert-danger"><h5>No es posible programar un menu en fechas pasadas.</h5></div>
    </div>
    <button class="btn btn-danger" style="float:right;" data-dismiss="modal"  aria-hidden="true">Entendido</button>

  </div>


</div>

<!--Modal modalFechaLimite-->
<div id="modalFechaLimite" data-backdrop="static" data-keyboard="false" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-body">
    <div class="control-group">
        <div class="alert alert-info"><h5 id="msj"></h5></div>
    </div>
      <button class="btn btn-success float-right" style="float:right;" data-dismiss="modal"  aria-hidden="true">Entendido</button>
  </div>


</div>

<!--pendiente-->
<div id="pedidoRealizado" class="modal hide fade" style="color: #00000;" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-body">
    <div class="control-group">
        <div class="alert alert-info">
            <h5>Tu <span id="menuPendiente"></span> se encuentra <span id="estadoMenu"></span></h5>

        </div>
    </div>
      <button class="btn btn-success" style="float:right" data-dismiss="modal"  aria-hidden="true">Entendido</button>

  </div>
</div>



<script>

 $(document).ready(function (){
     var parametroDia        =  [<?php echo '"'.implode('","', $day).'"'; ?>];
     var fechaActual = new Date();

     var NuevoEvento;

      $('.solo-numero').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');
      });




      function EnviarInformacion(accion,objEvento){
          $.ajax({
              type:'POST',
              url:'<?php echo site_url() ?>/CalendarioMenu/'+accion,
              data:objEvento,
              success:function(msg){
                  if(msg){
                      $("#calendarioWeb").fullCalendar('refetchEvents');
                      $("#modalEventos").modal('toggle');
                  }
              },
              error:function(){
                  alert("Hay un error...");
              }
          });
      }
      var isMobile = {
            mobilecheck : function() {
            return (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino|android|ipad|playbook|silk/i.test(navigator.userAgent||navigator.vendor||window.opera)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test((navigator.userAgent||navigator.vendor||window.opera).substr(0,4)))
            }
    }
    var resolucion = 500;
    if(isMobile.mobilecheck()){resolucion = 400 }
      function RecolectarDatosGUI(){
             NuevoEvento = {
                idCalendarioMenu    : $("#txtID").val(),
                legajo              : '<?php echo $usuario->legajo; ?>',
                persona_str         : '<?php echo $usuario->nombre; ?>',
                idPersona           : '<?php echo $persona[0]->id;?>',
                title               : $("input:radio[name=menu]:checked").attr('data-title'),
                descripcion         : $("input:radio[name=descripcion]:checked").attr('data-descripcion'),
                start               : $("#fecha").val(),
                color               : $("#txtColor").val(),
                //textColor
                //end
                idMenu              : $("input:radio[name=menu]:checked").val(),
                idMenuBingo         : $("input:radio[name=menuBingo]:checked").val(),
            }
      }

      $("#calendarioWeb").fullCalendar({
                height:resolucion,
                header:{
                    left:'',
                    center:'title',
                    //right:'month,basicWeek,basicDay, agendaDay'
                    right:'today,prev,next'
                },
                dayClick:function(date,jsEvent,view){

                    dayAction(date,<?php echo $calendario_menu;?>);
                },
                events:'<?php echo site_url() ?>/pedido/calendario_menu',
                eventClick:function(calEvent,jsEvent,view){

                    dayAction(calEvent.start,<?php echo $calendario_menu;?>)
                }
        });

      function limpiar(){
            $("#txtID").val('');
            $("input[name=menu]").attr('checked',false);
            $("input[name=descripcion]").attr('checked',false);
            $("#txtColor").val('');
            $("#rtaEliminacion").hide();
      }
      function inArray(needle, haystack) {
        var length = haystack.length;
        for(var i = 0; i < length; i++) {
            if(haystack[i] == needle) return true;
        }
        return false;
    }
      function dayAction(date,data){

        var check = moment(date).format('YYYY-MM-DD');//fecha del dia del calendario
        var today = moment(new Date()).format('YYYY-MM-DD');//fecha de hoy
        var limite =new Date("<?php echo (string)$limite; ?>");
        //Obtengo el srting del dia presionado
        var day_event = fechaActual.toString().slice(0,3); // Sun, Sat, Mon...etc



        // Cuando la fecha limite es mayor a la fecha del dis no se permite realizar acciones
        if (check > moment(limite).format('YYYY-MM-DD') ){
           $("#msj").text("Por el momento solo se pueden cargar platos hasta el dia <?php  echo date_format($fecha_, 'd/m/y');?>");
           $("#modalFechaLimite").modal();

        }else{
            //Si el evento corresponde al dia actual entonces busca un pedido pendiente
            if( check == today){
                $.ajax({
                  type:'POST',
                  url:"<?php echo site_url() ?>/CalendarioMenu/buscaPedidoRealizado?legajo="+data[0].legajo+"&fecha="+date.format(),
                  success:function(msg){
                      if(msg){//existe un pedido realizado
                          var html = JSON.parse(msg);
                          $("#estadoMenu").text(html.estadoStr);
                          $("#menuPendiente").text(html.descripcion);
                          $("#pedidoRealizado").modal();


                      }else{
                          $("#estadoMenu").text('');
                          $("#menuPendiente").text('');
                          $("#confirmarPedido").show();


                        //Obtiene los menus
                        get_menus(date,data);
                        //obtiene los eventos
                        get_eventos(date,data);
                        if (!inArray(day_event,parametroDia)){
                            $("#btnAgregar").replaceWith('');
                            $("#btnModificar").replaceWith('');
                            $("#btnBorrar").replaceWith('');
                        }
                        $("#modalEventos").modal();
                      }
                  },
                  error:function(){
                      alert("Hay un error...");
                  }
                });
            }
            else{
                // Si el dia es mayor o igual a hoy, solo busca los menus y eventos
                if(check >= today){
                    if (!inArray(day_event,parametroDia)){
                        $("#msj").text(" Por el momento solo se puede programar los dias  <?php echo implode(',',$diaCompleto);?> hasta el dia <?php  echo date_format($fecha_, 'd/m/y');?>");
                        $("#modalFechaLimite").modal();

                    } else {
                        //Obtiene los menus
                        get_menus(date,data);
                        //obtiene los eventos
                        get_eventos(date,data);
                        $("#modalEventos").modal();

                    }

                }else{
                    $("#modalError").modal();
                    //alert(" No es posible programar pedidos en fechas pasadas.")
                }
            }
            $("#tituloEvento").html(" Menu del "+moment(date).format('DD-MM-YYYY'));
            $("#fecha").val(date.format());
            $("#rtaEliminacion").hide();

        }
      }

      function selectMenu(element){
            $(".lbl-menu").each(function(){
                $(this).removeClass("lblSelected")
                $(this).addClass("lblUnselected")
             });
            $(element).removeClass("lblUnselected");
            $(element).addClass("lblSelected");
      }

      function selectMenuBingo(element){
            $(".lbl-menuBingo").each(function(){
                $(this).removeClass("lblSelectedBingo")
                $(this).addClass("lblUnselectedBingo")
             });
            $(element).removeClass("lblUnselectedBingo");
            $(element).addClass("lblSelectedBingo");
        }

      //Obtiene los menus del dia
      function get_menus(date,data){
          $.ajax({
            url: "<?php echo base_url();?>index.php/menuPersonal/buscarMenu?legajo="+data[0].legajo+"&fecha="+date.format(),
            dataType: 'json',
            success: function(menus){
                if(menus){

                    var list = '';
                    var list_interno = '';
                    $.each(menus, function(i, item){
                        if (menus[i].tipo_menu =="externo"){
                            list+='<label class="lbl-menu"  id="lbl_'+menus[i].idMenuPersonal+'" ><input  type="radio" style="width:1px; height:1px;" name="menu" id="rad_'+menus[i].idMenuPersonal+'" value="'+menus[i].idMenuPersonal+'"  data-title="'+menus[i].descripcion+'">'+menus[i].descripcion+'</label>';
                        }else{
                            list_interno+='<label class="lbl-menuBingo" id="lbl_'+menus[i].idMenuPersonal+'"  ><input  type="radio" style="width:1px; height:1px;" name="menuBingo" id="rad_'+menus[i].idMenuPersonal+'" value="'+menus[i].idMenuPersonal+'"  data-title="'+menus[i].descripcion+'">'+menus[i].descripcion+' $ '+menus[i].valor+'</label>';
                        }


                    });
                    $("#menus").replaceWith('<div id="menus"><b>Plato del dia valor $ <?php echo $importe_externo[0]->importe_externo; ?></b><br>'+list+'<hr><b>Bingo Oasis</b><br>'+list_interno+'</div>');
                    $(".lbl-menu").addClass("lblUnselected");
                    $(".lbl-menuBingo").addClass("lblUnselectedBingo");


                    //botones
                    $("#btnEliminar").show();
                    $("#btnAgregar").show();
                }
                else{
                    limpiar();
                    //botones
                    $("#btnEliminar").hide();
                    $("#btnAgregar").hide();
                    $("#btnModificar").hide();

                    $("#menus").replaceWith('\
                            <div class="controls" id="menus">\n\
                                <label class="alert alert-danger" style="font-weight: bold;font-size: 14px">Por el momento no tenemos menus programados para este dia.</label>\n\
                            </div>');

                }

                $(".lbl-menu").click(function(){
                    selectMenu(this);
                });
                $(".lbl-menuBingo").click(function(){
                    selectMenuBingo(this);
                });
            }
        });


      }

      var clics = 0;
      function inhibe_boton(boton){
        clics++;
        document.getElementById(boton).value = 'Aguarde...';
        if (clics > 1 ){
            alert (" Un click es suficiente.\n\nEl el dato está siendo enviado.\n\n Gracias por esperar.");
        }
      }

      //Obtiene los eventos del dia
      function get_eventos(date,data){
        var check = moment(date).format('YYYY-MM-DD');
        var today = moment(new Date()).format('YYYY-MM-DD');

          $.ajax({

            url: "<?php echo base_url();?>index.php/calendarioMenu/buscarEvento?legajo="+data[0].legajo+"&fecha="+date.format(),
            dataType: 'json',
            success: function(existe){
                if(existe){
                    //Setea los valores en el modal
                    $("#txtID").val(existe[0].idCalendarioMenu);
                    $("#rad_"+existe[0].idMenu).attr('checked',true);
                    $("#rad_"+existe[0].idMenuBingo).attr('checked',true);
                    //agrega las clases de platos seleccionados
                    $("#lbl_"+existe[0].idMenu).addClass('lblSelected');
                    $("#lbl_"+existe[0].idMenuBingo).addClass('lblSelectedBingo');
                    $("#fecha").val(existe[0].start);
                    $("#txtColor").val(existe[0].color);
                    alert(existe);

                    //botones
                    $("#btnAgregar").hide();
                    $("#btnEliminar").show();
                    $("#btnModificar").show();
                    if( check == today){
                        $("#confirmarPedido").show()
                    }else{
                        $("#confirmarPedido").hide()
                    }


                }else{
                    limpiar();
                    //botones
                    $("#btnAgregar").show();
                    $("#btnEliminar").hide();
                    $("#btnModificar").hide();
                    if( check == today){
                        $("#confirmarPedido").show()
                    }else{
                        $("#confirmarPedido").hide()
                    }


                }
            }
        });
      }


      $("#btnAgregar").click(function(){
          RecolectarDatosGUI();
          EnviarInformacion('agregar',NuevoEvento);
      });
      $("#btnModificar").click(function(){
          RecolectarDatosGUI();
          EnviarInformacion('modificar',NuevoEvento);
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
