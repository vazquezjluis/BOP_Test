<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Datos de Usuario</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">'.$custom_error.'</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formUsuario" method="post" class="form-horizontal" >
                    
                    <div class="control-group">
                        <label for="legajo" class="control-label">Legajo<span class="required">*</span></label>
                        <div class="controls">
                            <input id="legajo" type="number" name="legajo" class="solo-numero" value="<?php echo set_value('legajo'); ?>"  />
                            <span id="info" style="color:red"></span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="nombre" class="control-label">Nombre<span class="required">*</span></label>
                        <div class="controls">
                            <input id="nombre" type="text" name="nombre" value="<?php echo set_value('nombre'); ?>"  />
                            
                        </div>
                    </div>



                    <div class="control-group">
                        <label for="usuario" class="control-label">Usuario<span class="required">*</span></label>
                        <div class="controls">
                            <input id="usr" type="text" name="usr" value="<?php echo set_value('usr'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="email" class="control-label">Email<span class="required"></span></label>
                        <div class="controls">
                            <input id="email" type="text" name="email" value="<?php echo set_value('email'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="clave" class="control-label">Clave<span class="required">*</span></label>
                        <div class="controls">
                            <input id="clave" type="password" name="clave" value="<?php echo set_value('clave'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="celular" class="control-label">Celular</label>
                        <div class="controls">
                            <input id="celular" type="text" name="celular" value="<?php echo set_value('celular'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label  class="control-label">Estado*</label>
                        <div class="controls">
                            <select name="estado" id="estado">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label  class="control-label">Permisos<span class="required">*</span></label>
                        <div class="controls">
                            <select name="permisos_id" id="permisos_id">
                                  <?php foreach ($permisos as $p) {
                                      echo '<option value="'.$p->idPermiso.'">'.$p->nombre.'</option>';
                                  } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Agregar</button>
                                <a href="<?php echo base_url() ?>index.php/usuarios" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>


<script  src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
      $(document).ready(function(){
          
          $('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
          });

           $('#formUsuario').validate({
            rules : {
                  nombre:{ required: true},
                  //email:{ required: true,email:true},
                  clave:{ required: true},
            },
            messages: {
                  nombre :{ required: 'Campo Requerido.'},
                  //email:{ required: 'Campo Requerido.',email:'Ingrese un correo electrónico válido'},
                  clave:{ required: 'Campo Requerido.'},
                  
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
           
           $("#legajo").keyup(function(){          
                leer(this.value);          
            });
           
           function leer(valor){
                if (valor.length>2){
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>index.php/persona/get_persona?leg="+valor,
                        dataType: 'json',
                        success: function(data)
                        {

                            if (data[0].nombre =="error"){
                                $("#info").text('El empleado no existe.');
                                $("#nombre").val(" ");
                                $("#email").val(" ");
                            }else{
                                $("#nombre").val(data[0].nombre+" "+data[0].apellido);
                                $("#email").val(data[0].email);
                                $("#usr").val($("#legajo").val());
                                $("#clave").val('');
                                $("#info").text('');
                            }
                        }
                    });
                }
            }

      });
</script>




