/**
* Función encargada de recargar la tabla de tipo de novedades
*/
function recargarTipoNovedades()
{
  $.ajax(
  {
    cache: false,
    type: "POST",
    url: "querys/gestion_tipos_novedades.php",
    data: { opcion : 1 },
    dataType: "json",
    success: function(res)
    {
      if( res.status === "OK" )
      {
        var datos = [];
        for( var i=0; i < res.novedades.length; i++)
        {
            var link_editar = '<a href="#" class="fa fa-pencil-square-o" aria-hidden="true" onclick="modificarTipoNovedad(\''+ res.novedades[i].id +'\',\''+ res.novedades[i].nombre +'\',\''+
                              res.novedades[i].descripcion +'\')"></a>';
            var link_borrar = '<a href="#" class="fa fa-trash-o" aria-hidden="true" onclick="elimnarTipoNovedad(\''+ res.novedades[i].id +'\')"></a>';
            datos[i] = [
                            res.novedades[i].id,
                            res.novedades[i].nombre,
                            res.novedades[i].descripcion,
                            link_editar,
                            link_borrar
                        ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_novedades').DataTable();
        table.destroy();
        $("#tabla_novedades").DataTable({
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
* Función encargada de gestionar la apertura del PopUp para el ingreso del nuevo tipo de novedad
*/
function abrirNuevoTipoNovedad()
{

  //Resetear campos
  $("#new_nombre").val("");
  $("#new_descripcion").val("");
  //Ocultar mensajes error
  $("#form_nuevo_tipo_novedad #msg_error_nombre").fadeOut();
  //Abrir PopUp
  $("#modalNuevoTipoNovedad").modal("show");
  $('#modalNuevoTipoNovedad').on('shown.bs.modal', function (e) {
      $("#new_nombre").focus();
  });
}

/**
* Función encargada de inicializar y abrir PopUp modificar tipo de novedad
*/
function modificarTipoNovedad(id,nombre,desc)
{

  //Asignar valores a los campos
  $("#edit_id_tipo_novedad").val(id);
  $("#edit_nombre").val(nombre);
  $("#edit_descripcion").val(desc);
  //Ocultar mensajes error
  $("#form_editar_tipo_novedad #msg_error_nombre").fadeOut();
  //Abrir Pop
  $("#modalEditarTipoNovedad").modal("show");
  $('#modalEditarTipoNovedad').on('shown.bs.modal', function (e) {
      $("#edit_nombre").focus();
  });
}

/**
* Funcion encargada de procesar el registro del nuevo tipo de novedad
*/
function guardarNuevo()
{
  var nombre = $("#new_nombre").val();
  var desc = $("#new_descripcion").val();

  //Ocultar mensajes error
  $("#form_nuevo_tipo_novedad #msg_error_nombre").fadeOut();

  //Validar campos requeridos
  if( nombre === "" )
  {
    $("#new_nombre").focus();
    $("#form_nuevo_tipo_novedad #msg_error_nombre").fadeIn();
  }
  else{
    $("#btn_guardar_nuevo").button("loading"); //Cambiar estado del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_tipos_novedades.php",
        data: {
                opcion      : 2,
                nombre      : nombre,
                descripcion : desc
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              $("#modalNuevoTipoNovedad").modal("hide");
              jAlert('Tipo de novedad guardada con éxito', 'Nuevo tipo de novedad', function(){
                recargarTipoNovedades();
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
    });
  }
}

/**
* Funcion encargada de procesar la modificación del tipo de novedad
*/
function guardarModificacion()
{
  var id = $("#edit_id_tipo_novedad").val();
  var nombre = $("#edit_nombre").val();
  var desc = $("#edit_descripcion").val();

  //Ocultar mensajes error
  $("#form_nuevo_tipo_novedad #msg_error_nombre").fadeOut();

  //Validar campos requeridos
  if( nombre === "" )
  {
    $("#edit_nombre").focus();
    $("#form_editar_tipo_novedad #msg_error_nombre").fadeIn();
  }
  else{
    $("#btn_guardar_edit").button("loading"); //Cambiar estado del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_tipos_novedades.php",
        data: {
                opcion    : 3,
                id   : id,
                nombre    : nombre,
                descripcion : desc
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              $("#modalEditarTipoNovedad").modal("hide");
              jAlert('Tipo de novedad actualizada con éxito', 'Editar tipo de novedad', function(){
                recargarTipoNovedades();
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
            $("#btn_guardar_edit").button("reset");//Restaurar boton guardar
        }
    });
  }
}

/**
* Función encargada de borrar el tipo de novedad
*/
function elimnarTipoNovedad(id)
{
  jConfirm('¿Desea borrar el tipo de novedad con ID:'+ id +'?','Eliminar tipo de novedad', function(res){
    if(res)
    {
      $.ajax(
      {
          cache: false,
          type: "POST",
          url: "querys/gestion_tipos_novedades.php",
          data: {
                  opcion    : 4,
                  id   : id,
                },
          dataType: "json",
          success: function(res)
          {
              if( res.status === "OK" )
              {
                jAlert('Tipo de novedad eliminada con éxito', 'Eliminar tipo de novedad', function(){
                  recargarTipoNovedades();
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
  });
}

$(document).ready( function()
{
  $("#tabla_novedades").DataTable({
    responsive: true,
    "language":{
        "url"   :   "extensions/datatables/language/es.json"
    }
  });
});
