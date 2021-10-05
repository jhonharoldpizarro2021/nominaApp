  /**
* Función encargada de recargar la tabla de tipos de documento
*/
function recargarDatos(){
  $.ajax(
  {
    cache: false,
    type: "POST",
    url: "querys/gestion_departamento.php",
    data: { 
            opcion : 4 
          },
    dataType: "json",
    success: function(res)
    {
      if( res.status === "OK" )
      {
        var datos = [];
        for( var i=0; i < res.departamento.length; i++)
        {
            var link_editar = '<a href="#" class="fa fa-pencil-square-o" aria-hidden="true" onclick="editar(\''+ res.departamento[i].id +'\',\''+ res.departamento[i].nombre +'\')"></a>';
            var link_borrar = '<a href="#" class="fa fa-trash-o" aria-hidden="true" onclick="eliminar(\''+ res.departamento[i].id +'\',\''+ res.departamento[i].nombre +'\')"></a>';
            datos[i] = [
                            res.departamento[i].nombre,
                            res.departamento[i].pais,
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
* Función encargada de gestionar la apertura del PopUp para el ingreso del nuevo usuario
*/
function abrirNuevo(){
  $("#modalSpinner").modal("show");
  //Consultar perfiles
  $.ajax(
  {
      cache: false,
      type: "POST",
      url: "querys/gestion_departamento.php",
      data: { opcion : 1 },
      dataType: "json",
      success: function(res)
      {
          if( res.status === "OK" )
          { //console.log(""+res);
            //lista Tipo Documentos
            var lista = "";
            for( var i=0; i < res.paises.length; i++ )
            {
              lista += '<option value="'+ res.paises[i].id +'">'+ res.paises[i].nombre +'</option>';
            }
            $("#new_pais").html( lista );
            $('#new_pais').val(1);
            //Resetear campos
            $("#new_departamento").val("");
            //Ocultar mensajes error
            $("#form_nuevo #msg_error_nombre").fadeOut();
            $("#form_nuevo #msg_error_pais").fadeOut();
            //Abrir PopUp
            $("#modalSpinner").modal("hide");
            $("#modalNuevo").modal("show");
            $('#modalNuevo').on('shown.bs.modal', function (e) {
                $("#new_departamento").focus();
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
function guardarNuevo(){
  var departamento = $("#new_departamento").val();
  var pais = $("#new_pais").val();
  //Ocultar mensajes error
  $("#form_nuevo #msg_error_nombre").fadeOut();
  $("#form_nuevo #msg_error_pais").fadeOut();

  //Validar campos requeridos
  if( departamento === "" )
  {
    $("#new_departamento").focus();
    $("#form_nuevo #msg_error_nombre").fadeIn();
  }
  else if( pais === "" )
  {
    $("#new_pais").focus();
    $("#form_nuevo #msg_error_pais").fadeIn();
  }
  else{
    $("#btn_guardar_nuevo").button("loading"); //Cambiar estado del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_departamento.php",
        data: {
                opcion        : 2,
                departamento  : departamento,
                pais          : pais
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              $("#modalNuevo").modal("hide");
              jAlert('Departamento creado con éxito', 'Nuevo departamento', function(){
                recargarDatos();
                $("#new_departamento").val("");
              });
            }else if(res.status === "EXIST" )//Correo existente
            {
              jAlert('El Separtamento '+ departamento +' ya se encuentra registrado', 'Error', function(){
                $("#new_departamento").focus();
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
function editar(id,nombre,pais)
{
  //Consultar perfiles
  $.ajax(
  {
      cache: false,
      type: "POST",
      url: "querys/gestion_departamento.php",
      data: { opcion : 1 },
      dataType: "json",
      success: function(res)
      {
          if( res.status === "OK" )
          {
            var lista = "";
            for( var i=0; i < res.paises.length; i++ )
            {
              lista += '<option value="'+ res.paises[i].id +'">'+ res.paises[i].nombre +'</option>';
            }
            $("#edit_pais").html( lista );
            //Asignar valores a los campos
            $("#edit_nombre").val(nombre);
            $("#edit_pais").val(pais);

            //Ocultar mensajes error
            $("#form_editar #msg_error_nombre").fadeOut();
            $("#form_editar #msg_error_pais").fadeOut();

            //Abrir Pop
            $("#modalEditar").modal("show");
            $('#modalEditar').on('shown.bs.modal', function (e) {
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
* Funcion encargada de procesar la modificación del tipo de documento
*/
function guardarEdicion()
{
  var id = $("#edit_id_departamentoes").val();
  var nombre = $("#edit_nombre").val();
  var pais = $("#edit_pais").val();
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
        url: "querys/gestion_departamento.php",
        data: {
                opcion      : 3,
                id_departamento   : id,
                nombre      : nombre,
                pais        : pais
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              $("#modalEditar").modal("hide");
              jAlert('departamento actualizado con éxito', 'Editar departamento', function(){
                recargarDatos();
                $("#edit_nombre").val("");
              });
            }else if(res.status === "EXIST" )//Correo existente
            {
              jAlert('El departamento '+ nombre +' ya se encuentra registrado', 'Error', function(){
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
  jConfirm('¿Desea borrar el departamento:  ' + nombre + ' ?','Eliminar departamento', function(res){
    if(res)
    {
      $.ajax(
      {
          cache: false,
          type: "POST",
          url: "querys/gestion_departamento.php",
          data: {
                  opcion      : 5,
                  id_departamento   : id
                },
          dataType: "json",
          success: function(res)
          {
              if( res.status === "OK" )
              {
                jAlert('Departamento eliminado con éxito', 'Eliminar Departamento', function(){
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
