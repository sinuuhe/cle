/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function init() {
    cargando();
    inicializarSelects();
    listar(null,"Libros");
    agregarValorCosto();
    $('form#pagar_libros').submit(function () {
        event.preventDefault();
        var dato = $( this ).serializeObject();
        $("#flibro").val($('#libro').find(':selected').data('nombre'));
        $("#fcomprador").val($('#alumno').find(':selected').data('nombre'));
        $("#fforma_pago").val(dato.forma_pago);
        $("#fmonto-pago").val(dato.libro_costo);
        alertify.pagar($('#form-pagar')[0]);
    });
    $('#form-pagar').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            method: "POST",
            url: "../ajax/pago_libro.php?op=pagar",
            dataType: "json",
            data: $('form#pagar_libros').serialize(),
        }).done(function (data, textStatus, jqXHR) {
            try {
                if (data.mensaje == "Pago realizado con éxito.") {
                    alertify.pagar().close();
                    $(".idpago").val(data.id_generado);
                    tabla.ajax.reload();
                    resetForm();
                    alertify.pago_realizado($('#ver_recibo')[0]);
                } else {
                    alertify.notify(data.mensaje, 'error', 5, function () {});
                }
            } catch (error) {
                alertify.notify(error.message, 'error', 5, function () {});
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            if (console && console.log) {
                console.log("Algo ha fallado: " + textStatus + " " + jqXHR + " " + errorThrown);
            }
        });
    });
}
function inicializarSelects() {
    cargando();
    $.getJSON("../ajax/pago_libro.php",
            {"op": "iniciar_selects"})
            .done(function (data, textStatus, jqXHR) {
                try {
                    $.each(data, function (key, dat) {
                        $.each(dat.alumnos, function (key, alumnos) {
                            $("#alumno").append(
                                    '<option data-nombre="'+ alumnos.nombre +'" data-content="<span class=\'badge badge-success\'>' + alumnos.id + '</span> - '
                                    + alumnos.nombre + ' ' + alumnos.apellidoP + ' ' + alumnos.apellidoM + '" value="' + alumnos.id + '"></option>');
                            
                        });
                        $.each(dat.libros, function (key, libros) {
                             var dataContent = libros.nombre +' - <span class=\'badge badge-success\'>  $' + libros.costo + '</span>' +
                                ((libros.cantidad < 5) 
                                    ? ' - Inv: <span class=\'label label-danger\'> ' + libros.cantidad +  '</span>' 
                                    : ' - Inv: <span class=\'label label-primary\'> ' + libros.cantidad +  '</span>');
                           
                                $("#libro").append(
                                '<option ' + ((libros.cantidad == 0) ? 'disabled' : '') +' data-nombre="'+ libros.nombre +
                                '" value="' + libros.id +
                                '" data-costo="' + libros.costo +
                                '" data-content="'+ dataContent +'"');
                        });
                    });
                    $("#libro").selectpicker('refresh');
                    $("#alumno").selectpicker('refresh');
                } catch (error) {
                    alertify.notify(error.message, 'error', 5, function () {
                    });
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
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
    });
}
function resetForm() {
   
    $('#libro_costo').remove();
    $($("form#pagar_libros"))[0].reset();
    $("#alumno").empty();
    $("#libro").empty();
    inicializarSelects();
    $(".selectpicker").val('default');
    $(".selectpicker").selectpicker("refresh");
    

}

init();