function eliminartipofactura(id) {
    cadenau = "id=" + id;
    $.ajax({
        type: "POST",
        url: "configuracion/tiposfactura/eliminartipofactura.php",
        data: cadenau,
        success: function (r) {
            if (r == 1) {
                console.log(r);
                debugger;
            } else {
                console.log(r);
                debugger;
            }
        }
    });
}

function guardar(salmin) {
    cadenau = "salmin=" + salmin;
    $.ajax({
        type: "POST",
        url: "configuracion/guardar.php",
        data: cadenau,
        success: function (r) {
            if (r == 1) {
                //console.log(r);
                //debugger;
            } else {
                //console.log(r);
                //debugger;
            }
        }
    });
}
function registrartipofactura(tipo) {
    cadenau = "tipo=" + tipo;

    $.ajax({
        type: "POST",
        url: "configuracion/tiposfactura/registrartipofactura.php",
        data: cadenau,
        success: function (r) {
            if (r == 1) {
                // console.log(r);
                // debugger;
            } else {
                // console.log(r);
                // debugger;
            }
        }
    });
}


function datostipofactura(id, tipofactura) {
    $('#idu').val(id);
    $('#tipofacturau').val(tipofactura);
}


function editartipofactura(id, tipofactura) {
    cadenau = "id=" + id + "&tipo=" + tipofactura;
    $.ajax({
        type: "POST",
        url: "configuracion/tiposfactura/editartipofactura.php",
        data: cadenau,
        success: function (r) {
            if (r == 1) {
                // console.log(r);
                // debugger;
            } else {
                // console.log(r);
                // debugger;
            }
        }
    });
}