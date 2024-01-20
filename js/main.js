// ------------------- Validacion del formulario -------------------

function validarForm() {
    // Obtener el valor del campo username
    var username = document.getElementById("username");
    var usernameValue = username.value.trim(); //eliminamos espacios al principio y al final de la cadena
    var usernameError = document.getElementById("usernameError"); // Elemento para mostrar mensajes de error
    // Variable para almacenar si el campo username es válido
    var usernameValido = true;
    // Validar que no este vació
    if (usernameValue === "" || usernameValue === null) {
        // Si está vacío, mostrar mensaje de error y cambiar el borde a rojo
        usernameError.textContent = "Este campo es obligatorio";
        username.style.border = '2px solid red';
        usernameValido = false;
    } else {
        // Si es válido, borrar el mensaje de error y restablecer el borde
        usernameError.textContent = "";
        username.style.border = ''; // Restablecer el borde a su estado original si es válido

        // Verificar que el formato sea nombre_apellido
        var formatoUsername = /^[a-z]+_[a-z]+$/.test(usernameValue);
        //sino es el formato correcto saldra mensaje de error
        if (!formatoUsername) {
            usernameError.textContent = "Formato incorrecto";
            username.style.border = '2px solid red';
            usernameValido = false;
        }
    }
    //cojemos id del campo password del formulario
    var passwd = document.getElementById("password");
    var passwdValue = passwd.value.trim(); //comvertimos en valor quitando los espacios de princiipio y final
    var passwdError = document.getElementById("passwordError"); //obtener id del span de error donde mostraremos info
    // Variable para almacenar si el campo password es válido
    var passwordValido = true;
    //verificamos si el campo password esta vacío o no
    if (passwdValue === "" || passwdValue === null) {
        // Si está vacío, mostrar mensaje de error y cambiar el borde a rojo
        passwdError.textContent = "Este campo es obligatorio";
        passwd.style.border = '2px solid red';
        // Actualizar la variable a falso
        passwordValido = false;
    } else {
        // Si es válido, borrar el mensaje de error y restablecer el borde
        passwdError.textContent = "";
        passwd.style.border = ''; // Restablecer el borde a su estado original si es válido
        if (passwdValue.length < 9) {
            passwdError.textContent = "Formato incorrecto";
            passwd.style.border = '2px solid red';
            passwordValido = false;
        }
    }

    // Comprobar ambas variables antes de decidir si permitir o no el envío del formulario
    if (usernameValido && passwordValido) {
        // Ambos campos son válidos, permitir el envío del formulario
        return true;
    } else {
        // Al menos uno de los campos no es válido, evitar que se envíe el formulario
        return false;
    }


}

function validarReserva() {
    var sillas = document.getElementById('n-sillas').value;
    if (NaN(sillas)) {

    } else {

    }
}