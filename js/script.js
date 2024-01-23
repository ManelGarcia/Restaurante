// ------------------- Todo lo demas -------------------

window.onload = function() {
    mesas();
}

function mesas() {
    var xhr = new XMLHttpRequest();
    var url = '../view/mesas_sel.php';

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/json');

    xhr.onreadystatechange = function() {
        var body = document.getElementById('body')
        body.innerHTML = xhr.responseText

        awawa();
    };

    xhr.send();
}

function awawa() {
    var filtro = document.getElementById("filtros_sala");

    filtro.addEventListener("change", (e) => {
        showMesas();
    })
}

// Funcion que pide las mesas de cada sala
function showMesas() {
    var sala = document.getElementById("filtros_sala").value;

    var jsonData1 = {
        sala: sala,
    };

    var jsonObject = JSON.stringify(jsonData1);

    var xhr = new XMLHttpRequest();
    var url = '../proc/mesas.php';

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/json');

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var mesas = document.getElementById("mesas-div");
            mesas.innerHTML = xhr.responseText
        }
    };

    xhr.send(jsonObject);
}


// Funcion que pide la alerta

function openAlert(id, nombre) {
    var jsonData2 = {
        idmesa: id,
        nombremesa: nombre
    };

    var jsonObject = JSON.stringify(jsonData2);

    var xhr = new XMLHttpRequest();
    var url1 = '../proc/alert.php';

    xhr.open('POST', url1, true);
    xhr.setRequestHeader('Content-type', 'application/json');

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var alerta = xhr.responseText;
            var divAlerta = document.getElementById('alerta');
            divAlerta.innerHTML = alerta;
            showMesaDisp(id);
        }
    }

    xhr.send(jsonObject)
}

// Funcion que pide el select de las mesa de la misma sala
function showMesaDisp(id) {
    var jsonData2 = {
        selector: id,
        sala: document.getElementById("filtros_sala").value
    };

    var jsonObject = JSON.stringify(jsonData2);

    var xhr = new XMLHttpRequest();
    var url1 = '../proc/mesas.php';

    xhr.open('POST', url1, true);
    xhr.setRequestHeader('Content-type', 'application/json');

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var selectMesas = xhr.responseText;
            console.log(xhr.responseText)
            var divAlerta = document.getElementById('sillas-plus');
            divAlerta.innerHTML = selectMesas;

            // console.log(selectMesas);

            showSillaDisp()
        }
    }

    xhr.send(jsonObject)
}

// Funcion que pide el numero de sillas en la mesa del select anterior
function showSillaDisp() {
    var selectMesa = document.getElementById('select-mesa');

    selectMesa.addEventListener("change", function(e) {

        var smesa = selectMesa.value;

        if (smesa != null) {
            var jsonData2 = {
                smesa: smesa,
            };

            var jsonObject = JSON.stringify(jsonData2);

            var xhr = new XMLHttpRequest();
            var url1 = '../proc/sillas.php';

            xhr.open('POST', url1, true);
            xhr.setRequestHeader('Content-type', 'application/json');

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var sillas = document.getElementById("sillas-num");

                    sillas.value = 0;
                    sillas.setAttribute("max", xhr.responseText)
                }

            };

            xhr.send(jsonObject);
        }
    });

}


function closeAlert() {
    document.getElementById('alerta').innerHTML = null;
}

function ocupar(id_mesa) {
    var mesaPlus = document.getElementById('select-mesa').value;
    var sillaPlus = document.getElementById('sillas-num').value;

    // console.log('Id mesa: ' + id_mesa);
    // console.log('Id otra: ' + mesaPlus);
    // console.log('N sillas otra: ' + sillaPlus);

    var jsonData = {
        id_mesa: id_mesa,
        mesaPlus: mesaPlus,
        sillaPlus: sillaPlus,
        accion: 'ocupar',
    };

    cambiarEstado(jsonData)
}

