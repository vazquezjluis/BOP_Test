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

<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>

