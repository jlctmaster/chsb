<script type="text/javascript" src="js/chsb_asignacion.js"></script>
<?php
require_once("../class/class_perfil.php");
require_once('../class/class_bd.php');
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('asignacion_libro');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	$pgsql=new Conexion();
	$sql = "SELECT a.codigo_asignacion_libro,a.fecha_asignacion,p.cedula_persona||' - '||p.primer_nombre||' '||p.primer_apellido AS responsable 
	FROM biblioteca.tasignacion_libro a 
	INNER JOIN general.tpersona p ON a.cedula_persona = p.cedula_persona";
	$consulta = $pgsql->Ejecutar($sql);
	?>
	<fieldset>
		<legend><center>Vista: ASIGNACIÓN</center></legend>		
		<div id="paginador" class="enjoy-css"> 
			<div class="container">
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Código:</th>
							<th>Fecha Asignación:</th>
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
							echo '<td>'.$filas['codigo_asignacion_libro'].'</td>';
							echo '<td>'.$filas['fecha_asignacion'].'</td>';
							echo '<td>'.$filas['responsable'].'</td>';
							for($x=0;$x<count($a);$x++){
						if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
						echo '<td><a href="?asignacion_libro&Opt=3&codigo_asignacion_libro='.$filas['codigo_asignacion_libro'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
						else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
						echo '<td><a href="?asignacion_libro&Opt=4&codigo_asignacion_libro='.$filas['codigo_asignacion_libro'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
							echo '<a href="?asignacion_libro&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
						?>
						<button type="button" id="btnImprimirTodos" class="btn btn-large btn-primary"><i class="icon-download-alt"></i>&nbsp;Descargar Archivo</button>
					</center>

					<div id="Imprimir" style="display:none;">
						<span>Descargar Como:</span>
						<br/><br/>
						<a href="<?php echo  '../pdf/pdf_asignacion.php';?>" target="_blank"> <img src="images/icon-pdf.png" alt="Exportar a PDF" style="width:60px;heigth:60px;float:center;"> </a>
						&nbsp;&nbsp;
						<a href="../excel/excel_asignacion.php" ><img src="images/icon-excel.png" alt="Exportar a Excel" style="width:60px;heigth:60px;float:center;"></a>
				    </div>


				</div>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana Principal
else if($_GET['Opt']=="2"){ // Ventana de Registro
	?>
	<form class="form-horizontal" action="../controllers/control_asignacion_libro.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: ASIGNACIÓN</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_asignacion_libro">Código</label>  
					<div class="controls">  
						<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
						<input class="input-xlarge" title="el Código del asignacion es generado por el sistema" name="codigo_asignacion_libro" id="codigo_asignacion_libro" type="text" readonly /> 
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="fecha_asignacion">Fecha de Asignación</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha de Asignación" name="fecha_asignacion" id="fecha_asignacion" type="text" readonly required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="cedula_persona">Responsable de la Asignación</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Seleccione un responsable" onKeyUp="this.value=this.value.toUpperCase()" name="cedula_persona" id="cedula_persona" type="text" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="observacion">Motivo</label>  
					<div class="controls">  
						<textarea class="input-xlarge" title="Ingrese un Motivo de la asignación" onKeyUp="this.value=this.value.toUpperCase()" name="motivo" id="motivo" type="text"/></textarea>
					</div>  
				</div>  
				<div class="table-responsive">
					<table id='tablaDetAsignacion' class="table-bordered zebra-striped">
						<tr>
							<td><label class="control-label" >Item</label></td>
							<td><label class="control-label" >Cantidad</label></td>
							<td><label class="control-label" >Ubicación Desde</label></td>
							<td><label class="control-label" >Ubicación Hasta</label></td>
							<td><button type="button" onclick="agrega_campos()" class="btn btn-primary"><i class="icon-plus"></i></button></td>
						</tr>
					</table>
				</div>
				<div class="control-group">  
					<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
				</div>  
				<div class="form-actions">
					<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
					<a href="?asignacion_libro"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div> 
			</div>  
		</fieldset>  
	</form>
	<script type="text/javascript">
		var items = document.getElementsByName('items[]');
		var cantidad = document.getElementsByName('cantidad[]');
		var ubicacion = document.getElementsByName('ubicacion[]');
		var ubicacion_hasta = document.getElementsByName('ubicacion_hasta[]');
		var contador=items.length;
		function agrega_campos(){
			$("#tablaDetAsignacion").append("<tr id='"+contador+"'>"+
			"<td>"+
			"<input type='text' name='items[]' id='items_"+contador+"' onKeyPress='return ACDataGrid(this.id,\"inv_libros.php\")' onKeyUp='this.value=this.value.toUpperCase()' title='Seleccione un Item'>"+
			"</td>"+
			"<td>"+
			"<input type='text' name='cantidad[]' id='cantidad_"+contador+"' onKeyPress='return isNumberKey(event)' maxlength=3 title='Ingrese una cantidad'>"+
			"</td>"+
			"<td>"+
			"<input type='text' name='ubicacion[]' id='ubicacion_"+contador+"' onKeyPress='return ACDataGrid(this.id,\"inv_ubicacion_libros_nodefectuosos.php\")' onKeyUp='this.value=this.value.toUpperCase()' title='Seleccione una Ubicación'>"+
			"</td>"+
			"<td>"+
			"<input type='text' name='ubicacion_hasta[]' id='ubicacion_hasta_"+contador+"' onKeyPress='return ACDataGrid(this.id,\"ubicacion_libros.php\")' onKeyUp='this.value=this.value.toUpperCase()' title='Seleccione una Ubicación Destino'>"+
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
			for(var i=0;i<items.length;i++){
				items[i].removeAttribute('id');
				cantidad[i].removeAttribute('id');
				ubicacion[i].removeAttribute('id');
				ubicacion_hasta[i].removeAttribute('id');
			}
			for(var i=0;i<items.length;i++){
				items[i].setAttribute('id','items_'+i);
				cantidad[i].setAttribute('id','cantidad_'+i);
				ubicacion[i].setAttribute('id','ubicacion_'+i);
				ubicacion_hasta[i].setAttribute('id','ubicacion_hasta_'+i);
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
						url = "../pdf/pdf_formato_asignacion_libro.php?p1='.$_SESSION['datos']['codigo_asignacion_libro'].'";
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
	$sql = "SELECT *,TO_CHAR(fecha_asignacion,'DD/MM/YYYY') as fecha_asignacion 
	FROM biblioteca.tasignacion_libro 
	WHERE codigo_asignacion_libro=".$pgsql->comillas_inteligentes($_GET['codigo_asignacion_libro']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<form class="form-horizontal" action="../controllers/control_asignacion_libro.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: ASIGNACIÓN</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_asignacion_libro">Código</label>  
					<div class="controls">
						<input type="hidden" id="lOpt" name="lOpt" value="Modificar">  
						<input class="input-xlarge" title="el Código del asignacion es generado por el sistema" name="codigo_asignacion_libro" id="codigo_asignacion_libro" type="text" value="<?=$row['codigo_asignacion_libro']?>" readonly /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="fecha_asignacion">Fecha de Asignación</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha de nacimiento de la persona" name="fecha_asignacion" id="fecha_asignacion" type="text" value="<?=$row['fecha_asignacion']?>" readonly required />
					</div>  
				</div> 
				<div class="control-group">  
					<label class="control-label" for="cedula_persona">Responsable de la Asignación</label>  
					<div class="controls">  
						<select class="selectpicker" data-live-search="true" title="Seleccione un responsable" name='cedula_persona' id='cedula_persona' required >
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
					<label class="control-label" for="observacion">Motivo</label>  
					<div class="controls">  
						<textarea class="input-xlarge" title="Ingrese un Motivo de la asignación" onKeyUp="this.value=this.value.toUpperCase()" name="motivo" id="motivo" type="text"/><?php echo $row['motivo']; ?></textarea>
					</div>  
				</div> 
				<div class="control-group">  
					<?php if($row['estatus']=='1'){echo "<p id='estatus' class='Activo'>Activo </p>";}else{echo "<p id='estatus' class='Desactivado'>Desactivado</p>";} ?>
				</div>
				<div class="table-responsive">
					<table id='tablaDetAsignacion' class="table-bordered zebra-striped">
						<tr>
							<td><label class="control-label" >Item</label></td>
							<td><label class="control-label" >Cantidad</label></td>
							<td><label class="control-label" >Ubicación Desde</label></td>
							<td><label class="control-label" >Ubicación Hasta</label></td>
							<td><button type="button" onclick="agrega_campos()" class="btn btn-primary"><i class="icon-plus"></i></button></td>
						</tr>
						<?php
							$pgsql=new Conexion();
							$sql = "SELECT da.codigo_item||'_'||e.codigo_cra||' - '||e.numero_edicion||' - '||l.titulo AS item, 
							da.cantidad,da.codigo_ubicacion||'_'||u.descripcion AS ubicacion,
							da.codigo_ubicacion_hasta||'_'||uh.descripcion AS ubicacion_hasta 
							FROM biblioteca.tdetalle_asignacion_libro da 
							INNER JOIN biblioteca.tejemplar e ON da.codigo_item = e.codigo_ejemplar 
							LEFT JOIN biblioteca.tlibro l ON e.codigo_isbn_libro = l.codigo_isbn_libro 
							INNER JOIN inventario.tubicacion u ON da.codigo_ubicacion = u.codigo_ubicacion 
							INNER JOIN inventario.tubicacion uh ON da.codigo_ubicacion_hasta = uh.codigo_ubicacion 
							WHERE da.codigo_asignacion_libro = '".$row['codigo_asignacion_libro']."' 
							ORDER BY da.codigo_detalle_asignacion_libro ASC";
							$query = $pgsql->Ejecutar($sql);
							$con=0;
							while ($row = $pgsql->Respuesta($query)){
								echo "<tr id='".$con."'>
								        <td>
										<input type='text' name='items[]' id='items_".$con."' onKeyPress='return ACDataGrid(this.id,\"inv_libros.php\")' onKeyUp='this.value=this.value.toUpperCase()' title='Seleccione un Item' value='".$row['item']."'>
								        </td>
								        <td>
								        <input type='text' name='cantidad[]' id='cantidad_".$con."' onKeyPress='return isNumberKey(event)' maxlength=3 title='Ingrese una cantidad' value='".$row['cantidad']."' >
								        </td>
								        <td>
								        <input type='text' name='ubicacion[]' id='ubicacion_".$con."' onKeyPress='return ACDataGrid(this.id,\"inv_ubicacion_libros_nodefectuosos.php\")' onKeyUp='this.value=this.value.toUpperCase()' title='Seleccione una Ubicación' value='".$row['ubicacion']."'>
								        </td>
								        <td>
								        <input type='text' name='ubicacion_hasta[]' id='ubicacion_hasta_".$con."' onKeyPress='return ACDataGrid(this.id,\"ubicacion_libros.php\")' onKeyUp='this.value=this.value.toUpperCase()' title='Seleccione una Ubicación Destino' value='".$row['ubicacion_hasta']."'>
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
					<a href="?asignacion_libro"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div>  
			</div>  
		</fieldset>  
	</form>
	<script type="text/javascript">
		var items = document.getElementsByName('items[]');
		var cantidad = document.getElementsByName('cantidad[]');
		var ubicacion = document.getElementsByName('ubicacion[]');
		var ubicacion_hasta = document.getElementsByName('ubicacion_hasta[]');
		var contador=items.length;
		function agrega_campos(){
			$("#tablaDetasignacion").append("<tr id='"+contador+"'>"+
			"<td>"+
			"<input type='text' name='items[]' id='items_"+contador+"' onKeyPress='return ACDataGrid(this.id,\"inv_libros.php\")' onKeyUp='this.value=this.value.toUpperCase()' title='Seleccione un Item'>"+
			"</td>"+
			"<td>"+
			"<input type='text' name='cantidad[]' id='cantidad_"+contador+"' onKeyPress='return isNumberKey(event)' maxlength=3 title='Ingrese una cantidad'>"+
			"</td>"+
			"<td>"+
			"<input type='text' name='ubicacion[]' id='ubicacion_"+contador+"' onKeyPress='return ACDataGrid(this.id,\"inv_ubicacion_libros_nodefectuosos.php\")' onKeyUp='this.value=this.value.toUpperCase()' title='Seleccione una Ubicación'>"+
			"</td>"+
			"<td>"+
			"<input type='text' name='ubicacion_hasta[]' id='ubicacion_hasta_"+contador+"' onKeyPress='return ACDataGrid(this.id,\"ubicacion_libros.php\")' onKeyUp='this.value=this.value.toUpperCase()' title='Seleccione una Ubicación Destino'>"+
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
			for(var i=0;i<items.length;i++){
				items[i].removeAttribute('id');
				cantidad[i].removeAttribute('id');
				ubicacion[i].removeAttribute('id');
				ubicacion_hasta[i].removeAttribute('id');
			}
			for(var i=0;i<items.length;i++){
				items[i].setAttribute('id','items_'+i);
				cantidad[i].setAttribute('id','cantidad_'+i);
				ubicacion[i].setAttribute('id','ubicacion_'+i);
				ubicacion_hasta[i].setAttribute('id','ubicacion_hasta_'+i);
			}
		}
	</script>
	<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	$pgsql=new Conexion();
	$sql = "SELECT a.codigo_asignacion_libro,TO_CHAR(a.fecha_asignacion,'DD/MM/YYYY') AS fecha_asignacion,
	p.cedula_persona||' - '||p.primer_nombre||' '||p.primer_apellido AS responsable,
	e.codigo_cra||' - '||e.numero_edicion||' - '||l.titulo AS item,da.cantidad,a.motivo  
	FROM biblioteca.tasignacion_libro a 
	INNER JOIN general.tpersona p ON a.cedula_persona = p.cedula_persona 
	INNER JOIN biblioteca.tdetalle_asignacion_libro da ON a.codigo_asignacion_libro = da.codigo_asignacion_libro 
	INNER JOIN biblioteca.tejemplar e ON da.codigo_item = e.codigo_ejemplar 
	INNER JOIN biblioteca.tlibro l ON e.codigo_isbn_libro = l.codigo_isbn_libro 
	WHERE a.codigo_asignacion_libro =".$pgsql->comillas_inteligentes($_GET['codigo_asignacion_libro']);
	$query = $pgsql->Ejecutar($sql);
	while($obj=$pgsql->Respuesta($query)){
		$row[]=$obj;
	}
	?>
	<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
	<fieldset>
		<legend><center>Vista: ASIGNACIÓN</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="printer">
				<table class="bordered-table zebra-striped" >
					<tr>
						<td>
							<label>Código:</label>
						</td>
						<td>
							<label><?=$row[0]['codigo_asignacion_libro']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Fecha Adquisición:</label>
						</td>
						<td>
							<label><?=$row[0]['fecha_asignacion']?></label>
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
							<label>Motivo:</label>
						</td>
						<td>
							<label><?=$row[0]['motivo']?></label>
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
					<a href="?asignacion_libro"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</center>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana de Impresiones
?>