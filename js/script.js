// ------------------- Todo lo demas -------------------

var filtro = document.getElementById("filtros_sala");

// Funcion que pide las mesas de cada sala

filtro.addEventListener("change", (e) => {
    showMesas();
})

function showMesas() {
    var sala = filtro.value;

    var jsonData1 = {
        sala: sala,
    };

    var jsonObject1 = JSON.stringify(jsonData1);

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

    xhr.send(jsonObject1);
}


// Funcion que pide la alerta

function openAlert(id, nombre) {
    var jsonData2 = {
        idmesa: id,
        nombremesa: nombre
    };

    var jsonObject2 = JSON.stringify(jsonData2);

    var xhr1 = new XMLHttpRequest();
    var url1 = '../proc/alert.php';

    xhr1.open('POST', url1, true);
    xhr1.setRequestHeader('Content-type', 'application/json');

    xhr1.onreadystatechange = function() {
        if (xhr1.readyState == 4 && xhr1.status == 200) {
            var alerta = xhr1.responseText;
            var divAlerta = document.getElementById('alerta');
            divAlerta.innerHTML = alerta;
            showMesaDisp(id);
        }
    }

    xhr1.send(jsonObject2)
}

// Funcion que pide el select de las mesa de la misma sala
function showMesaDisp(id) {
    var jsonData2 = {
        selector: id,
        sala: filtro.value
    };

    var jsonObject2 = JSON.stringify(jsonData2);

    var xhr1 = new XMLHttpRequest();
    var url1 = '../proc/mesas.php';

    xhr1.open('POST', url1, true);
    xhr1.setRequestHeader('Content-type', 'application/json');

    xhr1.onreadystatechange = function() {
        if (xhr1.readyState == 4 && xhr1.status == 200) {
            var selectMesas = xhr1.responseText;
            var divAlerta = document.getElementById('sillas-plus');
            divAlerta.innerHTML = selectMesas;

            // console.log(selectMesas);

            showSillaDisp()
        }
    }

    xhr1.send(jsonObject2)
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

            var jsonObject2 = JSON.stringify(jsonData2);

            var xhr1 = new XMLHttpRequest();
            var url1 = '../proc/sillas.php';

            xhr1.open('POST', url1, true);
            xhr1.setRequestHeader('Content-type', 'application/json');

            xhr1.onreadystatechange = function() {
                var sillas = document.getElementById("sillas-num");

                sillas.value = 0;
                sillas.setAttribute("max", xhr1.responseText)


            };

            xhr1.send(jsonObject2);
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
        console.log(xhr.responseText);
        closeAlert();
        showMesas();
    };

    xhr.send(jsonObject);
}