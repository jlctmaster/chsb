<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_proceso_inscripcion']))
  $codigo_proceso_inscripcion=trim($_POST['codigo_proceso_inscripcion']);

if(isset($_POST['codigo_inscripcion']))
  $codigo_inscripcion=trim($_POST['codigo_inscripcion']);

if(isset($_POST['fecha_inscripcion']))
  $fecha_inscripcion=trim($_POST['fecha_inscripcion']);

if(isset($_POST['codigo_ano_academico']))
  $codigo_ano_academico=trim($_POST['codigo_ano_academico']);

if(isset($_POST['old_cedula_persona']))
  $old_cedula_persona=trim($_POST['old_cedula_persona']);

if(isset($_POST['cedula_persona']))
  $cedula_persona=trim($_POST['cedula_persona']);

/** Campos de la 1era Pestaña */

if(isset($_POST['cedula_responsable']))
  $cedula_responsable=trim($_POST['cedula_responsable']);

if(isset($_POST['primer_nombre']))
  $primer_nombre=trim($_POST['primer_nombre']);

if(isset($_POST['segundo_nombre']))
  $segundo_nombre=trim($_POST['segundo_nombre']);

if(isset($_POST['primer_apellido']))
  $primer_apellido=trim($_POST['primer_apellido']);

if(isset($_POST['segundo_apellido']))
  $segundo_apellido=trim($_POST['segundo_apellido']);

if(isset($_POST['sexo']))
  $sexo=trim($_POST['sexo']);

if(isset($_POST['fecha_nacimiento_estudiante']))
  $fecha_nacimiento_estudiante=trim($_POST['fecha_nacimiento_estudiante']);

if(isset($_POST['lugar_nacimiento']))
  $lugar_nacimiento=trim($_POST['lugar_nacimiento']);

if(isset($_POST['direccion']))
  $direccion=trim($_POST['direccion']);

if(isset($_POST['telefono_local']))
  $telefono_local=trim($_POST['telefono_local']);

if(isset($_POST['telefono_movil']))
  $telefono_movil=trim($_POST['telefono_movil']);

if(isset($_POST['anio_a_cursar']))
  $anio_a_cursar=trim($_POST['anio_a_cursar']);

if(isset($_POST['coordinacion_pedagogica']))
  $coordinacion_pedagogica=trim($_POST['coordinacion_pedagogica']);

/** Fin 1era Pestaña */

/** Campos de la 2da Pestaña */

if(isset($_POST['estudiante_regular']))
  $estudiante_regular=trim($_POST['estudiante_regular']);

if(isset($_POST['procedencia']))
  $procedencia=trim($_POST['procedencia']);

if(isset($_POST['materia_pendiente']))
  $materia_pendiente=trim($_POST['materia_pendiente']);

if(isset($_POST['cual_materia']))
  $cual_materia=trim($_POST['cual_materia']);

if(isset($_POST['estado_salud']))
  $estado_salud=trim($_POST['estado_salud']);

if(isset($_POST['alergico']))
  $alergico=trim($_POST['alergico']);

if(isset($_POST['impedimento_deporte']))
  $impedimento_deporte=trim($_POST['impedimento_deporte']);

if(isset($_POST['especifique_deporte']))
  $especifique_deporte=trim($_POST['especifique_deporte']);

if(isset($_POST['practica_deporte']))
  $practica_deporte=trim($_POST['practica_deporte']);

if(isset($_POST['cual_deporte']))
  $cual_deporte=trim($_POST['cual_deporte']);

if(isset($_POST['tiene_beca']))
  $tiene_beca=trim($_POST['tiene_beca']);

if(isset($_POST['organismo']))
  $organismo=trim($_POST['organismo']);

if(isset($_POST['tiene_hermanos']))
  $tiene_hermanos=trim($_POST['tiene_hermanos']);

if(isset($_POST['cuantas_hembras']))
  $cuantas_hembras=trim($_POST['cuantas_hembras']);

if(isset($_POST['cuantos_varones']))
  $cuantos_varones=trim($_POST['cuantos_varones']);

if(isset($_POST['estudian_aca']))
  $estudian_aca=trim($_POST['estudian_aca']);

if(isset($_POST['que_anio']))
  $que_anio=trim($_POST['que_anio']);

if(isset($_POST['peso']))
  $peso=trim($_POST['peso']);

if(isset($_POST['talla']))
  $talla=trim($_POST['talla']);

if(isset($_POST['tiene_talento']))
  $tiene_talento=trim($_POST['tiene_talento']);

if(isset($_POST['cual_talento']))
  $cual_talento=trim($_POST['cual_talento']);

/** Fin 2da Pestaña */

/** Campos de la 3era Pestaña */

if(isset($_POST['old_cedula_padre']))
  $old_cedula_padre=trim($_POST['old_cedula_padre']);

