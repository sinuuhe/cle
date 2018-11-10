var tabla;

function elegirBeca(selectName){
	
	console($("#" + selectName).attr("data-des"));
}
//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	listarConvenio();
	listarGrupos();
	$("#fecha_nacimiento,#fecha_ingreso").datepicker({
		format:"yyyy-mm-dd"
	});
	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})
	$("#empresa").on("change",function()
	{
		elegirBeca();
	})
	$("#beca").prop("disabled",true);
	$("#beca").val(0);

}

function baja(alumnoId, nombre){
	alertify.dialog('confirm').
            set({
                transition: 'slide',
                message: 'Desea dar de baja al alumno ' + nombre + '?',
                'reverseButtons': true,
                'labels': {ok: 'Confirmar', cancel: 'Cancelar!'},
                onok: function () {
						$.post("../ajax/Alumnos.php?op=baja", {id : alumnoId}, function(e){
							alertify.success(e);
							tabla.ajax.reload();
						});	
                },
                oncancel: function () {
                    //alertify.error('Cancelado')
                }
            })
            .setHeader('<span class="fa fa-info-circle" aria-hidden="true"'
                    + 'style="vertical-align:middle;color:#3399ff;">'
                    + '</span> Confirmar Alta')
            .show();  
}

function alta(alumnoId, nombre){
	alertify.dialog('confirm').
	set({
		transition: 'slide',
		message: "¿Seguro que desea dar de alta al alumno " + nombre + "?",
		'reverseButtons': true,
		'labels': {ok: 'Confirmar', cancel: 'Cancelar!'},
		onok: function () {
				$.post("../ajax/Alumnos.php?op=alta", {id : alumnoId}, function(e){
					alertify.success(e);
					tabla.ajax.reload();
				});	
		},
		oncancel: function () {
			//alertify.error('Alta exitosa')
		}
	})
	.setHeader('<span class="fa fa-info-circle" aria-hidden="true"'
			+ 'style="vertical-align:middle;color:#3399ff;">'
			+ '</span> Confirmar Alta')
	.show();  
}

function elegirBeca(){

	$("#beca").prop("disabled",false);
	var becaId = $("#empresa").find(':selected').val();
	var desc = $("#empresa").find(':selected').data('des');
	//ninguna
	if(becaId == -1){
		$("#beca").prop("disabled",true);
		$("#beca").val(0);
	}
	//ingresar beca
	if(becaId == -2){
		$("#beca").prop("disabled",false);
		$("#beca").val(0);
	}
	if(becaId > 0){
		$("#beca").prop("disabled",true);
		$("#beca").val(desc);
	}
}
//Función limpiar
function limpiar()
{
	$("#id").val("");
	$("#nombre").val("");
	$("#descripcion").val("");
	$("#nombre").val("");
	$("#apellidoP").val("");
	$("#apellidoM").val("");
	$("#calle").val("");
	$("#colonia").val("");
	$("#numero").val("");
	$("#municipio").val("");
	$("#telefono").val("");
	$("#celular").val("");
	$("#email").val("");
	$("#fecha_nacimiento").val("");
	$("#fecha_ingreso").val("");
	$("#foto").val("");
	$("#empresa").val("");
	$("#grupo").val(""); 
	$(".selectpicker").val('default');
    $(".selectpicker").selectpicker("refresh");
	$("#beca").val(0);
	$("#sede").val("");
	$("#vistaFoto").attr('src','');
	$("#beca").prop("disabled",true);
	$("#id").attr("status","");
}

