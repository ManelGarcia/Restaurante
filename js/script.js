// ------------------- Todo lo demas -------------------

var filtro = document.getElementById("filtros_sala");

// Funcion que pide las mesas de cada sala

filtro.addEventListener("change", (e) => {
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
})


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
            var alerta = xhr1.responseText;
            var divAlerta = document.getElementById('sillas-plus');
            divAlerta.innerHTML = alerta;
            // showMesaDisp();
        }
    }

    xhr1.send(jsonObject2)
}


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
                var sillas = document.getElementById("sillas-plus" + smesa);

                console.log(xhr1.responseText);

                if (xhr1.responseText == 0) {
                    sillas.innerHTML = '0';
                } else {
                    sillas.innerHTML = xhr1.responseText;
                }

            };

            xhr1.send(jsonObject2);
        }
    });

}


function closeAlert(id) {
    document.getElementById('alerta').innerHTML = null;
}

function reservar(id_mesa) {

}