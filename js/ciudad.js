  /**
* Función encargada de recargar la tabla de tipos de documento
*/
function recargarDatos(){
  $.ajax(
  {
    cache: false,
    type: "POST",
    url: "querys/gestion_ciudad.php",
    data: { 
            opcion : 4 
          },
    dataType: "json",
    success: function(res)
    {
      if( res.status === "OK" )
      {
        var datos = [];
        for( var i=0; i < res.ciudad.length; i++)
        {
            var link_editar = '<a href="#" class="fa fa-pencil-square-o" aria-hidden="true" onclick="editar(\''+ res.ciudad[i].id +'\',\''+ res.ciudad[i].nCiudad +'\',\''+ res.ciudad[i].departamento +'\',\''+ res.ciudad[i].pais +'\')"></a>';
            var link_borrar = '<a href="#" class="fa fa-trash-o" aria-hidden="true" onclick="eliminar(\''+ res.ciudad[i].id +'\',\''+ res.ciudad[i].nCiudad +'\')"></a>';
            datos[i] = [
                            res.ciudad[i].nCiudad,
                            res.ciudad[i].nDepartamento,
                            res.ciudad[i].nPais,
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
      url: "querys/gestion_ciudad.php",
      data: { opcion : 1 },
      dataType: "json",
      success: function(res)
      {
          if( res.status === "OK" )
          { //console.log(""+res);
            //lista Paises
            var lista = "";
            for( var i=0; i < res.paises.length; i++ )
            {
              lista += '<option value="'+ res.paises[i].id +'">'+ res.paises[i].nombre +'</option>';
            }
            $("#new_pais").html( lista );
            $('#new_pais').val(1);
            //$(".depto").hide();
            
            //lista Departamentos
            var lista2 = "";
            for( var i=0; i < res.departamentos.length; i++ )
            {
              lista2 += '<option value="'+ res.departamentos[i].id +'">'+ res.departamentos[i].nombre +'</option>';
            }
            $("#new_departamento").html( lista2 );
            //$( "#new_pais" ).change(function() {
              //$(".depto").show();
            //});
            //Resetear campos
            $("#new_ciudad").val("");
            //Ocultar mensajes error
            $("#form_nuevo #msg_error_nombre").fadeOut();
            $("#form_nuevo #msg_error_pais").fadeOut();
            $("#form_nuevo #msg_error_departamento").fadeOut();
            //Abrir PopUp
            $("#modalSpinner").modal("hide");
            $("#modalNuevo").modal("show");
            $('#modalNuevo').on('shown.bs.modal', function (e) {
                $("#new_ciudad").focus();
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
  var ciudad = $("#new_ciudad").val();
  var departamento = $("#new_departamento").val();
  //Ocultar mensajes error
  $("#form_nuevo #msg_error_nombre").fadeOut();
  $("#form_nuevo #msg_error_departamento").fadeOut();
  $("#form_nuevo #msg_error_pais").fadeOut();

  //Validar campos requeridos
  if( ciudad === "" )
  {
    $("#new_ciudad").focus();
    $("#form_nuevo #msg_error_nombre").fadeIn();
  }
  else if( departamento === "null" )
  {
    $("#new_departamento").focus();
    $("#form_nuevo #msg_error_departamento").fadeIn();
  }
  else{
    $("#btn_guardar_nuevo").button("loading"); //Cambiar estado del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_ciudad.php",
        data: {
                opcion       : 2,
                ciudad       : ciudad,
                departamento : departamento
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              $("#modalNuevo").modal("hide");
              jAlert('Ciudad creada con éxito', 'Nueva Ciudad', function(){
                recargarDatos();
                $("#new_ciudad").val("");
              });
            }else if(res.status === "EXIST" )//Correo existente
            {
              jAlert('La Ciudad '+ ciudad +' ya se encuentra registrada', 'Error', function(){
                $("#new_ciudad").focus();
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
function editar(id,nombre,departamento,pais){
  //Consultar perfiles
  $.ajax(
  {
      cache: false,
      type: "POST",
      url: "querys/gestion_ciudad.php",
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

            var lista2 = "";
            for( var i=0; i < res.departamentos.length; i++ )
            {
              lista2 += '<option value="'+ res.departamentos[i].id +'">'+ res.departamentos[i].nombre +'</option>';
            }
            $("#edit_departamento").html( lista2 );
            //Asignar valores a los campos
            $("#edit_nombre").val(nombre);
            $("#edit_pais").val(pais);
            $("#edit_departamento").val(departamento);

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
function guardarEdicion(){
  var id = $("#edit_id_ciudades").val();
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
        url: "querys/gestion_ciudad.php",
        data: {
                opcion      : 3,
                id_ciudad   : id,
                nombre      : nombre,
                pais        : pais
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              $("#modalEditar").modal("hide");
              jAlert('Ciudad actualizado con éxito', 'Editar Ciudad', function(){
                recargarDatos();
                $("#edit_nombre").val("");
              });
            }else if(res.status === "EXIST" )//Correo existente
            {
              jAlert('El Ciudad '+ nombre +' ya se encuentra registrado', 'Error', function(){
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
function eliminar(id,nombre){
  jConfirm('¿Desea borrar el Ciudad:  ' + nombre + ' ?','Eliminar Ciudad', function(res){
    if(res)
    {
      $.ajax(
      {
          cache: false,
          type: "POST",
          url: "querys/gestion_ciudad.php",
          data: {
                  opcion      : 5,
                  id_ciudad   : id
                },
          dataType: "json",
          success: function(res)
          {
              if( res.status === "OK" )
              {
                jAlert('Ciudad eliminado con éxito', 'Eliminar Ciudad', function(){
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

$(document).ready( function(){
  $("#tabla").DataTable({
    responsive: true,
    "language":{
        "url"   :   "extensions/datatables/language/es.json"
    }
  });
});
