function registrarfactura(iddoc, valor, user, tipo, fechafactura, ri, an, cuenta) {
    cadenau = "valor=" + valor + "&cuenta=" + cuenta + "&iddoc=" + iddoc + "&user=" + user + "&tipo=" + tipo + "&fechafactura=" + fechafactura + "&ri=" + ri + "&an=" + an;
    $.ajax({
        type: "POST",
        url: "facturas/registrarfactura.php",
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