function reservar(id_mesa) {
    var fechaIni = document.getElementById('fecha-ini').value;
    var horaIni = document.getElementById('hora-ini').value;
    var mesaPlus = document.getElementById('select-mesa').value;
    var sillaPlus = document.getElementById('sillas-num').value;

    // console.log('Id mesa: ' + id_mesa);
    // console.log('Fecha inicio: ' + fechaIni);
    // console.log('Hora inicio: ' + horaIni);
    // console.log('Id otra: ' + mesaPlus);
    // console.log('N sillas otra: ' + sillaPlus);

    var jsonData = {
        id_mesa: id_mesa,
        fechaIni: fechaIni,
        horaIni: horaIni,
        mesaPlus: mesaPlus,
        sillaPlus: sillaPlus,
        accion: 'reservar',
    };

    cambiarEstado(jsonData)
}

function cambiarEstado(jsonData) {
    var jsonObject = JSON.stringify(jsonData);

    var xhr = new XMLHttpRequest();
    var url = '../proc/reserva-ocupacion.php';

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/json');

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {

            console.log(xhr.responseText);
            closeAlert();
            showMesas();
        }
    };

    xhr.send(jsonObject);
}

function ClickCrud() {
    crudUS()
    sqlFiltro()
}

function crudUS() {
    var xhr = new XMLHttpRequest();
    var url = '../view/CRUD.php';

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/json');

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('body').innerHTML = xhr.responseText;
            text();
        }
    };

    xhr.send();
}

function text() {
    var busqueda = document.getElementById('busqueda');
    busqueda.removeEventListener("keyup", handleBusqueda);
    busqueda.addEventListener("keyup", handleBusqueda);
}

function handleBusqueda(e) {
    sqlFiltro(e.target.value);
}

function sqlFiltro(busqueda) {
    if (typeof busqueda !== 'undefined') {
        var jsonData2 = {
            busqueda: busqueda,
        };

        var jsonObject = JSON.stringify(jsonData2);
    }

    var xhr = new XMLHttpRequest();
    var url1 = '../view/usuarios.php';

    xhr.open('POST', url1, true);
    xhr.setRequestHeader('Content-type', 'application/json');

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('crud').innerHTML = xhr.responseText
            text();
        }
    };

    if (typeof busqueda !== 'undefined') {
        xhr.send(jsonObject);
    } else {
        xhr.send();
    }

}

function ClickCrudM() {
    crudMa()
    sqlFiltroMa()
}

function crudMa() {
    var xhr = new XMLHttpRequest();
    var url = '../view/CRUD_M.php';

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/json');

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('body').innerHTML = xhr.responseText;
            sqlFiltroMa();
        }
    };

    xhr.send();
}

function sqlFiltroMa(busqueda) {
    if (typeof busqueda !== 'undefined') {
        var jsonData2 = {
            busqueda: busqueda,
        };

        var jsonObject = JSON.stringify(jsonData2);
    }

    var xhr = new XMLHttpRequest();
    var url1 = '../view/materiales.php';

    xhr.open('POST', url1, true);
    xhr.setRequestHeader('Content-type', 'application/json');

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('crud').innerHTML = xhr.responseText
            document.getElementById('header').style.visibility = 'hidden';

        }
    };

    if (typeof busqueda !== 'undefined') {
        xhr.send(jsonObject);
    } else {
        xhr.send();
    }

}

function estad() {
    var xhr = new XMLHttpRequest();
    var url = '../view/estadisticas.php';

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/json');

    xhr.onreadystatechange = function() {
        var body = document.getElementById('body')
        body.innerHTML = xhr.responseText
    };

    xhr.send();
}

function hist() {
    var xhr = new XMLHttpRequest();
    var url = '../view/historial.php';

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/json');

    xhr.onreadystatechange = function() {
        var body = document.getElementById('body')
        body.innerHTML = xhr.responseText
    };

    xhr.send();
}