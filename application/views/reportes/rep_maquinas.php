<!--<link rel="stylesheet" href="<?php // echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />-->
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>

<form method="get" id="formBuscar" action="<?php echo current_url(); ?>">
    <div class="span12">
        <div class="span2" >
            <label for="buscar" class="control-label">UID<span class="required">*</span></label>
            <!--<input type="text" style="width: 99%;" name="uid"   id="uid"  placeholder=""  value="<?php //  echo $this->input->get('uid'); ?>" >-->
            <select  name="uid" style="width: 99%;">
                <option value="">Todas</option>
                <?php
                foreach ($maquinas as $ma){ ?>
                <option <?php if ($ma->nro_egm == $this->input->get('uid')){ echo 'selected';} ?> value="<?php echo $ma->nro_egm; ?>"><?php echo $ma->nro_egm; ?></option>
                <?php
                }
                ?>
                
            </select>
        </div>
        <div class="span2">
            <label for="buscar" class="control-label">Fabricante<span class="required">*</span></label>
            <!--<input type="text" style="width: 99%;" name="fabricante"    id="fabricante"  placeholder=""  value="<?php echo $this->input->get('fabricante'); ?>" >-->
            <select  name="fabricante" style="width: 99%;">
                <option value="">Todas</option>
                <?php
                foreach ($fabricantes as $fa){ ?>
                <option <?php if ($fa->fabricante == $this->input->get('fabricante')){ echo 'selected';} ?> value="<?php echo $fa->fabricante; ?>"><?php echo $fa->fabricante; ?></option>
                <?php
                }
                ?>
                
            </select>
        </div>
        <div class="span2">
            <label for="buscar" class="control-label">Modelo<span class="required">*</span></label>
            <!--<input type="text"  style="width: 99%;" name="modelo"   id="fabricante"  placeholder=""  value="<?php //echo $this->input->get('modelo'); ?>" >-->
            <select  name="modelo" style="width: 99%;">
                <option value="">Todas</option>
                <?php
                foreach ($modelos as $mo){ ?>
                <option <?php if ($mo->modelo == $this->input->get('modelo')){ echo 'selected';} ?> value="<?php echo $mo->modelo; ?>"><?php echo $mo->modelo; ?></option>
                <?php
                }
                ?>
                
            </select>
        </div>
        <div class="span2">
            <label for="buscar" class="control-label">Estado<span class="required">*</span></label>
            <select  name="estado" style="width: 99%;">
                <option value="">Todas</option>
                <option <?php if ($this->input->get('estado') =="1"){ echo 'selected';} ?> value="1">Activas</option>
                <option <?php if ($this->input->get('estado') =="0"){ echo 'selected';} ?> value="0">Fuera de servicio</option>
            </select>
        </div>
        <div class="span3">
            <label>&nbsp;</label>
            <button class="btn" style="margin-bottom: 10px;margin-left: -4px;"><i class="icon-search"></i> Buscar</button>
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
        <h5>Listado de Maquinas  - <?php echo $total." registros."?></h5>

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
