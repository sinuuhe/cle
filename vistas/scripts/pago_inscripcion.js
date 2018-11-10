/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//Función que se ejecuta al inicio
function init() {
    cargando();
    listar("ver_pagados","Inscripciones");
    actualizarTabla();
    $('#tb-adeudos tbody').on('click', 'button', function () {
        var data = tabla.row($(this).parents('tr')).data();
        $(".idpago").val($(this).attr("data-id"));
        $("#nombre").val(data[1]);
        $("#matricula").val(data[0]);
        $("#total").val(data[4]);
        alertify.pagar($('#form-pagar')[0]);
    });
    $('#form-pagar').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            method: "POST",
            url: "../ajax/pago_inscripcion.php?op=pagar",
            dataType: "json",
            data: $(this).serialize(),
        }).done(function (data, textStatus, jqXHR) {
            try {
                if (data.mensaje == "Pago realizado con éxito.") {
                    alertify.pagar().close();
                    tabla.ajax.reload();
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
    $('.nav-pills a').on('shown.bs.tab', function (event) {
        var nombre = $(event.target).attr("data-tipo");
        listar(nombre,"Inscripciones");
    });
}

init();
