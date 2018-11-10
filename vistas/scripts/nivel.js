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

function eliminar(nivelId, nombre){
	alertify.dialog('confirm').
            set({
                transition: 'slide',
                message: 'Desea eliminar el nivel ' + nombre + '?',
                'reverseButtons': true,
                'labels': {ok: 'Confirmar', cancel: 'Cancelar!'},
                onok: function () {
						$.post("../ajax/nivel.php?op=eliminar", {id : nivelId}, function(e){
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
                    + '</span> Eliminar grupo')
            .show();  
}

//Función limpiar
function limpiar()
{
    $("#nombre").val("");
    $("#curso").val("");
    $("#duracion").val("");
    $("#material_libro").val("");
    $("#costo").val("");
    $("#inscripcion").val("");
    $("#documento").val("");
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
					url: '../ajax/nivel.php?op=listar',
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
	$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);
    
	$.ajax({
		url: "../ajax/nivel.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          alertify.alert("Registro de niveles",datos, function(){
				mostrarform(false);
	          	tabla.ajax.reload();
			  });	          
	    }

	});
	limpiar();
}

function mostrar(idNivel,nombre)
{
	$.post("../ajax/nivel.php?op=mostrar",{id : idNivel}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

        $("#id").val(data.ID);
        $("#nombre").val(data.NOMBRE);
        $("#curso").val(data.CURSO);
        $("#duracion").val(data.DURACION);
        $("#material_libro").val(data.MATERIAL_LIBRO);
        $("#costo").val(data.COSTO);
        $("#inscripcion").val(data.INSCRIPCION);
        $("#documento").val(data.DOCUMENTO);

 	})
}

init();