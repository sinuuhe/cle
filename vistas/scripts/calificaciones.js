function init(){
	cargando();
	listarAlumnosInit(getGrupo());
}


function listarAlumnosInit(idGrupo){
    $.ajax({
		url: "../ajax/grupo.php?op=listarAlumnosGrupo&g=" + idGrupo,
	    type: "GET",
	    contentType: false,
	    processData: false,
	    success: function(datos){  
			var respuesta=Object.values(JSON.parse(datos));
			var rows = "";
			for (option of respuesta){
				var _idAlumno = option[0];
                rows += '<tr id = "' + option[0] + '">\n\
					<td>' + option[1] + '</td>\n\
					<td><input type="number" step="0.01" class = "bg-primary" max-length = "6" id = "O' + option[0] + '" value = "0" onfocusout = "sumarColumnas(&apos;' + option[0] + '&apos;)" max = "100" min = "0"></td>\n\
					<td><input type="number" step="0.01" class = "bg-primary" max-length = "6" id = "E' + option[0] + '" value = "0" onfocusout = "sumarColumnas(&apos;' + option[0] + '&apos;)" max = "100" min = "0"></td>\n\
					<td><input type="number" step="0.01" class = "bg-primary" max-length = "6" id = "P' + option[0] + '" value = "0" onfocusout = "sumarColumnas(&apos;' + option[0] + '&apos;)" max = "100" min = "0"></td>\n\
					<td><label>0</label></td>\n\
                </tr>';
            } 

            $('#tbllistado > tbody').append(rows);
	    }
	});
}

function sumarColumnas(idAlumno){
	var suma = 0;
	var oral = parseFloat($("#tbllistado tbody #" + idAlumno + " td #O" + idAlumno).val());
	if(oral.length > 6 || oral > 100 || oral < 0){
		avisoCorregirValor(oral);
		$("#tbllistado tbody #" + idAlumno + " td #O" + idAlumno).focus()
	}else{
		var escrita = parseFloat($("#tbllistado tbody #" + idAlumno + " td #E" + idAlumno).val());
		if(escrita.length > 6 || escrita > 100 || escrita < 0){
			avisoCorregirValor(escrita);
			$("#tbllistado tbody #" + idAlumno + " td #E" + idAlumno).focus();
		}
		else{
			var part = parseFloat($("#tbllistado tbody #" + idAlumno + " td #P" + idAlumno).val());
			if(part.length > 6 || part > 100 || part < 0){
				avisoCorregirValor(part);
				$("#tbllistado tbody #" + idAlumno + " td #P" + idAlumno).focus()
			}
		}
	}
	
	
	suma = (oral * 0.30) + (escrita * 0.40) + (part * 0.30);
	$("#tbllistado tbody #" + idAlumno + " td label").text(suma.toFixed(2));
}

function avisoCorregirValor(valor){
	alertify.alert("Error","Por favor, corrija el valor " + valor + ".\n Solo se aceptan números entre 0 y 100");
}

function getGrupo(){
	var url_string = window.location.href;
	var url = new URL(url_string);
	var g = url.searchParams.get("g");
	return (g);
}

function subirCalificaciones(){
	var g = getGrupo();
	var fechaAsistencia = $("#fechaAsistencia").val();
	var array = [];
	var datosOk = true;
	$("#tbllistado tbody tr").each(function (index) {
		var alumnoId=$(this).attr("id")
		$(this).find("label").each(function (index2) {
			var valor = $(this).text();
			if(valor.length > 6 || parseFloat(valor) > 100 || parseFloat(valor) < 0){
				alertify.alert("Por favor, corrija el valor " + valor + ".\n Solo se aceptan números entre 0 y 100");
				datosOk = false;
			}else
				array.push({"calificacion":$(this).text(),"alumnoId":alumnoId,"id":$(this).attr("id")})
		})
	})

	if(datosOk){
		var observaciones = $("#observaciones").val();
		$.ajax({
			method: "POST",
			url: "../ajax/grupo.php?op=subirCalificaciones&g="+g,
			dataType: "json",
			data: { array : JSON.stringify(array),
					observaciones:observaciones }
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