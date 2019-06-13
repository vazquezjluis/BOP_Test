
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>


<div class="span12" style="margin-left: 0px;">
<form method="get" id="formBuscar" action="<?php echo current_url(); ?>">
        <div class="control-group">
            <label  class="control-label">Busca un empleado <span class="required">*</span></label>
            <div class="controls" id="persona_select">
                <div class="input-append span6">
                    <input  placeholder="Escribe aquí el apellido o nombre del empleado" class="input-block-level" id="persona" value="" type="text" required="required">
                    
                </div>
            </div>
            <input name="buscar" id="persona_id" type="hidden" value="0">
        </div>
</form>
</div>
<?php if ( isset($custom_error)) {
    if($custom_error!=''){
        echo '<div class="span12"><div class="alert alert-danger">' . $custom_error . '</div></div>';
    }
    
} ?>
<?php
if (isset($result)){
    
?>
    <div class="widget-box">
       <div class="widget-title">
          <ul class="nav nav-tabs">
             <li class="active"><a data-toggle="tab" href="#tab1">Datos del empleado</a></li>
             <li><a data-toggle="tab" href="#tab2">Licencias</a></li>
             <li><a data-toggle="tab" href="#tab3">Capacitaciones</a></li>
             <li><a data-toggle="tab" href="#tab4">Premios</a></li>
             <li><a data-toggle="tab" href="#tab5">Sanciones</a></li>
             <li><a data-toggle="tab" href="#tab6">Ausencias</a></li>
             
             <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'vDesempeno')){ ?> 
             <li><a data-toggle="tab" href="#tab7">Desempeño</a></li>
             <?php }?>
             <li><a data-toggle="tab" href="#tab8">Uniforme</a></li>
             <li><a data-toggle="tab" href="#tab9">Estudios</a></li>
          </ul>
       </div>
       <div class="widget-content tab-content">
          <!--DATOS DEL EMPLEADO--> 
          <div id="tab1" class="tab-pane active" style="min-height: 300px">
              <div class="span12 nopadding">
                  <!--IMAGEN DEL EMPLEADO-->
                  <div class="span3" > 
                    
                    <img style="border-radius:10px 10px 0px 0px;" src="<?php echo base_url(); ?>index.php/persona/imagen?id=<?php echo $result[0]->id;?>" class="span12" style="max-height: 200px;"  id="imgSalida"><br>
                   <?php 
                   
                   if ($result[0]->eliminado != null){
                       $fecha_egreso = date_create($result[0]->eliminado);
                       echo "<div style='border-radius:0px 0px 10px 10px;margin-left:0px;text-align:center;background-color:#d9534f;' class='span12 label label-warning'> Baja  ".date_format($fecha_egreso, 'd/m/y')."</div>" ;
                   }else{
                       echo "<div style='border-radius:0px 0px 10px 10px;margin-left:0px;text-align:center;' class='span12 label label-success'>Activo</div>";
                   }
                   ?>
                </div>
                  
                <!--DATOS DEL EMPLEADO-->
                <div class="span9" style="font-size: 14px;">
                    <?php 
                      $fecha_ingreso = date_create($result[0]->fecha_ingreso);
                      $hoy = date('Y-m-j');//Dia de hoy
                      $tre_meses = strtotime ( '-3 month' , strtotime ( $hoy ) ) ;
                      $tre_meses= date ( 'Y-m-j' , $tre_meses);
                      
                      echo '<div class="span4">
                                <b><h4>Datos Personales</h4></b>
                                <b>Legajo: </b>'.$result[0]->legajo.'<br>
                                <b>Nombre: </b>'.$result[0]->nombre.'<br>
                                <b>Apellido: </b>'.$result[0]->apellido.'<br>
                                <b>DNI: </b>'.$result[0]->dni.'<br>
                                <b>Ingreso: </b>'.date_format($fecha_ingreso, 'd/m/y').'<br>
                                <b>Direccion: </b>'.$result[0]->direccion.' - CP '.$result[0]->cp.' '.$result[0]->localidad.' <br>
                                <b>Mail personal: </b>'.$result[0]->email.' <br>
                                <b>Mail laboral: </b>'.$result[0]->email_trabajo.' <br>
                                <b>Celular: </b>'.$result[0]->cel.' <br>
                                <b>Telefono: </b>'.$result[0]->tel.' <br>
                                <h5>SECTOR: '.$sector[0]->descripcion.' </h5><br>'
                              . ''
                        . '</div>   ';
                      echo '<div class="span4">';
                            if (isset($familiar) and count($familiar)){
                                echo "<b><h4>Datos de Familiares </h4></b>";
                                foreach ($familiar as $f){
                                    echo "<b>".$f->parentezco.": </b>".$f->nombre." <br>"
                                       . "<b>".$f->tipo_doc.": </b>".$f->documento." <br>"
                                       . "<b>Tel: </b>".$f->telefono."&nbsp;&nbsp;"
                                    . "<a href='#modal-eliminar' class='btn btn-danger btn-mini' familiar='".$f->idFamiliar."' data-toggle='modal'   title='eliminar familiar'>
                                        <i class='icon-remove'></i></a>"
                                    . "<hr>";
                                }
                            }      
                            echo  '<a href="#modal-agregar" class="btn btn-success " persona="'.$_GET['buscar'].'" style="margin-top:5%;" role="button" data-toggle="modal"   title="Agregar familiar">Agregar Familiar</a><br>'
                        . '</div>';
                            
                      echo' <div class="span4">'; ?>
                              <table class="table table-bordered" style="background-color: #FFF;box-shadow: 2px 2px 2px 2px;">
                                <tbody>
                                    
                                    <tr>
                                        <td> &nbsp;
                                            <a  href="<?php echo base_url()?>index.php/licencia/vincular?persona=<?php echo $result[0]->id;?>&persona_str=<?php echo $result[0]->nombre.' '.$result[0]->apellido;?>">
                                                <label><i class="icon-edit"></i>
                                                    &nbsp;-&nbsp;Asociar LICENCIA 
                                                    </label>
                                            </a>
                                        </td>
                                    </tr>
                                <?php if ($tre_meses>$result[0]->fecha_ingreso){?>
                                <tr>
                                    <td>
                                        <a  href="<?php echo base_url()?>index.php/premio/vincular?persona=<?php echo $result[0]->id;?>&persona_str=<?php echo $result[0]->nombre.' '.$result[0]->apellido;?>">
                                            <label><i class="icon-edit"></i>
                                                &nbsp;-&nbsp;Asociar PREMIO 
                                                </label>
                                        </a>
                                    </td>
                                </tr>
                                    <?php }?>
                                <tr>
                                    <td>
                                        <a  href="<?php echo base_url()?>index.php/capacitacion/vincular?persona=<?php echo $result[0]->id;?>&persona_str=<?php echo $result[0]->nombre.' '.$result[0]->apellido;?>">
                                            <label><i class="icon-edit"></i>
                                                &nbsp;-&nbsp;Asociar CAPACITACION 
                                                </label>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a  href="<?php echo base_url()?>index.php/uniforme/vincular?persona=<?php echo $result[0]->id;?>&persona_str=<?php echo $result[0]->nombre.' '.$result[0]->apellido;?>">
                                            <label><i class="icon-edit"></i>
                                                &nbsp;-&nbsp;Asociar UNIFORME
                                                </label>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a  href="<?php echo base_url()?>index.php/estudio/vincular?persona=<?php echo $result[0]->id;?>&persona_str=<?php echo $result[0]->nombre.' '.$result[0]->apellido;?>">
                                            <label><i class="icon-edit"></i>
                                                &nbsp;-&nbsp;Asociar ESTUDIO
                                                </label>
                                        </a>
                                    </td>
                                </tr>
                                <?php if($this->permission->checkPermission($this->session->userdata('permiso'),'cDesempeno')){ ?> 
                                <tr>
                                    <td>
                                        <a  href="<?php echo base_url()?>index.php/desempeno/agregar?persona=<?php echo $result[0]->id;?>&persona_str=<?php echo $result[0]->nombre.' '.$result[0]->apellido;?>">
                                            <label><i class="icon-list-alt"></i>
                                                &nbsp;-&nbsp;Nuevo DESEMPEÑO
                                                </label>
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                    <?php
                       echo'</div>';
                      ?>  
                </div>  
                     
              </div>

          </div>
          
          <!--LICENCIAS-->
          <div id="tab2" class="tab-pane" style="min-height: 300px">
              <?php
              if (isset($licencia) and count($licencia)!=0){
                  ;
                ?>
                <table  class='table table-bordered'>
                    <tr><td colspan='2'><b> Licencias del empleado</b></td></tr>
                    <tr>
                        <td><b>#</b></td>
                        <td><b>Titulo</b></td>
                        <td><b>Inicio</b></td>
                        <td><b>Finaliza</b></td>
                        <td><b>Dias tomados</b></td>
                        <td><b>Descripcion</b></td>
                        <td></td>
                    </tr>
              <?php
                    foreach ($licencia as $c){
                    echo " <tr> 
                                <td>".$c->idLicenciaPersona."</td> 
                                <td>".$c->titulo." (".$c->dias_corresponde." dias)</td> 
                                <td>".$c->f_inicio."</td> 
                                <td>".$c->f_fin."</td> 
                                <td>".$c->dias_tomados."</td> 
                                <td>".$c->lpdesc."</td> 
                                <td></td> 
                           </tr>";
                    } ?>
                </table>
                    <?php
              }else{
                   echo "<div class='alert alert-danger'>El empleado no tiene Licencias</div>";
              }
              ?>
          </div>
          
          <!--CAPACITACIONES-->
          <div id="tab3" class="tab-pane" style="min-height: 300px">
              <?php
              if (isset($capacitacion) and count($capacitacion)!=0){
                ?>
                <table  class='table table-bordered'>
                    <tr><td colspan='2'><b> Capacitaciones del empleado</b></td></tr>
                    <tr>
                        <td><b>#</b></td>
                        <td><b>Tema</b></td>
                        <td><b>Inicio</b></td>
                        <td><b>Finaliza</b></td>
                        <td><b>Capacitador</b></td>
                        <td><b>Institucion</b></td>
                        <td></td>
                    </tr>
              <?php
                    foreach ($capacitacion as $c){
                    echo " <tr> 
                                <td>".$c->idCapacitacionPersona."</td> 
                                <td>".$c->nombre."</td> 
                                <td>".$c->f_inicio."</td> 
                                <td>".$c->f_fin."</td> 
                                <td>".$c->capacitador."</td> 
                                <td>".$c->institucionStr."</td> 
                                <td></td> 
                           </tr>";
                    } ?>
                </table>
                    <?php
              }else{
                   echo "<div class='alert alert-danger'>El empleado no tiene Capacitaciones</div>";
              }
              ?>
          </div>
          
          <!--PREMIOS-->
          <div id="tab4" class="tab-pane" style="min-height: 300px">
              <?php
              if (isset($premio) and count($premio)!=0){
                  ;
                ?>
                <table  class='table table-bordered'>
                    <tr><td colspan='2'><b> Premios del empleado</b></td></tr>
                    <tr>
                        <td><b>#</b></td>
                        <td><b>Premio</b></td>
                        <td><b>Fecha entrega</b></td>
                        <td><b>Tipo</b></td>
                        <td><b>Descripcion</b></td>
                        <td></td>
                    </tr>
              <?php
                    foreach ($premio as $c){
                    echo " <tr> 
                                <td>".$c->idPremioPersona."</td> 
                                <td>".$c->nombre."</td>";
                    if ($c->fecha_entrega==0){
                        echo "<td>no se especificó la fecha de entrega</td>";
                    }else{
                        echo "<td>".$c->fecha_entrega."</td> ";
                    }
                    echo "
                                <td>".$c->tipo."</td> 
                                <td>".$c->descripcion."</td>  
                                <td></td>  
                           </tr>";
                    } ?>
                </table>
                    <?php
              }else{
                   echo "<div class='alert alert-danger'>El empleado no tiene Premios</div>";
              }
              ?>
          </div>
          
          <!--SANCIONES-->
          <div id="tab5" class="tab-pane" style="min-height: 300px">
              <?php 
              if(isset($sansion)and count($sansion)!=0){
                   ?>
                <table  class='table table-bordered'>
                    <tr><td colspan='3'><b> El empleado tiene <?=count($sansion);?> sanciones</b></td></tr>
                    <tr>
                        <th>Fecha</th>
                        <th>Novedad</th>
                        <th>Comentario</th>
                    </tr>
              <?php
                  foreach ($sansion as $s) {
                     echo " <tr>
                                <td>".date_format(date_create($s->fecha), 'd/m/y')."</td>  
                                <td>".$s->novedad." ";
                     if ($s->justificada ==1){
                         echo "<i>(Justificado)</i>";
                     }
                     echo   "</td>  
                                <td>".$s->comentario."</td>    
                           </tr>"; 
                    }
                 ?>
                </table>
                    <?php
              }else{
                  echo "<div class='alert alert-success'>El empleado no tiene sanciones.</div>";
              }
              ?>
          </div>
          
          <!--AUSENCIAS-->
          <div id="tab6" class="tab-pane" style="min-height: 300px">
              <?php 
              if(isset($ausencia)and count($ausencia)!=0){
                   ?>
                <table  class='table table-bordered'>
                    <tr><td colspan='3'><b> Ausencias del mes <?=count($ausencia);?></b></td></tr>
                    <tr>
                        <td><b>Codigo Bejerman</b></td>
                        <td><b>Fecha</b></td>
                        <td><b>Novedad</b></td>
                    </tr>
              <?php
                  foreach ($ausencia as $s) {
                     echo " <tr>
                                <td>".$s->codigoBejerman."</td> 
                                <td>".date_format(date_create($s->fecha), 'd/m/y')."</td>  
                                <td>".$s->novedad."</td>  
                           </tr>"; 
                    }
                 ?>
                </table>
                    <?php
              }else{
                  echo "<div class='alert alert-success'>El empleado no tiene ausencias.</div>";
              }
              ?>
          </div>
          
          <!--DESEMPEÑO-->
          <div id="tab7" class="tab-pane" style="min-height: 300px">
              <?php 
              if(isset($desempeno)and count($desempeno)!=0){
                   ?>
                <table  class='table table-bordered'>
                    <tr>
                        <td><b>Usuario</b></td>
                        <td><b>Fecha</b></td>
                        <td><b></b></td>
                    </tr>
              <?php
                  foreach ($desempeno as $s) { ?>
                    <tr>
                        <td><?php echo $s->usuario; ?></td>
                        <td><?php echo date_format(date_create($s->f_registro),'d/m/y'); ?></td>
                        <td>
                            <?php
//                            if($this->permission->checkPermission($this->session->userdata('permiso'),'eFallas')){ 
                                echo '<a href="#modal-verDesempeno"  class="btn  tip-top" role="button" data-toggle="modal" title="ver Desempeño" '
                                            . 'desempeno="'.$s->idDesempeno.'" '
                                            . 'fecha="'.date_format(date_create($s->f_registro),'d/m/y').'" '
                                            . 'usuario="'.$s->usuario.'" '
                                            . 'con_tecnico="'.$s->con_tecnico.'" '
                                            . 'con_operativo="'.$s->con_operativo.'" '
                                            . 'precencia_prolijidad="'.$s->precencia_prolijidad.' "'
                                            . 'puntualidad="'.$s->puntualidad.'" '
                                            . 'cumplimiento_modalidad_trabajo="'.$s->cumplimiento_modalidad_trabajo.'" '
                                            . 'vocabulario="'.$s->vocabulario.'" '
                                            . 'trabajo_equipo="'.$s->trabajo_equipo.'" '
                                            . 'capacidad_organizacion="'.$s->capacidad_organizacion.'" '
                                            . 'vocacion_servicio="'.$s->vocacion_servicio.'" '
                                            . 'capacidad_analisis="'.$s->capacidad_analisis.'" '
                                            . 'obs="'.$s->obs.'" '
                                            . 'cumplimiento_normas="'.$s->cumplimiento_normas.'" '
                                            
                                        . '><i class="icon-eye-open"></i></a>';
                            if($this->permission->checkPermission($this->session->userdata('permiso'),'eDesempeno')){ 
                                echo '<a href="'.base_url().'index.php/desempeno/editar/'.$s->idDesempeno.'" class="btn btn-info tip-top" title="Editar Desempeño"><i class="icon-pencil icon-white"></i></a>';
                            }
                            if($this->permission->checkPermission($this->session->userdata('permiso'),'dDesempeno')){
                                echo '<a href="#modal-eliminarDesempeno" class="btn btn-danger tip-top " role="button" data-toggle="modal" desempeno="'.$s->idDesempeno.'"  title="Eliminar Desempeño">
                                                <i class="icon-remove icon-white"></i></a>';
                            }   
                            ?>
                            
                        </td>
                                 
                    </tr>
              <?php             
                    }
                 ?>
                </table>
                    <?php
              }else{
                  echo "<div class='alert alert-success'>Por el momento el empleado no ha sido evaluado..</div>";
              }
              ?>
          </div>
          
          <!--UNIFORME-->
          <div id="tab8" class="tab-pane" style="min-height: 300px">
              <?php 
              if(isset($uniforme)and count($uniforme)!=0){
                   ?>
                <table  class='table table-bordered'>
                    <tr>
                        <td><b>#</b></td>
                        <td><b>Usuario</b></td>
                        <td><b>Fecha de entrega</b></td>
                        <td><b>Prenda</b></td>
                        <td><b></b></td>
                    </tr>
              <?php
                  foreach ($uniforme as $s) {
                      ?>
                    
                    <tr>
                        <td><?php echo $s->idUniforme_has_persona; ?></td>
                        <td><?php echo $s->usuario; ?></td>
                        <td><?php echo date_format(date_create($s->f_proceso),'d/m/y'); ?></td>
                        <td><?php echo $s->descripcion; ?></td>
                        <td>
                            <?php
                            
//                            if($this->permission->checkPermission($this->session->userdata('permiso'),'eDesempeno')){ 
//                                echo '<a href="'.base_url().'index.php/desempeno/editar/'.$s->idDesempeno.'" class="btn btn-info tip-top" title="Editar Desempeño"><i class="icon-pencil icon-white"></i></a>';
//                            }
//                            if($this->permission->checkPermission($this->session->userdata('permiso'),'dDesempeno')){
                                echo '<a href="#modal-eliminarPrenda" class="btn btn-danger tip-top " role="button" data-toggle="modal" idUniforme_has_persona="'.$s->idUniforme_has_persona.'"  title="Eliminar Prenda">
                                                <i class="icon-remove icon-white"></i></a>';
//                            }   
                            ?>
                            
                        </td>
                                 
                    </tr>
              <?php             
                    }
                 ?>
                </table>
                    <?php
              }else{
                  echo "<div class='alert alert-success'>Por el momento el empleado no registra prendas en su poder..</div>";
              }
              ?>
          </div>
          
          
          <!--ESTUDIOS-->
          <div id="tab9" class="tab-pane" style="min-height: 300px">
              <?php 
              if(isset($estudios)and count($estudios)!=0){
                   ?>
                <table  class='table table-bordered'>
                    <tr>
                        <td><b>#</b></td>
                        <td><b>Titulo</b></td>
                        <td><b>Institucion</b></td>
                        <td><b>Fecha</b></td>
                        <td><b></b></td>
                    </tr>
              <?php
                  foreach ($estudios as $s) {
                      ?>
                    
                    <tr>
                        <td><?php echo $s->idEstudio_persona; ?></td>
                        <td><?php echo $s->titulo; ?></td>
                        <td><?php echo $s->institucion; ?></td>
                        <td><?php echo date_format(date_create($s->fecha_registro),'d/m/y'); ?></td>
                        <td>
                            <?php
                            
//                            if($this->permission->checkPermission($this->session->userdata('permiso'),'eDesempeno')){ 
//                                echo '<a href="'.base_url().'index.php/desempeno/editar/'.$s->idDesempeno.'" class="btn btn-info tip-top" title="Editar Desempeño"><i class="icon-pencil icon-white"></i></a>';
//                            }
//                            if($this->permission->checkPermission($this->session->userdata('permiso'),'dDesempeno')){
                                echo '<a href="#modal-eliminarEstudio" class="btn btn-danger tip-top " role="button" data-toggle="modal" idEstudio_persona="'.$s->idEstudio_persona.'"  title="Eliminar Estudio">
                                                <i class="icon-remove icon-white"></i></a>';
//                            }   
                            ?>
                            
                        </td>
                                 
                    </tr>
              <?php             
                    }
                 ?>
                </table>
                    <?php
              }else{
                  echo "<div class='alert alert-success'>Por el momento el empleado no registra Estudios.</div>";
              }
              ?>
          </div>
          
       </div>
    </div>
<?php 
}
?>

