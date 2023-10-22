$(document).on("ready",function(){
	mostrar();	
	$(document).on("click",".eliminar",function(e){
		e.preventDefault();
		if(confirm(MensajeEliminar)){
			var CodAnunciosLogin=$(this).attr("rel");
			$.post("eliminar.php",{'CodAnunciosLogin':CodAnunciosLogin},function(data){mostrar();});
		}
	});
	$(document).on("click",".modificar",function(e){
		e.preventDefault();
		if(confirm(MensajeModificar)){
			cargandoG("#configuracion");
			var CodAnunciosLogin=$(this).attr("rel");
			$.post("modificar.php",{'CodAnunciosLogin':CodAnunciosLogin},function(data){$(".configuracion").html(data)});
		}
	});
	$(document).on("click","#nuevo",function(e){
		e.preventDefault();
		cargandoG("#configuracion");
		var CodAnunciosLogin=$(this).attr("rel");
		$.post("nuevo.php",{'CodAnunciosLogin':CodAnunciosLogin},function(data){$(".configuracion").html(data)});
	});
});
function mostrar(){
	cargandoG("#listadocursos");
	$.post("mostrar.php","",function(data){$("#listadocursos").html(data)});	
}