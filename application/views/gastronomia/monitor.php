
<div class="container">
      <div class="span12" style="margin-left:0px;margin-bottom: 2px;">
        <div class="span10" style="margin-left:0px;margin-bottom: 2px;">
            <h4>Pedidos pendientes</h4>
            <?php 
            if (isset($pendiente)){
                ?>
            <table  class="table table-bordered " style="background-color:white;">
            <?php
                foreach ($pendiente as $p){ ?>
                
                    
                        <tr id="pendiente_<?php echo $p->idPedido;?>">
                            
                            <td>
                                <img style="border-radius:5px; width: 50px; height: 50px;" 
                                     src="<?php echo base_url(); ?>index.php/persona/imagen?id=<?php echo $p->persona;?>"  
                                     id="imgSalida">
                            </td>
                            
                            <td><?php echo $p->persona_str ;?></td>
                              
                            <td><b style="font-size:16px;"><?php echo strtoupper($p->menu.'  '.$p->menuBingo.' - '.date('d/m/Y H:m:s',  strtotime($p->f_registro))); ?></b></td>
                            
                            <td>
                                <?php
                                if($this->permission->checkPermission($this->session->userdata('permiso'),'ePedido')){ ?>
                                <button  value="<?php echo $p->idPedido; ?>" onclick="btnListo(this.value)"  class="btn btn-primary btnListo"><i class="icon icon-ok"></i> Pedido listo</button>
                                <?php } ?>
                            </td>
                        </tr>
                    
                
                <?php } ?>
            </table>
                <?php
                    }
                ?>
        </div>
        
        <div class="span10" style="margin-left:0px;margin-bottom: 2px;">
            <h4>Pedidos Listos</h4>
            
            <?php 
            if (isset($listo)){ ?>
            <table class="table table-bordered" style="background-color:white">
            <?php     foreach ($listo as $l){ ?>
                    
                    <tr id="listo_<?php echo $l->idPedido;?>">
                        <td>
                            <img style="border-radius:5px; width: 50px; height: 50px;" 
                                 src="<?php echo base_url(); ?>index.php/persona/imagen?id=<?php echo $l->persona;?>"  
                                 id="imgSalida">
                        </td>
                            
                        <td><?php echo $l->persona_str ;?></td>
                        
                        <td>
                            <b style="font-size:16px;"><?php echo strtoupper($l->menu.'  '.$l->menuBingo.' - '.date('d/m/Y H:m:s',  strtotime($l->f_registro))); ?></b>
                        </td>
                        
                        <td>
                            <?php
                            if($this->permission->checkPermission($this->session->userdata('permiso'),'ePedido')){ ?>
                                <div class="btn-group">
                                    <button  value="<?php echo $l->idPedido; ?>" onclick="btnDevolver(this.value)" class="btn btn-danger btnDevolver"><i class="icon icon-remove"></i> Devuelto</button>
                                    <button  value="<?php echo $l->idPedido; ?>" onclick="btnEntregado(this.value)" class="btn btn-success btnEntregado"><i class="icon icon-ok"></i> Entregado</button>
                                </div>
                            <?php } ?>
                        </td>   
                    </tr>
                   
                <?php } ?>
                     <tr id="nuevo_pedido_listo"></tr>
                </table>
            <?php    
            }
            ?>
            
        </div>
      </div>
</div>

<!--Modal Detalle-->
<div id="modalDetalle" class="modal hide fade" style="color: #00000;" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <h4> Describe brevemente el motivo de la devolucion o cancelación.</h4>
    </div>
    <div class="modal-body">    
      <div class="control-group">
          <textarea id="descripcion"></textarea>
          <input type="hidden" id="idPedido" >
      </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal"  aria-hidden="true">Cancelar</button>
        <button class="btn btn-success" id="btnAgregar">Guardar</button>
    </div>
</div>

<script>
        
        setTimeout('document.location.reload()',60000);
        //var f  =  new Date();
        //console.log(f.getSeconds());
        
        
        function btnEntregado(val){
            let idPedido = val;
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>index.php/pedido/pedido_entregado?val="+idPedido,
                //dataType: 'json',
                success: function(data)
                {
                    $("#listo_"+idPedido).replaceWith('');
                }
            });
        }
        function btnDevolver(val){
            $("#idPedido").val(val);
            $("#modalDetalle").modal();
        }
        function btnListo(val){
            
            $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>index.php/pedido/pedido_listo?val="+val,
                    dataType: 'json',
                    success: function(data)
                    {
                        
                        var html = 
                        '<tr id="listo_'+val+'" >'+
                            '<td>'+
                                '<img style="border-radius:5px; width: 50px; height: 50px;" '+
                                     'src="<?php echo base_url(); ?>index.php/persona/imagen?id='+data[0].persona+'" '+ 
                                     '>'+
                            '</td>'+
                            '<td>'+data[0].persona_str+'</td>'+
                            '<td>'+
                                '<b style="font-size:16px;">'+data[0].menu+'  '+data[0].menuBingo+' - '+data[0].f_registro+'</b>'+
                            '</td>'+
                            '<td>';
                                <?php
                                if($this->permission->checkPermission($this->session->userdata('permiso'),'ePedido')){ ?>
                                    html+='<div class="btn-group">'+
                                        '<button  value="'+val+'" onclick="btnDevolver(this.value)" class="btn btn-danger btnDevolver"><i class="icon icon-remove"></i> Devuelto</button>'+
                                        '<button  value="'+val+'" onclick="btnEntregado(this.value)"class="btn btn-success btnEntregado"><i class="icon icon-ok"></i> Entregado</button>'+
                                    '</div>'+
                                <?php } ?>
                            '</td>'+   
                        '</tr>'+
                        '<tr id="nuevo_pedido_listo"></tr>';
                        $("#nuevo_pedido_listo").replaceWith(html);
                        $("#pendiente_"+val).replaceWith('');
                    }
                });
        }
        function pedido_devuelto(){
            let val         = $("#idPedido").val();
            let descripcion = $("#descripcion").val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>index.php/pedido/pedido_devuelto?val="+val+"&desc="+descripcion,
                //dataType: 'json',
                success: function(data)
                {
                    $("#listo_"+val).replaceWith('');
                }
            });
            $("#descripcion").val('');
            $("#idPedido").val('');
            
        }
    
        $("#btnAgregar").click(function(){
            pedido_devuelto();
            $("#modalDetalle").modal('hide');
        });
    
    

</script>






