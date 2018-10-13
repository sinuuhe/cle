var tabla;

//Función que se ejecuta al inicio
function init(){

}

//Función limpiar
function limpiar()
{

}


//Función Listar
function listarConvenio()
{
    $.ajax({
		url: "../ajax/Convenios.php?op=listar",
	    type: "POST",
	    contentType: false,
	    processData: false,
        
	    success: function(datos)
	    {
            console.log("SIIII");
            console.log(datos);
            $('#empresa').html(datos);                    
        },
        error:function(datos){console.log(datos)
        }

	});

}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);

	var newDate = $("#fecha_nacimiento").val();
	newDate = newDate.split("/").reverse().join("-");

	$("#fecha_nacimiento").val(newDate);
	var formData = new FormData($("#formulario")[0]);

	limpiar();
}

function mostrar(idcategoria)
{
	$.post("../ajax/categoria.php?op=mostrar",{idcategoria : idcategoria}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#nombre").val(data.nombre);
		$("#descripcion").val(data.descripcion);
 		$("#idcategoria").val(data.idcategoria);

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


init();