if(isset($_POST['cedula_padre']))
  $cedula_padre=trim($_POST['cedula_padre']);

if(isset($_POST['fecha_nacimiento_padre']))
  $fecha_nacimiento_padre=trim($_POST['fecha_nacimiento_padre']);

if(isset($_POST['primer_nombre_padre']))
  $primer_nombre_padre=trim($_POST['primer_nombre_padre']);

if(isset($_POST['segundo_nombre_padre']))
  $segundo_nombre_padre=trim($_POST['segundo_nombre_padre']);

if(isset($_POST['primer_apellido_padre']))
  $primer_apellido_padre=trim($_POST['primer_apellido_padre']);

if(isset($_POST['segundo_apellido_padre']))
  $segundo_apellido_padre=trim($_POST['segundo_apellido_padre']);

if(isset($_POST['lugar_nacimiento_padre']))
  $lugar_nacimiento_padre=trim($_POST['lugar_nacimiento_padre']);

if(isset($_POST['direccion_padre']))
  $direccion_padre=trim($_POST['direccion_padre']);

if(isset($_POST['telefono_local_padre']))
  $telefono_local_padre=trim($_POST['telefono_local_padre']);

if(isset($_POST['telefono_movil_padre']))
  $telefono_movil_padre=trim($_POST['telefono_movil_padre']);

if(isset($_POST['profesion_padre']))
  $profesion_padre=trim($_POST['profesion_padre']);

if(isset($_POST['grado_instruccion_padre']))
  $grado_instruccion_padre=trim($_POST['grado_instruccion_padre']);

if(isset($_POST['old_cedula_madre']))
  $old_cedula_madre=trim($_POST['old_cedula_madre']);

if(isset($_POST['cedula_madre']))
  $cedula_madre=trim($_POST['cedula_madre']);

if(isset($_POST['fecha_nacimiento_madre']))
  $fecha_nacimiento_madre=trim($_POST['fecha_nacimiento_madre']);

if(isset($_POST['primer_nombre_madre']))
  $primer_nombre_madre=trim($_POST['primer_nombre_madre']);

if(isset($_POST['segundo_nombre_madre']))
  $segundo_nombre_madre=trim($_POST['segundo_nombre_madre']);

if(isset($_POST['primer_apellido_madre']))
  $primer_apellido_madre=trim($_POST['primer_apellido_madre']);

if(isset($_POST['segundo_apellido_madre']))
  $segundo_apellido_madre=trim($_POST['segundo_apellido_madre']);

if(isset($_POST['lugar_nacimiento_madre']))
  $lugar_nacimiento_madre=trim($_POST['lugar_nacimiento_madre']);

if(isset($_POST['direccion_madre']))
  $direccion_madre=trim($_POST['direccion_madre']);

if(isset($_POST['telefono_local_madre']))
  $telefono_local_madre=trim($_POST['telefono_local_madre']);

if(isset($_POST['telefono_movil_madre']))
  $telefono_movil_madre=trim($_POST['telefono_movil_madre']);

if(isset($_POST['profesion_madre']))
  $profesion_madre=trim($_POST['profesion_madre']);

if(isset($_POST['grado_instruccion_madre']))
  $grado_instruccion_madre=trim($_POST['grado_instruccion_madre']);

/** Fin 3era Pestaña */

/** Campos de la 4ta Pestaña */

if(isset($_POST['codigo_parentesco']))
  $codigo_parentesco=trim($_POST['codigo_parentesco']);

if(isset($_POST['old_cedula_representante']))
  $old_cedula_representante=trim($_POST['old_cedula_representante']);

if(isset($_POST['cedula_representante']))
  $cedula_representante=trim($_POST['cedula_representante']);

if(isset($_POST['fecha_nacimiento_representante']))
  $fecha_nacimiento_representante=trim($_POST['fecha_nacimiento_representante']);

if(isset($_POST['primer_nombre_representante']))
  $primer_nombre_representante=trim($_POST['primer_nombre_representante']);

if(isset($_POST['segundo_nombre_representante']))
  $segundo_nombre_representante=trim($_POST['segundo_nombre_representante']);

if(isset($_POST['primer_apellido_representante']))
  $primer_apellido_representante=trim($_POST['primer_apellido_representante']);

if(isset($_POST['segundo_apellido_representante']))
  $segundo_apellido_representante=trim($_POST['segundo_apellido_representante']);

if(isset($_POST['sexo_representante']))
  $sexo_representante=trim($_POST['sexo_representante']);

if(isset($_POST['lugar_nacimiento_representante']))
  $lugar_nacimiento_representante=trim($_POST['lugar_nacimiento_representante']);

if(isset($_POST['direccion_representante']))
  $direccion_representante=trim($_POST['direccion_representante']);

