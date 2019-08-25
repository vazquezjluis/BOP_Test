<script src="<?php echo base_url()?>assets/js/jquery-1.10.2.min.js"></script>
<script src="<?php echo base_url()?>assets/js/moment.min.js"></script>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fullcalendar.css">
<script src="<?php echo base_url()?>assets/js/fullcalendar.min.js"></script>
<script src="<?php echo base_url()?>assets/js/es.js"></script>
<script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>

<!--reloj-->
<script src="<?php echo base_url()?>assets/js/bootstrap-clockpicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-clockpicker.css">

<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-lock"></i>
         </span>
        <h5>Sala de reuniones</h5>
     </div>
    <br>
    <div class="widget-content nopadding">
        
            <div id="calendarioWeb"></div>
       
    </div>
</div>



 

<!-- Modal Agregar, Modificar, Eliminar-->
<div id="modalEventos" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5>Evento</h5>
  </div>
  <div class="modal-body">
      
      
      <input type="hidden" id="txtId" name="txtId">
      <input type="hidden" id="txtFecha" name="txtFecha" required="required">
      
      <div class="controls controls-row">
          

          <table border="0" cellpadding="9">
              <tbody>
                  <tr>
                      <td>
                            <label>Titulo:</label>
                            <input type="text" id="txtTitulo" class="form-control" name="txtTitulo" required="required">
                      </td>
                      <td>
                            <label>Hora del evento:</label>
                            <div class="input-group clockpicker" data-autoclose="true">
                                <input type="text" id="txtHora" class="form-control" value="10:30" name="txtFecha">
                            </div>
                            
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2">
                            <label>Descripcion:</label>
                            <textarea id="txtDescripcion" class="form-control" rows="3" style="width: 97%;"></textarea>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2">
                            <label>Color:</label>
                            <input type="color" value="#FF0000" id="txtColor" class="form-control" style="height: 20px;width: 97%;" >
                      </td>
                  </tr>
              </tbody>
          </table>

      </div>
      
       
       
  </div>
  <div class="modal-footer">
      <?php 
      if($this->permission->checkPermission($this->session->userdata('permiso'),'cSala')){ ?>
      <button id="btnAgregar" class="btn btn-success">Agregar</button>
      <?php } 
      if($this->permission->checkPermission($this->session->userdata('permiso'),'eSala')){
      ?>
      <button id="btnModificar" class="btn btn-warning">Modificar</button>
      <?php } 
      if($this->permission->checkPermission($this->session->userdata('permiso'),'dSala')){
      ?>
      <button id="btnEliminar" class="btn btn-danger">Borrar</button>
      <?php } 
      
      ?>
      <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    
  </div>
</div>
<script>
$(document).ready(function(){
    var NuevoEvento;
    
    function RecolectarDatosGUI(){
         NuevoEvento = {
            idSala:$("#txtId").val(),
            title:$("#txtTitulo").val(),
            start:$("#txtFecha").val()+" "+$("#txtHora").val(),
            color:$("#txtColor").val(),
            descripcion:$("#txtDescripcion").val(),
            textColor:"#FFFFF",
            end:$("#txtFecha").val()+" "+$("#txtHora").val(),
        };
    }
    $("#btnAgregar").click(function(){
        RecolectarDatosGUI();
        EnviarInformacion('agregar',NuevoEvento);
    });
    $("#btnEliminar").click(function(){
        RecolectarDatosGUI();
        EnviarInformacion('eliminar',NuevoEvento);
    });
    $("#btnModificar").click(function(){
        RecolectarDatosGUI();
        EnviarInformacion('editar',NuevoEvento);
    });
    
    function EnviarInformacion(accion,objEvento,modal){
          $.ajax({
              type:'POST',
              url:'<?php echo site_url() ?>/Sala/'+accion,
              data:objEvento,
              success:function(msg){
                  if(msg){
                      $("#calendarioWeb").fullCalendar('refetchEvents');
                      if(!modal){
                          $("#modalEventos").modal('toggle');
                      }
                      
                  }
              },
              error:function(){
                  alert("Hay un error...");
              }
          });
    }
    
    
    
    $("#calendarioWeb").fullCalendar({
        header:{
            left:'today,prev,next',
            center:'title',
            right:'month,basicWeek,basicDay'
        },
        dayClick:function(date,jsEvent,view){
            limpiarFormulario();
            $("#txtFecha").val(date.format());
            $("#modalEventos").modal();
        },
        events:'<?php echo site_url() ?>/Sala/gestionar',
        editable:true,
        eventDrop:function(calEvent){
            $("#txtDescripcion").val(calEvent.descripcion);
            $("#txtId").val(calEvent.idSala);
            $("#txtTitulo").val(calEvent.title);
            $("#txtColor").val(calEvent.color);
            
            var fechaHora = calEvent.start.format().split("T");
            $("#txtFecha").val(fechaHora[0]);
            $("#txtHora").val(fechaHora[1]);
            
            RecolectarDatosGUI();
            EnviarInformacion('editar',NuevoEvento,true);
        },
        eventClick:function(calEvent, jsEvent, view){
            $("#tituloEvento").html(calEvent.title);
            
            //Mostrar la informacion del evento en los inputs
            $("#txtDescripcion").val(calEvent.descripcion);
            $("#txtId").val(calEvent.idSala);
            $("#txtTitulo").val(calEvent.title);
            $("#txtColor").val(calEvent.color);
            FechaHora = calEvent.start._i.split(" ");
            $("#txtFecha").val(FechaHora[0]);
            $("#txtHora").val(FechaHora[1]);
            
            $("#modalEventos").modal();
        }
    });
    
    function limpiarFormulario(){
        $("#txtDescripcion").val('');
        $("#txtId").val('');
        $("#txtTitulo").val('');
        $("#txtColor").val('');
    }
    $(".clockpicker").clockpicker();
});    
</script>

