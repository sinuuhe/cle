/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Extend existing 'alert' dialog
if(!alertify.errorAlert){
  //define a new errorAlert base on alert
  alertify.dialog('errorAlert',function factory(){
    return{
            build:function(){
                var errorHeader = '<span class="fa fa-times-circle fa-2x" '
                +    'style="vertical-align:middle;color:#e10000;">'
                + '</span> Error al inciar sesión.';
                this.setHeader(errorHeader);
            }
        };
    },true,'alert');
}

$("form#login").on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        method: "POST",
        url: "../ajax/usuario.php?op=verificar",
        data: $("form#login").serialize()
    }).done(function (data, textStatus, jqXHR) {
        try {
            if (isJson(data) && (data!=null)) {
                data=JSON.parse(data);
                alertify.notify("Iniciando sesión... " + data.nombre, 'success', 5, function () {
                    $(location).attr("href",data.ruta);            
                });
            } else {
                alertify
                    .errorAlert("Usuario y/o contraseña incorrectos");
            }
        } catch (error) {
            alertify.notify(error.message, 'error', 5, function () {});
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        if (console && console.log) {
            console.log("Algo has fallado: " + textStatus + " " + jqXHR + " " + errorThrown);
        }
    });
});

function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}