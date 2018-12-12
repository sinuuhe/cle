var tabla;


//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})
}

function eliminar(libroId){
	alertify.dialog('confirm').
            set({
                transition: 'slide',
                message: 'Desea eliminar el convenio?',
                'reverseButtons': true,
                'labels': {ok: 'Confirmar', cancel: 'Cancelar!'},
                onok: function () {
						$.post("../ajax/Convenios.php?op=eliminar", {id : libroId}, function(e){
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
                    + '</span> Eliminar convenio')
            .show();  
}

//Función limpiar
function limpiar()
{
	$("#id").val("");
	$("#nombre").val("");
	$("#des_mensualidad").val("");
	$("#des_inscripcion").val("");
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
					url: '../ajax/Convenios.php?op=listarTodo',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/Convenios.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          alertify.alert("Registro de convenios",datos, function(){
				mostrarform(false);
	          	tabla.ajax.reload();
			  });	          
	    }

	});
	limpiar();
}

function mostrar(idLibro)
{
	$.post("../ajax/Convenios.php?op=mostrar",{id : idLibro}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#id").val(data.ID);
		$("#nombre").val(data.NOMBRE);
		$("#des_mensualidad").val(data.DES_MENSUALIDAD);
		$("#des_inscripcion").val(data.DES_INSCRIPCION);
 	})
}

init();