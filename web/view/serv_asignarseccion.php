<?php
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT pi.codigo_proceso_inscripcion,pi.cedula_persona,CASE WHEN p.primer_nombre IS NOT NULL AND p.segundo_nombre IS NOT NULL AND p.primer_apellido IS NOT NULL AND p.segundo_apellido IS NOT NULL THEN INITCAP(p.primer_nombre||' '||p.segundo_nombre||' '||p.primer_apellido||' '||p.segundo_apellido) 
    WHEN p.primer_nombre IS NOT NULL AND p.segundo_nombre IS NOT NULL AND p.primer_apellido IS NOT NULL AND p.segundo_apellido IS NULL THEN INITCAP(p.primer_nombre||' '||p.segundo_nombre||' '||p.primer_apellido) 
    WHEN p.primer_nombre IS NOT NULL AND p.segundo_nombre IS NULL AND p.primer_apellido IS NOT NULL AND p.segundo_apellido IS NOT NULL THEN INITCAP(p.primer_nombre||' '||p.primer_apellido||' '||p.segundo_apellido) 
    ELSE INITCAP(p.primer_nombre||' '||p.primer_apellido) END AS nombre,date_part('year',age( p.fecha_nacimiento ))||' Años y '||date_part('month',age( p.fecha_nacimiento ))||' Mes(es)' AS edad,pi.indice,pi.peso,pi.talla AS estatura 
    FROM educacion.tproceso_inscripcion pi 
    INNER JOIN general.tpersona p ON pi.cedula_persona = p.cedula_persona 
    WHERE pi.seccion IS NULL 
    ORDER BY pi.indice ASC";
	$consulta = $pgsql->Ejecutar($sql);
?>
<fieldset>
	<legend><center>Vista: ASIGNACIÓN DE SECCIÓN</center></legend>
	<div id="paginador" class="enjoy-css">
		<div class="container">
			<form class="form-horizontal" action="../controllers/control_proceso_inscripcion.php" method="post" id="form1"> 
				<input type="hidden" name="lOpt" value="Asignar_Seccion" id="lOpt" />
				Todos&nbsp;&nbsp;<input onclick=seleccionar_todos(true) type='checkbox' name='todos' id='todos'/> 
					/ Ninguno&nbsp;&nbsp;<input onclick=seleccionar_todos(false) type='checkbox' name='ninguno' id='ninguno'/>
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Seleccione</th>
							<th>Cédula del Estudiante</th>
							<th>Nombre del Estudiante</th>
							<th>Edad del Estudiante</th>
							<th>Peso</th>
							<th>Estatura</th>
							<th>Índice</th>
						</tr>
					</thead>
					<tbody>
					<?php
						while ($filas = $pgsql->Respuesta($consulta))
						{
							echo '<tr>';
							echo "<td><input type='checkbox' name='codigos[]' value='".$filas['codigo_proceso_inscripcion']."'></td>";
				            echo "<td>".$filas['cedula_persona']."</td>";
				            echo "<td>".$filas['nombre']."</td>";
				            echo "<td>".$filas['edad']."</td>";
				            echo "<td>".$filas['peso']."</td>";
				            echo "<td>".$filas['estatura']."</td>";
				            echo "<td>".$filas['indice']."</td>";
							echo "</tr>";
						}
						?>
					<tbody>
				</table>
				<div class="form-actions">
					<button type="submit" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Procesar</button>
				</div> 
			</form>
		</div>
	</div> 
</fieldset>
<script type="text/javascript">
	function seleccionar_todos(param){
		var t=document.getElementsByTagName('input');
		for(i=0;i<t.length;i++){
			if(t[i].type=='checkbox')
				t[i].checked=param; 
		}
		document.getElementById('todos').checked=true;
		if(param==true){
			document.getElementById('todos').checked=true;
			document.getElementById('ninguno').checked=false;
		}else{
			document.getElementById('todos').checked=false;
			document.getElementById('ninguno').checked=true;
		}       	
	}
</script>
<?php
} // Fin Ventana Principal
?>