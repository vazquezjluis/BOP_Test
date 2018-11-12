
<!DOCTYPE html>
<html lang="en">
<head>
<title>Bingo Oasis</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="icon" href="<?php echo base_url();?>assets/img/icono.ico" type="image/ico" sizes="16x16">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-style.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-media.css" />
<link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<!--link rel="stylesheet" href="<?php //echo base_url();?>assets/css/fullcalendar.css" /--> 
<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<!--<link href="<?php //   echo base_url();?>assets/css/css.css" rel="stylesheet" type="text/css"/>-->
<!--<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>-->
<script type="text/javascript"  src="<?php echo base_url();?>assets/js/jquery-1.10.2.min.js"></script>

</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="">Bingo Oasis</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
   
    <li class=""><a title="" href="<?php echo site_url();?>/bingoOasis/miCuenta"><i class="icon icon-star"></i> <span class="text">Mi cuenta</span></a></li>
    
    <li class=""><a title="" href="<?php echo site_url();?>/bingoOasis/salir"><i class="icon icon-off"></i> <span class="text">Salir del Sistema</span></a></li>
    
  </ul>

</div>

<!--start-top-serch-->
<div id="search">
    
  <a href="#" ><i class="icon icon-asterisk"></i> <span class="text">Version: <?php echo $this->config->item('app_version'); ?></span></a>
</div>
<!--close-top-serch--> 

<!--sidebar-menu-->

<div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-list"></i> Menu</a>
  <ul>


    <li class="<?php if(isset($menuPainel)){echo 'active';};?>"><a href="<?php echo base_url()?>">
        <i class="icon icon-home"></i> <span>Inicio</span></a></li>
    
    <!--RRHH-->
    <?php if( $this->permission->checkPermission($this->session->userdata('permiso'),'vPersonas') || 
               $this->permission->checkPermission($this->session->userdata('permiso'),'vLicencias') || 
               $this->permission->checkPermission($this->session->userdata('permiso'),'vCapacitacion') || 
               $this->permission->checkPermission($this->session->userdata('permiso'),'vPremios')  
            ){ ?>
        <li class="submenu <?php if(isset($menuConfiguracoes)){echo 'active open';};?>">
          <a href="#"><i class="icon icon-list-alt"></i> <span>Recursos Humanos</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
              <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'vPersonas')){ ?>
                <li><a href="<?php echo base_url()?>index.php/persona">Personas</a></li>
              <?php } ?>
              <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'vLicencia')){ ?>
                <li><a href="<?php echo base_url()?>index.php/licencia">Licencias</a></li>
              <?php } ?>
              <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'vCapacitacion')){ ?>
                <li><a href="<?php echo base_url()?>index.php/capacitacion">Capacitacion</a></li>
              <?php } ?>
              <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'vPremios')){ ?>
                <li><a href="<?php echo base_url()?>index.php/premio">Premios</a></li>
              <?php } ?>
                <!--<li><a href="#">Fallas (en construccion)</a></li>-->
          </ul>
        </li>
    <?php } ?>
    
    
    <!--MAQUINAS-->
    <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'vMaquina')){ ?>
        <li class=" <?php if(isset($menuClientes)){echo 'active open';};?>">
            <a href="<?php echo base_url()?>index.php/maquinas"><i class="icon icon-desktop"></i> <span>Maquinas</span></a>
           
        </li>
    <?php } ?>  
        
    <!--FALLAS-->
    <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'vFallas')){ ?>
        <li class=" <?php if(isset($menuClientes)){echo 'active open';};?>">
            <a href="<?php echo base_url()?>index.php/fallas"><i class="icon icon-warning-sign"></i> <span>Fallas</span></a>
        </li>
    <?php } ?>        
        
    <!--LABORATORIO-->
    <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'vLaboratorio')){ ?>
        <li class=" <?php if(isset($menuClientes)){echo 'active open';};?>">
            <a href="<?php echo base_url()?>index.php/laboratorio"><i class="icon icon icon-wrench "></i> <span>Laboratorio</span></a>
        </li>
    <?php } ?>        
    
    <!--REPORTES-->
    <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'vRep_maquinas')  || 
            $this->permission->checkPermission($this->session->userdata('permiso'),'vReportes') ){ ?>
        <li class="submenu <?php if(isset($menuConfiguracoes)){echo 'active open';};?>">
          <a href="#"><i class="icon icon-list-alt"></i> <span>Reportes</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
              <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'vRep_maquinas')){ ?>
                <li><a href="<?php echo base_url()?>index.php/Reportes/maquinas">Maquinas</a></li>
              <?php } ?>
                <li><a href="#">Fallas (en construccion)</a></li>
          </ul>
        </li>
    <?php } ?>
    
    <!--INVENTARIO-->
    <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'vArticulos')  || 
            $this->permission->checkPermission($this->session->userdata('permiso'),'vCategorias') ){ ?>
        <li class="submenu <?php if(isset($menuConfiguracoes)){echo 'active open';};?>">
          <a href="#"><i class="icon icon-barcode"></i> <span>Inventario</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
                <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'vArticulos')){ ?>
                    <li><a href="<?php  echo base_url()?>index.php/articulo">Articulos </a></li>
                    <!--<li><a href="#">Articulos (en construccion)</a></li>-->
                <?php } 
                   if($this->permission->checkPermission($this->session->userdata('permiso'),'vArticulos')){ ?>
                    <li><a href="<?php  echo base_url()?>index.php/articulo/paniol">Pañol</a></li>
                    <!--<li><a href="#">Articulos (en construccion)</a></li>-->
                <?php } 
                if($this->permission->checkPermission($this->session->userdata('permiso'),'vCategorias')){ ?>
                    <li><a href="#">Categorias (en construccion)</a></li>
                <?php  }?>
          </ul>
        </li>
    <?php } ?>
    
    <!--AYUDA-->
    <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'vTicket')  || 
            $this->permission->checkPermission($this->session->userdata('permiso'),'vManuales') ){ ?>
        <li class="submenu <?php if(isset($menuConfiguracoes)){echo 'active open';};?>">
          <a href="#"><i class="icon icon-flag"></i> <span>Ayuda</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
            <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'vTicket')){ ?>
                <li><a href="<?php echo base_url()?>index.php/ticket">Ticket</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'vManuales')){ ?>
                <li><a href="#">Manuales (en construccion)</a></li>
            <?php } ?>
 
          </ul>
        </li>
    <?php } ?>
        
    <!--IMPORTADOR-->
    <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'vImporMaquinas')  || 
            $this->permission->checkPermission($this->session->userdata('permiso'),'vImpor') ){ ?>
        <li class="submenu <?php if(isset($menuConfiguracoes)){echo 'active open';};?>">
          <a href="#"><i class="icon-upload"></i> <span>Importador</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
            <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'vImporMaquinas')){ ?>
                <li><a href="<?php echo base_url()?>index.php/importador/maquinas">Maquinas</a></li>
            <?php } ?>
 
            <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'vImporArticulos')){ ?>
                <li><a href="<?php echo base_url()?>index.php/importador/articulos">Articulos</a></li>
            <?php } ?>
 
            <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'vImporArticulos_maq')){ ?>
                <li><a href="<?php echo base_url()?>index.php/importador/articulos_maquinas">Articulos a máquinas</a></li>
            <?php } ?>
 
            <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'vImporPersona')){ ?>
                <li><a href="<?php echo base_url()?>index.php/importador/persona">Persona</a></li>
            <?php } ?>
 
          </ul>
        </li>
    <?php } ?>
    
    <!--CONFIGURACION-->
    <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'cUsuario')  || $this->permission->checkPermission($this->session->userdata('permiso'),'cPermiso') || $this->permission->checkPermission($this->session->userdata('permiso'),'cBackup')){ ?>
        <li class="submenu <?php if(isset($menuConfiguracoes)){echo 'active open';};?>">
          <a href="#"><i class="icon icon-cog"></i> <span>Configuración</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
            <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'cUsuario')){ ?>
                <li><a href="<?php echo base_url()?>index.php/usuarios">Usuarios</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'cPermiso')){ ?>
                <li><a href="<?php echo base_url()?>index.php/permisos">Permisos</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'cConsola')){ ?>
                <li><a href="<?php echo base_url()?>index.php/consola">Acciones</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'cBackup')){ ?>
                <li><a href="<?php echo base_url()?>index.php/bingoOasis/backup">Backup</a></li>
            <?php } ?>
 
          </ul>
        </li>
    <?php } ?>
    
    
  </ul>
