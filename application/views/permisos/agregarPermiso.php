<div class="span12" style="margin-left: 0">
    <form action="<?php echo base_url();?>index.php/permisos/agregar" id="formPermiso" method="post">

    <div class="span12" style="margin-left: 0">
        
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-lock"></i>
                </span>
                <h5>Datos de Permisos</h5>
            </div>
            <div class="widget-content">
                
                <div class="span6">
                    <label>Nombre del Permiso</label>
                    <input name="nombre" type="text" id="nombre" class="span12" />

                </div>
                <div class="span6">
                    <br/>
                    <label>
                        <input name="marcarTodos" type="checkbox" value="1" id="marcarTodos" />
                        <span class="lbl"> Marcar Todos</span>

                    </label>
                    <br/>
                </div>

                <div class="control-group">
                    <label for="documento" class="control-label"></label>
                    <div class="controls">
                        
                        <div class="widget-box">
                                <div class="widget-title">
                                   <ul class="nav nav-tabs">
                                      <li class="active"><a data-toggle="tab" href="#tab1">Técnicos</a></li>
                                      <li><a data-toggle="tab" href="#tab2">RRHH</a></li>
                                      <li><a data-toggle="tab" href="#tab3">Inventario</a></li>
                                      <li><a data-toggle="tab" href="#tab4">Importadores</a></li>
                                      <li><a data-toggle="tab" href="#tab5">Configuracion</a></li>
                                      <li><a data-toggle="tab" href="#tab6">Ayuda</a></li>
                                      <li><a data-toggle="tab" href="#tab7">Gastronomia</a></li>
                                      <li><a data-toggle="tab" href="#tab8">Sala Reuniones</a></li>

                                   </ul>
                                </div>
                                <div class="widget-content tab-content">
                                   <!--TECNICOS--> 
                                   <div id="tab1" class="tab-pane active" style="min-height: 300px">
                                      <table class="table table-bordered">
                                         <tbody>
                                             <!--MAQUINAS-->
                                             <tr>

                                                 <td>
                                                     <label>
                                                         <input name="vMaquina" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> Visualizar Maquina</span>
                                                     </label>
                                                 </td>

                                                 <td>
                                                     <label>
                                                         <input name="cMaquina" class="marcar" type="checkbox" value="1" />
                                                         <span class="lbl"> Agregar Maquina</span>
                                                     </label>
                                                 </td>

                                                 <td>
                                                     <label>
                                                         <input name="eMaquina" class="marcar" type="checkbox" value="1" />
                                                         <span class="lbl"> Editar Maquina</span>
                                                     </label>
                                                 </td>

                                                 <td>
                                                     <label>
                                                         <input name="dMaquina" class="marcar" type="checkbox" value="1" />
                                                         <span class="lbl"> Eliminar Maquina</span>
                                                     </label>
                                                 </td>

                                             </tr>
                                             <tr><td colspan="4"></td></tr>
                                             <!--FALLAS-->
                                             <tr>

                                                 <td>
                                                     <label>
                                                         <input name="vFallas" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> Visualizar Fallas</span>
                                                     </label>
                                                 </td>

                                                 <td>
                                                     <label>
                                                         <input name="cFallas" class="marcar" type="checkbox" value="1" />
                                                         <span class="lbl"> Agregar Fallas</span>
                                                     </label>
                                                 </td>

                                                 <td>
                                                     <label>
                                                         <input name="eFallas" class="marcar" type="checkbox" value="1" />
                                                         <span class="lbl"> Editar Fallas</span>
                                                     </label>
                                                 </td>

                                                 <td>
                                                     <label>
                                                         <input name="dFallas" class="marcar" type="checkbox" value="1" />
                                                         <span class="lbl"> Eliminar Fallas</span>
                                                     </label>
                                                 </td>

                                             </tr>
                                             <tr><td colspan="4"></td></tr>
                                             <!--LABORATORIO-->
                                             <tr>
                                                 <td colspan="4">
                                                     <label>
                                                         <input name="vLaboratorio" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> Visualizar Laboratorio</span>
                                                     </label>
                                                 </td> 
                                             </tr>
                                             <tr><td colspan="4"></td></tr>
                                             <!--REPORTE-->
                                             <tr>
                                                 <td>
                                                     <label>
                                                         <input name="vRep_maquinas" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> Ver Reporte máquinas</span>
                                                     </label>
                                                 </td>
                                                 <td>
                                                     <label>
                                                         <input name="vRep_ticket" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> Ver Reporte tickets</span>
                                                     </label>
                                                 </td>
                                                 <td>
                                                     
                                                 </td>
                                                 <td>
                                                 </td>
                                             </tr>
                                         </tbody>
                                      </table>
                                   </div>

                                   <!--RRHH-->
                                   <div id="tab2" class="tab-pane" style="min-height: 300px">
                                       <table class="table table-bordered">
                                         <tbody>
                                             <tr>
                                                 <td colspan="1">
                                                     <label>
                                                         <input name="vPersonas" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> Visualizar Personas</span>
                                                     </label>
                                                 </td>
                                                 <td colspan="1">
                                                     <label>
                                                         <input name="vLicencia" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> Visualizar Licencias</span>
                                                     </label>
                                                 </td>
                                                 <td colspan="1">
                                                     <label>
                                                         <input name="vCapacitancion" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> Visualizar Capacitacion</span>
                                                     </label>
                                                 </td>
                                                 <td colspan="1">
                                                     <label>
                                                         <input name="vPremios" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> Visualizar Premios</span>
                                                     </label>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td colspan="1">
                                                     <label>
                                                         <input name="vDesempeno" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> Visualizar Desempeño</span>
                                                     </label>
                                                 </td>
                                                 <td colspan="1">
                                                     <label>
                                                         <input name="cDesempeno" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> Agregar Desempeño</span>
                                                     </label>
                                                 </td>
                                                 <td colspan="1">
                                                     <label>
                                                         <input name="eDesempeno" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> Editar Desempeño</span>
                                                     </label>
                                                 </td>
                                                 <td colspan="1">
                                                     <label>
                                                         <input name="dDesempeno" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> eliminar Desempeño</span>
                                                     </label>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td colspan="1">
                                                     <label>
                                                         <input name="vTitulo" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> Visualizar Titulo</span>
                                                     </label>
                                                 </td>
                                                 <td colspan="1">
                                                     <label>
                                                         <input name="cTitulo" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> Agregar Titulo</span>
                                                     </label>
                                                 </td>
                                                 <td colspan="1">
                                                     <label>
                                                         <input name="eTitulo" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> Editar Titulo</span>
                                                     </label>
                                                 </td>
                                                 <td colspan="1">
                                                     <label>
                                                         <input name="dTitulo" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> eliminar Titulo</span>
                                                     </label>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td colspan="1">
                                                     <label>
                                                         <input name="vEstudio" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> Visualizar Estudio</span>
                                                     </label>
                                                 </td>
                                                 <td colspan="1">
                                                     <label>
                                                         <input name="cEstudio" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> Agregar Estudio</span>
                                                     </label>
                                                 </td>
                                                 <td colspan="1">
                                                     <label>
                                                         <input name="eEstudio" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> Editar Estudio</span>
                                                     </label>
                                                 </td>
                                                 <td colspan="1">
                                                     <label>
                                                         <input name="dEstudio" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> eliminar Estudio</span>
                                                     </label>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td colspan="1">
                                                     <label>
                                                         <input name="vAvisoTicket" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> Notificar avisos con tickets.</span>
                                                     </label>
                                                 </td>
                                                 <td colspan="1">
                                                 </td>
                                                 <td colspan="1">
                                                 </td>
                                                 <td colspan="1">
                                                 </td>
                                             </tr>
                                         </tbody>
                                      </table>
                                       <table class="table table-bordered" id="rrhh_sector">
                                           
                                           <tr><td colspan="3"><label><input type="checkbox" id="todos_sectores"><i><b> Marcar todos los sectores</b></i></label></td></tr>
                                               <?php
                                               $a=0;
                                               foreach ($sectores as $sector) {
                                                 $a++;
                                                 if ($a ==3){echo "<tr></tr>"; $a=0;}?>
                                                
                                                <td>
                                                    <label><input  name="<?php echo str_replace(" ","",str_replace(".","",$sector->descripcion));?>" class="marcar_sector" type="checkbox" value="1" /><?php echo $sector->descripcion;?></label></td>
                                                
                                               <?php
                                               }
                                               ?>
                                           
                                       </table> 
                                   </div>

                                   <!--INVENTARIO-->
                                   <div id="tab3" class="tab-pane" style="min-height: 300px">
                                       <table class="table table-bordered">
                                             <tbody>
                                                 <!--ARTICULOS-->
                                                 <tr>
                                                     <td>
                                                         <label>
                                                             <input name="vArticulos" class="marcar" type="checkbox"  value="1" />
                                                             <span class="lbl"> Visualizar Articulos</span>
                                                         </label>
                                                     </td>
                                                     <td>
                                                         <label>
                                                             <input name="cArticulos" class="marcar" type="checkbox" value="1" />
                                                             <span class="lbl"> Agregar Articulos</span>
                                                         </label>
                                                     </td>
                                                     <td>
                                                         <label>
                                                             <input name="eArticulos" class="marcar" type="checkbox" value="1" />
                                                             <span class="lbl"> Editar Articulo</span>
                                                         </label>
                                                     </td>
                                                     <td>
                                                         <label>
                                                             <input name="dArticulos" class="marcar" type="checkbox" value="1" />
                                                             <span class="lbl"> Eliminar Articulo</span>
                                                         </label>
                                                     </td>
                                                 </tr>
                                             </tbody>
                                       </table>
                                   </div>

                                   <!--IMPORTADORES-->
                                   <div id="tab4" class="tab-pane" style="min-height: 300px">
                                       <table class="table table-bordered">
                                             <tbody>
                                                 <tr>
                                                     <td>
                                                         <label>
                                                             <input name="vImporMaquinas" class="marcar" type="checkbox"  value="1" />
                                                             <span class="lbl"> Visualizar Importador/Maquinas</span>
                                                         </label>
                                                     </td>
                                                     <td>
                                                         <label>
                                                             <input name="vImporArticulos" class="marcar" type="checkbox"  value="1" />
                                                             <span class="lbl"> Visualizar Importador/Articulos</span>
                                                         </label>
                                                     </td>
                                                     <td>
                                                         <label>
                                                             <input name="vImporArticulos_maq" class="marcar" type="checkbox"  value="1" />
                                                             <span class="lbl"> Visualizar Importador/Articulos a máquinas</span>
                                                         </label>
                                                     </td>
                                                     <td>
                                                         <label>
                                                             <input name="vImporMenu" class="marcar" type="checkbox"  value="1" />
                                                             <span class="lbl"> Visualizar Importador/Menu</span>
                                                         </label>
                                                     </td>
                                                 </tr>
                                             </tbody>
                                       </table>
                                   </div>

                                   <!--CONFIGURACION-->
                                   <div id="tab5" class="tab-pane" style="min-height: 300px">
                                       <table class="table table-bordered">
                                             <tbody>
                                                 <tr>
                                                     <td>
                                                         <label>
                                                             <input name="cUsuario" class="marcar" type="checkbox" value="1" />
                                                             <span class="lbl"> Configurar Usuario</span>
                                                         </label>
                                                     </td>
                                                     <td>
                                                         <label>
                                                             <input name="cPermiso" class="marcar" type="checkbox" value="1" />
                                                             <span class="lbl"> Configurar Permiso</span>
                                                         </label>
                                                     </td>
                                                     <td>
                                                         <label>
                                                             <input name="cBackup" class="marcar" type="checkbox" value="1" />
                                                             <span class="lbl"> Backup</span>
                                                         </label>
                                                     </td>
                                                     <td>
                                                         <label>
                                                             <input name="cConsola" class="marcar" type="checkbox" value="1" />
                                                             <span class="lbl"> Acciones</span>
                                                         </label>
                                                     </td>

                                                 </tr>
                                             </tbody>
                                       </table>
                                   </div>

                                   <!--AYUDA-->
                                   <div id="tab6" class="tab-pane" style="min-height: 300px">
                                       <table class="table table-bordered">
                                             <tbody>
                                                 <!--TICKET-->
                                                 <tr>
                                                     <td>
                                                         <label>
                                                             <input name="vTicket" class="marcar" type="checkbox"  value="1" />
                                                             <span class="lbl"> Visualizar Ticket</span>
                                                         </label>
                                                     </td>
                                                     <td>
                                                         <label>
                                                             <input name="cTicket" class="marcar" type="checkbox" value="1" />
                                                             <span class="lbl"> Agregar Ticket</span>
                                                         </label>
                                                     </td>
                                                     <td>
                                                     </td>
                                                     <td>
                                                     </td>
                                                 </tr>
                                             </tbody>
                                       </table>
                                   </div>

                                   <!--GASTRONOMIA-->
                                   <div id="tab7" class="tab-pane" style="min-height: 300px">
                                       <table class="table table-bordered">
                                             <tbody>
                                                 <!--MENU-->
                                                 <tr>
                                                     <td>
                                                         <label>
                                                             <input name="vMenu" class="marcar" type="checkbox"  value="1" />
                                                             <span class="lbl"> Visualizar Menu</span>
                                                         </label>
                                                     </td>
                                                     <td>
                                                         <label>
                                                             <input name="cMenu" class="marcar" type="checkbox" value="1" />
                                                             <span class="lbl"> Crear Menu</span>
                                                         </label>
                                                     </td>
                                                     <td>
                                                         <label>
                                                             <input name="eMenu" class="marcar" type="checkbox" value="1" />
                                                             <span class="lbl"> Editar Menu</span>
                                                         </label>
                                                     </td>
                                                     <td>
                                                         <label>
                                                             <input name="dMenu" class="marcar" type="checkbox" value="1" />
                                                             <span class="lbl"> Eliminar Menu</span>
                                                         </label>
                                                     </td>
                                                 </tr>
                                                 
                                                 <tr>

                                                    <td>
                                                        <label>
                                                            <label>
                                                                <input name="vPedido" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Visualizar Pedido</span>
                                                            </label>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label>
                                                            <input name="cPedido" class="marcar" type="checkbox" value="1" />
                                                            <span class="lbl"> Agregar Pedido</span>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label>
                                                            <input  name="ePedido" class="marcar" type="checkbox" value="1" />
                                                            <span class="lbl"> Editar Pedido</span>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label>
                                                         <input name="vRep_pedido" class="marcar" type="checkbox"  value="1" />
                                                         <span class="lbl"> Ver Reporte de pedidos</span>
                                                     </label>
                                                    </td>

                                                </tr>
                                             </tbody>
                                       </table>
                                   </div>
                                   
                                   <!--SALA REUNIONES-->
                                   <div id="tab8" class="tab-pane" style="min-height: 300px">
                                       <table class="table table-bordered">
                                             <tbody>
                                                 <!--SALA-->
                                                 <tr>
                                                     <td>
                                                         <label>
                                                             <input name="vSala" class="marcar" type="checkbox"  value="1" />
                                                             <span class="lbl"> Visualizar Calendario</span>
                                                         </label>
                                                     </td>
                                                     <td>
                                                         <label>
                                                             <input name="cSala" class="marcar" type="checkbox" value="1" />
                                                             <span class="lbl"> Agregar Evento</span>
                                                         </label>
                                                     </td>
                                                     <td>
                                                         <label>
                                                             <input name="eSala" class="marcar" type="checkbox" value="1" />
                                                             <span class="lbl"> Editar Evento</span>
                                                         </label>
                                                     </td>
                                                     <td>
                                                         <label>
                                                             <input name="dSala" class="marcar" type="checkbox" value="1" />
                                                             <span class="lbl"> Eliminar Evento</span>
                                                         </label>
                                                     </td>
                                                 </tr>
                                             </tbody>
                                       </table>
                                   </div>
                                </div>
                        </div>
                    </div>
                </div>

              
    
            <div class="form-actions">
                <div class="span12">
                    <div class="span6 offset3">
                        <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar</button>
                        <a href="<?php echo base_url() ?>index.php/permisos" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
                    </div>
                </div>
            </div>
           
            </div>
        </div>

                   
    </div>

</form>

</div>


<script type="text/javascript" src="<?php echo base_url()?>assets/js/validate.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

    $("#marcarTodos").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });
       

 
    $("#formPermissao").validate({
        rules :{
            nombre: {required: true}
        },
        messages:{
            nombre: {required: 'Campo obrigatório'}
        }
    });     

        

    });
</script>
