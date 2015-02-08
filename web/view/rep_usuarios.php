<fieldset>
	<legend><center>Reporte: USUARIO</center></legend>
	<div id="paginador" class="enjoy-css">
		<div class="container">
			<form class="form-horizontal" action="../pdf/pdf_usuario.php"  method="post" id="form1">
				<div class="control-group">  
					<label class="control-label" for="codigo_perfil">Perfil:</label>  
					<div class="controls">  
						<select class="selectpicker" data-live-search="true" title="Seleccione un Perfil" name='codigo_perfil' id='codigo_perfil' required >
							<?php 
							include_once("../class/class_html.php");
							$html=new Html();
							$id="codigo_perfil";
							$descripcion="nombre_perfil";
							$sql="SELECT * FROM seguridad.tperfil WHERE estatus = '1'";
							$Seleccionado='null';
							$html->Generar_Opciones($sql,$id,$descripcion,$Seleccionado); 
							?>
						</select>
					</div>
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
			alert("¡Debe ingresar la fecha desde la cual desea ver los usuarios!");
			send=false;
		}
		
		if($('#fecha_fin').val()==""){
			alert("¡Debe ingresar la fecha hasta donde desea ver los usuarios!");
			send=false;
		}

		if(send==true)
			$('#form1').submit();
	})
}
</script>
<?php if(isset($_SESSION['datos'])) unset($_SESSION['datos']);?>