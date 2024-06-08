file = "#";
function lanzador(CodAlumno) {

}
$(document).ready(function (e) {
	var TipoBusqueda = "";
	var Registro = 0;

	$.post('verificarconexion.php', {}, function (data) {
		let html = '';
		if (data && data.status == true) {
			html = '<div class="badge badge-success"><i class="icon-ok icon-white"></i> ' + CorrectaConexionServidor + '</div>';
		} else {
			html = '<div class="badge badge-important"><i class="icon-exclamation-sign icon-white"></i> ' + ErrorConexionServidor + '</div>';

			$("#overlayer").css({ "height": ($("#contenidoRegistroFactura").height() + 50) + "px" });
		}
		$('#respuestaConexionServidor').html(html);
	}, 'json');

	$.post('../../configuracion/general/sfeconexion.php', {
		'accion': 'obtenerTipoDocumentosIdentidad'
	}, function (data) {
		if (data.status == true) {
			let html = '';
			$.each(data.data, function (index, value) {
				html += '<option value="' + value.siat_code_classifier_identity_document_type + '">' + value.siat_description_identity_document_type + '</option>';
			});
			$("#TipoDocumento").html(html);
		}
	}, 'json');

	$.post('../../configuracion/general/sfeconexion.php', {
		'accion': 'obtenermetodosdepagos'
	}, function (data) {
		console.log(data);
		if (data.status == true) {
			let html = '';
			$.each(data.data, function (index, value) {
				html += '<option value="' + value.siat_code_classifier_payment_method + '">' + value.siat_description_payment_method + '</option>';
			});
			$("#MetodoPago").html(html);
		}
	}, 'json');

	$(".fecha").datepicker({ altField: "#FechaActividad", dateFormat: 'dd-mm-yy' })
	$(document).on("click", ".buscar", function (e) {
		TipoBusqueda = $(this).attr("rel");
		if (TipoBusqueda == "Registro") {
			Registro = $(this).attr("rel-id");
		}
		$('.modal').modal('show');

	}).on("change", "select.MostrarCuota", function () {
		Reg = $(this).attr("rel");

		NumCuota = $("select.MostrarCuota[rel=" + Reg + "]").val();
		CodigoAlumno = $("input.CodigoAlumno[rel=" + Reg + "]").val();
		$.post("sacarmonto.php", { 'CodAlumno': CodAlumno, "NumeroCuota": NumCuota, "Registro": Reg }, function (data) {
			Regis = data.Registro;
			//alert(Regis);
			$("input[name='a[" + Regis + "][MontoCuota]']").val(data.MontoPagar).change();
			$("input[name='a[" + Regis + "][ImporteCobrado]']").val(data.MontoPagar).change();
			$("input[name='a[" + Regis + "][Total]']").val(data.MontoPagar).change();
			$("input[name='a[" + Regis + "][CodCuota]']").val(data.CodCuota);
		}, "json");
	});
	$('.modal').on('hidden', function () {
		$("html,body").css("overflow", "auto")
	}).on('shown', function () {
		//$("html,body").css("overflow","hidden")
	})
	$(document).on("change", ".ImporteCobrado,.Interes,.Descuento", function (e) {
		Reg = $(this).attr("rel");
		Importe = parseFloat($(".ImporteCobrado[rel=" + Reg + "]").val());
		Interes = parseFloat($(".Interes[rel=" + Reg + "]").val());
		Descuento = parseFloat($(".Descuento[rel=" + Reg + "]").val());
		var TotalT = Importe + Interes - Descuento;
		$(".Total[rel=" + Reg + "]").val(TotalT).change();
	});

	$(document).on("change", ".NFactura", function (e) {
		$.post("verificarnumerofactura.php", { 'NFactura': $("input[name=NFactura]").val() }, function (data) {
			if (data.Estado == "Si") {
				//$("#Guardar").removeAttr("disabled");
			} else {
				alert(NFacturaDuplicado);
				$("input[name=NFactura]").focus();
				$("#Guardar").attr("disabled", "disabled");
			}
		}, "json");

	});
	//$("input[name=NFactura]").change();
	$(document).on("change", ".der", function (e) {
		var v = parseFloat($(this).val());
		if (isNaN(v)) {
			v = 0;
		}
		$(this).val(v.toFixed(2));
		sumaInteres = 0;
		$(".Interes").each(function (index, element) {
			sumaInteres += parseFloat($(element).val());
		});
		$(".TotalInteres").val(sumaInteres.toFixed(2))

		sumaDescuento = 0;
		$(".Descuento").each(function (index, element) {
			sumaDescuento += parseFloat($(element).val());
		});
		$(".TotalDescuento").val(sumaDescuento.toFixed(2))
		sumaTotal = 0;
		$(".Total").each(function (index, element) {
			sumaTotal += parseFloat($(element).val());
		});
		$(".TotalBs").val(sumaTotal.toFixed(2));
	});
	$(document).on("focus", ".Cancelado", function (e) {
		$(this).select();
	});
	$(document).on("change", ".Cancelado", function (e) {
		TotalT = parseFloat($(".TotalBs").val());
		Cancelado = parseFloat($(".Cancelado").val());
		MontoDevuelto = Cancelado - TotalT;
		if (MontoDevuelto >= 0 && Cancelado > 0 && TotalT > 0) {
			$("#Guardar").removeAttr("disabled");
		} else {
			$("#Guardar").attr("disabled", "disabled");
		}
		$(".MontoDevuelto").val(MontoDevuelto.toFixed(2));
	});
	$("#cerrar").click(function (e) {
		e.preventDefault();
		$('.modal').modal('hide');
	});
	$("input[name=NumeroDocumento]").on("change", verificarNit);
	$("#MetodoPago").change(cambiarMetodoPago);

	$("#seleccionar").click(function (e) {
		e.preventDefault();
		switch (TipoBusqueda) {
			case "BusquedaNit": {
				$.post("sacarnit.php", { 'CodAlumno': CodAlumno }, function (data) {
					$("input[name=CodAlumno]").val(CodAlumno);
					$("input[name=FacturaAlumno]").val(data.Alumno);
					$("input[name=NumeroDocumento]").val(data.NumeroDocumento);
					$("input[name=NombreFactura]").val(data.FacturaA);
					$("input[name=Email]").val(data.Email);
					verificarNit();

					$('.modal').modal('hide');
					//alert(CodAlumno);
					Registro = 1;
					//alert(Registro);
					TipoBusqueda = "Registro";
					$("#seleccionar").click();
				}, "json");
			} break;
			case "Registro": {
				//alert(Registro);
				$.post("sacarregistro.php", { 'CodAlumno': CodAlumno, "Registro": Registro }, function (data) {
					Regi = data.Registro;
					//alert(Regi);
					$("input[name='a[" + Regi + "][Nombre]']").val(data.Alumno);
					$("input[name='a[" + Regi + "][CodAlumno]']").val(data.CodAlumno);

					$("select[name='a[" + Regi + "][Cuota]']").html('');
					if (data.Cuota == "SinDeuda") {
						$("select[name='a[" + Regi + "][Cuota]']").append('<option value="null">' + data.Cuota + '</option>')
					} else {
						for (i = data.Cuota; i <= 10; i++) {
							$("select[name='a[" + Regi + "][Cuota]']").append('<option value="' + i + '">' + i + '</option>')
						}
						$("select[name='a[" + Regi + "][Cuota]']").append('<option value="2a10">2 - 10</option>')
						$("select[name='a[" + Regi + "][Cuota]']").append('<option value="Todo">Contado 1 - 10</option>')
					}
					$("select[name='a[" + Regi + "][Cuota]']").change();
					$('.modal').modal('hide');
				}, "json");
			} break;
		}
	});
	var l = 0;
	$(document).on("click", ".aumentar", aumentarregistro).on("click", ".eliminar", eliminarregistro);
	aumentarregistro(event);
	function eliminarregistro(e) {
		e.preventDefault();
		if (confirm(MensajeEliminarRegistro)) {
			$(this).parent().parent().remove();
		}
	}
	function aumentarregistro(e) {
		e.preventDefault();
		l++;
		$.post("registro.php", { "l": l }, function (data) {
			$("#senal").before(data);
			$(".der").numeric({ allow: '.' });
		});
	}
	$(document).on("submit", "#formularioSFE", function (e) {
		if (confirm(EstaSeguroRegistrarFactura)) {
		} else {
			e.preventDefault();
		}
	});
	if (CodAlumno != "") {//alert(CodAlumno);
		TipoBusqueda = "BusquedaNit";
		$("#seleccionar").click();
	}
	if (ContarAlumnos > 0) {
		for (numi = 1; numi <= ContarAlumnos; numi++) {
			$(".aumentar").click();

		}
		for (numi = 2; numi <= ContarAlumnos + 1; numi++) {
			//alert(numi-2);
			//alert(CodigosAlumnos[numi-2]);
			CodAlumno = CodigosAlumnos[numi - 2];
			Registro = numi;
			TipoBusqueda = "Registro";
			$("#seleccionar").click();
		}
	}
	// $("#Guardar").click(function (e) {
	// 	e.preventDefault();
	// 	$("#formulario").submit();
	// });
});

function verificarNit() {
	let Nit = $("input[name=NumeroDocumento]").val();
	$.post('../../configuracion/general/sfeconexion.php', {
		'accion': 'verificarNit',
		'Nit': Nit
	}, function (data) {
		if (data.status == true) {
			let html = '';
			if (data.data.response == 'NIT ACTIVO') {
				// Seleccionamos Nit
				$("#TipoDocumento").val(5).change();
			} else {
				// Seleccionamos CI
				$("#TipoDocumento").val(1).change();
			}
		}
	}, 'json');
}

function cambiarMetodoPago() {
	let MetodoPago = $("#MetodoPago > option:checked").html();
	//Si existe el texto tarjeta dentro de la descripción del método de pago
	$("#NumeroTarjetaGrupo").hide();
	$("#MontoGiftCardGrupo").hide();
	if (MetodoPago.toLowerCase().indexOf('tarjeta') > -1) {
		$("#NumeroTarjetaGrupo").show();
	} else if (MetodoPago.toLowerCase().indexOf('gift') > -1) {
		$("#MontoGiftCardGrupo").show();
	} else {

	}
}