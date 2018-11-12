<!--<link rel="stylesheet" href="<?php // echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />-->
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>


      
<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-desktop"></i>
            </span>
            <h5>Personas</h5>

        </div> 
    </div>

<?php }else{
	

?>
<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-desktop"></i>
         </span>
        <h5>Listado de Personas  - <?php echo " registros."?></h5>

     </div>

<div class="widget-content nopadding">

<div style="overflow-x:auto;">
<table class="table">
    <thead>
        <tr>
            <td><strong>Máquina</strong></td>
            <td><strong>Modelo</strong></td>
            <td><strong>Fabricante</strong></td>
            <td><strong>Tickets abiertos</strong></td>
            <td><strong>Fallas activas</strong></td>
            <td><strong>Partes</strong></td>
            <td><strong>Estado</strong></td>
            <td><strong>Accion</strong></td>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        foreach ($results as $r) {
            //Estado
            if($r->estado == 1){//activo
                $class_2= ' style="margin-top:10%;padding:5%;width:10px;height:10px; background-color:green;border-radius:10px;"';
                }
            else{//fuera de servicio
                $class_2= ' style="margin-top:10%;padding:5%;width:10px;height:10px; background-color:red;border-radius:10px;"';
                $estado = ' ';
            }
            
            if ($r->partes!=''){
                $class_3= ' style="margin-top:10%;padding:5%;width:10px;height:10px; background-color:green;"';
            }else{
                $class_3= ' style="margin-top:10%;padding:5%;width:10px;height:10px; background-color:red;"';
            }
            //Fallo
            $tickets='';
            if(isset($r->tickets) and $r->tickets!=''){
                $mis_tickets = explode("-_-", $r->tickets);
                $tickets='';
                foreach ($mis_tickets as $t){
                    $t = explode(":", $t);
                    $tickets.=",".$t[0];
                }
            } 
            
            echo '<tr>';
            echo '<td>
                        <b>UID: </b>'.$r->nro_egm.'<br>
                        <b>Juego: </b>'.$r->juego.'<br>
                        <b>Serie: </b>'.$r->nro_serie.'  ';
            //if($this->permission->checkPermission($this->session->userdata('permiso'),'vTicket')){
                    
            //}
            echo'</td>';
            echo'<td>'.$r->modelo.'</td>';
            echo'<td>'.$r->fabricante.'</td>';
            echo'<td>'.$tickets.'</td>';
            echo'<td>'.$r->falla.'</td>';
            echo'<td><div '.$class_3.'></div></td>';
            echo '<td>'; 
                        
            echo '<div '.$class_2.'></div>';
                        
                    echo'</td><td>';
                    echo '<a href="'.base_url().'index.php/maquinas?buscar='.substr($r->nro_egm, 3).'" style="margin-top:5%;;margin-right: 1%;" class="btn tip-top" title="Ver detalle"><i class="icon-eye-open"></i></a>'; 
                             
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
</div>
<?php  echo $this->pagination->create_links();
}?>


<script type="text/javascript">


$(document).ready(function(){
   $(document).on('click', 'a', function(event) {
        //obtiene el id de maquina desde la maquina
        var maquina = $(this).attr('maquina');
        $('#idMaquina').val(maquina);
        $('#referencia').val(maquina);

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


</script>
