/**
* Función encargada de recargar la tabla de tipos de documento
*/
function recargarDatos()
{
  $.ajax(
  {
    cache: false,
    type: "POST",
    url: "querys/gestion_pension.php",
    data: { 
            opcion : 2 
          },
    dataType: "json",
    success: function(res)
    {
      if( res.status === "OK" )
      {
        var datos = [];
        for( var i=0; i < res.pension.length; i++)
        {
            var link_editar = '<a href="#" class="fa fa-pencil-square-o" aria-hidden="true" onclick="editar(\''+ res.pension[i].id +'\',\''+ res.pension[i].nombre +'\')"></a>';
            var link_borrar = '<a href="#" class="fa fa-trash-o" aria-hidden="true" onclick="eliminar(\''+ res.pension[i].id +'\',\''+ res.pension[i].nombre +'\')"></a>';
            datos[i] = [
                            res.pension[i].nombre,
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
  var pension = $("#new_nombre").val();
  //Ocultar mensajes error
  $("#form_nuevo #msg_error_nombre").fadeOut();

  //Validar campos requeridos
  if( pension === "" )
  {
    $("#new_nombre").focus();
    $("#form_nuevo #msg_error_nombre").fadeIn();
  }
  else{
    $("#btn_guardar_nuevo").button("loading"); //Cambiar estado del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_pension.php",
        data: {
                opcion    : 1,
                pension    : pension
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              $("#modalNuevo").modal("hide");
              jAlert('Banco creado con éxito', 'Nuevo Banco', function(){
                recargarDatos();
                $("#new_nombre").val("");
              });
            }else if(res.status === "EXIST" )//Correo existente
            {
              jAlert('El Banco '+ pension +' ya se encuentra registrado', 'Error', function(){
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
function editar(id,nombre)
{
  //Asignar valores a los campos
  $("#edit_id_pension").val(id);
  $("#edit_nombre").val(nombre);
  //Ocultar mensajes error
  $("#form_editar #msg_error_nombre").fadeOut();
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
  var id = $("#edit_id_pension").val();
  var nombre = $("#edit_nombre").val();
  //Ocultar mensajes error
  $("#form_editar #msg_error_nombre").fadeOut();
  //Validar campos requeridos
  if( nombre === "" )
  {
    $("#edit_nombre").focus();
    $("#form_editar #msg_error_nombre").fadeIn();
  }
  else{
    $("#btn_guardar_edit").button("loading"); //Cambiar estado del botón 
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_pension.php",
        data: {
                opcion      : 3,
                id_pension   : id,
                nombre      : nombre
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              $("#modalEditar").modal("hide");
              jAlert('Banco actualizado con éxito', 'Editar Banco', function(){
                recargarDatos();
                $("#edit_nombre").val("");
              });
            }else if(res.status === "EXIST" )//Correo existente
            {
              jAlert('El Banco '+ nombre +' ya se encuentra registrado', 'Error', function(){
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
  jConfirm('¿Desea borrar el Banco:  ' + nombre + ' ?','Eliminar Banco', function(res){
    if(res)
    {
      $.ajax(
      {
          cache: false,
          type: "POST",
          url: "querys/gestion_pension.php",
          data: {
                  opcion      : 4,
                  id_pension   : id
                },
          dataType: "json",
          success: function(res)
          {
              if( res.status === "OK" )
              {
                jAlert('Banco eliminado con éxito', 'Eliminar Banco', function(){
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
