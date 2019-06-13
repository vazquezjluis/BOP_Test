<div class="widget-box">
   <div class="widget-title">
      <ul class="nav nav-tabs">
         <li class="active"><a data-toggle="tab" href="#tab1">Datos del articulo</a></li>
         <li><a data-toggle="tab" href="#tab2">Historial </a></li>
         
      </ul>
   </div>
   <div class="widget-content tab-content">
      <div id="tab1" class="tab-pane active" style="min-height: 300px">
          <div class="span12 nopadding">
            <div class="span4"> 
                <?php  if (isset($url_img[0]->url)){$url = $url_img[0]->url;
                    }else{$url=  base_url()."assets/img/sin_imagen.jpg";} ?>
               <img src="<?php echo $url?>" class="span12" id="imgSalida"><br>
               <form action="<?php echo base_url(); ?>index.php/Archivos/agregar/" id="formArquivo" enctype="multipart/form-data" method="post"  >
                  <input type="hidden" name="nombre" value="Articulo: <?php echo $result->idArticulo;?>">
                  <input type="hidden" name="descripcion" value="modifica la imagen del articulo">
                  <input type="hidden" name="sector" value="4">
                  <input type="hidden" name="referencia" value="<?php echo $result->idArticulo; ?>">
                  <label class="btn span12" id="lbl_file" style="margin: 0px;" ><span class="icon icon-camera"></span>  Cambiar imagen
                  <input id="file-input" accept="image/*" type="file" required="true" name="userfile" style="display: none;" capture/>
                  </label>
                  <!--<button type="submit" id="guardar_imagen" style="display: none;margin: 0px;" class="span12 btn btn-success"> Guardar</button>-->
               </form>
               <div class="span12"></div>
               
            </div>
            <div class="span8">
               <?php 
                  $tipo = "";
                  $modelo_asociado=" Este articulo no tiene modelos asociados.";
                  $str="";
                  if ($result->tipo_modelo!=''){
                      $modelos = explode("-_-", $result->tipo_modelo);
                      if (count($modelos)){
                          if (count($modelos)>1){
                              $str.=" a los siguientes modelos: ";
                          }else{
                              $str.=" al modelo ";
                          }
                          $model_string="";
                          
                          foreach ($modelos as $m){                              
                              $model_string.="<div class='span3' ><i>- ".$m."</i></div>";
                              
                          }
                          
                      }
                      $modelo_asociado = '<div class="span12"><b>Este articulo esta asociado'.$str.'</b></div> '.$model_string.''; 
                  }
                  echo '<div  style="font-size:14px;">
                            <b>'.strtoupper($result->nombre).'</b>
                            CDO'.$result->idArticulo.'<br>
                            '.$result->descripcion.'<br><br>
                            
                            <b>Stock disponible: </b>'.$result->stock.'     (<i>Mínimo: </i>'.$result->stockMinimo.')<br>';
                            if($result->entrada == 1){ $tipo .="- Entrada "; }
                            if($result->salida == 1){ $tipo .="- Salida "; }
                            echo '<b>Tipo: </b>'.$tipo.'<br><br>';
                            echo $modelo_asociado;
                        echo '</div>';
