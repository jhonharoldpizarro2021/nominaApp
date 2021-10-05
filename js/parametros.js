var formContent = $("#modalNuevo").html();
/**
* Funcion encargada guardar formulario para anexar nuevos registros de parámetros básicos  
*/
function addTipo(){ 
  $("#modalNuevo").modal("hide");
  abrirNuevoTipo();
  $('#modalNuevoTipo').on('hidden.bs.modal', function (e) {
      $("#modalNuevo").modal('show'); // do something...
      $('#modalNuevo').on('shown.bs.modal', function() {
            $("#modalNuevo #new_tipo").focus();
      });
      $("#modalNuevo").html(formContent);
  });
}
/**
* Función encargada de gestionar la apertura del PopUp para el ingreso de la nueva ciudad
*/
function abrirNuevoTipo(){  //Ocultar mensajes error
    $("#form_nuevo #msg_error_tipo").fadeOut();
    //Abrir PopUp
    $("#modalNuevoTipo").modal("show");
    $('#modalNuevoTipo').on('hidden.bs.modal', function (e) {
       $("#modalNuevo").modal('show'); // do something...
       $("#modalNuevo").html(formContent);
       $('#modalNuevo').on('shown.bs.modal', function() {
            $("#new_tipo").focus();
        });
       
      });
}
/**
* Funcion encargada de procesar el registro del nuevo tipo de documento
*/
function guardarNuevoTipo(){
  var tipo = $("#modalNuevoTipo #new_tipo").val();
  //Ocultar mensajes error
  $("#form_nuevo #msg_error_tipo").fadeOut();
  //Validar campos requeridos
  if( tipo === "" )
  {
    $("#modalNuevoTipo #new_tipo").focus();
    $("#form_nuevo #msg_error_tipo").fadeIn();
  }
  else{
    $("#btn_guardar_nuevo_tipo").button("loading"); //Cambiar estado del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_tipo_documentos.php",
        data: {
                opcion  : 1,
                tipo    : tipo
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              jAlert('Tipo de Documento creado con éxito. Ahora puedes elegirlo en la lista del formulario', 'Nuevo Tipo de Documento');
              $("#modalNuevoTipo").modal("hide");
              //Abrir PopUp
              $("#modalNuevo").modal("show");
              $('#modalNuevo').on('shown.bs.modal', function() {
                  $("#new_tipo").focus();
              });
              $("#modalNuevo").html(formContent);
              recargarTipos();
              // recargar la lista de tipos despues de insertar nueva
              function recargarTipos()
              {
                $.ajax(
                {
                    cache: false,
                    type: "POST",
                    url: "querys/gestion_empleados.php",
                    data: { opcion : 1 },
                    dataType: "json",
                    success: function(res)
                    {
                        if( res.status === "OK" )
                        { //console.log(""+res);
                          //lista Tipos de Documento
                          var lista = "";
                          for( var i=0; i < res.tipos.length; i++ )
                          {
                            lista+= '<option value="'+ res.tipos[i].id +'">'+ res.tipos[i].nombre +'</option>';
                          }
                          $("#new_tipo").html( lista );
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
            }else if(res.status === "EXIST" )//dato existente
            {
              jAlert('El Tipo de Documento '+ tipo +' ya se encuentra registrada', 'Error', function(){
                $("#modalNuevaCiudad #new_ciudad").focus();
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
            $("#btn_guardar_nuevo_tipo").button("reset");//Restaurar boton guardar
        }
    });
  }
}
/**
* Funcion encargada guardar formulario para anexar nuevos registros de parámetros básicos  
*/
function addCiudad(){ 
  $("#modalNuevo").modal("hide");
  abrirNuevaCiudad();
  $('#modalNuevaCiudad').on('hidden.bs.modal', function (e) {
      $("#modalNuevo").modal('show'); // do something...
      $("#modalNuevo").html(formContent);
      $('#modalNuevo').on('shown.bs.modal', function() {
          $("#new_ciudadExp").focus();
      });
  });
}
/**
* Función encargada de gestionar la apertura del PopUp para el ingreso de la nueva ciudad
*/
function abrirNuevaCiudad(){ //Consultar perfiles
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
        { //console.log(""+res);  //lista Tipo Documentos
          var lista = "";
          for( var i=0; i < res.paises.length; i++ )
          {
            lista += '<option value="'+ res.paises[i].id +'">'+ res.paises[i].nombre +'</option>';
          }
          $("#new_pais").html( lista );
          //Ocultar mensajes error
          $("#form_nuevo #msg_error_nombre").fadeOut();
          $("#form_nuevo #msg_error_pais").fadeOut();
          //Abrir PopUp
          $("#modalNuevaCiudad").modal("show");
          $('#modalNuevaCiudad').on('shown.bs.modal', function (e) {
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
function guardarNuevaCiudad(){
  var ciudad = $("#modalNuevaCiudad #new_ciudad").val();
  var pais = $("#modalNuevaCiudad #new_pais").val();
  //Ocultar mensajes error
  $("#form_nuevo #msg_error_nombre").fadeOut();
  $("#form_nuevo #msg_error_pais").fadeOut();
  //Validar campos requeridos
  if( ciudad === "" )
  {
    $("#modalNuevaCiudad #new_ciudad").focus();
    $("#form_nuevo #msg_error_nombre").fadeIn();
  }
  else if( pais === "" )
  {
    $("#modalNuevaCiudad #new_pais").focus();
    $("#form_nuevo #msg_error_pais").fadeIn();
  }
  else{
    $("#btn_guardar_nueva_ciudad").button("loading"); //Cambiar estado del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_ciudad.php",
        data: {
                opcion  : 2,
                ciudad  : ciudad,
                pais    : pais
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              jAlert('Ciudad creada con éxito. Ahora puedes elegirla en la lista del formulario', 'Nueva Ciudad');
              $("#modalNuevaCiudad").modal("hide");
              //Abrir PopUp
              $("#modalNuevo").modal("show");
              $("#modalNuevo").html(formContent);
              $('#modalNuevo').on('shown.bs.modal', function() {
                  $("#new_ciudadExp").focus();
              });
              recargarCiudades();
              // recargar la lista de ciudades despues de insertar nueva
              function recargarCiudades()
              {
                $.ajax(
                {
                    cache: false,
                    type: "POST",
                    url: "querys/gestion_empleados.php",
                    data: { opcion : 1 },
                    dataType: "json",
                    success: function(res)
                    {
                        if( res.status === "OK" )
                        { //console.log(""+res);
                          //lista Ciudades
                          var lista = "";
                          for( var i=0; i < res.ciudades.length; i++ )
                          {
                            lista+= '<option value="'+ res.ciudades[i].id +'">'+ res.ciudades[i].nombre +'</option>';
                          }
                          $("#new_ciudadExp").html( lista );
                          $("#new_ciudadNac").html( lista );
                          $("#new_ciudad").html( lista );
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
            }else if(res.status === "EXIST" )//dato existente
            {
              jAlert('La Ciudad '+ ciudad +' ya se encuentra registrada', 'Error', function(){
                $("#modalNuevaCiudad #new_ciudad").focus();
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
            $("#btn_guardar_nueva_ciudad").button("reset");//Restaurar boton guardar
        }
    });
  }
}
/**
* Funcion encargada guardar formulario para anexar nuevos registros de parámetros básicos  
*/
function addPais(){ 
  $("#modalNuevo").modal("hide");
  abrirNuevoPais();
  $('#modalNuevoPais').on('hidden.bs.modal', function (e) {
      $("#modalNuevo").modal('show'); // do something...
      $("#modalNuevo").html(formContent);
  });
}
/**
* Función encargada de gestionar la apertura del PopUp para el ingreso de la nueva ciudad
*/
function abrirNuevoPais(){   //Ocultar mensajes error
    $("#form_nuevo #msg_error_pais").fadeOut();
    //Abrir PopUp
    $("#modalNuevoPais").modal("show");
    $('#modalNuevoPais').on('hidden.bs.modal', function (e) {
       $("#modalNuevo").modal('show'); // do something...
       $("#modalNuevo").html(formContent);
      });
}
/**
* Funcion encargada de procesar el registro del nuevo tipo de documento
*/
function guardarNuevoPais(){
  var pais = $("#modalNuevoPais #new_pais").val();
  //Ocultar mensajes error
  $("#form_nuevo #msg_error_pais").fadeOut();
  //Validar campos requeridos
  if( pais === "" )
  {
    $("#modalNuevoPais #new_pais").focus();
    $("#form_nuevo #msg_error_pais").fadeIn();
  }
  else{
    $("#btn_guardar_nuevo_pais").button("loading"); //Cambiar estado del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_pais.php",
        data: {
                opcion  : 1,
                pais    : pais
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              jAlert('Pais creado con éxito. Ahora puedes elegirlo en la lista del formulario', 'Nuevo Pais');
              $("#modalNuevoPais").modal("hide");
              //Abrir PopUp
              $("#modalNuevo").modal("show");
              $("#modalNuevo").html(formContent);
              recargarPaises();
              // recargar la lista de tipos despues de insertar nueva
              function recargarPaises()
              {
                $.ajax(
                {
                    cache: false,
                    type: "POST",
                    url: "querys/gestion_empleados.php",
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
                            lista+= '<option value="'+ res.paises[i].id +'">'+ res.paises[i].nombre +'</option>';
                          }
                          $("#new_pais").html( lista );
                          $("#new_paisNac").html( lista );
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
            }else if(res.status === "EXIST" )//dato existente
            {
              jAlert('El Pais '+ pais +' ya se encuentra registrado', 'Error', function(){
                $("#modalNuevoPais #new_pais").focus();
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
            $("#btn_guardar_nuevo_pais").button("reset");//Restaurar boton guardar
        }
    });
  }
}
/**
* Funcion encargada guardar formulario para anexar nuevos registros de parámetros básicos  
*/
function addGenero(){ 
  $("#modalNuevo").modal("hide");
  abrirNuevoGenero();
  $('#modalNuevoGenero').on('hidden.bs.modal', function (e) {
      $("#modalNuevo").modal('show'); // do something...
      $("#modalNuevo").html(formContent);
  });
}
/**
* Función encargada de gestionar la apertura del PopUp para el ingreso de la nueva ciudad
*/
function abrirNuevoGenero(){   //Ocultar mensajes error
    $("#form_nuevo #msg_error_genero").fadeOut();
    //Abrir PopUp
    $("#modalNuevoGenero").modal("show");
    $('#modalNuevoGenero').on('hidden.bs.modal', function (e) {
       $("#modalNuevo").modal('show'); // do something...
       $("#modalNuevo").html(formContent);
      });
}
/**
* Funcion encargada de procesar el registro del nuevo tipo de documento
*/
function guardarNuevoGenero(){
  var genero = $("#modalNuevoGenero #new_genero").val();
  //Ocultar mensajes error
  $("#form_nuevo #msg_error_genero").fadeOut();
  //Validar campos requeridos
  if( genero === "" )
  {
    $("#modalNuevoGenero #new_genero").focus();
    $("#form_nuevo #msg_error_genero").fadeIn();
  }
  else{
    $("#btn_guardar_nuevo_genero").button("loading"); //Cambiar estado del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_generos.php",
        data: {
                opcion  : 1,
                genero    : genero
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              jAlert('Genero creado con éxito. Ahora puedes elegirlo en la lista del formulario', 'Nuevo Genero');
              $("#modalNuevoGenero").modal("hide");
              //Abrir PopUp
              $("#modalNuevo").modal("show");
              $("#modalNuevo").html(formContent);
              recargarGeneros();
              // recargar la lista de tipos despues de insertar nueva
              function recargarGeneros()
              {
                $.ajax(
                {
                    cache: false,
                    type: "POST",
                    url: "querys/gestion_empleados.php",
                    data: { opcion : 1 },
                    dataType: "json",
                    success: function(res)
                    {
                        if( res.status === "OK" )
                        { //console.log(""+res);
                          //lista Paises
                          var lista = "";
                          for( var i=0; i < res.generos.length; i++ )
                          {
                            lista+= '<option value="'+ res.generos[i].id +'">'+ res.generos[i].nombre +'</option>';
                          }
                          $("#new_genero").html( lista );
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
            }else if(res.status === "EXIST" )//dato existente
            {
              jAlert('El Genero '+ genero +' ya se encuentra registrado', 'Error', function(){
                $("#modalNuevoGenero #new_pais").focus();
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
            $("#btn_guardar_nuevo_genero").button("reset");//Restaurar boton guardar
        }
    });
  }
}
/**
* Funcion encargada guardar formulario para anexar nuevos registros de parámetros básicos  
*/
function addEstado(){ 
  $("#modalNuevo").modal("hide");
  abrirNuevoEstado();
  $('#modalNuevoEstado').on('hidden.bs.modal', function (e) {
      $("#modalNuevo").modal('show'); // do something...
      $("#modalNuevo").html(formContent);
  });
}
/**
* Función encargada de gestionar la apertura del PopUp para el ingreso de la nueva ciudad
*/
function abrirNuevoEstado(){   //Ocultar mensajes error
    $("#form_nuevo #msg_error_estado").fadeOut();
    //Abrir PopUp
    $("#modalNuevoEstado").modal("show");
    $('#modalNuevoEstado').on('hidden.bs.modal', function (e) {
       $("#modalNuevo").modal('show'); // do something...
       $("#modalNuevo").html(formContent);
      });
}
/**
* Funcion encargada de procesar el registro del nuevo tipo de documento
*/
function guardarNuevoEstado(){
  var estado = $("#modalNuevoEstado #new_estado").val();
  //Ocultar mensajes error
  $("#form_nuevo #msg_error_estado").fadeOut();
  //Validar campos requeridos
  if( estado === "" )
  {
    $("#modalNuevoEstado #new_estado").focus();
    $("#form_nuevo #msg_error_estado").fadeIn();
  }
  else{
    $("#btn_guardar_nuevo_estado").button("loading"); //Cambiar estado del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_estado_civil.php",
        data: {
                opcion  : 1,
                estado    : estado
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              jAlert('Estado Civil creado con éxito. Ahora puedes elegirlo en la lista del formulario', 'Nuevo Estado Civil');
              $("#modalNuevoEstado").modal("hide");
              //Abrir PopUp
              $("#modalNuevo").modal("show");
              $("#modalNuevo").html(formContent);
              recargarEstados();
              // recargar la lista de tipos despues de insertar nueva
              function recargarEstados()
              {
                $.ajax(
                {
                    cache: false,
                    type: "POST",
                    url: "querys/gestion_empleados.php",
                    data: { opcion : 1 },
                    dataType: "json",
                    success: function(res)
                    {
                        if( res.status === "OK" )
                        { //console.log(""+res);
                          //lista Paises
                          var lista = "";
                          for( var i=0; i < res.estados.length; i++ )
                          {
                            lista+= '<option value="'+ res.estados[i].id +'">'+ res.estados[i].nombre +'</option>';
                          }
                          $("#new_estado").html( lista );
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
            }else if(res.status === "EXIST" )//dato existente
            {
              jAlert('El Estado Civil '+ estado +' ya se encuentra registrado', 'Error', function(){
                $("#modalNuevoEstado #new_estado").focus();
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
            $("#btn_guardar_nuevo_estado").button("reset");//Restaurar boton guardar
        }
    });
  }
}
/**
* Funcion encargada guardar formulario para anexar nuevos registros de parámetros básicos  
*/
function addNivel(){ 
  $("#modalNuevo").modal("hide");
  abrirNuevoNivel();
  $('#modalNuevoNivel').on('hidden.bs.modal', function (e) {
      $("#modalNuevo").modal('show'); // do something...
      $("#modalNuevo").html(formContent);
  });
}
/**
* Función encargada de gestionar la apertura del PopUp para el ingreso de la nueva ciudad
*/
function abrirNuevoNivel(){   //Ocultar mensajes error
    $("#form_nuevo #msg_error_nivel").fadeOut();
    //Abrir PopUp
    $("#modalNuevoNivel").modal("show");
    $('#modalNuevoNivel').on('hidden.bs.modal', function (e) {
       $("#modalNuevo").modal('show'); // do something...
       $("#modalNuevo").html(formContent);
      });
}
/**
* Funcion encargada de procesar el registro del nuevo tipo de documento
*/
function guardarNuevoNivel(){
  var nivel = $("#modalNuevoNivel #new_nivel").val();
  //Ocultar mensajes error
  $("#form_nuevo #msg_error_nivel").fadeOut();
  //Validar campos requeridos
  if( nivel === "" )
  {
    $("#modalNuevoNivel #new_nivel").focus();
    $("#form_nuevo #msg_error_nivel").fadeIn();
  }
  else{
    $("#btn_guardar_nuevo_vivel").button("loading"); //Cambiar nivel del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_nivel_estudio.php",
        data: {
                opcion  : 1,
                nivel    : nivel
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              jAlert('Nivel de Estudio creado con éxito. Ahora puedes elegirlo en la lista del formulario', 'Nuevo Nivel de Estudio');
              $("#modalNuevoNivel").modal("hide");
              //Abrir PopUp
              $("#modalNuevo").modal("show");
              $("#modalNuevo").html(formContent);
              recargarNiveles();
              // recargar la lista de tipos despues de insertar nueva
              function recargarNiveles()
              {
                $.ajax(
                {
                    cache: false,
                    type: "POST",
                    url: "querys/gestion_empleados.php",
                    data: { opcion : 1 },
                    dataType: "json",
                    success: function(res)
                    {
                        if( res.status === "OK" )
                        { //console.log(""+res);
                          //lista Paises
                          var lista = "";
                          for( var i=0; i < res.niveles.length; i++ )
                          {
                            lista+= '<option value="'+ res.niveles[i].id +'">'+ res.niveles[i].nombre +'</option>';
                          }
                          $("#new_nivel").html( lista );
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
            }else if(res.status === "EXIST" )//dato existente
            {
              jAlert('El Nivel de Estudio '+ nivel +' ya se encuentra registrado', 'Error', function(){
                $("#modalNuevoNivel #new_nivel").focus();
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
            $("#btn_guardar_nuevo_nivel").button("reset");//Restaurar boton guardar
        }
    });
  }
}
/**
* Funcion encargada guardar formulario para anexar nuevos registros de parámetros básicos  
*/
function addEstrato(){ 
  $("#modalNuevo").modal("hide");
  abrirNuevoEstrato();
  $('#modalNuevoEstrato').on('hidden.bs.modal', function (e) {
      $("#modalNuevo").modal('show'); // do something...
      $("#modalNuevo").html(formContent);
  });
}
/**
* Función encargada de gestionar la apertura del PopUp para el ingreso de la nueva ciudad
*/
function abrirNuevoEstrato(){   //Ocultar mensajes error
    $("#form_nuevo #msg_error_estrato").fadeOut();
    //Abrir PopUp
    $("#modalNuevoEstrato").modal("show");
    $('#modalNuevoEstrato').on('hidden.bs.modal', function (e) {
       $("#modalNuevo").modal('show'); // do something...
       $("#modalNuevo").html(formContent);
      });
}
/**
* Funcion encargada de procesar el registro del nuevo tipo de documento
*/
function guardarNuevoEstrato(){
  var estrato = $("#modalNuevoEstrato #new_estrato").val();
  //Ocultar mensajes error
  $("#form_nuevo #msg_error_estrato").fadeOut();
  //Validar campos requeridos
  if( estrato === "" )
  {
    $("#modalNuevoEstrato #new_estrato").focus();
    $("#form_nuevo #msg_error_estrato").fadeIn();
  }
  else{
    $("#btn_guardar_nuevo_estrato").button("loading"); //Cambiar estrato del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_estratos.php",
        data: {
                opcion  : 1,
                estrato : estrato
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              jAlert('Estrato creado con éxito. Ahora puedes elegirlo en la lista del formulario', 'Nuevo Estrato');
              $("#modalNuevoEstrato").modal("hide");
              //Abrir PopUp
              $("#modalNuevo").modal("show");
              $("#modalNuevo").html(formContent);
              recargarEstratos();
              // recargar la lista de tipos despues de insertar nueva
              function recargarEstratos()
              {
                $.ajax(
                {
                    cache: false,
                    type: "POST",
                    url: "querys/gestion_empleados.php",
                    data: { opcion : 1 },
                    dataType: "json",
                    success: function(res)
                    {
                        if( res.status === "OK" )
                        { //console.log(""+res);
                          //lista Paises
                          var lista = "";
                          for( var i=0; i < res.estratos.length; i++ )
                          {
                            lista+= '<option value="'+ res.estratos[i].id +'">'+ res.estratos[i].nombre +'</option>';
                          }
                          $("#new_estrato").html( lista );
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
            }else if(res.status === "EXIST" )//dato existente
            {
              jAlert('El Estrato '+ estrato +' ya se encuentra registrado', 'Error', function(){
                $("#modalNuevoEstrato #new_estrato").focus();
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
            $("#btn_guardar_nuevo_estrato").button("reset");//Restaurar boton guardar
        }
    });
  }
}
/**
* Funcion encargada guardar formulario para anexar nuevos registros de parámetros básicos  
*/
function addEtnia(){ 
  $("#modalNuevo").modal("hide");
  abrirNuevaEtnia();
  $('#modalNuevaEtnia').on('hidden.bs.modal', function (e) {
      $("#modalNuevo").modal('show'); // do something...
      $("#modalNuevo").html(formContent);
  });
}
/**
* Función encargada de gestionar la apertura del PopUp para el ingreso de la nueva ciudad
*/
function abrirNuevaEtnia(){   //Ocultar mensajes error
    $("#form_nuevo #msg_error_etnia").fadeOut();
    //Abrir PopUp
    $("#modalNuevaEtnia").modal("show");
    $('#modalNuevaEtnia').on('hidden.bs.modal', function (e) {
       $("#modalNuevo").modal('show'); // do something...
       $("#modalNuevo").html(formContent);
      });
}
/**
* Funcion encargada de procesar el registro del nuevo tipo de documento
*/
function guardarNuevaEtnia(){
  var etnia = $("#modalNuevaEtnia #new_etnia").val();
  //Ocultar mensajes error
  $("#form_nuevo #msg_error_etnia").fadeOut();
  //Validar campos requeridos
  if( etnia === "" )
  {
    $("#modalNuevaEtnia #new_etnia").focus();
    $("#form_nuevo #msg_error_etnia").fadeIn();
  }
  else{
    $("#btn_guardar_nueva_etnia").button("loading"); //Cambiar etnia del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_etnias.php",
        data: {
                opcion  : 1,
                etnia : etnia
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              jAlert('Etnia creada con éxito. Ahora puedes elegirla en la lista del formulario', 'Nueva Etnia');
              $("#modalNuevaEtnia").modal("hide");
              //Abrir PopUp
              $("#modalNuevo").modal("show");
              $("#modalNuevo").html(formContent);
              recargarEtnias();
              // recargar la lista de tipos despues de insertar nueva
              function recargarEtnias()
              {
                $.ajax(
                {
                    cache: false,
                    type: "POST",
                    url: "querys/gestion_empleados.php",
                    data: { opcion : 1 },
                    dataType: "json",
                    success: function(res)
                    {
                        if( res.status === "OK" )
                        { //console.log(""+res);
                          //lista Paises
                          var lista = "";
                          for( var i=0; i < res.etnias.length; i++ )
                          {
                            lista+= '<option value="'+ res.etnias[i].id +'">'+ res.etnias[i].nombre +'</option>';
                          }
                          $("#new_etnia").html( lista );
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
            }else if(res.status === "EXIST" )//dato existente
            {
              jAlert('La Etnia '+ etnia +' ya se encuentra registrada', 'Error', function(){
                $("#modalNuevaEtnia #new_etnia").focus();
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
            $("#btn_guardar_nuevo_estrato").button("reset");//Restaurar boton guardar
        }
    });
  }
}
/**
* Funcion encargada guardar formulario para anexar nuevos registros de parámetros básicos  
*/
function addEps(){ 
  $("#modalNuevo").modal("hide");
  abrirNuevaEps();
  $('#modalNuevaEps').on('hidden.bs.modal', function (e) {
      $("#modalNuevo").modal('show'); // do something...
      $("#modalNuevo").html(formContent);
  });
}
/**
* Función encargada de gestionar la apertura del PopUp para el ingreso de la nueva ciudad
*/
function abrirNuevaEps(){   //Ocultar mensajes error
    $("#form_nuevo #msg_error_eps").fadeOut();
    //Abrir PopUp
    $("#modalNuevaEps").modal("show");
    $('#modalNuevaEps').on('hidden.bs.modal', function (e) {
       $("#modalNuevo").modal('show'); // do something...
       $("#modalNuevo").html(formContent);
      });
}
/**
* Funcion encargada de procesar el registro del nuevo tipo de documento
*/
function guardarNuevaEps(){
  var salud = $("#modalNuevaEps #new_eps").val();
  //Ocultar mensajes error
  $("#form_nuevo #msg_error_eps").fadeOut();
  //Validar campos requeridos
  if( salud === "" )
  {
    $("#modalNuevaEtnia #new_eps").focus();
    $("#form_nuevo #msg_error_eps").fadeIn();
  }
  else{
    $("#btn_guardar_nueva_eps").button("loading"); //Cambiar eps del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_salud.php",
        data: {
                opcion    : 1,
                salud     : salud
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              jAlert('EPS creada con éxito. Ahora puedes elegirla en la lista del formulario', 'Nueva EPS');
              $("#modalNuevaEps").modal("hide");
              //Abrir PopUp
              $("#modalNuevo").modal("show");
              $("#modalNuevo").html(formContent);
              recargarEps();
              // recargar la lista de eps despues de insertar nueva
              function recargarEps()
              {
                $.ajax(
                {
                  cache: false,
                  type: "POST",
                  url: "querys/gestion_empleados.php",
                  data: { opcion : 8 },
                  dataType: "json",
                  success: function(res)
                  {
                      if( res.status === "OK" )
                      { //console.log(""+res);
                        //lista Paises
                        var lista = "";
                        for( var i=0; i < res.eps.length; i++ )
                        {
                          lista+= '<option value="'+ res.eps[i].id +'">'+ res.eps[i].nombre +'</option>';
                        }
                        $("#new_eps").html( lista );
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
            }else if(res.status === "EXIST" )//dato existente
            {
              jAlert('La EPS '+ salud +' ya se encuentra registrada', 'Error', function(){
                $("#modalNuevaEps #new_eps").focus();
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
            $("#btn_guardar_nueva_eps").button("reset");//Restaurar boton guardar
        }
    });
  }
}


/**
* Funcion encargada guardar formulario para anexar nuevos registros de parámetros básicos  
*/
function addArl(){ 
  $("#modalNuevo").modal("hide");
  abrirNuevaArl();
  $('#modalNuevaArl').on('hidden.bs.modal', function (e) {
      $("#modalNuevo").modal('show'); // do something...
      $("#modalNuevo").html(formContent);
  });
}
/**
* Función encargada de gestionar la apertura del PopUp para el ingreso de la nueva ciudad
*/
function abrirNuevaArl(){   //Ocultar mensajes error
    $("#form_nuevo #msg_error_arl").fadeOut();
    //Abrir PopUp
    $("#modalNuevaArl").modal("show");
    $('#modalNuevaArl').on('hidden.bs.modal', function (e) {
       $("#modalNuevo").modal('show'); // do something...
       $("#modalNuevo").html(formContent);
      });
}
/**
* Funcion encargada de procesar el registro del nuevo tipo de documento
*/
function guardarNuevaArl(){
  var arl = $("#modalNuevaArl #new_arl").val();
  //Ocultar mensajes error
  $("#form_nuevo #msg_error_arl").fadeOut();
  //Validar campos requeridos
  if( arl === "" )
  {
    $("#modalNuevaEtnia #new_arl").focus();
    $("#form_nuevo #msg_error_arl").fadeIn();
  }
  else{
    $("#btn_guardar_nueva_arl").button("loading"); //Cambiar eps del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_arl.php",
        data: {
                opcion    : 1,
                arl       : arl
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              jAlert('ARL creada con éxito. Ahora puedes elegirla en la lista del formulario', 'Nueva ARL');
              $("#modalNuevaArl").modal("hide");
              //Abrir PopUp
              $("#modalNuevo").modal("show");
              $("#modalNuevo").html(formContent);
              recargarArl();
              // recargar la lista de eps despues de insertar nueva
              function recargarArl()
              {
                $.ajax(
                {
                  cache: false,
                  type: "POST",
                  url: "querys/gestion_empleados.php",
                  data: { opcion : 8 },
                  dataType: "json",
                  success: function(res)
                  {
                      if( res.status === "OK" )
                      { //console.log(""+res);
                        //lista Paises
                        var lista = "";
                        for( var i=0; i < res.arl.length; i++ )
                        {
                          lista+= '<option value="'+ res.arl[i].id +'">'+ res.arl[i].nombre +'</option>';
                        }
                        $("#new_arl").html( lista );
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
            }else if(res.status === "EXIST" )//dato existente
            {
              jAlert('El Arl '+ arl +' ya se encuentra registrada', 'Error', function(){
                $("#modalNuevaArl #new_arl").focus();
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
            $("#btn_guardar_nueva_arl").button("reset");//Restaurar boton guardar
        }
    });
  }
}