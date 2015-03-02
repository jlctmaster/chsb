<fieldset>
	<legend><center>Reporte: LISTADO DE ESTUDIANTE SOLVENTES</center></legend>
	<div id="paginador" class="enjoy-css">
		<div class="container">
			<form class="form-horizontal" action="../pdf/pdf_solvencia.php"  method="post" id="form1">
				<div class="control-group">  
	                <label class="control-label">Seleccione un Estudiante:</label>
	                <div class="controls">
	                	<input class="input-xlarge" title="Seleccione un estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="cedula_persona" id="cedula_persona" type="text" required />
					</div>
				</div>
				<div class="form-actions">
					<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Generar Reporte</button>
				</div>
			</form>
		</div>
	</div>
</fieldset>
<script type="text/javascript">
$(document).ready(init);
function init(){
	//Búsquedas del estudiante por autocompletar.
	$('#cedula_persona').autocomplete({
		source:'../autocomplete/estudiante_solvente.php', 
		minLength:1
	});

	$('#btnGuardar').click(function(){
		var send=true;
		if($('#cedula_persona').val()==""){
			alert("¡Debe seleccionar un Estudiante para imprimir la Solvencia!");
			send=false;
		}
		
		if(send==true)
			$('#form1').submit();
	})
}
</script>
<?php if(isset($_SESSION['datos'])) unset($_SESSION['datos']);?>