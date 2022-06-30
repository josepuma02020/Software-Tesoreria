function agregarnotacontable(valor, descripcion, fecha, encargado, tipogasto) {
    cadenau = "valor=" + valor + "&descripcion=" + descripcion + "&tipogasto=" + tipogasto + "&fecha=" + fecha + "&encargado=" + encargado;
    $.ajax({
        type: "POST",
        url: "gastos/agregargasto.php",
        data: cadenau,
        success: function (r) {
            if (r == 111) {
                window.location.reload();
            } else {
                console.log(r);
                debugger;
            }
        }
    });
    "&encargado=" + encargado;
}
function registrar(idnota, cuenta, fecha, debe, haber, lm, an, tipolm) {
    cadenau = "idnota=" + idnota + "&cuenta=" + cuenta + "&debe=" + debe + "&fecha=" + fecha + "&haber=" + haber + "&lm=" + lm + "&an=" + an + "&tipolm=" + tipolm;
    $.ajax({
        type: "POST",
        url: "funciones/notascontables/registrar.php",
        data: cadenau,
        success: function (r) {
            if (r == 111) {
                //console.log(r);
                //7debugger;
                //window.location.reload();
            } else {
                //console.log(r);
                //debugger;
            }
        }
    });
}

