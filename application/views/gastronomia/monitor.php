
<div class="container">
      <div class="span12" style="margin-left:0px;">
        <div class="span12" style="margin-left:0px;">
            <h3>Pedidos pendientes</h3>
            <?php 
            if (isset($pendiente)){
                foreach ($pendiente as $p){ ?>
                
                    <div id="pendiente_<?php echo $p->idPedido;?>" class="span12 alert alert-danger" style="margin-left:0px;" >
                        
                        <div class="span3" style="margin-left:0px;">
                            <div style="width:50%;float: left;">
                                <img style="border-radius:5px; width: 60px; height: 60px;" 
                                     src="<?php echo base_url(); ?>index.php/persona/imagen?id=<?php echo $p->persona;?>"  
                                     id="imgSalida">
                            </div>
                            <div style="width:50%;float: left;"><?php echo $p->persona_str ;?></div>
                        </div>
                        <div class="span6">
                            <b style="font-size:16px;"><?php echo strtoupper($p->menu.' - '.date('d/m/Y H:m:s',  strtotime($p->f_registro))); ?></b>
                        </div>
                        <div class="span2">
                            <?php
                            if($this->permission->checkPermission($this->session->userdata('permiso'),'ePedido')){ ?>
                            <button style="float: right;" value="<?php echo $p->idPedido; ?>" onclick="btnListo(this.value)"  class="btn btn-danger btnListo"><i class="icon icon-ok"></i> Pedido listo</button>
                            <?php } ?>
                        </div>   
                        
                    </div>
                
                <?php }
                    }
                ?>
        </div>
        
        <div class="span12" style="margin-left:0px;">
            <h3>Pedidos Listos</h3>
            
            <?php 
            if (isset($listo)){
                foreach ($listo as $l){ ?>
                <div id="listo_<?php echo $l->idPedido;?>" class="span12 alert alert-success" style="margin-left:0px;">
                    
                    <div class="span3" style="margin-left:0px;">
                            <div style="width:50%;float: left;">
                                <img style="border-radius:5px; width: 60px; height: 60px;" 
                                     src="<?php echo base_url(); ?>index.php/persona/imagen?id=<?php echo $l->persona;?>"  
                                     id="imgSalida">
                            </div>
                            <div style="width:50%;float: left;"><?php echo $l->persona_str ;?></div>
                        </div>
                        <div class="span6">
                            <b style="font-size:16px;"><?php echo strtoupper($l->menu.' - '.date('d/m/Y H:m:s',  strtotime($l->f_registro))); ?></b>
                        </div>
                        <div class="span2">
                            <?php
                            if($this->permission->checkPermission($this->session->userdata('permiso'),'ePedido')){ ?>
                                <div class="btn-group">
                                    <button  value="<?php echo $l->idPedido; ?>" onclick="btnDevolver(this.value)" class="btn btn-danger btnDevolver"><i class="icon icon-remove"></i> Devuelto</button>
                                    <button  value="<?php echo $l->idPedido; ?>" onclick="btnEntregado(this.value)" class="btn btn-success btnEntregado"><i class="icon icon-ok"></i> Entregado</button>
                                </div>
                            <?php } ?>
                        </div>   
                </div>
                <?php }
            }
            ?>
            <div id="nuevo_pedido_listo"></div>
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
        
        //setTimeout('document.location.reload()',10000);
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
                        '<div id="listo_'+val+'" class="span12 alert alert-success" style="margin-left:0px;" >'+
                            '<div class="span3" style="margin-left:0px;">'+
                                '<div style="width:50%;float: left;">'+
                                    '<img style="border-radius:5px; width: 60px; height: 60px;" '+
                                         'src="<?php echo base_url(); ?>index.php/persona/imagen?id='+data[0].persona+'" '+ 
                                         '>'+
                                '</div>'+
                                '<div style="width:50%;float: left;">'+data[0].persona_str+'</div>'+
                            '</div>'+
                            '<div class="span6">'+
                                '<b style="font-size:16px;">'+data[0].menu+''+data[0].f_registro+'</b>'+
                            '</div>'+
                            '<div class="span2">';
                                <?php
                                if($this->permission->checkPermission($this->session->userdata('permiso'),'ePedido')){ ?>
                                    html+='<div class="btn-group">'+
                                        '<button  value="'+val+'" onclick="btnDevolver(this.value)" class="btn btn-danger btnDevolver"><i class="icon icon-remove"></i> Devuelto</button>'+
                                        '<button  value="'+val+'" onclick="btnEntregado(this.value)"class="btn btn-success btnEntregado"><i class="icon icon-ok"></i> Entregado</button>'+
                                    '</div>'+
                                <?php } ?>
                            '</div>'+   
                        '</div>'+
                        '<div id="nuevo_pedido_listo"></div>';
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






