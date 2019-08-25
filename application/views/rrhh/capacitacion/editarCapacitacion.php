<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>

<link rel="stylesheet" href="<?php  echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<link rel="stylesheet" href="<?php  echo base_url();?>assets/css/jquery.multiselect.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.multiselect.js"></script>
<?php


?>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Editar Capacitacion</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formCapacitacion" method="post"  >
                    
                    <?php echo form_hidden('idCapacitacion',$result->idCapacitacion) ?>
                     <!--Tema , capacitador, institucion-->
                     <div class="span12" style="padding: 1%">
                        <div class="span3 control-group">
                            <label for="tema" >Tema<span class="required">*</span></label>
                            <select id="tema" name="tema" required="required" >
                                <option value="">Seleccione</option>
                                <?php
                                if (isset($tema)){
                                    foreach ($tema as $t){
                                        echo "<option value='".$t->idTema."'";
                                        if ($result->tema==$t->idTema){
                                            echo " selected ";
                                        }
                                        echo ">".$t->nombre."</option>";
                                    }
                                }
                                ?>                                
                            </select>
                            <a href="<?php echo base_url()?>index.php/tema/agregar/<?php echo $result->idCapacitacion;?>" class="btn btn-default btn-mini"><i class="icon-plus icon-white"></i> Agregar nueva Tema</a>
                        </div>
                        
                        <div class="span2 control-group">
                            <label for="modalidad" class="control-label">Modalidad<span class="required">*</span></label>
                            <label ><input style="margin-left: 10px;margin-top: 0px;" <?php if ($result->modalidad == "taller" ){ echo 'checked="true"';} ?> type="radio"  name="modalidad" value="taller"> Taller</label>
                            <label ><input style="margin-left: 10px;margin-top: 0px;" <?php if ($result->modalidad == "seminario" ){ echo 'checked="true"';} ?> type="radio"  name="modalidad" value="seminario"> Seminario</label>
                            <label ><input style="margin-left: 10px;margin-top: 0px;" <?php if ($result->modalidad == "curso" ){ echo 'checked="true"';} ?> type="radio"  name="modalidad" value="curso" > Curso</label>
                        </div>
                        <div class="span2 control-group">
                            <label for="evaluacion" class="control-label">Evaluacion<span class="required">*</span></label>
                            <label ><input style="margin-left: 10px;margin-top: 0px;" <?php if ($result->evaluacion== "no" ){ echo 'checked="true"';}  ?> type="radio"  name="evaluacion" value="no"> No</label>
                            <label ><input style="margin-left: 10px;margin-top: 0px;" <?php if ($result->evaluacion== "si" ){ echo 'checked="true"';}  ?>  type="radio"  name="evaluacion"  value="si"> Si</label>
                        </div>
                        <div class="span2 control-group">
                            <label for="tipo" class="control-label">Tipo<span class="required">*</span></label>
                            <label ><input style="margin-left: 10px;margin-top: 0px;" <?php if ($result->tipo== "interno" ){ echo 'checked="true"';}  ?> type="radio"  name="tipo" value="interno"> Interno</label>
                            <label ><input style="margin-left: 10px;margin-top: 0px;" <?php if ($result->tipo == "externo" ){ echo 'checked="true"';}  ?> type="radio"  name="tipo" value="externo" > Externo</label>
                        </div>
                        <div class="span2 control-group">
                            <label for="obligatorio" class="control-label">Obligatorio<span class="required">*</span></label>
                            <label ><input style="margin-left: 10px;margin-top: 0px;" <?php if ($result->obligatorio == "si" ){ echo 'checked="true"';}  ?> type="radio"  name="obligatorio" value="si"> Si</label>
                            <label ><input style="margin-left: 10px;margin-top: 0px;" <?php if ($result->obligatorio == "no" ){ echo 'checked="true"';}  ?>type="radio"  name="obligatorio" value="no"> No</label>
                        </div>
                    </div>
                     
                    <div class="span12" style="padding: 1%; margin-left: 0px;">
                        <div class="span6 control-group">
                            <label for="descripcion" class="control-label">Descripcion<span class="required">*</span></label>
                            <textarea id="descripcion" class="span12" rows="5"  type="text" name="descripcion"  ><?php echo $result->descripcion; ?></textarea>
                        </div>
                        <div class="span3 control-group">
                            <label for="institucion" >Institucion<span class="required">*</span></label>                            
                            <select id="institucion" name="institucion" required="required" >
                                <option value="">Seleccione</option>
                                <?php
                                if (isset($institucion)){
                                    foreach ($institucion as $i){
                                        echo "<option value='".$i->idInstitucion."'";
                                        if($i->idInstitucion==$result->institucion){
                                            echo " selected ";
                                        }
                                        echo ">".$i->nombre."</option>";
                                    }
                                }
                                ?>                                
                            </select>
                            <a href="<?php echo base_url()?>index.php/institucion/agregar/<?php echo $result->idCapacitacion;?>" class="btn btn-default btn-mini"><i class="icon-plus icon-white"></i> Agregar nueva institucion</a>
                        </div>
                        <div class="span3 control-group">
                            <label for="sector" >Sector / Sectores <span class="required">*</span></label>                            
                            <select id="sector"  multiple="multiple" name="sector[]" required="required" >
                                
                                <?php
                                if (isset($sector)){
                                    $los_sectores = explode(",",$result->sector);
                                    foreach ($sector as $s){
                                        echo "<option value='".$s->id."' ";
                                        if(in_array($s->id,$los_sectores)){
                                            echo " selected ";                                            
                                        }        
                                        echo ">".$s->descripcion."</option>";
                                    }
                                }
                                ?>                                
                            </select>
                        </div>
                    </div> 
                    
                     <!--inicio, fin, cupo, capacitador-->
                    <div class="span12" style="padding: 1%; margin-left: 0px;">
                        <div class="span3 control-group ">
                            <label for="f_inicio" class="control-label">Fecha Inicio<span class="required">*</span></label>
                            <input id="f_inicio" type="date" name="f_inicio" value="<?php echo $result->f_inicio; ?>"  required="required" />
                        </div>
                        <div class="span3 control-group">
                            <label for="f_fin" class="control-label">Fecha Finalizacion<span class="required">*</span></label>
                            <input id="f_fin" type="date" name="f_fin" value="<?php echo $result->f_fin; ?>"  required="required" />
                        </div>
                        <div class="span1 control-group">
                            <label for="cupo" >Cupo<span class="required">*</span></label>
                            <input id="cupo" type="number" style="width: 80%"  name="cupo"  value="<?php echo $result->cupo; ?>"  required="required" />
                        </div>
                        <div class="span4 control-group">
                            <label for="capacitador" >Capacitador/es<span class="required">*</span></label>
                            <input id="capacitador" type="text" style="width: 80%" placeholder="Nombre y Apellido" value="<?php echo $result->capacitador; ?>" name="capacitador"  />
                            
                        </div>
<!--                        <div class="span1">
                            <label>&nbsp;</label>
                            <button id="agregar_fecha" style="margin-bottom: 10px;" class="btn btn-primary"><b>+</b></button>
                        </div>-->
                    </div>
                                         
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-primary"><i class="icon-plus icon-white"></i> Modificar</button>
                                <a href="<?php echo base_url() ?>index.php/capacitacion" id="" class="btn"><i class="icon-arrow-left"></i> Volver</a>
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

$("#sector").multiselect();

           $('#formUsuario').validate({
            rules : {
                  nombre:{ required: true},
                  email:{ required: true,email:true}
            },
            messages: {
                  nombre :{ required: 'Campo Requerido.'},
                  email:{ required: 'Campo Requerido.',email:'Ingrese un correo electrónico válido.'}

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


