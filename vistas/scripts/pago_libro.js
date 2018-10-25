/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var tabla;

function init() {
    inicializarSelects();
    listar_pagos();
    togglePanel();
    agregarValorCosto();
    pagar();
}

function togglePanel() {
    $('.nav-pills a').on('shown.bs.tab', function (event) {
        var nombre = $(event.target).text();         // active tab
        if (nombre == "Libros Pagados") {
            //listar_pagos();
        }
        var y = $(event.relatedTarget).text();  // previous tab
    });

}
function inicializarSelects() {
    $(document).ajaxStart(function () {
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
        alertify.loading('<br><div class="fa-5x text-center">' +
                '<i class="fa fa-spinner fa-spin""></i>' +
                '</div>');
    });
    $(document).ajaxComplete(function (event, request, settings) {
        alertify.loading().close();
    });
    $.getJSON("../ajax/pago_libro.php",
            {"op": "iniciar_selects"})
            .done(function (data, textStatus, jqXHR) {
                try {
                    $.each(data, function (key, dat) {
                        $.each(dat.alumnos, function (key, alumnos) {
                            $("#alumno").append(
                                    '<option data-content="<span class=\'badge badge-success\'>' + alumnos.id + '</span> - '
                                    + alumnos.nombre + ' ' + alumnos.apellidoP + ' ' + alumnos.apellidoM + '" value="' + alumnos.id + '"></option>');
                            $("#alumno").selectpicker('refresh');
                        });
                        $.each(dat.libros, function (key, libros) {
                            $("#libro").append(
                                    '<option value="' + libros.id + '" data-costo="' + libros.costo + '" data-content="' + libros.nombre + ' - <span class=\'badge badge-success\'>  $' + libros.costo + '</span>" \n\
                                    value="' + libros.id + '"></option>');
                            $("#libro").selectpicker('refresh');
                        });
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
function agregarValorCosto() {
    $("#libro").on('change', function (e) {
        var costo = $(this).find(':selected').data('costo');
        $('#libro_costo').remove();
        $('#pagar_libros').append('<input type="hidden" id="libro_costo" name="libro_costo" value="' + costo + '">');
        console.log($(this).val());
    });
}
function pagar() {
    $('form#pagar_libros').submit(function () {
        var dato = $( this ).serializeObject();
        event.preventDefault();
        alertify.dialog('confirm').
                set({
                    transition: 'slide',
                    message: '	\n\
        <div class="form-horizontal">\n\
		<div class="form-group ">\n\
			<label for="alertify-libro" class="col-sm-3 control-label">Libro</label>\n\
			<div class="col-sm-9 ">\n\
                            <input id="alertify-libro" disabled type="text" class="form-control" value="' + dato.libro + '">\n\
                        </div>\n\
		</div>\n\
		<div class="form-group">\n\
			<label for="alertify-comprador" class="col-sm-3 control-label">Comprador</label>\n\
			<div class="col-sm-9">\n\
                            <input id="alertify-comprador" disabled type="text" class="form-control" value="' + dato.alumno + '">\n\
			</div>\n\
		</div>\n\
                <div class="form-group">\n\
                    <label for="alertify-forma-pago" class="col-sm-3 control-label">Forma Pago</label>\n\
                    <div class="col-sm-9">\n\
                        <input id="alertify-forma-pago" disabled type="text" class="form-control" value="' + dato.forma_pago + '">\n\
                    </div>\n\
		</div>\n\
		<div class="form-group">\n\
			<label for="alertify-monto-pago" class="col-sm-3 control-label">Total a pagar</label>\n\
			<div class="col-sm-9">\n\
                            <div class="input-group">\n\
                                <div class="input-group-addon">$</div>\n\
				<input id="alertify-monto-pago" disabled type="text" class="form-control" value="' + dato.libro_costo + '">\n\
                            </div>\n\
                        </div>\n\
		</div>\n\
	</div>',
                    'reverseButtons': true,
                    'labels': {ok: 'Confirmar', cancel: 'Cancelar!'},
                    onok: function () {
                        $.ajax({
                            method: "POST",
                            url: "../ajax/pago_libro.php?op=pagar",
                            dataType: "json",
                            data: $("form#pagar_libros").serialize()
                        }).done(function (data, textStatus, jqXHR) {
                            try {
                                alertify.notify(data.mensaje, data.verificar, 5, function () {
                                });
                                tabla.ajax.reload();
                                resetForm();
                            } catch (error) {
                                alertify.notify(error.message, 'error', 5, function () {
                                });
                            }
                        }).fail(function (jqXHR, textStatus, errorThrown) {
                            if (console && console.log) {
                                console.log("Algo ha fallado: " + textStatus + " " + jqXHR + " " + errorThrown);
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
    });

}
function resetForm() {
    $('#libro_costo').remove();
    $($("form#pagar_libros"))[0].reset();
    $(".selectpicker").val('default');
    $(".selectpicker").selectpicker("refresh");
}
function listar_pagos() {
    tabla = $('#tbllistado').dataTable({
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
            url: '../ajax/pago_libro.php?op=listar',
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
$.fn.serializeObject = function()
{
   var o = {};
   var a = this.serializeArray();
   $.each(a, function() {
       if (o[this.name]) {
           if (!o[this.name].push) {
               o[this.name] = [o[this.name]];
           }
           o[this.name].push(this.value || '');
       } else {
           o[this.name] = this.value || '';
       }
   });
   return o;
};
init();