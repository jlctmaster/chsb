<?php
session_start();
$ccc=explode('?',$_SERVER['REQUEST_URI']);
if (isset($ccc[1]))
  $cccc=explode('&',$ccc[1]);
if (isset($cccc[0]))  
  $ccccc=explode('=',$cccc[0]);

if(isset($_SESSION['user_estado'])){
	?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Menu</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!-- Load CSS Files -->
		<link rel="StyleSheet" type="text/css" href="../librerias/bootstrap/css/bootstrap.css" media="screen" />
		<link rel="StyleSheet" type="text/css" href="../librerias/bootstrap/css/bootstrap-combined.min.css" media="screen" />
		<link rel="StyleSheet" type="text/css" href="../librerias/paginador/css/DT_bootstrap.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="../librerias/bootstrap/css/bootstrap-select.css">
		<link rel="stylesheet" type="text/css" href="../librerias/JQueryTE/css/jquery-te-1.4.0.css">
		<link rel="stylesheet" type="text/css" href="../librerias/noty/buttons.css"/>
		<link rel="stylesheet" type="text/css" href="../librerias/alert/Alert.css" />
		<link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" />
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
		<!-- Load JQuery -->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.scrolly.min.js"></script>
    <script type="text/javascript" src="js/jquery.scrollzer.min.js"></script>
    <script type="text/javascript" src="js/skel.min.js"></script>
    <script type="text/javascript" src="js/skel-layers.min.js"></script>
    <script type="text/javascript" src="js/init.js"></script>
    <?php
    if(isset($ccccc) && $ccccc[0]=='horario'){ 
      echo '<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>';
    }else {
      echo '<script type="text/javascript" src="../js/jquery.js"></script>';
    }
    ?>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>
		<script type="text/javascript" src="../js/jquery.ui.datepicker-es.js"></script>
		<script type="text/javascript" src="../js/jquery-ui-timepicker.js"></script>
		<script type="text/javascript" src="js/main.js"></script>
    <!-- Load Alert-->
    <script type="text/javascript" src="../librerias/alert/Alert.js"></script>   
		<!-- Load Bootstrap Libreries -->
		<script type="text/javascript" src="../librerias/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../librerias/bootstrap/js/bootstrap-select.js"></script>
		<!-- Load Paginator DataTable Libreries -->
		<script type="text/javascript" src="../librerias/paginador/js/jquery.dataTables.js"></script>
		<script type="text/javascript" src="../librerias/paginador/js/config_datatable_api.js"></script>
		<!-- Load JQueryTe Libreries -->
		<script type="text/javascript" src="../librerias/JQueryTE/js/jquery-te-1.4.0.min.js" charset="utf-8"></script>
		<!-- Load Noty Libreries -->
		<script type="text/javascript" src="../librerias/noty/jquery.noty.packaged.min.js"></script>

    <noscript>
      <link rel="stylesheet" href="css/skel.css" />
      <link rel="stylesheet" href="css/style.css" />
      <link rel="stylesheet" href="css/style-wide.css" />
    </noscript>
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie8.css" /><![endif]-->
	</head>
	<body>

		<!-- Header -->
		<?php
		if($_SESSION['user_estado']==1){
			require_once("menu.php");
		}
		?>

		<!-- Intro -->
		<div id="mainBody">
			<h1>
				<?php 
          /*************************************
          Devuelve una cadena con la fecha que se 
          le manda como parámetro en formato largo.
          *************************************/
          function FechaFormateada2($FechaStamp){ 
            $ano = date('Y',$FechaStamp);
            $mes = date('n',$FechaStamp);
            $dia = date('d',$FechaStamp);
            $diasemana = date('w',$FechaStamp);

            $diassemanaN= array("Domingo","Lunes","Martes","Miércoles",
            "Jueves","Viernes","Sábado"); $mesesN=array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
            "Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            return $diassemanaN[$diasemana].", $dia de ". $mesesN[$mes] ." de $ano";
          }
          //Para utilizar la función, se le manda una fecha como parámetro, por ejemplo, 
          //si se quisiera imprimir la fecha actual, utilizaríamos el siguiente código:
          $fecha = time();
          echo FechaFormateada2($fecha);
        ?>
        <div class="pull-right">                         
          <a href="../manuales/Manual_Sistema.pdf" title="" class="btn btn-large" target="_blank"><i class="icon icon-question-sign"></i> <span>Manual de Usuario</span></a>
          <a href="?perfil" title="" class="btn btn-large"><i class="icon icon-user"></i> <span>Perfil</span></a>
          <a onclick="salir()"  title="Salir" class="btn btn-large btn-danger"><i class="icon-off"></i></a>
        </div>
      </h1>
      <?php 
        /*if(!empty($_GET))
            $url='../manuales/'.strtolower($ccccc[0].'.pdf');
        */
        if($_SESSION['user_estado']==3){
        	$_SESSION['datos']['mensaje']="Completa los datos de seguridad";
        	include("serv_usuario.php");                                             
        }elseif($_SESSION['user_estado']==2){
        	$_SESSION['datos']['mensaje']="Contraseña caducida";
        	echo "<script>location.href='../index.php?p=olvidar-clave#intranet'</script>";
        	exit();
        }elseif($_SESSION['user_caducidad']=='1'){
        	$_SESSION['datos']['mensaje']="Debe cambiar la clave cada 6 meses";
        	echo "<script>location.href='../index.php?p=olvidar-clave#intranet'</script>";
        	exit();
        }elseif($_SESSION['user_estado']==1){
  				//seguridad
        	if(isset($_GET['perfil'])) include("serv_usuario.php"); 
        	else if(isset($_GET['nuevousuario'])) include("serv_nuevo_usuario.php");
        	else if(isset($_GET['cambiarcontrasena'])) include("serv_cambiar_contrasena.php");
        	else if(isset($_GET['perfiles'])) include("serv_perfil.php"); 
        	else if(isset($_GET['servicio'])) include("serv_servicio.php");
        	else if(isset($_GET['configuracion'])) include("serv_configuracion.php");
        	else if(isset($_GET['sistema'])) include("serv_sistema.php");
        	else if(isset($_GET['bitacora'])) include("serv_bitacora.php");
        	else if(isset($_GET['desbloquearusuario'])) include("serv_desbloquearusuario.php");
        	else if(isset($_GET['modulo'])) include("serv_modulo.php");
        	else if(isset($_GET['botones'])) include("serv_opcion.php");
  				//ubicaciones
        	else if(isset($_GET['pais'])) include("serv_pais.php");
        	else if(isset($_GET['estado'])) include("serv_estado.php");
        	else if(isset($_GET['municipio'])) include("serv_municipio.php");
        	else if(isset($_GET['parroquia'])) include("serv_parroquia.php");
  				//general
        	else if(isset($_GET['organizacion'])) include("serv_organizacion.php");
        	else if(isset($_GET['tipo_persona'])) include("serv_tipo_persona.php");
        	else if(isset($_GET['persona'])) include("serv_persona.php");
        	else if(isset($_GET['parentesco'])) include("serv_parentesco.php");
        	else if(isset($_GET['departamento'])) include("serv_departamento.php");
        	else if(isset($_GET['area'])) include("serv_area.php");
        	else if(isset($_GET['ambiente'])) include("serv_ambiente.php");
  				//inventario
        	else if(isset($_GET['ubicacion'])) include("serv_ubicacion.php");
        	else if(isset($_GET['adquisicion'])) include("serv_adquisicion.php");
          else if(isset($_GET['movimiento'])) include("serv_movimiento.php");
          else if(isset($_GET['inventario'])) include("serv_inventario.php");
  				//educación
        	else if(isset($_GET['bloque_hora'])) include("serv_bloque_hora.php");
        	else if(isset($_GET['ano_academico'])) include("serv_ano_academico.php");
        	else if(isset($_GET['lapso'])) include("serv_lapso.php");
        	else if(isset($_GET['materia'])) include("serv_materia.php");
        	else if(isset($_GET['periodo'])) include("serv_periodo.php");
        	else if(isset($_GET['inscripcion'])) include("serv_inscripcion.php");
        	else if(isset($_GET['seccion'])) include("serv_seccion.php");
        	else if(isset($_GET['estudiante'])) include("serv_estudiante.php");
        	else if(isset($_GET['horario'])) include("serv_horario.php");
        	else if(isset($_GET['proceso_inscripcion'])) include("serv_proceso_inscripcion.php");
  				//bienes nacionales
        	else if(isset($_GET['tipo_bien'])) include("serv_tipo_bien.php");
        	else if(isset($_GET['bien'])) include("serv_bien.php");
        	else if(isset($_GET['asignacion'])) include("serv_asignacion.php");
          else if(isset($_GET['recuperacion'])) include("serv_recuperacion.php");
          else if(isset($_GET['reconstruccion'])) include("serv_reconstruccion.php");
          //biblioteca
          else if(isset($_GET['clasificacion'])) include("serv_clasificacion.php");
          else if(isset($_GET['tema'])) include("serv_tema.php");
          else if(isset($_GET['autor'])) include("serv_autor.php");
          else if(isset($_GET['editorial'])) include("serv_editorial.php");
          else if(isset($_GET['libro'])) include("serv_libro.php");
          else if(isset($_GET['ejemplar'])) include("serv_ejemplar.php");
          else if(isset($_GET['prestamo'])) include("serv_prestamo.php");
          else if(isset($_GET['entrega'])) include("serv_entrega.php");
          //reportes
          else if(isset($_GET['horario_clases'])) include("rep_horario_clases.php");
          else if(isset($_GET['horario_profesor'])) include("rep_horario_profesor.php");
          else if(isset($_GET['historico_inscripcion'])) include("rep_historico_inscripcion.php");
          else if(isset($_GET['inventario_analitico'])) include("rep_inventario_analitico.php");
          else if(isset($_GET['movimiento_inventario'])) include("rep_movimiento_inventario.php");
          else if(isset($_GET['asistencia_biblioteca'])) include("rep_asistencia_biblioteca.php");
          else if(isset($_GET['prestamo_libros'])) include("rep_prestamo_libros.php");
          else if(isset($_GET['carta_morosidad'])) include("rep_carta_morosidad.php");
          else if(isset($_GET['entrega_libros'])) include("rep_entrega_libros.php");
          else if(isset($_GET['asignacion_bienes'])) include("rep_asignacion_bienes.php");
          else if(isset($_GET['recuperacion_bienes'])) include("rep_recuperacion_bienes.php");
          else if(isset($_GET['reconstruccion_bienes'])) include("rep_reconstruccion_bienes.php");
  				//principal
        	else include("serv_inicio.php");                                                                                                                                                                                                                                                                                                                                            
        }else{
        	echo "<script>location.href='403.php'</script>";
        }
      ?>
    </div>

    <!-- Footer -->
    <div id="footer">
    	<!-- Copyright -->
    	<div class="copyright">
    		<p>&copy; 2014 CHSB. Todos los derechos reservados.</p>
    	</div>
    </div>
  </body>
</html>
<?php
if(isset($_SESSION['datos']['mensaje']))
	echo "<script>alert('".$_SESSION['datos']['mensaje']."')</script>";
if(isset($_SESSION['datos']))
	unset($_SESSION['datos']);
}else{
	echo "<script>location.href='403.php'</script>";
}
?>