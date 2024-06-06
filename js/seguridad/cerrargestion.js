$(document).ready(function (e) {
    $("#respuesta").ajaxStart(function () {
        $("#resultadosubida").html('');
        $("#imagencargador").show("fast");
    });
    $("#cerrargestion").click(function (e) {
        if (confirm(SeguroCerrarGestion)) {
            $.post("cerrar.php", function (data) {
                $("#imagencargador").hide("fast");
                $("#resultadocierre").html("" + data + "");

            });
        }
        e.preventDefault();
        e.stopPropagation();
        return false;
    });
});