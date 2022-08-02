function datosproceso(id) {
    $('#iduproceso').val(id);
}
function registrarproceso(equipo, proceso) {
    cadenau = "equipo=" + equipo + "&proceso=" + proceso;
    $.ajax({
        type: "POST",
        url: "procesos/registrarproceso.php",
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
function eliminarproceso(id) {
    cadenau = "id=" + id;
    $.ajax({
        type: "POST",
        url: "procesos/eliminarproceso.php",
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
function datosequipo(id) {
    $('#iduequipo').val(id);
}
function registrarequipo(equipo, area) {
    cadenau = "equipo=" + equipo + "&area=" + area;
    $.ajax({
        type: "POST",
        url: "procesos/registrarequipo.php",
        data: cadenau,
        success: function (r) {
            if (r == 1) {
                // console.log(r);
                //debugger;
            } else {
                //console.log(r);
                //debugger;
            }
        }
    });
}
function eliminarequipo(id) {
    cadenau = "id=" + id;
    $.ajax({
        type: "POST",
        url: "procesos/eliminarequipo.php",
        data: cadenau,
        success: function (r) {
            if (r == 1) {
                // console.log(r);
                // debugger;
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            } else {
                alertify.alert('ATENCION!!', 'No es posible eliminar este equipo, ya que este tiene procesos asignados.', function () {
                    alertify.success('Ok');
                });
                // console.log(r);
                // debugger;
            }
        }
    });
}
function datosarea(id) {
    $('#iduarea').val(id);
}
function registrararea(area) {
    cadenau = "area=" + area;
    $.ajax({
        type: "POST",
        url: "procesos/registrararea.php",
        data: cadenau,
        success: function (r) {
            if (r == 1) {
                // console.log(r);
                //debugger;
            } else {
                //console.log(r);
                //debugger;
            }
        }
    });
}
function eliminararea(id) {
    cadenau = "id=" + id;
    $.ajax({
        type: "POST",
        url: "procesos/eliminararea.php",
        data: cadenau,
        success: function (r) {
            if (r == 1) {
                // console.log(r);
                // debugger;
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            } else {
                alertify.alert('ATENCION!!', 'No es posible eliminar área, ya que esta tiene equipos asignados.', function () {
                    alertify.success('Ok');
                });

            }
        }
    });
}
