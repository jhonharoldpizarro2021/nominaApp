/**
* Función encargada de recargar la tabla de tipos de documento
*/
function recargarDatos()
{
  $.ajax(
  {
    cache: false,
    type: "POST",
    url: "querys/gestion_ccf.php",
    data: { 
            opcion : 2 
          },
    dataType: "json",
    success: function(res)
    {
      if( res.status === "OK" )
      {
        var datos = [];
        for( var i=0; i < res.ccf.length; i++)
        {
            var link_editar = '<a href="#" class="fa fa-pencil-square-o" aria-hidden="true" onclick="editar(\''+ res.ccf[i].id +'\',\''+ res.ccf[i].nombre +'\')"></a>';
            var link_borrar = '<a href="#" class="fa fa-trash-o" aria-hidden="true" onclick="eliminar(\''+ res.ccf[i].id +'\',\''+ res.ccf[i].nombre +'\')"></a>';
            datos[i] = [
                            res.ccf[i].nombre,
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
        jAlert('Su sesión ha caducado, por favor inicie sesión de nueva', 'Sesión expirada', function(){
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
* Funcion encargada de procesar el registro del nueva tipo de documento
*/
function guardarNueva()
{
  var ccf = $("#new_nombre").val();
  //Ocultar mensajes error
  $("#form_nueva #msg_error_nombre").fadeOut();

  //Validar campos requeridos
  if( ccf === "" )
  {
    $("#new_nombre").focus();
    $("#form_nueva #msg_error_nombre").fadeIn();
  }
  else{
    $("#btn_guardar_nueva").button("loading"); //Cambiar estado del botón guardarNueva
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_ccf.php",
        data: {
                opcion    : 1,
                ccf    : ccf
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              $("#modalNuevo").modal("hide");
              jAlert('Caja de Compensacion Familiar creada con éxito', 'Nueva Caja de Compensacion Familiar', function(){
                recargarDatos();
                $("#new_nombre").val("");
              });
            }else if(res.status === "EXIST" )//Correo existente
            {
              jAlert('La Caja de Compensacion Familiar '+ ccf +' ya se encuentra registrada', 'Error', function(){
                $("#new_nombre").focus();
              });
            }else if(res.status === "EXPIRED" )//Sesión finalizada
            {
              jAlert('Su sesión ha caducado, por favor inicie sesión de nueva', 'Sesión expirada', function(){
                window.location = "cerrar_sesion.php";
              });
            }else if( res.status === "ERROR")
            {
              jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
            }
            $("#btn_guardar_nueva").button("reset");//Restaurar boton guardar
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
  $("#edit_id_caja_compensacion").val(id);
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
  var id = $("#edit_id_caja_compensacion").val();
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
        url: "querys/gestion_ccf.php",
        data: {
                opcion      : 3,
                id_caja_compensacion   : id,
                nombre      : nombre
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              $("#modalEditar").modal("hide");
              jAlert('Caja de Compensacion Familiar actualizado con éxito', 'Editar Caja de Compensacion Familiar', function(){
                recargarDatos();
                $("#edit_nombre").val("");
              });
            }else if(res.status === "EXIST" )//Correo existente
            {
              jAlert('La Caja de Compensacion Familiar '+ nombre +' ya se encuentra registrada', 'Error', function(){
                $("#edit_nombre").focus();
              });
            }else if(res.status === "EXPIRED" )//Sesión finalizada
            {
              jAlert('Su sesión ha caducado, por favor inicie sesión de nueva', 'Sesión expirada', function(){
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
  jConfirm('¿Desea borrar la Caja de Compensacion Familiar:  ' + nombre + ' ?','Eliminar Caja de Compensacion Familiar', function(res){
    if(res)
    {
      $.ajax(
      {
          cache: false,
          type: "POST",
          url: "querys/gestion_ccf.php",
          data: {
                  opcion      : 4,
                  id_caja_compensacion   : id
                },
          dataType: "json",
          success: function(res)
          {
              if( res.status === "OK" )
              {
                jAlert('Caja de Compensacion Familiar eliminado con éxito', 'Eliminar Caja de Compensacion Familiar', function(){
                  recargarDatos();
                });
              }else if(res.status === "EXPIRED" )//Sesión finalizada
              {
                jAlert('Su sesión ha caducado, por favor inicie sesión de nueva', 'Sesión expirada', function(){
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
