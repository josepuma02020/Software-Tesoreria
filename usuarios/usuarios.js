function registrarusuario(nombre, correo, rol, usuario, clave, proceso, nconfiguracion, nautorizacion, naprobacion, nverificacion, ncreacion) {
    cadenau = "nombre=" + nombre + "&correo=" + correo + "&rol=" + rol + "&usuario=" + usuario + "&clave=" + clave + "&proceso=" + proceso + "&nconfiguracion=" + nconfiguracion + "&nautorizacion=" + nautorizacion + "&naprobacion=" + naprobacion + "&nverificacion=" + nverificacion + "&ncreacion=" + ncreacion;
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
            $('#usuariou').val(dato['usuario']);
            $('#ultconexion').val(dato['ultconexion']);
            $('#ultconexion').val(dato['ultconexion']);
            $('#procesoa').val(dato['proceso']);
            if (dato['creacion'] == 1) {
                $('#pcreacion').prop('checked', true);
            } else {
                $('#pcreacion').prop('checked', false);
            }
            if (dato['verificacion'] == 1) {
                $('#pverificacion').prop('checked', true);
            } else {
                $('#pverificacion').prop('checked', false);
            }
            if (dato['aprobacion'] == 1) {
                $('#paprobacion').prop('checked', true);
            } else {
                $('#paprobacion').prop('checked', false);
            }
            if (dato['autorizacion'] == 1) {
                $('#pautorizacion').prop('checked', true);
            } else {
                $('#pautorizacion').prop('checked', false);
            }
            if (dato['configuracion'] == 1) {
                $('#pconfiguracion').prop('checked', true);
            } else {
                $('#pconfiguracion').prop('checked', false);
            }
        }
    });
}
function editarusuario(id, correo, rol, usuario, clave, proceso, pcreacion, pverificacion, paprobacion, pautorizacion, pconfiguracion) {
    cadenau = "nombre=" + nombre + "&proceso=" + proceso + "&correo=" + correo + "&rol=" + rol + "&usuario=" + usuario + "&clave=" + clave + "&id=" + id + "&pcreacion=" + pcreacion + "&pverificacion=" + pverificacion + "&paprobacion=" + paprobacion + "&pautorizacion=" + pautorizacion + "&pconfiguracion=" + pconfiguracion;
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