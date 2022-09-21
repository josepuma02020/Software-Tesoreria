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