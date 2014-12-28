<?php
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT u.nombre_usuario,u.cedula_persona,CASE WHEN p.primer_nombre IS NOT NULL AND p.segundo_nombre IS NOT NULL AND p.primer_apellido IS NOT NULL AND p.segundo_apellido IS NOT NULL THEN INITCAP(p.primer_nombre||' '||p.segundo_nombre||' '||p.primer_apellido||' '||p.segundo_apellido) 
    WHEN p.primer_nombre IS NOT NULL AND p.segundo_nombre IS NOT NULL AND p.primer_apellido IS NOT NULL AND p.segundo_apellido IS NULL THEN INITCAP(p.primer_nombre||' '||p.segundo_nombre||' '||p.primer_apellido) 
    WHEN p.primer_nombre IS NOT NULL AND p.segundo_nombre IS NULL AND p.primer_apellido IS NOT NULL AND p.segundo_apellido IS NOT NULL THEN INITCAP(p.primer_nombre||' '||p.primer_apellido||' '||p.segundo_apellido) 
    ELSE INITCAP(p.primer_nombre||' '||p.primer_apellido) END AS nombre,c.fecha_modificacion,u.intentos_fallidos 
    FROM seguridad.tusuario u 
    INNER JOIN general.tpersona p ON u.cedula_persona = p.cedula_persona 
    INNER JOIN seguridad.tcontrasena c ON u.nombre_usuario = c.nombre_usuario 
    WHERE c.estado = 4 
    ORDER BY c.fecha_modificacion ASC";
	$consulta = $pgsql->Ejecutar($sql);
?>
<fieldset>
	<legend><center>Vista: DESBLOQUEAR USUARIO</center></legend>
	<div id="paginador" class="enjoy-css">
		<div class="container">
			<form class="form-horizontal" action="../controllers/control_desbloquearusuario.php" method="post" id="form1"> 
				<input type="hidden" name="lOpt" value="DesbloquearUsuario" id="lOpt" />
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Seleccione</th>
							<th>Nombre de Usuario</th>
							<th>Cédula</th>
							<th>Nombres y Apellidos</th>
							<th>Fecha de Bloqueo</th>
							<th>Intentos Realizados</th>
						</tr>
					</thead>
					<tbody>
					<?php
						while ($filas = $pgsql->Respuesta($consulta))
						{
							echo '<tr>';
							echo "<td><input type='checkbox' name='bloqueados[]' value='".$filas['nombre_usuario']."'></td>";
				            echo "<td>".$filas['nombre_usuario']."</td>";
				            echo "<td>".$filas['cedula_persona']."</td>";
				            echo "<td>".$filas['nombre']."</td>";
				            echo "<td>".$filas['fecha_modificacion']."</td>";
				            echo "<td>".$filas['intentos_fallidos']."</td>";
							echo "</tr>";
						}
						?>
					<tbody>
				</table>
				<div class="form-actions">
					<button type="submit" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Desbloquear Usuarios</button>
				</div> 
			</form>
		</div>
	</div> 
</fieldset>  
<?php
} // Fin Ventana Principal
?>