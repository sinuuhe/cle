/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var tabla;
var ig;

function init() {
    mostrarform(false);
    listarGrupos();
    listarNiveles();
    listarMaestros();

    $("#fecha_inicio,#fecha_fin").datepicker({
		format:"yyyy-mm-dd"
    });
    $("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
    })
}

function listarNiveles() {
    alertify.loading || alertify.dialog('loading', function () {
        return {
            main: function (content) {
                this.setContent(content);
            },
            setup: function () {
                return {
                    options: {
                        basic: false,
                        maximizable: false,
                        resizable: true,
                        padding: false,
                        closable: false,
                        movable: false,
                        title: "Cargando contenido"
                    }
                };
            }
        };
    });
    $(document).ajaxStart(function () {
        
        alertify.loading('<br><div class="fa-5x text-center">' +
                '</div>');
    });
    $(document).ajaxComplete(function (event, request, settings) {
        alertify.loading().close();
    });
    $.getJSON("../ajax/grupo.php",
            {"op": "iniciar_niveles"})
            .done(function (data, textStatus, jqXHR) {
                try {
                        $.each(data, function (key, nivel) {
                            /* ---AGREGAR LOS DATOS DEL NIVEL--- */
                            $("#nivel").append(
                                    '<option value = "' + nivel.id + '" data-content="<span class=\'badge badge-success\'>Nivel: ' + nivel.nombre + '</span> - Idioma: '
                                    + nivel.curso + '  |   Material: ' + nivel.material + '   |  Costo: ' + nivel.costo + '"></option>');
                            $("#nivel").selectpicker('refresh');
                        });
                } catch (error) {
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

function listarMaestros() {
    $(document).ajaxStart(function () {
        alertify.loading || alertify.dialog('loading', function () {
            return {
                main: function (content) {
                    this.setContent(content);
                },
                setup: function () {
                    return {
                        options: {
                            basic: false,
                            maximizable: false,
                            resizable: true,
                            padding: false,
                            closable: false,
                            movable: false,
                            title: "Cargando contenido"
                        }
                    };
                }
            };
        });
        alertify.loading('<br><div class="fa-5x text-center">' +
                '</div>');
    });
    $(document).ajaxComplete(function (event, request, settings) {
        alertify.loading().close();
    });
    $.getJSON("../ajax/grupo.php",
            {"op": "iniciar_maestros"})
            .done(function (data, textStatus, jqXHR) {
                try {
                        $.each(data, function (key, maestro) {
                            
                            $("#idMaestro").append(
                                    '<option value = "' + maestro.id + '" data-content="' + maestro.nombre + ' ' + maestro.apellidoP + ' ' + maestro.apellidoM + '"></option>');
                            $("#idMaestro").selectpicker('refresh');
                        });
                } catch (error) {
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


function resetForm() {
    $('#libro_costo').remove();
    $($("form#pagar_libros"))[0].reset();
    $(".selectpicker").val('default');
    $(".selectpicker").selectpicker("refresh");
}

$.fn.serializeObject = function()
{
   var o = {};
   var a = this.serializeArray();
   $.each(a, function() {
       if (o[this.name]) {
           if (!o[this.name].push) {
               o[this.name] = [o[this.name]];
           }
           o[this.name].push(this.value || '');
       } else {
           o[this.name] = this.value || '';
       }
   });
   return o;
};

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}
//Función Listar
function listarGrupos()
{
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/grupo.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

function listarAlumnos(idGrupo)
{
	tabla=$('#tbllistadoAlumnos').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/grupo.php?op=listarAlumnos&g=' + idGrupo,
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();
    
    $("#alumno").data("idGrupo",idGrupo)
    //$('.selectpicker').selectpicker('refresh')
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
        
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
        $("#btnagregar").show();
        $("#listadoAlumnos").hide();
	}
}

function verAlumnos(idGrupo,flag)
{

	if (flag)
	{
        
        $("#listadoAlumnos").show();
        $("#formularioregistros").hide();
        $("#listadoregistros").hide();
        $("#btnagregar").hide();
        listarAlumnos(idGrupo);
        inicializarSelects() 
        $('.selectpicker').selectpicker('refresh')

	}
	else
	{
		$("#listadoAlumnos").hide();
        $("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

function limpiar()
{
$("#nivel").val("");
$("#idMaestro").val("");
$("#numDias").val("");
$("#dias").val("");
$("#horario_entrada").val("");
$("#horario_salida").val("");
$("#fecha_inicio").val("");
$("#fecha_fin").val("");
$("#salon").val("");
$("#observaciones").val("");
}

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../ajax/grupo.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          alertify.alert("Registro de grupo",datos, function(){
				mostrarform(false);
	          	tabla.ajax.reload();
			  });	          
	    }

	});
	limpiar();
}
function mostrar(idGrupo)
{
	$.post("../ajax/grupo.php?op=mostrar",{id : idGrupo}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#id").val(data.ID_GRUPO);
		$("#nombre").val(data.nombre);
        $("#nivel").val(data.ID_NIVEL);
		$("#idMaestro").val(data.ID_MAESTRO);
		$("#numDias").val(data.NUM_DIAS);
		$("#dias").val(data.DIAS);
		$("#horario_entrada").val(data.HORARIO_ENTRADA);
		$("#horario_salida").val(data.HORARIO_SALIDA);
		$("#fecha_inicio").val(data.FECHA_INICIO);
		$("#fecha_fin").val(data.FEHA_FIN);
		$("#salon").val(data.SALON);
        $("#observaciones").val(data.OBSERVACIONES);
        $('.selectpicker').selectpicker('refresh')

 	})
}

function cancelarAlumnos()
{
	verAlumnos(false)
}

function inicializarSelects() {
    $(document).ajaxStart(function () {
        alertify.loading || alertify.dialog('loading', function () {
            return {
                main: function (content) {
                    this.setContent(content);
                },
                setup: function () {
                    return {
                        options: {
                            basic: false,
                            maximizable: false,
                            resizable: true,
                            padding: false,
                            closable: false,
                            movable: false,
                            title: "Cargando contenido"
                        }
                    };
                }
            };
        });
        alertify.loading('<br><div class="fa-5x text-center">' +
                '<i class="fa fa-spinner fa-spin""></i>' +
                '</div>');
    });
    $(document).ajaxComplete(function (event, request, settings) {
        alertify.loading().close();
    });
    $.getJSON("../ajax/pago_libro.php",
            {"op": "iniciar_selects"})
            .done(function (data, textStatus, jqXHR) {
                try {
                    $("#alumno").html("");
                    $.each(data, function (key, dat) {
                        $.each(dat.alumnos, function (key, alumnos) {
                            console.log(alumnos)
                            $("#alumno").append(
                                    '<option data-content="<span class=\'badge badge-success\'>' + alumnos.id + '</span> - '
                                    + alumnos.nombre + ' ' + alumnos.apellidoP + ' ' + alumnos.apellidoM + '" value="' + alumnos.id + '"></option>');
                            
                        });

                    });
                    $("#alumno").selectpicker('refresh');
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

function agregarAlumno(){

    

    alertify.dialog('confirm').
    set({
        transition: 'slide',
        message: '	\n\
<div class="form-horizontal">\n\
<h2>Desea dar de alta al alumno?</h2>\n\
</div>',

        'reverseButtons': true,
        'labels': {ok: 'Confirmar', cancel: 'Cancelar!'},
        onok: function () {
            $.post("../ajax/grupo.php?op=inscribirAlumno&idAlumno=" + $("#alumno").val() + "&g=" + $("#alumno").data("idGrupo"), {},
                    function (respuesta) {
                        try {
                            alertify.notify(respuesta, 'success', 5, function () {
                                listarAlumnos($("#alumno").data("idGrupo"));
                            });
                            tabla.ajax.reload();
                        } catch (error) {
                            alertify.notify(error.message, 'error', 5, function () {
                                console.log('dismissed');
                            });
                        }
                    });
        },
        oncancel: function () {
            alertify.error('Cancelado')
        }
    })
    .setHeader('<span class="fa fa-exclamation-triangle" aria-hidden="true"'
            + 'style="vertical-align:middle;color:#e10000;">'
            + '</span> ¿Confirmar Pago?')
    .show();
    
}

function eliminarAlumno(idAlumno,idGrupo){
    alertify.dialog('confirm').
    set({
        transition: 'slide',
        message: '	\n\
<div class="form-horizontal">\n\
<h2>Desea remover al alumno del grupo?</h2>\n\
</div>',

        'reverseButtons': true,
        'labels': {ok: 'Confirmar', cancel: 'Cancelar!'},
        onok: function () {
            $.post("../ajax/grupo.php?op=removerAlumno&idAlumno=" + idAlumno + "&g=" + idGrupo, {},
                    function (respuesta) {
                        try {
                            alertify.notify(respuesta, 'success', 5, function () {
                                listarAlumnos($("#alumno").data("idGrupo"));
                            });
                            tabla.ajax.reload();
                        } catch (error) {
                            alertify.notify(error.message, 'error', 5, function () {
                                console.log('dismissed');
                            });
                        }
                    });
        },
        oncancel: function () {
            alertify.error('Cancelado')
        }
    })
    .setHeader('<span class="fa fa-exclamation-triangle" aria-hidden="true"'
            + 'style="vertical-align:middle;color:#e10000;">'
            + '</span> ¿Confirmar Pago?')
    .show();
}

init();