<!-- Modal agregar familiar -->
<div id="modal-agregar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/familiar/agregar" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Datos de familiares</h5>
  </div>
  <div class="modal-body">
      <input type="hidden" name="idPersona" value="<?php if (isset($_GET['buscar'])) {echo $_GET['buscar'];}?>" >
      <table>
          <tr>
              <td>Parentezco</td>
              <td>
                  <select name="parentezco" required="required">
                      <option value="PADRE">PADRE</option>
                      <option value="MADRE">MADRE</option>
                      <option value="HERMANO/A">HERMANO/A</option>
                      <option value="TUTOR/A">TUTOR/A</option>
                  </select>
              </td>
          </tr>
          <tr>
              <td>Nombre</td>
              <td><input name="nombre" type="text" required="required"></td>
          </tr>
          <tr>
              <td>Tipo Doc.</td>
              <td>
                  <select name="tipo_doc" required="required">
                      <option value="DNI">DNI</option>
                      <option value="CI">CI</option>
                      <option value="LE">LE</option>
                      <option value="LC">LC</option>
                  </select>
              </td>
          </tr>
          <tr>
              <td>nro. Documento</td>
              <td><input name="documento" type="text" required="required"></td>
          </tr>
          <tr>
              <td>Teléfono</td>
              <td><input name="telefono" type="text" required="required"></td>
          </tr>
      </table>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Guardar</button>
  </div>
  </form>
