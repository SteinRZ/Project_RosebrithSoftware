document.getElementById('id_cliente').addEventListener('change', function() {
    var selectedClientId = this.value;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('apellido_materno').value = this.responseText;
        }
    };
    xhttp.open('GET', '../php/get_client_secondlastname.php?id=' + selectedClientId, true);
    xhttp.send();
});