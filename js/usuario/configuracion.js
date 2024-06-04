$(document).on("ready", function () {
	$("#Usuario").alpha({ 'allow': '' });
	$("#contrasenaigual,#contrasenanoigual").hide();
	var fortaleza = 0;
	$("#Pass").keyup(function (event) {
		var password = $('#Pass').val();
		fortaleza = checkPasswordStrength(password);
	});

	$("#Pass,#PassRepetir").keyup(function () {
		var Pass = $("#Pass").val();
		var PassRepetir = $("#PassRepetir").val();
		if (Pass == PassRepetir && fortaleza >= 4) {
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