</div>

<!-- Modal eliminar-->
<div id="modal-eliminar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/familiar/eliminar" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Eliminar familiar</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idFamiliar" name="id" value="" >
    <input type="hidden"  name="idPersona" value="<?php if (isset($_GET['buscar'])) {echo $_GET['buscar'];}?>" >
    <h5 style="text-align: center">Realmente desea eliminar familiar?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Eliminar</button>
  </div>
  </form>
</div>

<!-- Modal eliminar desempeño--->
<div id="modal-eliminarDesempeno" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/desempeno/eliminar" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Eliminar Desempeño</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idDesempeno" name="id" value="" >
    <input type="hidden" id="idPersona" name="idPersona" value="<?php if (isset($_GET['buscar'])){echo $_GET['buscar'];}?>" >
    
    <h5 style="text-align: center">Realmente desea eliminar el desempeño?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Eliminar</button>
  </div>
  </form>
</div>

<!-- Modal ver desempeño--->
<div id="modal-verDesempeno" class="modal hide fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Desempeño #<b id="desempeno_autor"></b></h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idDesempeno" name="id" value="" >
    <table class="table table-bordered" >
        <tr>
            <th colspan="2"><b>Habilidades Técnicas</b></th>
        </tr>
        <tr>
            <td>Conocimiento Operativo de Tareas del Area</td>
            <td><b id="at1"></b></td>
        </tr>
        <tr>
            <td>Conocimiento Técnico de Tareas del Area</td>
            <td><b id="at2"></b></td>
        </tr>
        <tr>
            <th colspan="2"><b>Conducta</b></th>
        </tr>
        <tr>
            <td>Precencia, Prolijidad y Uso del uniforme</td>
            <td><b id="at3"></b></td>
        </tr>
        <tr>
            <td>Cumplimiento de las normas generales del área y de la empresa</td>
            <td><b id="at4"></b></td>
        </tr>
        <tr>
            <td>Puntualidad</td>
            <td><b id="at5"></b></td>
        </tr>
        <tr>
            <td>Cumplimiento de modalidad de trabajo</td>
            <td><b id="at6"></b></td>
        </tr>
        <tr>
            <th colspan="2"><b>Competencias</b></th>   
        </tr>
        <tr>
            <td>Vocabulario</td>
            <td><b id="at7"></b></td>
        </tr>
        <tr>
            <td>Trabajo en equipo</td>
            <td><b id="at8"></b></td>
        </tr>
        <tr>
            <td>Capacidad de Organizacion</td>
            <td><b id="at9"></b></td>
        </tr>
        <tr>
            <td>Vocacion de servicio</td>
            <td><b id="at10"></b></td>
        </tr>
        <tr>
            <td>Capacidad de analisis y organizacion</td>
            <td><b id="at11"></b></td>
        </tr>
        <tr>
            <td colspan="2">Observacion:<br><b id="at12"></b></td>
        </tr>
    </table>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>
