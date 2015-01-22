<fieldset>
	<legend><center>Reporte: PRÉSTAMO DE LIBROS</center></legend>
	<div id="paginador" class="enjoy-css">
		<div class="container">
			<form class="form-horizontal" action="../pdf/pdf_prestamo_libros.php"  method="post" id="form1">
				<div class="control-group">  
					<label class="control-label" for="fecha_inicio">Fecha desde</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha desde la cual desea ver los prestamos de libros" name="fecha_inicio" id="fecha_inicio" type="text" readonly required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="fecha_fin">Fecha hasta</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha hasta donde desea ver los prestamos de libros" name="fecha_fin" id="fecha_fin" type="text" readonly required />
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
	$('#btnGuardar').click(function(){
		var send=true;
		if($('#fecha_inicio').val()==""){
			alert("¡Debe ingresar la fecha desde la cual desea ver el inventario!");
			send=false;
		}
		
		if($('#fecha_fin').val()==""){
			alert("¡Debe ingresar la fecha hasta donde desea ver el inventario!");
			send=false;
		}

		if(send==true)
			$('#form1').submit();
	})
}
</script>
<?php if(isset($_SESSION['datos'])) unset($_SESSION['datos']);?>