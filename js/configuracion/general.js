$(document).on("ready", function () {
	$(".fecha").datepicker({ dateFormat: 'dd-mm-yy', numberOfMonths: 2 });

	revisarSistemaFacturacion();
	$("[name='SistemaFacturacion']").change(revisarSistemaFacturacion);

	$("#SFETestConexion").click(function () {
		let SFEUrl = $("[name=SFEUrl]").val();
		let SFEUsuario = $("[name=SFEUsuario]").val();
		let SFEContrasena = $("[name=SFEContrasena]").val();
		let parametros = {
			"accion": "testconexion",
			"SFEUrl": SFEUrl,
			"SFEUsuario": SFEUsuario,
			"SFEContrasena": SFEContrasena
		};
		console.log(parametros)
		$.post("sfeconexion.php", parametros, function (data) {
			console.log(data);
			if (data.status == false) {
				alert(data.message);
			} else {
				$("[name='SFEToken']").val(data.token);
				$("[name='SFEValidezToken']").val(data.expires_at);
			}

		}, "json");
	});
	obtenerSistemas();
	$("#SFEObtenerSistemas").click(obtenerSistemas);
	sincronizar();
	$("#SFESincronizar").click(sincronizar);
	$("[name=SFECodSucursal]").change(cambioSucursal);
	$("[name=SFEActividades]").change(actualizarProductosSin);
});

function obtenerSistemas() {
	let SFEToken = $("[name=SFEToken]").val();
	if (SFEToken == '') {
		alert("Debe obtener un token primero");
		return;
	}
	let SFEIdSistemaAux = $("[name=SFEIdSistemaAux]").val();
	let parametros = {
		"accion": "obtenersistemas",
		"SFEToken": SFEToken
	};
	// console.log(parametros)
	$.post("sfeconexion.php", parametros, function (data) {
		// console.log(data);
		if (data.status == false) {
			alert(data.message);
		} else {
			// Insert data into select
			let html = "";
			for (let i = 0; i < data.data.length; i++) {
				if (SFEIdSistemaAux == data.data[i].id_siat_system) {
					html += "<option value='" + data.data[i].id_siat_system + "' selected>" + data.data[i].name + "</option>";
				} else {
					html += "<option value='" + data.data[i].id_siat_system + "'>" + data.data[i].name + "</option>";
				}
			}
			$("[name='SFEIdSistema']").html(html);
		}
	}, "json");

}
function sincronizar() {
	let SFEToken = $("[name=SFEToken]").val();
	if (SFEToken == '') {
		alert("Debe obtener un token primero");
		return;
	}
	let SFECodSucursalAux = $("[name=SFECodSucursalAux]").val();
	let parametros = {
		"accion": "obtenersucursales",
		"SFEToken": SFEToken
	};
	// console.log(parametros)
	$.post("sfeconexion.php", parametros, function (data) {
		// console.log(data);
		if (data.status == false) {
			alert(data.message);
		} else {
			// Insert data into select
			let html = "";
			for (let i = 0; i < data.data.length; i++) {
				if (SFECodSucursalAux == data.data[i].siat_number_branch) {
					html += "<option value='" + data.data[i].siat_number_branch + "' selected>" + data.data[i].name + "</option>";
				} else {
					html += "<option value='" + data.data[i].siat_number_branch + "'>" + data.data[i].name + "</option>";
				}
			}
			$("[name='SFECodSucursal']").html(html);
			cambioSucursal();
		}
	}, "json");

}

