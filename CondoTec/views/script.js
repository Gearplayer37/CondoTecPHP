document.getElementById('btnVisualizarBoletos').addEventListener('click', function() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'obter_boletos.php', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var boletos = JSON.parse(xhr.responseText);
            exibirBoletos(boletos);
        }
    };
    xhr.send();
});

function exibirBoletos(boletos) {
    var listaBoletos = document.getElementById('listaBoletos');
    listaBoletos.innerHTML = ''; // Limpa o conteúdo anterior
    for (var i = 0; i < boletos.length; i++) {
        var boleto = boletos[i];
        listaBoletos.innerHTML += '<p>' + boleto.nome_pagador + ' - R$ ' + boleto.valor + ' - ' + boleto.status + '</p>';
    }
}
