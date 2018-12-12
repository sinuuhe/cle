var tabla;

function elegirBeca(selectName){
	
	console($("#" + selectName).attr("data-des"));
}
//Función que se ejecuta al inicio
function init(){
    cargando();
	mostrarform(true);
	cargarDatos();
	cargarDatosGrupo()
    $("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})
}


//Función mostrar formulario
function mostrarform(flag)
{
	$("#fotoDiv").show();
	if (flag)
	{
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform()
{
	mostrarform(false);
}

//Función Listar
function cargarDatos()
{
    cargando();
    $.getJSON("../ajax/maestro.php",
            {"op": "mostrar_perfil"})
            .done(function (data, textStatus, jqXHR) {
                try {
                        $("#id").val(data.id);
                        //$("#foto").val(data.foto);
                        $("#password").val(data.password)
                        $("#foto").attr("data-rutaFoto",data.foto)
                        $("#vistaFoto").attr('src','..' + data.foto);
                } catch (error) {
                    console.log("ERRPRRRRRRRRRRRR")
                    alertify.notify(error.message, 'error', 5, function () {
                    });
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                if (console && console.log) {
                    console.log("Algo ha fallado: " + textStatus + " " + jqXHR + " " + errorThrown);
                }
            });
}

function cargarDatosGrupo()
{
    cargando();
    $.getJSON("../ajax/grupo.php",
            {"op": "listar_grupos"})
            .done(function (data, textStatus, jqXHR) {
                try {
                    $.each(data, function (key, grupo) {
                        $("#misGrupos").append('<li><a href="asistencia.php?g=' + grupo[0] + '">' + grupo[0] + ' ' + grupo[1] + '</a></li>')
                    });
                } catch (error) {
                    console.log("ERRPRRRRRRRRRRRR")
                    alertify.notify(error.message, 'error', 5, function () {
                    });
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                if (console && console.log) {
                    console.log("Algo ha fallado: " + textStatus + " " + jqXHR + " " + errorThrown);
                }
            });
}

//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formulario")[0]);

	if($("#foto").attr("rutaFoto") != ""){
		formData.append("foto",$("#foto").attr("rutaFoto"))
	}
	
	$.ajax({
		url: "../ajax/maestro.php?op=guardaryeditarperfil",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	        alertify.alert("Registro de maestros",datos, function(){
            mostrarform(true);
            $("#foto").val("");
            cargarDatos();    
			  });	          
	    }

	});
	
}

init();