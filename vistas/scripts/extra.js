function init(){
	cargando();
	listarAlumnosInit();
}


function listarAlumnosInit(){
    $.ajax({
		url: "../ajax/grupo.php?op=listarAlumnosExtra",
	    type: "GET",
	    contentType: false,
	    processData: false,
	    success: function(datos){ 
			var respuesta=Object.values(JSON.parse(datos));
            var rows = "";
            console.log(respuesta);
            if(respuesta.length !=0){
			for (option of respuesta){
				var _idAlumno = option[0];
                rows += '<tr id = "' + option[0] + '">\n\
					<td>' + option[1] + '</td>\n\
					<td><input type="number" step="0.01" class = "bg-primary" max-length = "6" id = "calif' + option[0] + '" value = "0" onfocusout = "sumarColumnas(&apos;' + option[0] + '&apos;)" max = "100" min = "0"></td>\n\
                </tr>';
            } 

            $('#tbllistado > tbody').append(rows);
        }else{
            alertify.alert("Lista vacía","No tienes ningún alumno en Extra.");
            $("#subirCalificaciones").prop('disabled', true);
            $("#subirCalificaciones").hide();
            $("#tbllistado").hide();
            $("#tituloPagina").text("No tienes alumnos en extra");
        }
    }
	});
}

function sumarColumnas(idAlumno){
	var oral = parseFloat($("#tbllistado tbody #" + idAlumno + " td #calif" + idAlumno).val());
	if(oral.length > 6 || oral > 100 || oral < 0){
		avisoCorregirValor(oral);
		$("#tbllistado tbody #" + idAlumno + " td #calif" + idAlumno).focus()
	}
}

function avisoCorregirValor(valor){
	alertify.alert("Error","Por favor, corrija el valor " + valor + ".\n Solo se aceptan números entre 0 y 100");
}

function subirCalificaciones(){
    var datosOk = true;
    var array = [];
	$("#tbllistado tbody tr").each(function (index) {
		var alumnoId=$(this).attr("id")
		$(this).find("input").each(function (index2) {
			var valor = $(this).val();
			if(valor.length > 6 || valor > 100 || valor < 0){
				alertify.alert("Por favor, corrija el valor " + valor + ".\n Solo se aceptan números entre 0 y 100");
				datosOk = false;
			}else
				array.push({"calificacion":valor,"alumnoId":alumnoId,"id":$(this).attr("id")})
		})
	})

	if(datosOk){
		$.ajax({
			method: "POST",
			url: "../ajax/grupo.php?op=subirCalificacionesExtra",
			dataType: "json",
			data: { array : JSON.stringify(array)}
		})
		.done(function (data, textStatus, jqXHR) {
			try {
				alertify.alert("Calificaciones guardadas");
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
	
}

init();