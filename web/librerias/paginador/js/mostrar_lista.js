function mostrar(){
	$.post("consulta.php", function(data){ 
		$("#contenido").html(data) 
	});
}

$(document).ready(function(){
	mostrar();
});