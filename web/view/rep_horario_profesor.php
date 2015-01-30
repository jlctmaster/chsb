<fieldset>
	<legend><center>Reporte: HORARIO PROFESOR</center></legend>
	<div id="paginador" class="enjoy-css">
		<div class="container">
			<form class="form-horizontal" action="../pdf/pdf_horario_profesor.php"  method="post" id="form1">
				<input type="hidden" id="formato" name="formato" value="<?php if(isset($_GET['pdf'])) echo "pdf"; if(isset($_GET['horario_completo'])) echo "horario_completo";?>" />
				<input type="hidden" id="mensaje" name="mensaje" value="<?php if(isset($_SESSION['mensaje']))echo $_SESSION['mensaje'];else echo 'no_asignado';?>"/>
				<?php
					include_once("../class/class_horario.php");
					$bloque_horas=new horario();
					$turno='todos';
					$get_hora=$bloque_horas->bloque_hora($turno);
					$lapso_actual=$bloque_horas->lapso_actual();      
				?>
				<div class="control-group">  
					<label class="control-label" for="cedula">Cédula Profesor:</label>  
					<div class="controls">  
						<input type="hidden" id="lapso" name="lapso" value="<?php echo $lapso_actual['codigo_ano_academico'][0];?>" required=""/>
						<?php if(!isset($_GET['horario_completo'])){?>
							<input type="hidden" id="turno" name="turno" value="todos" />
							<input class="input-xlarge" type="text" id="cedula" name="cedula" onKeyUp="this.value=this.value.toUpperCase()" title="Seleccione un profesor" required />
						<?php }?>
					</div>  
				</div>
				<div class="form-actions">
					<button type="submit" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Generar Reporte</button>
				</div>
			</form>
		</div>
	</div>
</fieldset>
<script type="text/javascript">
$(document).ready(init);
function init(){
	//Búsquedas del profesor por autocompletar.
	$('#cedula').autocomplete({
		source:'../autocomplete/profesor.php', 
		minLength:1,
		select: function (event, ui){
			Datos={"lOpt":"BuscarDatosPersona","filtro":ui.item.value};
			BuscarDatosPersona(Datos);
		}
	});

	//Busca los Datos del Profesor seleccionado.
    function BuscarDatosPersona(value){
        $.ajax({
        url: '../controllers/control_persona.php',
        type: 'POST',
        async: true,
        data: value,
        dataType: "json",
        success: function(resp){
        	$('#cedula').val(resp[0].cedula_persona);
        },
        error: function(jqXHR, textStatus, errorThrown){
        	alert('¡Error al procesar la petición! '+textStatus+" "+errorThrown)
        }
        });
    }	
}
</script>
<?php 
	if(isset($_SESSION['datos'])) 
		unset($_SESSION['datos']);
?>
