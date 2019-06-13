
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
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/fav.png">
        <style>
            .pendiente {
                color:#FFFFFF;
                width: 100%;
                font-weight: bold;
                background-color: #802420;
                border: 1px solid red;
                border-radius: 5px;
                font-size: 15px;
                padding-bottom:  20px;
                padding-top:  10px;
                padding-right :  10px;
                margin-bottom: 1%;
                margin-top: 1%;
            }
            .listo{
                color:#FFFFFF;
                background-color: #006600;
                width: 100%;
                font-weight: bold;
                border: 1px solid green;
                border-radius: 5px;
                font-size: 15px;
                padding-bottom:  20px;
                padding-top:  10px;
                padding-right :  10px;
                margin-bottom: 1%;
                margin-top: 1%;
            }
        </style>
    </head>
    <body style="background-color: #000000; color:#FFFFFF; margin: auto;text-align: center;">
        <?php if(isset($view)){echo $this->load->view($view, null, true);}?>
         
    </body>

</html>













