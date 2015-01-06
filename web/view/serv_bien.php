<script type="text/javascript" src="js/chsb_bien.js"></script>
<?php
require_once("../class/class_perfil.php");
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('bien');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT b.codigo_bien, b.nombre, b.nro_serial, tb.descripcion AS tipo_bien 
	FROM bienes_nacionales.tbien b 
	INNER JOIN bienes_nacionales.ttipo_bien tb ON b.codigo_tipo_bien = tb.codigo_tipo_bien";
	$consulta = $pgsql->Ejecutar($sql);
?>
<fieldset>
	<legend><center>BIEN</center></legend>
	<div id="paginador" class="enjoy-css">
		<div class="container">
			<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
				<thead>
					<tr>
						<th>Código</th>
						<th>Nombre del Bien Nacional</th>
						<th>Serial del Bien Nacional</th>
						<th>Tipo Bien Nacional</th>
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
						echo '<td>'.$filas['codigo_bien'].'</td>';
						echo '<td>'.$filas['nombre'].'</td>';
						echo '<td>'.$filas['nro_serial'].'</td>';
						echo '<td>'.$filas['tipo_bien'].'</td>';
						for($x=0;$x<count($a);$x++){
							if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
								echo '<td><a href="?bien&Opt=3&codigo_bien='.$filas['codigo_bien'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
							else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
								echo '<td><a href="?bien&Opt=4&codigo_bien='.$filas['codigo_bien'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
						echo '<a href="?bien&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
				?>
				<button type="button" id="btnImprimirTodos" class="btn btn-large btn-primary"><i class="icon-download-alt"></i>&nbsp;Descargar Archivo</button>				
			</center>
			<div id="Imprimir" style="display:none;">
				<span>Descargar Como:</span>
				<br/><br/>
				<a href="<?php echo  '../pdf/pdf_bien.php';?>" target="_blank"> <img src="images/icon-pdf.png" alt="Exportar a PDF" style="width:60px;heigth:60px;float:center;"> </a>
				&nbsp;&nbsp;
				<a href="../excel/excel_bien.php" ><img src="images/icon-excel.png" alt="Exportar a Excel" style="width:60px;heigth:60px;float:center;"></a>
    		</div>
		</div>
	</div>
</fieldset>
<?php
} // Fin Ventana Principal
else if($_GET['Opt']=="2"){ // Ventana de Registro
?>
<form class="form-horizontal" action="../controllers/control_bien.php" method="post" id="form1">  
<fieldset>
	<legend><center>BIEN</center></legend>
		<div id="paginador" class="enjoy-css">
	<div class="control-group">  
		<label class="control-label" for="codigo_bien">Código</label>  
		<div class="controls">  
			<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
			<input class="input-xlarge" title="el Código del bien es generado por el sistema" name="codigo_bien" id="codigo_bien" type="text" readonly /> 
		</div>  
	</div>   
	<div class="control-group">  
		<label class="control-label" for="nombre">Nombre del Bien</label>  
		<div class="controls">  
			<input class="input-xlarge" title="Ingrese el nombre del bien" onKeyUp="this.value=this.value.toUpperCase()" name="nombre" id="nombre" type="text" size="50" required />
		</div>  
	</div>
	<div class="control-group">  
		<label class="control-label" for="nro_serial">Serial del Bien</label>  
		<div class="controls">  
			<input class="input-xlarge" title="Ingrese el Serial del bien" onKeyUp="this.value=this.value.toUpperCase()" name="nro_serial" id="nro_serial" type="text" size="50" required />
		</div>  
	</div>    
	<div class="control-group">  
		<label class="control-label" for="codigo_tipo_bien">Tipo del Bien Nacional</label>  
		<div class="controls">  
			<select class="selectpicker" data-live-search="true" title="Seleccione un Tipo Bien Nacional" name='codigo_tipo_bien' id='codigo_tipo_bien' required >
				<option value=0>Seleccione un Tipo Bien Nacional</option>
				<?php
					require_once('../class/class_bd.php');
					$pgsql = new Conexion();
					$sql = "SELECT * FROM bienes_nacionales.ttipo_bien ORDER BY descripcion ASC";
					$query = $pgsql->Ejecutar($sql);
					while($row=$pgsql->Respuesta($query)){
						echo "<option value=".$row['codigo_tipo_bien'].">".$row['descripcion']."</option>";
					}
				?>
			</select>
		</div>
	</div>   
	<div class="control-group">  
		<label class="control-label" for="esconfigurable">¿Es Configurable? </label>  
		<div class="controls">  
			<div class="radios">
				<input type="checkbox" title="Si el Check está marcado puede ser usuario del sistema" name="esconfigurable" id="esconfigurable" required />
			</div>
		</div>
	</div> 
	<br>
	<div class="table-responsive">
		<table id='tablaBienes' class="table-bordered zebra-striped" style="display:none">
		<tr>
			<td><label class="control-label" >Componente</label></td>
			<td><label class="control-label" >Cantidad</label></td>
			<td><label class="control-label" >¿Componente Base?</label></td>
			<td><button type="button" onclick="agrega_campos()" class="btn btn-primary"><i class="icon-plus"></i></button></td>
		</tr>
		</table>
	</div>
	<div class="control-group">  
		<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
	</div>
	<div class="form-actions">
		<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
		<a href="?bien"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
	</div>  
	</fieldset>
</form>
<script type="text/javascript">
	var items = document.getElementsByName('items[]');
	var cantidades = document.getElementsByName('cantidades[]');
	var item_base = document.getElementsByName('item_base[]');
	var contador=items.length;
	function agrega_campos(){
		$("#tablaBienes").append("<tr id='"+contador+"'>"+
		"<td>"+
		"<select class='bootstrap-select form-control' name='items[]' id='items_"+contador+"' title='Seleccione un componente'>"+
		<?php
		require_once("../class/class_bd.php");
		$pgsql=new Conexion();
		$sql = "SELECT b.codigo_bien,b.nombre 
 		FROM bienes_nacionales.ttipo_bien tb
 		INNER JOIN bienes_nacionales.tbien b ON tb.codigo_tipo_bien= b.codigo_tipo_bien 
 		WHERE tb.descripcion NOT LIKE '%PRODUCTO TERMINADO%'
		AND b.estatus = '1'
		ORDER BY codigo_bien ASC";
		$query = $pgsql->Ejecutar($sql);
		$comillasimple=chr(34);
		while ($rows = $pgsql->Respuesta($query)){
			echo $comillasimple."<option value='".$rows['codigo_bien']."'>".$rows['nombre']."</option>".$comillasimple."+";
		}
		?>
		"</select>"+
		"</td>"+
		"<td>"+
		"<input type='text' name='cantidades[]' id='cantidades_"+contador+"' onKeyPress='return isNumberKey(event)' maxlength=3 title='Ingrese una cantidad'>"+
		"</td>"+
		"<td>"+
		"<input type='checkbox' name='item_base[]' id='item_base_"+contador+"' title='Seleccione el item base'>"+ 
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
			cantidades[i].removeAttribute('id');
			item_base[i].removeAttribute('id');
		}
		for(var i=0;i<items.length;i++){
			items[i].setAttribute('id','items_'+i);
			cantidades[i].setAttribute('id','cantidades_'+i);
			item_base[i].setAttribute('id','item_base_'+i);
		}
	}
</script>
<?php
} // Ventana de Registro
else if($_GET['Opt']=="3"){ // Ventana de Modificaciones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * FROM bienes_nacionales.tbien WHERE codigo_bien =".$_GET['codigo_bien'];
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
?>
<form class="form-horizontal" action="../controllers/control_bien.php" method="post" id="form1">  
<fieldset>
	<legend><center>BIEN</center></legend>
		<div id="paginador" class="enjoy-css">
	<div class="control-group">  
		<label class="control-label" for="codigo_bien">Código</label>  
		<div class="controls">
			<input type="hidden" id="lOpt" name="lOpt" value="Modificar">  
			<input class="input-xlarge" title="el Código del bien es generado por el sistema" name="codigo_bien" id="codigo_bien" type="text" value="<?=$row['codigo_bien']?>" readonly /> 
		</div>  
	</div>
	<div class="control-group">  
		<label class="control-label" for="nombre">Nombre del Bien</label>  
		<div class="controls">  
			<input class="input-xlarge" title="Ingrese el nombre del bien" onKeyUp="this.value=this.value.toUpperCase()" name="nombre" id="nombre" type="text" value="<?=$row['nombre']?>" required />
		</div>  
	</div>
		<div class="control-group">  
		<label class="control-label" for="nro_serial">Serial del Bien</label>  
		<div class="controls">  
			<input class="input-xlarge" title="Ingrese el serial del bien" onKeyUp="this.value=this.value.toUpperCase()" name="nro_serial" id="nro_serial" type="text" value="<?=$row['nro_serial']?>" required />
		</div>  
	</div>      
	<div class="control-group">  
		<label class="control-label" for="codigo_tipo_bien">Tipo del Bien Nacional</label>  
		<div class="controls">  
			<select class="selectpicker" data-live-search="true" title="Seleccione un Tipo Bien Nacional" name='codigo_tipo_bien' id='codigo_tipo_bien' required >
				<option value=0>Seleccione un Tipo Bien Nacional</option>
				<?php
					require_once('../class/class_bd.php');
					$pgsql = new Conexion();
					$sql = "SELECT * FROM bienes_nacionales.ttipo_bien ORDER BY descripcion ASC";
					$query = $pgsql->Ejecutar($sql);
					while($rows=$pgsql->Respuesta($query)){
						if($rows['codigo_tipo_bien']==$row['codigo_tipo_bien'])
							echo "<option value=".$rows['codigo_tipo_bien']." selected >".$rows['descripcion']."</option>";
						else
							echo "<option value=".$rows['codigo_tipo_bien'].">".$rows['descripcion']."</option>";
					}
				?>
			</select>
		</div>  
	</div>
	<div class="control-group">  
		<label class="control-label" for="esconfigurable"> ¿Es Configurable? </label>  
		<div class="controls">  
			<div class="radios">
				<input type="checkbox" title="Si el Check está marcado es configurable" name="esconfigurable" id="esconfigurable" <?php if($row['esconfigurable']=="Y"){echo "checked='checked'";} ?> >
			</div>
		</div>
	</div> 
	<div class="control-group">  
		<?php if($row['estatus']=='1'){echo "<p id='estatus' class='Activo'>Activo </p>";}else{echo "<p id='estatus' class='Desactivado'>Desactivado</p>";} ?>
	</div> 
	<br>
	<div class="table-responsive">
		<table id='tablaBienes' class="table-bordered zebra-striped" <?php if($row['esconfigurable']=="N"){echo "style='display:none'";} ?> >
			<tr>
				<td><label class="control-label" >Componente</label></td>
				<td><label class="control-label" >Cantidad</label></td>
				<td><label class="control-label" >¿Componente Base?</label></td>
				<td><center><button type="button" onclick="agrega_campos()" class="btn btn-primary"><i class="icon-plus"></i></button></center></td>
			</tr>
			<?php
				$pgsql=new Conexion();
				$sql = "SELECT cb.codigo_item, cb.cantidad, cb.item_base
				FROM bienes_nacionales.tconfiguracion_bien cb WHERE cb.codigo_bien = '".$row['codigo_bien']."' 
				ORDER BY cb.codigo_configuracion_bien ASC";
				$query = $pgsql->Ejecutar($sql);
				$con=0;
				while ($row = $pgsql->Respuesta($query)){
					echo "<tr id='".$con."'>
					        <td>
					          <select class='bootstrap-select form-control' name='items[]' id='items".$con."' title='Seleccione un Componente' >
					          <option value='0'>Seleccione un Componente</option>";
					          $sqlx = "SELECT codigo_bien,nombre FROM bienes_nacionales.tbien WHERE estatus = '1' ORDER BY codigo_bien ASC";
					          $querys = $pgsql->Ejecutar($sqlx);
					          while ($rows = $pgsql->Respuesta($querys)){
					            if($rows['codigo_bien']==$row['codigo_item']){
					              echo "<option value='".$rows['codigo_bien']."' selected>".$rows['nombre']."</option>";
					            }else{
					              echo "<option value='".$rows['codigo_bien']."'>".$rows['nombre']."</option>";
					            }
					          }
					          echo "</select>
					        </td>
					        <td>
					        <input type='text' name='cantidades[]' id='cantidades_".$con."' onKeyPress='return isNumberKey(event)' maxlength=3 title='Ingrese una cantidad' value='".$row['cantidad']."' >
					        </td>
					        <td>
					        <input type='checkbox' name='item_base[]' id='item_base_".$con."' title='Seleccione el item base' ".($row['item_base']=='Y' ? "checked='checked'" : "")." >
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
	<div class="form-actions">
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
		<a href="?bien"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
	</div>  
	</fieldset>  
</form>
<script type="text/javascript">
	var items = document.getElementsByName('items[]');
	var cantidades = document.getElementsByName('cantidades[]');
	var item_base = document.getElementsByName('item_base[]');
	var contador=items.length;
	function agrega_campos(){
		$("#tablaBienes").append("<tr id='"+contador+"'>"+
		"<td>"+
		"<center>"+
		"<select class='bootstrap-select form-control' name='items[]' id='items_"+contador+"' title='Seleccione un componente'>"+
		"<option value='0'>Seleccione un componente</option>"+
		<?php
		require_once("../class/class_bd.php");
		$pgsql=new Conexion();
		$sql = "SELECT codigo_bien,nombre 
 		FROM bienes_nacionales.ttipo_bien tb
 		INNER JOIN bienes_nacionales.tbien b ON tb.codigo_tipo_bien= b.codigo_tipo_bien 
 		WHERE tb.descripcion NOT LIKE '%PRODUCTO TERMINADO%'
		AND b.estatus = '1'
		ORDER BY codigo_bien ASC";
		$query = $pgsql->Ejecutar($sql);
		$comillasimple=chr(34);
		while ($rows = $pgsql->Respuesta($query)){
			echo $comillasimple."<option value='".$rows['codigo_bien']."'>".$rows['nombre']."</option>".$comillasimple."+";
		}
		?>
		"</select>"+
		"</center>"+
		"</td>"+
		"<td>"+
		"<input type='text' name='cantidades[]' id='cantidades_"+contador+"' title='Ingrese una cantidad'>"+
		"</td>"+
		"<td>"+
		"<input type='checkbox' name='item_base[]' id='item_base_"+contador+"' title='Seleccione el item base'>"+ 
		"</td>"+
		"<td>"+
		"<center>"+
		"<button type='button' class='btn btn-primary' onclick='elimina_me("+contador+")'><i class='icon-minus'></i></button>"+
		"</center>"+
		"</td>"+
		"</tr>");
		contador++;
	}

	function elimina_me(elemento){
		$("#"+elemento).remove();
		for(var i=0;i<items.length;i++){
			items[i].removeAttribute('id');
			cantidades[i].removeAttribute('id');
			item_base[i].removeAttribute('id');
		}
		for(var i=0;i<items.length;i++){
			items[i].setAttribute('id','items_'+i);
			cantidades[i].setAttribute('id','cantidades_'+i);
			item_base[i].setAttribute('id','item_base_'+i);
		}
	}
</script>
<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT b.codigo_bien, b.nombre,b.nro_serial, tb.descripcion AS tipo_bien 
	FROM bienes_nacionales.tbien b 
	INNER JOIN bienes_nacionales.ttipo_bien tb ON b.codigo_tipo_bien = tb.codigo_tipo_bien 
	WHERE b.codigo_bien =".$_GET['codigo_bien'];
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
?>
<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
<fieldset>
	<legend><center>BIEN</center></legend>
	<div id="paginador" class="enjoy-css">
	<div class="printer">
		<table class="bordered-table zebra-striped" >
			<tr>
				<td>
					<label class="control-label">Código:</label>
				</td>
				<td>
					<label><?=$row['codigo_bien']?></label>
				</td>
			</tr>
			<tr>
				<td>
					<label class="control-label">Nombre del Bien Nacional:</label>
				</td>
				<td>
					<label><?=$row['nombre']?></label>
				</td>
			</tr>
				<tr>
				<td>
					<label class="control-label">Serial del Bien Nacional:</label>
				</td>
				<td>
					<label><?=$row['nro_serial']?></label>
				</td>
			</tr>
			<tr>
				<td>
					<label class="control-label">Tipo Bien Nacional:</label>
				</td>
				<td>
					<label class="control-label"><?=$row['tipo_bien']?></label>
				</td>
			</tr>
		</table>
		<center>
			<button id="btnPrint" type="button" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
			<a href="?bien"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
		</center>
	</div>
</fieldset>
<?php
} // Fin Ventana de Impresiones
?>