<?php
session_start();
$url="#";
if(empty($_GET)){
	$url="web/controllers/control_login.php";	
}elseif($_GET['p']=="olvidar-clave" || $_GET['p']=="pregunta-seguridad"){
	$url="web/controllers/control_recuperar_clave.php";	
}elseif($_GET['p']=="cambiar-contrasena"){
	$url="web/controllers/control_cambiar_clave.php";	
}

?>
<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
	<title>...Bienvenidos...</title>
	<!-- Meta -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- End Meta -->
	<!-- JavaScripts -->
	<!-- Load Jquery Libreries-->
	<script src="web/js/jquery.min.js"></script>
	<script src="web/js/jquery.magnific-popup.js" type="text/javascript"></script>
	<!-- Load Noty Libreries-->
	<script type="text/javascript" src="web/librerias/noty/jquery.noty.packaged.min.js"></script>
	<link rel="stylesheet" type="text/css" href="web/librerias/noty/buttons.css"/>
	<!--<link rel="stylesheet" type="text/css" href="web/librerias/noty/noty_theme_default.css"/>-->
	<!-- Load Others Libreries-->
	<script type="text/javascript" src="web/js/move-top.js"></script>
	<script type="text/javascript" src="web/js/easing.js"></script>
	<script type="text/javascript" src="web/js/menu.js"></script>
	<!-- End JavaScripts -->
	<!-- Styles -->
	<!-- Load Bootstrap Libreries -->
	<script src="web/librerias/bootstrap/js/bootstrap.js"></script>
	<link rel="StyleSheet" type="text/css" href="web/css/bootstrap.css">
	<link rel="StyleSheet" type="text/css" href="web/librerias/bootstrap/css/normalize.css">
	<link rel="StyleSheet" type="text/css" href="web/librerias/bootstrap/css/bootstrap-theme.css">
	<!-- Load Styles Custom -->
	<link href='web/css/fonts.css' rel='stylesheet' type='text/css'>
	<link href="web/css/style.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="stylesheet" type="text/css" href="web/css/magnific-popup.css">
	<!-- End Styles -->