//Función mostrar formulario
function mostrarform(flag)
{
	$("#fotoDiv").show();
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
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar()
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
					url: '../ajax/Alumnos.php?op=listar',
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

//Funcion para llenar el select de grupos
function listarGrupos(idGrupo) {
	
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
	
	if(idGrupo === undefined) {
		$.getJSON("../ajax/Alumnos.php",
				{"op": "iniciar_grupos"})
				.done(function (data, textStatus, jqXHR) {
					try {
						$.each(data, function (key, grupo) {
							/* ---AGREGAR LOS DATOS DE GRUPOS--- */
							$("#grupo").append(
									'<option value = "' + grupo.id + '" data-content="<span class=\'badge badge-success\'>Grupo: ' + grupo.id + '</span> - Maestro: '
									+ grupo.nombre_maestro + '  |   Horario: ' + grupo.horario_entrada  + '-' + grupo.horario_salida + '"></option>');
							$("#grupo").selectpicker('refresh');
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
	else if(idGrupo == null){
		$('#grupo option[value="0"]').prop('selected', true);
		$("#grupo").selectpicker('refresh');
	}
	else{
		$('#grupo option[value="'+idGrupo+'"]').prop('selected', true);
		$("#grupo").selectpicker('refresh');
	}
}

//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#beca").prop("disabled",false);
	$("#btnGuardar").prop("disabled",true);
	$("#fotoDiv").show();
	var formData = new FormData($("#formulario")[0]);

	if($("#foto").attr("rutaFoto") != ""){
		formData.append("foto",$("#foto").attr("rutaFoto"))
	}
	
	if($("#id").attr("status") != ""){
		formData.append("status",$("#id").attr("status"))
		console.log("entro");
	}

	$.ajax({
		url: "../ajax/Alumnos.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          alertify.alert("Registro de alumnos",datos, function(){
				mostrarform(false);
	          	tabla.ajax.reload();
			  });	          
	    }

	});
	limpiar();
}

function mostrar(idAlumno,nombre)
{
	$.post("../ajax/Alumnos.php?op=mostrar",{id : idAlumno}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#id").val(data.id);
		$("#id").attr("status",data.status);
		$("#nombre").val(data.nombre);
		$("#descripcion").val(data.descripcion);
		$("#nombre").val(data.nombre);
		$("#apellidoP").val(data.apellidoP);
		$("#apellidoM").val(data.apellidoM);
		$("#calle").val(data.calle);
		$("#colonia").val(data.colonia);
		$("#numero").val(data.numero);
		$("#municipio").val(data.municipio);
		$("#telefono").val(data.telefono);
		$("#celular").val(data.celular);
		$("#email").val(data.email);
		$("#fecha_nacimiento").val(data.fecha_nacimiento);
		$("#fecha_ingreso").val(data.fecha_ingreso);
		$("#foto").attr("rutaFoto",data.foto)
		$("#vistaFoto").attr('src','..' + data.foto);
		$("#beca").val(data.beca);
		$("#sede").val(data.sede);
		listarConvenio(data.empresa);
		listarGrupos(data.id_grupo);

 	})
}

//Función para desactivar registros
function desactivar(idcategoria)
{
	bootbox.confirm("¿Está Seguro de desactivar la Categoría?", function(result){
		if(result)
        {
        	$.post("../ajax/categoria.php?op=desactivar", {idcategoria : idcategoria}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idcategoria)
{
	bootbox.confirm("¿Está Seguro de activar la Categoría?", function(result){
		if(result)
        {
        	$.post("../ajax/categoria.php?op=activar", {idcategoria : idcategoria}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}
function listarConvenio(idConvenio)
{
	if(idConvenio != undefined){
		$.ajax({
			url: "../ajax/Convenios.php?op=listar",
			type: "GET",
			contentType: false,
			processData: false,
			success: function(datos)
			{  
				var respuesta=Object.values(JSON.parse(datos));
				console.log(respuesta)
				var options = "";
				for (option of respuesta){
					if(option.id == idConvenio){
						options += "<option selected value = " + option.id + " data-des = " + option.des_mensualidad + ">" + option.nombre + "</option>";
					}else{
						options += "<option value = " + option.id + " data-des = " + option.des_mensualidad + ">" + option.nombre + "</option>";
					}
				}

				if(option.id == 0){
					options += "<option selected value = " + option.id + " data-des = " + option.des_mensualidad + ">" + option.nombre + "</option>";
				}else{
					options = "<option value = '-1'  data-des = 0>Ninguna</option><option data-des = 0 value = '-2'>Beca</option>" + options;
				}
				$('#empresa').html(options);
			}
	
		});
	}else{

	}
    $.ajax({
		url: "../ajax/Convenios.php?op=listar",
	    type: "GET",
	    contentType: false,
	    processData: false,
	    success: function(datos)
	    {  
			var respuesta=Object.values(JSON.parse(datos));
			console.log(respuesta)
			var options = "";
			for (option of respuesta){
				options += "<option value = " + option.id + " data-des = " + option.des_mensualidad + ">" + option.nombre + "</option>";
			}
			options = "<option value = '-1' selected data-des = 0>Ninguna</option><option data-des = 0 value = '-2'>Beca</option>" + options;
            $('#empresa').html(options);
	    }

	});

}

init();