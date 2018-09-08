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

                        <table class="table table-bordered">
                            <tbody>
                                <!--CONFIGURACION-->
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
                                
                                <tr><td colspan="4"></td></tr>
                                
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
                                                                
                                
                                                                
                                <!--CATEGORIAS (ARTICULOS)-->
                                <tr>

                                    <td>
                                        <label>
                                            <input name="vCategorias" class="marcar" type="checkbox"  value="1" />
                                            <span class="lbl"> Visualizar Categorias</span>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input name="cCategorias" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Agregar Categorias</span>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input name="eCategorias" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Editar Categorias</span>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input name="dCategorias" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Eliminar Categorias</span>
                                        </label>
                                    </td>
                                 
                                </tr>
                                <tr><td colspan="4"></td></tr>
                                
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
                                <tr><td colspan="4"></td></tr>
                                
                                <!--IMPORTADOR-->
                                <tr><td colspan="4"><b>Importadores</b></td></tr>
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
                                            <input name="vImporPersona" class="marcar" type="checkbox"  value="1" />
                                            <span class="lbl"> Visualizar Importador/Persona</span>
                                        </label>
                                    </td>
                                 
                                </tr>
                                <tr><td colspan="4"></td></tr>
                                
                                <!--RRHH-->
                                <tr><td colspan="4"><b>Recusos Humanos</b></td></tr>
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
                                <tr><td colspan="4"></td></tr>
                                
                                <!--MANUALES-->
                                <tr>

                                    <td colspan="4">
                                        <label>
                                            <input name="vManuales" class="marcar" type="checkbox"  value="1" />
                                            <span class="lbl"> Visualizar Manuales</span>
                                        </label>
                                    </td>
                                 
                                </tr>
                                <tr><td colspan="4"></td></tr>
                                
                                <!--REPORTES-->
                                <tr>
                                    <td colspan="4">
                                        <label>
                                            <input name="vRep_maquinas" class="marcar" type="checkbox"  value="1" />
                                            <span class="lbl"> Ver Reporte máquinas</span>
                                        </label>
                                    </td>
                                </tr>
                                <tr><td colspan="4"></td></tr>
                            </tbody>
                        </table>
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