if(isset($_POST['telefono_local_representante']))
  $telefono_local_representante=trim($_POST['telefono_local_representante']);

if(isset($_POST['telefono_movil_representante']))
  $telefono_movil_representante=trim($_POST['telefono_movil_representante']);

if(isset($_POST['profesion_representante']))
  $profesion_representante=trim($_POST['profesion_representante']);

if(isset($_POST['grado_instruccion_representante']))
  $grado_instruccion_representante=trim($_POST['grado_instruccion_representante']);

/** Fin 4ta Pestaña */

/** Campos de la 5ta Pestaña */

if(isset($_POST['integracion_educativa']))
  $integracion_educativa=trim($_POST['integracion_educativa']);

if(isset($_POST['integracion_plomeria']))
  $integracion_plomeria=trim($_POST['integracion_plomeria']);

if(isset($_POST['integracion_electricidad']))
  $integracion_electricidad=trim($_POST['integracion_electricidad']);

if(isset($_POST['integracion_albanileria']))
  $integracion_albanileria=trim($_POST['integracion_albanileria']);

if(isset($_POST['integracion_peluqueria']))
  $integracion_peluqueria=trim($_POST['integracion_peluqueria']);

if(isset($_POST['integracion_ambientacion']))
  $integracion_ambientacion=trim($_POST['integracion_ambientacion']);

if(isset($_POST['integracion_manualidades']))
  $integracion_manualidades=trim($_POST['integracion_manualidades']);

if(isset($_POST['integracion_bisuteria']))
  $integracion_bisuteria=trim($_POST['integracion_bisuteria']);

if(isset($_POST['otra_integracion']))
  $otra_integracion=trim($_POST['otra_integracion']);

if(isset($_POST['especifique_integracion']))
  $especifique_integracion=trim($_POST['especifique_integracion']);

/** Fin 5ta Pestaña */

/** Campos de la 6ta Pestaña */

if(isset($_POST['fotocopia_ci']))
  $fotocopia_ci=trim($_POST['fotocopia_ci']);

if(isset($_POST['partida_nacimiento']))
  $partida_nacimiento=trim($_POST['partida_nacimiento']);

if(isset($_POST['boleta_promocion']))
  $boleta_promocion=trim($_POST['boleta_promocion']);

if(isset($_POST['certificado_calificaciones']))
  $certificado_calificaciones=trim($_POST['certificado_calificaciones']);

if(isset($_POST['constancia_buenaconducta']))
  $constancia_buenaconducta=trim($_POST['constancia_buenaconducta']);

if(isset($_POST['fotos_estudiante']))
  $fotos_estudiante=trim($_POST['fotos_estudiante']);

if(isset($_POST['boleta_zonificacion']))
  $boleta_zonificacion=trim($_POST['boleta_zonificacion']);

if(isset($_POST['fotocopia_ci_representante']))
  $fotocopia_ci_representante=trim($_POST['fotocopia_ci_representante']);

if(isset($_POST['fotos_representante']))
  $fotos_representante=trim($_POST['fotos_representante']);

if(isset($_POST['otro_documento']))
  $otro_documento=trim($_POST['otro_documento']);

if(isset($_POST['cual_documento']))
  $cual_documento=trim($_POST['cual_documento']);

if(isset($_POST['observacion_documentos']))
  $observacion_documentos=trim($_POST['observacion_documentos']);

/** Fin 6ta Pestaña */

