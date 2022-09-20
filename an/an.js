function registraan(id, nombre) {
    cadenau = "id=" + id + "&nombre=" + nombre;
    $.ajax({
        type: "POST",
        url: "an/registraran.php",
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

function datosan(id) {
    $('#idane').val(id);
}

function eliminaran(id) {
    cadenau = "id=" + id;
    $.ajax({
        type: "POST",
        url: "an/eliminaran.php",
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