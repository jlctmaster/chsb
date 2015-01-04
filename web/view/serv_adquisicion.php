<script type="text/javascript" src="js/chsb_adquisicion.js"></script>
<?php
require_once("../class/class_perfil.php");
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('adquisicion');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT codigo_adquisicion,TO_CHAR(fecha_adquisicion,'DD/MM/YYYY') AS fecha_adquisicion,
	CASE tipo_adquisicion WHEN '1' THEN 'DONACIÓN' WHEN '2' THEN 'COMPRA' WHEN '3' THEN 'RECURSOS DEL MINISTERIO' ELSE 'OTROS' END AS tipo_adquisicion
	FROM inventario.tadquisicion";
	$consulta = $pgsql->Ejecutar($sql);
	?>
	<fieldset>
		<legend><center>Vista: ADQUISICIÓN</center></legend>		
		<div id="paginador" class="enjoy-css"> 
			<div class="container">
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Código:</th>
							<th>Fecha Adquisición:</th>
							<th>Tipo Adquisición:</th>
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
							echo '<td>'.$filas['codigo_adquisicion'].'</td>';
							echo '<td>'.$filas['fecha_adquisicion'].'</td>';
							echo '<td>'.$filas['tipo_adquisicion'].'</td>';
							for($x=0;$x<count($a);$x++){
						if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
						echo '<td><a href="?adquisicion&Opt=3&codigo_adquisicion='.$filas['codigo_adquisicion'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
						else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
						echo '<td><a href="?adquisicion&Opt=4&codigo_adquisicion='.$filas['codigo_adquisicion'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
							echo '<a href="?adquisicion&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
						?>
						<button type="button" id="btnImprimirTodos" class="btn btn-large btn-primary"><i class="icon-download-alt"></i>&nbsp;Descargar Archivo</button>
					</center>

					<div id="Imprimir" style="display:none;">
						<span>Descargar Como:</span>
						<br/><br/>
						<a href="<?php echo  '../pdf/pdf_adquisicion.php';?>" target="_blank"> <img src="images/icon-pdf.png" alt="Exportar a PDF" style="width:60px;heigth:60px;float:center;"> </a>
						&nbsp;&nbsp;
						<a href="../excel/excel_adquisicion.php" ><img src="images/icon-excel.png" alt="Exportar a Excel" style="width:60px;heigth:60px;float:center;"></a>
				    </div>


				</div>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana Principal
else if($_GET['Opt']=="2"){ // Ventana de Registro
	?>
	<form class="form-horizontal" action="../controllers/control_adquisicion.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: ADQUISICIÓN</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_adquisicion">Código</label>  
					<div class="controls">  
						<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
						<input class="input-xlarge" title="el Código del adquisicion es generado por el sistema" name="codigo_adquisicion" id="codigo_adquisicion" type="text" readonly /> 
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="fecha_adquisicion">Fecha de Adquisición</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha de adquisición" name="fecha_adquisicion" id="fecha_adquisicion" type="text" readonly required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="tipo_adquisicion">Tipo Adquisición</label>  
					<div class="controls">  
						<select class="selectpicker" data-live-search="true" name="tipo_adquisicion" id="tipo_adquisicion" title="Seleccione un tipo de adquisición" required /> 
			              <option value=0>Seleccione un Tipo de Adquisición</option>
			              <option value="1" >DONACIÓN</option>
			              <option value="2" >COMPRA</option>	
			              <option value="3" >RECURSOS DEL MINISTERIO</option>
			              <option value="4" >OTROS</option>			
			             </select>
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="rif_organizacion">Organización</label>  
					<div class="controls">  
						<select class="selectpicker" data-live-search="true" title="Seleccione una organización" name='rif_organizacion' id='rif_organizacion' required >
							<option value=0>Seleccione una Organización</option>
							<?php
								require_once('../class/class_bd.php');
								$pgsql = new Conexion();
								$sql = "SELECT * FROM general.torganizacion ORDER BY nombre ASC";
								$query = $pgsql->Ejecutar($sql);
								while($row=$pgsql->Respuesta($query)){
									echo "<option value=".$row['rif_organizacion'].">".$row['nombre']."</option>";
								}
							?>
						</select>
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="cedula_persona">Responsable de la Adquisición</label>  
					<div class="controls">  
						<select class="selectpicker" data-live-search="true" title="Seleccione un responsable" name='cedula_persona' id='cedula_persona' required >
							<option value=0>Seleccione un Responsable</option>
							<?php
								require_once('../class/class_bd.php');
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
					<label class="control-label" for="sonlibros">¿Son libros?</label>  
					<div class="controls">  
						<div class="radios">
							<input type="checkbox" title="Si el check está marcado indica que la adquisición son libros" name="sonlibros" id="sonlibros" >
						</div>
					</div>  
				</div>
				<div class="table-responsive">
					<table id='tablaDetAdquisicion' class="table-bordered zebra-striped">
						<tr>
							<td><label class="control-label" >Item</label></td>
							<td><label class="control-label" >Cantidad</label></td>
							<td><label class="control-label" >Ubicación</label></td>
							<td><button type="button" onclick="agrega_campos()" class="btn btn-primary"><i class="icon-plus"></i></button></td>
						</tr>
					</table>
				</div>
				<div class="control-group">  
					<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
				</div>  
				<div class="form-actions">
					<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
					<a href="?adquisicion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div> 
			</div>  
		</fieldset>  
	</form>
	<script type="text/javascript">
		var where = "WHERE tablename='tbien' ";
		$('#sonlibros').change(function(){
			if($('#sonlibros').is(":checked"))
				where ="WHERE tablename='tejemplar' ";
			else
				where ="WHERE tablename='tbien' ";
		});
		var items = document.getElementsByName('items[]');
		var cantidad = document.getElementsByName('cantidad[]');
		var ubicacion = document.getElementsByName('ubicacion[]');
		var contador=items.length;
		function agrega_campos(){
			$("#tablaDetAdquisicion").append("<tr id='"+contador+"'>"+
			"<td>"+
			"<select class='bootstrap-select form-control' name='items[]' id='items_"+contador+"' title='Seleccione un items'>"+
			<?php
			require_once("../class/class_bd.php");
			$pgsql=new Conexion();
			$sql = "SELECT * FROM 
			(SELECT codigo_bien AS codigo_item, nombre AS nombre_item, 'tbien' AS tablename FROM bienes_nacionales.tbien WHERE estatus = '1'
			UNION
			SELECT e.codigo_ejemplar AS codigo_item, e.numero_edicion||' '||l.titulo AS nombre_item, 'tejemplar' AS tablename FROM biblioteca.tejemplar e INNER JOIN biblioteca.tlibro l ON e.codigo_isbn_libro = l.codigo_isbn_libro) items 
			ORDER BY codigo_item ASC,tablename DESC";
			$query = $pgsql->Ejecutar($sql);
			$comillasimple=chr(34);
			while ($rows = $pgsql->Respuesta($query)){
				echo $comillasimple."<option value='".$rows['codigo_item']."'>".$rows['nombre_item']."</option>".$comillasimple."+";
			}
			?>
			"</select>"+
			"</td>"+
			"<td>"+
			"<input type='text' name='cantidad[]' id='cantidad_"+contador+"' onKeyPress='return isNumberKey(event)' maxlength=3 title='Ingrese una cantidad'>"+
			"</td>"+
			"<td>"+
			"<select class='bootstrap-select form-control' name='ubicacion[]' id='ubicacion_"+contador+"' title='Seleccione una Ubicación'>"+
			<?php
			require_once("../class/class_bd.php");
			$pgsql=new Conexion();
			$sql = "SELECT * FROM inventario.tubicacion WHERE estatus = '1'";
			$query = $pgsql->Ejecutar($sql);
			$comillasimple=chr(34);
			while ($rows = $pgsql->Respuesta($query)){
				echo $comillasimple."<option value='".$rows['codigo_ubicacion']."'>".$rows['descripcion']."</option>".$comillasimple."+";
			}
			?>
			"</select>"+
			"</td>"+
			"<td>"+
			"<button type='button' class='btn btn-primary' onclick='elimina_me("+contador+")'><i class='icon-minus'></i></button>"+
			"</td>"+
			"</tr>");
			contador++;
		}

		function elimina_me(elemento){
			$("#"+elemento).remove();
			for(var i=0;i<items.length;i++){
				items[i].removeAttribute('id');
				cantidad[i].removeAttribute('id');
				ubicacion[i].removeAttribute('id');
			}
			for(var i=0;i<items.length;i++){
				items[i].setAttribute('id','items_'+i);
				cantidad[i].setAttribute('id','cantidad_'+i);
				ubicacion[i].setAttribute('id','ubicacion_'+i);
			}
		}
	</script>
	<?php
} // Ventana de Registro
else if($_GET['Opt']=="3"){ // Ventana de Modificaciones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT *,TO_CHAR(fecha_adquisicion,'DD/MM/YYYY') as fecha_adquisicion 
	FROM inventario.tadquisicion 
	WHERE codigo_adquisicion=".$pgsql->comillas_inteligentes($_GET['codigo_adquisicion']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<form class="form-horizontal" action="../controllers/control_adquisicion.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: ADQUISICIÓN</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_adquisicion">Código</label>  
					<div class="controls">
						<input type="hidden" id="lOpt" name="lOpt" value="Modificar">  
						<input class="input-xlarge" title="el Código del adquisicion es generado por el sistema" name="codigo_adquisicion" id="codigo_adquisicion" type="text" value="<?=$row['codigo_adquisicion']?>" readonly /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="fecha_adquisicion">Fecha de Adquisición</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha de nacimiento de la persona" name="fecha_adquisicion" id="fecha_adquisicion" type="text" value="<?=$row['fecha_adquisicion']?>" readonly required />
					</div>  
				</div> 
				<div class="control-group">  
					<label class="control-label" for="tipo_adquisicion">Tipo Adquición</label>  
					<div class="controls">  
						<select class="selectpicker" data-live-search="true" name="tipo_adquisicion" id="tipo_adquisicion" title="Seleccione un tipo de adquisición" required /> 
			              <option value=0>Seleccione un Tipo de Adquisición</option>
			              <option value="1" <?php if($row['tipo_adquisicion']=="1") {echo "selected";} ?>>DONACIÓN</option>
			              <option value="2" <?php if($row['tipo_adquisicion']=="2") {echo "selected";} ?>>COMPRA</option>	
			              <option value="3" <?php if($row['tipo_adquisicion']=="3") {echo "selected";} ?>>RECURSOS DEL MINISTERIO</option>
			              <option value="4" <?php if($row['tipo_adquisicion']=="4") {echo "selected";} ?>>OTROS</option>			
			             </select>
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="rif_organizacion">Organización</label>  
					<div class="controls">  
						<select class="selectpicker" data-live-search="true" title="Seleccione una Organización" name='rif_organizacion' id='rif_organizacion' required >
							<option value=0>Seleccione una Organización</option>
							<?php
								require_once('../class/class_bd.php');
								$pgsql = new Conexion();
								$sql = "SELECT * FROM general.torganizacion ORDER BY nombre ASC";
								$query = $pgsql->Ejecutar($sql);
								while($rows=$pgsql->Respuesta($query)){
									if($rows['rif_organizacion']==$row['rif_organizacion'])
										echo "<option value=".$rows['rif_organizacion']." selected >".$rows['nombre']."</option>";
									else
										echo "<option value=".$row['rif_organizacion'].">".$row['nombre']."</option>";
								}
							?>
						</select>
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="cedula_persona">Responsable de la Adquisición</label>  
					<div class="controls">  
						<select class="selectpicker" data-live-search="true" title="Seleccione un responsable" name='cedula_persona' id='cedula_persona' required >
							<option value=0>Seleccione un Responsable</option>
							<?php
								require_once('../class/class_bd.php');
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
					<label class="control-label" for="sonlibros">¿Son libros?</label>  
					<div class="controls">  
						<div class="radios">
							<input type="checkbox" title="Si el check está marcado indica que la adquisición son libros" name="sonlibros" id="sonlibros" <?php if($row['sonlibros']=="Y"){echo "checked='checked'";} ?> >
						</div>
					</div>  
				</div>
				<div class="control-group">  
					<?php if($row['estatus']=='1'){echo "<p id='estatus' class='Activo'>Activo </p>";}else{echo "<p id='estatus' class='Desactivado'>Desactivado</p>";} ?>
				</div>
				<div class="table-responsive">
					<table id='tablaDetAdquisicion' class="table-bordered zebra-striped">
						<tr>
							<td><label class="control-label" >Item</label></td>
							<td><label class="control-label" >Cantidad</label></td>
							<td><label class="control-label" >Ubicación</label></td>
							<td><button type="button" onclick="agrega_campos()" class="btn btn-primary"><i class="icon-plus"></i></button></td>
						</tr>
						<?php
							$clausulaWhere="";
							if($row['sonlibros']=='Y')
								$clausulaWhere="WHERE tablename='tejemplar' ";
							else
								$clausulaWhere="WHERE tablename='tbien' ";
							$pgsql=new Conexion();
							$sql = "SELECT da.codigo_item, da.cantidad, da.codigo_ubicacion
							FROM inventario.tdetalle_adquisicion da WHERE da.codigo_adquisicion = '".$row['codigo_adquisicion']."' 
							ORDER BY da.codigo_detalle_adquisicion ASC";
							$query = $pgsql->Ejecutar($sql);
							$con=0;
							while ($row = $pgsql->Respuesta($query)){
								echo "<tr id='".$con."'>
								        <td>
								          <select class='bootstrap-select form-control' name='items[]' id='items_".$con."' title='Seleccione un Item' >
								          <option value='0'>Seleccione un Item</option>";
								          $sqlx = "SELECT * FROM 
										  (SELECT codigo_bien AS codigo_item, nombre AS nombre_item, 'tbien' AS tablename FROM bienes_nacionales.tbien WHERE estatus = '1'
										  UNION
										  SELECT e.codigo_ejemplar AS codigo_item, l.titulo AS nombre_item, 'tejemplar' AS tablename FROM biblioteca.tejemplar e INNER JOIN biblioteca.tlibro l ON e.codigo_isbn_libro = l.codigo_isbn_libro) items 
										  $clausulaWhere
										  ORDER BY codigo_item ASC,tablename DESC";
								          $querys = $pgsql->Ejecutar($sqlx);
								          while ($rows = $pgsql->Respuesta($querys)){
								            if($rows['codigo_item']==$row['codigo_item']){
								              echo "<option value='".$rows['codigo_item']."' selected>".$rows['nombre_item']."</option>";
								            }else{
								              echo "<option value='".$rows['codigo_item']."'>".$rows['codigo_item']."</option>";
								            }
								          }
								          echo "</select>
								        </td>
								        <td>
								        <input type='text' name='cantidad[]' id='cantidad_".$con."' onKeyPress='return isNumberKey(event)' maxlength=3 title='Ingrese una cantidad' value='".$row['cantidad']."' >
								        </td>
								        <td>
								        <select class='bootstrap-select form-control' name='ubicacion[]' id='ubicacion_".$con."' title='Seleccione un Item' >
								        <option value='0'>Seleccione un Item</option>";
								        $sqlz="SELECT * FROM inventario.tubicacion WHERE estatus = '1'";
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
								          <button type='button' class='btn btn-primary' onclick='elimina_me('".$con."')'><i class='icon-minus'></i></button>
								        </td>
								      </tr>";
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
					<button type="button" id="btnPrintReport" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Formato de Impresión</button>';

					<a href="?adquisicion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div>  
			</div>  
		</fieldset>  
	</form>
	<script type="text/javascript">
		var where = "WHERE tablename='tbien' ";
		$('#sonlibros').change(function(){
			if($('#sonlibros').is(":checked"))
				where ="WHERE tablename='tejemplar' ";
			else
				where ="WHERE tablename='tbien' ";
		});
		var items = document.getElementsByName('items[]');
		var cantidad = document.getElementsByName('cantidad[]');
		var ubicacion = document.getElementsByName('ubicacion[]');
		var contador=items.length;
		function agrega_campos(){
			$("#tablaDetAdquisicion").append("<tr id='"+contador+"'>"+
			"<td>"+
			"<select class='bootstrap-select form-control' name='items[]' id='items_"+contador+"' title='Seleccione un items'>"+
			<?php
			require_once("../class/class_bd.php");
			$pgsql=new Conexion();
			$sql = "SELECT * FROM 
			(SELECT codigo_bien AS codigo_item, nombre AS nombre_item, 'tbien' AS tablename FROM bienes_nacionales.tbien WHERE estatus = '1'
			UNION
			SELECT e.codigo_ejemplar AS codigo_item, l.titulo AS nombre_item, 'tejemplar' AS tablename FROM biblioteca.tejemplar e INNER JOIN biblioteca.tlibro l ON e.codigo_isbn_libro = l.codigo_isbn_libro) items 
			ORDER BY codigo_item ASC,tablename DESC";
			$query = $pgsql->Ejecutar($sql);
			$comillasimple=chr(34);
			while ($rows = $pgsql->Respuesta($query)){
				echo $comillasimple."<option value='".$rows['codigo_item']."'>".$rows['nombre_item']."</option>".$comillasimple."+";
			}
			?>
			"</select>"+
			"</td>"+
			"<td>"+
			"<input type='text' name='cantidad[]' id='cantidad_"+contador+"' onKeyPress='return isNumberKey(event)' maxlength=3 title='Ingrese una cantidad'>"+
			"</td>"+
			"<td>"+
			"<select class='bootstrap-select form-control' name='ubicacion[]' id='ubicacion_"+contador+"' title='Seleccione una Ubicación'>"+
			<?php
			require_once("../class/class_bd.php");
			$pgsql=new Conexion();
			$sql = "SELECT * FROM inventario.tubicacion WHERE estatus = '1'";
			$query = $pgsql->Ejecutar($sql);
			$comillasimple=chr(34);
			while ($rows = $pgsql->Respuesta($query)){
				echo $comillasimple."<option value='".$rows['codigo_ubicacion']."'>".$rows['descripcion']."</option>".$comillasimple."+";
			}
			?>
			"</select>"+
			"</td>"+
			"<td>"+
			"<button type='button' class='btn btn-primary' onclick='elimina_me("+contador+")'><i class='icon-minus'></i></button>"+
			"</td>"+
			"</tr>");
			contador++;
		}

		function elimina_me(elemento){
			$("#"+elemento).remove();
			for(var i=0;i<items.length;i++){
				items[i].removeAttribute('id');
				cantidad[i].removeAttribute('id');
				ubicacion[i].removeAttribute('id');
			}
			for(var i=0;i<items.length;i++){
				items[i].setAttribute('id','items_'+i);
				cantidad[i].setAttribute('id','cantidad_'+i);
				ubicacion[i].setAttribute('id','ubicacion_'+i);
			}
		}
	</script>
	<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT a.codigo_adquisicion,TO_CHAR(a.fecha_adquisicion,'DD/MM/YYYY') AS fecha_adquisicion,
	CASE a.tipo_adquisicion WHEN '1' THEN 'DONACIÓN' WHEN '2' THEN 'COMPRA' WHEN '3' THEN 'RECURSOS DEL MINISTERIO' ELSE 'OTROS' END AS tipo_adquisicion, 
	o.rif_organizacion||' - '||o.nombre AS organizacion, p.cedula_persona||' - '||p.primer_nombre||' '||p.primer_apellido AS responsable,
	CASE a.sonlibros WHEN 'N' THEN b.nro_serial||' '||b.nombre WHEN 'Y' THEN e.codigo_isbn_libro||' - '||e.numero_edicion||' - '||l.titulo ELSE null END AS item,
	da.cantidad 
	FROM inventario.tadquisicion a 
	INNER JOIN general.torganizacion o ON a.rif_organizacion = o.rif_organizacion 
	INNER JOIN general.tpersona p ON a.cedula_persona = p.cedula_persona 
	INNER JOIN inventario.tdetalle_adquisicion da ON a.codigo_adquisicion = da.codigo_adquisicion 
	LEFT JOIN bienes_nacionales.tbien b ON da.codigo_item = b.codigo_bien AND a.sonlibros ='N' 
	LEFT JOIN biblioteca.tejemplar e ON da.codigo_item = e.codigo_ejemplar AND a.sonlibros = 'Y' 
	LEFT JOIN biblioteca.tlibro l ON e.codigo_isbn_libro = l.codigo_isbn_libro 
	WHERE a.codigo_adquisicion =".$pgsql->comillas_inteligentes($_GET['codigo_adquisicion']);
	$query = $pgsql->Ejecutar($sql);
	while($obj=$pgsql->Respuesta($query)){
		$row[]=$obj;
	}
	?>
	<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
	<fieldset>
		<legend><center>Vista: ADQUISICIÓN</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="printer">
				<table class="bordered-table zebra-striped" >
					<tr>
						<td>
							<label>Código:</label>
						</td>
						<td>
							<label><?=$row[0]['codigo_adquisicion']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Fecha Adquisición:</label>
						</td>
						<td>
							<label><?=$row[0]['fecha_adquisicion']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Tipo Adquisición:</label>
						</td>
						<td>
							<label><?=$row[0]['tipo_adquisicion']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Organización:</label>
						</td>
						<td>
							<label><?=$row[0]['organizacion']?></label>
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
					<a href="?adquisicion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</center>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana de Impresiones
?>