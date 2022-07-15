
function editartipo(id, tipodocumento) {
    cadenau = "id=" + id + "&tipo=" + tipodocumento;
    $.ajax({
        type: "POST",
        url: "tiposdocumento/editartipo.php",
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

function registrartipo(id, tipo) {
    cadenau = "id=" + id + "&tipo=" + tipo;
    $.ajax({
        type: "POST",
        url: "tiposdocumento/registrartipo.php",
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

function eliminartipo(id) {
    cadenau = "id=" + id;
    $.ajax({
        type: "POST",
        url: "tiposdocumento/eliminartipo.php",
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

function datostipo(id, descripcion) {
    $('#id').val(id);
    $('#tipodocumento').val(descripcion);
}
