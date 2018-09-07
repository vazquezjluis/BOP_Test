<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-hdd"></i>
                </span>
                <h5>Importacion de maquinas</h5>
            </div>
            <div class="widget-content nopadding">
                
                <?php
                if (isset($html) and $html!=''){
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
                }
                else{
                    if (count($result)){
                        if ($result['distintos'] == 0 and $result['nuevos']==0 and $result['bajas']==0){
                            echo "<div class='alert alert-warning'>
                                <h5>Total de filas evaluadas ".$result['total'].' de los cuales '.$result['identicos']." son identicos</h5>
                                No existen registro distintos, nuevos o de baja a los que figuran en nuestra base de datos
                            </div>";
                        }
                        else{
                            echo "<h5 style='margin-left:5%;'> Registros que se modificarán: ".$result['distintos']." </h5>";
                            echo "<h5 style='margin-left:5%;'> Registros nuevos: ".$result['nuevos']." </h5>";
                            echo "<h5 style='margin-left:5%;'> Registros que pasaran a 'fuera de servicio' : ".$result['bajas']." </h5>";
                            
                            //modificaciones
                            echo '<div style="width:90%;margin-left:5%;" class="accordion-group widget-box">
                                    <div class="accordion-heading">
                                        <div class="widget-title">
                                            <a data-parent="#collapse-group" href="#modificaciones" data-toggle="collapse">
                                                <span class="icon"><i class="icon-list"></i></span><h5>Ver modificaciones</h5>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="collapse  accordion-body" id="modificaciones">
                                        <div class="widget-content span12">
                                        '.$result['str_ditintos'].'
                                        </div>
                                    </div>
                                </div>';
                            //nuevos
                            if (isset($_SESSION['new_import']) and count($_SESSION['new_import'])){
                            echo '<div style="width:90%;margin-left:5%;" class="accordion-group widget-box">
                                    <div class="accordion-heading">
                                        <div class="widget-title">
                                            <a data-parent="#collapse-group" href="#nuevos" data-toggle="collapse">
                                                <span class="icon"><i class="icon-list"></i></span><h5>Ver nuevos</h5>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="collapse  accordion-body" id="nuevos">
                                        <div class="widget-content span12">';
                            echo '          <table class="table">
                                                <tr>
                                                    <td><b>UID</b></td>
                                                    <td><b>Fabricante</b></td>
                                                    <td><b>Modelo</b></td>
                                                    <td><b>% de Pago</b></td>
                                                    <td><b>Denom</b></td>
                                                    <td><b>Juego</b></td>
                                                    <td><b>Nro. Serie</b></td>
                                                    <td><b>Programa</b></td>
                                                    <td><b>Credito</b></td>
                                                <tr>';
                                            foreach ($_SESSION['new_import'] as $k=>$v){
                            echo'               <tr>
                                                    <td>'.$v['nro_egm'].'</td>
                                                    <td>'.$v['fabricante'].'</td>
                                                    <td>'.$v['modelo'].'</td>
                                                    <td>'.$v['p_pago'].'</td>
                                                    <td>'.$v['denom'].'</td>
                                                    <td>'.$v['juego'].'</td>
                                                    <td>'.$v['nro_serie'].'</td>
                                                    <td>'.$v['programa'].'</td>
                                                    <td>'.$v['credito'].'</td>
                                                <tr>';
                                            }
                            echo '          </table>    
                                        </div>
                                    </div>
                                </div>';
                            }
                            //bajas
                            if (isset($_SESSION['delete_import']) and count($_SESSION['delete_import'])){
                            echo '<div style="width:90%;margin-left:5%;" class="accordion-group widget-box">
                                    <div class="accordion-heading">
                                        <div class="widget-title">
                                            <a data-parent="#collapse-group" href="#bajas" data-toggle="collapse">
                                                <span class="icon"><i class="icon-list"></i></span><h5>Ver Bajas</h5>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="collapse  accordion-body" id="bajas">
                                        <div class="widget-content span12">';
                            echo        ' <table class="table">
                                            <tr>
                                                <td><b>UID</b></td>
                                            <tr>';
                            foreach ($_SESSION['delete_import'] as $baja){
                                echo '      <tr>
                                                <td>'.$baja.'</td>
                                            <tr>';
                            }    
                            echo'         </table>  
                                        </div>
                                    </div>
                                </div>';
                            }
                        } 
                        echo'<div style="text-aligne:left;margin:0% 0% 5% 5%;">';
                        echo '  <a href="'.base_url().'index.php/Importador/cancel_import" id="" class="btn btn-danger"><i class="icon-remove-sign"></i> Cancelar importacion</a>';
                        if ($result['distintos'] == 0 and $result['nuevos']==0 and $result['bajas']==0){

                        }else{
                            echo '<a href="#modal-importar" id="" class="btn btn-success" role="button" data-toggle="modal"><i class="icon-arrow-right"></i> Importar</a></div>';
                        }
                        echo '</div>';
                    }else{
                        echo "<div class='alert alert-danger'>Ocurrio un error al intentar importar el archivo</div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="modal-importar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/Importador/importar" method="post" >
        <input type="hidden" name="tipo" value="maquinas">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h5 id="myModalLabel">Ultimo paso!</h5>
        </div>
        <div class="modal-body">
          <input type="hidden" id="idMaquina" name="id" value="" />
          <p><strong> Si usted hace click en importar, los registros de las máquinas seran modificados y no podran ser recuperados. </strong></p>
          <h5 style="text-align: center">Realmente desea importar estos registros?</h5>

        </div>
        <div class="modal-footer">
          <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
          <button class="btn btn-danger">Importar</button>
        </div>
  </form>
</div>