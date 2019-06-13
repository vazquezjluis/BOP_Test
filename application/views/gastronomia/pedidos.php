
      <div class="span12">
        <div class="span12">
            <?php 
            if ($custom_error != '') {
                echo '<div class="pendiente">'.$custom_error.'</div>';
            } 
            
            if (isset($menu)){
                foreach ($menu as $m){ ?>
                    <form action="<?php echo base_url();?>index.php/pedido/agregar" id="formPedido" method="post">
                    <div class="span12">
                        <?php echo "<h2>Menu del día </h2><h3>".$m->descripcion.'  modificado ';
                        
                        if (substr($m->f_proceso,0,10) == date('Y-m-d')){
                            
                            echo 'Hoy '.date('H:m:s',  strtotime($m->f_proceso));
                        }else{
                            echo date('d/m/Y H:m:s',  strtotime($m->f_proceso)).'</h3>';
                        }
                        ?>
                    </div>
                    <div class="span12">
                        <input name="legajo" id="legajo" type="number"  class="solo-numero" onchange="ver_empleado(this.value)" ondrag="ver_empleado(this.value)" onkeydown="ver_empleado(this.value)" onkeypress="ver_empleado(this.value)" onkeyup="ver_empleado(this.value)"  onfocus="ver_empleado(this.value)"  placeholder="NRO. LEGAJO">
                        <?php 
                        if (isset($custom_success) and  $custom_success!= '') {
                            echo '<div id="pedido_realizado"  style="color:green"><h5>'.$custom_success.'!</h5></div>';
                         } ?>
                        <input type="hidden" name="idMenu" value="<?php echo $m->idMenuPersonal;?>">
                        <input type="hidden" id="persona" name="persona" value="">
                        <input type="hidden" id="persona_str" name="persona_str" value="">
                    </div>
                    <div class="span12" id="empleado">Ingrese su legajo para realizar el pedido.</div>
                    <div class="span12" style="margin-left: 0px;">
<!--                        <div class="span12">
                            <input type="button" class="btn btn-large" value="1">
                            <input type="button" class="btn btn-large" value="2">
                            <input type="button" class="btn btn-large" value="3">
                        </div>
                        <div class="span12">
                            <input type="button" class="btn btn-large" value="4">
                            <input type="button" class="btn btn-large" value="5">
                            <input type="button" class="btn btn-large" value="6">
                        </div>
                        <div class="span12">
                            <input type="button" class="btn btn-large" value="7">
                            <input type="button" class="btn btn-large" value="8">
                            <input type="button" class="btn btn-large" value="9">
                        </div>
                        <div class="span12">
                            <input type="button" class="btn btn-large" value="0">    
                        </div>-->
                <div class="span12"><hr></div>
                        <div class="span12">
                            <input type="button" name="borrar" onclick="limpiar()" id="borrar" class="btn btn-large btn-danger" disabled="disabled" value="Borrar">
                            <button type="submit" name="pedir" id="pedir" class="btn btn-large btn-success" disabled="disabled" ><i class="icon-plus icon-white"></i> Pedir</button>
                        </div>
                    </div>
                    </form>
                <?php }
            }else{ ?>
            <div><h3>Por el momento no hay menús cargados.</h3></div>
                <?php
            }
            ?>
            
        </div>
        
      </div>
<script>
    
 $(document).ready(function (){
      $('.solo-numero').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');
      });
      
      
    });
    function limpiar(){
         document.getElementById("legajo").value = "";
    }
    
    
    setTimeout(function() {
        $("#pedido_realizado").fadeOut(1500);
    },3000);
function ver_empleado(valor){
    if (valor.length>2){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>index.php/persona/verificarLegajo?leg="+valor,
            dataType: 'json',
            success: function(data)
            {
                if (data.persona =="error"){
                    $("#empleado").text('El empleado no existe.');
                    $("#persona").val('');
                    $("#persona_str").val('')
                    $('#pedir').attr("disabled", true);
                }else{
                    if (data.pedido == "pendiente"){
                        $("#empleado").text(data.nombre+" Esta persona ya tiene un pedido pendiente.")
                        $('#pedir').attr("disabled", true);
                    }else{
                        $("#empleado").text(data.nombre);
                        $('#pedir').attr("disabled", false);
                    }
                    $("#persona").val(data.persona);
                    $("#persona_str").val(data.nombre)
                    
                }
              
            }
        });
        
        $('#borrar').attr("disabled", false);
    }
}
</script>