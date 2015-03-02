<script type="text/javascript" src="js/chsb_reconstruccion.js"></script>
<?php
require_once("../class/class_perfil.php");
require_once('../class/class_bd.php');
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('reconstruccion');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	$pgsql=new Conexion();
	$sql = "SELECT r.codigo_recuperacion,TO_CHAR(fecha,'DD/MM/YYYY') AS fecha,
	p.primer_nombre||' '||p.primer_apellido AS responsable,b.nro_serial||' '||b.nombre AS item 
	FROM bienes_nacionales.trecuperacion r 
	INNER JOIN general.tpersona p ON r.cedula_persona = p.cedula_persona 
	INNER JOIN bienes_nacionales.tbien b ON r.codigo_bien = b.codigo_bien 
	WHERE r.esrecuperacion='N'";
	$consulta = $pgsql->Ejecutar($sql);
	?>
	<fieldset>
		<legend><center>Vista: RECONSTRUCCIÓN</center></legend>		
		<div id="paginador" class="enjoy-css"> 
			<div class="container">
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Código:</th>
							<th>Fecha:</th>
							<th>Responsable:</th>
							<th>Item:</th>
							<?php
							for($x=0;$x<count($a);$x++){
								if($a[$x]['orden']=='2' || $a[$x]['orden']=='5')
									echo '<th>'.$a[$x]['nombre_opcion'].'</th>';
							}
							?>
						</tr>
					</thead>
					<tbody>
						<?php
						while ($filas = $pgsql->Respuesta($consulta))
						{
							echo '<tr>';
							echo '<td>'.$filas['codigo_recuperacion'].'</td>';
							echo '<td>'.$filas['fecha'].'</td>';
							echo '<td>'.$filas['responsable'].'</td>';
							echo '<td>'.$filas['item'].'</td>';
							for($x=0;$x<count($a);$x++){
						if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
						echo '<td><a href="?reconstruccion&Opt=3&codigo_reconstruccion='.$filas['codigo_recuperacion'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
						else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
						echo '<td><a href="?reconstruccion&Opt=4&codigo_reconstruccion='.$filas['codigo_recuperacion'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
					}
					echo "</tr>";
				}
				?>
				<tbody>
				</table>
				<center>
					<?php
					for($x=0;$x<count($a);$x++)
						if($a[$x]['orden']=='1')
							echo '<a href="?reconstruccion&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
						?>
						<button type="button" id="btnImprimirTodos" class="btn btn-large btn-primary"><i class="icon-download-alt"></i>&nbsp;Descargar Archivo</button>
					</center>

					<div id="Imprimir" style="display:none;">
						<span>Descargar Como:</span>
						<br/><br/>
						<a href="<?php echo  '../pdf/pdf_reconstruccion.php';?>" target="_blank"> <img src="images/icon-pdf.png" alt="Exportar a PDF" style="width:60px;heigth:60px;float:center;"> </a>
						&nbsp;&nbsp;
						<a href="../excel/excel_reconstruccion.php" ><img src="images/icon-excel.png" alt="Exportar a Excel" style="width:60px;heigth:60px;float:center;"></a>
				    </div>


				</div>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana Principal
else if($_GET['Opt']=="2"){ // Ventana de Registro
	?>
	<form class="form-horizontal" action="../controllers/control_reconstruccion.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: RECONSTRUCCIÓN</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_reconstruccion">Código</label>  
					<div class="controls">  
						<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
						<input class="input-xlarge" title="el Código del reconstruccion es generado por el sistema" name="codigo_reconstruccion" id="codigo_reconstruccion" type="text" readonly /> 
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="fecha">Fecha</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha de reconstrucción del bien nacional" name="fecha" id="fecha" type="text" readonly required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="cedula_persona">Responsable</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Seleccione un responsable" onKeyUp="this.value=this.value.toUpperCase()" name="cedula_persona" id="cedula_persona" type="text" required />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="codigo_ubicacion">Ubicación Destino</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Seleccione una ubicación" onKeyUp="this.value=this.value.toUpperCase()" name="codigo_ubicacion" id="codigo_ubicacion" type="text" required /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="codigo_bien">Bien Nacional a Recuperar</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Seleccione un Item a Recuperar" onKeyUp="this.value=this.value.toUpperCase()" name="codigo_bien" id="codigo_bien" type="text" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="cantidad">Cantidad a Recuperar</label>  
					<div class="controls"> 
						<input type="hidden" name="cantidad_max" id="cantidad_max" >
						<input class="input-xlarge" type="text" title="Cantidad disponible a recuperar" onKeyPress="return isNumberKey(event)" name="cantidad_a_recuperar" id="cantidad" required >
					</div>  
				</div>
				<div class="table-responsive">
					<table id='tablaDetReconstruccion' class="table-bordered zebra-striped">
						<tr>
							<td><label class="control-label" >Ubicación</label></td>
							<td><label class="control-label" >Item</label></td>
							<td><label class="control-label" >Cantidad</label></td>
						</tr>
					</table>
				</div>
				<div class="control-group">  
					<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
				</div>  
				<div class="form-actions">
					<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
					<a href="?reconstruccion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div> 
			</div>  
		</fieldset>  
	</form>
	<?php
	if(isset($_SESSION['datos']['procesado']) && $_SESSION['datos']['procesado']=="Y"){
		echo '<script language="javascript">
		setTimeout(function(){
			noty({
		        text: stringUnicode("¿Desea ver el Formato de Impresión?"),
		        layout: "center",
		        type: "confirm",
		        dismissQueue: true,
		        animateOpen: {"height": "toggle"},
		        animateClose: {"height": "toggle"},
		        theme: "defaultTheme",
		        closeButton: false,
		        closeOnSelfClick: true,
		        closeOnSelfOver: false,
		        buttons: [
		        {
		            addClass: "btn btn-primary", text: "Sí", onClick: function($noty){
		                $noty.close();
						url = "../pdf/pdf_formato_reconstruccion.php?p1='.$_SESSION['datos']['codigo_reconstruccion'].'";
						window.open(url, "_blank");
		            }
		        },
		        {
		            addClass: "btn btn-danger", text: "No", onClick: function($noty){
		                $noty.close();
		            }
		        }
		        ]
		    });
		},1000);
			</script>';
	}
} // Ventana de Registro
else if($_GET['Opt']=="3"){ // Ventana de Modificaciones
	$pgsql=new Conexion();
	$sql = "SELECT r.*,TO_CHAR(r.fecha,'DD/MM/YYYY') as fecha, 
	r.cedula_persona||'_'||p.primer_nombre||' '||p.primer_apellido AS responsable,
	r.codigo_ubicacion||'_'||u.descripcion AS ubicacion,
	r.codigo_bien||'_'||b.nro_serial||' - '||b.nombre AS item 
	FROM bienes_nacionales.trecuperacion r 
	INNER JOIN general.tpersona p ON r.cedula_persona = p.cedula_persona 
	INNER JOIN inventario.tubicacion u ON r.codigo_ubicacion = u.codigo_ubicacion 
	INNER JOIN bienes_nacionales.tbien b ON r.codigo_bien = b.codigo_bien 
	WHERE r.esrecuperacion='N' AND r.codigo_recuperacion=".$pgsql->comillas_inteligentes($_GET['codigo_reconstruccion']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<form class="form-horizontal" action="../controllers/control_reconstruccion.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: RECONSTRUCCIÓN</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_reconstruccion">Código</label>  
					<div class="controls">
						<input type="hidden" id="lOpt" name="lOpt" value="Modificar">  
						<input class="input-xlarge" title="el Código del reconstrucción es generado por el sistema" name="codigo_reconstruccion" id="codigo_reconstruccion" type="text" value="<?=$row['codigo_recuperacion']?>" readonly /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="fecha">Fecha</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha de reconstrucción del bien nacional" name="fecha" id="fecha" type="text" value="<?=$row['fecha']?>" readonly required />
					</div>  
				</div> 
				<div class="control-group">  
					<label class="control-label" for="cedula_persona">Responsable</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Seleccione un responsable" onKeyUp="this.value=this.value.toUpperCase()" name="cedula_persona" id="cedula_persona" type="text" value="<?=$row['responsable']?>" required />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="codigo_ubicacion">Ubicación Destino</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Seleccione una ubicación" onKeyUp="this.value=this.value.toUpperCase()" name="codigo_ubicacion" id="codigo_ubicacion" type="text" value="<?=$row['ubicacion']?>" required /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="codigo_bien">Bien Nacional a Recuperar</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Seleccione un Item a Recuperar" onKeyUp="this.value=this.value.toUpperCase()" name="codigo_bien" id="codigo_bien" type="text" value="<?=$row['item']?>" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="cantidad">Cantidad a Reconstruir</label>  
					<div class="controls">
						<?php
							$pgsql = new Conexion();
							$sql = "SELECT LAST(dm.valor_actual) AS existencia 
							FROM inventario.tmovimiento m 
							INNER JOIN inventario.tdetalle_movimiento dm ON m.codigo_movimiento = dm.codigo_movimiento 
							WHERE dm.codigo_ubicacion = ".$row['codigo_ubicacion']." AND dm.codigo_item = ".$row['codigo_bien']." 
							AND m.fecha_movimiento < '".$row['fecha']."'";
							$query = $pgsql->Ejecutar($sql);
							while($rows=$pgsql->Respuesta($query)){
								echo '<input type="hidden" name="cantidad_max" id="cantidad_max" value="'.$rows['existencia'].'">';
							}
						?>
						<input class="input-xlarge" type="text" title="Cantidad disponible a recuperar" name="cantidad_a_recuperar" id="cantidad" value="<?=$row['cantidad']?>" required >
					</div>  
				</div>
				<div class="control-group">  
					<?php if($row['estatus']=='1'){echo "<p id='estatus' class='Activo'>Activo </p>";}else{echo "<p id='estatus' class='Desactivado'>Desactivado</p>";} ?>
				</div>
				<div class="table-responsive">
					<table id='tablaDetReconstruccion' class="table-bordered zebra-striped">
						<tr>
							<td><label class="control-label" >Ubicación</label></td>
							<td><label class="control-label" >Item</label></td>
							<td><label class="control-label" >Cantidad</label></td>
						</tr>
						<?php
							$pgsql=new Conexion();
							$sql = "SELECT dr.codigo_item, dr.cantidad, dr.codigo_ubicacion,
							b.nro_serial||' '||b.nombre AS item,u.descripcion AS ubicacion 
							FROM bienes_nacionales.tdetalle_recuperacion dr 
							INNER JOIN bienes_nacionales.tbien b ON dr.codigo_item = b.codigo_bien 
							INNER JOIN inventario.tubicacion u ON dr.codigo_ubicacion = u.codigo_ubicacion 
							WHERE dr.codigo_recuperacion = '".$pgsql->comillas_inteligentes($_GET['codigo_reconstruccion'])."' 
							ORDER BY dr.codigo_detalle_recuperacion ASC";
							$query = $pgsql->Ejecutar($sql);
							$con=0;
							while ($tupla = $pgsql->Respuesta($query)){
								echo "<tr id='".$con."'>
								        <td>
								        <input type='hidden' name='ubicacion[]' id='ubicacion_".$con."' value='".$tupla['codigo_ubicacion']."' >
								        <input class='input-xlarge' type='text' name='name_ubicacion[]' id='name_ubicacion_".$con."' title='Ubicación donde se va a almacenar' value='".$tupla['ubicacion']."' readonly >
								        </td>
								        <td>
								        <input type='hidden' name='items[]' id='items_".$con."' value='".$tupla['codigo_item']."' >
								        <input class='input-xlarge' type='text' name='name_items[]' id='name_items_".$con."' title='Componente a recuperar' value='".$tupla['item']."' readonly >
								        </td>
								        <td>";
										$pgsqlx=new Conexion();
										$sqlx="SELECT MAX(".$row['cantidad']."*cb.cantidad) AS cantidad_max  
										FROM inventario.vw_inventario i
		        						INNER JOIN bienes_nacionales.tconfiguracion_bien cb ON i.codigo_item = cb.codigo_bien 
		        						WHERE i.codigo_item = ".$row['codigo_bien']." AND i.sonlibros='N' AND cb.codigo_item = ".$tupla['codigo_item']."";
		        						$queryx = $pgsqlx->Ejecutar($sqlx);
		        						$fila=$pgsqlx->Respuesta($queryx);
										echo "<input type='hidden' name='cantidad_max[]' id='cantidad_max_".$con."' value='".$fila['cantidad_max']."' >";
										echo "<input class='input-xlarge' type='text' name='cantidad[]' id='cantidad_".$con."' title='Cantidad a recuperar' value='".$tupla['cantidad']."' >
								        </td>
								      </tr>";
								echo "<script language='javascript'>$('#cantidad_'+".$con.").css('width','80px');</script>";
								$con++;
							}
			            ?>
					</table>
				</div>
				<div class="control-group">  
					<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
				</div>  
				<div class="form-action">
					<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
					<?php
						for($x=0;$x<count($a);$x++)
							if($a[$x]['orden']=='3'){
								if($row['estatus']=='1')
									echo '<button type="button" id="btnDesactivar" class="btn btn-large btn-primary"><i class="'.$a[$x]['icono'].'"></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button>&nbsp;';
								else
									echo '<button disabled type="button" id="btnDesactivar" class="btn btn-large btn-primary"><i class="'.$a[$x]['icono'].'"></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button>&nbsp;';

							}else if($a[$x]['orden']=='4'){
								if($row['estatus']=='1')
									echo '<button disabled type="button" id="btnActivar" class="btn btn-large btn-primary"><i class="'.$a[$x]['icono'].'"></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button>';
								else
									echo '<button type="button" id="btnActivar" class="btn btn-large btn-primary"><i class="'.$a[$x]['icono'].'"></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button>';
							}
					?>
					<button type="button" id="btnPrintReport" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Formato de Impresión</button>
					<a href="?reconstruccion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div>  
			</div>  
		</fieldset>  
	</form>
	<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	$pgsql=new Conexion();
	$sql = "SELECT r.codigo_recuperacion,TO_CHAR(r.fecha,'DD/MM/YYYY') AS fecha,
	p.cedula_persona||' - '||p.primer_nombre||' '||p.primer_apellido AS responsable,
	uo.descripcion as ubicacion_origen, u.descripcion as ubicacion, r.cantidad AS cantidad_a_recuperar, 
	br.nro_serial||' '||br.nombre AS bien,b.nro_serial||' '||b.nombre AS item,dr.cantidad 
	FROM bienes_nacionales.trecuperacion r 
	INNER JOIN general.tpersona p ON r.cedula_persona = p.cedula_persona 
	INNER JOIN bienes_nacionales.tdetalle_recuperacion dr ON r.codigo_recuperacion = dr.codigo_recuperacion 
	INNER JOIN inventario.tubicacion uo ON r.codigo_ubicacion = uo.codigo_ubicacion 
	INNER JOIN inventario.tubicacion u ON dr.codigo_ubicacion = u.codigo_ubicacion 
	INNER JOIN bienes_nacionales.tbien br ON r.codigo_bien = br.codigo_bien 
	INNER JOIN bienes_nacionales.tbien b ON dr.codigo_item = b.codigo_bien 
	WHERE r.esrecuperacion='N' AND r.codigo_recuperacion =".$pgsql->comillas_inteligentes($_GET['codigo_reconstruccion']);
	$query = $pgsql->Ejecutar($sql);
	while($obj=$pgsql->Respuesta($query)){
		$row[]=$obj;
	}
	?>
	<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
	<fieldset>
		<legend><center>Vista: RECONSTRUCCIÓN</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="printer">
				<table class="bordered-table zebra-striped" >
					<tr>
						<td>
							<label>Código:</label>
						</td>
						<td>
							<label><?=$row[0]['codigo_recuperacion']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Fecha:</label>
						</td>
						<td>
							<label><?=$row[0]['fecha']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Responsable:</label>
						</td>
						<td>
							<label><?=$row[0]['responsable']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Ubicación Destino:</label>
						</td>
						<td>
							<label><?=$row[0]['ubicacion_origen']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Bien Nacional a Reconstruir:</label>
						</td>
						<td>
							<label><?=$row[0]['bien']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Cantidad a Reconstruir:</label>
						</td>
						<td>
							<label><?=$row[0]['cantidad_a_recuperar']?></label>
						</td>
					</tr>
				</table>
				<table class="bordered-table zebra-striped" >
					<tr>
						<td>
							<label>Item:</label>
						</td>
						<td>
							<label>Cantidad:</label>
						</td>
						<td>
							<label>Ubicación:</label>
						</td>
					</tr>
					<?php
					for ($i=0; $i < count($row); $i++) { 
					?>
					<tr>
						<td>
							<label><?=$row[$i]['item']?></label>
						</td>
						<td>
							<label><?=$row[$i]['cantidad']?></label>
						</td>
						<td>
							<label><?=$row[$i]['ubicacion']?></label>
						</td>
					</tr>
					<?php
					}
					?>
				</table>
				<center>
					<button id="btnPrint" type="button" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
					<a href="?reconstruccion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</center>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana de Impresiones
?>