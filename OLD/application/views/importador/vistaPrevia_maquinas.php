<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-hdd"></i>
                </span>
                <h5>Errores</h5>
            </div>
            <div class="widget-content nopadding">
                
                <?php
                if ($html!=''){
                    echo '
                      <form action="'.base_url().'index.php/Importador/modificacion_previa" id="frmDatsExcel"  method="post" class="form-horizontal" >
                        <input type="hidden" name="tipo" value="maquinas">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td class="alert alert-danger" colspan="2">
                                    <strong>Errores:</strong> las filas que contengan campos de error no podran ser procesadas.Puede editarlos ahora.
                                    </td>
                                </tr>    
                            </thead>
                            <tbody>'.$html.'</tbody>
                        </table>
                        <div class="form-actions">
                            <div class="span12">
                                <div class="span6 offset3">
                                <a href="'.base_url().'index.php/Importador/cancel_import" id="" class="btn btn-danger"><i class="icon-remove-sign"></i> Cancelar importacion</a>
                                    <button type="submit" class="btn btn-success"><i class="icon-arrow-right"></i> Continuar</button>
                                </div>
                            </div>
                        </div>
                      </form>';
                }else{
                    echo '
                    <div class="alert alert-info">
                        No se encontraron errores criticos. Puedes ir al siguiente paso para continuar.
                        <div class="span12">
                                <div class="span6 offset3">
                                <a href="'.base_url().'index.php/Importador/cancel_import" id="" class="btn btn-danger"><i class="icon-remove-sign"></i> Cancelar importacion</a>
                                    <button type="submit" class="btn btn-success"><i class="icon-arrow-right"></i> Continuar</button>
                                </div>
                            </div>
                    </div>';
                }
                ?>
                
<!--                <form action="<?php //echo current_url(); ?>" id="frmDatsExcel"  method="post" class="form-horizontal" >
                    
                    <div class="control-group">
                        
                    </div>

                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Analizar</button>
                            </div>
                        </div>
                    </div>
                    
                </form>-->
            </div>
        </div>
    </div>
</div>
