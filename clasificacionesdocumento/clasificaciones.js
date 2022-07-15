function datosclasificacion(id, clasificacion) {
    $('#id').val(id);
    $('#clasificacion').val(clasificacion);
}

function registrarclasificacion(clasificacion) {
    cadenau = "clasificacion=" + clasificacion;
    $.ajax({
        type: "POST",
        url: "clasificacionesdocumento/registrarclasificacion.php",
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

function eliminarclasificacion(id) {
    cadenau = "id=" + id;
    $.ajax({
        type: "POST",
        url: "clasificacionesdocumento/eliminarclasificacion.php",
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