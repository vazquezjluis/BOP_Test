
      <div class="span12">
        <div class="span12">
            <h3>Pedidos pendientes</h3>
            <?php 
            if (isset($pendiente)){
                foreach ($pendiente as $p){ ?>
            <div id="pendiente_<?php echo $p->idPedido;?>" class="pendiente">
                        <?php echo $p->persona_str.' '.$p->menu.' '.date('d/m/Y H:m:s',  strtotime($p->f_registro));?>
                        
                        <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'ePedido')){ ?>
                            <button style="float: right;" value="<?php echo $p->idPedido; ?>" onclick="pedido_listo(this.value)" class="btn btn-danger"><i class="icon icon-ok"></i> Pedido listo</button>
                        <?php } ?>
                    </div>
                <?php }
            }
            ?>
            
        </div>
        
        <div class="span12">
            <h3>Pedidos Listos</h3>
            
            <?php 
            if (isset($listo)){
                foreach ($listo as $l){ ?>
                <div id="listo_<?php echo $l->idPedido;?>" class="listo">
                        <?php echo $l->persona_str.' '.$l->menu.' '.date('d/m/Y H:m:s',  strtotime($l->f_registro));?>
                        <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'ePedido')){ ?>    
                            <button style="float: right;" value="<?php echo $l->idPedido; ?>" onclick="pedido_entregado(this.value)" class="btn btn-success"><i class="icon icon-ok"></i> Entregado</button>
                        <?php } ?>        
                </div>
                <?php }
            }
            ?>
            <div id="nuevo_pedido_listo"></div>
        </div>
      </div>

<script>
    setTimeout('document.location.reload()',10000);
    function pedido_listo (val){
        console.log(val);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>index.php/pedido/pedido_listo?val="+val,
            //dataType: 'json',
            success: function(data)
            {
                var html = '<div id="listo_'+val+'"class="listo">'+data+'<button style="float: right;" value="'+val+'" onclick="pedido_entregado(this.value)" class="btn btn-success"><i class="icon icon-ok"></i> Entregado</button></div>\n\
                <div id="nuevo_pedido_listo"></div>';
                $("#nuevo_pedido_listo").replaceWith(html);
                $("#pendiente_"+val).replaceWith('');
            }
        });
        
    }
    function pedido_entregado(val){
        console.log(val)
         $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>index.php/pedido/pedido_entregado?val="+val,
            //dataType: 'json',
            success: function(data)
            {
                $("#listo_"+val).replaceWith('');
            }
        });
    }

</script>






