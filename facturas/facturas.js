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
function verificarbanco(banco) {
    cadenau = "banco=" + banco;
    $.ajax({
        type: "POST",
        url: "facturas/verificarbanco.php",
        data: cadenau,
        success: function (r) {
            if (r == 1) {
                console.log('blanco');
                // debugger;
                inputcuenta = document.getElementById("cuenta");
                inputcuenta.style.backgroundColor = "white";
            } else {
                // console.log('rojo');
                // debugger;
                inputcuenta = document.getElementById("cuenta");
                inputcuenta.style.backgroundColor = "#F77E8E";
            }
        }
    });
}
function verificaran(an) {
    cadenau = "an=" + an;
    $.ajax({
        type: "POST",
        url: "facturas/verificaran.php",
        data: cadenau,
        success: function (r) {
            if (r == 1) {
                // console.log(r);
                // debugger;
                inputcuenta = document.getElementById("an");
                inputcuenta.style.backgroundColor = "white";
            } else {
                console.log('rojo');
                // debugger;
                inputcuenta = document.getElementById("an");
                inputcuenta.style.backgroundColor = "#F77E8E";
            }
        }
    });
}