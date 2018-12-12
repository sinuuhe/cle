function init(){
	cargando();
	datePickerInit();
	listarAlumnosInit(getGrupo());
}

function datePickerInit(){
	$('.selectpicker').selectpicker();
    $("#fechaAsistencia").datepicker({
		language: 'es',
        clearBtn: true,
        calendarWeeks: true,
        autoclose: true,
        todayHighlight: true,
        format:"yyyy-mm-dd",
        show: true,
        endDate: new Date()
	});
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
                rows += '<tr id = "' + option[0] + '">\n\
                    <td>' + option[1] + '</td>\n\
                </tr>';
            } 

            $('#tbllistado > tbody').append(rows);
	    }
	});
}

function sumarColumnas(row){
    var columns = $("#tbllistado thead tr th").length;
    var totalA = 0,totalF = 0,totalS = 0;
    for(var col = 0; col <= columns - 5; col++){
        if($("#tbllistado tbody tr td select").eq(col).val() == "A"){
            totalA += 1;
        }
        if($("#tbllistado tbody tr td select").eq(col).val() == "F"){
            totalF += 1;
        }
        if($("#tbllistado tbody tr td select").eq(col).val() == "S"){
            totalS += 1;
        }
    }
    $("#tbllistado tbody tr td select").eq(columns - 4).text("popo")
}

function agregarClase(){
    
    var numeroClases = 1;
    //Checamos cuantas clases hemor agregado;
    while($("#t" + numeroClases).length > 0){             
        numeroClases++;
    }    

    var inputFecha = "<th>Hora " + $('#tbllistado thead th').length + "</th>";
    
    $("#tbllistado thead tr").append(inputFecha);
    
    var rows = $("#tbllistado tbody tr").length;

    var columns = $("#tbllistado thead tr th").length;

    for(var index = 0; index < rows ; index++){
        var rowActual = $("#tbllistado tbody tr").eq(index);
        rowActual.append('<td>\n\
							<select data-style="btn btn-primary btn-round" name="asistencia"  class="selectpicker">\n\
			                    <option value="A">A</option>\n\
			                    <option value="F">F</option>\n\
			                    <option value="S">S</option>\n\
		                    </select>\n\
		        		</td>');
    }
    $(".selectpicker").selectpicker('refresh');  
}

function getGrupo(){
	var url_string = window.location.href;
	var url = new URL(url_string);
	var g = url.searchParams.get("g");
	

	return (g);
}

function nuevaAsistencia(){
	var g = getGrupo();
	var fechaAsistencia = $("#fechaAsistencia").val();
	var array = [];

	$("#tbllistado tbody tr").each(function (index) {
		var alumnoId=$(this).attr("id")
		$(this).find("select").each(function (index2) {
			array.push({"asistencia":$(this).val(),"alumnoId":alumnoId,"id":$(this).attr("id")})
		})
	})

	$.ajax({
		method: "POST",
		url: "../ajax/grupo.php?op=nueva&grupo="+g+"&fecha="+fechaAsistencia,
		dataType: "json",
		data: { array : JSON.stringify(array) }
	})
	.done(function (data, textStatus, jqXHR) {
		try {
			alertify.alert("Asistencia del " + fechaAsistencia + " guardada")
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

function addClase(asistencias){
    $("#tbllistado tbody tr").each(function (index,element) {

		var alumnoId=$(this).attr("id");

		$.each(asistencias, function (key, asistencia) {
    		if(asistencia.idAlumno == alumnoId){
    			//console.log($("#tbllistado tbody tr").eq(index))
    			var tipoA = ((asistencia.asistencia == 'A') 
                        ? 'selected' 
                        : ' ');
    			var tipoF = ((asistencia.asistencia == 'F') 
                        ? 'selected' 
                        : ' ');
    			var tipoS = ((asistencia.asistencia == 'S') 
                        ? 'selected' 
                        : ' ');

    			var rowActual = $("#tbllistado tbody tr").eq(index);
    			rowActual.append('<td>\n\
							<select id='+asistencia.id+' data-style="btn btn-primary btn-round" name="asistencia"  class="selectpicker">\n\
			                    <option '+tipoA +' value="A">A</option>\n\
			                    <option '+tipoF +' value="F">F</option>\n\
			                    <option '+tipoS +' value="S">S</option>\n\
		                    </select>\n\
		        		</td>');
    		}

    	});
    	
	});

	for (var i = 1; i < $('#tbllistado tbody tr').eq(0).find('td').length; i++) {
		var inputFecha = "<th>Hora " + i + "</th>";
    	$("#tbllistado thead tr").append(inputFecha);
	}
    
}

function checarFecha(){
	var g = getGrupo();
	
	var fechaAsistencia = $("#fechaAsistencia").val();
    $.getJSON("../ajax/grupo.php",
			{"op": "checarFecha",
			"g":g,
			"fecha":fechaAsistencia})
            .done(function (data, textStatus, jqXHR) {
                try {
                	limpiarClases();
                    if(data.length > 0){//si la fecha ya fue registrada, se cargan las fechas si no, pus quedan igual
						addClase(data);
						var count = $("#tbllistado tbody tr:first td").length;
						$("#tbllistado tbody tr").each(function (index,element) {
								for(i = $(this).children('td').length; i < count ; i++){
								var rowActual = $("#tbllistado tbody tr").eq(index);
				    			rowActual.append('<td>\n\
											<select  data-style="btn btn-primary btn-round" name="asistencia"  class="selectpicker">\n\
							                    <option  value="A">A</option>\n\
							                    <option selected  value="F">F</option>\n\
							                    <option  value="S">S</option>\n\
						                    </select>\n\
						        		</td>');
							}
						});

						$(".selectpicker").selectpicker('refresh');

					}
					$("#tbllistadoWrapper").show();
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

function limpiarClases(){
	$("#tbllistado tbody tr").each(function (index) {
		$(this).find('td').each(function (index2) {
			if(index2 >= 1){
				$(this).remove();
			}	
		})
	})

	$("#tbllistado thead tr").each(function (index) {
		$(this).find('th').each(function (index2) {
			if(index2 >= 1){
				$(this).remove();
			}	
		})
	})
}

init();