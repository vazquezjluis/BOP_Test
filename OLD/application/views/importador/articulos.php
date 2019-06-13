<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-hdd"></i>
                </span>
                <h5>Cargar un archivo</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12 well">
                    <div class="span12"><h3>Importador de Artículos</h3></div>
                    <div class="span8">
                        <h5>Requermientos</h5>
                        <p><span class="icon-chevron-right"></span> &nbsp;&nbsp;El archivo debe tener extencion .xlsx</p>
                        <p><span class="icon-chevron-right"></span>&nbsp;&nbsp; Debe respetar los encabezados como se muestra en la imagen partiendo de la celda "A1".</p>    
                        <p><table border="1" cellpadding="3"><tr>
                                <td>stkart_codgen </td>
                                <td>skart_codEle1 </td>
                                <td>skart_codEle2 </td> 
                                <td>skart_codEle3 </td> 
                                <td>deposito </td> 
                                <td>cantidad </td> 
                                <td>f_carga_bejerman </td>
                                <td>autor </td>
                            </tr></table></p>
                        <p><span class="icon-chevron-right"></span>&nbsp;&nbsp; Respete los puntos, espacios y mayusculas del encabezado.</p>
                        <p><span class="icon-chevron-right"></span>&nbsp;&nbsp; Los datos deben estar entre las columnas "A" e "H" inclusive.</p>
                        <p><span class="icon-chevron-right"></span>&nbsp;&nbsp; Revise que no existan celdas vacías en la columna "A"(stkart_codgen) y "E" (cantidad). </p>
                        <!--<p><span class="icon-chevron-right"></span>&nbsp;&nbsp; El Nro. EGM debe ser numérico de 7 caracteres. </p>-->
                        <p><span class="icon-chevron-right"></span>&nbsp;&nbsp; El sistema toma los datos de la <b> hoja activa</b>. Es recomendable que el archivo solo tenga una hoja para evitar confusión. </p>
                    </div>
                    <div class="span3" style="border: 1px solid #ccc;padding: 1%;border-radius: 5px;margin: 1%;">
                        <a href="#modal-excluir"  style="margin-top:0px;float: right;" role="button" data-toggle="modal">
                            <p>Click para ver el ejemplo</p>
                            <img  src="<?php echo  base_url()."assets/img/import_articulos.jpg"; ?>" width="100%;"/>
                        </a>
                    </div>
                    
                </div>
                
                
                <form action="<?php echo current_url(); ?>" id="formArquivo" enctype="multipart/form-data" method="post" class="form-horizontal" >
                    
                    <div class="control-group">
                        <div class="controls">
                            
                            <?php 
                            if (count($results)){
                                echo "<label style = 'color:red;'>Codigos de depositos a tener en cuenta: <b>";
                                foreach ($results as $r){
                                    echo ','.$r->cod_deposito;
                                }
                                echo '</b> tenga en cuenta que solo se importarán los depositos con estas codificaciones.</label>';
                            }else{
                                echo "<label class='alert alert-danger'>No hay codigo de depositos, no podrá continuar con la importacion. Pongase en contacto con el administrador del sistema. </label>";
                            }
                            ?>
                            
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <input  type="hidden" name="tipo" value="articulos"/>
                            <input id="archivo" type="file" name="el_importado" required="required"/> (solo .xlsx)
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
    <img  src="<?php echo  base_url()."assets/img/import_articulos.jpg"; ?>" width="100%;"/>
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
                                    
