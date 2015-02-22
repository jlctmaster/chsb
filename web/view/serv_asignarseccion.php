<?php
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT pi.codigo_proceso_inscripcion,pi.cedula_persona,CASE WHEN p.primer_nombre IS NOT NULL AND p.segundo_nombre IS NOT NULL AND p.primer_apellido IS NOT NULL AND p.segundo_apellido IS NOT NULL THEN INITCAP(p.primer_nombre||' '||p.segundo_nombre||' '||p.primer_apellido||' '||p.segundo_apellido) 
    WHEN p.primer_nombre IS NOT NULL AND p.segundo_nombre IS NOT NULL AND p.primer_apellido IS NOT NULL AND p.segundo_apellido IS NULL THEN INITCAP(p.primer_nombre||' '||p.segundo_nombre||' '||p.primer_apellido) 
    WHEN p.primer_nombre IS NOT NULL AND p.segundo_nombre IS NULL AND p.primer_apellido IS NOT NULL AND p.segundo_apellido IS NOT NULL THEN INITCAP(p.primer_nombre||' '||p.primer_apellido||' '||p.segundo_apellido) 
    ELSE INITCAP(p.primer_nombre||' '||p.primer_apellido) END AS nombre, date_part('year',age( p.fecha_nacimiento )) AS edad,pi.indice,pi.peso,pi.talla AS estatura 
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
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Seleccione</th>
							<th>Cédula del Estudiante</th>
							<th>Nombre del Estudiante</th>
							<th>Edad</th>
							<th>Índice</th>
							<th>Peso</th>
							<th>Estatura</th>
						</tr>
					</thead>
					<tbody>
					<?php
						while ($filas = $pgsql->Respuesta($consulta))
						{
							echo '<tr>';
							echo "<td><input type='checkbox' name='codigos[]' value='".$filas['codigo_proceso_inscripcion']."'>
								<input type='hidden' name='cedulas[]' value='".$filas['cedula_persona']."'>
							</td>";
				            echo "<td>".$filas['cedula_persona']."</td>";
				            echo "<td>".$filas['nombre']."</td>";
				            echo "<td>".$filas['edad']."</td>";
				            echo "<td>".$filas['indice']."</td>";
				            echo "<td>".$filas['peso']."</td>";
				            echo "<td>".$filas['estatura']."</td>";
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
<?php
} // Fin Ventana Principal
?>