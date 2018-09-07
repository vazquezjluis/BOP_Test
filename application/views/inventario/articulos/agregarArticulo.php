<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
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
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-align-justify"></i>
                </span>
                <h5>Datos del articulo</h5>
            </div>
            <div class="widget-content nopadding">
                <?php echo $custom_error; ?>
                <form action="<?php echo current_url(); ?>" id="formArticulo" method="post" class="form-horizontal" >
                     <div class="control-group">
                        <label for="nombre" class="control-label">Nombre <span class="required">*</span></label>
                        <div class="controls">
                            <input id="nombre" type="text" name="nombre" value="<?php echo set_value('nombre'); ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descripcion" class="control-label">Decripción </label>
                        <div class="controls">
                            <textarea id="descripcion" type="text" name="descripcion"   ><?php echo set_value('descripcion'); ?></textarea>
                        </div>
                    </div>


<!--                    <div class="control-group">
                        <label class="control-label">Tipo de Movimiento</label>
                        <div class="controls">
                            <label for="entrada" class="btn btn-default" style="margin-top: 5px;">Entrada 
                                <input type="checkbox" id="entrada" name="entrada" class="badgebox" value="1" checked>
                                <span class="badge" >&check;</span>
                            </label>
                            <label for="salida" class="btn btn-default" style="margin-top: 5px;">Salida 
                                <input type="checkbox" id="salida" name="salida" class="badgebox" value="1" checked>
                                <span class="badge" >&check;</span>
                            </label>
                        </div>
                    </div>-->

<!--                    <div class="control-group">
                        <label for="precioCompra" class="control-label">Precio de Compra</label>
                        <div class="controls">
                            <input id="precioCompra" class="money" type="text" name="precioCompra" value="<?php // echo set_value('precioCompra'); ?>"  />
                        </div>
                    </div>-->

<!--                    <div class="control-group">
                        <label for="precioVenta" class="control-label">Precio de Venta</label>
                        <div class="controls">
                            <input id="precioVenta" class="money" type="text" name="precioVenta" value="<?php // echo set_value('precioVenta'); ?>"  />
                        </div>
                    </div>-->

                    <div class="control-group">
                    <label for="categoria" class="control-label">Categoria<span class="required">*</span></label>
                    <div class="controls">
                        <!--<input id="unidade" type="text" name="unidade" value="<?php echo set_value('categoria'); ?>"  />-->
                        <select id="categoria" name="categoria">
                            <option value="1">Electrónica</option>
                        </select>
                    </div>
                    </div>       

                    <div class="control-group">
                        <label for="modelo" class="control-label">Asociar a un modelo de máquina</label>
                        <div class="controls">
                            <div class="span6">
                                <div class="accordion" id="accordion">
                                <div class="accordion-group widget-box">
                                  <div class="accordion-heading">
                                      <div class="widget-title tipoModelo" data-tipo="modelo">
                                          <span class="icon"><i class="icon-list"></i></span>
                                          <h5 id="filtrar_text">Mostrar modelos</h5>
                                          
                                      </div>
                                  </div>
                                </div>
                                <div class="accordion-body">
                                    <div class="widget-content" style="border:1px solid #cccc;height: 150px;overflow-y:scroll; ">
                                        <table class="table" id="modelos">
                                            <thead>
                                                <tr>
                                                    <td><input  type="text" id="filtrar" placeholder="Filtrar"></td>
                                                    <td>
                                                        <label>
                                                            <input name="marcarTodos" type="checkbox" value="1" id="marcarTodos" />
                                                            <span class="lbl"> Marcar Todos</span>
                                                        </label></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                if($modelos){
                                                  foreach ($modelos as $model){                                  
                                                      echo '<tr><td colspan="2"><label><input type="checkbox" name="tipoModelo[]" style="vertical-align: middle;position: relative;bottom: 3px;" value="'.$model->modelo.'"> '.$model->modelo.'</label></td></tr>';
                                                  }
                                                }
                                
                                                ?>
                                            </tbody>
                                        </table>
                                </div>
                            </div>
                            </div>
                            </div>
                        </div>
                    </div>                     

                    <div class="control-group">
                        <label for="stock" class="control-label">Stock<span class="required">*</span></label>
                        <div class="controls">
                            <input id="stock" type="text" name="stock" value="<?php echo set_value('stock'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="stockMinimo" class="control-label">Stock Mínimo</label>
                        <div class="controls">
                            <input id="stockMinimo" type="text" name="stockMinimo" value="<?php echo set_value('stockMinimo'); ?>"  />
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar</button>
                                <a href="<?php echo base_url() ?>index.php/articulo/gestionar" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
                            </div>
                        </div>
                    </div>

                    
                </form>
            </div>

         </div>
     </div>
</div>

<script src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>assets/js/maskmoney.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#marcarTodos").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });
        
        var contenido_fila;
        var coincidencias;
        var codigoAscci;
        $( function() {
            $( "#accordion" ).accordion({
              collapsible: true,
              active: false,
              heightStyle: "content",
              activate: function(){
                    $("#filtrar").keyup(function(){
                        if(!checkTeclaDel(event)){
                            filtrar($(this).val());
                           
                        }

                    });
                
              }
              
            });
          } );
          
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
          
        $(".money").maskMoney();

        $('#formArticulo').validate({
            rules :{
                  nombre: { required: true},
                  categoria: { required: true},
                  
                  stock: { required: true}
            },
            messages:{
                  nombre: { required: 'Campo Requerido.'},
                  categoria: {required: 'Campo Requerido.'},
                  stock: { required: 'Campo Requerido.'}
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
    });
</script>



