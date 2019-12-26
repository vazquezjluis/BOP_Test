$(document).on("ready", main);

functoin main(){
    mostrarDatos("",1);

    $("input[name=busqueda]").keyup(function(){
      textoBuscar = $(this).val();

        mostrarDatos(textoBuscar);
    });
}

function mostrarDatos(valorBuscar){
    $.ajax({
      url : "http://localhost/intranet_cami/Intranet-cami/BOP_Test/index.php/Reportes/maquinas",
      type : "POST",
      data: {buscar: valorBuscar},
      dataType: "json",
      success: function(response){

          filas = "";
          $.each(response.maquinas,function(key,item){
            filas+="<tr><td>" + item.id + "</td><td>" + item.nro_egm + "</td></tr>";
          });

          $("#tbmaquinas tbody").html(filas);

          //total registros
            totalregistros = response.totalregistros;
          //cantidad de rsgistros por pagina
            cantidadregistros = response.cantidad;

            numerolinks = Math.ceil(totalregistros/cantidadregistros);
            paginador = "<ul class='pagination'>";
              for (var i = 1; i <= numerolinks; i++) {
                  paginador +="<li><a href='"+i+"'>"+i+"</a></li>"
              }
            paginador +="</ul>";
            $(".paginacion").html(paginador);
      }


    })
}