</div>

<!-- Modal eliminar prenda(uniforme)--->
<div id="modal-eliminarPrenda" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/uniforme/eliminarPrendaPersona" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Eliminar Prenda</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idUniforme_has_persona" name="id" value="" >
    <input type="hidden" id="idPersona" name="idPersona" value="<?php if (isset($_GET['buscar'])){echo $_GET['buscar'];}?>" >
    
    <h5 style="text-align: center">Realmente desea eliminar esta Prenda?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Eliminar</button>
  </div>
  </form>
</div>

<!-- Modal eliminar estudio--->
<div id="modal-eliminarEstudio" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/estudio/eliminarEstudioPersona" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Eliminar Estudio</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idEstudio_persona" name="id" value="" >
    <input type="hidden" id="idPersona" name="idPersona" value="<?php if (isset($_GET['buscar'])){echo $_GET['buscar'];}?>" >
    
    <h5 style="text-align: center">Realmente desea eliminar este estudio?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Eliminar</button>
  </div>
  </form>
</div>

<script type="text/javascript">
$(document).ready(function(){
        $(document).on('click', 'a', function(event) {       
            var familiar = $(this).attr('familiar');
            $('#idFamiliar').val(familiar);
            
            var desempeno = $(this).attr('desempeno');
            $("#idDesempeno").val(desempeno);
            
            var idUniforme_has_persona = $(this).attr('idUniforme_has_persona');
            $("#idUniforme_has_persona").val(idUniforme_has_persona);
            
            var idEstudio_persona = $(this).attr('idEstudio_persona');
            $("#idEstudio_persona").val(idEstudio_persona);
            
            var tfecha = $(this).attr('fecha');
            var tusuario = $(this).attr('usuario');
            
            var at1 = $(this).attr('con_operativo');
            var at2 = $(this).attr('con_tecnico');
            
            var at3 = $(this).attr('precencia_prolijidad');
            var at4 = $(this).attr('cumplimiento_modalidad_trabajo');
            var at5 = $(this).attr('puntualidad');
            var at6 = $(this).attr('cumplimiento_normas');
            
            var at7 = $(this).attr('vocabulario');
            var at8 = $(this).attr('trabajo_equipo');
            var at9 = $(this).attr('capacidad_organizacion');
            var at10 = $(this).attr('vocacion_servicio');
            var at11 = $(this).attr('capacidad_analisis');
            var at12 = $(this).attr('obs');
            
            
            $('#desempeno_autor').text(" "+desempeno+" "+tusuario+" "+tfecha);
            
            $('#at1').text(at1);
            $('#at2').text(at2);
            $('#at3').text(at3);
            $('#at4').text(at4);
            $('#at5').text(at5);
            $('#at6').text(at6);
            $('#at7').text(at7);
            $('#at8').text(at8);
            $('#at9').text(at9);
            $('#at10').text(at10);
            $('#at11').text(at11);
            $('#at12').text(at12);
            
        });
        
          $("#cancel").hide();
          $("#persona").autocomplete({
            source: "<?php echo base_url(); ?>index.php/Persona/autoCompletePersona",
            minLength: 1,
            select: function( event, ui ) {
                    $("#persona_id").val(ui.item.id);
                    $("#formBuscar").submit();
                    
                }
          });
          
         
          
      });
      
$(function() {
    
   //#CAPTURA DE IMAGEN DEL EMPLEADO  
   $('#file-input').change(function(e) {
      addImage(e); 
     });

    function addImage(e){
     var file = e.target.files[0],
     imageType = /image.*/;

     if (!file.type.match(imageType))
      return;

     var reader = new FileReader();
     reader.onload = fileOnload;
     reader.readAsDataURL(file);
    }
  
    function fileOnload(e) {
      var result=e.target.result;
      $('#imgSalida').attr("src",result);
      $('#guardar_imagen').show();
      $('#lbl_file').hide();
     }
     
 
});
</script>
