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