function cambioSucursal() {
	let SFEToken = $("[name=SFEToken]").val();
	let SFECodSucursal = $("[name=SFECodSucursal] option:checked").val();
	if (SFEToken == '') {
		alert("Debe obtener un token primero");
		return;
	}
	let SFECodPosAux = $("[name=SFECodPosAux]").val();
	let parametros = {
		"accion": "obtenerposes",
		"SFEToken": SFEToken,
		"SFECodSucursal": SFECodSucursal
	};
	// console.log(parametros)
	$.post("sfeconexion.php", parametros, function (data) {
		// console.log(data);
		if (data.status == false) {
			alert(data.message);
		} else {
			// Insert data into select
			let html = "";
			for (let i = 0; i < data.data.length; i++) {
				if (SFECodPosAux == data.data[i].siat_code_pos) {
					html += "<option value='" + data.data[i].siat_code_pos + "' selected>" + data.data[i].siat_name_pos + "</option>";
				} else {
					html += "<option value='" + data.data[i].siat_code_pos + "'>" + data.data[i].siat_name_pos + "</option>";
				}
			}
			$("[name='SFECodPos']").html(html);
		}
	}, "json");
	//obtener metodos de pago
	let SFEMetodoDePagoAux = $("[name=SFECodPosAux]").val();
	parametros = {
		"accion": "obtenermetodosdepagos",
		"SFEToken": SFEToken,
		"SFECodSucursal": SFECodSucursal
	};
	// console.log(parametros)
	$.post("sfeconexion.php", parametros, function (data) {
		// console.log(data);
		if (data.status == false) {
			alert(data.message);
		} else {
			// Insert data into select
			let html = "";
			for (let i = 0; i < data.data.length; i++) {
				if (SFEMetodoDePagoAux == data.data[i].siat_code_classifier_payment_method) {
					html += "<option value='" + data.data[i].siat_code_classifier_payment_method + "' selected>" + data.data[i].siat_description_payment_method + "</option>";
				} else {
					html += "<option value='" + data.data[i].siat_code_classifier_payment_method + "'>" + data.data[i].siat_description_payment_method + "</option>";
				}
			}
			$("[name='SFEMetodoDePago']").html(html);
		}
	}, "json");
	//obtener tipos de moneda
	let SFETipoDeMoneda = $("[name=SFETipoDeMonedaAux]").val();
	parametros = {
		"accion": "obtenertipomonedas",
		"SFEToken": SFEToken,
		"SFECodSucursal": SFECodSucursal
	};
	// console.log(parametros)
	$.post("sfeconexion.php", parametros, function (data) {
		// console.log(data);
		if (data.status == false) {
			alert(data.message);
		} else {
			// Insert data into select
			let html = "";
			for (let i = 0; i < data.data.length; i++) {
				if (SFETipoDeMoneda == data.data[i].siat_code_classifier_currency_type) {
					html += "<option value='" + data.data[i].siat_code_classifier_currency_type + "' selected>" + data.data[i].siat_description_currency_type + "</option>";
				} else {
					html += "<option value='" + data.data[i].siat_code_classifier_currency_type + "'>" + data.data[i].siat_description_currency_type + "</option>";
				}
			}
			$("[name='SFETipoDeMoneda']").html(html);
		}
	}, "json");
	// obtener unidades de medida
	let SFEUnidadMedidaMensualidad = $("[name=SFEUnidadMedidaMensualidadAux]").val();
	parametros = {
		"accion": "obtenerunidadmedidas",
		"SFEToken": SFEToken,
		"SFECodSucursal": SFECodSucursal
	};
	if (SFEUnidadMedidaMensualidad == '') {
		SFEUnidadMedidaMensualidad = '58';
	}
	$.post("sfeconexion.php", parametros, function (data) {
		// console.log(data);
		if (data.status == false) {
			alert(data.message);
		} else {
			// Insert data into select
			let html = "";
			for (let i = 0; i < data.data.length; i++) {
				if (SFEUnidadMedidaMensualidad == data.data[i].siat_code_classifier_measurement_unit) {
					html += "<option value='" + data.data[i].siat_code_classifier_measurement_unit + "' selected>" + data.data[i].siat_description_measurement_unit + "</option>";
				} else {
					html += "<option value='" + data.data[i].siat_code_classifier_measurement_unit + "'>" + data.data[i].siat_description_measurement_unit + "</option>";
				}
			}
			$("[name='SFEUnidadMedidaMensualidad']").html(html);
		}
	}, "json");
	// Obtener actividades economicas
	let SFEActividades = $("[name=SFEActividadesAux]").val();
	parametros = {
		"accion": "obteneractividades",
		"SFEToken": SFEToken,
		"SFECodSucursal": SFECodSucursal
	};
	// console.log({ SFEActividades })
	$.post("sfeconexion.php", parametros, function (data) {
		// console.log(data);
		if (data.status == false) {
			alert(data.message);
		} else {
			// Insert data into select
			let html = "";
			for (let i = 0; i < data.data.length; i++) {
				if (SFEActividades == data.data[i].siat_code_caeb_activity) {
					html += "<option value='" + data.data[i].siat_code_caeb_activity + "' selected>" + data.data[i].siat_description_activity + " - " + data.data[i].siat_type_activity + "</option>";
				} else {
					html += "<option value='" + data.data[i].siat_code_caeb_activity + "'>" + data.data[i].siat_description_activity + " - " + data.data[i].siat_type_activity + "</option>";
				}
			}
			$("[name='SFEActividades']").html(html);
			actualizarProductosSin();
		}
	}, "json");

	// Obtener Código Producto SIN
}
function actualizarProductosSin() {
	let SFECodigoProductoSINAux = $("[name=SFECodigoProductoSINAux]").val();
	let SFECodActividad = $("[name=SFEActividades] option:checked").val();
	let SFECodSucursal = $("[name=SFECodSucursal] option:checked").val();
	let SFEToken = $("[name=SFEToken]").val();

	parametros = {
		"accion": "obtenerProductosSin",
		"SFEToken": SFEToken,
		"SFECodSucursal": SFECodSucursal,
		"SFECodActividad": SFECodActividad
	};
	// console.log({ SFEActividades })
	$.post("sfeconexion.php", parametros, function (data) {
		console.log(data);
		if (data.status == false) {
			alert(data.message);
		} else {
			// Insert data into select
			let html = "";
			for (let i = 0; i < data.data.length; i++) {
				if (SFECodigoProductoSINAux == data.data[i].siat_code_product_service) {
					html += "<option value='" + data.data[i].siat_code_product_service + "' selected>" + data.data[i].siat_description_product_service + "</option>";
				} else {
					html += "<option value='" + data.data[i].siat_code_product_service + "'>" + data.data[i].siat_description_product_service + "</option>";
				}
			}
			$("[name='SFECodigoProductoSIN']").html(html);
		}
	}, "json");
}

function revisarSistemaFacturacion() {
	var sistema = $("[name='SistemaFacturacion'] option:checked").val();
	if (sistema == 'NuevoQR' || sistema == 'Antiguo') {
		$("#CajaSFE").hide();
		$("#CajaNuevoQR").show();
	}
	if (sistema == 'SistemaFacturacionElectronica') {
		$("#CajaNuevoQR").hide();
		$("#CajaSFE").show();
	}
}