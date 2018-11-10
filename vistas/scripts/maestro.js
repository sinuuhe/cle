var tabla;

function elegirBeca(selectName){
	
	console($("#" + selectName).attr("data-des"));
}
//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	$("#fecha_nacimiento,#fecha_ingreso").datepicker({
		format:"yyyy-mm-dd"
	});
	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

}

function baja(maestroId, nombre){
	alertify.dialog('confirm').
            set({
                transition: 'slide',
                message: 'Desea dar de baja al maestro ' + nombre + '?',
                'reverseButtons': true,
                'labels': {ok: 'Confirmar', cancel: 'Cancelar!'},
                onok: function () {
						$.post("../ajax/maestro.php?op=baja", {id : maestroId}, function(e){
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

function alta(maestroId, nombre){
	alertify.dialog('confirm').
	set({
		transition: 'slide',
		message: "¿Seguro que desea dar de alta al maestro " + nombre + "?",
		'reverseButtons': true,
		'labels': {ok: 'Confirmar', cancel: 'Cancelar!'},
		onok: function () {
				$.post("../ajax/maestro.php?op=alta", {id : maestroId}, function(e){
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

//Función limpiar
function limpiar()
{
	$("#id").val("");
	$("#nombre").val("");
	$("#descripcion").val("");
	$("#nombre").val("");
	$("#apellidoP").val("");
	$("#apellidoM").val("");
	$("#telefono").val("");
	$("#celular").val("");
	$("#email").val("");
	$("#fecha_nacimiento").val("");
	$("#fecha_ingreso").val("");
    $("#foto").val("");
    $("#foto").attr("data-rutaFoto","")
	$("#vistaFoto").attr('src','');
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
					url: '../ajax/maestro.php?op=listar',
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
		url: "../ajax/maestro.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          alertify.alert("Registro de maestros",datos, function(){
				mostrarform(false);
	          	tabla.ajax.reload();
			  });	          
	    }

	});
	limpiar();
}

function mostrar(idAlumno,nombre)
{
	$.post("../ajax/maestro.php?op=mostrar",{id : idAlumno}, function(data, status)
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
		$("#telefono").val(data.telefono);
		$("#celular").val(data.celular);
		$("#email").val(data.email);
		$("#fecha_nacimiento").val(data.fecha_nacimiento);
		$("#fecha_ingreso").val(data.fecha_ingreso);
		$("#foto").attr("data-rutaFoto",data.foto)
		$("#vistaFoto").attr('src','..' + data.foto);

 	})
}

init();