include_once("../class/class_proceso_inscripcion.php");
$proceso_inscripcion=new proceso_inscripcion();
if($lOpt=='Registrar_Paso1'){
  $proceso_inscripcion->codigo_inscripcion($codigo_inscripcion);
  $proceso_inscripcion->fecha_inscripcion($fecha_inscripcion);
  $proceso_inscripcion->codigo_ano_academico($codigo_ano_academico);
  $proceso_inscripcion->cedula_persona($cedula_persona);
  $proceso_inscripcion->cedula_responsable($cedula_responsable);
  $proceso_inscripcion->primer_nombre($primer_nombre);
  $proceso_inscripcion->segundo_nombre($segundo_nombre);
  $proceso_inscripcion->primer_apellido($primer_apellido);
  $proceso_inscripcion->segundo_apellido($segundo_apellido);
  $proceso_inscripcion->sexo($sexo);
  $proceso_inscripcion->fecha_nacimiento_estudiante($fecha_nacimiento_estudiante);
  $proceso_inscripcion->lugar_nacimiento($lugar_nacimiento);
  $proceso_inscripcion->direccion($direccion);
  $proceso_inscripcion->telefono_local($telefono_local);
  $proceso_inscripcion->telefono_movil($telefono_movil);
  $proceso_inscripcion->anio_a_cursar($anio_a_cursar);
  $proceso_inscripcion->coordinacion_pedagogica($coordinacion_pedagogica);
  if($proceso_inscripcion->Registrar_Paso1($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡Se ha registrado al estudiante en el proceso de inscripción con éxito!";
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=2&codigo_proceso_inscripcion=".$proceso_inscripcion->codigo_proceso_inscripcion()."#tab-condicionestudiante");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el estudiante en el proceso de inscripción!";
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=2#tab-datosestudiantes");
  }
}

if($lOpt=='Registrar_Paso2'){
  $proceso_inscripcion->codigo_proceso_inscripcion($codigo_proceso_inscripcion);
  $proceso_inscripcion->cedula_persona($cedula_persona);
  $proceso_inscripcion->estudiante_regular($estudiante_regular);
  $proceso_inscripcion->procedencia($procedencia);
  $proceso_inscripcion->materia_pendiente($materia_pendiente);
  $proceso_inscripcion->cual_materia($cual_materia);
  $proceso_inscripcion->estado_salud($estado_salud);
  $proceso_inscripcion->alergico($alergico);
  $proceso_inscripcion->impedimento_deporte($impedimento_deporte);
  $proceso_inscripcion->especifique_deporte($especifique_deporte);
  $proceso_inscripcion->practica_deporte($practica_deporte);
  $proceso_inscripcion->cual_deporte($cual_deporte);
  $proceso_inscripcion->tiene_beca($tiene_beca);
  $proceso_inscripcion->organismo($organismo);
  $proceso_inscripcion->tiene_hermanos($tiene_hermanos);
  $proceso_inscripcion->cuantas_hembras($cuantas_hembras);
  $proceso_inscripcion->cuantos_varones($cuantos_varones);
  $proceso_inscripcion->estudian_aca($estudian_aca);
  $proceso_inscripcion->que_anio($que_anio);
  $proceso_inscripcion->peso($peso);
  $proceso_inscripcion->talla($talla);
  $proceso_inscripcion->tiene_talento($tiene_talento);
  $proceso_inscripcion->cual_talento($cual_talento);
  if($proceso_inscripcion->Registrar_Paso2($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡Se ha registrado la condición del estudiante en el proceso de inscripción con éxito!";
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=2&codigo_proceso_inscripcion=".$proceso_inscripcion->codigo_proceso_inscripcion()."#tab-antecedentesfamiliares");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar la condición del estudiante en el proceso de inscripción!";
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=2&codigo_proceso_inscripcion=".$proceso_inscripcion->codigo_proceso_inscripcion()."#tab-condicionestudiante");
  }
}

if($lOpt=='Registrar_Paso3'){
  $proceso_inscripcion->codigo_proceso_inscripcion($codigo_proceso_inscripcion);
  $proceso_inscripcion->cedula_persona($cedula_persona);
  $proceso_inscripcion->cedula_padre($cedula_padre);
  $proceso_inscripcion->fecha_nacimiento_padre($fecha_nacimiento_padre);
  $proceso_inscripcion->primer_nombre_padre($primer_nombre_padre);
  $proceso_inscripcion->segundo_nombre_padre($segundo_nombre_padre);
  $proceso_inscripcion->primer_apellido_padre($primer_apellido_padre);
  $proceso_inscripcion->segundo_apellido_padre($segundo_apellido_padre);
  $proceso_inscripcion->lugar_nacimiento_padre($lugar_nacimiento_padre);
  $proceso_inscripcion->direccion_padre($direccion_padre);
  $proceso_inscripcion->telefono_local_padre($telefono_local_padre);
  $proceso_inscripcion->telefono_movil_padre($telefono_movil_padre);
  $proceso_inscripcion->profesion_padre($profesion_padre);
  $proceso_inscripcion->grado_instruccion_padre($grado_instruccion_padre);
  $proceso_inscripcion->cedula_madre($cedula_madre);
  $proceso_inscripcion->fecha_nacimiento_madre($fecha_nacimiento_madre);
  $proceso_inscripcion->primer_nombre_madre($primer_nombre_madre);
  $proceso_inscripcion->segundo_nombre_madre($segundo_nombre_madre);
  $proceso_inscripcion->primer_apellido_madre($primer_apellido_madre);
  $proceso_inscripcion->segundo_apellido_madre($segundo_apellido_madre);
  $proceso_inscripcion->lugar_nacimiento_madre($lugar_nacimiento_madre);
  $proceso_inscripcion->direccion_madre($direccion_madre);
  $proceso_inscripcion->telefono_local_madre($telefono_local_madre);
  $proceso_inscripcion->telefono_movil_madre($telefono_movil_madre);
  $proceso_inscripcion->profesion_madre($profesion_madre);
  $proceso_inscripcion->grado_instruccion_madre($grado_instruccion_madre);
  if($proceso_inscripcion->Registrar_Paso3($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡Se han registrado los antecedentes familiares en el proceso de inscripción con éxito!";
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=2&codigo_proceso_inscripcion=".$proceso_inscripcion->codigo_proceso_inscripcion()."#tab-datosrepresentante");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar los antecedentes familiares en el proceso de inscripción!";
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=2&codigo_proceso_inscripcion=".$proceso_inscripcion->codigo_proceso_inscripcion()."#tab-antecedentesfamiliares");
  }
}

if($lOpt=='Registrar_Paso4'){
  $proceso_inscripcion->codigo_proceso_inscripcion($codigo_proceso_inscripcion);
  $proceso_inscripcion->cedula_persona($cedula_persona);
  $proceso_inscripcion->cedula_padre($cedula_padre);
  $proceso_inscripcion->cedula_madre($cedula_madre);
  $proceso_inscripcion->codigo_parentesco($codigo_parentesco);
  $proceso_inscripcion->cedula_representante($cedula_representante);
  $proceso_inscripcion->fecha_nacimiento_representante($fecha_nacimiento_representante);
  $proceso_inscripcion->primer_nombre_representante($primer_nombre_representante);
  $proceso_inscripcion->segundo_nombre_representante($segundo_nombre_representante);
  $proceso_inscripcion->primer_apellido_representante($primer_apellido_representante);
  $proceso_inscripcion->segundo_apellido_representante($segundo_apellido_representante);
  $proceso_inscripcion->sexo_representante($sexo_representante);
  $proceso_inscripcion->lugar_nacimiento_representante($lugar_nacimiento_representante);
  $proceso_inscripcion->direccion_representante($direccion_representante);
  $proceso_inscripcion->telefono_local_representante($telefono_local_representante);
  $proceso_inscripcion->telefono_movil_representante($telefono_movil_representante);
  $proceso_inscripcion->profesion_representante($profesion_representante);
  $proceso_inscripcion->grado_instruccion_representante($grado_instruccion_representante);
  if($proceso_inscripcion->Registrar_Paso4($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡Se ha registrado al representante del estudiante en el proceso de inscripción con éxito!";
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=2&codigo_proceso_inscripcion=".$proceso_inscripcion->codigo_proceso_inscripcion()."#tab-integracionec");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar al representante del estudiante en el proceso de inscripción!";
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=2&codigo_proceso_inscripcion=".$proceso_inscripcion->codigo_proceso_inscripcion()."#tab-datosrepresentante");
  }
}

if($lOpt=='Registrar_Paso5'){
  $proceso_inscripcion->codigo_proceso_inscripcion($codigo_proceso_inscripcion);
  $proceso_inscripcion->cedula_persona($cedula_persona);
  $proceso_inscripcion->integracion_educativa($integracion_educativa);
  $proceso_inscripcion->integracion_plomeria($integracion_plomeria);
  $proceso_inscripcion->integracion_electricidad($integracion_electricidad);
  $proceso_inscripcion->integracion_albanileria($integracion_albanileria);
  $proceso_inscripcion->integracion_peluqueria($integracion_peluqueria);
  $proceso_inscripcion->integracion_ambientacion($integracion_ambientacion);
  $proceso_inscripcion->integracion_manualidades($integracion_manualidades);
  $proceso_inscripcion->integracion_bisuteria($integracion_bisuteria);
  $proceso_inscripcion->otra_integracion($otra_integracion);
  $proceso_inscripcion->especifique_integracion($especifique_integracion);
  if($proceso_inscripcion->Registrar_Paso5($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡Se han registrado los datos de la integración escuela-comunidad en el proceso de inscripción con éxito!";
    $_SESSION['datos']['codigo_proceso_inscripcion']=$proceso_inscripcion->codigo_proceso_inscripcion();
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=2&codigo_proceso_inscripcion=".$proceso_inscripcion->codigo_proceso_inscripcion()."#tab-documentos");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar los datos de la integración escuela-comunidad en el proceso de inscripción!";
    $_SESSION['datos']['error']=$proceso_inscripcion->error();
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=2&codigo_proceso_inscripcion=".$proceso_inscripcion->codigo_proceso_inscripcion()."#tab-integracionec");
  }
}

if($lOpt=='Registrar_Paso6'){
  $proceso_inscripcion->codigo_proceso_inscripcion($codigo_proceso_inscripcion);
  $proceso_inscripcion->cedula_persona($cedula_persona);
  $proceso_inscripcion->fotocopia_ci($fotocopia_ci);
  $proceso_inscripcion->partida_nacimiento($partida_nacimiento);
  $proceso_inscripcion->boleta_promocion($boleta_promocion);
  $proceso_inscripcion->certificado_calificaciones($certificado_calificaciones);
  $proceso_inscripcion->constancia_buenaconducta($constancia_buenaconducta);
  $proceso_inscripcion->fotos_estudiante($fotos_estudiante);
  $proceso_inscripcion->boleta_zonificacion($boleta_zonificacion);
  $proceso_inscripcion->fotocopia_ci_representante($fotocopia_ci_representante);
  $proceso_inscripcion->fotos_representante($fotos_representante);
  $proceso_inscripcion->otro_documento($otro_documento);
  $proceso_inscripcion->cual_documento($cual_documento);
  $proceso_inscripcion->observacion_documentos($observacion_documentos);
  if($proceso_inscripcion->Registrar_Paso6($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡Se han registrado los datos de los documentos consignados en el proceso de inscripción con éxito!";
    $_SESSION['datos']['procesado']="Y";
    $_SESSION['datos']['codigo_proceso_inscripcion']=$proceso_inscripcion->codigo_proceso_inscripcion();
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=2#tab-datosestudiantes");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar los datos de los documentos consignados en el proceso de inscripción!";
    $_SESSION['datos']['error']=$proceso_inscripcion->error();
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=2&codigo_proceso_inscripcion=".$proceso_inscripcion->codigo_proceso_inscripcion()."#tab-documentos");
  }
}

if($lOpt=='Modificar_Paso1'){
  $proceso_inscripcion->codigo_proceso_inscripcion($codigo_proceso_inscripcion);
  $proceso_inscripcion->cedula_persona($cedula_persona);
  $proceso_inscripcion->codigo_inscripcion($codigo_inscripcion);
  $proceso_inscripcion->fecha_inscripcion($fecha_inscripcion);
  $proceso_inscripcion->codigo_ano_academico($codigo_ano_academico);
  $proceso_inscripcion->cedula_persona($cedula_persona);
  $proceso_inscripcion->cedula_responsable($cedula_responsable);
  $proceso_inscripcion->primer_nombre($primer_nombre);
  $proceso_inscripcion->segundo_nombre($segundo_nombre);
  $proceso_inscripcion->primer_apellido($primer_apellido);
  $proceso_inscripcion->segundo_apellido($segundo_apellido);
  $proceso_inscripcion->sexo($sexo);
  $proceso_inscripcion->fecha_nacimiento_estudiante($fecha_nacimiento_estudiante);
  $proceso_inscripcion->lugar_nacimiento($lugar_nacimiento);
  $proceso_inscripcion->direccion($direccion);
  $proceso_inscripcion->telefono_local($telefono_local);
  $proceso_inscripcion->telefono_movil($telefono_movil);
  $proceso_inscripcion->anio_a_cursar($anio_a_cursar);
  $proceso_inscripcion->coordinacion_pedagogica($coordinacion_pedagogica);
  if($proceso_inscripcion->Actualizar_Paso1($_SESSION['user_name'],$old_cedula_persona))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡Se ha modificado los datos del estudiante en el proceso de inscripción con éxito!";
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=3&codigo_proceso_inscripcion=".$proceso_inscripcion->codigo_proceso_inscripcion()."#tab-datosestudiantes");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar los datos del estudiante en el proceso de inscripción!";
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=3&codigo_proceso_inscripcion=".$proceso_inscripcion->codigo_proceso_inscripcion()."#tab-datosestudiantes");
  }
}

if($lOpt=='Modificar_Paso2'){
  $proceso_inscripcion->codigo_proceso_inscripcion($codigo_proceso_inscripcion);
  $proceso_inscripcion->cedula_persona($cedula_persona);
  $proceso_inscripcion->estudiante_regular($estudiante_regular);
  $proceso_inscripcion->procedencia($procedencia);
  $proceso_inscripcion->materia_pendiente($materia_pendiente);
  $proceso_inscripcion->cual_materia($cual_materia);
  $proceso_inscripcion->estado_salud($estado_salud);
  $proceso_inscripcion->alergico($alergico);
  $proceso_inscripcion->impedimento_deporte($impedimento_deporte);
  $proceso_inscripcion->especifique_deporte($especifique_deporte);
  $proceso_inscripcion->practica_deporte($practica_deporte);
  $proceso_inscripcion->cual_deporte($cual_deporte);
  $proceso_inscripcion->tiene_beca($tiene_beca);
  $proceso_inscripcion->organismo($organismo);
  $proceso_inscripcion->tiene_hermanos($tiene_hermanos);
  $proceso_inscripcion->cuantas_hembras($cuantas_hembras);
  $proceso_inscripcion->cuantos_varones($cuantos_varones);
  $proceso_inscripcion->estudian_aca($estudian_aca);
  $proceso_inscripcion->que_anio($que_anio);
  $proceso_inscripcion->peso($peso);
  $proceso_inscripcion->talla($talla);
  $proceso_inscripcion->tiene_talento($tiene_talento);
  $proceso_inscripcion->cual_talento($cual_talento);
  if($proceso_inscripcion->Actualizar_Paso2($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡Se ha modificado la condición del estudiante en el proceso de inscripción con éxito!";
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=3&codigo_proceso_inscripcion=".$proceso_inscripcion->codigo_proceso_inscripcion()."#tab-condicionestudiante");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar la condición del estudiante en el proceso de inscripción!";
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=3&codigo_proceso_inscripcion=".$proceso_inscripcion->codigo_proceso_inscripcion()."#tab-condicionestudiante");
  }
}

if($lOpt=='Modificar_Paso3'){
  $proceso_inscripcion->codigo_proceso_inscripcion($codigo_proceso_inscripcion);
  $proceso_inscripcion->cedula_persona($cedula_persona);
  $proceso_inscripcion->cedula_padre($cedula_padre);
  $proceso_inscripcion->fecha_nacimiento_padre($fecha_nacimiento_padre);
  $proceso_inscripcion->primer_nombre_padre($primer_nombre_padre);
  $proceso_inscripcion->segundo_nombre_padre($segundo_nombre_padre);
  $proceso_inscripcion->primer_apellido_padre($primer_apellido_padre);
  $proceso_inscripcion->segundo_apellido_padre($segundo_apellido_padre);
  $proceso_inscripcion->lugar_nacimiento_padre($lugar_nacimiento_padre);
  $proceso_inscripcion->direccion_padre($direccion_padre);
  $proceso_inscripcion->telefono_local_padre($telefono_local_padre);
  $proceso_inscripcion->telefono_movil_padre($telefono_movil_padre);
  $proceso_inscripcion->profesion_padre($profesion_padre);
  $proceso_inscripcion->grado_instruccion_padre($grado_instruccion_padre);
  $proceso_inscripcion->cedula_madre($cedula_madre);
  $proceso_inscripcion->fecha_nacimiento_madre($fecha_nacimiento_madre);
  $proceso_inscripcion->primer_nombre_madre($primer_nombre_madre);
  $proceso_inscripcion->segundo_nombre_madre($segundo_nombre_madre);
  $proceso_inscripcion->primer_apellido_madre($primer_apellido_madre);
  $proceso_inscripcion->segundo_apellido_madre($segundo_apellido_madre);
  $proceso_inscripcion->lugar_nacimiento_madre($lugar_nacimiento_madre);
  $proceso_inscripcion->direccion_madre($direccion_madre);
  $proceso_inscripcion->telefono_local_madre($telefono_local_madre);
  $proceso_inscripcion->telefono_movil_madre($telefono_movil_madre);
  $proceso_inscripcion->profesion_madre($profesion_madre);
  $proceso_inscripcion->grado_instruccion_madre($grado_instruccion_madre);
  if($proceso_inscripcion->Actualizar_Paso3($_SESSION['user_name'],$old_cedula_padre,$old_cedula_madre))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡Se han modificado los antecedentes familiares en el proceso de inscripción con éxito!";
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=3&codigo_proceso_inscripcion=".$proceso_inscripcion->codigo_proceso_inscripcion()."#tab-antecedentesfamiliares");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar los antecedentes familiares en el proceso de inscripción!";
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=3&codigo_proceso_inscripcion=".$proceso_inscripcion->codigo_proceso_inscripcion()."#tab-antecedentesfamiliares");
  }
}

if($lOpt=='Modificar_Paso4'){
  $proceso_inscripcion->codigo_proceso_inscripcion($codigo_proceso_inscripcion);
  $proceso_inscripcion->cedula_persona($cedula_persona);
  $proceso_inscripcion->cedula_padre($cedula_padre);
  $proceso_inscripcion->cedula_madre($cedula_madre);
  $proceso_inscripcion->codigo_parentesco($codigo_parentesco);
  $proceso_inscripcion->cedula_representante($cedula_representante);
  $proceso_inscripcion->fecha_nacimiento_representante($fecha_nacimiento_representante);
  $proceso_inscripcion->primer_nombre_representante($primer_nombre_representante);
  $proceso_inscripcion->segundo_nombre_representante($segundo_nombre_representante);
  $proceso_inscripcion->primer_apellido_representante($primer_apellido_representante);
  $proceso_inscripcion->segundo_apellido_representante($segundo_apellido_representante);
  $proceso_inscripcion->lugar_nacimiento_representante($lugar_nacimiento_representante);
  $proceso_inscripcion->direccion_representante($direccion_representante);
  $proceso_inscripcion->telefono_local_representante($telefono_local_representante);
  $proceso_inscripcion->telefono_movil_representante($telefono_movil_representante);
  $proceso_inscripcion->profesion_representante($profesion_representante);
  $proceso_inscripcion->grado_instruccion_representante($grado_instruccion_representante);
  if($proceso_inscripcion->Actualizar_Paso4($_SESSION['user_name'],$old_cedula_representante))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡Se ha modificado al representante del estudiante en el proceso de inscripción con éxito!";
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=3&codigo_proceso_inscripcion=".$proceso_inscripcion->codigo_proceso_inscripcion()."#tab-datosrepresentante");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar al representante del estudiante en el proceso de inscripción!";
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=3&codigo_proceso_inscripcion=".$proceso_inscripcion->codigo_proceso_inscripcion()."#tab-datosrepresentante");
  }
}

if($lOpt=='Modificar_Paso5'){
  $proceso_inscripcion->codigo_proceso_inscripcion($codigo_proceso_inscripcion);
  $proceso_inscripcion->cedula_persona($cedula_persona);
  $proceso_inscripcion->integracion_educativa($integracion_educativa);
  $proceso_inscripcion->integracion_plomeria($integracion_plomeria);
  $proceso_inscripcion->integracion_electricidad($integracion_electricidad);
  $proceso_inscripcion->integracion_albanileria($integracion_albanileria);
  $proceso_inscripcion->integracion_peluqueria($integracion_peluqueria);
  $proceso_inscripcion->integracion_ambientacion($integracion_ambientacion);
  $proceso_inscripcion->integracion_manualidades($integracion_manualidades);
  $proceso_inscripcion->integracion_bisuteria($integracion_bisuteria);
  $proceso_inscripcion->otra_integracion($otra_integracion);
  $proceso_inscripcion->especifique_integracion($especifique_integracion);
  if($proceso_inscripcion->Actualizar_Paso5($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡Se han modificado los datos de la integración escuela-comunidad en el proceso de inscripción con éxito!";
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=3&codigo_proceso_inscripcion=".$proceso_inscripcion->codigo_proceso_inscripcion()."#tab-integracionec");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar los datos de la integración escuela-comunidad en el proceso de inscripción!";
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=3&codigo_proceso_inscripcion=".$proceso_inscripcion->codigo_proceso_inscripcion()."#tab-integracionec");
  }
}

if($lOpt=='Modificar_Paso6'){
  $proceso_inscripcion->codigo_proceso_inscripcion($codigo_proceso_inscripcion);
  $proceso_inscripcion->cedula_persona($cedula_persona);
  $proceso_inscripcion->fotocopia_ci($fotocopia_ci);
  $proceso_inscripcion->partida_nacimiento($partida_nacimiento);
  $proceso_inscripcion->boleta_promocion($boleta_promocion);
  $proceso_inscripcion->certificado_calificaciones($certificado_calificaciones);
  $proceso_inscripcion->constancia_buenaconducta($constancia_buenaconducta);
  $proceso_inscripcion->fotos_estudiante($fotos_estudiante);
  $proceso_inscripcion->boleta_zonificacion($boleta_zonificacion);
  $proceso_inscripcion->fotocopia_ci_representante($fotocopia_ci_representante);
  $proceso_inscripcion->fotos_representante($fotos_representante);
  $proceso_inscripcion->otro_documento($otro_documento);
  $proceso_inscripcion->cual_documento($cual_documento);
  $proceso_inscripcion->observacion_documentos($observacion_documentos);
  if($proceso_inscripcion->Actualizar_Paso6($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡Se han modificado los datos de los documentos consignados en el proceso de inscripción con éxito!";
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=3&codigo_proceso_inscripcion=".$proceso_inscripcion->codigo_proceso_inscripcion()."#tab-documentos");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar los datos de los documentos consignados en el proceso de inscripción!";
    header("Location: ../view/menu_principal.php?proceso_inscripcion&Opt=3&codigo_proceso_inscripcion=".$proceso_inscripcion->codigo_proceso_inscripcion()."#tab-documentos");
  }
}

if($lOpt=="Asignar_Seccion"){
  $con=0;
  if(isset($_POST['codigos']) && isset($_POST['cedulas'])){
    $proceso_inscripcion->Transaccion('iniciando');
    for($i=0;$i<count($_POST['codigos']);$i++){
      echo "a".$i;
      if($proceso_inscripcion->Asignar_Seccion($_SESSION['user_name'],$_POST['codigos'][$i],$_POST['cedulas'][$i]))
        $con++;
    }
    $rest=count($_POST['codigos'])-$con;
    if($con!=0)
      $proceso_inscripcion->Transaccion('finalizado');
    else
      $proceso_inscripcion->Transaccion('cancelado');
  }
  $_SESSION['datos']['mensaje']="Cantidad de Estudiantes Seleccionados: ".count($_POST['codigos']).", Cantidad Asignados: ".$con.", Cantidad Restantes: ".$rest;
  header("Location: ../view/menu_principal.php?asignar_seccion");
}
  
?>