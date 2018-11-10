/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var corte_caja;
var generar_corte;
var iniciarDatePicker;
var tabla;
$("#form-pagar").hide();
$("#ver_recibo").hide();

alertify.pagar || alertify.dialog('pagar', function () {
    var header = '<span class="fa fa-exclamation-triangle" aria-hidden="true"'
            + 'style="vertical-align:middle;color:#e10000;">'
            + '</span> ¿Confirmar Pago?';
    return {
        main: function (content) {
            $(content).show();
            this.setContent(content);
        },
        prepare: function () {
            this.elements.footer.style.display = "none";
        },
        setup: function () {
            return {
                /* buttons collection */
                options: {
                    transition: 'slide',
                    basic: false,
                    maximizable: false,
                    resizable: false,
                    padding: true,
                    title: header
                },

            };
        },
        settings: {
            selector: undefined
        }
    };
});

alertify.pago_realizado || alertify.dialog('pago_realizado', function () {
    var header = 'Pago realizado con éxito <span class="fa fa-check-circle-o" aria-hidden="true"'
            + 'style="vertical-align:middle;color: green;">'
            + '</span> ';
    return {
        main: function (content) {
            $(content).show();
            this.setContent(content);
        },
        setup: function () {
            return {
                 
                options: {
                    transition: 'slide',
                    basic: false,
                    maximizable: false,
                    resizable: false,
                    padding: true,
                    title: header,
                },
                buttons:[{text: "Salir!", key:27/*Esc*/}],
                focus: { element:0 }
            };
        },
        settings: {
            selector: undefined
        }
    };
}); 
$('#btn-salir').click(function(){
        alertify.pagar().close();
});
$.fn.serializeObject = function(){
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
function cargando(){
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
    $(document).ajaxStart(function () {
        alertify.loading('<br><div class="fa-5x text-center">' +
                '<i class="fa fa-spinner fa-spin""></i>' +
                '</div>');
    });
    $(document).ajaxComplete(function (event, request, settings) {
        alertify.loading().close();
    });
}
function listar(pago, tipo) {
    $.fn.dataTable.Buttons.defaults.dom.button.className = 'btn btn-app p';
    var tbSelector;
    var url;
    if (tabla !== undefined && tabla !== null) {
        tabla.destroy();
    }
    switch (tipo) {
        case "Libros":
            url = "../ajax/pago_libro.php?op=listar";
            break;
        case "Extras":
            url = '../ajax/pago_extras.php?op=listar&pago=' + pago;
            break;
        case "Inscripciones":
            url = '../ajax/pago_inscripcion.php?op=listar&pago=' + pago;
            break;
        case "Cursos":
            url = '../ajax/pago_curso.php?op=listar&pago='+pago;
            break;
     
    }
    switch (pago) {
        case "ver_pagados":
            tbSelector = $('#tb-pagos');
            break;
        case "ver_nopagados":
            tbSelector = $('#tb-adeudos');
            break;
        case undefined || null:
            tbSelector = $('#tbllistado');
            break;
    }
    tabla = tbSelector.dataTable({
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return 'Details for '+data[0]+' '+data[1];
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table'
                } )
            }
        },
        columnDefs: [
            {responsivePriority: 1, targets: 0},
            {responsivePriority: 2, targets: -1},
        ],
        "aProcessing": "true", //Activamos el procesamiento del datatables
        "aServerSide": "true", //Paginación y filtrado realizados por el servidor
        "dom": "SBflrtip", //Definimos los elementos del control de tabla
        "buttons": [
            {
                "extend": "copyHtml5",
                "text": "<i class='fa fa-files-o'></i>Copiar Datos",
                "titleAttr": "Copiar Tabla"
            },
            {
                "extend": "print",
                "text": "<i class='fa fa-print'></i> Imprimir",
                "titleAttr": "Imprimir Tabla",
                "messageTop": "La información de este documento pertenece a la escuela CLE, derechos restringidos."
            },
            {
                "extend": "pdfHtml5",
                "text": "<i class='fa fa-file-pdf-o' aria-hidden='true'></i> Exportar PDF",
                "titleAttr": "Exportar a PDF",
                "messageTop": "La información de este documento pertenece a la escuela CLE, derechos restringidos.",
            },
            {
                "extend": "excelHtml5",
                "text": "<i class='fa fa-file-excel-o' aria-hidden='true'></i>Exportar Excel",
                "titleAttr": "Exportar a Excel",
                "messageTop": "La información de este documento pertenece a la escuela CLE, derechos reservados."
            },
            {
                "extend": "colvis",
                "text": "<i class='fa fa-eye' aria-hidden='true'></i>OCultar",
                "titleAttr": "Ocultar y Mostrar Columnas"
            }
        ],
        "ajax": url,
        "bDestroy": true,
        "lengthMenu": [[10, 20, 30, 50, -1], [10, 20, 30, 50, "All"]],
        "order": [[0, "desc"]], //Ordenar (columna,orden)
        "language": {
            "url": "../public/bower_components/datatables/json/Spanish.json"
        }
    }).DataTable();
    
    obtener_permisos(tipo);
}
//Función para saber que tipo de usuario inicio sesión y así poder saber que le mostraremos al usuario
function obtener_permisos(tipo) {
    $.getJSON({
        url: "../ajax/vistas_permisos.php",
    }).done(function (data, textStatus, jqXHR) {
        try {
            permiso = data.permiso;
            if (data.permiso == "admin") {
                if(tipo==="Libros"){
                   $('<li role="presentation">\n\
                        <a class="btn-default" href="#" title="Corte de Caja"  onclick="corte_caja()" >\n\
                        <span><i class="fa fa-scissors" aria-hidden="true"></i></span>\n\
                        </a>\n\
                    </li>\n\
                ').appendTo($('.nav-pills')); 
                }
                $('<button onclick="corte_caja()"  class="btn btn-app p" tabindex="0" aria-controls="tbllistado" type="button" \n\
                title="Corte de caja" id="corte_caja"><span><i class="fa fa-scissors" aria-hidden="true"></i></span> Corte Caja</button>\n\
                ').appendTo($('.dt-buttons'));
                iniciarFuncionesCorteCaja(tipo);
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
function iniciarFuncionesCorteCaja(tipo) {
    var header = "";
    switch (tipo) {
        case "Libros":
            header = "Corte de Caja Libros";
            break;
        case "Extras":
             header = "Corte de Caja Extras";
            break;
        case "Cursos":
             header = "Corte de Caja Cursos";
            break;
        case "Inscripciones":
             header = "Corte de Caja Inscripciones";
            break;
        case "Nominas":
             header = "Corte de Caja Nóminas";
             break;
    }
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
                            + '</span> '+header)
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
                        '<input type="hidden" id="tipo" name="tipo" value="'+tipo+'" />',
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

