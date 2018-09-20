<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>

<style>
/* Hiding the checkbox, but allowing it to be focused */
.badgebox
{
    opacity: 0;
}

.badgebox + .badge
{
    /* Move the check mark away when unchecked */
    text-indent: -999999px;
    /* Makes the badge's width stay the same checked and unchecked */
	width: 27px;
}

.badgebox:focus + .badge
{
    /* Set something to make the badge looks focused */
    /* This really depends on the application, in my case it was: */
    
    /* Adding a light border */
    box-shadow: inset 0px 0px 5px;
    /* Taking the difference out of the padding */
}

.badgebox:checked + .badge
{
    /* Move the check mark back when checked */
	text-indent: 0;
}
</style>


<div class="span12" style="margin-left: 0px;">
    <div class="span4">
        <label class="control-label inline">Filtrar</label>
        <input type="text" id="articulo" class="span12" placeholder="Escribe el codigo o el nombre del articulo">
        <!--<input type="button" class="btn" id="cancel" value="Reset" >-->
    </div>
    <div class="span4">
        
    </div>
    <div class="span4 float-right">
<!--<a href="<?php // echo base_url();?>index.php/maquinas/agregar" class="btn btn-success">-->
            <?php // if($this->permission->checkPermission($this->session->userdata('permiso'),'cArticulos')){ ?>
        <!--<a href="<?php // echo base_url()?>index.php/articulo/agregar" class="btn btn-success" style="float: right;">-->
                <!--<i class="icon-plus icon-white"></i> Agregar nuevo Articulo</a>-->
            <?php // } ?>
    </div>
    
</div>

<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-barcode"></i>
            </span>
            <h5>Inventario</h5>

        </div>

        <div class="widget-content nopadding">
            
            <div class="quick-actions_homepage">
                <p>No hay Articulos cargados</p>
            </div>

        </div>
    </div>

<?php }else{
	

?>
<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-barcode"></i>
         </span>
        <h5>Articulos</h5>
        
     </div>

<div class="widget-content nopadding">
<div style="overflow-x:auto;">
<table class="table table-bordered">
    <tr>
        <!--<th>#</th>-->
        <!--<th>Articulo</th>-->
        <th>Codigo</th>
        <th>Stock</th>
        <th>Asociar a modelo</th>
        <!--<th>Laboratorio</th>-->
        <!--<th>Estado</th>-->
        <!--<th></th>-->
    </tr>
        <?php 
        foreach ($results as $r) {
//            if($r->estado == 1){$estado = "Activo";}else{$estado="Inactivo";}
//            if($r->categoria == 1){$categoria = "Electrónica";}else{$categoria="";}
            echo '<tr>';
//                echo '<td>'.$r->idArticulo.'</td>';
//                echo '<td>'.$r->nombre.'</td>';s
                echo '<td>'.$r->codigo.'</td>';
                echo '<td>'.$r->stock.'</td>';
//                echo '<td>'.$r->maquina.'</td>';
//                echo '<td>'.$r->laboratorio.'</td>';
//                echo '<td>'.$estado.'</td>';
                
                echo '<td> ';
//                 echo '<a href="'.base_url().'index.php/articulo/visualizar/'.$r->idArticulo.'"  class="btn tip-top" title="Ver detalle"><i class="icon-eye-open"></i></a>'; 
                 
//                if($this->permission->checkPermission($this->session->userdata('permiso'),'eArticulos')){ 
//                    echo '<a href="'.base_url().'index.php/articulo/editar/'.$r->idArticulo.'" class="btn btn-info tip-top" title="Editar Articulo"><i class="icon-pencil icon-white"></i></a>';
//                }
//                if($this->permission->checkPermission($this->session->userdata('permiso'),'dArticulos')){
                    echo '<a href="#modal-excluir"  class="btn  tip-top vincular_modelo" role="button" data-toggle="modal" codigoArticuloGenerico="'.$r->codigo.'"  title="Asociar modelo">
                                    <i class="icon-resize-small icon-white"></i></a>';
//                }             
                echo'</td>';
            echo '</tr>';
            
        }?>
    </tbody>
</table>
</div>
</div>
</div>
<?php   echo $this->pagination->create_links(); 
}?>



 
<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php   echo base_url() ?>index.php/articulo/asociarArticuloModelo" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Asociar Articulo a modelo</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="codigoArticulo" name="codigo" value="" />
    <div class="widget-content" style="border:1px solid #cccc;height: 150px;overflow-y:scroll; ">
            <table class="table" id="modelos">
                <thead>
                    <tr>
                        <td><input  type="text" id="filtrar" placeholder="Filtrar"></td>
                        <td>
                            <label>
                                <input name="marcarTodos" type="checkbox" value="1" id="marcarTodos" />
                                <span class="lbl"> Marcar Todos</span>
                            </label>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr id="losModelos" ></tr>
                </tbody>
            </table>
        </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-success">Guardar</button>
  </div>
  </form>
</div>

<script type="text/javascript">
      $(document).ready(function(){
          //marcar todos
          $("#marcarTodos").change(function () {
                $("input:checkbox").prop('checked', $(this).prop("checked"));
          });
          //muestra los modelos
          $(".vincular_modelo").click(function(){
              $.ajax({
                    type: "GET",
                    url: "<?php echo base_url(); ?>index.php/articulo/getArticuloModelo?codigo="+$(this).attr("codigoArticuloGenerico"),
                        
                    success: function(data){
                        $("#losModelos").replaceWith(data);
                    }
              });
          });
          //setea el hidden con el codigo del articulo seleccionado
          $(document).on('click', 'a', function(event) {       
               var articulo = $(this).attr('codigoArticuloGenerico');
               $('#codigoArticulo').val(articulo);
          });
          
          
          //Filtrar 
            var contenido_fila;
            var coincidencias;
            var codigoAscci;
          $("#filtrar").keyup(function(){
                if(!checkTeclaDel(event)){
                    filtrar($(this).val());
                }
            });
            function filtrar(cadena){
              $("#modelos tbody tr").each(function(){
                  $(this).removeClass('ocultar');
                  contenido_fila =  $(this).find('td:eq(0)').text();
                  exp = new RegExp(cadena,'gi');
                  coincidencias = contenido_fila.match(exp);
                  if(coincidencias!=null){
                      $(this).addClass('resaltar');
                  }else{
                      $(this).addClass('ocultar');
                  }
              } );
          }
          
          function mostrarFilas(){
              $("#modelos tbody tr").each(function(){
                  $(this).removeClass('ocultar resaltar');
              });
          }
          
          function checkTeclaDel(e){
              
              codigoAscci = e.which;
              
              if(codigoAscci==8){
                  if($("#filtrar").val().length>0){
                      filtrar($("#filtrar").val());
                  }else{
                      mostrarFilas();
                  }
                  return true;
              }else{
                  return false;
              }
          } 
            
            
      });
</script>
<!--<script type="text/javascript">
$(document).ready(function(){

   
    
    
    
    $("#cancel").hide();
    $("#persona").autocomplete({
        source: "<?php // echo base_url(); ?>index.php/licencia/autoCompletePersona",
        minLength: 1,
        select: function( event, ui ) {
                $("#persona_id").val(ui.item.id);
                $("#persona").attr("readonly",true);
                $("#cancel").show();
            }
        });
          
    $("#cancel").click(function(){
        $("#persona_id").val("");
        $("#persona").val("");
        $("#persona").attr("readonly",false);
        $(this).hide();
        });

});

</script>-->

