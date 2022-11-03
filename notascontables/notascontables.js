function guardarnotacontableadjunto(iddocumento, tiponota, comentario) {
    cadenau = "iddocumento=" + iddocumento + "&tiponota=" + tiponota + "&comentario=" + comentario;
    $.ajax({
        type: "POST",
        url: "notascontables/guardanotaadjunto.php",
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

function noaprobarnota(iddocumento, comentariodesaprobacion) {
    cadenau = "iddocumento=" + iddocumento + "&comentario=" + comentariodesaprobacion;
    $.ajax({
        type: "POST",
        url: "notascontables/desaprobarnota.php",
        data: cadenau,
        success: function (r) {
            //console.log(r);
            //debugger;
        }
    });
}
function enviarmensaje(iddocumento, comentariomensaje) {
    cadenau = "iddocumento=" + iddocumento + "&comentario=" + comentariomensaje;
    $.ajax({
        type: "POST",
        url: "notascontables/enviarmensaje.php",
        data: cadenau,
        success: function (r) {
            console.log(r);
            debugger;
        }
    });
}
function revision(iddocumento) {
    cadenau = "iddocumento=" + iddocumento;
    $.ajax({
        type: "POST",
        url: "notascontables/revision.php",
        data: cadenau,
        success: function (r) {
            //console.log(r);
            //debugger;
        }
    });
}

function autorizar(iddocumento) {
    cadenau = "iddocumento=" + iddocumento;
    $.ajax({
        type: "POST",
        url: "notascontables/autorizarnota.php",
        data: cadenau,
        success: function (r) {
            //console.log(r);
            //debugger;
        }
    });
}

function aprobarnota(iddocumento) {
    cadenau = "iddocumento=" + iddocumento;
    $.ajax({
        type: "POST",
        url: "notascontables/aprobarnota.php",
        data: cadenau,
        success: function (r) {
            //console.log(r);
            //debugger;
        }
    });
}

function registrargrupogestioncontable(iddoc, conceptos, fechas, importes, ans, tms) {
    cadenau = "conceptos=" + conceptos + "&iddoc=" + iddoc + "&fechas=" + fechas + "&importes=" + importes + "&ans=" + ans + "&tms=" + tms;
    $.ajax({
        type: "POST",
        url: "notascontables/registragrupogestioncontable.php",
        data: cadenau,
        success: function (r) {
            if (r == 111) {
                // console.log(r);
                //  debugger;
            } else {
                //console.log(r);
                //debugger;
            }
        }
    });
}

function registrogestioncontable(iddoc, concepto, fecha, importe, tm, an, lmauxiliar) {
    cadenau = "iddoc=" + iddoc + "&concepto=" + concepto + "&importe=" + importe + "&fecha=" + fecha + "&tm=" + tm + "&lmauxiliar=" + lmauxiliar + "&an=" + an;
    $.ajax({
        type: "POST",
        url: "notascontables/registrogestioncontable.php",
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

function editarnota(id, usuario, type, clasificacion, comentario, batch, proceso) {
    cadenau = "type=" + type + "&clasificacion=" + clasificacion + "&comentario=" + comentario + "&batch=" + batch + "&usuario=" + usuario + "&id=" + id + "&proceso=" + proceso;
    $.ajax({
        type: "POST",
        url: "notascontables/editarnota.php",
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
function verificar(desde, hasta, batch) {
    cadenau = "desde=" + desde + "&hasta=" + hasta + "&batch=" + batch;
    $.ajax({
        type: "POST",
        url: "notascontables/verificarbatch.php",
        data: cadenau,
        success: function (r) {
            // console.log(r);
            // debugger;

        }
    });
}
function limpiarnota(id) {
    $.ajax({
        type: "POST",
        url: "notascontables/limpiarnota.php",
        data: "id=" + id,
        success: function (r) {
            // console.log(r);
            // debugger;

        }
    });
}
function cambiarseleccionnota(id) {
    $.ajax({
        type: "POST",
        url: "notascontables/cambiarseleccion.php",
        data: "id=" + id,
        success: function (r) {
            // console.log(r);
            // debugger;

        }
    });
}

function agregaridregistro(id) {
    $.ajax({
        type: "POST",
        data: "id=" + id,
        success: function (r) {
            $('#idu').val(id);
            // console.log(id);
            // debugger;
        }
    });
}

function elminarregistro(id) {

    $.ajax({
        type: "POST",
        url: "notascontables/eliminarregistro.php",
        data: "id=" + id,
        success: function (r) {
            if (r == 1) {
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            } else {
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            }
        }
    });
}

function registrarnota(type, clasificacion, comentario, batch, tipo) {
    cadenau = "type=" + type + "&clasificacion=" + clasificacion + "&comentario=" + comentario + "&batch=" + batch + "&tipo=" + tipo;
    $.ajax({
        type: "POST",
        url: "notascontables/agregarnota.php",
        data: cadenau,
        success: function (r) {
            if (r == 111) {
                //   console.log(batch);
                // debugger;
            } else {
                //console.log(batch);
                //debugger;
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
                //  console.log(r);
                //  debugger;
            } else {
                //console.log(r);
                //debugger;
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

