<?php $permisos = unserialize($result->permisos);

?>
<div class="span12" style="margin-left: 0">
    <form action="<?php echo base_url();?>index.php/permisos/editar" id="formPermiso" method="post">

    <div class="span12" style="margin-left: 0">
        
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-lock"></i>
                </span>
                <h5>Editar Permiso</h5>
            </div>
            <div class="widget-content">
                
                <div class="span4">
                    <label>Nombre del permiso</label>
                    <input name="nombre" type="text" id="nombre" class="span12" value="<?php echo $result->nombre; ?>" />
                    <input type="hidden" name="idPermiso" value="<?php echo $result->idPermiso; ?>">

                </div>

                <div class="span3">
                    <label>Estado</label>
                    
                    <select name="estado" id="estado" class="span12">
                        <?php if($result->estado == 1){$si = 'selected'; $no ='';}else{$si = ''; $no ='selected';}?>
                        <option value="1" <?php echo $si;?>>Activo</option>
                        <option value="0" <?php echo $no;?>>Inactivo</option>
                    </select>

                </div>
                <div class="span4">
                    <br/>
                    <label>
                        <input name="" type="checkbox" value="1" id="marcarTodos" />
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
                                                <label>
                                                    <input <?php if(isset($permisos['vMaquina'])){ if($permisos['vMaquina'] == '1'){echo 'checked';}}?> name="vMaquina" class="marcar" type="checkbox" value="1" />
                                                    <span class="lbl"> Visualizar Maquina</span>
                                                </label>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if(isset($permisos['cMaquina'])){ if($permisos['cMaquina'] == '1'){echo 'checked';}}?> name="cMaquina" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Agregar Maquina</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if(isset($permisos['eMaquina'])){ if($permisos['eMaquina'] == '1'){echo 'checked';}}?> name="eMaquina" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Maquina</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if(isset($permisos['dMaquina'])){ if($permisos['dMaquina'] == '1'){echo 'checked';}}?> name="dMaquina" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Eliminar Maquina</span>
                                            </label>
                                        </td>

                                    </tr>
                                
                                            <tr><td colspan="4"></td></tr>
                                
                                            <!--FALLAS-->
                                            <tr>

                                    <td>
                                        <label>
                                            <label>
                                                <input <?php if(isset($permisos['vFallas'])){ if($permisos['vFallas'] == '1'){echo 'checked';}}?> name="vFallas" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Fallas</span>
                                            </label>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input <?php if(isset($permisos['cFallas'])){ if($permisos['cFallas'] == '1'){echo 'checked';}}?> name="cFallas" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Agregar Fallas</span>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input <?php if(isset($permisos['eFallas'])){ if($permisos['eFallas'] == '1'){echo 'checked';}}?> name="eFallas" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Editar Fallas</span>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input <?php if(isset($permisos['dFallas'])){ if($permisos['dFallas'] == '1'){echo 'checked';}}?> name="dFallas" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Eliminar Fallas</span>
                                        </label>
                                    </td>
                                 
                                </tr>
                                
                                            <tr><td colspan="4"></td></tr>
                                
                                            <!--LABORATORIO-->
                                            <tr>

                                    <td colspan="4">
                                        <label>
                                            <label>
                                                <input <?php if(isset($permisos['vLaboratorio'])){ if($permisos['vLaboratorio'] == '1'){echo 'checked';}}?> name="vLaboratorio" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Laboratorio</span>
                                            </label>
                                        </label>
                                    </td>
                                 
                                </tr>
                                
                                            <!--REPORTES-->
                                            <tr>

                                                <td>
                                                    <label>
                                                        <input <?php if(isset($permisos['vRep_maquinas'])){ if($permisos['vRep_maquinas'] == '1'){echo 'checked';}}?> name="vRep_maquinas" class="marcar" type="checkbox" value="1" />
                                                        <span class="lbl"> Ver Reporte de Maquinas</span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input <?php if(isset($permisos['vRep_ticket'])){ if($permisos['vRep_ticket'] == '1'){echo 'checked';}}?> name="vRep_ticket" class="marcar" type="checkbox" value="1" />
                                                        <span class="lbl"> Ver Reporte de Tickets</span>
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

                                                <td>
                                                    <label>
                                                        <input <?php if(isset($permisos['vPersonas'])){ if($permisos['vPersonas'] == '1'){echo 'checked';}}?> name="vPersonas" class="marcar" type="checkbox" value="1" />
                                                        <span class="lbl"> Visualizar Personas</span>
                                                    </label>
                                                </td>

                                                <td>
                                                    <label>
                                                        <input <?php if(isset($permisos['vLicencia'])){ if($permisos['vLicencia'] == '1'){echo 'checked';}}?> name="vLicencia" class="marcar" type="checkbox" value="1" />
                                                        <span class="lbl"> Visualizar Licencias</span>
                                                    </label>
                                                </td>

                                                <td>
                                                    <label>
                                                        <input <?php if(isset($permisos['vCapacitacion'])){ if($permisos['vCapacitacion'] == '1'){echo 'checked';}}?> name="vCapacitacion" class="marcar" type="checkbox" value="1" />
                                                        <span class="lbl"> Visualizar Capacitacion</span>
                                                    </label>
                                                </td>

                                                <td>
                                                    <label>
                                                        <input <?php if(isset($permisos['vPremios'])){ if($permisos['vPremios'] == '1'){echo 'checked';}}?> name="vPremios" class="marcar" type="checkbox" value="1" />
                                                        <span class="lbl"> Visualizar Premios</span>
                                                    </label>
                                                </td>

                                            </tr>
                                            <tr>

                                                <td>
                                                    <label>
                                                        <input <?php if(isset($permisos['vDesempeno'])){ if($permisos['vDesempeno'] == '1'){echo 'checked';}}?> name="vDesempeno" class="marcar" type="checkbox" value="1" />
                                                        <span class="lbl"> Visualizar Desempeño</span>
                                                    </label>
                                                </td>

                                                <td>
                                                    <label>
                                                        <input <?php if(isset($permisos['cDesempeno'])){ if($permisos['cDesempeno'] == '1'){echo 'checked';}}?> name="cDesempeno" class="marcar" type="checkbox" value="1" />
                                                        <span class="lbl"> Agregar Desempeño</span>
                                                    </label>
                                                </td>

                                                <td>
                                                    <label>
                                                        <input <?php if(isset($permisos['eDesempeno'])){ if($permisos['eDesempeno'] == '1'){echo 'checked';}}?> name="eDesempeno" class="marcar" type="checkbox" value="1" />
                                                        <span class="lbl"> Editar Desempeño</span>
                                                    </label>
                                                </td>

                                                <td>
                                                    <label>
                                                        <input <?php if(isset($permisos['dDesempeno'])){ if($permisos['dDesempeno'] == '1'){echo 'checked';}}?> name="dDesempeno" class="marcar" type="checkbox" value="1" />
                                                        <span class="lbl"> Eliminar Desempeño</span>
                                                    </label>
                                                </td>

                                            </tr>
                                            <tr>

                                                <td>
                                                    <label>
                                                        <input <?php if(isset($permisos['vTitulo'])){ if($permisos['vTitulo'] == '1'){echo 'checked';}}?> name="vTitulo" class="marcar" type="checkbox" value="1" />
                                                        <span class="lbl"> Visualizar Titulos</span>
                                                    </label>
                                                </td>

                                                <td>
                                                    <label>
                                                        <input <?php if(isset($permisos['cTitulo'])){ if($permisos['cTitulo'] == '1'){echo 'checked';}}?> name="cTitulo" class="marcar" type="checkbox" value="1" />
                                                        <span class="lbl"> Agregar Titulo</span>
                                                    </label>
                                                </td>

                                                <td>
                                                    <label>
                                                        <input <?php if(isset($permisos['eTitulo'])){ if($permisos['eTitulo'] == '1'){echo 'checked';}}?> name="eTitulo" class="marcar" type="checkbox" value="1" />
                                                        <span class="lbl"> Editar Titulo</span>
                                                    </label>
                                                </td>

                                                <td>
                                                    <label>
                                                        <input <?php if(isset($permisos['dTitulo'])){ if($permisos['dTitulo'] == '1'){echo 'checked';}}?> name="dTitulo" class="marcar" type="checkbox" value="1" />
                                                        <span class="lbl"> Eliminar Titulo</span>
                                                    </label>
                                                </td>

                                            </tr>
                                            <tr>

                                                <td>
                                                    <label>
                                                        <input <?php if(isset($permisos['vEstudio'])){ if($permisos['vEstudio'] == '1'){echo 'checked';}}?> name="vEstudio" class="marcar" type="checkbox" value="1" />
                                                        <span class="lbl"> Visualizar Estudios</span>
                                                    </label>
                                                </td>

                                                <td>
                                                    <label>
                                                        <input <?php if(isset($permisos['cEstudio'])){ if($permisos['cEstudio'] == '1'){echo 'checked';}}?> name="cEstudio" class="marcar" type="checkbox" value="1" />
                                                        <span class="lbl"> Agregar Estudio</span>
                                                    </label>
                                                </td>

                                                <td>
                                                    <label>
                                                        <input <?php if(isset($permisos['eEstudio'])){ if($permisos['eEstudio'] == '1'){echo 'checked';}}?> name="eEstudio" class="marcar" type="checkbox" value="1" />
                                                        <span class="lbl"> Editar Estudio</span>
                                                    </label>
                                                </td>

                                                <td>
                                                    <label>
                                                        <input <?php if(isset($permisos['dEstudio'])){ if($permisos['dEstudio'] == '1'){echo 'checked';}}?> name="dEstudio" class="marcar" type="checkbox" value="1" />
                                                        <span class="lbl"> Eliminar Estudio</span>
                                                    </label>
                                                </td>

                                            </tr>
                                            <tr>

                                                <td>
                                                    <label title="Recibe avisos de licencias, o periosods de prueba del empleado.">
                                                        <input <?php if(isset($permisos['vAvisoTicket'])){ if($permisos['vAvisoTicket'] == '1'){echo 'checked';}}?> name="vAvisoTicket" class="marcar" type="checkbox" value="1" />
                                                        <span class="lbl"> Notificar avisos con tickets.</span>
                                                    </label>
                                                </td>

                                                <td>
                                                    
                                                </td>

                                                <td>
                                                    
                                                </td>

                                                <td>
                                                    
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
                                                    <label><input <?php if(isset($permisos[str_replace(" ","",str_replace(".","",$sector->descripcion))])){ if($permisos[str_replace(" ","",str_replace(".","",$sector->descripcion))] == '1'){echo 'checked';}}?> name="<?php echo str_replace(" ","",str_replace(".","",$sector->descripcion));?>" class="marcar_sector" type="checkbox" value="1" /><?php echo $sector->descripcion;?></label></td>
                                                
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
                                                            <label>
                                                                <input <?php if(isset($permisos['vArticulos'])){ if($permisos['vArticulos'] == '1'){echo 'checked';}}?> name="vArticulos" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Visualizar Articulos</span>
                                                            </label>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label>
                                                            <input <?php if(isset($permisos['cArticulos'])){ if($permisos['cArticulos'] == '1'){echo 'checked';}}?> name="cArticulos" class="marcar" type="checkbox" value="1" />
                                                            <span class="lbl"> Agregar Articulos</span>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label>
                                                            <input <?php if(isset($permisos['eArticulos'])){ if($permisos['eArticulos'] == '1'){echo 'checked';}}?> name="eArticulos" class="marcar" type="checkbox" value="1" />
                                                            <span class="lbl"> Editar Articulos</span>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label>
                                                            <input <?php if(isset($permisos['dArticulos'])){ if($permisos['dArticulos'] == '1'){echo 'checked';}}?> name="dArticulos" class="marcar" type="checkbox" value="1" />
                                                            <span class="lbl"> Eliminar Articulos</span>
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
                                                            <input <?php if(isset($permisos['vImporMaquinas'])){ if($permisos['vImporMaquinas'] == '1'){echo 'checked';}}?> name="vImporMaquinas" class="marcar" type="checkbox" value="1" />
                                                            <span class="lbl"> Visualizar Importador/Maquinas</span>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label>
                                                            <input <?php if(isset($permisos['vImporArticulos'])){ if($permisos['vImporArticulos'] == '1'){echo 'checked';}}?> name="vImporArticulos" class="marcar" type="checkbox" value="1" />
                                                            <span class="lbl"> Visualizar Importador/Articulos</span>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label>
                                                            <input <?php if(isset($permisos['vImporArticulos_maq'])){ if($permisos['vImporArticulos'] == '1'){echo 'checked';}}?> name="vImporArticulos_maq" class="marcar" type="checkbox" value="1" />
                                                            <span class="lbl"> Visualizar Importador/Articulos a máquinas</span>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label>
                                                            <input <?php if(isset($permisos['vImporMenu'])){ if($permisos['vImporMenu'] == '1'){echo 'checked';}}?> name="vImporMenu" class="marcar" type="checkbox" value="1" />
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
                                                            <input <?php if(isset($permisos['cUsuario'])){ if($permisos['cUsuario'] == '1'){echo 'checked';}}?> name="cUsuario" class="marcar" type="checkbox" value="1" />
                                                            <span class="lbl"> Configurar Usuario</span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label>
                                                            <input <?php if(isset($permisos['cPermiso'])){ if($permisos['cPermiso'] == '1'){echo 'checked';}}?> name="cPermiso" class="marcar" type="checkbox" value="1" />
                                                            <span class="lbl"> Configurar Permiso</span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label>
                                                            <input <?php if(isset($permisos['cBackup'])){ if($permisos['cBackup'] == '1'){echo 'checked';}}?> name="cBackup" class="marcar" type="checkbox" value="1" />
                                                            <span class="lbl"> Backup</span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label>
                                                            <input <?php if(isset($permisos['cConsola'])){ if($permisos['cConsola'] == '1'){echo 'checked';}}?> name="cConsola" class="marcar" type="checkbox" value="1" />
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
                                                <tr>

                                                    <td>
                                                        <label>
                                                            <label>
                                                                <input <?php if(isset($permisos['vTicket'])){ if($permisos['vTicket'] == '1'){echo 'checked';}}?> name="vTicket" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Visualizar Ticket</span>
                                                            </label>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label>
                                                            <input <?php if(isset($permisos['cTicket'])){ if($permisos['cTicket'] == '1'){echo 'checked';}}?> name="cTicket" class="marcar" type="checkbox" value="1" />
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
                                                <tr>

                                                    <td>
                                                        <label>
                                                            <label>
                                                                <input <?php if(isset($permisos['vMenu'])){ if($permisos['vMenu'] == '1'){echo 'checked';}}?> name="vMenu" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Visualizar Menu</span>
                                                            </label>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label>
                                                            <input <?php if(isset($permisos['cMenu'])){ if($permisos['cMenu'] == '1'){echo 'checked';}}?> name="cMenu" class="marcar" type="checkbox" value="1" />
                                                            <span class="lbl"> Agregar Menu</span>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label>
                                                            <input <?php if(isset($permisos['eMenu'])){ if($permisos['cMenu'] == '1'){echo 'checked';}}?> name="eMenu" class="marcar" type="checkbox" value="1" />
                                                            <span class="lbl"> Editar Menu</span>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label>
                                                            <input <?php if(isset($permisos['dMenu'])){ if($permisos['dMenu'] == '1'){echo 'checked';}}?> name="dMenu" class="marcar" type="checkbox" value="1" />
                                                            <span class="lbl"> Eliminar Menu</span>
                                                        </label>
                                                    </td>

                                                </tr>
                                                <tr>

                                                    <td>
                                                        <label>
                                                            <label>
                                                                <input <?php if(isset($permisos['vPedido'])){ if($permisos['vPedido'] == '1'){echo 'checked';}}?> name="vPedido" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Visualizar Pedido (Ver pedidos en el monitor)</span>
                                                            </label>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label>
                                                            <input <?php if(isset($permisos['ePedido'])){ if($permisos['cPedido'] == '1'){echo 'checked';}}?> name="ePedido" class="marcar" type="checkbox" value="1" />
                                                            <span class="lbl"> Editar Pedido (cambiar estados en el monitor)</span>
                                                        </label>
                                                    </td>
                                                    
                                                    <td>
                                                        <label>
                                                            <input <?php if(isset($permisos['cPedido'])){ if($permisos['cPedido'] == '1'){echo 'checked';}}?> name="cPedido" class="marcar" type="checkbox" value="1" />
                                                            <span class="lbl"> Agregar Pedido (Programacion y pedidos)</span>
                                                        </label>
                                                    </td>

                                                    

                                                    <td>
                                                        <label>
                                                        <input <?php if(isset($permisos['vRep_pedido'])){ if($permisos['vRep_pedido'] == '1'){echo 'checked';}}?> name="vRep_pedido" class="marcar" type="checkbox" value="1" />
                                                        <span class="lbl"> Ver Reporte de Pedidos</span>
                                                    </label>
                                                    </td>

                                                </tr>
                                                <tr>

                                                    <td>
                                                        <label>
                                                            <label>
                                                                <input <?php if(isset($permisos['vInicioEmpleado'])){ if($permisos['vInicioEmpleado'] == '1'){
                                                                    echo 'checked';}}?> name="vInicioEmpleado" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Visualizar Inicio del empleado</span>
                                                            </label>
                                                        </label>
                                                    </td>

                                                    <td>
                                                    </td>
                                                    
                                                    <td>
                                                    </td>

                                                    <td>
                                                    </td>

                                                </tr>
                                             </tbody>
                                       </table>
                                   </div>
                                   
                                   <!--SALA REUNIONES-->
                                   <div id="tab8" class="tab-pane" style="min-height: 300px">
                                       <table class="table table-bordered">
                                             <tbody>
                                                <!--CALENDARIO-->
                                                <tr>

                                                    <td>
                                                        <label>
                                                            <label>
                                                                <input <?php if(isset($permisos['vSala'])){ if($permisos['vSala'] == '1'){echo 'checked';}}?> name="vSala" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Visualizar Calendario</span>
                                                            </label>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label>
                                                            <input <?php if(isset($permisos['cSala'])){ if($permisos['cSala'] == '1'){echo 'checked';}}?> name="cSala" class="marcar" type="checkbox" value="1" />
                                                            <span class="lbl"> Agregar Evento</span>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label>
                                                            <input <?php if(isset($permisos['eSala'])){ if($permisos['eSala'] == '1'){echo 'checked';}}?> name="eSala" class="marcar" type="checkbox" value="1" />
                                                            <span class="lbl"> Editar Evento</span>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <label>
                                                            <input <?php if(isset($permisos['dSala'])){ if($permisos['dSala'] == '1'){echo 'checked';}}?> name="dSala" class="marcar" type="checkbox" value="1" />
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
                        <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Modificar</button>
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
    $("#todos_sectores").change(function () {
        $(".marcar_sector").prop('checked', $(this).prop("checked"));
    });   

 
    $("#formPermiso").validate({
        rules :{
            nombre: {required: true}
        },
        messages:{
            nombre: {required: 'Campo obrigatório'}
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
