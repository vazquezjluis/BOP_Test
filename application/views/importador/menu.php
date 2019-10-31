<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <?php if (isset($_GET['error'])) {
                    echo '<div class="alert alert-danger">'.$_GET['error'].'</div>';
                } ?>
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-hdd"></i>
                </span>
                <h5>Cargar un archivo</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12 well">
                    <div class="span12"><h3>Importador de Menus</h3></div>
                     
                    <div class="span8">
                        <h5>Requermientos</h5>
                        <div class="alert alert-info"><strong>Atencion!</strong> Asegurate de que no existan menus cargados manualmente, Si existen el archivo no se importara.</div>
                        <p><span class="icon-chevron-right"></span> &nbsp;&nbsp;El archivo debe tener extencion .xlsx</p>
                        <p><span class="icon-chevron-right"></span>&nbsp;&nbsp; Debe respetar los encabezados como se muestra en la imagen partiendo de la celda "A1".</p>    
                       
                        <p><span class="icon-chevron-right"></span>&nbsp;&nbsp; Respete los puntos, espacios y mayusculas del encabezado.</p>
                        <p><span class="icon-chevron-right"></span>&nbsp;&nbsp; Los datos deben estar entre las columnas "A" y "D" inclusive.</p>
                        <p><span class="icon-chevron-right"></span>&nbsp;&nbsp; Revise que no existan celdas vacías en la columna "A"(FECHA) y "D" (REFRIGERIO). </p>
                        <p><span class="icon-chevron-right"></span>&nbsp;&nbsp; El sistema toma los datos de la <b> hoja activa</b>. Es recomendable que el archivo solo tenga una hoja para evitar confusión. </p>
                    </div>
                    <div class="span3" style="border: 1px solid #ccc;padding: 1%;border-radius: 5px;margin: 1%;">
                        <a href="#modal-excluir"  style="margin-top:0px;float: right;" role="button" data-toggle="modal">
                            <p>Click para ver el ejemplo</p>
                            <img  src="<?php echo  base_url()."assets/img/import_menu.png"; ?>" width="100%;"/>
                        </a>
                    </div>
                    
                </div>
                
                
                <form action="<?php echo current_url(); ?>" id="formArquivo" enctype="multipart/form-data" method="post" class="form-horizontal" >
                    
                    <div class="control-group">
                        <div class="controls">
                            <input  type="hidden" name="tipo" value="menu"/>
                            <input id="archivo" type="file" name="el_importado" required="required"/> (solo .xlsx)
                        </div>
                    </div>
                    <div class="control-group">
                        
                            <label class="control-label"> Tipo dle Menu </label>
                            <div class="controls">
                                <select id="tipo_menu" name="tipo_menu" required="required">
                                    <option value="externo">Externo (Proveedor)</option>
                                    <option value="interno">Interno (Aperitivos del Bingo)</option>
                                </select>
                            </div>
                    </div>
                    

                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Analizar</button>
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
<div id="modal-excluir" style="width: 98%;height: 100%;margin: 1% 0% 1% 1% ;top: 0;left: 0;"   class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Ejemplo Excel</h5>
  </div>
  <div class="modal-body">
    <img  src="<?php echo  base_url()."assets/img/import_menu.png"; ?>" width="100%;"/>
  </div>
</div>


<script type="text/javascript">


$(document).ready(function(){
   
   $(function() {
        $("#fullScreem").click(function(){
            $("#screem").removeClass('hide');
        });
    });
  
});
</script>