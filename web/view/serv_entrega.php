<script type="text/javascript" src="js/chsb_entrega.js"></script>
<?php
require_once("../class/class_perfil.php");
require_once('../class/class_bd.php');
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('entrega');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	$pgsql=new Conexion();
	$sql = "SELECT a.codigo_entrega,a.fecha_entrada,a.cedula_responsable||' '||r.primer_nombre||' '||r.primer_apellido AS responsable 
	FROM biblioteca.tentrega a 
	INNER JOIN general.tpersona r ON a.cedula_responsable = r.cedula_persona 
	INNER JOIN general.tpersona p ON a.cedula_persona = p.cedula_persona";
	$consulta = $pgsql->Ejecutar($sql);
	?>
	<fieldset>
		<legend><center>Vista: ENTREGA</center></legend>		
		<div id="paginador" class="enjoy-css"> 
			<div class="container">
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Código:</th>
							<th>Fecha Entrada:</th>
							<th>Responsable:</th>
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
							echo '<td>'.$filas['codigo_entrega'].'</td>';
							echo '<td>'.$filas['fecha_entrada'].'</td>';
							echo '<td>'.$filas['responsable'].'</td>';
							for($x=0;$x<count($a);$x++){
						if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
						echo '<td><a href="?entrega&Opt=3&codigo_entrega='.$filas['codigo_entrega'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
						else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
						echo '<td><a href="?entrega&Opt=4&codigo_entrega='.$filas['codigo_entrega'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
							echo '<a href="?entrega&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
						?>
						<button type="button" id="btnImprimirTodos" class="btn btn-large btn-primary"><i class="icon-download-alt"></i>&nbsp;Descargar Archivo</button>
					</center>

					<div id="Imprimir" style="display:none;">
						<span>Descargar Como:</span>
						<br/><br/>
						<a href="<?php echo  '../pdf/pdf_entrega.php';?>" target="_blank"> <img src="images/icon-pdf.png" alt="Exportar a PDF" style="width:60px;heigth:60px;float:center;"> </a>
						&nbsp;&nbsp;
						<a href="../excel/excel_entrega.php" ><img src="images/icon-excel.png" alt="Exportar a Excel" style="width:60px;heigth:60px;float:center;"></a>
				    </div>


				</div>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana Principal
else if($_GET['Opt']=="2"){ // Ventana de Registro
	?>
	<form class="form-horizontal" action="../controllers/control_entrega.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: ENTREGA</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_entrega">Código</label>  
					<div class="controls">  
						<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
						<input class="input-xlarge" title="el Código del entrega es generado por el sistema" name="codigo_entrega" id="codigo_entrega" type="text" readonly /> 
					</div>  
				</div>
				<div class="control-group">  
				<label class="control-label" for="codigo_prestamo">Préstamos:</label>  
				<div class="controls">  
					<select class="bootstrap-select form-control" title="Seleccione un Préstamo" name='codigo_prestamo' id='codigo_prestamo' required >
						<option value=0>Seleccione un Préstamo</option>
						<?php
						require_once('../class/class_bd.php');
						$pgsql = new Conexion();
						$sql = "SELECT a.codigo_prestamo,a.cota||', '||a.fecha_entrada||' .'||
						a.cedula_persona||' -'||INITCAP(p.primer_nombre||' '||p.primer_apellido) AS prestamo 
						FROM biblioteca.tprestamo a
						INNER JOIN general.tpersona p ON a.cedula_persona = p.cedula_persona
						WHERE NOT EXISTS(SELECT 1 FROM biblioteca.tentrega e WHERE a.codigo_prestamo = e.codigo_prestamo)";
						$query = $pgsql->Ejecutar($sql);
						while($row=$pgsql->Respuesta($query)){
							echo "<option value=".$row['codigo_prestamo'].">".$row['prestamo']."</option>";
						}
						?>
					</select>
				</div>  
			</div>
				<div class="control-group">  
					<label class="control-label" for="cedula_responsable">Responsable de la Entrega</label>  
						<div class="controls">  
						<select class="bootstrap-select form-control" title="Seleccione un responsable" name='cedula_responsable' id='cedula_responsable' required >
							<option value=0>Seleccione un Responsable</option>
							<?php
								$pgsql = new Conexion();
								$sql = "SELECT p.cedula_persona,INITCAP(p.primer_nombre||' '||p.primer_apellido) nombre 
								FROM general.tpersona p 
								INNER JOIN general.ttipo_persona tp ON p.codigo_tipopersona = tp.codigo_tipopersona 
								WHERE LOWER(descripcion) NOT LIKE '%representante%' AND LOWER(descripcion) NOT LIKE '%estudiante%'";
								$query = $pgsql->Ejecutar($sql);
								while($row=$pgsql->Respuesta($query)){
									echo "<option value=".$row['cedula_persona'].">".$row['cedula_persona']." ".$row['nombre']."</option>";
								}
							?>
						</select>
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="cedula_persona">Estudiante</label>  
					<div class="controls">  
						<input name="cedula_persona" id="cedula_persona" type="hidden"/>
						<input class="input-xlarge" title="Estudiante que realiza la entrega" name="estudiante" id="estudiante" type="text" readonly required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="fecha_entrada">Fecha de Entrada </label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha de Entrada" name="fecha_entrada" id="fecha_entrada" type="text" readonly required />
					</div>  
				</div>
				<div class="table-responsive">
					<table id='tablaDetEntrega' class="table-bordered zebra-striped">
						<tr>
							<td><label class="control-label" >Ejemplar</label></td>
							<td><label class="control-label" >Cantidad</label></td>
						</tr>
					</table>
				</div>
				<div class="control-group">  
					<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
				</div>  
				<div class="form-actions">
					<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
					<a href="?entrega"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
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
						url = "../pdf/pdf_formato_entrega.php?p1='.$_SESSION['datos']['codigo_entrega'].'";
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
	$sql = "SELECT *,TO_CHAR(fecha_entrada,'DD/MM/YYYY') as fecha_entrada 
	FROM biblioteca.tentrega 
	WHERE codigo_entrega=".$pgsql->comillas_inteligentes($_GET['codigo_entrega']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<form class="form-horizontal" action="../controllers/control_entrega.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: ENTREGA</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_entrega">Código</label>  
					<div class="controls">
						<input type="hidden" id="lOpt" name="lOpt" value="Modificar">  
						<input class="input-xlarge" title="el Código del entrega es generado por el sistema" name="codigo_entrega" id="codigo_entrega" type="text" value="<?=$row['codigo_entrega']?>" readonly /> 
					</div>  
				</div>
			<div class="control-group">  
				<label class="control-label" for="codigo_prestamo">Préstamos</label>  
				<div class="controls">  
					<select class="selectpicker" data-live-search="true" title="Seleccione un Préstamo" name='codigo_prestamo' id='codigo_prestamo' required >
						<option value=0>Seleccione un Préstamo</option>
						<?php
							$pgsql = new Conexion();
							$sql = "SELECT a.codigo_prestamo,a.cota||', '||a.fecha_entrada||' .'||
							a.cedula_persona||' -'||INITCAP(p.primer_nombre||' '||p.primer_apellido) AS prestamo 
							FROM biblioteca.tprestamo a
							INNER JOIN general.tpersona p ON a.cedula_persona = p.cedula_persona";
							$query = $pgsql->Ejecutar($sql);
							while($rows=$pgsql->Respuesta($query)){
								if($rows['codigo_prestamo']==$row['codigo_prestamo'])
									echo "<option value=".$rows['codigo_prestamo']." selected>".$rows['codigo_prestamo']." ".$rows['prestamo']."</option>";
								else
									echo "<option value=".$rows['codigo_prestamo'].">".$rows['codigo_prestamo']." ".$rows['prestamo']."</option>";
							}
						?>
					</select>
				</div>
			<div class="control-group">  
				<label class="control-label" for="cedula_responsable">Responsable de la Entrega</label>  
				<div class="controls">  
					<select class="selectpicker" data-live-search="true" title="Seleccione un responsable" name='cedula_responsable' id='cedula_responsable' required >
						<option value=0>Seleccione un Responsable</option>
						<?php
							$pgsql = new Conexion();
							$sql = "SELECT p.cedula_persona,INITCAP(p.primer_nombre||' '||p.primer_apellido) nombre 
							FROM general.tpersona p 
							INNER JOIN general.ttipo_persona tp ON p.codigo_tipopersona = tp.codigo_tipopersona 
							WHERE LOWER(descripcion) NOT LIKE '%representante%' AND LOWER(descripcion) NOT LIKE '%estudiante%'";
							$query = $pgsql->Ejecutar($sql);
							while($rows=$pgsql->Respuesta($query)){
								if($rows['cedula_persona']==$row['cedula_persona'])
									echo "<option value=".$rows['cedula_persona']." selected>".$rows['cedula_persona']." ".$rows['nombre']."</option>";
								else
									echo "<option value=".$rows['cedula_persona'].">".$rows['cedula_persona']." ".$rows['nombre']."</option>";
							}
						?>
					</select>
				</div>  
			</div>
				<div class="control-group">  
				<label class="control-label" for="cedula_persona">Estudiante</label>  
				<div class="controls">  
					<select class="selectpicker" data-live-search="true" title="Seleccione un Estudiante" name='cedula_persona' id='cedula_persona' required >
						<option value=0>Seleccione un Estudiante</option>
						<?php
							$pgsql = new Conexion();
							$sql = "SELECT p.cedula_persona,INITCAP(p.primer_nombre||' '||p.primer_apellido) nombre 
							FROM general.tpersona p 
							INNER JOIN general.ttipo_persona tp ON p.codigo_tipopersona = tp.codigo_tipopersona 
							WHERE LOWER(descripcion) LIKE '%estudiante%'";
							$query = $pgsql->Ejecutar($sql);
							while($rows=$pgsql->Respuesta($query)){
								if($rows['cedula_persona']==$row['cedula_persona'])
									echo "<option value=".$rows['cedula_persona']." selected>".$rows['cedula_persona']." ".$rows['nombre']."</option>";
								else
									echo "<option value=".$rows['cedula_persona'].">".$rows['cedula_persona']." ".$rows['nombre']."</option>";
								}
							?>
						</select>
					</div>
				</div>
				<div class="control-group">  
					<label class="control-label" for="fecha_entrada">Fecha de Entrada</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha de entrada del Préstamo" name="fecha_entrada" id="fecha_entrada" type="text" value="<?=$row['fecha_entrada']?>" readonly required />
					</div>  
				</div> 
				</div>
				<div class="control-group">  
					<?php if($row['estatus']=='1'){echo "<p id='estatus' class='Activo'>Activo </p>";}else{echo "<p id='estatus' class='Desactivado'>Desactivado</p>";} ?>
				</div>
				<div class="table-responsive">
					<table id='tablaDetEntrega' class="table-bordered zebra-striped">
						<tr>
							<td><label class="control-label" >Ejemplar</label></td>
							<td><label class="control-label" >Ubicación</label></td>
							<td><label class="control-label" >Cantidad</label></td>
							<td><button type="button" onclick="agrega_campos()" class="btn btn-primary"><i class="icon-plus"></i></button></td>
						</tr>
						<?php
							$pgsql=new Conexion();
							$sql = "SELECT codigo_ejemplar, codigo_ubicacion, cantidad 
							FROM biblioteca.tdetalle_entrega  WHERE codigo_entrega = '".$row['codigo_entrega']."' 
							ORDER BY codigo_detalle_entrega ASC";
							$query = $pgsql->Ejecutar($sql);
							$con=0;
							while ($row = $pgsql->Respuesta($query)){
								echo "<tr id='".$con."'>
								        <td>
										<select class='bootstrap-select form-control' name='ejemplar[]' id='ejemplar_".$con."' title='Seleccione un Ejemplar' >
										<option value='0'>Seleccione un Ejemplar</option>";
										$sqlx = "SELECT DISTINCT b.codigo_ejemplar,INITCAP(l.codigo_isbn_libro||' '||l.titulo) ejemplars 
										FROM biblioteca.tejemplar b 
										INNER JOIN inventario.vw_inventario i ON b.codigo_ejemplar = i.codigo_item
										INNER JOIN biblioteca.tlibro l on b.codigo_isbn_libro=l.codigo_isbn_libro";
																	$querys = $pgsql->Ejecutar($sqlx);
										while ($rows = $pgsql->Respuesta($querys)){
											if($rows['codigo_ejemplar']==$row['codigo_ejemplar']){
												echo "<option value='".$rows['codigo_ejemplar']."' selected>".$rows['ejemplars']."</option>";
											}else{
												echo "<option value='".$rows['codigo_ejemplar']."'>".$rows['ejemplars']."</option>";
											}
										}
										echo "</select>
								        </td>
								        <td>
								        <select class='bootstrap-select form-control' name='ubicacion[]' id='ubicacion_".$con."' title='Seleccione una Ubicación Origen' >
								        <option value='0'>Seleccione un Ejemplar</option>";
								        $sqlz="SELECT DISTINCT u.codigo_ubicacion,u.descripcion  
										FROM inventario.tubicacion u 
										INNER JOIN inventario.vw_inventario i ON u.codigo_ubicacion = i.codigo_ubicacion";
								        $queryz = $pgsql->Ejecutar($sqlz);
								          while ($rows = $pgsql->Respuesta($queryz)){
								            if($rows['codigo_ubicacion']==$row['codigo_ubicacion']){
								              echo "<option value='".$rows['codigo_ubicacion']."' selected>".$rows['descripcion']."</option>";
								            }else{
								              echo "<option value='".$rows['codigo_ubicacion']."'>".$rows['descripcion']."</option>";
								            }
								          }
								        echo "</select>
								        </td>
								        <td>
								        <input type='text' name='cantidad[]' id='cantidad_".$con."' onKeyPress='return isNumberKey(event)' maxlength=3 title='Ingrese una cantidad' value='".$row['cantidad']."' >
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
					<a href="?entrega"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
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
			$("#tablaDetentrega").append("<tr id='"+contador+"'>"+
			"<td>"+
			"<select class='bootstrap-select form-control' name='ejemplar[]' id='ejemplar_"+contador+"' title='Seleccione un ejemplar'>"+
			<?php
			$pgsql=new Conexion();
			$sql = "SELECT DISTINCT b.codigo_ejemplar,INITCAP(l.codigo_isbn_libro||' '||l.titulo) ejemplars 
			FROM biblioteca.tejemplar b 
			INNER JOIN inventario.vw_inventario i ON b.codigo_ejemplar = i.codigo_item
			INNER JOIN biblioteca.tlibro l on b.codigo_isbn_libro=l.codigo_isbn_libro";
			$query = $pgsql->Ejecutar($sql);
			$comillasimple=chr(34);
			while ($rows = $pgsql->Respuesta($query)){
				echo $comillasimple."<option value='".$rows['codigo_ejemplar']."'>".$rows['ejemplars']."</option>".$comillasimple."+";
			}
			?>
			"</select>"+
			"</td>"+
			
			"<td>"+
			"<select class='bootstrap-select form-control' name='ubicacion[]' id='ubicacion_"+contador+"' title='Seleccione una Ubicación'>"+
			<?php
			$pgsql=new Conexion();
			$sql = "SELECT DISTINCT u.codigo_ubicacion,u.descripcion  
			FROM inventario.tubicacion u 
			INNER JOIN inventario.vw_inventario i ON u.codigo_ubicacion = i.codigo_ubicacion";
			$query = $pgsql->Ejecutar($sql);
			$comillasimple=chr(34);
			while ($rows = $pgsql->Respuesta($query)){
				echo $comillasimple."<option value='".$rows['codigo_ubicacion']."'>".$rows['descripcion']."</option>".$comillasimple."+";
			}
			?>
			"</select>"+
			"</td>"+
			"<td>"+
			"<input type='text' name='cantidad[]' id='cantidad_"+contador+"' onKeyPress='return isNumberKey(event)' maxlength=3 title='Ingrese una cantidad'>"+
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
	$sql = "SELECT a.codigo_entrega,b.codigo_prestamo,b.cota||' '||b.fecha_entrada||' '||
	b.cedula_persona||' '||INITCAP(p.primer_nombre||' '||p.primer_apellido) AS prestamo,
	a.cedula_responsable||' '||r.primer_nombre||' '||r.primer_apellido AS responsable,
	a.cedula_persona||' '||p.primer_nombre||' '||p.primer_apellido AS persona,
	 TO_CHAR(a.fecha_entrada,'DD/MM/YYYY') AS fecha_entrada,
	a.cantidad AS cantidad_a_prestar
	FROM biblioteca.tentrega a 
	LEFT JOIN biblioteca.tprestamo b ON a.codigo_prestamo = b.codigo_prestamo 
	INNER JOIN general.tpersona r ON a.cedula_responsable = r.cedula_persona 
	INNER JOIN general.tpersona p ON a.cedula_persona = p.cedula_persona
 
	WHERE a.codigo_entrega =".$pgsql->comillas_inteligentes($_GET['codigo_entrega']);
	$query = $pgsql->Ejecutar($sql);
	while($obj=$pgsql->Respuesta($query)){
		$row[]=$obj;
	}
	?>
	<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
	<fieldset>
		<legend><center>Vista: ENTREGA</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="printer">
				<table class="bordered-table zebra-striped" >
					<tr>
						<td>
							<label>Código:</label>
						</td>
						<td>
							<label><?=$row[0]['codigo_entrega']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Préstamo:</label>
						</td>
						<td>
							<label><?=$row[0]['prestamo']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Responsable de la Entrega:</label>
						</td>
						<td>
							<label><?=$row[0]['responsable']?></label>
						</td>
					</tr>
						<tr>
						<td>
							<label>Estudiante:</label>
						</td>
						<td>
							<label><?=$row[0]['persona']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Fecha Entrada:</label>
						</td>
						<td>
							<label><?=$row[0]['fecha_entrada']?></label>
						</td>
					</tr> 
					<tr>
						<td>
							<label>Cantidad:</label>
						</td>
						<td>
							<label><?=$row[0]['cantidad_a_prestar']?></label>
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
							<label><?=$row[$i]['item']?></label>
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
					<a href="?entrega"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</center>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana de Impresiones
?>