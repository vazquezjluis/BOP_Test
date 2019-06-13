
<div class="widget-box">
    <div class="widget-title">
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#tab1">
                    Prenda <?php echo $result[0]->prenda." ".$result[0]->apellido; ?>
                </a>
            </li>
        </ul>
    </div>          
    <div class="widget-content tab-content">
        <div id="tab1" class="tab-pane active" style="min-height: 300px">
        <table class="table table-bordered " style="background-color: #FFF;">
            <tbody>
                <tr>
                    <td style="text-align: right"><strong>Contacto</strong></td>
                    <td><?php echo $result[0]->contacto; ?></td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Domicilio</strong></td>
                    <td><?php echo $result[0]->domicilio; ?></td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Estado</strong></td>
                    <td><?php echo $result[0]->meta_estado."  ".date('d/m/Y H:m:s',  strtotime($result[0]->fecha_meta_estado)); ?></td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Descripcion</strong></td>
                    <td><?php echo $result[0]->descripcion; ?></td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Documentos adjuntos</strong></td>
                    <td>
                         <?php if(isset($cv[0]->url)){ ?>
                            <a href="#modal-cv" class="btn  tip-top " role="button" data-toggle="modal"   title="Ver CV">
                                    <i class="icon-list-alt"></i> - CV</a>
                         <?php } ?>
                        
                         <?php if(isset($psicotecnico[0]->url)){ ?>           
                            <a href="#modal-psicotecnico" class="btn  tip-top " role="button" data-toggle="modal"   title="Ver CV">
                                    <i class="icon-list-alt"></i> - Psicotecnico</a>
                         <?php } ?>           
                         <?php if(isset($ambiental[0]->url)){ ?>           
                            <a href="#modal-ambiental" class="btn  tip-top " role="button" data-toggle="modal"   title="Ver CV">
                                    <i class="icon-list-alt"></i> - Ambiental</a>
                        <?php } ?>            
                        <?php if(isset($policial[0]->url)){ ?>           
                        <a href="#modal-policial" class="btn  tip-top " role="button" data-toggle="modal"   title="Ver CV">
                                    <i class="icon-list-alt"></i> - Policial</a>
                        <?php } ?>
                        <br>
                        <hr>
                        <a href="#modal-nuevo" class="btn btn-primary  tip-top " candidato='<?php echo $result[0]->idSeleccion_personal;?>' role="button" data-toggle="modal"   title="Cargar nuevo o modificar uno existente">
                                    <i class="icon-plus"></i> Nuevo documento</a>
                        
                        
                    </td>
                </tr>

            </tbody>
        </table>  
        </div>
    </div>
</div>

<div id="modal-nuevo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php   echo base_url() ?>index.php/seleccion_personal/nuevoDocumento" method="post" enctype="multipart/form-data" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Cargar nuevo archivo o modificar uno existente</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idCandidatoArchivo" name="id" value="" />
    <div class="control-group">
        <label for="documento" class="control-label">Tipo <span class="required"></span></label>
        <select name="documento" required="">
            <option value="">Seleccione</option>
            <option value="CV">CV</option>
            <option value="psicotecnico">Psicotecnico</option>
            <option value="ambiental">Ambiental</option>
            <option value="policial">Policial</option>
        </select>
    </div>
    <div class="control-group">
        <label for="documento" class="control-label">Adjuntar <span class="required"></span></label>
        <div class="controls">
            <input type="file" class="form-control" name="userFiles[]"  required="required"/>
        </div>
    </div>
  </div>
  <div class="modal-footer">
      <div class="alert alert-danger"><b>Atencion!</b> Al modificar un documento, este será reemplazado y no podrá ser recuperado. </div>
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Modificar</button>
  </div>
  </form>
</div>
<div id="modal-cv" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Curriculum Vitae</h5>
  </div>
  <div class="modal-body">
      <embed src="<?php 
            if(isset($cv[0]->url))
                {echo $cv[0]->url;}
            else{echo base_url()."assets/img/sin_imagen.jpg"; 
            }?>" 
        style="max-height: 500px;">
  </div>
</div>
<div id="modal-psicotecnico" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Psicotecnico</h5>
  </div>
  <div class="modal-body">
      <embed src="<?php 
            if(isset($psicotecnico[0]->url))
                {echo $psicotecnico[0]->url;}
            else{echo base_url()."assets/img/sin_imagen.jpg"; 
            }?>" 
        style="max-height: 500px;">
  </div>
</div>
<div id="modal-ambiental" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Ambiental</h5>
  </div>
  <div class="modal-body">
      <embed src="<?php 
            if(isset($ambiental[0]->url))
                {echo $ambiental[0]->url;}
            else{echo base_url()."assets/img/sin_imagen.jpg"; 
            }?>" 
        style="max-height: 500px;">
  </div>
</div>
<div id="modal-policial" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Ambiental</h5>
  </div>
  <div class="modal-body">
      <embed src="<?php 
            if(isset($policial[0]->url))
                {echo $policial[0]->url;}
            else{echo base_url()."assets/img/sin_imagen.jpg"; 
            }?>" 
        style="max-height: 500px;">
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){

   $(document).on('click', 'a', function(event) {       
        var candidato = $(this).attr('candidato');
        
        $('#idCandidatoArchivo').val(candidato);

    });

});

</script>