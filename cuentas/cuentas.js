function registrarcuentagestioncontable(cuenta, descripcion, tipo, concepto) {
    cadenau = "cuenta=" + cuenta + "&descripcion=" + descripcion + "&tipo=" + tipo + "&concepto=" + concepto;
    $.ajax({
        type: "POST",
        url: "cuentas/registrarcuentagestioncontable.php",
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

function eliminarcuenta(cuenta) {
    cadenau = "cuenta=" + cuenta;
    $.ajax({
        type: "POST",
        url: "cuentas/eliminarcuenta.php",
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