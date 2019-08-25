
<!DOCTYPE html>
<html lang="pt-br">
    
<head>
        <title>Bingo Oasis</title><meta charset="UTF-8" />
        <link rel="icon" href="<?php echo base_url();?>assets/img/icono.ico" type="image/ico" sizes="16x16">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap-responsive.min.css" />
        <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
        <script src="<?php echo base_url()?>assets/js/jquery-1.10.2.min.js"></script>
        <script src="<?php echo base_url()?>assets/js/moment.min.js"></script>
        <!-- Full calendar -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fullcalendar.css">
        <script src="<?php echo base_url()?>assets/js/fullcalendar.min.js"></script>
        <script src="<?php echo base_url()?>assets/js/es.js"></script>
        <script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
        
        
        
        <style>
            .fc th{
                padding: 10px 0px;
                vertical-align: middle;
                background: #F2F2F2;
            }
            .fc-time { display: none;}
            .fc-content { padding: 5px;}
            .fc-unthemed td.fc-today {
                background: #f2f2f2;
            }
            
        </style>
    </head>
    <body style="background-color: #FFFFFF;">
        <?php if(isset($view)){echo $this->load->view($view, null, true);}?>
         
    </body>

</html>













