function registrarnota(type, clasificacion, comentario, batch) {
    cadenau = "type=" + type + "&clasificacion=" + clasificacion + "&comentario=" + comentario + "&batch=" + batch;
    $.ajax({
        type: "POST",
        url: "notascontables/agregarnota.php",
        data: cadenau,
        success: function (r) {
            if (r == 111) {
                // console.log(r);
                // debugger;
            } else {
                // console.log(r);
                // debugger;
            }
        }
    });
}
function registrar(idnota, cuenta, fecha, debe, haber, lm, an, tipolm) {
    cadenau = "idnota=" + idnota + "&cuenta=" + cuenta + "&debe=" + debe + "&fecha=" + fecha + "&haber=" + haber + "&lm=" + lm + "&an=" + an + "&tipolm=" + tipolm;
    $.ajax({
        type: "POST",
        url: "notascontables/registrar.php",
        data: cadenau,
        success: function (r) {
            if (r == 1) {

                // console.log(r);
                // debugger;
                //window.location.reload();
            } else {
                //     console.log(r);
                //     debugger;
            }
        }
    });
}

function registrargrupo(iddoc, cuentas, dates, debes, habers, lms, ans) {
    cadenau = "cuentas=" + cuentas + "&iddoc=" + iddoc + "&dates=" + dates + "&debes=" + debes + "&habers=" + habers + "&lms=" + lms + "&ans=" + ans;
    $.ajax({
        type: "POST",
        url: "notascontables/registrargrupo.php",
        data: cadenau,
        success: function (r) {
            if (r == 111) {
                // console.log(r);
                // debugger;
                //window.location.reload();
            } else {
                // console.log(r);
                // debugger;
            }
        }
    });
}

