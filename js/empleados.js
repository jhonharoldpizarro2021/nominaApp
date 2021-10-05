/*  
** VARIALES GLOBALES PARA SEGUIMIENTO Y RELACION DE TABLA empleados CON TABLA afiliacion_empleado_salud 
*/
var id = 0;
var doc = "";
var name = "";
var lastName = "";
/**
* Función encargada de recargar la tabla de empleados
*/
function recargarDatos(){
  $("#modalSpinner").modal("show"); // muestra spinner
  $.ajax(
  {
    cache: false,
    type: "POST",
    url: "querys/gestion_empleados.php",
    data: { opcion : 4 },
    dataType: "json",
    success: function(res)
    {
      if( res.status === "OK" )
      {
        var datos = [];
        for( var i=0; i < res.empleados.length; i++)
        {
            var link_ver = '<a  class="fa fa-eye" aria-hidden="true" onclick="ver(\''+ res.empleados[i].id +'\',\''+ res.empleados[i].nombre +'\',\''+ res.empleados[i].nombre2 +'\',\''+ res.empleados[i].apellido +'\',\''+ res.empleados[i].apellido2 +'\',\''+ res.empleados[i].tipo +'\',\''+ res.empleados[i].documento +'\',\''+ res.empleados[i].fechaExp +'\',\''+ res.empleados[i].ciudadExp +'\',\''+ res.empleados[i].fechaNac +'\',\''+ res.empleados[i].ciudadNac +'\',\''+ res.empleados[i].paisNac +'\',\''+ res.empleados[i].genero +'\',\''+ res.empleados[i].estado +'\',\''+ res.empleados[i].nivel +'\',\''+ res.empleados[i].titulo +'\',\''+ res.empleados[i].direccion +'\',\''+ res.empleados[i].barrio +'\',\''+ res.empleados[i].estrato +'\',\''+ res.empleados[i].ciudad +'\',\''+ res.empleados[i].telefono +'\',\''+ res.empleados[i].celular +'\',\''+ res.empleados[i].email +'\',\''+ res.empleados[i].etnia +'\',\''+ res.empleados[i].comentario +'\')"></a>';
            /*
            // SI LA EPS ARL PENSION CAJA ESTA REGISTRADA NO MUESTRA EL ICONO, 
            // SI FALTA MUESTRA EL ICONO CORRESPONDIENTE EN COLOR NARANJA O ROJO
            // AL DAR CLIC PERMITE AGREGARLA
            // SI ESTAN TODAS QUE MUESTRE UN ICONO DE VERIFICACION
            */
            link_segSoc = '';
            link_segSoc += res.empleados[i].eps == 1 ? "" : '<i class="fa fa-ambulance fa-fw" data-toggle="tooltip" data-placement="top" title="E.P.S. Pendiente"></i>';
            link_segSoc += res.empleados[i].arl == 1 ? "" : '</i> <i class="fa fa-medkit fa-fw" data-toggle="tooltip" data-placement="top" title="A.R.L. Pendiente"></i>';
            link_segSoc += res.empleados[i].pension == 1 ? "" : '<i class="fa fa-wheelchair fa-fw"  data-toggle="tooltip" data-placement="top" title="Fondo Pensiones Pendiente"></i>';
            link_segSoc += res.empleados[i].caja == 1 ? "" : '<i class="fa fa-heartbeat fa-fw" data-toggle="tooltip" data-placement="top" title="Caja Compensación Pendiente"></i>';
            if( link_segSoc === '' )
            {
             link_segSoc = '<i class="fa fa-check" aria-hidden="true"></i>';
            }

            var link_editar = '<a  class="fa fa-pencil-square-o" aria-hidden="true" onclick="editar(\''+ res.empleados[i].id +'\',\''+ res.empleados[i].nombre +'\',\''+ res.empleados[i].nombre2 +'\',\''+ res.empleados[i].apellido +'\',\''+ res.empleados[i].apellido2 +'\',\''+ res.empleados[i].IDtipo +'\',\''+ res.empleados[i].documento +'\',\''+ res.empleados[i].fechaExp +'\',\''+ res.empleados[i].IDciudadExp +'\',\''+ res.empleados[i].fechaNac +'\',\''+ res.empleados[i].IDciudadNac +'\',\''+ res.empleados[i].IDpaisNac +'\',\''+ res.empleados[i].IDgenero +'\',\''+ res.empleados[i].IDestado +'\',\''+ res.empleados[i].IDnivel +'\',\''+ res.empleados[i].titulo +'\',\''+ res.empleados[i].direccion +'\',\''+ res.empleados[i].barrio +'\',\''+ res.empleados[i].IDestrato +'\',\''+ res.empleados[i].IDciudad +'\',\''+ res.empleados[i].telefono +'\',\''+ res.empleados[i].celular +'\',\''+ res.empleados[i].email +'\',\''+ res.empleados[i].IDetnia +'\',\''+ res.empleados[i].comentario +'\')"></a>';
            var link_borrar = '<a  class="fa fa-trash-o" aria-hidden="true" onclick="eliminar(\''+ res.empleados[i].id +'\',\''+ res.empleados[i].documento +'\',\''+ res.empleados[i].nombre +'\',\''+ res.empleados[i].apellido +'\')"></a>';
            datos[i] = [
                            link_ver,
                            res.empleados[i].nombre +" "+ res.empleados[i].nombre2 +" "+ res.empleados[i].apellido +" "+ res.empleados[i].apellido2,
                            res.empleados[i].documento,
                            res.empleados[i].telefono,
                            res.empleados[i].celular,
                            res.empleados[i].email,
                            link_segSoc,
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
        $("#modalSpinner").modal("hide"); //ocultar spinner
      }
      else if(res.status === "EXPIRED" )//Sesión finalizada
      {
        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }
      else if( res.status === "ERROR")
      {
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
}
/**
* Función encargada de gestionar la apertura del PopUp para el ingreso del nuevo Empleado
*/
function abrirNuevo(){
  $("#modalSpinner").modal("show"); // muestra spinner
  //Consultar perfiles
  $.ajax({
    cache: false,
    type: "POST",
    url: "querys/gestion_empleados.php",
    data: { opcion : 1 },
    dataType: "json",
    success: function(res) {
      if( res.status === "OK" ){ 
        //lista Tipo Documentos
        var lista = "";
        for( var i=0; i < res.tipos.length; i++ ){
          lista += '<option value="'+ res.tipos[i].id +'">'+ res.tipos[i].nombre +'</option>';
        }
        $("#new_tipo").html( lista );
        //lista Generos
        var lista2 = "";
        for( var i=0; i < res.generos.length; i++ ){
          lista2 += '<option value="'+ res.generos[i].id +'">'+ res.generos[i].nombre +'</option>';
        }
        $("#new_genero").html( lista2 );
        //lista Estados Civiles
        var lista3 = "";
        for( var i=0; i < res.estados.length; i++ ){
          lista3 += '<option value="'+ res.estados[i].id +'">'+ res.estados[i].nombre +'</option>';
        }
        $("#new_estado").html( lista3 );
        //lista Niveles Estudio
        var lista4 = "";
        for( var i=0; i < res.niveles.length; i++ ){
          lista4 += '<option value="'+ res.niveles[i].id +'">'+ res.niveles[i].nombre +'</option>';
        }
        $("#new_nivel").html( lista4 );
        //lista Estratos
        var lista5 = "";
        for( var i=0; i < res.estratos.length; i++ ){
          lista5 += '<option value="'+ res.estratos[i].id +'">'+ res.estratos[i].nombre +'</option>';
        }
        $("#new_estrato").html( lista5 );
        //lista Etnias
        var lista6 = "";
        for( var i=0; i < res.etnias.length; i++ ){
          lista6 += '<option value="'+ res.etnias[i].id +'">'+ res.etnias[i].nombre +'</option>';
        }
        $("#new_etnia").html( lista6 );
        //lista Ciudades
        var lista7 = "";
        for( var i=0; i < res.ciudades.length; i++ ){
          lista7 += '<option value="'+ res.ciudades[i].id +'">'+ res.ciudades[i].nombre +'</option>';
        }
        $("#new_ciudadExp").html( lista7 );
        $("#new_ciudadNac").html( lista7 );
        $("#new_ciudad").html( lista7 );
        //lista Paises
        var lista8 = "";
        for( var i=0; i < res.paises.length; i++ ){
          lista8 += '<option value="'+ res.paises[i].id +'">'+ res.paises[i].nombre +'</option>';
        }
        $("#new_paisNac").html( lista8 );
        //Resetear campos
        $("#new_nombre").val("");
        $("#new_nombre2").val("");
        $("#new_apellido").val("");
        $("#new_apellido2").val("");
        $("#new_documento").val("");
        $("#new_documento_v").val("");
        $("#new_fechaExp").val("");
        $("#new_fechaNac").val("");
        $("#new_titulo").val("");
        $("#new_direccion").val("");
        $("#new_barrio").val("");
        $("#new_telefono").val("");
        $("#new_celular").val("");
        $("#new_email").val("");
        $("#new_comentario").val("");
        $('#new_fechaExp').mask('00-00-0000');
        $('#new_fechaNac').mask('00-00-0000');
        //Ocultar mensajes error
        $("form .alert").fadeOut();
        //Ocultar campo validar doc
        $("#form_nuevo #new_documento_v").hide(500);
        $("#modalSpinner").modal("hide"); // oculta spinner
        // muestra modal
        $("#modalNuevo").modal("show");
        $('#modalNuevo').on('shown.bs.modal', function() {
          if (  $("#new_documento").val() === "" ){
            $("#new_documento").focus();
          }
        });
      }
      else if(res.status === "EXPIRED" ){
        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }
      else if( res.status === "ERROR"){
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
}
/**
* Funcion encargada de procesar el registro del nuevo Empleado
*/
function guardarNuevo(){
  var nombre = $("#new_nombre").val();
  var nombre2 = $("#new_nombre2").val();
  var apellido = $("#new_apellido").val();
  var apellido2 = $("#new_apellido2").val();
  var tipo = $("#new_tipo").val();
  var documento = $("#new_documento_v").val();
  var fechaExp = $("#new_fechaExp").val();
  var fechae_array = fechaExp.split("-");
  var fecha_exp = fechae_array[2] +"-"+ fechae_array[1] +"-"+ fechae_array[0]; //yyyy-mm-dd
  var ciudadExp = $("#new_ciudadExp").val();
  var fechaNac = $("#new_fechaNac").val();
  var fechan_array = fechaNac.split("-");
  var fecha_nac = fechan_array[2] +"-"+ fechan_array[1] +"-"+ fechan_array[0]; //yyyy-mm-dd
  var ciudadNac = $("#new_ciudadNac").val();
  var paisNac = $("#new_paisNac").val();
  var genero = $("#new_genero").val();
  var estado = $("#new_estado").val();
  var nivel = $("#new_nivel").val();
  var titulo = $("#new_titulo").val();
  var direccion = $("#new_direccion").val();
  var barrio = $("#new_barrio").val();
  var estrato = $("#new_estrato").val();
  var ciudad = $("#new_ciudad").val();
  var telefono = $("#new_telefono").val();
  var celular = $("#new_celular").val();
  var email = $("#new_email").val();
  var etnia = $("#new_etnia").val();
  var comentario = $("#new_comentario").val();
  var aExp = fechae_array[2];
  var aNac = fechan_array[2];
  nacVsExp(aExp,aNac);
  //Validar campos requeridos
  if( documento === ""){
    $("#new_documento").focus();
    $("#form_nuevo #msg_error_documento").show();
  }
  else if( tipo === "null"){
    $("#new_tipo").focus();
    $("#form_nuevo #msg_error_tipo").show();
  }
  else if( fechaExp === ""){
    $("#new_fechaExp").focus();
    $("#form_nuevo #msg_error_fechaExp").show();
  }
  else if( ciudadExp === "null"){
    $("#new_ciudadExp").focus();
    $("#form_nuevo #msg_error_ciudadExp").show();
  }
  else if( nombre === "" ){
    $("#new_nombre").focus();
    $("#form_nuevo #msg_error_nombre").show();
  }
  else if( apellido === ""){
    $("#new_apellido").focus();
    $("#form_nuevo #msg_error_apellido").show();
  }
  else if( email === ""){
    $("#new_email").focus();
    $("#form_nuevo #msg_error_email").text("Campo requerido");
    $("#form_nuevo #msg_error_email").show();
  }
  else if( !validarEmail(email) ){
    $("#new_email").focus();
    $("#form_nuevo #msg_error_email").text("E-mail inválida");
    $("#form_nuevo #msg_error_email").show();
  }
  else if( fechaNac === ""){
    $("#new_fechaNac").focus();
    $("#form_nuevo #msg_error_fechaNac").show();
  }
  else if( ciudadNac === "null")
  {
    $("#new_ciudadNac").focus();
    $("#form_nuevo #msg_error_ciudadNac").show();
  }
  else if( paisNac === "null"){
    $("#new_paisNac").focus();
    $("#form_nuevo #msg_error_paisNac").show();
  }
  else if( genero === "null"){
    $("#new_genero").focus();
    $("#form_nuevo #msg_error_genero").show();
  }
  else if( estado === "null"){
    $("#new_estado").focus();
    $("#form_nuevo #msg_error_estado").show();
  }
  else if( nivel === "null"){
    $("#new_nivel").focus();
    $("#form_nuevo #msg_error_nivel").show();
  }
  else if( direccion === ""){
    $("#new_direccion").focus();
    $("#form_nuevo #msg_error_direccion").show();
  }
  else if( barrio === ""){
    $("#new_barrio").focus();
    $("#form_nuevo #msg_error_barrio").show();
  }
  else if( estrato === "null"){
    $("#new_estrato").focus();
    $("#form_nuevo #msg_error_estrato").show();
  }
  else if( ciudad === "null"){
    $("#new_ciudad").focus();
    $("#form_nuevo #msg_error_ciudad").show();
  }
  else if( celular === "")
  {
    $("#new_celular").focus();
    $("#form_nuevo #msg_error_celular").show();
  }
  else if( email === "")
  {
    $("#new_email").focus();
    $("#form_nuevo #msg_error_email").text("Campo requerido");
    $("#form_nuevo #msg_error_email").show();
  }
  else if( !validarEmail(email) )
  {
    $("#new_email").focus();
    $("#form_nuevo #msg_error_email").text("E-mail inválida");
    $("#form_nuevo #msg_error_email").show();
  }
  else if( etnia === "null")
  {
    $("#new_etnia").focus();
    $("#form_nuevo #msg_error_etnia").show();
  }
  else
  {
    jConfirm('<form id="form_v" role="form"><div class="row form-group"><label class="col-sm-3" for="v_nombre">Primer Nombre:</label><div class="col-sm-9"><input type="text" id="v_nombre" name="v_nombre" class="form-control" value="'+nombre+'"></div></div><div class="row form-group"><label class="col-sm-3" for="v_nombre2">Segundo Nombre:</label><div class="col-sm-9"><input type="text" id="v_nombre2" name="v_nombre2" class="form-control" value="'+nombre2+'"></div></div><div class="row form-group"><label class="col-sm-3" for="v_apellido">Primer Apellido:</label><div class="col-sm-9"><input type="text" id="v_apellido" name="v_apellido" class="form-control" value="'+apellido+'"></div></div><div class="row form-group"><label class="col-sm-3" for="v_apellido2">Segundo Apellido:</label><div class="col-sm-9"><input type="text" id="v_apellido2" name="v_apellido2" class="form-control" value="'+apellido2+'"></div></div><div class="row form-group"><label class="col-sm-3" for="v_documento">Numero Documento:</label><div class="col-sm-9"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+documento+'"></div></div></form>', 'Los datos son correctos?', function(r) {     
      if(r)
        {
          save();
        }
     });
    function save(){
      $(".btn_guardar_nuevo").button("loading"); //Cambiar estado del botón guardarNuevo
      $("#modalSpinner").modal("show"); // muestra spinner
      $.ajax({
        cache: false,
        type: "POST",
        url: "querys/gestion_empleados.php",
        data: {
                opcion      : 2 ,
                tipo        : tipo,
                documento   : documento,
                nombre      : nombre,
                nombre2     : nombre2,
                apellido    : apellido,
                apellido2   : apellido2,
                ciudadExp   : ciudadExp,
                fecha_exp   : fecha_exp,
                fecha_nac   : fecha_nac,
                ciudadNac   : ciudadNac,
                paisNac     : paisNac,
                genero      : genero,
                estado      : estado,
                nivel       : nivel,
                titulo      : titulo,
                direccion   : direccion,
                barrio      : barrio,
                estrato     : estrato,
                ciudad      : ciudad,
                telefono    : telefono,
                celular     : celular,
                email       : email,
                etnia       : etnia,
                comentario  : comentario
              },
        dataType: "json",
        success: function(res){
          if( res.status === "OK" ){
            jAlert('Empleado guardado con éxito. Ahora puedes agregar los datos de Seguridad Social', 'Nuevo Empleado', function(e){
              id = res.id;
              doc = documento;
              name = nombre;
              lastName = apellido;
              agregarEps(id,doc,name,lastName);
              agregarArl(id,doc,name,lastName);
              agregarPension(id,doc,name,lastName);
              agregarCaja(id,doc,name,lastName);
              agregarReferencia(id,doc,name,lastName);
              agregarEmpresa(id,doc,name,lastName);
              recargarDatos();
              /** 
              *  ACTIVA FORMULARIOS SEGURIDAD SOCIAL
              */
              $('#mytabs a[href="#datosEps"]').tab('show');
              $('#mytabs li').removeClass("disabledTab");
              $('#mytabs li:nth-child(1)').addClass("disabledTab");
              $("#modalSpinner").modal("hide"); //ocultar spinner
            });
            
          }
          else if(res.status === "EXIST" )//Correo existente
          {
            jAlert('El documento '+ documento +' ya se encuentra registrado', 'Error', function(){
              $("#new_documento").focus();
            });
          }
          else if(res.status === "EXPIRED" )//Sesión finalizada
          {
            jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
              window.location = "cerrar_sesion.php";
            });
          }
          else if( res.status === "ERROR")
          {
            jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
          }
          $(".btn_guardar_nuevo").button("reset");//Restaurar boton guardar
        }
      });
    }
  }
}
/**
* Función encargada de validad que el documento no esta registrado
*/
function validarDoc(){
  //hide error msg
  $("#form_nuevo #msg_error_documento_r").hide();
  //hide validation input for slow conections
  $("#form_nuevo #new_documento_v").hide(500);
  // hide error msg when press backspace
  $('#new_documento').keyup(function(e){ if(e.keyCode == 8) $("#form_nuevo #msg_validacion").hide(500);}) 
  // set variable
  var documento = $("#new_documento").val();
  // campo vacio
  if( documento === "" ){
      $("#form_nuevo #msg_error_documento_r").hide();
      $("#form_nuevo #msg_error_documento").show(500);
      $("#form_nuevo #new_documento_v").show(500);
      $('#new_documento').focus();      
    }
  // valida documento 
  else if ( documento != "" ){
    $("#form_nuevo #msg_error_documento_r").hide();
    $("#form_nuevo #msg_error_documento").hide(500);
    $("#form_nuevo #msg_validacion").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i> Validando Documento').show(500);  
    $.ajax( {
      cache: false,
      type: "POST",
      url: "querys/gestion_empleados.php",
      data: {
              opcion    : 6,
              documento : documento,
            },
      dataType: "json",
      success: function(res){
        if( res.status === "EXIST" ) 
        {
          $("#form_nuevo #msg_validacion").hide(500);
          $("#form_nuevo #msg_error_validacion").show(500);
            jConfirm('El Usuario ya Existe, desea actualizar los datos', 'El Usuario ya Existe', function(r) {     
              if(r)
                {
                  existe(documento);
                }
            });
            function existe(documento){
                  var documento = documento;
                  $("#modalNuevo").modal("hide");
                  $("#modalSpinner").modal("show"); // muestra spinner
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
                      {
                        //lista Tipo Documentos
                        var lista = "";
                        for( var i=0; i < res.tipos.length; i++ )
                        {
                          lista += '<option value="'+ res.tipos[i].id +'">'+ res.tipos[i].nombre +'</option>';
                        }
                        $("#edit_tipo").html( lista );
                        //lista Generos
                        var lista2 = "";
                        for( var i=0; i < res.generos.length; i++ )
                        {
                          lista2 += '<option value="'+ res.generos[i].id +'">'+ res.generos[i].nombre +'</option>';
                        }
                        $("#edit_genero").html( lista2 );
                        //lista Estados Civiles
                        var lista3 = "";
                        for( var i=0; i < res.estados.length; i++ )
                        {
                          lista3 += '<option value="'+ res.estados[i].id +'">'+ res.estados[i].nombre +'</option>';
                        }
                        $("#edit_estado").html( lista3 );
                        //lista Niveles Estudio
                        var lista4 = "";
                        for( var i=0; i < res.niveles.length; i++ )
                        {
                          lista4 += '<option value="'+ res.niveles[i].id +'">'+ res.niveles[i].nombre +'</option>';
                        }
                        $("#edit_nivel").html( lista4 );
                        //lista Estratos
                        var lista5 = "";
                        for( var i=0; i < res.estratos.length; i++ )
                        {
                          lista5 += '<option value="'+ res.estratos[i].id +'">'+ res.estratos[i].nombre +'</option>';
                        }
                        $("#edit_estrato").html( lista5 );
                        //lista Etnias
                        var lista6 = "";
                        for( var i=0; i < res.etnias.length; i++ )
                        {
                          lista6 += '<option value="'+ res.etnias[i].id +'">'+ res.etnias[i].nombre +'</option>';
                        }
                        $("#edit_etnia").html( lista6 );
                        //lista Ciudades
                        var lista7 = "";
                        for( var i=0; i < res.ciudades.length; i++ )
                        {
                          lista7 += '<option value="'+ res.ciudades[i].id +'">'+ res.ciudades[i].nombre +'</option>';
                        }
                        $("#edit_ciudadExp").html( lista7 );
                        $("#edit_ciudadNac").html( lista7 );
                        $("#edit_ciudad").html( lista7 );
                        //lista Paises
                        var lista8 = "";
                        for( var i=0; i < res.paises.length; i++ )
                        {
                          lista8 += '<option value="'+ res.paises[i].id +'">'+ res.paises[i].nombre +'</option>';
                        }
                        $("#edit_paisNac").html( lista8 );
                        //Ocultar mensajes error
                        $(".alert").fadeOut();                            
                      }
                      else if(res.status === "EXPIRED" )//Sesión finalizada
                      {
                        jAlert('Su sesión ha caducado, por favor inicie sesión de Nuevo', 'Sesión expirada', function(){
                          window.location = "cerrar_sesion.php";
                        });
                      }
                      else if( res.status === "ERROR")
                      {
                        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
                      }
                    }
                  });
                  $.ajax(
                  {
                    cache: false,
                    type: "POST",
                    url: "querys/gestion_empleados.php",
                    data: {
                            opcion      : 7 ,
                            documento   : documento
                          },
                    dataType: "json",
                    success: function(res)
                    {
                      if( res.status === "OK" )
                      {
                        //Asignar Valores
                        for( var i=0; i < res.empleados.length; i++ )
                        {
                          $("#edit_id_empleado").val(res.empleados[i].id);
                          $("#edit_nombre").val(res.empleados[i].nombre);
                          $("#edit_nombre2").val(res.empleados[i].nombre2);
                          $("#edit_apellido").val(res.empleados[i].apellido);
                          $("#edit_apellido2").val(res.empleados[i].apellido2);
                          $("#edit_tipo").val(res.empleados[i].IDtipo);
                          $("#edit_documento").val(res.empleados[i].documento);
                          $("#edit_fechaExp").val(res.empleados[i].fechaExp);
                          $("#edit_ciudadExp").val(res.empleados[i].IDciudadExp);
                          $("#edit_fechaNac").val(res.empleados[i].fechaNac);
                          $("#edit_ciudadNac").val(res.empleados[i].IDciudadNac);
                          $("#edit_paisNac").val(res.empleados[i].IDpaisNac);
                          $("#edit_genero").val(res.empleados[i].IDgenero);
                          $("#edit_estado").val(res.empleados[i].IDestado);
                          $("#edit_nivel").val(res.empleados[i].IDnivel);
                          $("#edit_titulo").val(res.empleados[i].titulo);
                          $("#edit_direccion").val(res.empleados[i].direccion);
                          $("#edit_barrio").val(res.empleados[i].barrio);
                          $("#edit_estrato").val(res.empleados[i].IDestrato);
                          $("#edit_ciudad").val(res.empleados[i].IDciudad);
                          $("#edit_telefono").val(res.empleados[i].telefono);
                          $("#edit_celular").val(res.empleados[i].celular);
                          $("#edit_email").val(res.empleados[i].email);
                          $("#edit_etnia").val(res.empleados[i].IDetnia);
                          $("#edit_comentario").val(res.empleados[i].comentario);
                        }
                        // end asignar 
                        $("#modalSpinner").modal("hide"); //ocultar spinner
                        $("#modalEditar").modal("show"); //Abrir PopUp
                        $('#modalEditar').on('shown.bs.modal', function() {
                            $("#edit_nombre").focus();
                        });
                      }
                      else if(res.status === "EXPIRED" )//Sesión finalizada
                      {
                        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
                          window.location = "cerrar_sesion.php";
                        });
                      }
                      else if( res.status === "ERROR")
                      {
                        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
                        //console.log(res.sql);
                      }
                      $("#btn_guardar_nuevo").button("reset");//Restaurar boton guardar
                    }
                  });
            }// end funtion existe
          $("#form_nuevo #msg_error_validacion").delay(3000).hide(500);
          $("#form_nuevo #msg_error_documento_r").hide();
          $('#new_documento').val("");
          $('#new_documento').focus(); 
        }
        else if( res.status === "EMPTY" ) {
          $("#form_nuevo #msg_error_documento_r").hide();
          $("#form_nuevo #msg_validacion").html('<i class="fa fa-check" aria-hidden="true"></i>  Continuar');
          $('#form_nuevo #new_documento').show(500);
          $("#form_nuevo #new_documento_v").show(500);
          $('#new_documento_v').focus();
        }
        //Sesión finalizada
        else if(res.status === "EXPIRED" ) {
          jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
            window.location = "cerrar_sesion.php";
          });
        }
        else if( res.status === "ERROR") {
          jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
        }
      }
    });      
  }       
}
/**
* Función encargada de verificar que el campo new_documento_v sea igual al campo new_documento
*/
function verificarDoc(){
    // hide error mgs when press backspace
    $('#new_documento_v').keyup(function(e){ 
      if(e.keyCode == 8) 
        $("#form_nuevo #msg_error_documento_v").hide(500); 
    })
    // set variables
    var new_documento = $('#new_documento').val();
    var new_documento_v = $('#new_documento_v').val();
    var _this = $('#new_documento_v');
    if( new_documento=== "" ){
      $("#form_nuevo #msg_error_documento_r").hide();
      $('#new_documento').focus();      
    }
    else if( new_documento_v === "" ){
      $("#form_nuevo #msg_error_documento_r").show(500);
      $('#new_documento_v').focus();      
    }
    else if( new_documento_v === "" ){
      $("#form_nuevo #msg_error_documento_r").show(500);
      $('#new_documento_v').focus();      
    }
    // documento diferente
    else if(new_documento !== new_documento_v && new_documento_v != ''){
      $("#form_nuevo #msg_error_documento_r").hide(500);
      $("#form_nuevo #msg_validacion_v").delay(3000).hide(500);
      $("#form_nuevo #msg_error_documento_v").show(500);
      $('#form_nuevo #new_documento_v').show(2500);
      $("#form_nuevo #msg_error_documento_v").delay(3000).hide(500);
      $('#new_documento_v').focus();                            
    } 
    // documento igual
    else if(new_documento === new_documento_v ){
      $("#form_nuevo #msg_error_documento_r").hide(500);
      $("#form_nuevo #msg_validacion_v").hide(500);
      $("#form_nuevo #msg_ok_documento_v").show(500);
      $('#form_nuevo #new_documento_v').show(3000);
      $("#form_nuevo #msg_ok_documento_v").delay(3000).hide(500);
      $('#form_nuevo #msg_validacion').delay(3000).hide(500);
      $('#new_tipo').focus(); 
    } 
    // campo vacio
    else {
      $("#form_nuevo #msg_error_documento_v").hide();
      $("#form_nuevo #msg_ok_documento_v").hide();
    }
}
/**
* Función encargada de verificar que los campos .fecha  tengan el formato correcto : # dias y # meses
*/
function verificarFecha(fecha){
  var currVal = fecha;
  if(currVal == '')
      return false;
  var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; //Declare Regex
  var dtArray = currVal.match(rxDatePattern); // is format OK?
  if (dtArray == null) 
      return false;
  //Checks for dd/mm/yyyy format.
  dtDay= dtArray[1];
  dtMonth = dtArray[3];
  dtYear = dtArray[5]; 
  actual = new Date();
  yActual = actual.getFullYear(); //yields year
  
  if (dtDay < 1 || dtDay > 31) 
      return false;
  else if (dtMonth < 1 || dtMonth> 12) 
      return false;
  else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31) 
      return false;
  else if (dtYear > yActual) 
    return false;
  else if (dtMonth == 2) 
  {
      var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
      if (dtDay> 29 || (dtDay ==29 && !isleap)) 
              return false;
  }
  return true;
}
/**
* Función encargada de comparar la fecha de nacimiento y la fecha de expeicion
*/
function nacVsExp(aExp,aNac){
  var aExp = aExp; 
  var aNac = aNac; 
    if ( (aExp - aNac) < 18 ){
          jAlert('Fecha de Nacimiento no puede ser mayor a Fecha de Expedicion, por favor verificar ambas fechas', 'Error');
    }
}
/**
* Función encargada de agregar eps
*/
function agregarEps(id,doc,name,lastName){
  var idEmpleadoEps = id;
  var documentoEps = doc;
  var nombreEps = name;
  var apellidoEps = lastName;
  //Consultar EPS
  $.ajax({
    cache: false,
    type: "POST",
    url: "querys/gestion_empleados.php",
    data: { opcion : 8 },
    dataType: "json",
    success: function(res){
      if( res.status === "OK" ){ 
        //lista EPS
        var eps = "";
        for( var e=0; e < res.eps.length; e++ ){
          eps += '<option value="'+ res.eps[e].id +'">'+ res.eps[e].nombre +'</option>';
        }
        //lista Tipo Tramites
        var tramite = "";
        for( var t=0; t < res.tramite.length; t++ ){
          tramite += '<option value="'+ res.tramite[t].id +'">'+ res.tramite[t].nombre +'</option>';
        }
        //lista Tipo Afiliaciones
        var afiliacion = "";
        for( var a=0; a < res.afiliacion.length; a++ ){
          afiliacion += '<option value="'+ res.afiliacion[a].id +'">'+ res.afiliacion[a].nombre +'</option>';
        }
        //lista Tipo Afiliación
        var afiliado = "";
        for( var i=0; i < res.afiliado.length; i++ ){
          afiliado += '<option value="'+ res.afiliado[i].id +'">'+ res.afiliado[i].nombre +'</option>';
        }
        //lista Tipo Cotizante
        var cotizante = "";
        for( var c=0; c < res.cotizante.length; c++ ){
          cotizante += '<option value="'+ res.cotizante[c].id +'">'+ res.cotizante[c].nombre +'</option>';
        }
        //Resetear campos
        $("#new_fecha_radicacion_eps").val("");
        $("#new_tipo_tramite_eps").val("");
        $("#new_tipo_afiliacion_eps").val("");
        $("#new_tipo_afiliado_eps").val("");
        $("#new_tipo_cotizante_eps").val("");
        //Ocultar mensajes error
        $(".alert").fadeOut();
        //Asignar Documento para relacionar
        $("#new_nombreEps").html( nombreEps );
        $("#new_apellidoEps").html( apellidoEps );
        $("#new_documentoEps").html( documentoEps );
        $("#new_id_empleadoEps").html( idEmpleadoEps );
        //asignar valores
        $("#new_eps").html( eps );
        $("#new_tipo_tramite_eps").html( tramite );
        $("#new_tipo_afiliacion_eps").html( afiliacion );
        $("#new_tipo_afiliado_eps").html( afiliado );
        $("#new_tipo_cotizante_eps").html( cotizante );
      }
      else if(res.status === "EXPIRED" ){
        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }
      else if( res.status === "ERROR"){
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
}
/**
* Funcion encargada de procesar el registro del nueva eps Empleado
*/
function guardarEps(){
  var idEmpleado = $("#new_id_empleadoEps").html();
  var documentoEps = $("#new_documentoEps").html();
  var idEps = $("#new_eps").val();
  var nEps = $( "#new_eps option:selected" ).text();
  var fechaRadicacion = $("#new_fecha_radicacion_eps").val();
  var fechar_array = fechaRadicacion.split("-");
  var fecha_rad = fechar_array[2] +"-"+ fechar_array[1] +"-"+ fechar_array[0]; //yyyy-mm-dd
  var tipoTramite = $("#new_tipo_tramite_eps").val();
  var nTipoTramite = $( "#new_tipo_tramite_eps option:selected" ).text();
  var tipoAfiliacion = $("#new_tipo_afiliacion_eps").val();
  var nTipoAfiliacion = $( "#new_tipo_afiliacion_eps option:selected" ).text();
  var tipoAfiliado = $("#new_tipo_afiliado_eps").val();
  var nTipoAfiliado = $( "#new_tipo_afiliado_eps option:selected" ).text();
  var tipoCotizante = $("#new_tipo_cotizante_eps").val();
  var nTipoCotizante = $( "#new_tipo_cotizante_eps option:selected" ).text();
  var regimen = $("#new_regimen_eps").val();
  var nombreBeneficiario = $("#new_convivencia_nombre").val();
  var apellidoBeneficiario = $("#new_convivencia_apellido").val();
  var convivencia = 0;
  if ( $('input.si').is(':checked')){
    convivencia = 1;
  }
  //Validar campos requeridos
  if( idEmpleado === ""){
    jAlert('no trajo el Id Empleado', 'Error');
  }
  else if( idEps === "null"){
    $("#new_eps").focus();
    $("#form_nuevo #msg_error_eps").show();
  }
  else if( fechaRadicacion === "null"){
    $("#new_fecha_radicacion_eps").focus();
    $("#form_nuevo #msg_error_fechaRad_eps").show();
  }
  else if( tipoTramite === "null"){
    $("#new_tipo_tramite_eps").focus();
    $("#form_nuevo #msg_error_tramite_eps").show();
  }
  else if( tipoAfiliacion === "null"){
    $("#new_tipo_afiliacion_eps").focus();
    $("#form_nuevo #msg_error_afiliacion_eps").show();
  }
  else if( tipoAfiliado === "null" ){
    $("#new_tipo_afiliado_eps").focus();
    $("#form_nuevo #msg_error_afiliado_eps").show();
  }
  else if( tipoCotizante === "null"){
    $("#new_tipo_cotizante_eps").focus();
    $("#form_nuevo #msg_error_cotizante_eps").show();
  }
  else if( regimen === "null"){
    $("#new_regimen_eps").focus();
    $("#form_nuevo #msg_error_regimen_eps").show();
  }
  else if( $('input.si').is(':checked') && nombreBeneficiario === ""){
    $("#new_convivencia_nombre").focus();
    $("#form_nuevo #msg_error_convivencia_nombre").show();
  }
  else if( $('input.si').is(':checked') && apellidoBeneficiario === ""){
    $("#new_convivencia_apellido").focus();
    $("#form_nuevo #msg_error_convivencia_apellido").show();
  }
  else{
    jConfirm('<form id="form_v" role="form"><div class="row form-group"><label class="col-sm-6" for="v_nombre">E.P.S:</label><div class="col-sm-6"><input type="text" id="v_nombre" name="v_nombre" class="form-control" value="'+nEps+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_nombre2">Fecha Radicación:</label><div class="col-sm-6"><input type="text" id="v_nombre2" name="v_nombre2" class="form-control" value="'+fechaRadicacion+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_apellido">Tipo Trámite:</label><div class="col-sm-6"><input type="text" id="v_apellido" name="v_apellido" class="form-control" value="'+nTipoTramite+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_apellido2">Tipo Afiliación:</label><div class="col-sm-6"><input type="text" id="v_apellido2" name="v_apellido2" class="form-control" value="'+nTipoAfiliacion+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_documento">Tipo Afiliado:</label><div class="col-sm-6"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+nTipoAfiliado+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_documento">Tipo Cotizante:</label><div class="col-sm-6"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+nTipoCotizante+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_documento">Regimen:</label><div class="col-sm-6"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+regimen+'"></div></div>      <div class="row form-group"><label class="col-sm-6" for="v_nombre">Declaraci&oacute;n Convivencia</label><div class="col-sm-6"><input type="text" id="v_nombre" name="v_nombre" class="form-control" value="'+convivencia+'"></div></div>   <div class="row form-group"><label class="col-sm-6" for="v_nombre">Conyugue</label><div class="col-sm-6"><input type="text" id="v_nombre" name="v_nombre" class="form-control" value="'+nombreBeneficiario+' '+apellidoBeneficiario+'"></div></div>  </form>', 'Los datos son correctos?', function(r) {     
      if(r){
          saveEps();
        }
     });
    function saveEps(){
      $(".btn_guardar_nuevo").button("loading"); //Cambiar estado del botón guardarNuevo
      //$("#modalSpinner").modal("show"); // muestra spinner
      $.ajax({
        cache: false,
        type: "POST",
        url: "querys/gestion_empleados.php",
        data: {
                opcion           :   9,
                id               :   id,
                idEps            :   idEps,
                fecha_rad        :   fecha_rad,
                tipoTramite      :   tipoTramite,
                tipoAfiliacion   :   tipoAfiliacion,
                tipoAfiliado     :   tipoAfiliado,
                tipoCotizante    :   tipoCotizante,
                regimen          :   regimen,
                beneficiario     :   nombreBeneficiario +' '+apellidoBeneficiario,
                convivencia      :   convivencia
              },
        dataType: "json",
        success: function(res){
          if( res.status === "OK" ){
            //$("#modalSpinner").modal("hide"); //ocultar spinner
            recargarDatos();
            jAlert('Datos de E.P.S. agregados con éxito.', 'Datos E.P.S.', function(){
              agregarArl();
              $('#mytabs a[href="#datosArl"]').tab('show');
              $('#mytabs li:nth-child(1)').addClass("disabledTab");
              $('#mytabs li:nth-child(2)').addClass("disabledTab");
            });
          }
          else if(res.status === "EXIST" ){
            jAlert('La Entidad '+ nEps +' ya se encuentra registrada', 'Error', function(){
              $("#new_eps").focus();
            });
          }
          else if(res.status === "EXPIRED" ){
            jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
              window.location = "cerrar_sesion.php";
            });
          }
          else if( res.status === "ERROR"){
            jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
            //console.log(res.sql);
          }              
        }
      });
      $(".btn_guardar_nuevo").button("reset");//Restaurar boton guardar
    }
  }
}
/**
* Función encargada de agregar arl
*/
function agregarArl(id,doc,name,lastName){
  var idEmpleado = id;
  var documentoArl = doc;
  var nombreArl = name;
  var apellidoArl = lastName;
  //Consultar ARL
  $.ajax({
    cache: false,
    type: "POST",
    url: "querys/gestion_empleados.php",
    data: { opcion : 8 },
    dataType: "json",
    success: function(res){
      if( res.status === "OK" ){ 
        //lista ARL
        var arl = "";
        for( var e=0; e < res.arl.length; e++ ){
          arl += '<option value="'+ res.arl[e].id +'">'+ res.arl[e].nombre +'</option>';
        }
        //asignar valores
        $("#new_arl").html( arl );
        //Resetear campos
        $("#new_fecha_afiliacion_arl").val("");
        $("#new_codigo_transaccion_arl").val("");
        //Ocultar mensajes error
        $(".alert").fadeOut();
        //Asignar Documento para relacionar
        $("#new_nombreArl").html( nombreArl );
        $("#new_apellidoArl").html( apellidoArl );
        $("#new_documentoArl").html( documentoArl );
      }
      else if(res.status === "EXPIRED" ) {
        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }
      else if( res.status === "ERROR"){
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
}
/**
* Funcion encargada de procesar el registro del nueva arl Empleado
*/
function guardarArl(){
  var idArl = $("#new_arl").val();
  var nArl = $( "#new_arl option:selected" ).text();
  var fechaAfiliacion = $("#new_fecha_afiliacion_arl").val();
  var fechar_array = fechaAfiliacion.split("-");
  var fecha_afi = fechar_array[2] +"-"+ fechar_array[1] +"-"+ fechar_array[0]; //yyyy-mm-dd
  var codigoTransaccion = $("#new_codigo_transaccion_arl").val();
  //Validar campos requeridos
  if( idArl === "null"){
    $("#new_arl").focus();
    $("#form_editar #msg_error_arl").show();
  }
  else if( fechaAfiliacion === "null"){
    $("#new_fecha_radicacion_arl").focus();
    $("#form_editar #msg_error_fechaAfi_arl").show();
  }
  else if( codigoTransaccion === ""){
    $("#new_codigo_transaccion_arl").focus();
    $("#form_editar #msg_error_codigo_transaccion_arl").show();
  }
  else{
    jConfirm('<form id="form_v" role="form"><div class="row form-group"><label class="col-sm-6" for="v_nombre">A.R.L.:</label><div class="col-sm-6"><input type="text" id="v_nombre" name="v_nombre" class="form-control" value="'+nArl+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_nombre2">Fecha Radicación:</label><div class="col-sm-6"><input type="text" id="v_nombre2" name="v_nombre2" class="form-control" value="'+fechaAfiliacion+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_apellido">Tipo Trámite:</label><div class="col-sm-6"><input type="text" id="v_apellido" name="v_apellido" class="form-control" value="'+codigoTransaccion+'"></div></div></form>', 'Los datos son correctos?', function(r) {     
      if(r){
          saveArl();
        }
     });
    function saveArl(){
      $("#btn_guardar_editar").button("loading"); //Cambiar estado del botón guardarNuevo
      //$("#modalSpinner").modal("show"); // muestra spinner
      $.ajax({
        cache: false,
        type: "POST",
        url: "querys/gestion_empleados.php",
        data: {
                opcion            :   12,
                id                :   id,
                idArl             :   idArl,
                fecha_afi         :   fecha_afi,
                codigoTransaccion :   codigoTransaccion
              },
        dataType: "json",
        success: function(res){
          if( res.status === "OK" ){
            //$("#modalSpinner").modal("hide"); //ocultar spinner
            recargarDatos();
            jAlert('Datos de A.R.L. agregados con éxito', 'Datos A.R.L.', function(){
              $('#mytabs a[href="#datosPension"]').tab('show');
              $('#mytabs li:nth-child(1)').addClass("disabledTab");
              $('#mytabs li:nth-child(2)').addClass("disabledTab");
              $('#mytabs li:nth-child(3)').addClass("disabledTab");
            });
          }
          else if(res.status === "EXIST" ){
            lert('La Entidad '+ nArl +' ya se encuentra registrada', 'Error', function(){
              $("#new_arl").focus();
            });
          }
          else if(res.status === "EXPIRED" ){
            jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
              window.location = "cerrar_sesion.php";
            });
          }
          else if( res.status === "ERROR"){
            jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
            //console.log(res.sql);
          }
        }
      });
      $(".btn_guardar_nuevo").button("reset");//Restaurar boton guardar
    }
  }
}
/**
* Función encargada de agregar pension
*/
function agregarPension(id,doc,name,lastName){
  var idEmpleado = id;
  var documentoPension = doc;
  var nombrePension = name;
  var apellidoPension = lastName;
  //Consultar PENSION
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
        { 
          //lista PENSION
          var pension = "";
          for( var e=0; e < res.pension.length; e++ )
          {
            pension += '<option value="'+ res.pension[e].id +'">'+ res.pension[e].nombre +'</option>';
          }
          //asignar valores
          $("#new_pension").html( pension );
          //Resetear campos
          $("#new_fecha_afiliacion_pension").val("");
          //Ocultar mensajes error
          $(".alert").fadeOut();
          //Asignar Documento para relacionar
          $("#new_nombrePension").html( nombrePension );
          $("#new_apellidoPension").html( apellidoPension );
          $("#new_documentoPension").html( documentoPension );
        }
        else if(res.status === "EXPIRED" )//Sesión finalizada
        {
          jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
            window.location = "cerrar_sesion.php";
          });
        }
        else if( res.status === "ERROR")
        {
          jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
        }
    }
  });
}
/**
* Funcion encargada de procesar el registro del nueva pension Empleado
*/
function guardarPension(){
  var idPension = $("#new_pension").val();
  var nPension = $( "#new_pension option:selected" ).text();
  var fechaAfiliacion = $("#new_fecha_afiliacion_pension").val();
  var fechar_array = fechaAfiliacion.split("-");
  var fecha_afi = fechar_array[2] +"-"+ fechar_array[1] +"-"+ fechar_array[0]; //yyyy-mm-dd


  //Validar campos requeridos
  if( idPension === "null")
  {
    $("#new_pension").focus();
    $("#form_nuevo #msg_error_pension").show();
  }
  else if( fechaAfiliacion === "" && $('input.noAfiliado').is(':checked'))
  {
    $("#new_fecha_radicacion_pension").focus();
    $("#form_nuevo #msg_error_fechaAfi_pension").show();
  }
  else{
    jConfirm('<form id="form_v" role="form"><div class="row form-group"><label class="col-sm-6" for="v_nombre">PENSION:</label><div class="col-sm-6"><input type="text" id="v_nombre" name="v_nombre" class="form-control" value="'+nPension+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_nombre2">Fecha Radicación:</label><div class="col-sm-6"><input type="text" id="v_nombre2" name="v_nombre2" class="form-control" value="'+fechaAfiliacion+'"></div></div></form>', 'Los datos son correctos?', function(r) {     
      if(r)
        {
          savePension();
        }
     });
    function savePension()
    {
      $(".btn_guardar_nuevo").button("loading"); //Cambiar estado del botón guardarNuevo
      //$("#modalSpinner").modal("show"); // muestra spinner
      $.ajax(
      {
          cache: false,
          type: "POST",
          url: "querys/gestion_empleados.php",
          data: {
                  opcion      :   15,
                  id          :   id,
                  idPension   :   idPension,
                  fecha_afi   :   fecha_afi
                },
          dataType: "json",
          success: function(res)
          {
            if( res.status === "OK" )
            {
              //$("#modalSpinner").modal("hide"); //ocultar spinner
              recargarDatos();
              jAlert('Datos de PENSION agregados con éxito', 'Datos PENSION', function(){
                $('#mytabs a[href="#datosCaja"]').tab('show');
                $('#mytabs li:nth-child(1)').addClass("disabledTab");
                $('#mytabs li:nth-child(2)').addClass("disabledTab");
                $('#mytabs li:nth-child(3)').addClass("disabledTab");
                $('#mytabs li:nth-child(4)').addClass("disabledTab");
              });
            }else if(res.status === "EXIST" )//PENSION existente
            {
              lert('La Entidad '+ nPension +' ya se encuentra registrada', 'Error', function(){
                $("#new_pension").focus();
              });
            }else if(res.status === "EXPIRED" )//Sesión finalizada
            {
              jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
                window.location = "cerrar_sesion.php";
              });
            }else if( res.status === "ERROR")
            {
              jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
              //console.log(res.sql);
            }
          }
      });
      $(".btn_guardar_nuevo").button("reset");//Restaurar boton guardar
    }
  }
}
/**
* Función encargada de agregar caja
*/
function agregarCaja(id,doc,name,lastName){
  var idEmpleado = id;
  var documentoCaja = doc;
  var nombreCaja = name;
  var apellidoCaja = lastName;
  //Consultar Caja
  $.ajax({
    cache: false,
    type: "POST",
    url: "querys/gestion_empleados.php",
    data: { opcion : 8 },
    dataType: "json",
    success: function(res){
      if( res.status === "OK" ){ 
        //lista Caja
        var caja = "";
        for( var e=0; e < res.caja.length; e++ ){
          caja += '<option value="'+ res.caja[e].id +'">'+ res.caja[e].nombre +'</option>';
        }
        //asignar valores
        $("#new_caja").html( caja );
        //Ocultar mensajes error
        $(".alert").fadeOut();
        //Asignar Documento para relacionar
        $("#new_nombreCaja").html( nombreCaja );
        $("#new_apellidoCaja").html( apellidoCaja );
        $("#new_documentoCaja").html( documentoCaja );
      }
      else if(res.status === "EXPIRED" ){
        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }
      else if( res.status === "ERROR"){
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
}
/**
* Funcion encargada de procesar el registro del nueva caja Empleado
*/
function guardarCaja(){
  var idCaja = $("#new_caja").val();
  var nCaja = $( "#new_caja option:selected" ).text();
  //Validar campos requeridos
  if( idCaja === "null"){
    $("#new_caja").focus();
    $("#form_nuevo #msg_error_caja").show();
  }
  else{
    jConfirm('<form id="form_v" role="form"><div class="row form-group"><label class="col-sm-6" for="v_nombre">Caja:</label><div class="col-sm-6"><input type="text" id="v_nombre" name="v_nombre" class="form-control" value="'+nCaja+'"></div></div></form>', 'Los datos son correctos?', function(r) {     
      if(r){
          saveCaja();
        }
     });
    function saveCaja(){
      $(".btn_guardar_nuevo").button("loading"); //Cambiar estado del botón guardarNuevo
      //$("#modalSpinner").modal("show"); // muestra spinner
      $.ajax({
        cache: false,
        type: "POST",
        url: "querys/gestion_empleados.php",
        data: {
                opcion    :   18,
                id        :   id,
                idCaja    :   idCaja,
              },
        dataType: "json",
        success: function(res){
          if( res.status === "OK" ){
            //$("#modalSpinner").modal("hide"); //ocultar spinner
            recargarDatos();
            jAlert('Datos de Caja de Compensacion agregados con éxito', 'Datos Caja Compensación', function(){
              //$("#modalNuevo").modal("hide");
              $('#mytabs a[href="#datosReferencias"]').tab('show');
              $('#mytabs li:nth-child(1)').addClass("disabledTab");
              $('#mytabs li:nth-child(2)').addClass("disabledTab");
              $('#mytabs li:nth-child(3)').addClass("disabledTab");
              $('#mytabs li:nth-child(4)').addClass("disabledTab");
              $('#mytabs li:nth-child(5)').addClass("disabledTab");
            });
          }
          else if(res.status === "EXIST" ){
            lert('La Entidad '+ nCaja +' ya se encuentra registrada', 'Error', function(){
              $("#new_caja").focus();
            });
          }
          else if(res.status === "EXPIRED" ){
            jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
              window.location = "cerrar_sesion.php";
            });
          }
          else if( res.status === "ERROR"){
            jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
            //console.log(res.sql);
          }
        }
      });
      $(".btn_guardar_nuevo").button("reset");//Restaurar boton guardar
    }
  }
}
/**
* Función encargada de agregar caja
*/
function agregarReferencia(id,doc,name,lastName){
  var idEmpleado = id;
  var documentoReferencia = doc;
  var nombreReferencia = name;
  var apellidoReferencia = lastName;
  //Consultar Referencia
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
        { 
          //lista Parentescos
          var parentesco = "";
          for( var i=0; i < res.parentesco.length; i++ )
          {
            parentesco += '<option value="'+ res.parentesco[i].id +'">'+ res.parentesco[i].nombre +'</option>';
          }
          //asignar valores
          $("#new_parentesco_ref1").html( parentesco );
          $("#new_parentesco_ref2").html( parentesco );
          
          //Ocultar mensajes error
          $(".alert").fadeOut();
          //Asignar Documento para relacionar
          $("#new_nombreRef").html( nombreReferencia );
          $("#new_apellidoRef").html( apellidoReferencia );
          $("#new_documentoRef").html( documentoReferencia );
        }
        else if(res.status === "EXPIRED" )//Sesión finalizada
        {
          jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
            window.location = "cerrar_sesion.php";
          });
        }
        else if( res.status === "ERROR")
        {
          jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
        }
    }
  });
}
/**
* Funcion encargada de procesar el registro del nueva caja Empleado
*/
function guardarReferencia(){
  var nombre1 = $("#new_nombre_ref1").val();
  var apellido1 = $("#new_apellido_ref1").val();
  var parentesco1 = $( "#new_parentesco_ref1" ).val();
  var telefono1 = $( "#new_telefono_ref1" ).val();
  var nombre2 = $("#new_nombre_ref2").val();
  var apellido2 = $("#new_apellido_ref2").val();
  var parentesco2 = $( "#new_parentesco_ref2" ).val();
  var telefono2 = $( "#new_telefono_ref2" ).val();
  //Validar campos requeridos
  if( nombre1 === "null")
  {
    $("#new_nombre_ref1").focus();
    $("#form_nuevo #msg_error_nombre_ref1").show();
  }
  else if( apellido1 === "null")
  {
    $("#new_apellido_ref1").focus();
    $("#form_nuevo #msg_error_apellido_ref1").show();
  }
  else if( parentesco1 === "null")
  {
    $("#new_parentesco_ref1").focus();
    $("#form_nuevo #msg_error_parentesco_ref1").show();
  }
  else if( telefono1 === "null")
  {
    $("#new_telefono_ref1").focus();
    $("#form_nuevo #msg_error_telefono_ref1").show();
  }
  else if( nombre2 === "null")
  {
    $("#new_nombre_ref2").focus();
    $("#form_nuevo #msg_error_nombre_ref2").show();
  }
  else if( apellido2 === "null")
  {
    $("#new_apellido_ref2").focus();
    $("#form_nuevo #msg_error_apellido_ref2").show();
  }
  else if( parentesco2 === "null")
  {
    $("#new_parentesco_ref2").focus();
    $("#form_nuevo #msg_error_parentesco_ref2").show();
  }
  else if( telefono2 === "null")
  {
    $("#new_telefono_ref2").focus();
    $("#form_nuevo #msg_error_telefono_ref2").show();
  }
  else
  {
    jConfirm('<form id="form_v" role="form"><div class="row form-group"><label class="col-sm-6" for="v_nombre">Ref #1 Nombre:</label><div class="col-sm-6"><input type="text" id="v_nombre" name="v_nombre" class="form-control" value="'+nombre1+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_nombre2">Ref #1 Apellido:</label><div class="col-sm-6"><input type="text" id="v_nombre2" name="v_nombre2" class="form-control" value="'+apellido1+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_apellido">Ref #1 Parentesco:</label><div class="col-sm-6"><input type="text" id="v_apellido" name="v_apellido" class="form-control" value="'+parentesco1+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_apellido2">Ref #1 Telefono:</label><div class="col-sm-6"><input type="text" id="v_apellido2" name="v_apellido2" class="form-control" value="'+telefono1+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_documento">Ref #2 Nombre:</label><div class="col-sm-6"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+nombre2+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_documento">Ref #2 Apellido:</label><div class="col-sm-6"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+apellido2+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_documento">Ref #2 Parentesco:</label><div class="col-sm-6"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+parentesco2+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_documento">Ref #2 Telefono:</label><div class="col-sm-6"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+telefono2+'"></div></div></form>', 'Los datos son correctos?', function(r) {     
      if(r)
        {
          saveReferencia();
        }
     });
    function saveReferencia()
    {
      $(".btn_guardar_nuevo").button("loading"); //Cambiar estado del botón guardarNuevo
      //$("#modalSpinner").modal("show"); // muestra spinner
      $.ajax(
      {
          cache: false,
          type: "POST",
          url: "querys/gestion_empleados.php",
          data: {
                  opcion      :   21,
                  id          :   id,
                  nombre1     : nombre1 ,
                  apellido1   : apellido1,
                  parentesco1 : parentesco1,
                  telefono1   : telefono1,
                  nombre2     : nombre2,
                  apellido2   : apellido2,
                  parentesco2 : parentesco2,
                  telefono2   : telefono2
                },
          dataType: "json",
          success: function(res)
          {
            if( res.status === "OK" )
            {
              //$("#modalSpinner").modal("hide"); //ocultar spinner
              recargarDatos();
              jAlert('Datos de Referencias Personales agregados con éxito', 'Datos Referencias Personales', function(){
                $('#mytabs a[href="#datosEmpresa"]').tab('show');
                $('#mytabs li:nth-child(1)').addClass("disabledTab");
                $('#mytabs li:nth-child(2)').addClass("disabledTab");
                $('#mytabs li:nth-child(3)').addClass("disabledTab");
                $('#mytabs li:nth-child(4)').addClass("disabledTab");
                $('#mytabs li:nth-child(5)').addClass("disabledTab");
                $('#mytabs li:nth-child(6)').addClass("disabledTab");
              });
            }else if(res.status === "EXIST" )//Referencia existente
            {
              lert('La Entidad '+ nReferencia +' ya se encuentra registrada', 'Error', function(){
                $("#new_caja").focus();
              });
            }else if(res.status === "EXPIRED" )//Sesión finalizada
            {
              jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
                window.location = "cerrar_sesion.php";
              });
            }else if( res.status === "ERROR")
            {
              jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
              //console.log(res.sql);
            }
          }
      });
      $(".btn_guardar_nuevo").button("reset");//Restaurar boton guardar
    }
  }
}
/**
* Función encargada de agregar caja
*/
function agregarEmpresa(id,doc,name,lastName){
  var idEmpleado = id;
  var documentoEmpresa = doc;
  var nombreEmpresa = name;
  var apellidoEmpresa = lastName;
  //Consultar Empresa
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
        { 
          var empresas = "";
          var bancos = "";
          var cuentas = "";
          //lista empresas          
          for( var i=0; i < res.empresas.length; i++ )
          {
            empresas += '<option value="'+ res.empresas[i].id +'">'+ res.empresas[i].nombre +'</option>';
          }
          $("#new_empresa").html( empresas );
          //lista bancos          
          for( var i=0; i < res.bancos.length; i++ )
          {
            bancos += '<option value="'+ res.bancos[i].id +'">'+ res.bancos[i].nombre +'</option>';
          }
          $("#new_banco").html( bancos );
          //lista cuentas          
          for( var i=0; i < res.tipoCuentas.length; i++ )
          {
            cuentas += '<option value="'+ res.tipoCuentas[i].id +'">'+ res.tipoCuentas[i].nombre +'</option>';
          }
          $("#new_tipo_cuenta").html( cuentas );          
          //Ocultar mensajes error
          $(".alert").fadeOut();
          //Asignar Documento para relacionar
          $("#new_nombreEmpresa").html( nombreEmpresa );
          $("#new_apellidoEmpresa").html( apellidoEmpresa );
          $("#new_documentoEmpresa").html( documentoEmpresa );
        }
        else if(res.status === "EXPIRED" )//Sesión finalizada
        {
          jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
            window.location = "cerrar_sesion.php";
          });
        }
        else if( res.status === "ERROR")
        {
          jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
        }
    }
  });
}
/**
* Funcion encargada de procesar el registro del nueva caja Empleado
*/
function guardarEmpresa(){
  var empresa = $("#new_empresa").val();
  var nEmpresa  = $("#new_empresa option:selected").text();
  var cargo = $("#new_cargo").val();
  var salario = $("#new_salario").val();
  var jornada = $("#new_jornada").val();
  var servicioFunerario = $("#new_servicio_funerario").val();
  var nServicioFunerario  = $("#new_servicio_funerario option:selected").text();
  var banco = $("#new_banco").val();
  var nBanco  = $("#new_banco option:selected").text();
  var cuenta = $("#new_cuenta").val();
  var tipoCuenta = $("#new_tipo_cuenta").val();
  var nTipoCuenta  = $("#new_tipo_cuenta option:selected").text();

  //Validar campos requeridos
  if( empresa === "null")
  {
    $("#new_empresa").focus();
    $("#form_nuevo #msg_error_empresa").show();
  }
  else if( cargo === "")
  {
    $("#new_cargo").focus();
    $("#form_nuevo #msg_error_cargo").show();
  }
  else if( salario === "")
  {
    $("#new_salario").focus();
    $("#form_nuevo #msg_error_salario").show();
  }
  else if( jornada === "")
  {
    $("#new_jornada").focus();
    $("#form_nuevo #msg_error_jornada").show();
  }
  else if( servicioFunerario === "null")
  {
    $("#new_servicio_funerario").focus();
    $("#form_nuevo #msg_error_servicio_funerario").show();
  }
  else if( banco === "null")
  {
    $("#new_banco").focus();
    $("#form_nuevo #msg_error_banco").show();
  }
  else if( cuenta === "")
  {
    $("#new_cuenta").focus();
    $("#form_nuevo #msg_error_cuenta").show();
  }
  else if( tipoCuenta === "")
  {
    $("#new_tipo_cuenta").focus();
    $("#form_nuevo #msg_error_tipo_cuenta").show();
  }
  else
  {
    jConfirm('<form id="form_v" role="form"><div class="row form-group"><label class="col-sm-6" for="v_nombre">Empresa:</label><div class="col-sm-6"><input type="text" id="v_nombre" name="v_nombre" class="form-control" value="'+nEmpresa+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_nombre2">Cargo:</label><div class="col-sm-6"><input type="text" id="v_nombre2" name="v_nombre2" class="form-control" value="'+cargo+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_apellido">Salario:</label><div class="col-sm-6"><input type="text" id="v_apellido" name="v_apellido" class="form-control" value="'+salario+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_apellido2">Jornada:</label><div class="col-sm-6"><input type="text" id="v_apellido2" name="v_apellido2" class="form-control" value="'+jornada+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_documento">Servicio Funerario:</label><div class="col-sm-6"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+nServicioFunerario+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_documento">Banco:</label><div class="col-sm-6"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+nBanco+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_documento">Cuenta:</label><div class="col-sm-6"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+cuenta+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_documento">Tipo Cuenta:</label><div class="col-sm-6"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+nTipoCuenta+'"></div></div></form>', 'Los datos son correctos?', function(r) {     
      if(r)
        {
          saveEmpresa();
        }
     });
    function saveEmpresa()
    {
      $(".btn_guardar_nuevo").button("loading"); //Cambiar estado del botón guardarNuevo
      //$("#modalSpinner").modal("show"); // muestra spinner
      $.ajax(
      {
          cache: false,
          type: "POST",
          url: "querys/gestion_empleados.php",
          data: {
                  opcion              :   24,
                  id                  :   id,
                  empresa             :   empresa,
                  cargo               :   cargo,
                  salario             :   salario,
                  jornada             :   jornada,
                  servicioFunerario   :   servicioFunerario,
                  banco               :   banco,
                  cuenta              :   cuenta,
                  tipoCuenta          :   tipoCuenta
                },
          dataType: "json",
          success: function(res)
          {
            if( res.status === "OK" )
            {
              //$("#modalSpinner").modal("hide"); //ocultar spinner
              recargarDatos();
              jAlert('Datos de Contrato Empleado agregados con éxito', 'Datos Coantrato', function(){
                $("#modalNuevo").modal("hide");
                $('#mytabs a[href="#datosBasicos"]').tab('show');
                $('#mytabs li:nth-child(1)').addClass("disabledTab");
                $('#mytabs li:nth-child(2)').addClass("disabledTab");
                $('#mytabs li:nth-child(3)').addClass("disabledTab");
                $('#mytabs li:nth-child(4)').addClass("disabledTab");
                $('#mytabs li:nth-child(5)').addClass("disabledTab");
              });
            }else if(res.status === "EXIST" )//Empresa existente
            {
              lert('La Entidad '+ nEmpresa +' ya se encuentra registrada', 'Error', function(){
                $("#new_caja").focus();
              });
            }else if(res.status === "EXPIRED" )//Sesión finalizada
            {
              jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
                window.location = "cerrar_sesion.php";
              });
            }else if( res.status === "ERROR")
            {
              jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
              //console.log(res.sql);
            }
          }
      });
      $(".btn_guardar_nuevo").button("reset");//Restaurar boton guardar
    }
  }
}
/* /// */
// EDITAR //
/* /// */
/**
* Función encargada de inicializar y abrir PopUp modificar Empleado
*/
function editar(id,nombre,nombre2,apellido,apellido2,tipo,documento,fechaExp,ciudadExp,fechaNac,ciudadNac,paisNac,genero,estado,nivel,titulo,direccion,barrio,estrato,ciudad,telefono,celular,email,etnia,comentario){
  $("#modalSpinner").modal("show"); // show spinner
  //invertir formato de fecha
  var fechaExp_array = fechaExp.split("-");
  var fecha_Exp = fechaExp_array[2] +"-"+ fechaExp_array[1] +"-"+ fechaExp_array[0]; //dd-mm-yyyy
  var fechaNac_array = fechaNac.split("-");
  var fecha_Nac = fechaNac_array[2] +"-"+ fechaNac_array[1] +"-"+ fechaNac_array[0]; //dd-mm-yyyy
  //Consultar perfiles
  $.ajax({
    cache: false,
    type: "POST",
    url: "querys/gestion_empleados.php",
    data: { opcion : 1 },
    dataType: "json",
    success: function(res){
      if( res.status === "OK" ){
        //console.log(""+res);
        //lista Tipo Documentos
        var lista = "";
        for( var i=0; i < res.tipos.length; i++ ){
          lista += '<option value="'+ res.tipos[i].id +'">'+ res.tipos[i].nombre +'</option>';
        }
        $("#edit_tipo").html( lista );
        //lista Generos
        var lista2 = "";
        for( var i=0; i < res.generos.length; i++ ){
          lista2 += '<option value="'+ res.generos[i].id +'">'+ res.generos[i].nombre +'</option>';
        }
        $("#edit_genero").html( lista2 );
        //lista Estados Civiles
        var lista3 = "";
        for( var i=0; i < res.estados.length; i++ ){
          lista3 += '<option value="'+ res.estados[i].id +'">'+ res.estados[i].nombre +'</option>';
        }
        $("#edit_estado").html( lista3 );
        //lista Niveles Estudio
        var lista4 = "";
        for( var i=0; i < res.niveles.length; i++ ){
          lista4 += '<option value="'+ res.niveles[i].id +'">'+ res.niveles[i].nombre +'</option>';
        }
        $("#edit_nivel").html( lista4 );
        //lista Estratos
        var lista5 = "";
        for( var i=0; i < res.estratos.length; i++ ){
          lista5 += '<option value="'+ res.estratos[i].id +'">'+ res.estratos[i].nombre +'</option>';
        }
        $("#edit_estrato").html( lista5 );
        //lista Etnias
        var lista6 = "";
        for( var i=0; i < res.etnias.length; i++ ){
          lista6 += '<option value="'+ res.etnias[i].id +'">'+ res.etnias[i].nombre +'</option>';
        }
        $("#edit_etnia").html( lista6 );
        //lista Ciudades
        var lista7 = "";
        for( var i=0; i < res.ciudades.length; i++ ){
          lista7 += '<option value="'+ res.ciudades[i].id +'">'+ res.ciudades[i].nombre +'</option>';
        }
        $("#edit_ciudadExp").html( lista7 );
        $("#edit_ciudadNac").html( lista7 );
        $("#edit_ciudad").html( lista7 );
        //lista Paises
        var lista8 = "";
        for( var i=0; i < res.paises.length; i++ ){
          lista8 += '<option value="'+ res.paises[i].id +'">'+ res.paises[i].nombre +'</option>';
        }
        $("#edit_paisNac").html( lista8 );
        //Ocultar mensajes error
        $("#modalSpinner").modal("hide");
        $('#new_fechaExp').mask('00-00-0000');
        $('#new_fechaNac').mask('00-00-0000');
        //Asignar Valores seguimiento
        $("#edit_nombreEmpleado").html(nombre);
        $("#edit_apellidoEmpleado").html(apellido);
        $("#edit_documentoEmpleado").html(documento);
        //Asignar Valores
        $("#edit_id_empleado").val(id);
        $("#edit_documento").val(documento);
        $("#edit_nombre").val(nombre);
        $("#edit_nombre2").val(nombre2);
        $("#edit_apellido").val(apellido);
        $("#edit_apellido2").val(apellido2);
        $("#edit_tipo").val(tipo);
        $("#edit_documento").val(documento);
        $("#edit_fechaExp").val(fecha_Exp);
        $("#edit_ciudadExp").val(ciudadExp);
        $("#edit_fechaNac").val(fecha_Nac);
        $("#edit_ciudadNac").val(ciudadNac);
        $("#edit_paisNac").val(paisNac);
        $("#edit_genero").val(genero);
        $("#edit_estado").val(estado);
        $("#edit_nivel").val(nivel);
        $("#edit_titulo").val(titulo);
        $("#edit_direccion").val(direccion);
        $("#edit_barrio").val(barrio);
        $("#edit_estrato").val(estrato);
        $("#edit_ciudad").val(ciudad);
        $("#edit_telefono").val(telefono);
        $("#edit_celular").val(celular);
        $("#edit_email").val(email);
        $("#edit_etnia").val(etnia);
        $("#edit_comentario").val(comentario);
        $("#edit_foto").html('<img class="img-responsive" src="http://temporales.com.co/contratacion/images/foto.png">');
        var img = $('<img class="img-responsive" />').attr('src', 'http://temporales.com.co/fotos/' + documento + '.jpg').on('load', function() {
          if (!this.complete || typeof this.naturalWidth == "undefined" || this.naturalWidth == 0) {
               $("#edit_foto").html('<img class="img-responsive" src="http://temporales.com.co/contratacion/images/foto.png">')
          } 
          else{
              $("#edit_foto").html(img);
          }
        });
        // consultar seg social
        id = id;
        doc = documento;
        name = nombre;
        lastName = apellido;
        editarEpsEmpleado(id,doc,name,lastName);
        editarArlEmpleado(id,doc,name,lastName);
        editarPensionEmpleado(id,doc,name,lastName);
        editarCajaEmpleado(id,doc,name,lastName);
        editarReferenciasEmpleado(id,doc,name,lastName);
        editarContratoEmpleado(id,doc,name,lastName);
        consultarEpsEmpleado(id);            
        consultarArlEmpleado(id);            
        consultarPensionEmpleado(id);            
        consultarCajaEmpleado(id);            
        consultarReferenciasEmpleado(id);
        consultarContratoEmpleado(id);
        //Abrir PopUp
        $("#modalSpinner").modal("hide"); // hide spinner
        $("#modalEditar").modal("show");
        $('#modalEditar').on('shown.bs.modal', function() {
            $("#edit_nombre").focus();
        });
      }
      else if(res.status === "EXPIRED" ){
        jAlert('Su sesión ha caducado, por favor inicie sesión de Nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }
      else if( res.status === "ERROR"){
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
  $('#modalEditar').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormEdit();
  });
}
/**
* Funcion encargada de procesar la modificación del Empleado
*/
function guardarEdicion(){
  var id = $("#edit_id_empleado").val();
  var documento = $("#edit_documento").val();
  var nombre = $("#edit_nombre").val();
  var nombre2 = $("#edit_nombre2").val();
  var apellido = $("#edit_apellido").val();
  var apellido2 = $("#edit_apellido2").val();
  var tipo = $("#edit_tipo").val();
  var fechaExp = $("#edit_fechaExp").val();
  var ciudadExp = $("#edit_ciudadExp").val();
  var fechaNac = $("#edit_fechaNac").val();
  var ciudadNac = $("#edit_ciudadNac").val();
  var paisNac = $("#edit_paisNac").val();
  var genero = $("#edit_genero").val();
  var estado = $("#edit_estado").val();
  var nivel = $("#edit_nivel").val();
  var titulo = $("#edit_titulo").val();
  var direccion = $("#edit_direccion").val();
  var barrio = $("#edit_barrio").val();
  var estrato = $("#edit_estrato").val();
  var ciudad = $("#edit_ciudad").val();
  var telefono = $("#edit_telefono").val();
  var celular = $("#edit_celular").val();
  var email = $("#edit_email").val();
  var etnia = $("#edit_etnia").val();
  var comentario = $("#edit_comentario").val();
  //Validar campos requeridos
  if( nombre === "" )
  {
    $("#edit_nombre").focus();
    $("#form_editar #msg_error_nombre").show();
  }
  else if( apellido === "")
  {
    $("#edit_apellido").focus();
    $("#form_editar #msg_error_apellido").show();
  }
  else if( tipo === "")
  {
    $("#edit_tipo").focus();
    $("#form_editar #msg_error_tipo").show();
  }
  else if( email === "")
  {
    $("#edit_email").focus();
    $("#form_editar #msg_error_email").text("Campo requerido");
    $("#form_editar #msg_error_email").show();
  }
  else if( !validarEmail(email) )
  {
    $("#edit_email").focus();
    $("#form_editar #msg_error_email").text("E-mail inválida");
    $("#form_editar #msg_error_email").show();
  }
  else if( fechaExp === "")
  {
    $("#edit_fechaExp").focus();
    $("#form_editar #msg_error_fechaExp").show();
  }
  else if( ciudadExp === "")
  {
    $("#edit_ciudadExp").focus();
    $("#form_editar #msg_error_ciudadExp").show();
  }
  else if( fechaNac === "")
  {
    $("#edit_fechaNac").focus();
    $("#form_editar #msg_error_fechaNac").show();
  }
  else if( ciudadNac === "")
  {
    $("#edit_ciudadNac").focus();
    $("#form_editar #msg_error_ciudadNac").show();
  }
  else if( paisNac === "")
  {
    $("#edit_paisNac").focus();
    $("#form_editar #msg_error_paisNac").show();
  }
  else if( genero === "")
  {
    $("#edit_genero").focus();
    $("#form_editar #msg_error_genero").show();
  }
  else if( estado === "")
  {
    $("#edit_estado").focus();
    $("#form_editar #msg_error_estado").show();
  }
  else if( nivel === "")
  {
    $("#edit_nivel").focus();
    $("#form_editar #msg_error_nivel").show();
  }
  else if( direccion === "")
  {
    $("#edit_direccion").focus();
    $("#form_editar #msg_error_direccion").show();
  }
  else if( barrio === "")
  {
    $("#edit_barrio").focus();
    $("#form_editar #msg_error_barrio").show();
  }
  else if( estrato === "")
  {
    $("#edit_estrato").focus();
    $("#form_editar #msg_error_estrato").show();
  }
  else if( ciudad === "")
  {
    $("#edit_ciudad").focus();
    $("#form_editar #msg_error_ciudad").show();
  }
  else if( celular === "")
  {
    $("#edit_celular").focus();
    $("#form_editar #msg_error_celular").show();
  }
  else if( email === "")
  {
    $("#edit_email").focus();
    $("#form_editar #msg_error_email").text("Campo requerido");
    $("#form_editar #msg_error_email").show();
  }
  else if( !validarEmail(email) )
  {
    $("#edit_email").focus();
    $("#form_editar #msg_error_email").text("E-mail inválida");
    $("#form_editar #msg_error_email").show();
  }
  else if( etnia === "")
  {
    $("#edit_etnia").focus();
    $("#form_editar #msg_error_etnia").show();
  }
  else{
    $("#btn_guardar_edit").button("loading"); //Cambiar estado del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_empleados.php",
        data: {
                opcion      : 3,
                id          : id,
                tipo        : tipo,
                nombre      : nombre,
                nombre2     : nombre2,
                apellido    : apellido,
                apellido2   : apellido2,
                fechaExp    : fechaExp,
                ciudadExp   : ciudadExp,
                fechaNac    : fechaNac,
                ciudadNac   : ciudadNac,
                paisNac     : paisNac,
                genero      : genero,
                estado      : estado,
                nivel       : nivel,
                titulo      : titulo,
                direccion   : direccion,
                barrio      : barrio,
                estrato     : estrato,
                ciudad      : ciudad,
                telefono    : telefono,
                celular     : celular,
                email       : email,
                etnia       : etnia,
                comentario  : comentario
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
            jAlert('Datos basicos editados con éxito.', 'Editar Empleado', function(e){
              recargarDatos();
            });
          }
            else if(res.status === "EXPIRED" )//Sesión finalizada
            {
              jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
                window.location = "cerrar_sesion.php";
              });
            }
            else if( res.status === "ERROR")
            {
              jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
            }
            $("#btn_guardar_edit").button("reset");//Restaurar boton guardar
        }
    });
  }
  $('#modalEditar').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormEdit();
  });
}
/**
* Función encargada de editar eps
*/
function editarEpsEmpleado(id,doc,name,lastName){
  var id = id;
  var documentoEps = doc;
  var nombreEps = name;
  var apellidoEps = lastName;
  //Consultar EPS
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
        { 
          //lista EPS
          var eps = "";
          for( var e=0; e < res.eps.length; e++ )
          {
            eps += '<option value="'+ res.eps[e].id +'">'+ res.eps[e].nombre +'</option>';
          }
          //lista Tipo Tramites
          var tramite = "";
          for( var t=0; t < res.tramite.length; t++ )
          {
            tramite += '<option value="'+ res.tramite[t].id +'">'+ res.tramite[t].nombre +'</option>';
          }
          //lista Tipo Afiliaciones
          var afiliacion = "";
          for( var a=0; a < res.afiliacion.length; a++ )
          {
            afiliacion += '<option value="'+ res.afiliacion[a].id +'">'+ res.afiliacion[a].nombre +'</option>';
          }
          //lista Tipo Afiliación
          var afiliado = "";
          for( var i=0; i < res.afiliado.length; i++ )
          {
            afiliado += '<option value="'+ res.afiliado[i].id +'">'+ res.afiliado[i].nombre +'</option>';
          }
          //lista Tipo Cotizante
          var cotizante = "";
          for( var c=0; c < res.cotizante.length; c++ )
          {
            cotizante += '<option value="'+ res.cotizante[c].id +'">'+ res.cotizante[c].nombre +'</option>';
          }

          $("#edit_tipo_cotizante_eps").val("");
          //Ocultar mensajes error
          $(".alert").fadeOut();
          //Asignar Documento para relacionar
          $("#edit_NombreEps").html(nombreEps);
          $("#edit_ApellidoEps").html(apellidoEps);
          $("#edit_DocumentoEps").html(documentoEps);

          //asignar valores
          $("#edit_eps").html( eps );
          $("#edit_tipo_tramite_eps").html( tramite );
          $("#edit_tipo_afiliacion_eps").html( afiliacion );
          $("#edit_tipo_afiliado_eps").html( afiliado );
          $("#edit_tipo_cotizante_eps").html( cotizante );
        }
        else if(res.status === "EXPIRED" )//Sesión finalizada
        {
          jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
            window.location = "cerrar_sesion.php";
          });
        }
        else if( res.status === "ERROR")
        {
          jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
        }
    }
  });
  $('#modalEditar').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormEdit();
  });
}
/**
* Funcion encargada de consultar los datos de eps del empleado
*/
function consultarEpsEmpleado(id){
  //consultar datos seg soc empleado
  var id = id;
  $.ajax(
  {
    cache: false,
    type: "POST",
    url: "querys/gestion_empleados.php",
    data: {
            opcion  : 10,
            id      : id
          },
    dataType: "json",
    success: function(res)
    {
      if( res.status === "OK" )
      {
        //Asignar Valores
        var idEmpleado = "";
        var eps = "";
        var fecha = "";
        var tramite = "";
        var afiliacion = "";
        var afiliado = "";
        var cotizante = "";
        var regimen = "";
        for( var i=0; i < res.epsEmpleado.length; i++ )
        {
          idEmpleado += res.epsEmpleado[i].idEmpleado;
          eps += res.epsEmpleado[i].IdEps;
          fecha += res.epsEmpleado[i].fecha;
          tramite += res.epsEmpleado[i].IdTramite;
          afiliacion += res.epsEmpleado[i].IdAfiliacion;
          afiliado += res.epsEmpleado[i].IdAfiliado;
          cotizante += res.epsEmpleado[i].IdCotizante;
          regimen += res.epsEmpleado[i].regimen;
        }
        var fechar_array = fecha.split("-");
        var fecha_rad = fechar_array[2] +"-"+ fechar_array[1] +"-"+ fechar_array[0]; //dd-mm-yyyy
        if (eps != ""){
          // asignar datos
          $("#edit_eps").val(eps);
          $("#edit_fecha_radicacion_eps").val(fecha_rad);
          $("#edit_tipo_tramite_eps").val(tramite);
          $("#edit_tipo_afiliacion_eps").val(afiliacion);
          $("#edit_tipo_afiliado_eps").val(afiliado);
          $("#edit_tipo_cotizante_eps").val(cotizante);
          $("#edit_regimen_eps").val(regimen);
        }
        else if (eps === ""){
          $(".edit_id_empleado_eps").val(idEmpleado);
        }
        
      }
      else if(res.status === "EXPIRED" )//Sesión finalizada
      {
        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }
      else if( res.status === "ERROR")
      {
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
  $('#modalEditar').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormEdit();
  });
}
/**
* Funcion encargada de guardar la edicion eps Empleado
*/
function guardarEdicionEps(){
  var idEmpleado = $("#edit_id_empleado").val();
  var idEps = $("#edit_eps").val();
  var nEps = $( "#edit_eps option:selected" ).text();
  var fechaRadicacion = $("#edit_fecha_radicacion_eps").val();
  var fechar_array = fechaRadicacion.split("-");
  var fecha_rad = fechar_array[2] +"-"+ fechar_array[1] +"-"+ fechar_array[0]; //yyyy-mm-dd
  var tipoTramite = $("#edit_tipo_tramite_eps").val();
  var nTipoTramite = $( "#edit_tipo_tramite_eps option:selected" ).text();
  var tipoAfiliacion = $("#edit_tipo_afiliacion_eps").val();
  var nTipoAfiliacion = $( "#edit_tipo_afiliacion_eps option:selected" ).text();
  var tipoAfiliado = $("#edit_tipo_afiliado_eps").val();
  var nTipoAfiliado = $( "#edit_tipo_afiliado_eps option:selected" ).text();
  var tipoCotizante = $("#edit_tipo_cotizante_eps").val();
  var nTipoCotizante = $( "#edit_tipo_cotizante_eps option:selected" ).text();
  var regimen = $("#edit_regimen_eps").val();
  //Validar campos requeridos
  if( idEmpleado === "")
  {
    jAlert('no trajo el Id Empleado', 'Error');
  }
  else if( idEps === "null")
  {
    $("#edit_eps").focus();
    $("#form_editar #msg_error_eps").show();
  }
  else if( fechaRadicacion === "")
  {
    $("#edit_fecha_radicacion_eps").focus();
    $("#form_editar #msg_error_fechaRad_eps").show();
  }
  else if( tipoTramite === "null")
  {
    $("#edit_tipo_tramite_eps").focus();
    $("#form_editar #msg_error_tramite_eps").show();
  }
  else if( tipoAfiliacion === "null")
  {
    $("#edit_tipo_afiliacion_eps").focus();
    $("#form_editar #msg_error_afiliacion_eps").show();
  }
  else if( tipoAfiliado === "null" )
  {
    $("#edit_tipo_afiliado_eps").focus();
    $("#form_editar #msg_error_afiliado_eps").show();
  }
  else if( tipoCotizante === "null")
  {
    $("#edit_tipo_cotizante_eps").focus();
    $("#form_editar #msg_error_cotizante_eps").show();
  }
  else if( regimen === "null")
  {
    $("#edit_regimen_eps").focus();
    $("#form_editar #msg_error_regimen_eps").show();
  }
  else{
    jConfirm('<form id="form_v" role="form"><div class="row form-group"><label class="col-sm-6" for="v_nombre">E.P.S:</label><div class="col-sm-6"><input type="text" id="v_nombre" name="v_nombre" class="form-control" value="'+nEps+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_nombre2">Fecha Radicación:</label><div class="col-sm-6"><input type="text" id="v_nombre2" name="v_nombre2" class="form-control" value="'+fecha_rad+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_apellido">Tipo Trámite:</label><div class="col-sm-6"><input type="text" id="v_apellido" name="v_apellido" class="form-control" value="'+nTipoTramite+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_apellido2">Tipo Afiliación:</label><div class="col-sm-6"><input type="text" id="v_apellido2" name="v_apellido2" class="form-control" value="'+nTipoAfiliacion+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_documento">Tipo Afiliado:</label><div class="col-sm-6"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+nTipoAfiliado+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_documento">Tipo Cotizante:</label><div class="col-sm-6"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+nTipoCotizante+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_documento">Regimen:</label><div class="col-sm-6"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+regimen+'"></div></div></form>', 'Los datos son correctos?', function(r) {     
      if(r)
        {
          editarEps();
        }
     });
    function editarEps()
    {
      $("#btn_guardar_editar").button("loading"); //Cambiar estado del botón guardarNuevo
      $.ajax(
      {
          cache: false,
          type: "POST",
          url: "querys/gestion_empleados.php",
          data: {
                  opcion            :   11,
                  idEmpleado        :   idEmpleado,
                  idEps             :   idEps,
                  fecha_rad         :   fecha_rad,
                  tipoTramite       :   tipoTramite,
                  tipoAfiliacion    :   tipoAfiliacion,
                  tipoAfiliado      :   tipoAfiliado,
                  tipoCotizante     :   tipoCotizante,
                  regimen           :   regimen
                },
          dataType: "json",
          success: function(res)
          {
              if( res.status === "OK" )
              {
                jAlert('Datos de E.P.S. editados con éxito.', 'Datos E.P.S.', function(){
                  recargarDatos();
                });
              }
              else if(res.status === "EXPIRED" )//Sesión finalizada
              {
                jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
                  window.location = "cerrar_sesion.php";
                });
              }else if( res.status === "ERROR")
              {
                jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
                //console.log(res.sql);
              }
              $("#btn_guardar_editar").button("reset");//Restaurar boton guardar
          }
      });
    }
  }
  $('#modalEditar').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormEdit();
  });
}
/**
* Función encargada de editar arl
*/
function editarArlEmpleado(id,doc,name,lastName){
  var id = id;
  var documentoArl = doc;
  var nombreArl = name;
  var apellidoArl = lastName;
  //Consultar EPS
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
      { 
        //lista ARL
        var arl = "";
        for( var e=0; e < res.arl.length; e++ )
        {
          arl += '<option value="'+ res.arl[e].id +'">'+ res.arl[e].nombre +'</option>';
        }
        //Ocultar mensajes error
        $(".alert").fadeOut();
        //Asignar Documento para relacionar
        $("#edit_NombreArl").html(nombreArl);
        $("#edit_ApellidoArl").html(apellidoArl);
        $("#edit_DocumentoArl").html(documentoArl);
        //asignar valores
        $("#edit_arl").html( arl );
      }
      else if(res.status === "EXPIRED" )//Sesión finalizada
      {
        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }
      else if( res.status === "ERROR")
      {
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
  $('#modalEditar').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormEdit();
  });
}
/**
* Funcion encargada de consultar los datos de arl del empleado
*/
function consultarArlEmpleado(id){
  //consultar datos arl empleado
  var id = id;
  $.ajax(
  {
    cache: false,
    type: "POST",
    url: "querys/gestion_empleados.php",
    data: {
            opcion  : 13,
            id      : id
          },
    dataType: "json",
    success: function(res)
    {
      if( res.status === "OK" )
      {
        //Asignar Valores
        var idEmpleado = "";
        var arl = "";
        var fecha = "";
        var codigo = "";
        for( var i=0; i < res.arlEmpleado.length; i++ )
        {
          idEmpleado += res.arlEmpleado[i].idEmpleado;
          arl += res.arlEmpleado[i].idArl;
          fecha += res.arlEmpleado[i].fecha;
          codigo += res.arlEmpleado[i].codigo;
        }
        if (arl != ""){
          // asignar datos
          $("#edit_arl").val( arl );
          $("#edit_fecha_afiliacion_arl").val( fecha );
          $("#edit_codigo_transaccion_arl").val( codigo );
        }
        else if (arl === ""){
          $(".edit_id_empleado_arl").val(idEmpleado);
        }
        
      }
      else if(res.status === "EXPIRED" )//Sesión finalizada
      {
        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }
      else if( res.status === "ERROR")
      {
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
  $('#modalEditar').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormEdit();
  });
}
/**
* Funcion encargada de guardar la edicion arl Empleado
*/
function guardarEdicionArl(){
  var idEmpleado = $("#edit_id_empleado").val();
  var idArl = $("#edit_arl").val();
  var nArl = $( "#edit_arl option:selected" ).text();
  var fechaAfiliacion = $("#edit_fecha_afiliacion_arl").val();
  var fechar_array = fechaAfiliacion.split("-");
  var fecha_afi = fechar_array[2] +"-"+ fechar_array[1] +"-"+ fechar_array[0]; //yyyy-mm-dd
  var codigo = $("#edit_codigo_transaccion_arl").val();
  //Validar campos requeridos
  if( idEmpleado === "")
  {
    jAlert('no trajo el Id Empleado', 'Error');
  }
  else if( idArl === "null")
  {
    $("#edit_arl").focus();
    $("#form_editar #msg_error_arl").show();
  }
  else if( fechaAfiliacion === "")
  {
    $("#edit_fecha_afiliacion_arl").focus();
    $("#form_editar #msg_error_fechaAfi_arl").show();
  }
  else if( codigo === "")
  {
    $("#edit_tipo_tramite_arl").focus();
    $("#form_editar #edit_codigo_transaccion_arl").show();
  }  
  else{
    jConfirm('<form id="form_v" role="form"><div class="row form-group"><label class="col-sm-6" for="v_nombre">A.R.L:</label><div class="col-sm-6"><input type="text" id="v_nombre" name="v_nombre" class="form-control" value="'+nArl+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_nombre2">Fecha Radicación:</label><div class="col-sm-6"><input type="text" id="v_nombre2" name="v_nombre2" class="form-control" value="'+fechaAfiliacion+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_apellido">Tipo Trámite:</label><div class="col-sm-6"><input type="text" id="v_apellido" name="v_apellido" class="form-control" value="'+codigo+'"></div></div></form>', 'Los datos son correctos?', function(r) {     
      if(r)
        {
          editarArl();
        }
     });
    function editarArl()
    {
      $("#btn_guardar_editar").button("loading"); //Cambiar estado del botón guardarNuevo
      $.ajax(
      {
          cache: false,
          type: "POST",
          url: "querys/gestion_empleados.php",
          data: {
                  opcion         :   14,
                  idEmpleado     :   idEmpleado,
                  idArl          :   idArl,
                  fecha_afi      :   fecha_afi,
                  codigo         :   codigo
                },
          dataType: "json",
          success: function(res)
          {
              if( res.status === "OK" )
              {
                jAlert('Datos de A.R.L. editados con éxito.', 'Datos A.R.L.', function(){
                  recargarDatos();
                });
              }
              else if(res.status === "EXPIRED" )//Sesión finalizada
              {
                jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
                  window.location = "cerrar_sesion.php";
                });
              }else if( res.status === "ERROR")
              {
                jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
                //console.log(res.sql);
              }
              $("#btn_guardar_editar").button("reset");//Restaurar boton guardar
          }
      });
    }
  }
  $('#modalEditar').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormEdit();
  });
}
/**
* Función encargada de editar pension
*/
function editarPensionEmpleado(id,doc,name,lastName){
  var id = id;
  var documentoPension = doc;
  var nombrePension = name;
  var apellidoPension = lastName;
  //Consultar pension
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
      { 
        //lista pension
        var pension = "";
        for( var e=0; e < res.pension.length; e++ )
        {
          pension += '<option value="'+ res.pension[e].id +'">'+ res.pension[e].nombre +'</option>';
        }
        //Ocultar mensajes error
        $(".alert").fadeOut();
        //Asignar Documento para relacionar
        $("#edit_NombrePension").html(nombrePension);
        $("#edit_ApellidoPension").html(apellidoPension);
        $("#edit_DocumentoPension").html(documentoPension);
        //asignar valores
        $("#edit_pension").html( pension );
      }
      else if(res.status === "EXPIRED" )//Sesión finalizada
      {
        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }
      else if( res.status === "ERROR")
      {
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
  $('#modalEditar').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormEdit();
  });
}
/**
* Funcion encargada de consultar los datos de pension del empleado
*/
function consultarPensionEmpleado(id){
  //consultar datos pension empleado
  var id = id;
  $.ajax(
  {
    cache: false,
    type: "POST",
    url: "querys/gestion_empleados.php",
    data: {
            opcion  : 16,
            id      : id
          },
    dataType: "json",
    success: function(res)
    {
      if( res.status === "OK" )
      {
        //Asignar Valores
        var idEmpleado = "";
        var pension = "";
        var fecha = "";
        for( var i=0; i < res.pensionEmpleado.length; i++ )
        {
          pension += res.pensionEmpleado[i].idPension;
          fecha += res.pensionEmpleado[i].fecha;
        }
        if (pension != ""){
          // asignar datos
          $("#edit_pension").val(pension);
          $("#edit_fecha_afiliacion_pension").val(fecha);
        }
        else if (pension === ""){
          $(".edit_id_empleado_pension").val(idEmpleado);
        }
      }
      else if(res.status === "EXPIRED" )//Sesión finalizada
      {
        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }
      else if( res.status === "ERROR")
      {
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
  $('#modalEditar').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormEdit();
  });
}
/**
* Funcion encargada de guardar la edicion pension Empleado
*/
function guardarEdicionPension(){
  var idEmpleado = $("#edit_id_empleado").val();
  var idPension = $("#edit_pension").val();
  var nPension = $("#edit_pension option:selected").text();
  var fechaAfiliacion = $("#edit_fecha_afiliacion_pension").val();
  var fechar_array = fechaAfiliacion.split("-");
  var fecha_afi = fechar_array[2] +"-"+ fechar_array[1] +"-"+ fechar_array[0]; //yyyy-mm-dd
  //Validar campos requeridos
  if( idEmpleado === "")
  {
    jAlert('no trajo el Id Empleado', 'Error');
  }
  else if( idPension === "null")
  {
    $("#edit_pension").focus();
    $("#form_editar #msg_error_pension").show();
  }
  else if( fechaAfiliacion === "")
  {
    $("#edit_fecha_afiliacion_pension").focus();
    $("#form_editar #msg_error_fechaAfi_pension").show();
  } 
  else{
    jConfirm('<form id="form_v" role="form"><div class="row form-group"><label class="col-sm-6" for="v_nombre">Fondo de Pensión:</label><div class="col-sm-6"><input type="text" id="v_nombre" name="v_nombre" class="form-control" value="'+nPension+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_nombre2">Fecha Afiliación:</label><div class="col-sm-6"><input type="text" id="v_nombre2" name="v_nombre2" class="form-control" value="'+fechaAfiliacion+'"></div></div></form>', 'Los datos son correctos?', function(r) {     
      if(r)
        {
          editarPension();
        }
     });
    function editarPension()
    {
      $("#btn_guardar_editar").button("loading"); //Cambiar estado del botón guardarNuevo
      $.ajax(
      {
          cache: false,
          type: "POST",
          url: "querys/gestion_empleados.php",
          data: {
                  opcion         :   17,
                  idEmpleado     :   idEmpleado,
                  idPension      :   idPension,
                  fecha_afi      :   fecha_afi
                },
          dataType: "json",
          success: function(res)
          {
              if( res.status === "OK" )
              {
                jAlert('Datos de Pensión editados con éxito.', 'Datos Pensión.', function(){
                  recargarDatos();
                });
              }
              else if(res.status === "EXPIRED" )//Sesión finalizada
              {
                jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
                  window.location = "cerrar_sesion.php";
                });
              }else if( res.status === "ERROR")
              {
                jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
                //console.log(res.sql);
              }
              $("#btn_guardar_editar").button("reset");//Restaurar boton guardar
          }
      });
    }
  }
  $('#modalEditar').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormEdit();
  });
}
/**
* Función encargada de editar caja
*/
function editarCajaEmpleado(id,doc,name,lastName){
  var id = id;
  var documentoCaja = doc;
  var nombreCaja = name;
  var apellidoCaja = lastName;
  //Consultar caja
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
      { 
        //lista caja
        var caja = "";
        for( var e=0; e < res.caja.length; e++ )
        {
          caja += '<option value="'+ res.caja[e].id +'">'+ res.caja[e].nombre +'</option>';
        }
        //Ocultar mensajes error
        $(".alert").fadeOut();
        //Asignar Documento para relacionar
        $("#edit_NombreCaja").html(nombreCaja);
        $("#edit_ApellidoCaja").html(apellidoCaja);
        $("#edit_DocumentoCaja").html(documentoCaja);
        //asignar valores
        $("#edit_caja").html( caja );
      }
      else if(res.status === "EXPIRED" )//Sesión finalizada
      {
        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }
      else if( res.status === "ERROR")
      {
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
  $('#modalEditar').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormEdit();
  });
}
/**
* Funcion encargada de consultar los datos de caja del empleado
*/
function consultarCajaEmpleado(id){
  //consultar datos caja empleado
  var id = id;
  $.ajax(
  {
    cache: false,
    type: "POST",
    url: "querys/gestion_empleados.php",
    data: {
            opcion  : 19,
            id      : id
          },
    dataType: "json",
    success: function(res)
    {
      if( res.status === "OK" )
      {
        //Asignar Valores
        var idEmpleado = "";
        var caja = "";
        for( var i=0; i < res.cajaEmpleado.length; i++ )
        {
          idEmpleado += res.cajaEmpleado[i].idEmpleado;
          caja += res.cajaEmpleado[i].idCaja;
        }
        if (caja != ""){
          // asignar datos
          $("#edit_caja").val(caja);
        }
        else if (caja === ""){
          $(".edit_id_empleado_caja").val(idEmpleado);
        }
      }
      else if(res.status === "EXPIRED" )//Sesión finalizada
      {
        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }
      else if( res.status === "ERROR")
      {
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
  $('#modalEditar').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormEdit();
  });
}
/**
* Funcion encargada de guardar la edicion caja Empleado
*/
function guardarEdicionCaja(){
  var idEmpleado = $("#edit_id_empleado").val();
  var idCaja = $("#edit_caja").val();
  var nCaja = $("#edit_caja option:selected").text();
  //Validar campos requeridos
  if( idEmpleado === "")
  {
    jAlert('no trajo el Id Empleado', 'Error');
  }
  else if( idCaja === "null")
  {
    $("#edit_caja").focus();
    $("#form_editar #msg_error_caja").show();
  }
  else{
    jConfirm('<form id="form_v" role="form"><div class="row form-group"><label class="col-sm-6" for="v_nombre">Caja de Compensación:</label><div class="col-sm-6"><input type="text" id="v_nombre" name="v_nombre" class="form-control" value="'+nCaja+'"></div></div></form>', 'Los datos son correctos?', function(r) {     
      if(r)
        {
          editarCaja();
        }
     });
    function editarCaja()
    {
      $("#btn_guardar_editar").button("loading"); //Cambiar estado del botón guardarNuevo
      $.ajax(
      {
          cache: false,
          type: "POST",
          url: "querys/gestion_empleados.php",
          data: {
                  opcion      :   20,
                  idEmpleado  :   idEmpleado,
                  idCaja      :   idCaja,
                },
          dataType: "json",
          success: function(res)
          {
              if( res.status === "OK" )
              {
                jAlert('Datos de Casa de Compensación editados con éxito.', 'Datos Caja de Compensación.', function(){
                  recargarDatos();
                });
              }
              else if(res.status === "EXPIRED" )//Sesión finalizada
              {
                jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
                  window.location = "cerrar_sesion.php";
                });
              }else if( res.status === "ERROR")
              {
                jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
                //console.log(res.sql);
              }
              $("#btn_guardar_editar").button("reset");//Restaurar boton guardar
          }
      });
    }
  }
  $('#modalEditar').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormEdit();
  });
}
/**
* Función encargada de editar referencias
*/
function editarReferenciasEmpleado(id,doc,name,lastName){
  var id = id;
  var documentoReferencias = doc;
  var nombreReferencias = name;
  var apellidoReferencias = lastName;
  //Consultar referencias
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
      { 
        //lista referencias
        var parentesco = "";
        for( var e=0; e < res.parentesco.length; e++ )
        {
          parentesco += '<option value="'+ res.parentesco[e].id +'">'+ res.parentesco[e].nombre +'</option>';
        } 
        //Ocultar mensajes error
        $(".alert").fadeOut();
        //Asignar Documento para relacionar
        $("#edit_nombreRef").html(nombreReferencias);
        $("#edit_apellidoRef").html(apellidoReferencias);
        $("#edit_documentoRef").html(documentoReferencias);
        //asignar valores
        $("#edit_parentesco_ref").html( parentesco );
        $("#edit_parentesco_ref1").html( parentesco );
        $("#edit_parentesco_ref2").html( parentesco );

      }
      else if(res.status === "EXPIRED" )//Sesión finalizada
      {
        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }
      else if( res.status === "ERROR")
      {
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
  $('#modalEditar').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormEdit();
  });
}
/**
* Funcion encargada de consultar los datos de referencias del empleado
*/
function consultarReferenciasEmpleado(id){  
  //consultar datos referencias empleado
  var id = id;
  $.ajax(
  {
    cache: false,
    type: "POST",
    url: "querys/gestion_empleados.php",
    data: {
            opcion  : 22,
            id      : id
          },
    dataType: "json",
    success: function(res)
    {
      if( res.status === "OK" )
      {
        $("#modalSpinner").modal("show"); // muestra spinner
        //Asignar Valores
        var datosReferencia = '';
        var idEmpleado = '';
        for( var i=0; i < res.referenciasEmpleado.length; i++ )
        {
          var idReferencia = res.referenciasEmpleado[i].idReferencia;
          idEmpleado = res.referenciasEmpleado[i].idEmpleado;
          datosReferencia += '<div class="panel panel-default" id="ref'+ res.referenciasEmpleado[i].idReferencia +'"><div class="panel-heading"><strong>Referencia # <span id="idReferencia">'+ res.referenciasEmpleado[i].idReferencia +'</span></strong><input type="hidden" id="idEmpleado" name="idEmpleado" value="'+ res.referenciasEmpleado[i].idEmpleado +'"></div><div class="panel-body"><div class="row"><div class="col-lg-12"><form id="form_editar" role="form"><div class="row form-group"><div class="col-xs-12 col-sm-6 col-md-3 margen"><label for="edit_nombre_ref">Nombre:</label><input type="text" id="edit_nombre_ref" name="edit_nombre_ref" class="form-control" value="'+ res.referenciasEmpleado[i].nombres +'"><div id="msg_error_nombre_ref" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div></div><div class="col-xs-12 col-sm-6 col-md-3 margen"><label for="edit_apellido_ref">Apellido:</label><input type="text" id="edit_apellido_ref" name="edit_apellido_ref" class="form-control" value="'+ res.referenciasEmpleado[i].apellidos +'"><div id="msg_error_apellido_ref" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div></div><div class="col-xs-12 col-sm-6 col-md-3 margen"><label for="edit_parentesco">Parentesco:</label><div class="input-group"><select id="edit_parentesco_ref" name="edit_parentesco" class="form-control">'+ res.referenciasEmpleado[i].lista_parentesco +'</select><div class="input-group-addon add"><span id="edit_estrato_icon" class="fa fa-plus cursor" onclick="addParentezco()"></span></div></div><div id="msg_error_parentesco_ref" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div></div><div class="col-xs-12 col-sm-6 col-md-3 margen"><label for="edit_telefono_ref">Teléfono:</label><input type="text" id="edit_telefono_ref" name="edit_telefono_ref" class="form-control" value="'+ res.referenciasEmpleado[i].telefono +'"><div id="msg_error_telefono_ref" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div></div></div></form></div></div></div></div>';
        }
        $("#contador_referencias").val(res.referenciasEmpleado.length);
        if (idReferencia != "")
        {
          // asignar datos
          $(".edit_id_empleado_referencias").val(id);
          $("#editReferencia").show();
          $("#newReferencia").hide();
          $("#edit_DatosReferencias").html(datosReferencia);
          $("#modalSpinner").modal("hide"); // hide spinner
        }
        else if (idReferencia === "")
        { 
          $("#modalSpinner").modal("show"); // muestra spinner
          $(".edit_id_empleado_referencias").val(id);          
          $("#edit_DatosReferencias").html('<div class="panel panel-default"><div class="panel-heading">    <strong>Referencia # 1</strong></div><div class="panel-body">    <div class="row"><div class="col-lg-12">  <form id="form_editar" role="form">    <!-- row -->    <div class="row form-group">      <div class="col-xs-12 col-sm-6 col-md-3 margen">        <label for="edit_nombre_ref1">Nombre:</label>        <input type="text" id="edit_nombre_ref1" name="edit_nombre_ref1" class="form-control" placeholder="Nombre">        <div id="msg_error_nombre_ref1" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>      </div>      <div class="col-xs-12 col-sm-6 col-md-3 margen">        <label for="edit_apellido_ref1">Apellido:</label>        <input type="text" id="edit_apellido_ref1" name="edit_apellido_ref1" class="form-control" placeholder="Apellido">        <div id="msg_error_apellido_ref1" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>      </div>      <div class="col-xs-12 col-sm-6 col-md-3 margen">        <label for="edit_parentesco">Parentesco:</label>        <div class="input-group">          <select id="edit_parentesco_ref1" name="edit_parentesco" class="form-control">            <option value="null">--Parentesco--</option>          </select>          <div class="input-group-addon add">              <span id="edit_estrato_icon" class="fa fa-plus cursor" onclick="addParentezco()"></span>          </div>        </div>        <div id="msg_error_parentesco_ref1" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>      </div>      <div class="col-xs-12 col-sm-6 col-md-3 margen">        <label for="edit_telefono_ref1">Teléfono:</label>        <input type="text" id="edit_telefono_ref1" name="edit_telefono_ref1" class="form-control" placeholder="Teléfono">        <div id="msg_error_telefono_ref1" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>      </div>    </div>    <!-- /row -->  </form></div><!-- /.col-lg-12 (nested) --></div><!-- /.row (nested) --></div></div><div class="panel panel-default"><div class="panel-heading">    <strong>Referencia # 2</strong></div><div class="panel-body">    <div class="row"><div class="col-lg-12">  <form id="form_editar" role="form">    <!-- row -->    <div class="row form-group">      <div class="col-xs-12 col-sm-6 col-md-3 margen">        <label for="edit_nombre_ref1">Nombre:</label>        <input type="text" id="edit_nombre_ref2" name="edit_nombre_ref2" class="form-control" placeholder="Nombre">        <div id="msg_error_nombre_ref2" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>      </div>      <div class="col-xs-12 col-sm-6 col-md-3 margen">        <label for="edit_apellido_ref2">Apellido:</label>        <input type="text" id="edit_apellido_ref2" name="edit_apellido_ref2" class="form-control" placeholder="Apellido">        <div id="msg_error_apellido_ref2" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>      </div>      <div class="col-xs-12 col-sm-6 col-md-3 margen">        <label for="edit_parentesco">Parentesco:</label>        <div class="input-group">          <select id="edit_parentesco_ref2" name="edit_parentesco" class="form-control">            <option value="null">--Parentesco--</option>          </select>          <div class="input-group-addon add">              <span id="edit_estrato_icon" class="fa fa-plus cursor" onclick="addParentezco()"></span>          </div>        </div>        <div id="msg_error_parentesco_ref2" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>      </div>      <div class="col-xs-12 col-sm-6 col-md-3 margen">        <label for="edit_telefono_ref2">Teléfono:</label>        <input type="text" id="edit_telefono_ref2" name="edit_telefono_ref2" class="form-control" placeholder="Teléfono">        <div id="msg_error_telefono_ref2" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>      </div>    </div>    <!-- /row -->  </form></div><!-- /.col-lg-12 (nested) --></div><!-- /.row (nested) --></div></div>');
          $("#editReferencia").hide();
          $("#newReferencia").show();
          editarReferenciasEmpleado(id);
          $("#modalSpinner").modal("hide"); // muestra spinner
        }
      }
      else if (res.status === "EMPTY")
      { 
        $("#modalSpinner").modal("show"); // muestra spinner
        $(".edit_id_empleado_referencias").val(id);
        $("#edit_DatosReferencias").html('<div class="panel panel-default"><div class="panel-heading">    <strong>Referencia # 1</strong></div><div class="panel-body">    <div class="row"><div class="col-lg-12">  <form id="form_editar" role="form">    <!-- row -->    <div class="row form-group">      <div class="col-xs-12 col-sm-6 col-md-3 margen">        <label for="edit_nombre_ref1">Nombre:</label>        <input type="text" id="edit_nombre_ref1" name="edit_nombre_ref1" class="form-control" placeholder="Nombre">        <div id="msg_error_nombre_ref1" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>      </div>      <div class="col-xs-12 col-sm-6 col-md-3 margen">        <label for="edit_apellido_ref1">Apellido:</label>        <input type="text" id="edit_apellido_ref1" name="edit_apellido_ref1" class="form-control" placeholder="Apellido">        <div id="msg_error_apellido_ref1" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>      </div>      <div class="col-xs-12 col-sm-6 col-md-3 margen">        <label for="edit_parentesco">Parentesco:</label>        <div class="input-group">          <select id="edit_parentesco_ref1" name="edit_parentesco" class="form-control">            <option value="null">--Parentesco--</option>          </select>          <div class="input-group-addon add">              <span id="edit_estrato_icon" class="fa fa-plus cursor" onclick="addParentezco()"></span>          </div>        </div>        <div id="msg_error_parentesco_ref1" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>      </div>      <div class="col-xs-12 col-sm-6 col-md-3 margen">        <label for="edit_telefono_ref1">Teléfono:</label>        <input type="text" id="edit_telefono_ref1" name="edit_telefono_ref1" class="form-control" placeholder="Teléfono">        <div id="msg_error_telefono_ref1" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>      </div>    </div>    <!-- /row -->  </form></div><!-- /.col-lg-12 (nested) --></div><!-- /.row (nested) --></div></div><div class="panel panel-default"><div class="panel-heading">    <strong>Referencia # 2</strong></div><div class="panel-body">    <div class="row"><div class="col-lg-12">  <form id="form_editar" role="form">    <!-- row -->    <div class="row form-group">      <div class="col-xs-12 col-sm-6 col-md-3 margen">        <label for="edit_nombre_ref1">Nombre:</label>        <input type="text" id="edit_nombre_ref2" name="edit_nombre_ref2" class="form-control" placeholder="Nombre">        <div id="msg_error_nombre_ref2" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>      </div>      <div class="col-xs-12 col-sm-6 col-md-3 margen">        <label for="edit_apellido_ref2">Apellido:</label>        <input type="text" id="edit_apellido_ref2" name="edit_apellido_ref2" class="form-control" placeholder="Apellido">        <div id="msg_error_apellido_ref2" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>      </div>      <div class="col-xs-12 col-sm-6 col-md-3 margen">        <label for="edit_parentesco">Parentesco:</label>        <div class="input-group">          <select id="edit_parentesco_ref2" name="edit_parentesco" class="form-control">            <option value="null">--Parentesco--</option>          </select>          <div class="input-group-addon add">              <span id="edit_estrato_icon" class="fa fa-plus cursor" onclick="addParentezco()"></span>          </div>        </div>        <div id="msg_error_parentesco_ref2" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>      </div>      <div class="col-xs-12 col-sm-6 col-md-3 margen">        <label for="edit_telefono_ref2">Teléfono:</label>        <input type="text" id="edit_telefono_ref2" name="edit_telefono_ref2" class="form-control" placeholder="Teléfono">        <div id="msg_error_telefono_ref2" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div>      </div>    </div>    <!-- /row -->  </form></div><!-- /.col-lg-12 (nested) --></div><!-- /.row (nested) --></div></div>');
        $("#editReferencia").hide();
        $("#newReferencia").show();
        editarReferenciasEmpleado(id);
        $("#modalSpinner").modal("hide"); // muestra spinner
      }
      else if(res.status === "EXPIRED" )//Sesión finalizada
      {
        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }
      else if( res.status === "ERROR")
      {
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
  $('#modalEditar').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormEdit();
  });
}
/**
* Funcion encargada de guardar la edicion referencias Empleado
*/
function guardarEdicionReferencias(){
	var idEmpleado = $("#idEmpleado").val();
	var idReferencia1 = $("#ref1 #idReferencia").html();
	var nombreRef1 = $("#ref1 #edit_nombre_ref").val();
	var apellidoRef1 = $("#ref1 #edit_apellido_ref").val();
	var telefonoRef1 = $("#ref1 #edit_telefono_ref").val();
	var parentescoRef1 = $("#ref1 #edit_parentesco_ref").val();
	var idReferencia2 = $("#ref2 #idReferencia").html();
	var nombreRef2 = $("#ref2 #edit_nombre_ref").val();
	var apellidoRef2 = $("#ref2 #edit_apellido_ref").val();
	var telefonoRef2 = $("#ref2 #edit_telefono_ref").val();
	var parentescoRef2 = $("#ref2 #edit_parentesco_ref").val();

	var completo = true;
	var cantRef = $("#contador_referencias").val();

	for (var i=1; i<= cantRef; i++)
	{
		if( $("#ref"+i+" edit_nombre_ref").val() === "" )
		{
			completo = false;
			break;
		}
		if( $("#ref"+i+" edit_apellido_ref").val() === "" )
		{
			completo = false;
			break;
		}
		if( $("#ref"+i+" edit_parentesco_ref").val() === "" )
		{
			completo = false;
			break;
		}
		if( $("#ref"+i+" edit_telefono_ref").val() === "" )
		{
			completo = false;
			break;
		}
	}
  	if(!completo)
  	{
		jAlert('Campos Imcompletos', 'Error');
	}
	else
	{
  		var referencias = {};
		for (var i=1; i<= cantRef; i++)
		{
			var temporal = {};
			temporal.idEmpleado= $("#ref"+i+" #idEmpleado").val();
			temporal.idReferencia = $("#ref"+i+" #idReferencia").text();
			temporal.nombres = $("#ref"+i+" #edit_nombre_ref").val();
			temporal.apellidos = $("#ref"+i+" #edit_apellido_ref").val();
			temporal.parentesco = $("#ref"+i+" #edit_parentesco_ref").val();
			temporal.telefono = $("#ref"+i+" #edit_telefono_ref").val();
			referencias[i-1]=temporal;
		}
		//console.log(referencias);
	    jConfirm('<form id="form_v" role="form"><div class="row form-group"><label class="col-sm-6" for="v_nombre">Ref #1 Nombre:</label><div class="col-sm-6"><input type="text" id="v_nombre" name="v_nombre" class="form-control" value="'+nombreRef1+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_nombre2">Ref #1 Apellido:</label><div class="col-sm-6"><input type="text" id="v_nombre2" name="v_nombre2" class="form-control" value="'+apellidoRef1+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_apellido">Ref #1 Parentesco:</label><div class="col-sm-6"><input type="text" id="v_apellido" name="v_apellido" class="form-control" value="'+parentescoRef1+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_apellido2">Ref #1 Telefono:</label><div class="col-sm-6"><input type="text" id="v_apellido2" name="v_apellido2" class="form-control" value="'+telefonoRef1+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_documento">Ref #2 Nombre:</label><div class="col-sm-6"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+nombreRef2+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_documento">Ref #2 Apellido:</label><div class="col-sm-6"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+apellidoRef2+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_documento">Ref #2 Parentesco:</label><div class="col-sm-6"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+parentescoRef2+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_documento">Ref #2 Telefono:</label><div class="col-sm-6"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+telefonoRef2+'"></div></div></form>', 'Los datos son correctos?', function(r) {     
	      if(r)
	        {
	          
				$("#btn_guardar_editar").button("loading"); //Cambiar estado del botón guardarNuevo
				$.ajax(
				{
					cache: false,
					type: "POST",
					url: "querys/gestion_empleados.php",
					data: {
					      opcion        :   23,
					      referencias 	: 	referencias
					    },
					dataType: "json",
					success: function(res)
					{
					  console.log(res);
					  if( res.status === "OK" )
					  {
					    jAlert('Datos de Referencias Personales. editados con éxito.', 'Datos Referencias Personales.', function(){
					      recargarDatos();
					    });
					  }
					  else if(res.status === "EXPIRED" )//Sesión finalizada
					  {
					    jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
					      window.location = "cerrar_sesion.php";
					    });
					  }else if( res.status === "ERROR")
					  {
					    jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
					    //console.log(res.sql);
					  }
					  $("#btn_guardar_editar").button("reset");//Restaurar boton guardar
					}
			    });
	        }
	    });
    }
	$('#modalEditar').on('hidden.bs.modal', function () {
		// resetear campos …
		limpiarFormEdit();
	});
}
/**
* Función encargada de editar contrato
*/
function editarContratoEmpleado(id,doc,name,lastName){
  var id = id;
  var documentoEmpresa = doc;
  var nombreEmpresa = name;
  var apellidoEmpresa = lastName;
  //Consultar contrato
  $.ajax({
    cache: false,
    type: "POST",
    url: "querys/gestion_empleados.php",
    data: { opcion : 1 },
    dataType: "json",
    success: function(res){
        if( res.status === "OK" ){ 
          var empresas = "";
          var bancos = "";
          var cuentas = "";
          //lista empresas          
          for( var i=0; i < res.empresas.length; i++ ){
            empresas += '<option value="'+ res.empresas[i].id +'">'+ res.empresas[i].nombre +'</option>';
          }
          $("#edit_empresa").html( empresas );
          //lista bancos          
          for( var i=0; i < res.bancos.length; i++ ){
            bancos += '<option value="'+ res.bancos[i].id +'">'+ res.bancos[i].nombre +'</option>';
          }
          $("#edit_banco").html( bancos );
          //lista cuentas          
          for( var i=0; i < res.tipoCuentas.length; i++ ){
            cuentas += '<option value="'+ res.tipoCuentas[i].id +'">'+ res.tipoCuentas[i].nombre +'</option>';
          }
          $("#edit_tipo_cuenta").html( cuentas );          
          //Ocultar mensajes error
          $(".alert").fadeOut();
          //Asignar Documento para relacionar
          $("#edit_nombreContrato").html( nombreEmpresa );
          $("#edit_apellidoContrato").html( apellidoEmpresa );
          $("#edit_documentoContrato").html( documentoEmpresa );
        }
        else if(res.status === "EXPIRED" ){
          jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
            window.location = "cerrar_sesion.php";
          });
        }
        else if( res.status === "ERROR"){
          jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
        }
    }
  });
  $('#modalEditar').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormEdit();
  });
}
/**
* Funcion encargada de consultar los datos de contrato del empleado
*/
function consultarContratoEmpleado(id){
  //consultar datos contrato empleado
  var id = id;
  $.ajax({
    cache: false,
    type: "POST",
    url: "querys/gestion_empleados.php",
    data: {
            opcion  : 25,
            id      : id
          },
    dataType: "json",
    success: function(res) {
      if( res.status === "OK" ){
        //Asignar Valores
        var idEmpleado = "";
        var empresa = "";
        var cargo = "";
        var salario = "";
        var jornada = "";
        var servicioFunerario = "";
        var banco = "";
        var cuenta = "";
        var tipoCuenta = "";
        for( var i=0; i < res.contratoEmpleado.length; i++ ){
          idEmpleado += res.contratoEmpleado[i].idEmpleado;
          empresa  += res.contratoEmpleado[i].empresa;
          cargo += res.contratoEmpleado[i].cargo;
          salario += res.contratoEmpleado[i].salario;
          jornada += res.contratoEmpleado[i].jornada;
          servicioFunerario += res.contratoEmpleado[i].servicioFunerario;
          banco += res.contratoEmpleado[i].banco;
          cuenta += res.contratoEmpleado[i].cuenta;
          tipoCuenta += res.contratoEmpleado[i].tipoCuenta;
        }
        if (empresa != ""){
          // asignar datos
          $(".edit_id_empleado_contrato").val(idEmpleado);
          $("#edit_empresa").val(empresa);
          $("#edit_cargo").val(cargo);
          $("#edit_salario").val(salario);
          $("#edit_jornada").val(jornada);
          $("#edit_servicio_funerario").val(servicioFunerario);
          $("#edit_banco").val(banco);
          $("#edit_cuenta").val(cuenta);
          $("#edit_tipo_cuenta").val(tipoCuenta);
        }
        else if (empresa === ""){
          $(".edit_id_empleado_contrato").val(idEmpleado);
        }
      }
      else if(res.status === "EXPIRED" ){ 
        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }
      else if( res.status === "ERROR"){
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
  $('#modalEditar').on('hidden.bs.modal', function(){
    limpiarFormEdit();
  });
}
/**
* Funcion encargada de guardar la edicion contrato Empleado
*/
function guardarEdicionContrato(){
  var idEmpleado = $("#edit_id_empleado").val();
  var empresa = $("#edit_empresa").val();
  var nEmpresa = $("#edit_empresa option:selected").text();
  var cargo = $("#edit_cargo").val();
  var salario = $("#edit_salario").val();
  var jornada = $("#edit_jornada").val();
  var servicioFunerario = $("#edit_servicio_funerario").val();
  var nServicioFunerario = $("#edit_servicio_funerario option:selected").text();
  var banco = $("#edit_banco").val();
  var nBanco = $("#edit_banco option:selected").text();
  var cuenta = $("#edit_cuenta").val();
  var tipoCuenta = $("#edit_tipo_cuenta").val();
  var nTipoCuenta = $("#edit_tipo_cuenta option:selected").text();
  //Validar campos requeridos
  if( idEmpleado === ""){
    jAlert('no trajo el Id Empleado', 'Error');
  }
  else if( empresa === "null"){
    $("#edit_empresa").focus();
    $("#form_editar #msg_error_empresa").show();
  }
  else{
    jConfirm('<form id="form_v" role="form"><div class="row form-group"><label class="col-sm-6" for="v_nombre">Empresa:</label><div class="col-sm-6"><input type="text" id="v_nombre" name="v_nombre" class="form-control" value="'+nEmpresa+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_nombre2">Cargo:</label><div class="col-sm-6"><input type="text" id="v_nombre2" name="v_nombre2" class="form-control" value="'+cargo+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_apellido">Salario:</label><div class="col-sm-6"><input type="text" id="v_apellido" name="v_apellido" class="form-control" value="$ '+salario+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_apellido2">Jornada:</label><div class="col-sm-6"><input type="text" id="v_apellido2" name="v_apellido2" class="form-control" value="'+jornada+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_documento">Servicio Funerario:</label><div class="col-sm-6"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+nServicioFunerario+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_documento">Banco:</label><div class="col-sm-6"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+nBanco+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_documento">Cuenta:</label><div class="col-sm-6"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+cuenta+'"></div></div><div class="row form-group"><label class="col-sm-6" for="v_documento">Tipo Cuenta:</label><div class="col-sm-6"><input type="text" id="v_documento" name="v_documento" class="form-control" value="'+nTipoCuenta+'"></div></div></form>', 'Los datos son correctos?', function(r) {     
      if(r){
          editarContrato();
        }
     });
    function editarContrato(){
      $("#btn_guardar_editar").button("loading"); //Cambiar estado del botón guardarNuevo
      $.ajax({
        cache: false,
        type: "POST",
        url: "querys/gestion_empleados.php",
        data: {
                opcion      :   26,
                idEmpleado  :   idEmpleado,            
                empresa     :   empresa,
                cargo       :   cargo,
                salario     :   salario,
                jornada     :   jornada,
                servicioFunerario : servicioFunerario,
                banco       :   banco,
                cuenta      :   cuenta,
                tipoCuenta  :   tipoCuenta
              },
        dataType: "json",
        success: function(res){
          if( res.status === "OK" ){
            jAlert('Datos de Contrato. Editados con éxito.', 'Datos Contrato de Compensación.', function(){
              recargarDatos();
            });
          }
          else if(res.status === "EXPIRED" ){
            jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
              window.location = "cerrar_sesion.php";
            });
          }
          else if( res.status === "ERROR"){
            jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
            //console.log(res.sql);
          }
          $("#btn_guardar_editar").button("reset");//Restaurar boton guardar
        }
      });
    }
  }
  $('#modalEditar').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormEdit();
  });
}
/**
* FUNCION ENCARGADA DE LIMPIOAR LOS CAMPOS DEL FORMULARIO EDITAR
*/
function limpiarFormEdit(){
  // resetear campos …
  $("#foto").html('<img class="img-responsive" src="http://temporales.com.co/contratacion/images/foto.png">')
  $("#edit_nombreEmpleado").html("$nombre");
  $("#edit_apellidoEmpleado").html("$apellido");
  $("#edit_documentoEmpleado").html("$documento");
  $("#edit_id_empleado").val("");
  $("#edit_nombre").val("");
  $("#edit_nombre2").val("");
  $("#edit_apellido").val("");
  $("#edit_apellido2").val("");
  $("#edit_tipo").val("");
  $("#edit_documento").val("");
  $("#edit_fechaExp").val("");
  $("#edit_ciudadExp").val("");
  $("#edit_fechaNac").val("");
  $("#edit_ciudadNac").val("");
  $("#edit_paisNac").val("");
  $("#edit_genero").val("");
  $("#edit_estado").val("");
  $("#edit_nivel").val("");
  $("#edit_titulo").val("");
  $("#edit_direccion").val("");
  $("#edit_barrio").val("");
  $("#edit_estrato").val("");
  $("#edit_ciudad").val("");
  $("#edit_telefono").val("");
  $("#edit_celular").val("");
  $("#edit_email").val("");
  $("#edit_etnia").val("");
  $("#edit_comentario").val("");
  $(".edit_id_empleado_eps").val("");
  $("#edit_NombreEps").html("$nombre");
  $("#edit_ApellidoEps").html("$apellido");
  $("#edit_DocumentoEps").html("$documento");
  $("#edit_eps").val("");
  $("#edit_fecha_radicacion_eps").val("");
  $("#edit_tipo_tramite_eps").val("");
  $("#edit_tipo_afiliacion_eps").val("");
  $("#edit_tipo_afiliado_eps").val("");
  $("#edit_tipo_cotizante_eps").val("");
  $("#edit_regimen_eps").val("");
  $(".edit_id_empleado_arl").val("");
  $("#edit_NombreArl").html("$nombre");
  $("#edit_ApellidoArl").html("$apellido");
  $("#edit_DocumentoArl").html("$documento");
  $("#edit_arl").val( "" );
  $("#edit_fecha_afiliacion_arl").val( "" );
  $("#edit_codigo_transaccion_arl").val( "" );
  $(".edit_id_empleado_pension").val("");
  $("#edit_NombrePension").html("$nombre");
  $("#edit_ApellidoPension").html("$apellido");
  $("#edit_DocumentoPension").html("$documento");
  $("#edit_pension").val("");
  $("#edit_fecha_afiliacion_pension").val("");
  $(".edit_id_empleado_caja").val("");
  $("#edit_NombreCaja").html("$nombre");
  $("#edit_ApellidoCaja").html("$apellido");
  $("#edit_DocumentoCaja").html("$documento");
  $("#edit_caja").val("");
  $(".edit_id_empleado_contrato").val("");
  $("#edit_nombreEmpresa").html( "$nombre" );
  $("#edit_apellidoEmpresa").html( "$apellido" );
  $("#edit_documentoEmpresa").html( "$documento" );
  $("#edit_empresa").val("");
  $("#edit_cargo").val("");
  $("#edit_salario").val("");
  $("#edit_jornada").val("");
  $("#edit_servicio_funerario").val("");
  $("#edit_banco").val("");
  $("#edit_cuenta").val("");
  $("#edit_tipo_cuenta").val("");  
  $('#mytabsEdit a[href="#datosBasicosEdit"]').tab('show');
}
/* /// */
// VER //
/* /// */
/**
/**
* Función encargada de inicializar y abrir PopUp Ver Empleado
*/
function ver(id,nombre,nombre2,apellido,apellido2,tipo,documento,fechaExp,ciudadExp,fechaNac,ciudadNac,paisNac,genero,estado,nivel,titulo,direccion,barrio,estrato,ciudad,telefono,celular,email,etnia,comentario){
  $("#modalSpinner").modal("show");
  //Asignar Valores
  $("#ver_nombreEmpleado").html(nombre);
  $("#ver_apellidoEmpleado").html(apellido);
  $("#ver_documentoEmpleado").html(documento);
  $("#ver_id_empleado").val(id);
  $("#ver_nombre").val(nombre);
  $("#ver_nombre2").val(nombre2);
  $("#ver_apellido").val(apellido);
  $("#ver_apellido2").val(apellido2);
  $("#ver_tipo").val(tipo);
  $("#ver_documento").val(documento);
  $("#ver_fechaExp").val(fechaExp);
  $("#ver_ciudadExp").val(ciudadExp);
  $("#ver_fechaNac").val(fechaNac);
  $("#ver_ciudadNac").val(ciudadNac);
  $("#ver_paisNac").val(paisNac);
  $("#ver_genero").val(genero);
  $("#ver_estado").val(estado);
  $("#ver_nivel").val(nivel);
  $("#ver_titulo").val(titulo);
  $("#ver_direccion").val(direccion);
  $("#ver_barrio").val(barrio);
  $("#ver_estrato").val(estrato);
  $("#ver_ciudad").val(ciudad);
  $("#ver_telefono").val(telefono);
  $("#ver_celular").val(celular);
  $("#ver_email").val(email);
  $("#ver_etnia").val(etnia);
  $("#ver_comentario").val(comentario);
  $("#ver_foto").html('<img class="img-responsive" src="http://temporales.com.co/contratacion/images/foto.png">');
  var img = $('<img class="img-responsive" />').attr('src', 'http://temporales.com.co/fotos/' + documento + '.jpg').on('load', function() {
                if (!this.complete || typeof this.naturalWidth == "undefined" || this.naturalWidth == 0) {
                     $("#ver_foto").html('<img class="img-responsive" src="http://temporales.com.co/contratacion/images/foto.png">');
                } else {
                    $("#ver_foto").html(img);
                }
            });
  // valores seg social
  verEpsEmpleado(id,nombre,apellido,documento);
  verArlEmpleado(id,nombre,apellido,documento);
  verPensionEmpleado(id,nombre,apellido,documento);
  verCajaEmpleado(id,nombre,apellido,documento);
  verReferenciasEmpleado(id,nombre,apellido,documento);
  verContratoEmpleado(id,nombre,apellido,documento);
  //Abrir PopUp
  $("#modalSpinner").modal("hide");
  $("#modalVer").modal("show");
  $('#modalVer').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormVer();
  });
}
/**
* Funcion encargada de ver los datos de eps del empleado
*/
function verEpsEmpleado(id,nombre,apellido,documento){
  //ver datos seg soc empleado
  var id = id;
  var nombre = nombre;
  var apellido = apellido;
  var documento = documento;
  $.ajax(
  {
    cache: false,
    type: "POST",
    url: "querys/gestion_empleados.php",
    data: {
            opcion  : 10,
            id      : id
          },
    dataType: "json",
    success: function(res)
    {
      if( res.status === "OK" )
      {
        //Asignar Valores
        var idEmpleado = "";
        var eps = "";
        var fecha = "";
        var tramite = "";
        var afiliacion = "";
        var afiliado = "";
        var cotizante = "";
        var regimen = "";
        for( var i=0; i < res.epsEmpleado.length; i++ )
        {
          idEmpleado += res.epsEmpleado[i].idEmpleado;
          eps += res.epsEmpleado[i].eps;
          fecha += res.epsEmpleado[i].fecha;
          tramite += res.epsEmpleado[i].tramite;
          afiliacion += res.epsEmpleado[i].afiliacion;
          afiliado += res.epsEmpleado[i].afiliado;
          cotizante += res.epsEmpleado[i].cotizante;
          regimen += res.epsEmpleado[i].regimen;
        }
        if (eps != ""){
          // asignar datos
          $("#ver_NombreEps").html(nombre);
          $("#ver_ApellidoEps").html(apellido);
          $("#ver_DocumentoEps").html(documento);
          $("#ver_eps").val(eps);
          $("#ver_fecha_radicacion_eps").val(fecha);
          $("#ver_tipo_tramite_eps").val(tramite);
          $("#ver_tipo_afiliacion_eps").val(afiliacion);
          $("#ver_tipo_afiliado_eps").val(afiliado);
          $("#ver_tipo_cotizante_eps").val(cotizante);
          $("#ver_regimen_eps").val(regimen);
          $("#datosEpsVer #pint").show();
          $("#datosEpsVer #alertaVacio").hide();
          $("#datosEpsVer #alertaVacio .alert").hide();
          $("#datosEpsVer #ocultarCaja").show();
        }
        else if (eps === ""){
          $("#ver_NombreEps").html(nombre);
          $("#ver_ApellidoEps").html(apellido);
          $("#ver_DocumentoEps").html(documento);
          $(".ver_id_empleado_eps").val(idEmpleado);
          $("#datosEpsVer #alertaVacio").show();
          $("#datosEpsVer #alertaVacio .alert").show();
          $("#datosEpsVer #ocultarCaja").hide();
          $("#datosEpsVer #pint").hide();
        }
        
      }
      else if(res.status === "EXPIRED" )//Sesión finalizada
      {
        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }
      else if( res.status === "ERROR")
      {
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
  $('#modalVer').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormVer();
  });
}
/**
* Funcion encargada de ver los datos de arl del empleado
*/
function verArlEmpleado(id,nombre,apellido,documento){
  //ver datos arl empleado
  var id = id;
  var nombre = nombre;
  var apellido = apellido;
  var documento = documento;
  $.ajax(
  {
    cache: false,
    type: "POST",
    url: "querys/gestion_empleados.php",
    data: {
            opcion  : 13,
            id      : id
          },
    dataType: "json",
    success: function(res)
    {
      if( res.status === "OK" )
      {
        //Asignar Valores
        var idEmpleado = "";
        var arl = "";
        var fecha = "";
        var codigo = "";
        for( var i=0; i < res.arlEmpleado.length; i++ )
        {
          idEmpleado += res.arlEmpleado[i].idEmpleado;
          arl += res.arlEmpleado[i].arl;
          fecha += res.arlEmpleado[i].fecha;
          codigo += res.arlEmpleado[i].codigo;
        }
        if (arl != ""){
          // asignar datos
          $("#ver_NombreArl").html(nombre);
          $("#ver_ApellidoArl").html(apellido);
          $("#ver_DocumentoArl").html(documento);
          $("#ver_arl").val( arl );
          $("#ver_fecha_afiliacion_arl").val( fecha );
          $("#ver_codigo_transaccion_arl").val( codigo );
          $("#datosArlVer #pint").show();
          $("#datosArlVer #alertaVacio").hide();
          $("#datosArlVer #alertaVacio .alert").hide();
          $("#datosArlVer #ocultarCaja").show();
        }
        else if (arl === ""){
          $("#ver_NombreArl").html(nombre);
          $("#ver_ApellidoArl").html(apellido);
          $("#ver_DocumentoArl").html(documento);
          $(".ver_id_empleado_arl").val(idEmpleado);
          $("#datosArlVer #alertaVacio").show();
          $("#datosArlVer #alertaVacio .alert").show();
          $("#datosArlVer #ocultarCaja").hide();
          $("#datosArlVer #pint").hide();
        }
        
      }
      else if(res.status === "EXPIRED" )//Sesión finalizada
      {
        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }
      else if( res.status === "ERROR")
      {
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
  $('#modalVer').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormVer();
  });
}
/**
* Funcion encargada de ver los datos de pension del empleado
*/
function verPensionEmpleado(id,nombre,apellido,documento){
  //ver datos pension empleado
  var id = id;
  var nombre = nombre;
  var apellido = apellido;
  var documento = documento;
  $.ajax(
  {
    cache: false,
    type: "POST",
    url: "querys/gestion_empleados.php",
    data: {
            opcion  : 16,
            id      : id
          },
    dataType: "json",
    success: function(res)
    {
      if( res.status === "OK" )
      {
        //Asignar Valores
        var idEmpleado = "";
        var pension = "";
        var fecha = "";
        for( var i=0; i < res.pensionEmpleado.length; i++ )
        {
          pension += res.pensionEmpleado[i].pension;
          fecha += res.pensionEmpleado[i].fecha;
        }
        if (pension != ""){
          // asignar datos
          $("#ver_NombrePension").html(nombre);
          $("#ver_ApellidoPension").html(apellido);
          $("#ver_DocumentoPension").html(documento);
          $("#ver_pension").val(pension);
          $("#ver_fecha_afiliacion_pension").val(fecha);
          $("#datosPensionVer #pint").show();
          $("#datosPensionVer #alertaVacio").hide();
          $("#datosPensionVer #alertaVacio .alert").hide();
          $("#datosPensionVer #ocultarCaja").show();
        }
        else if (pension === ""){
          $("#ver_NombrePension").html(nombre);
          $("#ver_ApellidoPension").html(apellido);
          $("#ver_DocumentoPension").html(documento);
          $(".ver_id_empleado_pension").val(idEmpleado);
          $("#datosPensionVer #alertaVacio").show();
          $("#datosPensionVer #alertaVacio .alert").show();
          $("#datosPensionVer #ocultarCaja").hide();
          $("#datosPensionVer #pint").hide();
        }
      }
      else if(res.status === "EXPIRED" )//Sesión finalizada
      {
        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }
      else if( res.status === "ERROR")
      {
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
  $('#modalVer').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormVer();
  });
}
/**
* Funcion encargada de ver los datos de caja del empleado
*/
function verCajaEmpleado(id,nombre,apellido,documento){
  //ver datos caja empleado
  var id = id;
  var nombre = nombre;
  var apellido = apellido;
  var documento = documento;
  $.ajax(
  {
    cache: false,
    type: "POST",
    url: "querys/gestion_empleados.php",
    data: {
            opcion  : 19,
            id      : id
          },
    dataType: "json",
    success: function(res)
    {
      if( res.status === "OK" )
      {
        //Asignar Valores
        var idEmpleado = "";
        var caja = "";
        for( var i=0; i < res.cajaEmpleado.length; i++ )
        {
          idEmpleado += res.cajaEmpleado[i].idEmpleado;
          caja += res.cajaEmpleado[i].caja;
        }
        if (caja != ""){
          // asignar datos
          $("#ver_NombreCaja").html(nombre);
          $("#ver_ApellidoCaja").html(apellido);
          $("#ver_DocumentoCaja").html(documento);
          $("#datosCajaVer #pint").show();
          $("#datosCajaVer #alertaVacio").hide();
          $("#datosCajaVer #alertaVacio .alert").hide();
          $("#datosCajaVer #ocultarCaja").show();
          $("#ver_caja").val(caja);
        }
        else if (caja === ""){
          $("#ver_NombreCaja").html(nombre);
          $("#ver_ApellidoCaja").html(apellido);
          $("#ver_DocumentoCaja").html(documento);
          $(".ver_id_empleado_caja").val(idEmpleado);
          $("#datosCajaVer #alertaVacio").show();
          $("#datosCajaVer #alertaVacio .alert").show();
          $("#datosCajaVer #ocultarCaja").hide();
          $("#datosCajaVer #pint").hide(); 
        }
      }
      else if(res.status === "EXPIRED" )//Sesión finalizada
      {
        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }
      else if( res.status === "ERROR")
      {
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
  $('#modalVer').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormVer();
  });
}
/**
* Funcion encargada de ver los datos de Referencias del empleado
*/
function verReferenciasEmpleado(id,nombre,apellido,documento){  
  
  //consultar datos referencias empleado
  var id = id;
  var nombre = nombre;
  var apellido = apellido;
  var documento = documento;
  $.ajax(
  {
    cache: false,
    type: "POST",
    url: "querys/gestion_empleados.php",
    data: {
            opcion  : 22,
            id      : id
          },
    dataType: "json",
    success: function(res)
    {
      if( res.status === "OK" )
      {
        $("#modalSpinner").modal("show"); // muestra spinner
        //Asignar Valores
        $("#ver_nombreRef").html(nombre);
        $("#ver_apellidoRef").html(apellido);
        $("#ver_documentoRef").html(documento);
        var datosReferencia = '';
        for( var i=0; i < res.referenciasEmpleado.length; i++ )
        {
          var idReferencia = res.referenciasEmpleado[i].idReferencia;
          var idEmpleado = res.referenciasEmpleado[i].idEmpleado;
          datosReferencia += '<div class="panel panel-default" id="ref'+ res.referenciasEmpleado[i].idReferencia +'"><div class="panel-heading"><strong>Referencia # <span id="idReferencia">'+ res.referenciasEmpleado[i].idReferencia +'</span></strong><input type="hidden" id="idEmpleado" name="idEmpleado" value="'+ res.referenciasEmpleado[i].idEmpleado +'" readonly></div><div class="panel-body"><div class="row"><div class="col-lg-12"><form id="form_ver" role="form"><div class="row form-group"><div class="col-xs-12 col-sm-6 col-md-3 margen"><label for="edit_nombre_ref">Nombre:</label><input type="text" id="edit_nombre_ref" name="edit_nombre_ref" class="form-control" value="'+ res.referenciasEmpleado[i].nombres +'" readonly><div id="msg_error_nombre_ref" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div></div><div class="col-xs-12 col-sm-6 col-md-3 margen"><label for="edit_apellido_ref">Apellido:</label><input type="text" id="edit_apellido_ref" name="edit_apellido_ref" class="form-control" value="'+ res.referenciasEmpleado[i].apellidos +'" readonly><div id="msg_error_apellido_ref" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div></div><div class="col-xs-12 col-sm-6 col-md-3 margen"><label for="edit_parentesco">Parentesco:</label><div class=""><select id="edit_parentesco_ref" name="edit_parentesco" class="form-control" readonly>'+ res.referenciasEmpleado[i].lista_parentesco +'</select></div><div id="msg_error_parentesco_ref" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div></div><div class="col-xs-12 col-sm-6 col-md-3 margen"><label for="edit_telefono_ref">Teléfono:</label><input type="text" id="edit_telefono_ref" name="edit_telefono_ref" class="form-control" value="'+ res.referenciasEmpleado[i].telefono +'" readonly><div id="msg_error_telefono_ref" class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Campo requerido</div></div></div></form></div></div></div></div>';
        }
        $("#ver_contador_referencias").val(res.referenciasEmpleado.length);
        if (idReferencia != "")
        {
          // asignar datos
          $("#verDatosReferencias").html(datosReferencia);
          $("#datosReferenciasVer   #pint").show(); 
          $("#modalSpinner").modal("hide"); // hide spinner
        }
        else if (idReferencia === "")
        {
          $(".ver_id_empleado_referencias").val(idEmpleado);
          $("#ver_nombreRef").html(nombre);
          $("#ver_apellidoRef").html(apellido);
          $("#ver_documentoRef").html(documento);
          $("#modalSpinner").modal("hide"); // hide spinner
        }
      }
      else if (res.status === "EMPTY")
      { 
        
        $(".ver_id_empleado_referencias").val(idEmpleado);
        $("#ver_nombreRef").html(nombre);
        $("#ver_apellidoRef").html(apellido);
        $("#ver_documentoRef").html(documento);
        $("#verDatosReferencias").html('<div class="alert alert-danger" role="alert"> <strong>No se han agregado Referencias Personales</strong> </div>');
        $("#datosReferenciasVer   #pint").hide(); 
        $("#modalSpinner").modal("hide"); // muestra spinner
      }
      else if(res.status === "EXPIRED" )//Sesión finalizada
      {
        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }
      else if( res.status === "ERROR")
      {
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
  $('#modalVer').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormVer();
  });
}
/**
* Funcion encargada de ver los datos de contrato del empleado
*/
function verContratoEmpleado(id,nombre,apellido,documento){
  //ver datos contrato empleado
  var id = id;
  var nombre = nombre;
  var apellido = apellido;
  var documento = documento;
  $.ajax({
    cache: false,
    type: "POST",
    url: "querys/gestion_empleados.php",
    data: {
            opcion  : 25,
            id      : id
          },
    dataType: "json",
    success: function(res){
      if( res.status === "OK" ){
        //Asignar Valores
        var idEmpleado = "";
        var empresa = "";
        var cargo = "";
        var salario = "";
        var jornada = "";
        var servicioFunerario = "";
        var banco = "";
        var cuenta = "";
        var tipoCuenta = "";
        for( var i=0; i < res.contratoEmpleado.length; i++ ){
          idEmpleado += res.contratoEmpleado[i].idEmpleado;
          empresa  += res.contratoEmpleado[i].empresa;
          cargo += res.contratoEmpleado[i].cargo;
          salario += res.contratoEmpleado[i].salario;
          jornada += res.contratoEmpleado[i].jornada;
          servicioFunerario += res.contratoEmpleado[i].servicioFunerario;
          banco += res.contratoEmpleado[i].banco;
          cuenta += res.contratoEmpleado[i].cuenta;
          tipoCuenta += res.contratoEmpleado[i].tipoCuenta;
        }
        if (empresa != ""){
          // asignar datos
          $("#ver_nombreContrato").html(nombre);
          $("#ver_apellidoContrato").html(apellido);
          $("#ver_documentoContrato").html(documento);
          $("#datosContratoVer #pint").show();
          $("#datosContratoVer #alertaVacio").hide();
          $("#datosContratoVer #alertaVacio .alert").hide();
          $("#datosContratoVer #ocultarContrato").show();
          $(".ver_id_empleado_contrato").val(idEmpleado);
          $("#ver_empresa").val(empresa);
          $("#ver_cargo").val(cargo);
          $("#ver_salario").val(salario);
          $("#ver_jornada").val(jornada);
          $("#ver_servicio_funerario").val(servicioFunerario);
          $("#ver_banco").val(banco);
          $("#ver_cuenta").val(cuenta);
          $("#ver_tipo_cuenta").val(tipoCuenta);
        }
        else if (empresa === ""){
          $("#ver_nombreContrato").html(nombre);
          $("#ver_apellidoContrato").html(apellido);
          $("#ver_documentoContrato").html(documento);
          $(".ver_id_empleado_contrato").val(idEmpleado);
          $("#datosContratoVer #alertaVacio").show();
          $("#datosContratoVer #alertaVacio .alert").show();
          $("#datosContratoVer #ocultarContrato").hide();
          $("#datosContratoVer #pint").hide(); 
        }
      }
      else if(res.status === "EXPIRED" ){
        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
          window.location = "cerrar_sesion.php";
        });
      }
      else if( res.status === "ERROR"){
        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
      }
    }
  });
  $('#modalVer').on('hidden.bs.modal', function () {
    // resetear campos …
    limpiarFormVer();
  });
}
/**
* FUNCION ENCARGADA DE LIMPIAR LOS CAMPOS DEL FORMULARIO VER
*/
function limpiarFormVer(){
  // resetear campos …
  $("#ver_foto").html('<img class="img-responsive" src="http://temporales.com.co/contratacion/images/foto.png">');
  $("#ver_nombreEmpleado").html("$nombre");
  $("#ver_apellidoEmpleado").html("$apellido");
  $("#ver_documentoEmpleado").html("$documento");
  $("#ver_id_empleado").val("");
  $("#ver_nombre").val("");
  $("#ver_nombre2").val("");
  $("#ver_apellido").val("");
  $("#ver_apellido2").val("");
  $("#ver_tipo").val("");
  $("#ver_documento").val("");
  $("#ver_fechaExp").val("");
  $("#ver_ciudadExp").val("");
  $("#ver_fechaNac").val("");
  $("#ver_ciudadNac").val("");
  $("#ver_paisNac").val("");
  $("#ver_genero").val("");
  $("#ver_estado").val("");
  $("#ver_nivel").val("");
  $("#ver_titulo").val("");
  $("#ver_direccion").val("");
  $("#ver_barrio").val("");
  $("#ver_estrato").val("");
  $("#ver_ciudad").val("");
  $("#ver_telefono").val("");
  $("#ver_celular").val("");
  $("#ver_email").val("");
  $("#ver_etnia").val("");
  $("#ver_comentario").val("");
  $("#ver_NombreEps").html("$nombre");
  $("#ver_ApellidoEps").html("$apellido");
  $("#ver_DocumentoEps").html("$documento");
  $("#ver_eps").val("");
  $("#ver_fecha_radicacion_eps").val("");
  $("#ver_tipo_tramite_eps").val("");
  $("#ver_tipo_afiliacion_eps").val("");
  $("#ver_tipo_afiliado_eps").val("");
  $("#ver_tipo_cotizante_eps").val("");
  $("#ver_regimen_eps").val("");
  $("#ver_NombreArl").html("$nombre");
  $("#ver_ApellidoArl").html("$apellido");
  $("#ver_DocumentoArl").html("$documento");
  $("#ver_arl").val( "" );
  $("#ver_fecha_afiliacion_arl").val( "" );
  $("#ver_codigo_transaccion_arl").val( "" );
  $("#ver_NombrePension").html("$nombre");
  $("#ver_ApellidoPension").html("$apellido");
  $("#ver_DocumentoPension").html("$documento");
  $("#ver_pension").val("");
  $("#ver_fecha_afiliacion_pension").val("");
  $("#ver_NombreCaja").html("$nombre");
  $("#ver_ApellidoCaja").html("$apellido");
  $("#ver_DocumentoCaja").html("$documento");
  $("#ver_caja").val("");
  $("#verDatosReferencias").html("");
  $(".ver_id_empleado_contrato").val("");
  $("#ver_nombreEmpresa").html( "$nombre" );
  $("#ver_apellidoEmpresa").html( "$apellido" );
  $("#ver_documentoEmpresa").html( "$documento" );
  $("#ver_empresa").val("");
  $("#ver_cargo").val("");
  $("#ver_salario").val("");
  $("#ver_jornada").val("");
  $("#ver_servicio_funerario").val("");
  $("#ver_banco").val("");
  $("#ver_cuenta").val("");
  $("#ver_tipo_cuenta").val("");  
  $('#mytabsVer a[href="#datosBasicosVer"]').tab('show');
}
/* /// */
// BORRAR //
/* /// */
/**
* Función encargada de borrar el Empleado
*/
function eliminar(idEmpleado,id,nombre,apellido){
  jConfirm('¿Desea borrar el Empleado con ID: <strong>' + id + '</strong> y Nombre: <strong>' + nombre + ' ' + apellido + '</strong>?','Eliminar Empleado', function(res){
    if(res){
      $.ajax({
          cache: false,
          type: "POST",
          url: "querys/gestion_empleados.php",
          data: {
                  opcion     : 5,
                  id         : id,
                  idEmpleado : idEmpleado
                },
          dataType: "json",
          success: function(res){
            if( res.status === "OK" ){
              recargarDatos();
              jAlert('Empleado eliminado con éxito', 'Eliminar Empleado', function(){
                
              });
            }
            else if(res.status === "EXPIRED" ){
              jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
                window.location = "cerrar_sesion.php";
              });
            }
            else if( res.status === "ERROR"){
              jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
            }
          }
      });
    }
  });
}
/**
* Document Ready
*/
$(document).ready( function() {
  //define datatable
  $("#tabla").DataTable({
    responsive: true,
    "language":{
        "url"   :   "extensions/datatables/language/es.json"
    }
  });
  // Evitar cut and copy paste en documento
  $('#new_documento').bind("copy cut paste 0",function(e) {
       e.preventDefault();
    });
  // Evitar cut copy paste en campo de validacion de documento
  $('#verificar').bind("cut copy paste",function(e) {
       e.preventDefault();
    });
  /**
  * // validar documento 
  */
  $('#new_documento').blur(function(){
    validarDoc();
  });
  /** 
  * // verificar documento
  */
  $('#new_documento_v').blur(function(){
    verificarDoc();
  });
  /**
  * // verificar fecha Exp
  */
  $('#new_fechaExp').blur(function(){
    var fecha = $(this).val();
    verificarFecha(fecha);
    if (verificarFecha(fecha)){
      $('#msg_error_fechaExp_v').hide(500);
    }
    else if ( !verificarFecha(fecha) && (fecha != "") ){
      $('#msg_error_fechaExp_v').show(500);  
      $('#msg_error_fechaExp_v').delay(3000).hide(500);
    }
    else if ( fecha ===""){
      $('#msg_error_fechaExp_v').hide();
      $('#msg_ok_fechaExp').hide();
    }
  });
  /**
  * // verificar fecha Nac
  */
 $('#new_fechaNac').blur(function(){
    var fecha = $(this).val();
    verificarFecha(fecha);
    if (verificarFecha(fecha)){
      $('#msg_error_fechaNac_v').hide(500);
    }
    else if ( !verificarFecha(fecha) && (fecha != "") ){
      $('#msg_error_fechaNac_v').show(500);
      $('#msg_error_fechaNac_v').delay(3000).hide(500);
    }
    else if ( fecha ===""){
      $('#msg_error_fechaNac_v').hide();
      $('#msg_ok_fechaNac').hide();
    }
  });
  // Agregar datapicker - Habilitar click sobre iconos del calendario
  $("#new_fechaExp_icon").on("click",function(){
    $("#new_fechaExp").datepicker({
      language:  'es',
      format: "dd-mm-yyyy"
    });
    $("#new_fechaExp").focus();
  });  
  $("#new_fechaNac_icon").on("click",function(){
    $("#new_fechaNac").datepicker({
      language:  'es',
      format: "dd-mm-yyyy"
    });
    $("#new_fechaNac").focus();
  }); 
  $("#new_fecha_radicacion_eps_icon").on("click",function(){
    $("#new_fecha_radicacion_eps").datepicker({
      language:  'es',
      format: "dd-mm-yyyy",
    });
    $("#new_fecha_radicacion_eps").focus();
  });  
  $("#edit_fechaExp_icon").on("click",function(){
    $("#edit_fechaExp").datepicker({
      language:  'es',
      format: "dd-mm-yyyy",
    });
    $("#edit_fechaExp").focus();
  });
  $("#edit_fechaNac_icon").on("click",function(){
    $("#edit_fechaNac").datepicker({
      language:  'es',
      format: "dd-mm-yyyy",
    });
    $("#edit_fechaNac").focus();
  });
  $("#edit_fecha_radicacion_eps_icon").on("click",function(){
    $("#edit_fecha_radicacion_eps").datepicker({
      language:  'es',
      format: "dd-mm-yyyy",
    });
    $("#edit_fecha_radicacion_eps").focus();
  });
  $("#new_fecha_afiliacion_arl_icon").on("click",function(){
    $("#new_fecha_afiliacion_arl").datepicker({
      language:  'es',
      format: "dd-mm-yyyy",
    });
    $("#new_fecha_afiliacion_arl").focus();
  }); 
  $("#edit_fecha_afiliacion_arl_icon").on("click",function(){
    $("#edit_fecha_afiliacion_arl").datepicker({
      language:  'es',
      format: "dd-mm-yyyy",
    });
    $("#edit_fecha_afiliacion_arl").focus();
  }); 
  $("#new_fecha_afiliacion_pension_icon").on("click",function(){
    $("#new_fecha_afiliacion_pension").datepicker({
      language:  'es',
      format: "dd-mm-yyyy",
    });
    $("#new_fecha_afiliacion_pension").focus();
  }); 
  $("#edit_fecha_afiliacion_pension_icon").on("click",function(){
    $("#edit_fecha_afiliacion_pension").datepicker({
      language:  'es',
      format: "dd-mm-yyyy",
    });
    $("#edit_fecha_afiliacion_pension").focus();
  }); 
  /**
  * Función encargada de validar si esta o no afiliado a fondo de  pension
  */
  $('input[type="checkbox"]').click(function(){
      if($(this).attr("value")=="afiliado"){
          $("#nFondo").toggle();
          $("#noAfiliado").toggle();
      }
      if($(this).attr("value")=="noAfiliado"){
          $("#fechaAfi").toggle();
          $("#nFondo").toggle();
          $("#afiliado").toggle();
      }
  });
  /**
  * Función encargada de validar si declara o no convivencia
  */
  $('input[type="checkbox"]').click(function(){
      if($(this).attr("value")=="1"){
          $("#convivencia").toggle();
          $("#no").toggle();
      }
      if($(this).attr("value")=="0"){
          $("#si").toggle();
          $("#").toggle();
          $("#").toggle();
      }
  });
}); //end document ready