</head>
<body>
	<!--start-intranet-->
	<div class="view-login">
		<div class="container" id="intranet">	
			<div id="content">												
				<div class="form2">
					<img alt="Logo" src="http://localhost/CHSB/web/images/joomla.png">
					<hr/>
					<form role="form" id="form" name="form" method="POST" action="<?=  $url; ?>" <?php if(isset($_GET['p']) and $_GET['p']=='cambiar-contrasena') echo "onsubmit='return validar_contrasena()'"?> >
						<!-- AUTHENTICATION!-->
						<?php if(empty($_GET['p'])){ ?> 
						<div class="control-group"> 
							<div class="controls">
								<div class="input-prepend">
									<span class="add-on"><i class="icon-globe"></i></span>
									<select name="ambiente" id="ambiente" title="Conexión al servidor Ambiente de Producción / Pruebas" required >
										<option value="0">Conexión al Servidor</option>
										<option value="1">Producción</option>
										<option value="2">Pruebas</option>
									</select>
								</div>
								<br />
								<div class="input-prepend">
									<span class="add-on"><i class="icon-user"></i></span>
									<input type="text" onKeyUp="this.value=this.value.toUpperCase()" name="usuario" id="usuario" placeholder="Introduce tu usuario"  title="Por favor coloque su nombre de usuario" required />
								</div>
								<div class="input-prepend">
									<span class="add-on"><i class="icon-lock"></i></span>
									<input type="password" name="contrasena" id="contrasena" placeholder="Contraseña"  title="Por favor coloque su contraseña" required />
								</div>
							</div>
						</div>
						<?php } ?>
						<!-- END AUTHENTICATION!-->
						<!-- USER IDENTIFY!-->
						<?php if(!empty($_GET['p']) and $_GET['p']=='olvidar-clave'){?>
						<div class="control-group">
							<div class="controls"> 
								<div class="input-prepend">
									<span class="add-on"><i class="icon-globe"></i></span>
									<select name="ambiente" id="ambiente" title="Conexión al servidor Ambiente de Producción / Pruebas" required >
										<option value="0">Conexión al Servidor</option>
										<option value="1">Producción</option>
										<option value="2">Pruebas</option>
									</select>
								</div>
								<br />
								<div class="input-prepend">
									<span class="add-on"><i class="icon-user"></i></span>
									<input type="text" onKeyUp="this.value=this.value.toUpperCase()" name="user_name" id="user_name" placeholder="Introduce tu usuario" title="Por favor coloque su nombre de usuario" required>
								</div>
							</div>
						</div>
						<?php } ?>
						<!-- END USER IDENTIFY!-->
						<!-- SECRET QUESTION ANSWER!-->
						<?php if(!empty($_GET['p']) and $_GET['p']=='pregunta-seguridad'){?>    
						<div class="control-group">
							<div class="controls"> 
								<div class="input-prepend">
									<span class="add-on"><i class="icon-globe"></i></span>
									<select name="ambiente" id="ambiente" title="Conexión al servidor Ambiente de Producción / Pruebas" readonly required >
										<option value="0" <?php if($_SESSION['ambiente']=="0"){echo "selected";}?>>Conexión al Servidor</option>
										<option value="1" <?php if($_SESSION['ambiente']=="1"){echo "selected";}?>>Producción</option>
										<option value="2" <?php if($_SESSION['ambiente']=="2"){echo "selected";}?>>Pruebas</option>
									</select>
								</div>
								<br />
								<input type='hidden' value="<?php echo $_SESSION['pregunta_respuesta'];?>" name="accion" />
								<?php
								if(isset($_SESSION['pregunta_respuesta'])){
									for($i=0;$i<$_SESSION['user_preguntas_a_responder'];$i++){
										for($j=0;$j<$_SESSION['user_numero_preguntas'];$j++){
											if($i==$j){
												echo "<div class='input-prepend'>";
												echo "<h4>¿".ucfirst($_SESSION['user_pregunta'][$j])."?</h4>";
												echo "</div><br />";
												echo "<div class='input-prepend'>
												<span class='add-on'><i class='icon-question-sign'></i></span>
												<input type='text' onKeyUp='this.value=this.value.toUpperCase()' name='respuesta[]' placeholder='Ingresa la respuesta...' title='Por favor ingrese la respuesta' required />
												</div><br />";
											}
										}
									}
								}
								?>
							</div>
						</div>
						<?php } ?>
						<!-- END SECRET QUESTION ANSWER!-->
						<!-- CHANGE TO PASSWORD!-->
						<?php if(!empty($_GET['p']) and $_GET['p']=='cambiar-contrasena'
							and isset($_SESSION['pregunta_respuesta']) and $_SESSION['pregunta_respuesta']==4){ 
							require_once('class/class_bd.php');
							$conexion = new Conexion();
							$sql = "SELECT p.codigo_perfil,p.nombre_perfil,c.descripcion AS configuracion, 
							c.longitud_minclave,c.longitud_maxclave,c.cantidad_letrasmayusculas,c.cantidad_letrasminusculas,
							c.cantidad_caracteresespeciales,c.cantidad_numeros 
							FROM seguridad.tusuario u 
							INNER JOIN seguridad.tperfil p ON p.codigo_perfil = u.codigo_perfil 
							INNER JOIN seguridad.tconfiguracion c ON p.codigo_configuracion = c.codigo_configuracion 
							WHERE u.nombre_usuario = '".$_SESSION['user_name']."'";
							$query=$conexion->Ejecutar($sql);
							if($Obj=$conexion->Respuesta($query)){
								echo "<input type='hidden' id='longitud_minclave' value='".$Obj['longitud_minclave']."' />";
								echo "<input type='hidden' id='longitud_maxclave' value='".$Obj['longitud_maxclave']."' />";
								echo "<input type='hidden' id='cantidad_letrasmayusculas' value='".$Obj['cantidad_letrasmayusculas']."' />";
								echo "<input type='hidden' id='cantidad_letrasminusculas' value='".$Obj['cantidad_letrasminusculas']."' />";
								echo "<input type='hidden' id='cantidad_caracteresespeciales' value='".$Obj['cantidad_caracteresespeciales']."' />";
								echo "<input type='hidden' id='cantidad_numeros' value='".$Obj['cantidad_numeros']."' />";
							}
							?> 
							<div class="control-group"> 
								<div class="controls">
									<div class="input-prepend">
										<span class="add-on"><i class="icon-globe"></i></span>
										<select name="ambiente" id="ambiente" title="Conexión al servidor Ambiente de Producción / Pruebas" readonly required >
											<option value="0" <?php if($_SESSION['ambiente']=="0"){echo "selected";}?>>Conexión al Servidor</option>
											<option value="1" <?php if($_SESSION['ambiente']=="1"){echo "selected";}?>>Producción</option>
											<option value="2" <?php if($_SESSION['ambiente']=="2"){echo "selected";}?>>Pruebas</option>
										</select>
									</div>
									<br />
									<div class="input-prepend">
										<span class="add-on"><i class="icon-lock"></i></span>
										<input type="password" name="contrasena_actual" id="contrasena_actual" title="Contraseña actual" value="<?php echo $_SESSION['user_passwd'];?>" readonly required />
									</div>
									<br />
									<div class="input-prepend">
										<span class="add-on"><i class="icon-lock"></i></span>
										<input type="password" name="nueva_contrasena" id="nueva_contrasena" placeholder="Nueva Contraseña" title="Por favor coloque su nueva contraseña"  required>
									</div>
									<br />
									<div class="input-prepend">
										<span class="add-on"><i class="icon-lock"></i></span>
										<input type="password" name="confirmar_contrasena" id="confirmar_contrasena" placeholder="Repita la Contraseña" title="Por favor repita la contraseña ingresada" required>
									</div>
									<input type="hidden" name="cambiar_clave_sin_logeo"/>
								</div>
							</div>
							<?php } ?>
							<!-- END CHANGE TO PASSWORD!-->
							<div class="">							
								<input type="submit" value="Enviar" class="btn btn-primary btn-large">
								<a href="./"><button type="button" class="btn btn-primary btn-large"/>Cancelar</button></a>
							</div>
							<br />
							<?php if(empty($_GET['p'])){?> 
							<p class="link">Olvidaste tu contrase&ntilde;a. haz click <a href="?p=olvidar-clave#intranet">aquí</a></p>
							<?php }?>
						</form>			 	
					</div>
					<div class="clear"> </div>
				</div>			
			</div>
		</div>
		<!--end-intranet-->
	</body>
	</html>
	<?php
	if(isset($_SESSION['datos']['mensaje'])){
		echo "<script>alert('".$_SESSION['datos']['mensaje']."')</script>";	
		unset($_SESSION['datos']['mensaje']);	
		unset($_SESSION['pregunta_respuesta']);
	}
	?>