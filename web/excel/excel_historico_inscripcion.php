<?php
	session_start();
	require_once("../class/class_bd.php");
	//	Variable que contendrá la clausula where a ejecutar
	$clausuleWhere="";
	//	Recorremos los parametros enviados para armar la clausula where
	if(isset($_POST['fid']) && !empty($_POST['fid']) && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.fecha_inscripcion >= '".$_POST['fid']."'";

	if(isset($_POST['fih']) && !empty($_POST['fih']) && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.fecha_inscripcion <= '".$_POST['fih']."'";
	else if(isset($_POST['fih']) && !empty($_POST['fih']) && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.fecha_inscripcion <= '".$_POST['fih']."'";

	if(isset($_POST['codigo_ano_academico']) && $_POST['codigo_ano_academico']!="0" && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.codigo_ano_academico = ".$_POST['codigo_ano_academico'];
	else if(isset($_POST['codigo_ano_academico']) && $_POST['codigo_ano_academico']!="0" && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.codigo_ano_academico = ".$_POST['codigo_ano_academico'];

	if(isset($_POST['cedula_responsable']) && !empty($_POST['cedula_responsable']) && $clausuleWhere==""){
	  $responsable=explode('_',trim($_POST['cedula_responsable']));
	  $cedula_responsable=$responsable[0];
	  $clausuleWhere="WHERE ps.cedula_responsable = '".$cedula_responsable."'";
	}
	else if(isset($_POST['cedula_responsable']) && !empty($_POST['cedula_responsable']) && $clausuleWhere!=""){
	  $responsable=explode('_',trim($_POST['cedula_responsable']));
	  $cedula_responsable=$responsable[0];
	  $clausuleWhere.=" AND ps.cedula_responsable = '".$cedula_responsable."'";
	}

	if(isset($_POST['fnd']) && !empty($_POST['fnd']) && $clausuleWhere=="")
		$clausuleWhere="WHERE per.fecha_nacimiento >= '".$_POST['fnd']."'";
	else if(isset($_POST['fnd']) && !empty($_POST['fnd']) && $clausuleWhere!="")
		$clausuleWhere.=" AND per.fecha_nacimiento >= '".$_POST['fnd']."'";

	if(isset($_POST['fnh']) && !empty($_POST['fnh']) && $clausuleWhere=="")
		$clausuleWhere="WHERE per.fecha_nacimiento <= '".$_POST['fnh']."'";
	else if(isset($_POST['fnh']) && !empty($_POST['fnh']) && $clausuleWhere!="")
		$clausuleWhere.=" AND per.fecha_nacimiento <= '".$_POST['fnh']."'";

	if(isset($_POST['sexo']) && $_POST['sexo']!="0" && $clausuleWhere=="")
		$clausuleWhere="WHERE per.sexo = '".$_POST['sexo']."'";
	else if(isset($_POST['sexo']) && $_POST['sexo']!="0" && $clausuleWhere!="")
		$clausuleWhere.=" AND per.sexo = '".$_POST['sexo']."'";

	if(isset($_POST['lugar_nacimiento']) && !empty($_POST['lugar_nacimiento']) && $clausuleWhere==""){
	  $lugar_nacimiento=explode('_',trim($_POST['lugar_nacimiento']));
	  $parroquia=$lugar_nacimiento[0];
	  $clausuleWhere="WHERE per.lugar_nacimiento = ".$parroquia;
	}
	else if(isset($_POST['lugar_nacimiento']) && !empty($_POST['lugar_nacimiento']) && $clausuleWhere!=""){
	  $lugar_nacimiento=explode('_',trim($_POST['lugar_nacimiento']));
	  $parroquia=$lugar_nacimiento[0];
	  $clausuleWhere.=" AND per.lugar_nacimiento = ".$parroquia;
	}

	if(isset($_POST['anio_a_cursar']) && $_POST['anio_a_cursar']!="" && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.anio_a_cursar IN ('".implode('\',\'',$_POST['anio_a_cursar'])."')";
	else if(isset($_POST['anio_a_cursar']) && $_POST['anio_a_cursar']!="" && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.anio_a_cursar IN ('".implode('\',\'',$_POST['anio_a_cursar'])."')";

	if(isset($_POST['coordinacion_pedagogica']) && $_POST['coordinacion_pedagogica']!="" && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.coordinacion_pedagogica IN ('".implode('\',\'',$_POST['coordinacion_pedagogica'])."')";
	else if(isset($_POST['coordinacion_pedagogica']) && $_POST['coordinacion_pedagogica']!="" && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.coordinacion_pedagogica IN ('".implode('\',\'',$_POST['coordinacion_pedagogica'])."')";

	if(isset($_POST['estado_salud']) && $_POST['estado_salud']!="" && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.estado_salud IN ('".implode('\',\'',$_POST['estado_salud'])."')";
	else if(isset($_POST['estado_salud']) && $_POST['estado_salud']!="" && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.estado_salud IN ('".implode('\',\'',$_POST['estado_salud'])."')";

	if(isset($_POST['alergico']) && $_POST['alergico']!="" && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.alergico IN ('".implode('\',\'',$_POST['alergico'])."')";
	else if(isset($_POST['alergico']) && $_POST['alergico']!="" && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.alergico IN ('".implode('\',\'',$_POST['alergico'])."')";

	if(isset($_POST['estudiante_regular']) && $_POST['estudiante_regular']!="" && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.estudiante_regular IN ('".implode('\',\'',$_POST['estudiante_regular'])."')";
	else if(isset($_POST['estudiante_regular']) && $_POST['estudiante_regular']!="" && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.estudiante_regular IN ('".implode('\',\'',$_POST['estudiante_regular'])."')";

	if(isset($_POST['procedencia']) && !empty($_POST['procedencia']) && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.procedencia LIKE '%".$_POST['procedencia']."%'";
	else if(isset($_POST['procedencia']) && !empty($_POST['procedencia']) && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.procedencia LIKE '%".$_POST['procedencia']."%'";

	if(isset($_POST['materia_pendiente']) && $_POST['materia_pendiente']!="" && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.materia_pendiente IN ('".implode('\',\'',$_POST['materia_pendiente'])."')";
	else if(isset($_POST['materia_pendiente']) && $_POST['materia_pendiente']!="" && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.materia_pendiente IN ('".implode('\',\'',$_POST['materia_pendiente'])."')";

	if(isset($_POST['cual_materia']) && !empty($_POST['cual_materia']) && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.cual_materia LIKE '%".$_POST['cual_materia']."%'";
	else if(isset($_POST['cual_materia']) && !empty($_POST['cual_materia']) && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.cual_materia LIKE '%".$_POST['cual_materia']."%'";

	if(isset($_POST['impedimento_deporte']) && $_POST['impedimento_deporte']!="" && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.impedimento_deporte IN ('".implode('\',\'',$_POST['impedimento_deporte'])."')";
	else if(isset($_POST['impedimento_deporte']) && $_POST['impedimento_deporte']!="" && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.impedimento_deporte IN ('".implode('\',\'',$_POST['impedimento_deporte'])."')";

	if(isset($_POST['especifique_deporte']) && !empty($_POST['especifique_deporte']) && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.especifique_deporte LIKE '%".$_POST['especifique_deporte']."%'";
	else if(isset($_POST['especifique_deporte']) && !empty($_POST['especifique_deporte']) && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.especifique_deporte LIKE '%".$_POST['especifique_deporte']."%'";

	if(isset($_POST['practica_deporte']) && $_POST['practica_deporte']!="" && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.practica_deporte IN ('".implode('\',\'',$_POST['practica_deporte'])."')";
	else if(isset($_POST['practica_deporte']) && $_POST['practica_deporte']!="" && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.practica_deporte IN ('".implode('\',\'',$_POST['practica_deporte'])."')";

	if(isset($_POST['cual_deporte']) && !empty($_POST['cual_deporte']) && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.cual_deporte LIKE '%".$_POST['cual_deporte']."%'";
	else if(isset($_POST['cual_deporte']) && !empty($_POST['cual_deporte']) && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.cual_deporte LIKE '%".$_POST['cual_deporte']."%'";

	if(isset($_POST['tiene_beca']) && $_POST['tiene_beca']!="" && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.tiene_beca IN ('".implode('\',\'',$_POST['tiene_beca'])."')";
	else if(isset($_POST['tiene_beca']) && $_POST['tiene_beca']!="" && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.tiene_beca IN ('".implode('\',\'',$_POST['tiene_beca'])."')";

	if(isset($_POST['organismo']) && !empty($_POST['organismo']) && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.organismo LIKE '%".$_POST['organismo']."%'";
	else if(isset($_POST['organismo']) && !empty($_POST['organismo']) && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.organismo LIKE '%".$_POST['organismo']."%'";

	if(isset($_POST['estudian_aca']) && $_POST['estudian_aca']!="" && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.estudian_aca IN ('".implode('\',\'',$_POST['estudian_aca'])."')";
	else if(isset($_POST['estudian_aca']) && $_POST['estudian_aca']!="" && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.estudian_aca IN ('".implode('\',\'',$_POST['estudian_aca'])."')";

	if(isset($_POST['que_anio']) && !empty($_POST['que_anio']) && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.que_anio LIKE '%".$_POST['que_anio']."%'";
	else if(isset($_POST['que_anio']) && !empty($_POST['que_anio']) && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.que_anio LIKE '%".$_POST['que_anio']."%'";

	if(isset($_POST['pesod']) && !empty($_POST['pesod']) && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.peso >= ".$_POST['pesod'];
	else if(isset($_POST['pesod']) && !empty($_POST['pesod']) && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.peso >= ".$_POST['pesod'];

	if(isset($_POST['pesoh']) && !empty($_POST['pesoh']) && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.peso <= ".$_POST['pesoh'];
	else if(isset($_POST['pesoh']) && !empty($_POST['pesoh']) && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.peso <= ".$_POST['pesoh'];

	if(isset($_POST['tallad']) && !empty($_POST['tallad']) && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.talla >= ".$_POST['tallad'];
	else if(isset($_POST['tallad']) && !empty($_POST['tallad']) && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.talla >= ".$_POST['tallad'];

	if(isset($_POST['tallah']) && !empty($_POST['tallah']) && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.talla <= ".$_POST['tallah'];
	else if(isset($_POST['tallah']) && !empty($_POST['tallah']) && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.talla <= ".$_POST['tallah'];

	if(isset($_POST['indiced']) && !empty($_POST['indiced']) && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.indice >= ".$_POST['indiced'];
	else if(isset($_POST['indiced']) && !empty($_POST['indiced']) && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.indice >= ".$_POST['indiced'];

	if(isset($_POST['indiceh']) && !empty($_POST['indiceh']) && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.indice <= ".$_POST['indiceh'];
	else if(isset($_POST['indiceh']) && !empty($_POST['indiceh']) && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.indice <= ".$_POST['indiceh'];

	if(isset($_POST['tiene_talento']) && $_POST['tiene_talento']!="" && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.tiene_talento IN ('".implode('\',\'',$_POST['tiene_talento'])."')";
	else if(isset($_POST['tiene_talento']) && $_POST['tiene_talento']!="" && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.tiene_talento IN ('".implode('\',\'',$_POST['tiene_talento'])."')";

	if(isset($_POST['cual_talento']) && !empty($_POST['cual_talento']) && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.cual_talento LIKE '%".$_POST['cual_talento']."%'";
	else if(isset($_POST['cual_talento']) && !empty($_POST['cual_talento']) && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.cual_talento LIKE '%".$_POST['cual_talento']."%'";

	if(isset($_POST['seccion_desde']) && $_POST['seccion_desde']!="0" && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.seccion >= '".$_POST['seccion_desde']."'";
	else if(isset($_POST['seccion_desde']) && $_POST['seccion_desde']!="0" && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.seccion >= '".$_POST['seccion_desde']."'";

	if(isset($_POST['seccion_hasta']) && $_POST['seccion_hasta']!="0" && $clausuleWhere=="")
		$clausuleWhere="WHERE ps.seccion <= '".$_POST['seccion_hasta']."'";
	else if(isset($_POST['seccion_hasta']) && $_POST['seccion_hasta']!="0" && $clausuleWhere!="")
		$clausuleWhere.=" AND ps.seccion <= '".$_POST['seccion_hasta']."'";

	$pgsql = new Conexion();
	$sql = "SELECT TO_CHAR(ps.fecha_inscripcion,'DD/MM/YYYY') AS fecha_inscripcion, aa.ano AS ano_academico, 
	CASE WHEN rp.segundo_nombre IS NOT NULL AND rp.segundo_apellido  IS NOT NULL THEN rp.cedula_persona||' - '||rp.primer_nombre||' '||rp.segundo_nombre||' '||rp.primer_apellido||' '||rp.segundo_apellido 
	WHEN rp.segundo_nombre IS NULL AND rp.segundo_apellido  IS NOT NULL THEN rp.cedula_persona||' - '||rp.primer_nombre||' '||rp.primer_apellido||' '||rp.segundo_apellido 
	WHEN rp.segundo_nombre IS NOT NULL AND rp.segundo_apellido  IS NULL THEN rp.cedula_persona||' - '||rp.primer_nombre||' '||rp.segundo_nombre||' '||rp.primer_apellido 
	ELSE rp.cedula_persona||' - '||rp.primer_nombre||' '||rp.primer_apellido END AS responsable,
	CASE WHEN per.segundo_nombre IS NOT NULL AND per.segundo_apellido IS NOT NULL THEN per.primer_nombre||' '||per.segundo_nombre||' '||per.primer_apellido||' '||per.segundo_apellido 
	WHEN per.segundo_nombre IS NULL AND per.segundo_apellido  IS NOT NULL THEN per.primer_nombre||' '||per.primer_apellido||' '||per.segundo_apellido 
	WHEN per.segundo_nombre IS NOT NULL AND per.segundo_apellido  IS NULL THEN per.primer_nombre||' '||per.segundo_nombre||' '||per.primer_apellido 
	ELSE per.primer_nombre||' '||per.primer_apellido END AS estudiante,
	TRIM(ps.cedula_persona) AS cedula_estudiante,CASE per.sexo WHEN 'F' THEN 'Femenino' ELSE 'Masculino' END AS sexo,TO_CHAR(per.fecha_nacimiento,'DD/MM/YYYY') AS fecha_nacimiento,
	extract(year from age(per.fecha_nacimiento))||' Años y '||extract(month from age(per.fecha_nacimiento))||' Meses' AS edad,pa.descripcion AS lugar_nacimiento,e.descripcion AS entidad_federal,
	per.direccion,CASE ps.anio_a_cursar WHEN '1' THEN '1er Año' WHEN '2' THEN '2do Año' WHEN '3' THEN '3er Año' WHEN '4' THEN '4to Año' WHEN '5' THEN '5to Año' END AS anio_a_cursar,
	CASE ps.coordinacion_pedagogica WHEN '1' THEN 'Coordinación 1' WHEN '2' THEN 'Coordinación 2' WHEN '3' THEN 'Coordinación 3' WHEN '4' THEN 'Coordinación 4' WHEN '5' THEN 'Coordinación 5' END AS coordinacion_pedagogica,
	per.telefono_local,CASE ps.estado_salud WHEN '1' THEN 'Excelente' WHEN '2' THEN 'Bueno' WHEN '3' THEN 'Regular' END AS estado_salud,CASE ps.alergico WHEN 'Y' THEN 'Sí' ELSE 'No' END AS alergico,
	CASE ps.impedimento_deporte WHEN 'Y' THEN 'Sí' ELSE 'No' END AS impedimento_deporte,ps.especifique_deporte,CASE ps.materia_pendiente WHEN 'Y' THEN 'Sí' ELSE 'No' END AS materia_pendiente,ps.cual_materia,
	CASE ps.practica_deporte WHEN 'Y' THEN 'Sí' ELSE 'No' END AS practica_deporte,ps.cual_deporte,CASE ps.tiene_beca WHEN 'Y' THEN 'Sí' ELSE 'No' END AS tiene_beca,ps.organismo,CASE ps.tiene_hermanos WHEN 'Y' THEN 'Sí' ELSE 'No' END AS tiene_hermanos,
	ps.cuantos_varones,ps.cuantas_hembras,CASE ps.estudian_aca WHEN 'Y' THEN 'Sí' ELSE 'No' END AS estudian_aca,ps.que_anio,ps.peso,ps.talla,ps.indice,CASE ps.tiene_talento WHEN 'Y' THEN 'Sí' ELSE 'No' END AS tiene_talento,ps.cual_talento,
	CASE WHEN pad.segundo_nombre IS NOT NULL AND pad.segundo_apellido  IS NOT NULL THEN pad.primer_nombre||' '||pad.segundo_nombre||' '||pad.primer_apellido||' '||pad.segundo_apellido 
	WHEN pad.segundo_nombre IS NULL AND pad.segundo_apellido  IS NOT NULL THEN pad.primer_nombre||' '||pad.primer_apellido||' '||pad.segundo_apellido 
	WHEN pad.segundo_nombre IS NOT NULL AND pad.segundo_apellido  IS NULL THEN pad.primer_nombre||' '||pad.segundo_nombre||' '||pad.primer_apellido 
	ELSE pad.primer_nombre||' '||pad.primer_apellido END AS padre,TO_CHAR(pad.fecha_nacimiento,'DD/MM/YYYY') AS fecha_nacimiento_padre,TRIM(pad.cedula_persona) AS cedula_padre,pad.profesion AS profesion_padre,pad.grado_instruccion AS grado_instruccion_padre,
	pad.direccion AS direccion_padre,pad.telefono_local AS telefono_local_padre,
	CASE WHEN mad.segundo_nombre IS NOT NULL AND mad.segundo_apellido  IS NOT NULL THEN mad.primer_nombre||' '||mad.segundo_nombre||' '||mad.primer_apellido||' '||mad.segundo_apellido 
	WHEN mad.segundo_nombre IS NULL AND mad.segundo_apellido  IS NOT NULL THEN mad.primer_nombre||' '||mad.primer_apellido||' '||mad.segundo_apellido 
	WHEN mad.segundo_nombre IS NOT NULL AND mad.segundo_apellido  IS NULL THEN mad.primer_nombre||' '||mad.segundo_nombre||' '||mad.primer_apellido 
	ELSE mad.primer_nombre||' '||mad.primer_apellido END AS madre,TO_CHAR(mad.fecha_nacimiento,'DD/MM/YYYY') AS fecha_nacimiento_madre,TRIM(mad.cedula_persona) AS cedula_madre,mad.profesion AS profesion_madre,mad.grado_instruccion AS grado_instruccion_madre,
	mad.direccion AS direccion_madre,mad.telefono_local AS telefono_local_madre,
	CASE WHEN rep.segundo_nombre IS NOT NULL AND rep.segundo_apellido  IS NOT NULL THEN rep.primer_nombre||' '||rep.segundo_nombre||' '||rep.primer_apellido||' '||rep.segundo_apellido 
	WHEN rep.segundo_nombre IS NULL AND rep.segundo_apellido  IS NOT NULL THEN rep.primer_nombre||' '||rep.primer_apellido||' '||rep.segundo_apellido 
	WHEN rep.segundo_nombre IS NOT NULL AND rep.segundo_apellido  IS NULL THEN rep.primer_nombre||' '||rep.segundo_nombre||' '||rep.primer_apellido 
	ELSE rep.primer_nombre||' '||rep.primer_apellido END AS representante,TO_CHAR(rep.fecha_nacimiento,'DD/MM/YYYY') AS fecha_nacimiento_representante,TRIM(rep.cedula_persona) AS cedula_representante,rep.profesion AS profesion_representante,
	rep.grado_instruccion AS grado_instruccion_representante,rep.direccion AS direccion_representante,rep.telefono_local AS telefono_local_representante,paren.descripcion AS parentesco,CASE ps.integracion_educativa WHEN 'Y' THEN 'Sí' ELSE 'No' END AS integracion_educativa,
	CASE ps.integracion_plomeria WHEN 'Y' THEN 'Sí' ELSE 'No' END AS integracion_plomeria,CASE ps.integracion_electricidad WHEN 'Y' THEN 'Sí' ELSE 'No' END AS integracion_electricidad,CASE ps.integracion_albanileria WHEN 'Y' THEN 'Sí' ELSE 'No' END AS integracion_albanileria,
	CASE ps.integracion_peluqueria WHEN 'Y' THEN 'Sí' ELSE 'No' END AS integracion_peluqueria,CASE ps.integracion_ambientacion WHEN 'Y' THEN 'Sí' ELSE 'No' END AS integracion_ambientacion,CASE ps.integracion_manualidades WHEN 'Y' THEN 'Sí' ELSE 'No' END AS integracion_manualidades,
	CASE ps.integracion_bisuteria WHEN 'Y' THEN 'Sí' ELSE 'No' END AS integracion_bisuteria,CASE ps.otra_integracion WHEN 'Y' THEN 'Sí' ELSE 'No' END AS otra_integracion,ps.especifique_integracion,sec.nombre_seccion,ps.observacion,CASE ps.fotocopia_ci WHEN 'Y' THEN 'Sí' ELSE 'No' END AS fotocopia_ci,
	CASE ps.partida_nacimiento WHEN 'Y' THEN 'Sí' ELSE 'No' END AS partida_nacimiento,CASE ps.boleta_promocion WHEN 'Y' THEN 'Sí' ELSE 'No' END AS boleta_promocion,CASE ps.certificado_calificaciones WHEN 'Y' THEN 'Sí' ELSE 'No' END AS certificado_calificaciones,
	CASE ps.constancia_buenaconducta WHEN 'Y' THEN 'Sí' ELSE 'No' END AS constancia_buenaconducta,CASE ps.fotos_estudiante WHEN 'Y' THEN 'Sí' ELSE 'No' END AS fotos_estudiante,CASE ps.boleta_zonificacion WHEN 'Y' THEN 'Sí' ELSE 'No' END AS boleta_zonificacion,CASE ps.fotocopia_ci_representante WHEN 'Y' THEN 'Sí' ELSE 'No' END AS fotocopia_ci_representante,
	CASE ps.fotos_representante WHEN 'Y' THEN 'Sí' ELSE 'No' END AS fotos_representante,CASE ps.otro_documento WHEN 'Y' THEN 'Sí' ELSE 'No' END AS otro_documento,ps.cual_documento,ps.observacion_documentos, 
	CASE ps.estudiante_regular WHEN 'Y' THEN 'Sí' ELSE 'No' END AS estudiante_regular,ps.procedencia, CASE ps.estatus WHEN '1' THEN 'Activo' ELSE 'Desactivado' END AS estatus 
	FROM educacion.tproceso_inscripcion ps 
	INNER JOIN educacion.tano_academico aa ON ps.codigo_ano_academico = aa.codigo_ano_academico 
	LEFT JOIN general.tpersona rp ON ps.cedula_responsable = rp.cedula_persona 
	LEFT JOIN general.tpersona per ON ps.cedula_persona = per.cedula_persona 
	LEFT JOIN general.tparroquia pa ON per.lugar_nacimiento = pa.codigo_parroquia 
	LEFT JOIN general.tmunicipio m ON pa.codigo_municipio = m.codigo_municipio 
	LEFT JOIN general.testado e ON m.codigo_estado = e.codigo_estado 
	LEFT JOIN general.tpersona pad ON ps.cedula_padre = pad.cedula_persona 
	LEFT JOIN general.tpersona mad ON ps.cedula_madre = mad.cedula_persona
	LEFT JOIN general.tpersona rep ON ps.cedula_representante = rep.cedula_persona
	LEFT JOIN general.tparentesco paren ON ps.codigo_parentesco = paren.codigo_parentesco 
	LEFT JOIN educacion.tseccion sec ON ps.seccion = sec.seccion 
	$clausuleWhere";

	$query = $pgsql->Ejecutar($sql);

	if($pgsql->Total_Filas($query)==0){
		$_SESSION['datos']['mensaje']="¡En estos momentos no se puede generar el reporte, porque la consulta no posee datos!";
  		header("Location: ../view/menu_principal.php?historico_inscripcion");
	}

	date_default_timezone_set('America/Caracas');

	/** Se agrega la libreria PHPExcel */
	require_once '../librerias/PHPExcel/PHPExcel.php';

	// Se crea el objeto PHPExcel
	$objPHPExcel = new PHPExcel();

	// Se asignan las propiedades del libro
	/*$objPHPExcel->getProperties()->setCreator("Codedrinks") //Autor
						 ->setLastModifiedBy("Codedrinks") //Ultimo usuario que lo modificó
						 ->setTitle("Reporte Excel con PHP y MySQL")
						 ->setSubject("Reporte Excel con PHP y MySQL")
						 ->setDescription("Reporte de alumnos")
						 ->setKeywords("reporte alumnos carreras")
						 ->setCategory("Reporte excel");*/

	$tituloReporte = "Histórico de Inscripciones";

	$titulosColumnas = explode(',',$_POST['etiquetas'][0]);
	$valoresColumnas = explode(',',$_POST['campos'][0]);

	//	Get Letter Based Index
	$starletter = PHPExcel_Cell::stringFromColumnIndex(0);
	$endletter = PHPExcel_Cell::stringFromColumnIndex(count($titulosColumnas)-1);
	
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells($starletter.'1:'.$endletter.'1')
										->mergeCells($starletter.'2:'.$endletter.'2');
					
	// Se agregan los titulos del reporte
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', $tituloReporte);

	$col = 0;
	foreach($titulosColumnas as $key=>$value) {
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col, 3, $value);
		$col++;
	}
	
	//Se seleccionan las columnas a mostrar
	$i = 4;
	$j = 0;
	while ($rows = $pgsql->Respuesta($query)){
		for($x = 0;$x<count($valoresColumnas);$x++)
			$filas[$valoresColumnas[$x]] = $rows[$valoresColumnas[$x]];	
		foreach($filas as $key=>$value) {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($j, $i, $value);
			$j++;
		}
		$i++;
		$j=0;
	}

	$estiloTituloReporte = new PHPExcel_Style();
	$estiloTituloReporte = array(
    	'font' => array(
        	'name'      => 'Verdana',
	        'bold'      => true,
    	    'italic'    => false,
            'strike'    => false,
           	'size' =>16,
            'color'     => array('rgb' => '000000')
        ),

        'fill' => array(
			'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
			'color'	=> array('argb' => '969696')
		),

        'borders' => array(
           	'allborders' => array(
            	'style' => PHPExcel_Style_Border::BORDER_NONE                    
           	)
        ), 

        'alignment' =>  array(
    			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    			'rotation'   => 0,
    			'wrap'       => TRUE
		)
    );

	$estiloTituloColumnas = new PHPExcel_Style();
	$estiloTituloColumnas = array(
        'font' => array(
            'name'      => 'Arial',
            'bold'      => true,                          
            'color'     => array(
                'rgb' => 'FF0000'
            )
        ),

        'fill' 	=> array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'rotation' => 90,
    		'startcolor' => array(
        		'rgb' => 'FAFAFA'
    		)
		),

        'borders' => array(
           	'allborders' => array(
            	'style' => PHPExcel_Style_Border::BORDER_NONE                   
           	)
        ), 

		'alignment' =>  array(
    			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    			'wrap'          => TRUE
		)
	);
		
	$estiloInformacion = new PHPExcel_Style();
	$estiloInformacion->applyFromArray(
		array(

       		'font' => array(
	           	'name'      => 'Arial',
	           	'bold'      => true,         
	           	'color'     => array('rgb' => '000000')
       		),

       		'fill' 	=> array(
				'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'		=> array('argb' => 'FFFFFF')
			),

	       	'borders' => array(
           		'allborders' => array(
            		'style' => PHPExcel_Style_Border::BORDER_THIN                   
           		)
        	),

        	'alignment' =>  array(
    			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    			'wrap'          => TRUE
		)
    	)
	);
	 
	$objPHPExcel->getActiveSheet()->getStyle($starletter.'1:'.$endletter.'1')->applyFromArray($estiloTituloReporte);
	$objPHPExcel->getActiveSheet()->getStyle($starletter.'2:'.$endletter.'2')->applyFromArray($estiloTituloReporte);
	$objPHPExcel->getActiveSheet()->getStyle($starletter.'3:'.$endletter.'3')->applyFromArray($estiloTituloColumnas);		
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion,$starletter.'4:'.$endletter.($i-1));

	$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
			
	for($i = $starletter; $i < $endletter; $i++){
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
	}
	
	// Se asigna el nombre a la hoja
	$objPHPExcel->getActiveSheet()->setTitle('Histórico de Inscripciones');

	// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
	$objPHPExcel->setActiveSheetIndex(0);
	// Inmovilizar paneles 
	$objPHPExcel->getActiveSheet(0)->freezePane($starletter.'4');
	//$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

	// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Historico_Inscripciones.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;

?>