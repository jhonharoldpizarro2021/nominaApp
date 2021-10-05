/**
* Función encargada de recargar la tabla de empresas
*/
function recargarDatos(){
  $("#modalSpinner").modal("show"); // muestra spinner
  $.ajax(
  {
    cache: false,
    type: "POST",
    url: "querys/gestion_empresas.php",
    data: { opcion : 4 },
    dataType: "json",
    success: function(res)
    {
      if( res.status === "OK" )
      {
        var datos = [];
        for( var i=0; i < res.empresas.length; i++)
        {
            var link_editar = '<a class="fa fa-pencil-square-o" aria-hidden="true" onclick="modificar(\''+ res.empresas[i].id +'\',\''+ res.empresas[i].nit +'\',\''+ res.empresas[i].nombre +'\',\''+ res.empresas[i].direccion +'\',\''+ res.empresas[i].telefono +'\',\''+ res.empresas[i].email +'\',\''+ res.empresas[i].ciudad +'\')"></a>';
            var link_borrar = '<a class="fa fa-trash-o" aria-hidden="true" onclick="eliminar(\''+ res.empresas[i].id +'\')"></a>';
            datos[i] = [
                            res.empresas[i].nit,
                            res.empresas[i].nombre,
                            res.empresas[i].direccion,
                            res.empresas[i].email,
                            res.empresas[i].telefono,
                            res.empresas[i].nCiudad,
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
        //ocultar spinner
        $("#modalSpinner").modal("hide");
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
  $("#modalSpinner").modal("show"); // muestra spinner
  $.ajax(
  {
      cache: false,
      type: "POST",
      url: "querys/gestion_empresas.php",
      data: { opcion : 1 },
      dataType: "json",
      success: function(res)
      {
          if( res.status === "OK" )
          {
          	// lista paises
            var paises = "";
            for( var i=0; i < res.paises.length; i++ ){
              paises += '<option value="'+ res.paises[i].id +'">'+ res.paises[i].nombre +'</option>';
            }
            $("#new_pais").html( paises );
            $("#new_pais").val( 1 );
            // lista deptos
            var departamentos = "";
            for( var i=0; i < res.departamentos.length; i++ ){
              departamentos += '<option value="'+ res.departamentos[i].id +'">'+ res.departamentos[i].nombre +'</option>';
            }
            $("#new_departamento").html( departamentos );
            // lista ciudades
            var ciudades = "";
            for( var i=0; i < res.ciudades.length; i++ ){
              ciudades += '<option value="'+ res.ciudades[i].id +'">'+ res.ciudades[i].nombre +'</option>';
            }
            $("#new_ciudad").html( ciudades );
            //Resetear campos
            $("#new_nit").val("");
            $("#new_nombre").val("");
            $("#new_direccion").val("");
            $("#new_telefono").val("");
            $("#new_email").val("");
            //Ocultar mensajes error
            $(".alertt").fadeOut();
            //ocultar spinner
            $("#modalSpinner").modal("hide");
            //Abrir PopUp
            $("#modalNuevo").modal("show");
            $('#modalNuevo').on('shown.bs.modal', function (e) {
                $("#new_nit").focus();
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
function guardarNuevo(){
  var nit = $("#new_nit").val();
  var nombre = $("#new_nombre").val();
  var direccion = $("#new_direccion").val();
  var telefono = $("#new_telefono").val();
  var email = $("#new_email").val();
  var ciudad = $("#new_ciudad").val();
  //Ocultar mensajes error
  $(".alert").fadeOut();
  //Validar campos requeridos
  if( nit === "" ){
    $("#new_nit").focus();
    $("#form_nueva_empresa #msg_error_nit").show();
  }
  else if( nombre === "" ){
    $("#new_nombre").focus();
    $("#form_nueva_empresa #msg_error_nombre").show();
  }
  else if( direccion === "") {
    $("#new_direccion").focus();
    $("#form_nueva_empresa #msg_error_direccion").show();
  }
  else if( telefono === ""){
    $("#new_telefono").focus();
    $("#form_nueva_empresa #msg_error_telefono").show();
  }
  else if( email === "") {
    $("#new_email").focus();
    $("#form_nueva_empresa #msg_error_email").text("Campo requerido");
    $("#form_nueva_empresa #msg_error_email").show();
  }
  else if( !validarEmail(email) ) {
    $("#new_email").focus();
    $("#form_nueva_empresa #msg_error_email").text("E-mail inválida");
    $("#form_nueva_empresa #msg_error_email").show();
  }
  else if( ciudad === "") {
    $("#new_ciudad").focus();
    $("#form_nueva_empresa #msg_error_ciudad").fadeIn();
  }
  else {
    $("#btn_guardar_nuevo").button("loading"); //Cambiar estado del botón guardarNuevo
    $("#modalSpinner").modal("show"); // muestra spinner
    $.ajax(
    {
	    cache: false,
	    type: "POST",
	    url: "querys/gestion_empresas.php",
	    data: {
	            opcion    : 2 ,
	            nit 	  : nit,
	            nombre    : nombre,
	            direccion : direccion,
	            telefono  : telefono,
	            email     : email,
	            ciudad    : ciudad
	          },
	    dataType: "json",
	    success: function(res)
	    {
	        if( res.status === "OK" )
	        {
            $("#modalSpinner").modal("hide"); //ocultar spinner
	          $("#modalNuevo").modal("hide");
	          jAlert('Empresa Creada con éxito', 'Nueva Empresa', function(){
	            recargarDatos();

	          });
	        }else if(res.status === "EXIST" )//Correo existente
	        {
              $("#modalSpinner").modal("hide");  //ocultar spinner
	          jAlert('El E-Mail '+ email +' ya se encuentra registrado', 'Error', function(){
	            $("#new_email").focus();
	          });
	        }else if(res.status === "EXPIRED" )//Sesión finalizada
	        {
	       	  $("#modalSpinner").modal("hide"); //ocultar spinner;
	          jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
	            window.location = "cerrar_sesion.php";
	          });
	        }else if( res.status === "ERROR")
	        {
	          jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
	        }
	        
	    }
    });
    $("#btn_guardar_nuevo").button("reset");//Restaurar boton guardar
  }
}

/**
* Función encargada de inicializar y abrir PopUp modificar Usuario
*/
function modificar(id,nit,nombre,direccion,telefono,email,ciudad) { 
  $("#modalSpinner").modal("show");	//muestra spinner
  $.ajax(
  {
      cache: false,
      type: "POST",
      url: "querys/gestion_empresas.php",
      data: { opcion : 1 },
      dataType: "json",
      success: function(res)
      {
          if( res.status === "OK" )
          {
            // lista paises
            var paises = "";
            for( var i=0; i < res.paises.length; i++ ){
              paises += '<option value="'+ res.paises[i].id +'">'+ res.paises[i].nombre +'</option>';
            }
            $("#edit_pais").html( paises );
            $("#edit_pais").val( 1 );
            // lista deptos
            var departamentos = "";
            for( var i=0; i < res.departamentos.length; i++ ){
              departamentos += '<option value="'+ res.departamentos[i].id +'">'+ res.departamentos[i].nombre +'</option>';
            }
            $("#edit_departamento").html( departamentos );
            // lista ciudades
            var ciudades = "";
            for( var i=0; i < res.ciudades.length; i++ ){
              ciudades += '<option value="'+ res.ciudades[i].id +'">'+ res.ciudades[i].nombre +'</option>';
            }
            $("#edit_ciudad").html( ciudades );
            //Asignar valores a los campos
            $("#edit_id_empresa").val(id);
            $("#edit_nit").val(nit);
            $("#edit_nombre").val(nombre);
            $("#edit_direccion").val(direccion);
            $("#edit_telefono").val(telefono);
            $("#edit_email").val(email);
            $("#edit_ciudad").val(ciudad);
            //Ocultar mensajes error
            $(".alertt").fadeOut();
            //ocultar spinner
            $("#modalSpinner").modal("hide");
            //Abrir PopUp
            $("#modalEditar").modal("show");
            $('#modalEditar').on('shown.bs.modal', function (e) {
                $("#edit_nit").focus();
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
* Funcion encargada de procesar la modificación del usuario
*/
function guardarEdicion(){
  var id = $("#edit_id_empresa").val();
  var nit = $("#edit_nit").val();
  var nombre = $("#edit_nombre").val();
  var direccion = $("#edit_direccion").val();
  var telefono = $("#edit_telefono").val();
  var email = $("#edit_email").val();
  var ciudad = $("#edit_ciudad").val();
  //Ocultar mensajes error
  $(".alert").fadeOut();
  //Validar campos requeridos
  if( nit === "" ){
    $("#edit_nit").focus();
    $("#form_editar_empresa #msg_error_nit").show();
  }
  else if( nombre === "" ){
    $("#edit_nombre").focus();
    $("#form_editar_empresa #msg_error_nombre").show();
  }
  else if( direccion === "") {
    $("#edit_direccion").focus();
    $("#form_editar_empresa #msg_error_direccion").show();
  }
  else if( telefono === ""){
    $("#edit_telefono").focus();
    $("#form_editar_empresa #msg_error_telefono").show();
  }
  else if( email === "") {
    $("#edit_email").focus();
    $("#form_editar_empresa #msg_error_email").text("Campo requerido");
    $("#form_editar_empresa #msg_error_email").show();
  }
  else if( !validarEmail(email) ) {
    $("#edit_email").focus();
    $("#form_editar_empresa #msg_error_email").text("E-mail inválida");
    $("#form_editar_empresa #msg_error_email").show();
  }
  else if( ciudad === "") {
    $("#edit_ciudad").focus();
    $("#form_editar_empresa #msg_error_ciudad").fadeIn();
  }
  else {
    $("#btn_guardar_edit").button("loading"); //Cambiar estado del botón guardarNuevo
    $("#modalSpinner").modal("show"); // muestra spinner
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_empresas.php",
        data: {
                opcion    : 3,
                id   	  : id,
                nit 	  : nit,
                nombre    : nombre,
                direccion : direccion,
                telefono  : telefono,
                correo    : email,
                ciudad    : ciudad
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              $("#modalSpinner").modal("hide"); //ocultar spinner
              $("#modalEditar").modal("hide");
              jAlert('Usuario actualizado con éxito', 'Editar Usuario', function(){
                recargarDatos();
              });
            }else if(res.status === "EXIST" )//Correo existente
            {
              //ocultar spinner
              $("#modalSpinner").modal("hide");
              jAlert('El E-Mail '+ email +' ya se encuentra registrado', 'Error', function(){
                $("#edit_email").focus();
              });
            }else if(res.status === "EXPIRED" )//Sesión finalizada
            {
              //ocultar spinner
              $("#modalSpinner").modal("hide");
              jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
                window.location = "cerrar_sesion.php";
              });
            }else if( res.status === "ERROR")
            {
              //ocultar spinner
              $("#modalSpinner").modal("hide");
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
function eliminar(id)
{
  jConfirm('¿Desea borrar la empresa con ID:'+ id +'?','Eliminar Empresa', function(res){
    if(res)
    {
      //mostar spinner
      $("#modalSpinner").modal("show");
      $.ajax(
      {
          cache: false,
          type: "POST",
          url: "querys/gestion_empresas.php",
          data: {
                  opcion    : 5,
                  id   : id,
                },
          dataType: "json",
          success: function(res)
          {
              if( res.status === "OK" )
              {
              	//ocultar spinner
            	$("#modalSpinner").modal("hide");
                jAlert('Empresa eliminada con éxito', 'Eliminar Empresa', function(){
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
