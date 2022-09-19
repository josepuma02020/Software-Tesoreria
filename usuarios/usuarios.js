function registrarusuario(nombre, correo, rol, usuario, clave, proceso) {
    cadenau = "nombre=" + nombre + "&correo=" + correo + "&rol=" + rol + "&usuario=" + usuario + "&clave=" + clave + "&proceso=" + proceso;
    $.ajax({
        type: "POST",
        url: "usuarios/registrarusuario.php",
        data: cadenau,
        success: function (r) {
            if (r == 1) {
                //console.log(r);
                //debugger;
            } else {
                // console.log(r);
                //debugger;
            }
        }
    });
}
function datosusuario(id) {
    $.ajax({
        type: "POST",
        data: "id=" + id,
        url: "usuarios/datosusuario.php",
        success: function (r) {
            dato = jQuery.parseJSON(r);
            $('#idu').val(dato['id']);
            $('#nombreu').val(dato['nombre']);
            $('#correou').val(dato['Correo']);
            $('#telefonou').val(dato['telefono']);
            $('#rola').val(dato['Rol']);
            $('#usuariou').val(dato['usuario']);
            $('#ultconexion').val(dato['ultconexion']);
            $('#ultconexion').val(dato['ultconexion']);
            $('#procesoa').val(dato['proceso']);
        }
    });
}
function editarusuario(id, correo, rol, usuario, clave, proceso) {
    cadenau = "nombre=" + nombre + "&proceso=" + proceso + "&correo=" + correo + "&rol=" + rol + "&usuario=" + usuario + "&clave=" + clave + "&id=" + id;
    $.ajax({
        type: "POST",
        url: "usuarios/editarusuario.php",
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