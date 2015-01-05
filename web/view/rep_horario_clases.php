<fieldset>
	<legend><center>Reporte: HORARIO DE CLASES</center></legend>
	<div id="paginador" class="enjoy-css">
		<div class="container">
			<form class="form-horizontal" action="../pdf/pdf_horario_seccion.php"  method="post" id="form1">
				<input type="hidden" id="formato" name="formato" value="horario_completo"/>
				<input type="hidden" id="mensaje" name="mensaje" value="<?php if(isset($_SESSION['mensaje']))echo $_SESSION['mensaje'];else echo 'no_asignado';?>"/>
				<?php
					include_once("../class/class_horario.php");
					$bloque_horas=new horario();
					$turno='todos';
					$get_hora=$bloque_horas->bloque_hora($turno);
					$lapso_actual=$bloque_horas->lapso_actual();      
				?>
				<div class="control-group">
					<label class="control-label" for="seccion">Seleccionar la Sección:</label>
					<div class="controls"> 
						<input type="hidden" id="lapso" name="lapso" value="<?php echo $lapso_actual['codigo_ano_academico'][0];?>" required=""/>
						<?php if(!isset($_GET['horario_completo'])){?>
							<input type="hidden" id="turno" name="turno" value="todos" />
							<select class="selectpicker" data-live-search="true" id="seccion" name="seccion" required >
							<?php 
								include_once("../class/class_html.php");
								$html=new Html();
								$id="seccion";
								$descripcion="nombre_seccion";
								$sql="SELECT seccion,nombre_seccion FROM educacion.tseccion WHERE estatus = '1' ORDER BY seccion";
								$Seleccionado='null';
								$html->Generar_Opciones($sql,$id,$descripcion,$Seleccionado); 
							?>
							</select>
						<?php }?>
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
		if($('#seccion').val()==""){
			alert("¡Debe seleccionar una sección!");
			send=false;
		}

		if(send==true)
			$('#form1').submit();
	})
}
</script>
<?php if(isset($_SESSION['datos'])) unset($_SESSION['datos']);?>
