
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
    
    <a href="#" ><i class="icon icon-asterisk"></i> <span class="text">Usuario: <?php  echo $this->session->userdata('nombre'); ?></span></a>
</div>
<!--close-top-serch--> 

<!--sidebar-menu-->

<div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-list"></i> Menu</a>
  
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



















