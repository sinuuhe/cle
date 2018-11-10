/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var tabla;
var fecha;
var corte_caja;
var generar_corte;
var iniciarDatePicker;
//Función que se ejecuta al inicio
function init() {
    cambiarSemanaNomina();
    listar("ver_nopagados");
    actualizarTabla();
}
//Función para saber que tipo de usuario inicio sesión y así poder saber que le mostraremos al usuario
function obtener_permisos() {
    $.getJSON({
        url: "../ajax/vistas_permisos.php",
    }).done(function (data, textStatus, jqXHR) {
        try {
            permiso = data.permiso;
            if (data.permiso == "admin") {
                $('<button onclick="corte_caja()"  class="btn btn-default p" tabindex="0" aria-controls="tbllistado" type="button" \n\
                title="Corte de caja" id="corte_caja"><span><i class="fa fa-scissors" aria-hidden="true"></i></span></button>\n\
                ').appendTo($('.dt-buttons'));
                iniciarFuncionesCorteCaja();
            }
        } catch (error) {
            alertify.notify(error.message, 'error', 5, function () {});
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        if (console && console.log) {
            console.log("Algo ha fallado: " + textStatus + " " + jqXHR + " " + errorThrown);
        }
    });
}
function iniciarFuncionesCorteCaja() {
    if (typeof corte_caja === 'undefined') {
        corte_caja = function () {
            alertify.dialog('confirm').
                    set({
                        transition: 'slide',
                        message: '<div class="form-horizontal">\n\
                                <h4>SELECIONA RANGO DE FECHAS:</h2>\n\
                                <div class="form-group">\n\
                                    <label for="fecha_inicio" class="col-sm-3 control-label">Fecha Inicio</label>\n\
                                    <div class="col-sm-9 input-group date" data-provide="datepicker" id="fecha_inicio">\n\
                                    <input id="fecha_i" required type="text" class="form-control custom-input" />\n\
                                        <span class="input-group-addon">\n\
                                            <span class="glyphicon glyphicon-calendar"></span>\n\
                                        </span>\n\
                                    </div>\n\
                                </div>\n\
                                <div class="form-group">\n\
                                    <label for="fecha_fin" class="col-sm-3 control-label">Fecha Fin</label>\n\
                                    <div class="col-sm-9 input-group date" data-provide="datepicker" id="fecha_fin">\n\
                                    <input id="fecha_f" required type="text" class="form-control custom-input" />\n\
                                        <span class="input-group-addon">\n\
                                            <span class="glyphicon glyphicon-calendar"></span>\n\
                                        </span>\n\
                                    </div>\n\
                                </div>\n\
                        </div>',
                        reverseButtons: true,
                        labels: {
                            ok: 'Confirmar',
                            cancel: 'Cancelar!'
                        },
                        onshow: function () {
                            iniciarDatePicker();
                        },
                        onok: function (closeEvent) {
                            var fecha_inicio = moment($('#fecha_inicio').datepicker("getDate")).format("YYYY-MM-DD") + " 00:00:00";
                            var fecha_fin = moment($('#fecha_fin').datepicker("getDate")).format("YYYY-MM-DD") + ' 23:59:59';
                            console.log(fecha_inicio + " " + fecha_fin);
                            if (fecha_inicio == "Invalid date 00:00:00") {
                                closeEvent.cancel = true;
                                alertify.error('Selecciona la fecha de incio');
                                $('#fecha_i').focus();
                            } else if (fecha_fin == "Invalid date 23:59:59") {
                                closeEvent.cancel = true;
                                alertify.error('Selecciona la fecha final');
                                $('#fecha_f').focus();
                            } else {
                                generar_corte(fecha_inicio, fecha_fin);
                                $("#generar_corte").remove();
                            }
                        },
                        oncancel: function () {
                            alertify.error('Cancelado');
                        }
                    })
                    .setHeader('<span class="fa fa-scissors" aria-hidden="true"'
                            + 'style="vertical-align:middle;color:#000000;">'
                            + '</span> Corte de Caja Nóminas')
                    .show();
        }
    }
    if (typeof generar_corte === 'undefined') {
        generar_corte = function (fecha_inicio, fecha_fin) {
            $('<form>', {
                "id": "generar_corte",
                "method": "POST",
                "target": "_blank",
                "html": '<input type="hidden" id="fecha_i" name="fecha_i" value="' + fecha_inicio + '" />' +
                        '<input type="hidden" id="fecha_f" name="fecha_f" value="' + fecha_fin + '" />' +
                        '<input type="hidden" id="tipo" name="tipo" value="Nominas" />',
                "action": '../impresiones/tickets/corteCaja.php'
            }).appendTo(document.body).submit();
        }
    }
    if (typeof iniciarDatePicker === 'undefined') {
        iniciarDatePicker = function () {
            $("#fecha_inicio").datepicker({
                language: 'es',
                clearBtn: true,
                calendarWeeks: true,
                autoclose: true,
                todayHighlight: true,
                format: 'dd/mm/yyyy',
                show: true,
                endDate: new Date()
            }).on('changeDate', function (selected) {
                var startDate = new Date(selected.date.valueOf());
                $('#fecha_fin').datepicker('setStartDate', startDate);
            }).on('clearDate', function () {
                $('#fecha_fin').datepicker('setStartDate', null);
            }).datepicker('update', new Date());

            $("#fecha_fin").datepicker({
                language: 'es',
                clearBtn: true,
                calendarWeeks: true,
                autoclose: true,
                todayHighlight: true,
                format: 'dd/mm/yyyy',
                show: true,
                endDate: new Date()
            }).on('changeDate', function (selected) {
                var endDate = new Date(selected.date.valueOf());
                $('#fecha_inicio').datepicker('setEndDate', endDate);
            }).on('clearDate', function () {
                $('#fecha_inicio').datepicker('setEndDate', null);
            }).datepicker('update', new Date());
        }
    }

}
//Función para  cambiar los labels de la vista, para que se pueda visualizar el número de semana y las fechas correspondientes.
function cambiarSemanaNomina() {
    $.ajax({
        url: '../ajax/pago_nomina.php?op=cambiar_semana',
        data: {
            fecha: fecha
        },
        method: 'GET'
    }).done(function (response) {
        console.log(response);
        try {
            var respuesta = JSON.parse(response);
            $("#semana_inicio").text(respuesta.semana_inicio);
            $("#semana_fin").text(respuesta.semana_fin);
            $("#numero_semana").text(respuesta.num_semana);
        } catch (error) {
            console.log(error);
        }
    }).fail(function (response) {
        console.log(response);
    }).always(function (response) {
        console.log(response);
    });
}
//Función para iniciar el datepicker y que el usuario pueda seleccionar la semana
function iniciarDatePicker() {
    $("#datepicker").datepicker({
        language: 'es',
        clearBtn: true,
        calendarWeeks: true,
        autoclose: true,
        todayHighlight: true,
        format: 'dd/mm/yyyy',
        show: true,
        endDate: new Date()
    }).datepicker('update', new Date());

    fecha = moment($('#datepicker').datepicker("getDate")).format("YYYY-MM-DD");
}
//Función listar pagos de extras.
//La función recibe la variable pago que contiene la bandera para saber si listar los adeudos o los pagos.
//Está función es llamada del onclick en la vista.
function listar(pago) {
    tipopago(pago);
    tabla = $('#tbllistado').dataTable({
        colReorder: true,
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return 'Detalles para ' + data[0] + ' ' + data[1];
                    }
                }),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                    tableClass: 'table'
                })
            }
        },
        columnDefs: [
            {responsivePriority: 1, targets: 0},
            {responsivePriority: 2, targets: -1},
        ],
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        dom: 'SBflrtip', //Definimos los elementos del control de tabla
        buttons: [
            {
                titleAttr: 'Cambiar Semana de la Nómina',
                className: 'p',
                text: '<i class="fa fa-calendar-o" aria-hidden="true"></i>',
                action: function ( ) {
                    seleccionarFecha();
                }
            },
            {
                extend: 'copyHtml5',
                text: '<i class="fa fa-files-o"></i>',
                titleAttr: 'Copiar Tabla'
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i>',
                titleAttr: 'Imprimir Tabla',
                messageTop: 'La información de este documento pertenece a la escuela CLE, derechos restringidos.'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                titleAttr: 'Exportar a PDF',
                messageTop: 'La información de este documento pertenece a la escuela CLE, derechos restringidos.',
            },
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                titleAttr: 'Exportar a Excel',
                messageTop: 'La información de este documento pertenece a la escuela CLE, derechos reservados.'
            },
            {
                extend: 'colvis',
                text: '<i class="fa fa-eye aria-hidden="true"></i>',
                titleAttr: 'Ocultar y Mostrar Columnas'
            },
        ],
        "ajax": {
            url: '../ajax/pago_nomina.php',
            type: "GET",
            data: {
                fecha: fecha,
                op: 'listar',
                pago : pago
            },
            error: function (e) {
                console.log(e);
            }
        },
        "bDestroy": true,
        "lengthMenu": [[10, 20, 30, 50, -1], [10, 20, 30, 50, "All"]],
        "order": [[0, "desc"]], //Ordenar (columna,orden)
        "language": {
            buttons: {
                colvis: 'Vista de Columnas',
                print: 'Imprimir',
                copy: 'Copiar',
                copyTitle: 'Añadido al portapapeles',
                copySuccess: {
                    _: '%d líneas copiadas',
                    1: '1 línea copiada'
                }
            },
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    }).DataTable();
    obtener_permisos();
}
//Función para hacer el cambio en las columnas correspondientes de la tabla, dependiendo de la acción que se deseé, así como habilitar e inhabilitar  los botones. 
//La variable pago, solo puede recibir dos valores "ver_pagados" o "ver_nopagados".
function tipopago(pago) {
    if (tabla !== undefined && tabla !== null) {
        tabla.destroy();//Se destruye la tabla porque llega información nueva. (FECHA_PAGO)
    }
    if (pago === "ver_pagados") {
        $.each($("#tbllistado thead th"), function (index, val) {//se recorren todos los th dentro de thead 
            if (index == 4) //La pocisión 4 es el th de Monto Pago
                $(val).after("<th class='col-fecha_pago'>Fecha de pago</th>"); //se inserta un nombre de columna despues de th de Monto Pago
        });
        $.each($("#tbllistado tfoot th"), function (index, val) {//se recorren todos los th dentro de tfoot
            if (index == 4) //La pocisión 4 es el th de Monto Pago
                $(val).after("<th class='col-fecha_pago'>Fecha de pago</th>");//se inserta un nombre de columna despues de th de Monto Pago. Se agrega la clase col-fecha_pago para despúes poder borrarla
        });
        $("#btnverpagados").attr("disabled", "true"); //se inhabilita el botón de Pagos(verpagados), para evitar que se agreguen más th.
        $("#btnvernopagados").removeAttr("disabled");//se habilita el botón de Adeudos(vernopagados)
    } else {
        $("#btnverpagados").removeAttr("disabled");//se habilita el botón de Pagos(verpagados)
        $("#btnvernopagados").attr("disabled", "true"); //se inhabilita el botón de Adeudos(vernopagados), para evitar que se agreguen más th.
        $('.col-fecha_pago').each(function () { //Se recorren todos los elementos que tengan la clases .col-fecha_pago
            $(this).remove(); //Se borrar todos los elementos
        });
        $("#tbllistado tbody tr td").each(function (index, val) {//se recorren todos los th dentro de tfoot
            if (index == 5) //La pocisión 5 es el td de Fecha de Pago
                $(val).remove();//Se borra el el td de Fecha Pago
        });

    }
}
//Función que abre el modal para que el usuario selecciona la semana para poder visualizar la nomina de esa semana.
function seleccionarFecha() {
    alertify.dialog('confirm').
            set({
                transition: 'slide',
                message: '<div class="form-horizontal">\n\
                                <div class="form-group">\n\
                                    <label for="datepicker" class="col-sm-3 control-label">Selecciona semana</label>\n\
                                    <div class="col-sm-9 input-group date" data-provide="datepicker" id="datepicker">\n\
                                    <input required type="text" class="form-control custom-input" />\n\
                                        <span class="input-group-addon">\n\
                                            <span class="glyphicon glyphicon-calendar"></span>\n\
                                        </span>\n\
                                    </div>\n\
                                </div>\n\
                        </div>',
                reverseButtons: true,
                labels: {
                    ok: 'Confirmar', 
                    cancel: 'Cancelar!'
                },
                onshow: function(){ 
                    iniciarDatePicker();
                },
                onok: function (closeEvent) {
                    fecha = moment($('#datepicker').datepicker("getDate")).format("YYYY-MM-DD");
                    if (fecha == "Invalid date"){
                        closeEvent.cancel = true;
                        alertify.error('Selecciona una Fecha');
                    }else{
                        cambiarSemanaNomina();
                        $('#fecha').remove();
                        $( "body" ).append( '<input type="hidden" id="fecha" value="'+fecha+'" />' );
                        listar("ver_nopagados");
                        alertify.success('Semana Cambiada');
                    }
                },
                oncancel: function () {
                    alertify.error('Cancelado');
                }
            })
            .setHeader('<span class="fa fa-calendar" aria-hidden="true"'
                    + 'style="vertical-align:middle;color:#000000;">'
                    + '</span> Cambiar semana de Nómina')
            .show();
}
//Función para cambiar el estatus de pago de extras a pagado.
function pagar(idpagonomina) {
    var pagonomina = {}
    $('.idpago-' + idpagonomina).each(function () {
        pagonomina[$(this).attr("data-var")] = $(this).text();
    });
    alertify.dialog('confirm').
            set({
                transition: 'slide',
                message: '	\n\
        <div class="form-horizontal">\n\
		<div class="form-group ">\n\
			<label for="nombre-' + idpagonomina + '" class="col-sm-3 control-label">Maestro</label>\n\
			<div class="col-sm-9 ">\n\
                            <input id="nombre-' + idpagonomina + '" disabled type="text" class="form-control" value="' + pagonomina.nombre + '">\n\
                        </div>\n\
		</div>\n\
		<div class="form-group">\n\
			<label for="matricula-' + idpagonomina + '" class="col-sm-3 control-label">Matrícula</label>\n\
			<div class="col-sm-9">\n\
                            <input id="matricula-' + pagonomina.matricula + '" disabled type="text" class="form-control" value="' + pagonomina.matricula + '">\n\
			</div>\n\
		</div>\n\
		<div class="form-group">\n\
			<label for="matricula-' + idpagonomina + '" class="col-sm-3 control-label">Total a pagar</label>\n\
			<div class="col-sm-9">\n\
                            <div class="input-group">\n\
                                <div class="input-group-addon">$</div>\n\
				<input id="matricula-' + idpagonomina + '" disabled type="text" class="form-control" value="' + pagonomina.monto_pago + '">\n\
                            </div>\n\
                        </div>\n\
		</div>\n\
		<div class="form-group">\n\
			<label for="forma_pago-' + idpagonomina + '" class="col-sm-3 control-label">Forma de pago</label>\n\
			<div class="col-sm-9">\n\
				<select id="forma_pago-' + idpagonomina + '" class="form-control  idpago-' + idpagonomina + '">\n\
                                    <option value="Efectivo">Efectivo</option>\n\
                                    <option value="Tarjeta Bancaria">Tarjeta Bancaria</option>\n\
                                    <option value="Cheque">Cheque</option>\n\
                                    <option value="Transferencia">Transferencia</option>\n\
				</select>\n\
			</div>\n\
		</div>\n\
	</div>',
                'reverseButtons': true,
                'labels': {ok: 'Confirmar', cancel: 'Cancelar!'},
                onok: function () {
                    $.post("../ajax/pago_nomina.php?op=pagar", {idpagonomina: idpagonomina,fech:$('#fecha').val()},
                            function (e) {
                                try {
                                    var respuesta = JSON.parse(e);
                                    alertify.notify(respuesta.mensaje, respuesta.verificar, 5, function () {
                                    });
                                    fecha = respuesta.fecha;
                                    ver_recibo(idpagonomina);
                                    tabla.ajax.reload();
                                } catch (error) {
                                    alertify.notify(error.message, 'error', 5, function () {
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
                    + '</span> ¿Confirmar Pago ?')
            .show();
}
//Función para ver los recibos de pago, que ya fueron pagados.
function ver_recibo(idpagonomina) {
    $('<form>', {
        "method": "POST",
        "target": "_blank",
        "html": '<input type="hidden" id="idpagonomina" name="idpagonomina" value="' + idpagonomina + '" />',
        "action": '../impresiones/tickets/reciboNominaPDF.php'
    }).appendTo(document.body).submit();
}

init();
