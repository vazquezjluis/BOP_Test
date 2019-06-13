<div class="span6" style="margin-left: 0">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-th-list"></i>
		</span>
                <h5>Mi Cuenta</h5>
            </div>
            <div class="widget-content">
                <div class="row-fluid">
                    <div class="span12" style="min-height: 260px">
                        <ul class="site-stats">
                            <li class="bg_ls span12"><strong>Nombre: <?php echo $usuario->nombre?></strong></li>
                            <li class="bg_lb span12" style="margin-left: 0"><strong>Celular: <?php echo $usuario->celular?></strong></li>
                            <li class="bg_lg span12" style="margin-left: 0"><strong>Email: <?php echo $usuario->email?></strong></li>
                            <li class="bg_lo span12" style="margin-left: 0"><strong>Nível: <?php echo $usuario->permiso; ?></strong></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>

<div class="span6">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-th-list"></i>
		</span>
                <h5>Modificar mi clave</h5>
            </div>
            <div class="widget-content">
                <div class="row-fluid">
                    <div class="span12" style="min-height: 260px">
                        <form id="formSenha" action="<?php echo base_url();?>index.php/bingoOasis/modificarClave" method="post">
                        
                        <div class="span12" style="margin-left: 0">
                            <label for="">Clave Actual</label>
                            <input type="password" id="oldClave" name="oldClave" class="span12" />
                        </div>
                        <div class="span12" style="margin-left: 0">
                            <label for="">Nueva Clave</label>
                            <input type="password" id="newClave" name="newClave" class="span12" />
                        </div>
                        <div class="span12" style="margin-left: 0">
                            <label for="">Confirmar Clave</label>
                            <input type="password" name="confirmarClave" class="span12" />
                        </div>
                        <div class="span12" style="margin-left: 0; text-align: center">
                            <button class="btn btn-primary">Modificar Clave</button>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>


<script src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $('#formSenha').validate({
            rules :{
                  oldClave: {required: true},  
                  newClave: { required: true},
                  confirmarClave: { equalTo: "#newClave"}
            },
            messages:{
                  oldClave: {required: 'Campo Requerido'},  
                  newClave: { required: 'Campo Requerido.'},
                  confirmarClave: {equalTo: 'Las Claves no coinciden.'}
            },

            errorClass: "help-inline",
            errorElement: "span",
            highlight:function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
           });
    });
</script>