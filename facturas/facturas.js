function codigofuncionario(funcionario) {
    cadenau = "funcionario=" + funcionario;
    $.ajax({
        type: "POST",
        url: "facturas/codigofuncionario.php",
        data: cadenau,
        success: function (r) {
            if (r == 1) {
                // console.log(r);
                // debugger;
                $('#an').val(r);
            } else {
                // console.log(r);
                // debugger;
                $('#an').val(r);
            }
        }
    });
}

function registrarfactura(iddoc, valor, user, tipo, fechafactura, ri, an, cuenta, comentario) {
    cadenau = "valor=" + valor + "&comentario=" + comentario + "&cuenta=" + cuenta + "&iddoc=" + iddoc + "&user=" + user + "&tipo=" + tipo + "&fechafactura=" + fechafactura + "&ri=" + ri + "&an=" + an;
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
function aprobarfactura(iddocumento) {
    cadenau = "iddocumento=" + iddocumento;
    $.ajax({
        type: "POST",
        url: "facturas/aprobarfactura.php",
        data: cadenau,
        success: function (r) {
            // console.log(r);
            // debugger;
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
                //console.log('blanco');
                // debugger;
                inputcuenta = document.getElementById("cuenta");
                inputcuenta.style.backgroundColor = "white";
                $('#valido').val('');
            } else {
                // console.log('rojo');
                // debugger;
                inputcuenta = document.getElementById("cuenta");
                inputcuenta.style.backgroundColor = "#F77E8E";
                $('#valido').val('no');
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
                inputan = document.getElementById("an");
                inputan.style.backgroundColor = "white";
                $('#valido').val('');
            } else {
                // console.log('rojo');
                // debugger;
                inputan = document.getElementById("an");
                inputan.style.backgroundColor = "#F77E8E";
                $('#valido').val('no');
            }
        }
    });
}