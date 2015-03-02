<script type="text/javascript" src="js/chsb_prestamo.js"></script>
<?php
require_once("../class/class_perfil.php");
require_once('../class/class_bd.php');
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('prestamo');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	$pgsql=new Conexion();
	$sql = "SELECT a.codigo_prestamo,TO_CHAR(a.fecha_salida,'DD/MM/YYYY') AS fecha_salida,
		a.cedula_responsable||' '||r.primer_nombre||' '||r.primer_apellido AS responsable,
		a.cedula_persona||' '||p.primer_nombre||' '||p.primer_apellido AS persona,
		da.cantidad-COALESCE((SELECT SUM(de.cantidad) FROM biblioteca.tentrega e INNER JOIN biblioteca.tdetalle_entrega de ON e.codigo_entrega = de.codigo_entrega 
		WHERE e.codigo_prestamo = a.codigo_prestamo AND da.codigo_ejemplar = de.codigo_ejemplar),0) AS cantidad
		FROM biblioteca.tprestamo a 
		INNER JOIN biblioteca.tdetalle_prestamo da ON a.codigo_prestamo = da.codigo_prestamo 
		INNER JOIN general.tpersona r ON a.cedula_responsable = r.cedula_persona 
		INNER JOIN general.tpersona p ON a.cedula_persona = p.cedula_persona";
		$consulta = $pgsql->Ejecutar($sql);
		?>
	<fieldset>
		<legend><center>Vista: PRÉSTAMO</center></legend>		
		<div id="paginador" class="enjoy-css"> 
			<div class="container">
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Código</th>
							<th>Fecha Salida</th>
							<th>Responsable</th>
							<th>Solicitante</th>
							<th>Libros por Entregar</th>
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
							echo '<td>'.$filas['codigo_prestamo'].'</td>';
							echo '<td>'.$filas['fecha_salida'].'</td>';
							echo '<td>'.$filas['responsable'].'</td>';
							echo '<td>'.$filas['persona'].'</td>';
							echo '<td>'.$filas['cantidad'].'</td>';
							for($x=0;$x<count($a);$x++){
						if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
						echo '<td><a href="?prestamo&Opt=3&codigo_prestamo='.$filas['codigo_prestamo'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
						else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
						echo '<td><a href="?prestamo&Opt=4&codigo_prestamo='.$filas['codigo_prestamo'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
							echo '<a href="?prestamo&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
						?>
						<button type="button" id="btnImprimirTodos" class="btn btn-large btn-primary"><i class="icon-download-alt"></i>&nbsp;Descargar Archivo</button>
					</center>

					<div id="Imprimir" style="display:none;">
						<span>Descargar Como:</span>
						<br/><br/>
						<a href="<?php echo  '../pdf/pdf_prestamo.php';?>" target="_blank"> <img src="images/icon-pdf.png" alt="Exportar a PDF" style="width:60px;heigth:60px;float:center;"> </a>
						&nbsp;&nbsp;
						<a href="../excel/excel_prestamo.php" ><img src="images/icon-excel.png" alt="Exportar a Excel" style="width:60px;heigth:60px;float:center;"></a>
				    </div>


				</div>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana Principal
else if($_GET['Opt']=="2"){ // Ventana de Registro
	?>
	<form class="form-horizontal" action="../controllers/control_prestamo.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: PRÉSTAMO</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_prestamo">Código</label>  
					<div class="controls">  
						<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
						<input class="input-xlarge" title="el Código del prestamo es generado por el sistema" name="codigo_prestamo" id="codigo_prestamo" type="text" readonly /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="cedula_responsable">Responsable del Préstamo</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Seleccione un Responsable" name="cedula_responsable" id="cedula_responsable" onKeyUp="this.value=this.value.toUpperCase()" type="text" required />
					</div>  
				</div> 
				<div class="control-group">  
					<label class="control-label" for="cedula_persona">Solicitante</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Seleccione un Solicitante" name="cedula_persona" id="cedula_persona" onKeyUp="this.value=this.value.toUpperCase()" type="text" required />
					</div>  
				</div>     
				<div class="control-group">  
					<label class="control-label" for="codigo_area">Área:</label>  
					<div class="controls">  
						<select class="bootstrap-select form-control" title="Seleccione un Área" name='codigo_area' id='codigo_area' required >
							<option value=0>Seleccione un Área</option>
							<?php
							require_once('../class/class_bd.php');
							$pgsql = new Conexion();
							$sql = "SELECT * FROM general.tarea ORDER BY descripcion ASC";
							$query = $pgsql->Ejecutar($sql);
							while($row=$pgsql->Respuesta($query)){
								echo "<option value=".$row['codigo_area'].">".$row['descripcion']."</option>";
							}
							?>
						</select>
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="lugar_prestamo">Lugar del Préstamo:</label>  
					<div class="controls">  
						<select class="bootstrap-select form-control" name="lugar_prestamo" id="lugar_prestamo" title="Seleccione un lugar del préstamo" required > 
							<option value=0>Seleccione un Lugar</option>
							<option value="S" >SALA</option>
							<option value="A" >AULA</option>
						</select>
					</div>
				</div> 
					<div class="control-group">  
					<label class="control-label" for="fecha_salida">Fecha de Salida</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha de Salida" name="fecha_salida" id="fecha_salida" type="text" readonly required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="fecha_entrada">Fecha de Entrada</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha de Entrada" name="fecha_entrada" id="fecha_entrada" type="text" readonly required />
					</div>
				</div>
				<div class="control-group">  
					<label class="control-label" for="observacion">Observación</label>  
					<div class="controls">  
						<textarea class="input-xlarge" title="Ingrese una Observación del préstamo" onKeyUp="this.value=this.value.toUpperCase()" name="observacion" id="observacion" type="text"/></textarea>
					</div>  
				</div>    
				<div class="table-responsive">
					<table id='tablaDetPrestamo' class="table-bordered zebra-striped">
						<tr>
							<td><label class="control-label" >Ejemplar</label></td>
							<td><label class="control-label" >Ubicación</label></td>
							<td><label class="control-label" >Cantidad</label></td>
							<td><button type="button" onclick="agrega_campos()" class="btn btn-primary"><i class="icon-plus"></i></button></td>	
						</tr>
					</table>
				</div>
				<div class="control-group">  
					<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
				</div>  
				<div class="form-actions">
					<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
					<a href="?prestamo"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div> 
			</div>  
		</fieldset>  
	</form>
	<script type="text/javascript">
		var ejemplar = document.getElementsByName('ejemplar[]');
		var ubicacion = document.getElementsByName('ubicacion[]');
		var cantidad = document.getElementsByName('cantidad[]');
		var contador=ejemplar.length;
		function agrega_campos(){
			$("#tablaDetPrestamo").append("<tr id='"+contador+"'>"+
			"<td>"+
			"<input type='text' name='ejemplar[]' id='ejemplar_"+contador+"' onKeyPress='return ACDataGrid(this.id,\"inv_libros.php\")' onKeyUp='this.value=this.value.toUpperCase()' title='Seleccione un Libro'>"+
			"</td>"+
			"<td>"+
			"<input type='text' name='ubicacion[]' id='ubicacion_"+contador+"' onKeyPress='return ACDataGrid(this.id,\"inv_ubicacion_libros_nodefectuosos.php\")' onKeyUp='this.value=this.value.toUpperCase()' title='Seleccione una Ubicación'>"+
			"</td>"+
			"<td>"+
			"<input class='input-xlarge' type='text' name='cantidad[]' id='cantidad_"+contador+"' onKeyPress='return isNumberKey(event)' maxlength=3 title='Ingrese una cantidad'>"+
			"</td>"+
			"<td>"+
			"<button type='button' class='btn btn-primary' onclick='elimina_me("+contador+")'><i class='icon-minus'></i></button>"+
			"</td>"+
			"</tr>");
			//	Modificamos el width de la cantidad para este elemento
		    $('#cantidad_'+contador).css("width","80px");
			contador++;
		}

		function elimina_me(elemento){
			$("#"+elemento).remove();
			for(var i=0;i<ejemplar.length;i++){
				ejemplar[i].removeAttribute('id');
				ubicacion[i].removeAttribute('id');
				cantidad[i].removeAttribute('id');
			}
			for(var i=0;i<ejemplar.length;i++){
				ejemplar[i].setAttribute('id','ejemplar_'+i);
				ubicacion[i].setAttribute('id','ubicacion_'+i);
				cantidad[i].setAttribute('id','cantidad_'+i);
			}
		}
	</script>
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
						url = "../pdf/pdf_formato_prestamo.php?p1='.$_SESSION['datos']['codigo_prestamo'].'";
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
}
// Ventana de Registro
else if($_GET['Opt']=="3"){ 
// Ventana de Modificaciones
	$pgsql=new Conexion();
	$sql = "SELECT p.*,TO_CHAR(p.fecha_salida,'DD/MM/YYYY') as fecha_salida,TO_CHAR(p.fecha_entrada,'DD/MM/YYYY') as fecha_entrada,
	p.cedula_responsable||'_'||r.primer_nombre||' '||r.primer_apellido AS responsable,
	p.cedula_persona||'_'||s.primer_nombre||' '||s.primer_apellido AS solicitante
	FROM biblioteca.tprestamo p 
	INNER JOIN general.tpersona r ON p.cedula_responsable = r.cedula_persona 
	INNER JOIN general.tpersona s ON p.cedula_persona = s.cedula_persona 
	WHERE p.codigo_prestamo=".$pgsql->comillas_inteligentes($_GET['codigo_prestamo']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<form class="form-horizontal" action="../controllers/control_prestamo.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: PRÉSTAMO</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_prestamo">Código</label>  
					<div class="controls">
						<input type="hidden" id="lOpt" name="lOpt" value="Modificar">  
						<input class="input-xlarge" title="el Código del prestamo es generado por el sistema" name="codigo_prestamo" id="codigo_prestamo" type="text" value="<?=$row['codigo_prestamo']?>" readonly /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="cedula_responsable">Responsable del Préstamo</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Seleccione un Responsable" name="cedula_responsable" id="cedula_responsable" onKeyUp="this.value=this.value.toUpperCase()" type="text" value="<?=$row['responsable']?>" required />
					</div>  
				</div> 
				<div class="control-group">  
					<label class="control-label" for="cedula_persona">Solicitante</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Seleccione un Solicitante" name="cedula_persona" id="cedula_persona" onKeyUp="this.value=this.value.toUpperCase()" type="text" value="<?=$row['solicitante']?>" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="codigo_area">Área:</label>  
					<div class="controls">  
						<select class="bootstrap-select form-control" title="Seleccione un Área" name='codigo_area' id='codigo_area' required >
							<option value=0>Seleccione un Área</option>
							<?php
							require_once('../class/class_bd.php');
							$pgsql = new Conexion();
							$sql = "SELECT * FROM general.tarea ORDER BY descripcion ASC";
							$query = $pgsql->Ejecutar($sql);
							while($rows=$pgsql->Respuesta($query)){
								if($rows['codigo_area']==$row['codigo_area'])
									echo "<option value=".$rows['codigo_area']." selected >".$rows['descripcion']."</option>";
								else
									echo "<option value=".$row['codigo_area'].">".$row['descripcion']."</option>";
							}
							?>
						</select>
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="lugar_prestamo">Lugar del Préstamo:</label>  
					<div class="controls">  
						<select class="bootstrap-select form-control" name="lugar_prestamo" id="lugar_prestamo" title="Seleccione un tipo de materia" required > 
							<option value=0>Seleccione un Lugar</option>
							<option value="S" <?php if($row['lugar_prestamo']=="S") {echo "selected";} ?>> SALA</option>
							<option value="A" <?php if($row['lugar_prestamo']=="A") {echo "selected";} ?>> AULA</option>
						</select>
					</div>  
				</div>   			
				<div class="control-group">  
					<label class="control-label" for="fecha_salida">Fecha de Salida</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha de Salida" name="fecha_salida" id="fecha_salida" type="text" value="<?=$row['fecha_salida']?>" readonly required />
					</div>  
				</div> 
				<div class="control-group">  
					<label class="control-label" for="fecha_entrada">Fecha de Entrada</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha de Entrada" name="fecha_entrada" id="fecha_entrada" type="text" value="<?=$row['fecha_entrada']?>" readonly required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="observacion">Observación</label>  
					<div class="controls">  
						<textarea class="input-xlarge" title="Ingrese una observación del Préstamo" onKeyUp="this.value=this.value.toUpperCase()" name="observacion"type="text" /><?php echo $row['observacion']; ?></textarea>
					</div>  
				</div>
				<div class="control-group">  
					<?php if($row['estatus']=='1'){echo "<p id='estatus' class='Activo'>Activo </p>";}else{echo "<p id='estatus' class='Desactivado'>Desactivado</p>";} ?>
				</div>
				<div class="table-responsive">
					<table id='tablaDetPrestamo' class="table-bordered zebra-striped">
						<tr>
							<td><label class="control-label" >Ejemplar</label></td>
							<td><label class="control-label" >Ubicación</label></td>
							<td><label class="control-label" >Cantidad</label></td>
							<td><button type="button" onclick="agrega_campos()" class="btn btn-primary"><i class="icon-plus"></i></button></td>
						</tr>
						<?php
							$pgsql=new Conexion();
							$sql = "SELECT codigo_ejemplar, codigo_ubicacion,cantidad
							FROM biblioteca.tdetalle_prestamo  WHERE codigo_prestamo = '".$row['codigo_prestamo']."' 
							ORDER BY codigo_detalle_prestamo ASC";
							$query = $pgsql->Ejecutar($sql);
							$con=0;
							while ($row = $pgsql->Respuesta($query)){
								echo "<tr id='".$con."'>
								        <td>
										<input type='text' name='ejemplar[]' id='ejemplar_".$con."' onKeyPress='return ACDataGrid(this.id,\"inv_libros.php\")' onKeyUp='this.value=this.value.toUpperCase()' title='Seleccione un Libro' value='".$row['ejemplar']."'>
								        </td>
								        <td>
								       	<input type='text' name='ubicacion[]' id='ubicacion_".$con."' onKeyPress='return ACDataGrid(this.id,\"inv_ubicacion_libros_nodefectuosos.php\")' onKeyUp='this.value=this.value.toUpperCase()' title='Seleccione una Ubicación' value='".$row['ubicacion']."'>
								        </td>
								         <td>
								        <input class='input-xlarge' type='text' name='cantidad[]' id='cantidad_".$con."' onKeyPress='return isNumberKey(event)' maxlength=3 title='Ingrese una cantidad' value='".$row['cantidad']."' >
								        </td>
								        <td>
								          <button type='button' class='btn btn-primary' onclick='elimina_me('".$con."')'><i class='icon-minus'></i></button>
								        </td>
								      </tr>";
								echo "<script>$('#cantidad_'+".$con.").css('width','80px');</script>";
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
					<a href="?prestamo"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div>  
			</div>  
		</fieldset>  
	</form>
	<script type="text/javascript">
		var ejemplar = document.getElementsByName('ejemplar[]');
		var ubicacion = document.getElementsByName('ubicacion[]');
		var cantidad = document.getElementsByName('cantidad[]');
		var contador=ejemplar.length;
		function agrega_campos(){
			$("#tablaDetAdquisicion").append("<tr id='"+contador+"'>"+
			"<td>"+
			"<input type='text' name='ejemplar[]' id='ejemplar_"+contador+"' onKeyPress='return ACDataGrid(this.id,\"inv_libros.php\")' onKeyUp='this.value=this.value.toUpperCase()' title='Seleccione un Libro'>"+
			"</td>"+
			"<td>"+
			"<input type='text' name='ubicacion[]' id='ubicacion_"+contador+"' onKeyPress='return ACDataGrid(this.id,\"inv_ubicacion_libros_nodefectuosos.php\")' onKeyUp='this.value=this.value.toUpperCase()' title='Seleccione una Ubicación'>"+
			"</td>"+
			"<td>"+
			"<input class='input-xlarge' type='text' name='cantidad[]' id='cantidad_"+contador+"' onKeyPress='return isNumberKey(event)' maxlength=3 title='Ingrese una cantidad'>"+
			"</td>"+
			"<td>"+
			"<button type='button' class='btn btn-primary' onclick='elimina_me("+contador+")'><i class='icon-minus'></i></button>"+
			"</td>"+
			"</tr>");
			//	Modificamos el width de la cantidad para este elemento
		    $('#cantidad_'+contador).css("width","80px");
			contador++;
		}

		function elimina_me(elemento){
			$("#"+elemento).remove();
			for(var i=0;i<ejemplar.length;i++){
				ejemplar[i].removeAttribute('id');
				ubicacion[i].removeAttribute('id');
				cantidad[i].removeAttribute('id');
			}
			for(var i=0;i<ejemplar.length;i++){
				ejemplar[i].setAttribute('id','ejemplar_'+i);
				ubicacion[i].setAttribute('id','ubicacion_'+i);
				cantidad[i].setAttribute('id','cantidad_'+i);
			}
		}
	</script>
	<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	$pgsql=new Conexion();
	$sql = "SELECT a.codigo_prestamo,a.cedula_responsable||' '||r.primer_nombre||' '||r.primer_apellido AS responsable,
	a.cedula_persona||' '||p.primer_nombre||' '||p.primer_apellido AS persona,ar.descripcion AS area, CASE a.lugar_prestamo WHEN 'S' THEN 'SALA' ELSE 'AULA' END AS lugar_prestamo,
	TO_CHAR(a.fecha_salida,'DD/MM/YYYY') AS fecha_salida, TO_CHAR(a.fecha_entrada,'DD/MM/YYYY') AS fecha_entrada, a.observacion,
	 b.codigo_cra||' - '||b.numero_edicion||' '||l.titulo AS ejemplar,da.cantidad
	FROM biblioteca.tprestamo a 
	INNER JOIN general.tpersona r ON a.cedula_responsable = r.cedula_persona 
	INNER JOIN general.tpersona p ON a.cedula_persona = p.cedula_persona
	INNER JOIN general.tarea ar ON a.codigo_area = ar.codigo_area  
	INNER JOIN biblioteca.tdetalle_prestamo da ON a.codigo_prestamo = da.codigo_prestamo 
	LEFT JOIN biblioteca.tejemplar b ON da.codigo_ejemplar = b.codigo_ejemplar 
	INNER JOIN biblioteca.tlibro l on b.codigo_isbn_libro=l.codigo_isbn_libro 
	WHERE a.codigo_prestamo =".$pgsql->comillas_inteligentes($_GET['codigo_prestamo']);
	$query = $pgsql->Ejecutar($sql);
	while($obj=$pgsql->Respuesta($query)){
		$row[]=$obj;
	}
	?>
	<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
	<fieldset>
		<legend><center>Vista: PRÉSTAMO</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="printer">
				<table class="bordered-table zebra-striped" >
					<tr>
						<td>
							<label>Código:</label>
						</td>
						<td>
							<label><?=$row[0]['codigo_prestamo']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Responsable del Préstamo:</label>
						</td>
						<td>
							<label><?=$row[0]['responsable']?></label>
						</td>
					</tr> 
					<tr>
						<td>
							<label>Solicitante:</label>
						</td>
						<td>
							<label><?=$row[0]['persona']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Área:</label>
						</td>
						<td>
							<label><?=$row[0]['area']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Lugar del Préstamo:</label>
						</td>
						<td>
							<label><?=$row[0]['lugar_prestamo']?></label>
						</td>
					</tr> 
					<tr>
						<td>
							<label>Fecha De Salida:</label>
						</td>
						<td>
							<label><?=$row[0]['fecha_salida']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Fecha De Entrada:</label>
						</td>
						<td>
							<label><?=$row[0]['fecha_entrada']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Observación:</label>
						</td>
						<td>
							<label><?=$row[0]['observacion']?></label>
						</td>
					</tr>
				</table>
				<table class="bordered-table zebra-striped" >
					<tr>
						<td>
							<label>Ejemplar:</label>
						</td>
						<td>
							<label>Cantidad:</label>
						</td>
					</tr>
					<?php
					for ($i=0; $i < count($row); $i++) { 
					?>
					<tr>
						<td>
							<label><?=$row[$i]['ejemplar']?></label>
						</td>
						<td>
							<label><?=$row[$i]['cantidad']?></label>
						</td>
					</tr>
					<?php
					}
					?>
				</table>
				<center>
					<button id="btnPrint" type="button" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
					<a href="?prestamo"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</center>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana de Impresiones
?>