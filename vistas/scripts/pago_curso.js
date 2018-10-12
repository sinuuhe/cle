/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var tabla;
//Función que se ejecuta al inicio
function init() {
    listar("ver_nopagados");
    actualizarTabla();
}
function actualizarTabla(){
    $(window).resize(function () {
        if (this.resizeTO)
            clearTimeout(this.resizeTO);
        this.resizeTO = setTimeout(function () {
            $(this).trigger('resizeEnd');
        }, 500);
    });
    $(window).bind("resizeEnd", function () {
        if (tabla !== undefined && tabla !== null) {
            tabla.ajax.reload();//Se actualiza la tabla porque se redimensiona la pantalla. (FECHA_PAGO)
        }
    });
}
//Función listar pagos de extras.
//La función recibe la variable pago que contiene la bandera para saber si listar los adeudos o los pagos.
//Está función es llamada del onclick en la vista.
function listar(pago) {
    tipopago(pago);
    tabla = $('#tbllistado').dataTable({
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return 'Vista Completa';
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
            url: '../ajax/pago_curso.php?op=listar&pago=' + pago,
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
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
}
//Función para hacer el cambio en las columnas correspondientes de la tabla y los active en los botones. cuando esta la variable
//de pago de verpagados y vernopagados
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
//Función para cambiar el estatus de pago de extras a pagado.
function pagar(idpagocurso) {
    var pagocurso = {}
    $('.idpago-' + idpagocurso).each(function () {
        pagocurso[$(this).attr("data-var")] = $(this).text();
    });
    alertify.dialog('confirm').
            set({
                transition: 'slide',
                message: '	\n\
        <div class="form-horizontal">\n\
		<div class="form-group">\n\
			<label for="nombre-' + idpagocurso + '" class="col-sm-3 control-label">Alumno</label>\n\
			<div class="col-sm-9">\n\
				<input id="nombre-' + idpagocurso + '" disabled type="text" class="form-control" value="' + pagocurso.nombre + '">\n\
			</div>\n\
		</div>\n\
		<div class="form-group">\n\
			<label for="matricula-' + idpagocurso + '" class="col-sm-3 control-label">Matrícula</label>\n\
			<div class="col-sm-9">\n\
				<input id="matricula-' + pagocurso.matricula + '" disabled type="text" class="form-control" value="' + pagocurso.matricula + '">\n\
			</div>\n\
		</div>\n\
		<div class="form-group">\n\
			<label for="matricula-' + idpagocurso + '" class="col-sm-3 control-label">Total a pagar</label>\n\
			<div class="col-sm-9">\n\
                            <div class="input-group">\n\
                                <div class="input-group-addon">$</div>\n\
				<input id="matricula-' + idpagocurso + '" disabled type="text" class="form-control" value="' + pagocurso.monto_pago + '">\n\
                            </div>\n\
                        </div>\n\
		</div>\n\
		<div class="form-group">\n\
			<label for="forma_pago-' + idpagocurso + '" class="col-sm-3 control-label">Forma de pago</label>\n\
			<div class="col-sm-9">\n\
				<select id="forma_pago-' + idpagocurso + '" class="form-control  idpago-' + idpagocurso + '">\n\
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
                    $.post("../ajax/pago_curso.php?op=pagar", {idpagocurso: idpagocurso, forma_pago: $("#forma_pago-" + idpagocurso).val()},
                            function (e) {
                                try {
                                    var respuesta = JSON.parse(e);
                                    alertify.notify(respuesta.mensaje, respuesta.verificar, 5, function () {
                                        console.log('dismissed');
                                    });
                                    ver_recibo(idpagocurso);
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
//Función para ver los recibos de pago, que ya fueron pagados.
function ver_recibo(idpagocurso) {
    $('<form>', {
        "method": "POST",
        "target": "_blank",
        "html": '<input type="hidden" id="id" name="id" value="' + idpagocurso + '" />' +
                '<input type="hidden" id="concepto" name="concepto" value="Pago de curso" />' +
                '<input type="hidden" id="tipo" name="formato" value="pago_curso"    />',
        "action": '../impresiones/tickets/ticketPDF.php'
    }).appendTo(document.body).submit();
}

init();
