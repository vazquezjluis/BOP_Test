<?php $permisos = unserialize($result->permisos);?>
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
                        <table class="table table-bordered">
                            <tbody>
                                
                                <!--CONFIGURACION-->
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
                                
                                <tr><td colspan="4"></td></tr>
                                
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
                                
                                <tr><td colspan="4"></td></tr>
                                
                                <!--CATEGORIAS (ARTICULOS)-->
                                <tr>

                                    <td>
                                        <label>
                                            <label>
                                                <input <?php if(isset($permisos['vCategorias'])){ if($permisos['vCategorias'] == '1'){echo 'checked';}}?> name="vCategorias" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Categorias</span>
                                            </label>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input <?php if(isset($permisos['cCategorias'])){ if($permisos['cCategorias'] == '1'){echo 'checked';}}?> name="cCategorias" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Agregar Categorias</span>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input <?php if(isset($permisos['eCategorias'])){ if($permisos['eCategorias'] == '1'){echo 'checked';}}?> name="eCategorias" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Editar Categorias</span>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input <?php if(isset($permisos['dCategorias'])){ if($permisos['dCategorias'] == '1'){echo 'checked';}}?> name="dCategorias" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Eliminar Categorias</span>
                                        </label>
                                    </td>
                                 
                                </tr>
                                
                                <tr><td colspan="4"></td></tr>
                                
                                <!--TICKET-->
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
                                
                                <tr><td colspan="4"></td></tr>
                                
                                <!--MANUALES-->
                                <tr>

                                    <td colspan="4">
                                        <label>
                                            <input <?php if(isset($permisos['vManuales'])){ if($permisos['vManuales'] == '1'){echo 'checked';}}?> name="vManuales" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Visualizar Manuales</span>
                                        </label>
                                    </td>
 
                                </tr>
                                
                                <tr><td colspan="4"></td></tr>
                                
                                <!--IMPORTADOR-->
                                <tr><td colspan="4"><b>Importadores</b></td></tr>
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
                                            <input <?php if(isset($permisos['vImporPersona'])){ if($permisos['vImporPersona'] == '1'){echo 'checked';}}?> name="vImporPersona" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Visualizar Importador/Persona</span>
                                        </label>
                                    </td>
 
                                </tr>
                                
                                
                                <!--RRHH-->
                                <tr><td colspan="4"><b>Recursos Humanos</b></td></tr>
                                <tr>

                                    <td>
                                        <label>
                                            <input <?php if(isset($permisos['vPersonas'])){ if($permisos['vPersonas'] == '1'){echo 'checked';}}?> name="vPersonas" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Visualizar Personas</span>
                                        </label>
                                    </td>
                                    
                                    <td>
                                        <label>
                                            <input <?php if(isset($permisos['vLicencias'])){ if($permisos['vLicencias'] == '1'){echo 'checked';}}?> name="vLicencias" class="marcar" type="checkbox" value="1" />
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
                                
                                <!--REPORTES-->
                                <tr>

                                    <td colspan="4">
                                        <label>
                                            <input <?php if(isset($permisos['vRep_maquinas'])){ if($permisos['vRep_maquinas'] == '1'){echo 'checked';}}?> name="vRep_maquinas" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Ver Reporte de Maquinas</span>
                                        </label>
                                    </td>
 
                                </tr>

                            </tbody>
                        </table>
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
