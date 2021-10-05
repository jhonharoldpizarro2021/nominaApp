/**
* Función encargada de recargar la tabla de usuarios
*/
function recargarUsuarios()
{
  $.ajax(
  {
    cache: false,
    type: "POST",
    url: "querys/gestion_usuarios.php",
    data: { opcion : 4 },
    dataType: "json",
    success: function(res)
    {
      if( res.status === "OK" )
      {
        var datos = [];
        for( var i=0; i < res.usuarios.length; i++)
        {
            var link_editar = '<a href="#" class="fa fa-pencil-square-o" aria-hidden="true" onclick="modificarUsuario(\''+ res.usuarios[i].id +'\',\''+ res.usuarios[i].nombres +'\',\''+
                              res.usuarios[i].apellidos +'\',\''+ res.usuarios[i].correo +'\',\''+ res.usuarios[i].telefono +'\',\''+ res.usuarios[i].ciudad +'\',\''+
                              res.usuarios[i].password +'\',\''+ res.usuarios[i].id_perfil +'\',\''+ res.usuarios[i].fecha +'\')"></a>';
            var link_borrar = '<a href="#" class="fa fa-trash-o" aria-hidden="true" onclick="elimnarUsuario(\''+ res.usuarios[i].id +'\')"></a>';
            datos[i] = [
                            res.usuarios[i].id,
                            res.usuarios[i].nombres+" "+res.usuarios[i].apellidos,
                            res.usuarios[i].correo,
                            res.usuarios[i].telefono,
                            res.usuarios[i].perfil,
                            link_editar,
                            link_borrar
                        ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_usuarios').DataTable();
        table.destroy();
        $("#tabla_usuarios").DataTable({
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
* Función encargada de gestionar la apertura del PopUp para el ingreso del nuevo usuario
*/
function abrirNuevoUsuario()
{
  //Consultar perfiles
  $.ajax(
  {
      cache: false,
      type: "POST",
      url: "querys/gestion_usuarios.php",
      data: { opcion : 1 },
      dataType: "json",
      success: function(res)
      {
          if( res.status === "OK" )
          {
            var lista = "";
            for( var i=0; i < res.perfiles.length; i++ )
            {
              lista += '<option value="'+ res.perfiles[i].id +'">'+ res.perfiles[i].nombre +'</option>';
            }
            $("#new_perfil").html( lista );
            //Resetear campos
            $("#new_nombre").val("");
            $("#new_apellidos").val("");
            $("#new_telefono").val("");
            $("#new_email").val("");
            $("#new_ciudad").val("");
            $("#new_pass").val("");
            $("#new_perfil").val("null");
            $("#new_fecha").val("");
            //Ocultar mensajes error
            $("#form_nuevo_usuario #msg_error_nombre").fadeOut();
            $("#form_nuevo_usuario #msg_error_apellido").fadeOut();
            $("#form_nuevo_usuario #msg_error_telefono").fadeOut();
            $("#form_nuevo_usuario #msg_error_email").fadeOut();
            $("#form_nuevo_usuario #msg_error_ciudad").fadeOut();
            $("#form_nuevo_usuario #msg_error_password").fadeOut();
            $("#form_nuevo_usuario #msg_error_perfil").fadeOut();
            $("#form_nuevo_usuario #msg_error_fecha").fadeOut();
            //Abrir PopUp
            $("#modalNuevoUsuario").modal("show");
            $('#modalNuevoUsuario').on('shown.bs.modal', function (e) {
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
      }
  });
}

/**
* Función encargada de inicializar y abrir PopUp modificar Usuario
*/
function modificarUsuario(id,nombre,apellido,correo,telefono,ciudad,pass,perfil,fecha)
{
  //Consultar perfiles
  $.ajax(
  {
      cache: false,
      type: "POST",
      url: "querys/gestion_usuarios.php",
      data: { opcion : 1 },
      dataType: "json",
      success: function(res)
      {
          if( res.status === "OK" )
          {
            var lista = "";
            for( var i=0; i < res.perfiles.length; i++ )
            {
              lista += '<option value="'+ res.perfiles[i].id +'">'+ res.perfiles[i].nombre +'</option>';
            }
            $("#edit_perfil").html( lista );
            //Asignar valores a los campos
            $("#edit_id_usuario").val(id);
            $("#edit_nombre").val(nombre);
            $("#edit_apellidos").val(apellido);
            $("#edit_telefono").val(telefono);
            $("#edit_email").val(correo);
            $("#edit_ciudad").val(ciudad);
            $("#edit_pass").val(pass);
            $("#edit_perfil").val(perfil);
            $("#edit_fecha").val(fecha);
            //Ocultar mensajes error
            $("#form_editar_usuario #msg_error_nombre").fadeOut();
            $("#form_editar_usuario #msg_error_apellido").fadeOut();
            $("#form_editar_usuario #msg_error_telefono").fadeOut();
            $("#form_editar_usuario #msg_error_email").fadeOut();
            $("#form_editar_usuario #msg_error_ciudad").fadeOut();
            $("#form_editar_usuario #msg_error_password").fadeOut();
            $("#form_editar_usuario #msg_error_perfil").fadeOut();
            $("#form_editar_usuario #msg_error_fecha").fadeOut();
            //Abrir Pop
            $("#modalEditarUsuario").modal("show");
            $('#modalEditarUsuario').on('shown.bs.modal', function (e) {
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
      }
  });
}

/**
* Funcion encargada de procesar el registro del nuevo usuario
*/
function guardarNuevo()
{
  var nombre = $("#new_nombre").val();
  var apellido = $("#new_apellidos").val();
  var tel = $("#new_telefono").val();
  var email = $("#new_email").val();
  var ciudad = $("#new_ciudad").val();
  var pass = $("#new_pass").val();
  var perfil = $("#new_perfil").val();
  var fecha = $("#new_fecha").val();

  //Ocultar mensajes error
  $("#form_nuevo_usuario #msg_error_nombre").fadeOut();
  $("#form_nuevo_usuario #msg_error_apellido").fadeOut();
  $("#form_nuevo_usuario #msg_error_telefono").fadeOut();
  $("#form_nuevo_usuario #msg_error_email").fadeOut();
  $("#form_nuevo_usuario #msg_error_ciudad").fadeOut();
  $("#form_nuevo_usuario #msg_error_password").fadeOut();
  $("#form_nuevo_usuario #msg_error_perfil").fadeOut();
  $("#form_nuevo_usuario #msg_error_fecha").fadeOut();

  //Validar campos requeridos
  if( nombre === "" )
  {
    $("#new_nombre").focus();
    $("#form_nuevo_usuario #msg_error_nombre").fadeIn();
  }else if( apellido === "")
  {
    $("#new_apellidos").focus();
    $("#form_nuevo_usuario #msg_error_apellido").fadeIn();
  }else if( tel === "")
  {
    $("#new_telefono").focus();
    $("#form_nuevo_usuario #msg_error_telefono").fadeIn();
  }else if( email === "")
  {
    $("#new_email").focus();
    $("#form_nuevo_usuario #msg_error_email").text("Campo requerido");
    $("#form_nuevo_usuario #msg_error_email").fadeIn();
  }else if( !validarEmail(email) )
  {
    $("#new_email").focus();
    $("#form_nuevo_usuario #msg_error_email").text("E-mail inválida");
    $("#form_nuevo_usuario #msg_error_email").fadeIn();
  }else if( ciudad === "")
  {
    $("#new_ciudad").focus();
    $("#form_nuevo_usuario #msg_error_ciudad").fadeIn();
  }else if( pass === "")
  {
    $("#new_pass").focus();
    $("#form_nuevo_usuario #msg_error_password").fadeIn();
  }else if( perfil === "null")
  {
    $("#form_nuevo_usuario #new_perfil").focus();
    $("#form_nuevo_usuario #msg_error_perfil").fadeIn();
  }else if( fecha === "")
  {
    $("#new_fecha").focus();
    $("#form_nuevo_usuario #msg_error_fecha").fadeIn();
  }
  else{
    $("#btn_guardar_nuevo").button("loading"); //Cambiar estado del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_usuarios.php",
        data: {
                opcion    : 2 ,
                nombre    : nombre,
                apellidos : apellido,
                telefono  : tel,
                correo    : email,
                ciudad    : ciudad,
                password  : pass,
                perfil    : perfil,
                fecha     : fecha
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              $("#modalNuevoUsuario").modal("hide");
              jAlert('Usuario guardado con éxito', 'Nuevo Usuario', function(){
                recargarUsuarios();
              });
            }else if(res.status === "EXIST" )//Correo existente
            {
              jAlert('El E-Mail '+ email +' ya se encuentra registrado', 'Error', function(){
                $("#new_email").focus();
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
* Funcion encargada de procesar la modificación del usuario
*/
function guardarModificacion()
{
  var id = $("#edit_id_usuario").val();
  var nombre = $("#edit_nombre").val();
  var apellido = $("#edit_apellidos").val();
  var tel = $("#edit_telefono").val();
  var email = $("#edit_email").val();
  var ciudad = $("#edit_ciudad").val();
  var pass = $("#edit_pass").val();
  var perfil = $("#edit_perfil").val();
  var fecha = $("#edit_fecha").val();

  //Ocultar mensajes error
  $("#form_editar_usuario #msg_error_nombre").fadeOut();
  $("#form_editar_usuario #msg_error_apellido").fadeOut();
  $("#form_editar_usuario #msg_error_telefono").fadeOut();
  $("#form_editar_usuario #msg_error_email").fadeOut();
  $("#form_editar_usuario #msg_error_ciudad").fadeOut();
  $("#form_editar_usuario #msg_error_password").fadeOut();
  $("#form_editar_usuario #msg_error_perfil").fadeOut();
  $("#form_editar_usuario #msg_error_fecha").fadeOut();

  //Validar campos requeridos
  if( nombre === "" )
  {
    $("#edit_nombre").focus();
    $("#form_editar_usuario #msg_error_nombre").fadeIn();
  }else if( apellido === "")
  {
    $("#edit_apellidos").focus();
    $("#form_editar_usuario #msg_error_apellido").fadeIn();
  }else if( tel === "")
  {
    $("#edit_telefono").focus();
    $("#form_editar_usuario #msg_error_telefono").fadeIn();
  }else if( email === "")
  {
    $("#edit_email").focus();
    $("#form_editar_usuario #msg_error_email").text("Campo requerido");
    $("#form_editar_usuario #msg_error_email").fadeIn();
  }else if( !validarEmail(email) )
  {
    $("#edit_email").focus();
    $("#form_editar_usuario #msg_error_email").text("E-mail inválida");
    $("#form_editar_usuario #msg_error_email").fadeIn();
  }else if( ciudad === "")
  {
    $("#edit_ciudad").focus();
    $("#form_editar_usuario #msg_error_ciudad").fadeIn();
  }else if( pass === "")
  {
    $("#edit_pass").focus();
    $("#form_editar_usuario #msg_error_password").fadeIn();
  }else if( perfil === "null")
  {
    $("#edit_perfil").focus();
    $("#form_editar_usuario #msg_error_perfil").fadeIn();
  }else if( fecha === "")
  {
    $("#edit_fecha").focus();
    $("#form_editar_usuario #msg_error_fecha").fadeIn();
  }
  else{
    $("#btn_guardar_edit").button("loading"); //Cambiar estado del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_usuarios.php",
        data: {
                opcion    : 3,
                id_user   : id,
                nombre    : nombre,
                apellidos : apellido,
                telefono  : tel,
                correo    : email,
                ciudad    : ciudad,
                password  : pass,
                perfil    : perfil,
                fecha     : fecha
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              $("#modalEditarUsuario").modal("hide");
              jAlert('Usuario actualizado con éxito', 'Editar Usuario', function(){
                recargarUsuarios();
              });
            }else if(res.status === "EXIST" )//Correo existente
            {
              jAlert('El E-Mail '+ email +' ya se encuentra registrado', 'Error', function(){
                $("#edit_email").focus();
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
function elimnarUsuario(id)
{
  jConfirm('¿Desea borrar el usuario con ID:'+ id +'?','Eliminar usuario', function(res){
    if(res)
    {
      $.ajax(
      {
          cache: false,
          type: "POST",
          url: "querys/gestion_usuarios.php",
          data: {
                  opcion    : 5,
                  id_user   : id,
                },
          dataType: "json",
          success: function(res)
          {
              if( res.status === "OK" )
              {
                jAlert('Usuario eliminado con éxito', 'Eliminar Usuario', function(){
                  recargarUsuarios();
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
  $("#tabla_usuarios").DataTable({
    responsive: true,
    "language":{
        "url"   :   "extensions/datatables/language/es.json"
    }
  });
  //Agregar datapicker
  $("#new_fecha").datepicker({
    language:  'es',
    format: "yyyy-mm-dd"
  });
  $("#edit_fecha").datepicker({
    language:  'es',
    format: "yyyy-mm-dd",
  });
  //Habilitar click sobre iconos del calendario
  $("#edit_fecha_icon").on("click",function(){
    $("#edit_fecha").focus();
  });
  $("#new_fecha_icon").on("click",function(){
    $("#new_fecha").focus();
  });
});
