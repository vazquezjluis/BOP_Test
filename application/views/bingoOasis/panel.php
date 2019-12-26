<<<<<<< HEAD
=======
<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="<?php echo base_url();?>js/dist/excanvas.min.js"></script><![endif]-->

>>>>>>> 78135b1e18f6bbb996b5ba058a1d6101a538c44b
<script language="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/dist/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/dist/jquery.jqplot.min.css" />

<script type="text/javascript" src="<?php echo base_url();?>assets/js/dist/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/dist/plugins/jqplot.donutRenderer.min.js"></script>

<?php
  if ($_POST) {
    // var_dump($_POST );
    // exit;
    $resultado = $_POST["porcentaje"];
    if ($resultado === 'tickets') {
      $total = (int)$abierto_cerrado[0]->estado + (int)$abierto_cerrado[1]->estado;
      $p_abierto = ((int)$abierto_cerrado[0]->estado);
      $p_cerrado = ((int)$abierto_cerrado[1]->estado);
      $dataPoints = array(
        array("label"=> "Tickets abiertos", "y"=> $p_abierto),
        array("label"=> "Tickets cerrados", "y"=> $p_cerrado),
      );
    }
    if ($resultado === 'maquinas') {
      $total = (int)$abierto_cerrado[0]->estado + (int)$abierto_cerrado[1]->estado;
      $p_cerrado = ((int)$abierto_cerrado[1]->estado);
      $dataPoints = array(
        array("label"=> "Maquinas funcionando", "y"=> $count_maquinas),
        array("label"=> "Maquinas fuera de servicio", "y"=> $count_maquinas_fuera),
      );
    }
    if ($resultado === 'laboratorio') {
      $resta = $count_articulos - $count_laboratorio;
      $total = (int)$abierto_cerrado[0]->estado + (int)$abierto_cerrado[1]->estado;
      $p_cerrado = ((int)$abierto_cerrado[1]->estado);
      $dataPoints = array(
        array("label"=> "Articulos", "y"=> $resta),
        array("label"=> "Articulos en laboratorio", "y"=> $count_laboratorio),
      );
    }
    if ($resultado === 'usuarios') {
      $resta = $count_articulos - $count_laboratorio;
      $total = (int)$abierto_cerrado[0]->estado + (int)$abierto_cerrado[1]->estado;
      $p_cerrado = ((int)$abierto_cerrado[1]->estado);
      $dataPoints = array(
        array("label"=> "Articulos", "y"=> $resta),
        array("label"=> "Articulos en laboratorio", "y"=> $count_laboratorio),
      );
    }
  }
 ?>

<!---------------------ESTADISTICAS DEL SISTEMA----------------------->
        <div class="row-fluid" style="margin-top: 0">
        </div>
        <?php  if($this->permission->checkPermission($this->session->userdata('permiso'),'vRep_ticket')){ ?>
        <div class="row-fluid" style="margin-top: 0">

                    <div class="span12 d-flex justify-content-center">

                        <div class="widget-box"  style="width: 100%;">
                            <div class="widget-title">
                              <span class="icon"><i class="icon-signal"></i></span><h5>Estadísticas del Sistema</h5>
                            </div>
                            <div class="widget-content">
                                <div class="column-fluid" style="width: 100%;">
                                        <ul class="site-stats">
                                            <!-- Chequear por que no toma las variables de "$count_maquinas, $count_laboratorio  y $count_ticket"-- >
                                            <!-- <li class="bg_lh"><i class="icon-desktop"></i> <strong> echo $count_maquinas;</strong> <small>Maquinas fuera de servicio</small></li> -->
                                            <li class="bg_lh"> <a href="<?php echo base_url()?>index.php/Reportes/maquinas"> <i class="icon-desktop"></i> <strong><?php echo $count_maquinas;?></strong> <small>Maquinas fuera de servicio</small></a></li>
                                            <li class="bg_lh"> <a href="<?php echo base_url()?>index.php/laboratorio"> <i class="icon-wrench"></i> <strong><?php echo $count_laboratorio;?></strong> <small>Laboratorio </small></a></li>
                                            <li class="bg_lh"> <a href="<?php echo base_url()?>index.php/ticket"><i class="icon-tags"></i> <strong><?php echo $count_ticket;?></strong> <small>Tickets Activos</small></a></li>
                                            <li class="bg_lh"> <a href="<?php echo base_url()?>index.php/usuarios"> <i class="icon-group"></i> <strong><?php echo $this->db->count_all('usuarios');?></strong> <small>Usuarios</small></a></li>
                                          </div>
                                        </ul>
                                        <form class="" action="<?php echo base_url()?>index.php" method="POST">
                                          <select class="" name="porcentaje">
                                            <option value="maquinas" name="tickets"> Porcentaje de maquinas </option>
                                            <option value="tickets" name="maquinas"> Porcentaje de tickets </option>
                                            <option value="laboratorio" name="laboratorio"> Porcentaje de laboratorio </option>
                                            <option value="usuarios" name="usuarios"> Porcentaje de usuarios </option>
                                          </select>
                                          <input type="submit" name="ver" value="Ver">
                                        </form>
                                    <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        <?php } ?>
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
  animationEnabled: true,
  exportEnabled: false,
  title:{
    text: "Porcentajes"
  },
  data: [{
    type: "pie",
    showInLegend: "true",
    legendText: "{label}",
    indexLabelFontSize: 16,
    indexLabel: "{label} - #percent%",
    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
}


//Display graph
var bar = $.plot($(".bars"), data, {
legend: true
});

</script>


<!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
