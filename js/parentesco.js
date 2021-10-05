/**
* Función encargada de recargar la tabla de tipos de documento
*/
function recargarDatos()
{
  $.ajax(
  {
    cache: false,
    type: "POST",
    url: "querys/gestion_parentesco.php",
    data: { 
            opcion : 2 
          },
    dataType: "json",
    success: function(res)
    {
      if( res.status === "OK" )
      {
        var datos = [];
        for( var i=0; i < res.parentesco.length; i++)
        {
            var link_editar = '<a href="#" class="fa fa-pencil-square-o" aria-hidden="true" onclick="editar(\''+ res.parentesco[i].id +'\',\''+ res.parentesco[i].nombre +'\',\''+ res.parentesco[i].descripcion +'\')"></a>';
            var link_borrar = '<a href="#" class="fa fa-trash-o" aria-hidden="true" onclick="eliminar(\''+ res.parentesco[i].id +'\',\''+ res.parentesco[i].nombre +'\')"></a>';
            datos[i] = [
                            res.parentesco[i].nombre,
                            res.parentesco[i].descripcion,
                            link_editar,
                            link_borrar
                        ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla').DataTable();
        table.destroy();
        $("#tabla").DataTable({
            data: datos,
            responsive: true,
            "language":{
                "url"   :   "extensions/datatables/language/es.json"
            }
        });
        $("#new_nombre").val("");
        $("#new_descripcion").val("");
        $("#edit_nombre").val("");
        $("#edit_descripcion").val("");
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
* Funcion encargada de procesar el registro del nuevo tipo de documento
*/
function guardarNuevo()
{
  var nombre = $("#new_nombre").val();
  var descripcion = $("#new_descipcion").val();
  //Ocultar mensajes error
  $("#form_nuevo #msg_error_nombre").fadeOut();
  $("#form_nuevo #msg_error_descripcion").fadeOut();

  //Validar campos requeridos
  if( nombre === "" )
  {
    $("#new_nombre").focus();
    $("#form_nuevo #msg_error_nombre").fadeIn();
  }
  else if( descripcion === "" )
  {
    $("#new_descipcion").focus();
    $("#form_nuevo #msg_error_descripcion").fadeIn();
  }
  else{
    $("#btn_guardar_nuevo").button("loading"); //Cambiar estado del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_parentesco.php",
        data: {
                opcion         : 1,
                nombre         : nombre,
                descripcion    : descripcion
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              $("#modalNuevo").modal("hide");
              jAlert('Parentesco creado con éxito', 'Nuevo Parentesco', function(){
                recargarDatos();
              });
            }else if(res.status === "EXIST" )//Correo existente
            {
              jAlert('El Parentesco '+ nombre +' ya se encuentra registrado', 'Error', function(){
                $("#new_nombre").focus();
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
* Función encargada de inicializar y abrir PopUp modificar Usuario
*/
function editar(id,nombre,descripcion)
{
  //Asignar valores a los campos
  $("#edit_id_estratos").val(id);
  $("#edit_nombre").val(nombre);
  $("#edit_descripcion").val(descripcion);
  //Ocultar mensajes error
  $("#form_editar #msg_error_nombre").fadeOut();
  $("#form_editar #msg_error_descripcion").fadeOut();
  //Abrir Pop
  $("#modalEditar").modal("show");
  $('#modalEditar').on('shown.bs.modal', function (e) {
      $("#edit_nombre").focus();
    });
}
/**
* Funcion encargada de procesar la modificación del tipo de documento
*/
function guardarEdicion()
{
  var id = $("#edit_id_parentesco").val();
  var nombre = $("#edit_nombre").val();
  var descripcion = $("#edit_descripcion").val();
  //Ocultar mensajes error
  $("#form_editar #msg_error_nombre").fadeOut();
  $("#form_editar #msg_error_descripcion").fadeOut();
  //Validar campos requeridos
  if( nombre === "" )
  {
    $("#edit_nombre").focus();
    $("#form_editar #msg_error_nombre").fadeIn();
  }
  else if( descripcion === "" )
  {
    $("#edit_descripcion").focus();
    $("#form_editar #msg_error_descripcion").fadeIn();
  }
  else{
    $("#btn_guardar_edit").button("loading"); //Cambiar estado del botón 
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_parentesco.php",
        data: {
                opcion        : 3,
                id_estratos   : id,
                nombre        : nombre,
                descripcion   : descripcion
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              $("#modalEditar").modal("hide");
              jAlert('Parentesco actualizado con éxito', 'Editar Parentesco', function(){
                recargarDatos();
              });
            }else if(res.status === "EXIST" )//Correo existente
            {
              jAlert('El Parentesco '+ nombre +' ya se encuentra registrado', 'Error', function(){
                $("#edit_nombre").focus();
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
* Función encargada de borrar el usuario
*/
function eliminar(id,nombre)
{
  jConfirm('¿Desea borrar el Parentesco:  ' + nombre + ' ?','Eliminar Parentesco', function(res){
    if(res)
    {
      $.ajax(
      {
          cache: false,
          type: "POST",
          url: "querys/gestion_parentesco.php",
          data: {
                  opcion          : 4,
                  id_parentesco   : id
                },
          dataType: "json",
          success: function(res)
          {
              if( res.status === "OK" )
              {
                jAlert('Parentesco eliminado con éxito', 'Eliminar Parentesco', function(){
                  recargarDatos();
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
  $("#tabla").DataTable({
    responsive: true,
    "language":{
        "url"   :   "extensions/datatables/language/es.json"
    }
  });
});
