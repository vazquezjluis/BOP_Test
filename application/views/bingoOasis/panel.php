<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="<?php echo base_url();?>js/dist/excanvas.min.js"></script><![endif]-->

<script language="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/dist/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/dist/jquery.jqplot.min.css" />

<script type="text/javascript" src="<?php echo base_url();?>assets/js/dist/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/dist/plugins/jqplot.donutRenderer.min.js"></script>

<!--Action boxes-->
  <div class="container-fluid">
        <div class="quick-actions_homepage">
            <ul class="quick-actions">
        <?php  if($this->permission->checkPermission($this->session->userdata('permiso'),'cUsuario')){ ?>
            <li class="bg_lb"> <a href="<?php echo base_url()?>index.php/usuarios"> <i class="icon-group"></i> Usuarios</a> </li>
        <?php  } ?>
        <?php  if($this->permission->checkPermission($this->session->userdata('permiso'),'vMaquina')){ ?>
            <li class="bg_lg"> <a href="<?php  echo base_url()?>index.php/maquinas"> <i class="icon-desktop"></i> Maquinas</a> </li>
                <?php } ?>
        <?php  if($this->permission->checkPermission($this->session->userdata('permiso'),'vFallas')){ ?>
            <li class="bg_ly"> <a href="<?php echo base_url()?>index.php/fallas"> <i class="icon-wrench"></i> Fallas</a> </li>
                <?php } ?>
        <?php  if($this->permission->checkPermission($this->session->userdata('permiso'),'vTicket')){ ?>
            <li class="bg_lo"> <a href="<?php  echo base_url()?>index.php/ticket"> <i class="icon-tags"></i> Tickets</a> </li>
                <?php } ?>
                <?php // if($this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){ ?>
            <!--<li class="bg_ls"> <a href="<?php  echo base_url()?>index.php/vendas"><i class="icon-shopping-cart"></i> Vendas</a></li>-->
                <?php // } ?>


            </ul>
        </div>
  </div>  
<!--End-Action boxes-->  

        <div class="row-fluid" style="margin-top: 0">
    
<!--    <div class="span12">
        
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span><h5>Partes con stock minimo</h5></div>
            <div class="widget-content">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Descripcion</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Stock Mínimo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                       <tr><td colspan="3">No hay partes con bajo Stock </td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="span12" style="margin-left: 0">
        
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span><h5>Tickets en seguimiento</h5></div>
            <div class="widget-content">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>solicitud</th>
                            <th>Asunto</th>
                            <th>Emisor</th>
                            <th>Prioridad</th>
                            <th>Asignado</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>63713</td>
                            <td>26/02/2018 22:02:17</td>
                            <td> Se prende fuego la cocina</td>
                            <td> Juan Perez (1)</td>
                            <td><span class="badge badge-important">important</span></td>
                            <td> Rodrigo Fernandez (1)</td>
                            <td>Pendiente</td><td>
                                <a href="<?php echo base_url();?>index.php/ticket/visualizar/63713" style="margin-right: 1%" class="btn tip-top" data-original-title="Detalles"><i class="icon-eye-open"></i></a></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>-->

</div>
<?php  if($this->permission->checkPermission($this->session->userdata('permiso'),'vRep_ticket')){ ?>
<div class="row-fluid" style="margin-top: 0">

            <div class="span12">

                <div class="widget-box">
                    <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span><h5>Estadísticas del Sistema</h5></div>
                    <div class="widget-content">
                        <div class="row-fluid">           
                            <div class="span12">
                                <ul class="site-stats">
                            <li class="bg_lh"><i class="icon-desktop"></i> <strong><?php echo $count_maquinas;?></strong> <small>Maquinas fuera de servicio</small></li>
                            <li class="bg_lh"><i class="icon-wrench"></i> <strong><?php echo $count_laboratorio;?></strong> <small>Laboratorio </small></li>
                            <li class="bg_lh"><i class="icon-tags"></i> <strong><?php echo $count_ticket;?></strong> <small>Tickets Activos</small></li>
                            <li class="bg_lh"><i class="icon-group"></i> <strong><?php echo $this->db->count_all('usuarios');?></strong> <small>Usuarios</small></li>
                            

                                </ul>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php } ?>
<!--<div class="row-fluid" style="margin-top: 0">

            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
                        <h5>Real Time chart</h5>
                    </div>
                    <div class="widget-content">
                        <div id="placeholder2"></div>
                        <p>Time between updates:
                            <input id="updateInterval" type="text" value="" style="text-align: right; width:5em">
                            milliseconds</p>
                    </div>
                </div>
            </div>
        </div>-->
