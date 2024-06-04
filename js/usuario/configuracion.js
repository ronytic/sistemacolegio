$(document).on("ready", function () {
	$("#Usuario").alpha({ 'allow': '' });
	//$("input").mousedown(function(e){$(this).select();}).mouseup(function(e){e.preventDefault();});
	$("#contrasenaigual,#contrasenanoigual").hide();
	$("#Pass,#PassRepetir").keyup(function () {
		var Pass = $("#Pass").val();
		var PassRepetir = $("#PassRepetir").val();
		if (Pass == PassRepetir) {
			$("#contrasenaigual").show();
			$("#contrasenanoigual").hide();
			$("#botonSubmit").removeAttr("disabled");
		} else {
			$("#contrasenaigual").hide();
			$("#contrasenanoigual").show();
			$("#botonSubmit").attr("disabled", "disabled");
		}
	});

	$("#datos").submit(function (e) {
		var Pass = $("#Pass").val();
		var PassRepetir = $("#PassRepetir").val();
		if (Pass != PassRepetir) {
			alert(ContrasenaNoIgual);
			e.preventDefault();
		} else {
			//$(this).submit();
		}
	});
});