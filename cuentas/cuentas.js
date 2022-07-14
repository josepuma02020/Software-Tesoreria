function datoscuenta(id, descripcion) {
    $('#cuenta').val(id);
    $('#descripcion').val(descripcion);
}

function registrarcuenta(cuenta, descripcion) {
    cadenau = "cuenta=" + cuenta + "&descripcion=" + descripcion;
    $.ajax({
        type: "POST",
        url: "cuentas/registrarcuenta.php",
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

function editarcuenta(cuenta, descripcion) {
    cadenau = "cuenta=" + cuenta + "&descripcion=" + descripcion;
    $.ajax({
        type: "POST",
        url: "cuentas/editarcuenta.php",
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