//                        <div class="span12"><br>
//                            <button class="btn btn-primary" ><i class="icon-plus-sign"></i> Agregar Stock</button><br>
//                        </div>  
//                        <div class="span12"><br>
//                            <a href="#modal-excluir" class="btn btn-danger " articulo="'.$result->idArticulo.'"  role="button" data-toggle="modal"   title="Eliminar Stock">
//                                            <i class="icon-minus-sign "></i> Eliminar Stock</a>
//                            
//                        </div>';  
                  
                  ?> 
                    
            </div>
          </div>
          
      </div>
      <!--Tab 2-->
      <div id="tab2" class="tab-pane" style="min-height: 300px">
          
         <?php 
         if(!$historial_articulo){ ?> 
          <div class="alert alert-info"> No existen movimientos </div>
        <?php }else{ ?>
          <table class="table table-striped">
              <thead>
                  <tr>
                      <td><strong>Movimiento de <?php echo "Cod:#".$result->idArticulo." ".$result->nombre;?></strong></td>
                      <td><strong>Fecha y hora</strong></td>
                      <td><strong>Cantidad</strong></td>
                      <td><strong>Usuario</strong></td>
                  </tr>
              </thead>
              <tbody>
          <?php 
          foreach ($historial_articulo as $ha){
            
            $buscar = "#ingreso al sistema";
            $resultado = strpos($ha->movimiento, $buscar);
            if ($resultado!== FALSE){
                $movimiento ="Ingresan ".$ha->cantidad." unidades al sistema." ;  
            }else{
                $buscar = "#Agrega unidades";
                $resultado = strpos($ha->movimiento, $buscar);
                if ($resultado!== FALSE){
                    $movimiento = "Agrega ".$ha->cantidad." desde la modificacion del artículo.";
                }else{
                    $buscar = "#Quita unidades";
                    $resultado = strpos($ha->movimiento, $buscar);
                    if ($resultado!== FALSE){
                        $movimiento = "Quita ".$ha->cantidad." desde la modificacion del artículo.";
                        }else{
                            $buscar = "#Edita-Agrega importacion";
                            $resultado = strpos($ha->movimiento, $buscar);
                           
                            
                            if($resultado!== FALSE){
                                $movimiento = "Agrega ".$ha->cantidad." desde la IMPORTACION.";
                            }else{
                                $buscar = "#Edita-Quita importacion";
                                $resultado = strpos($ha->movimiento, $buscar);
                                if($resultado!== FALSE){
                                    $movimiento = "Quita ".$ha->cantidad." desde la IMPORTACION.";
                                }else{
                                    $buscar = "#Alta importacion";
                                    $resultado = strpos($ha->movimiento, $buscar);
                                    if($resultado!== FALSE){
                                        $movimiento = "Nuevo Articulo ".$ha->cantidad." desde la IMPORTACION del artículo.";
                                    }else{

                                        $movimiento = "Mueve ".$ha->cantidad." desde ".str_replace(">", "---> hacia", $ha->movimiento);
                                    }
                                    
                                }
                            }
                        
                    }
                    
                }
                
            }
            
            echo "
                <tr>
                    <td>".$movimiento."</td>
                    <td>".$ha->fecha_hora."</td>
                    <td>".$ha->cantidad."</td>
                    <td>".$ha->usuario_str."</td>
                </tr>
              ";
              
          } ?>
              </tbody>
          </table>
         <?php     
         }
         ?>
      </div>
   </div>
</div>



<script type="text/javascript">
//Para acceder a la camara en desktop
//window.addEventListener('load',init);
//function init(){
//    var video = document.querySelector('#v'), canvas = document.querySelector('#c'),
//        btn = document.querySelector('#t'), img = document.querySelector('#img');
//    
//    navigator.getUserMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia ||navigator.mozGetUserMedia ||navigator.msGetUserMedia );
//                
//        
//    if(navigator.getUserMedia){
//            navigator.getUserMedia({video:true},function(stream){
//               video.src = window.URL.createObjectURL(stream);
//               video.play();
//            },function(e){console.log(e);});
//        }else alert ('Atencion para funciones de camara es necesario que actualices tu navegador!. Shsolinteg.com :)');   
//          
//    video.addEventListener('loadedmetadata',function(){canvas.width = video.videoWidth; canvas.height = video.videoHeigth;},false);    
//    
//    btn.addEventListener('click',function(){
//            canvas.getContext('2d').drawImage(video,0,0);
//            var imgData = canvas.toDataURL('image/png');
//            img.setAttribute('src',imgData);
//        });
//    
//}

$(function() {
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