<!--        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
                        <h5>Turning-series chart</h5>
                    </div>
                    <div class="widget-content">
                        <div id="placeholder"></div>
                        <p id="choices"></p>
                    </div>
                </div>
            </div>
        </div>-->
<div class="row-fluid" >
    <div class="span12" style="display: none;">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
                        <h5>Grafico de Puntos</h5>
                    </div>
                    <div class="widget-content">
                        <div class="chart" ></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <?php  if($this->permission->checkPermission($this->session->userdata('permiso'),'vRep_ticket')){ ?>
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
                        <h5>Porcentaje de tickets - mes actual</h5>
                    </div>
                    <div class="widget-content">
                        <div class="pie"></div>
                    </div>
                </div>
            </div>
            <?php }?>
<!--            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
                        <h5>Grafico de barra</h5>
                    </div>
                    <div class="widget-content">
                        <div class="bars"></div>
                    </div>
                </div>
            </div>-->
        </div>
    <!--</div>-->
</div>





<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/jquery.flot.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/jquery.flot.pie.min.js"></script> 
<!--<script src="<?php //echo base_url(); ?>assets/js/matrix.charts.js"></script>--> 
<script src="<?php echo base_url(); ?>assets/js/jquery.flot.resize.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/matrix.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/jquery.peity.min.js"></script> 
<script>
    $(document).ready(function(){
	
	
	// === Prepare the chart data ===/
//	var sin = [], cos = [];
//    for (var i = 0; i < 14; i += 0.5) {
//        sin.push([i, Math.sin(i)]);
//        cos.push([i, Math.cos(i)]);
//    }
//	// === Prepare the chart data ===/
//	var sin = [], cos = [];
//    for (var i = 0; i < 14; i += 0.5) {
//        sin.push([i, Math.sin(i)]);
//        cos.push([i, Math.cos(i)]);
//    }
//
//	// === Make chart === //
//    var plot = $.plot($(".chart"),
//           [ { data: sin, label: "sin(x)", color: "#ee7951"}, { data: cos, label: "cos(x)",color: "#4fb9f0" } ], {
//               series: {
//                   lines: { show: true },
//                   points: { show: true }
//               },
//               grid: { hoverable: true, clickable: true },
//               yaxis: { min: -1.6, max: 1.6 }
//		   });
//    
//	// === Point hover in chart === //
//    var previousPoint = null;
//    $(".chart").bind("plothover", function (event, pos, item) {
//		
//        if (item) {
//            if (previousPoint != item.dataIndex) {
//                previousPoint = item.dataIndex;
//                
//                $('#tooltip').fadeOut(200,function(){
//					$(this).remove();
//				});
//                var x = item.datapoint[0].toFixed(2),
//					y = item.datapoint[1].toFixed(2);
//                    
//                maruti.flot_tooltip(item.pageX, item.pageY,item.series.label + " of " + x + " = " + y);
//            }
//            
//        } else {
//			$('#tooltip').fadeOut(200,function(){
//					$(this).remove();
//				});
//            previousPoint = null;           
//        }   
//    });	
    
	
	
    
    var data = [];
	
    
    var series = 2;
    <?php
    $total = (int)$abierto_cerrado[0]->estado + (int)$abierto_cerrado[1]->estado;
    $p_abierto = ((int)$abierto_cerrado[0]->estado/$total) *100;
    $p_cerrado = ((int)$abierto_cerrado[1]->estado/$total) *100;
        ?>
    data[0] = { label: "Tickets Abiertos", data: <?php echo $p_abierto;?> }
    data[1] = { label: "Tickets Cerrados", data: <?php echo $p_cerrado?> }
    var pie = $.plot($(".pie"), data,{
        series: {
            pie: {
                show: true,
                radius: 3/4,
                label: {
                    show: true,
                    radius: 3/4,
                    formatter: function(label, series){
                        return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">'+label+'<br/>'+Math.round(series.percent)+'%</div>';
                    },
                    background: {
                        opacity: 0.5,
                        color: '#000'
                    }
                },
                innerRadius: 0.2
            },
			legend: {
				show: false
			}
		}
	});	
    var d1 = [];
    for (var i = 0; i <= 10; i += 1) d1.push([i, parseInt(Math.random() * 30)]);

	var data = new Array(); 
	data.push({
		data:d1,
        bars: {
            show: true, 
            barWidth: 0.4, 
            order: 1,
        }
    });    
	
	
    //Display graph
    var bar = $.plot($(".bars"), data, {
		legend: true
	});
	
});
</script>

<script src="<?php echo base_url(); ?>assets/js/matrix.dashboard.js"></script>