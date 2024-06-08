$(document).on("ready", function (e) {
    buscadorLista("", $("#CodigoEventoSignificativo"));
    listadoEventos();
    $("#fecha").datepicker({ altField: "#FechaActividad", dateFormat: 'dd-mm-yy', maxDate: '+0D' });
    $("#buscar").click(function (e) {
        $("#listadoEventosSignificativos").html(MensajeCargando + '...<img src="' + folder + '/imagenes/cargador/cargador.gif">');
        listadoEventos();
    });
    $(document).on("click", ".enviarPaquete,.finalizarEvento,.cancelarEvento", function (e) {
        e.preventDefault();
        let url = $(this).attr("href");
        let row = $(this).attr("data-row");
        $.get(url, {}, function (data) {
            console.log(data);
            var html = '';
            if (data.estado == 'correcto') {
                html = '<div class="alert alert-success">' + data.mensaje + '</div>';
            } else {
                html = '<div class="alert alert-danger">' + data.mensaje + '</div>';
            }
            $(".response_row_" + row).html(html);
        }, "json");
    })
});

function listadoEventos() {
    fechaEvento = $("#fecha").val();
    $.post("mostrar.php", { fechaEvento }, function (data) {
        $("#listadoEventosSignificativos").html(data);
    });
}