/**
* Función encargada de recargar la tabla de productos
*/
function recargarProductos()
{
  $.ajax(
  {
    cache: false,
    type: "POST",
    url: "querys/gestion_productos.php",
    data: { opcion : 1 },
    dataType: "json",
    success: function(res)
    {
      if( res.status === "OK" )
      {
        var datos = [];
        for( var i=0; i < res.productos.length; i++)
        {
            var link_editar = '<a href="#" class="fa fa-pencil-square-o" aria-hidden="true" onclick="modificarProducto(\''+ res.productos[i].id +'\',\''+ res.productos[i].titulo +'\',\''+
                              res.productos[i].descripcion +'\',\''+ res.productos[i].precio +'\',\''+ res.productos[i].imagen +'\')"></a>';
            var link_borrar = '<a href="#" class="fa fa-trash-o" aria-hidden="true" onclick="elimnarProducto(\''+ res.productos[i].id +'\')"></a>';
            var img = res.productos[i].imagen === "null" ? "" : '<img class="img_producto" src="data:image/*;base64,'+ res.productos[i].imagen +'/>';
            datos[i] = [
                            res.productos[i].id,
                            res.productos[i].titulo,
                            res.productos[i].precio,
                            img,
                            link_editar,
                            link_borrar
                        ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_productos').DataTable();
        table.destroy();
        $("#tabla_productos").DataTable({
            data: datos,
            responsive: true,
            "language":{
                "url"   :   "extensions/datatables/language/es.json"
            }
        });
      }else if(res.status === "EXPIRED" )//Sesión finalizada
      {
        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }else if( res.status === "ERROR")
      {
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
}
/**
* Función encargada de gestionar la apertura del PopUp para el ingreso del nuevo producto
*/
function abrirNuevoProducto()
{

  //Resetear campos
  $("#new_titulo").val("");
  $("#new_descripcion").val("");
  $("#new_precio").val("");
  $("#new_imagen").val("");
  //Ocultar mensajes error
  $("#form_nuevo_producto #msg_error_titulo").fadeOut();
  $("#form_nuevo_producto #msg_error_descripcion").fadeOut();
  $("#form_nuevo_producto #msg_error_precio").fadeOut();
  $("#form_nuevo_producto #msg_error_imagen").fadeOut();
  //Abrir PopUp
  $("#modalNuevoProducto").modal("show");
  $('#modalNuevoProducto').on('shown.bs.modal', function (e) {
      $("#new_titulo").focus();
  });
}
/**
* Funcion encargada de visualizar la image para el nuevo producto,
* Se carga una vez se selecciona la imagen
*/
$(document).on('change', '#new_imagen',  function(){
  if ( this.files && this.files[0] && this.files[0].type.match("image/*") )
  {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#preview_new_image')
                            .attr('src', e.target.result)
                            .width(80)
                            .height("auto")
                            .fadeIn();
    };
    reader.readAsDataURL(this.files[0]);
  }else{
    $('#preview_new_image')
                          .attr('src', '')
                          .fadeOut();
  }
});
/**
* Funcion encargada de procesar el registro del nuevo usuario
*/
function guardarNuevo()
{
  var titulo = $("#new_titulo").val();
  var desc = $("#new_descripcion").val();
  var precio = $("#new_precio").val();
  //Ocultar mensajes error
  $("#form_nuevo_producto #msg_error_titulo").fadeOut();
  $("#form_nuevo_producto #msg_error_descripcion").fadeOut();
  $("#form_nuevo_producto #msg_error_precio").fadeOut();
  $("#form_nuevo_producto #msg_error_imagen").fadeOut();

  //Validar campos requeridos
  if( titulo === "" )
  {
    $("#new_titulo").focus();
    $("#form_nuevo_producto #msg_error_titulo").fadeIn();
  }else if( desc === "")
  {
    $("#new_descripcion").focus();
    $("#form_nuevo_producto #msg_error_descripcion").fadeIn();
  }else if( precio === "")
  {
    $("#new_precio").focus();
    $("#form_nuevo_producto #msg_error_precio").fadeIn();
  }else if( $("#new_imagen").val() === "")
  {
    $("#new_imagen").focus();
    $("#form_nuevo_producto #msg_error_imagen").text("Campo requerido");
    $("#form_nuevo_producto #msg_error_imagen").fadeIn();
  }else
  {
    var input_file = $("#new_imagen")[0];
    //Verificar que sea una imagen
    if( !input_file.files[0].type.match("image/*") )
    {
      $("#new_imagen").focus();
      $("#form_nuevo_producto #msg_error_imagen").text("Por favor seleccione una imagen (PNG/JPEG)");
      $("#form_nuevo_producto #msg_error_imagen").fadeIn();
    }else if( input_file.files[0].size > 6000000) //Validar el tamaño de la imagen
    {
      $("#new_imagen").focus();
      $("#form_nuevo_producto #msg_error_imagen").text("La imagen seleccionada supera los 6MB");
      $("#form_nuevo_producto #msg_error_imagen").fadeIn();
    }else
    {
      $("#btn_guardar_nuevo").button("loading"); //Cambiar estado del botón guardarNuevo
      //Submit imagen
      $("#form_nuevo_producto").attr("action","querys/gestion_productos.php");
      $("#form_nuevo_producto").submit();
    }
  }
}

/**
* Función encargada de procesar la respuesta del submit de la imagen y procesar el guardar los datos del producto
*/
function callbackImagenGuarduarNuevo(res)
{
  if( res.status === "OK" )
  {
    $("#modalNuevoProducto").modal("hide");
    jAlert('Producto guardado con éxito', 'Nuevo Producto', function(){
      recargarProductos();
    });
  }else if(res.status === "EXPIRED" )//Sesión finalizada
  {
    jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
      window.location = "cerrar_sesion.php";
    });
  }else if( res.status === "ERROR")
  {
    jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
  }
  $("#btn_guardar_nuevo").button("reset");//Restaurar boton guardar
}

$(document).ready( function()
{
  $("#tabla_productos").DataTable({
    responsive: true,
    "language":{
        "url"   :   "extensions/datatables/language/es.json"
    }
  });
  //Submit formulario imagen
  $('#form_nuevo_producto').ajaxForm({
    dataType: "json",
    success: callbackImagenGuarduarNuevo
  });
});