</div>
<div id="content">
  <div id="content-header">
        <div id="breadcrumb" > 
            <a href="<?php echo base_url()?>" title="Inicio" class="tip-bottom"><i class="icon-home"></i> Inicio</a> 
                    <?php if($this->uri->segment(1) != null){?>
            <a href="<?php echo base_url().'index.php/'.$this->uri->segment(1)?>" class="tip-bottom" title="<?php echo ucfirst($this->uri->segment(1));?>"><?php echo ucfirst($this->uri->segment(1));?></a> 
                    <?php if($this->uri->segment(2) != null){?>
            <a href="<?php echo base_url().'index.php/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3) ?>" class="current tip-bottom" title="<?php echo ucfirst($this->uri->segment(2)); ?>"><?php echo ucfirst($this->uri->segment(2));} ?></a> 
                    <?php }?>
            
        </div>
      
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
          <?php if($this->session->flashdata('error') != null){?>
                            <div class="alert alert-danger">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <?php echo $this->session->flashdata('error');?>
                           </div>
                      <?php }?>

                      <?php if($this->session->flashdata('success') != null){?>
                            <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <?php echo $this->session->flashdata('success');?>
                           </div>
                      <?php }?>
                          
                      <?php if(isset($view)){echo $this->load->view($view, null, true);}?>

      </div>
    </div>
  </div>
</div>
<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12"> <a href="https://www.shsolinteg.com" target="_blank"><?php echo date('Y'); ?> &copy; Bingo Oasis - Shsolinteg </a></div>
</div>
<!--end-Footer-part-->


<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/matrix.js"></script> 


</body>
</html>







