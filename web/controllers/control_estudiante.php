<?php
session_start();
include_once("../class/class_estudiante.php");

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

if(isset($_POST['cedula_responsable']))
  $cedula_responsable=trim($_POST['cedula_responsable']);

if(isset($_POST['oldci']))
  $oldci=trim($_POST['oldci']);

if(isset($_POST['cedula_persona']))
  $cedula_persona=trim($_POST['cedula_persona']);

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

if(isset($_POST['fecha_nacimiento']))
  $fecha_nacimiento=trim($_POST['fecha_nacimiento']);

if(isset($_POST['lugar_nacimiento']))
  $lugar_nacimiento=trim($_POST['lugar_nacimiento']);

if(isset($_POST['direccion']))
  $direccion=trim($_POST['direccion']);

if(isset($_POST['telefono_local']))
  $telefono_local=trim($_POST['telefono_local']);

if(isset($_POST['telefono_movil']))
  $telefono_movil=trim($_POST['telefono_movil']);

if(isset($_POST['anio_a_cursar'])){
  $anio_a_cursar=trim($_POST['anio_a_cursar']);
  $coordinacion_pedagogica=trim($_POST['anio_a_cursar']);
}

if(isset($_POST['peso']))
  $peso=trim($_POST['peso']);

if(isset($_POST['talla']))
  $talla=trim($_POST['talla']);

if(isset($_POST['cedula_representante']))
  $cedula_representante=trim($_POST['cedula_representante']);

if(isset($_POST['codigo_parentesco']))
  $codigo_parentesco=trim($_POST['codigo_parentesco']);

if(isset($_POST['seccion']))
  $seccion=trim($_POST['seccion']);

if(isset($_POST['observacion']))
  $observacion=trim($_POST['observacion']);

$estudiante=new estudiante();
if($lOpt=='Registrar'){
  $estudiante->codigo_inscripcion($codigo_inscripcion);
  $estudiante->fecha_inscripcion($fecha_inscripcion);
  $estudiante->codigo_ano_academico($codigo_ano_academico);
  $estudiante->cedula_responsable($cedula_responsable);
  $estudiante->cedula_persona($cedula_persona);
  $estudiante->primer_nombre($primer_nombre);
  $estudiante->segundo_nombre($segundo_nombre);
  $estudiante->primer_apellido($primer_apellido);
  $estudiante->segundo_apellido($segundo_apellido);
  $estudiante->sexo($sexo);
  $estudiante->fecha_nacimiento($fecha_nacimiento);
  $estudiante->lugar_nacimiento($lugar_nacimiento);
  $estudiante->direccion($direccion);
  $estudiante->telefono_local($telefono_local);
  $estudiante->telefono_movil($telefono_movil);
  $estudiante->anio_a_cursar($anio_a_cursar);
  $estudiante->coordinacion_pedagogica($coordinacion_pedagogica);
  $estudiante->peso($peso);
  $estudiante->talla($talla);
  $estudiante->cedula_representante($cedula_representante);
  $estudiante->codigo_parentesco($codigo_parentesco);
  $confirmacion=false;
  $estudiante->Transaccion('iniciando');
  if(!$estudiante->Comprobar()){
    if($estudiante->Registrar($_SESSION['user_name'])){
      if($estudiante->Inscribir($_SESSION['user_name'])){
        $confirmacion=1;
      }
      else
        $confirmacion=-1;
    }
    else
      $confirmacion=-1;
  }else{
    if($estudiante->estatus()==1)
      $confirmacion=0;
    else{
    if($estudiante->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $estudiante->Transaccion('finalizado');
    $estudiante->ObtenerCodigoPI();
    $_SESSION['datos']['procesado']="Y";
    $_SESSION['datos']['codigo_proceso_inscripcion']=$estudiante->codigo_proceso_inscripcion();
    $_SESSION['datos']['mensaje']="¡El Estudiante ha sido registrado con éxito!";
    header("Location: ../view/menu_principal.php?estudiante&Opt=2");
  }else{
    $estudiante->Transaccion('cancelado');
    echo $estudiante->error(); die();
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Estudiante!";
    header("Location: ../view/menu_principal.php?estudiante&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $estudiante->codigo_proceso_inscripcion($codigo_proceso_inscripcion);
  $estudiante->codigo_inscripcion($codigo_inscripcion);
  $estudiante->fecha_inscripcion($fecha_inscripcion);
  $estudiante->codigo_ano_academico($codigo_ano_academico);
  $estudiante->cedula_responsable($cedula_responsable);
  $estudiante->cedula_persona($cedula_persona);
  $estudiante->primer_nombre($primer_nombre);
  $estudiante->segundo_nombre($segundo_nombre);
  $estudiante->primer_apellido($primer_apellido);
  $estudiante->segundo_apellido($segundo_apellido);
  $estudiante->sexo($sexo);
  $estudiante->fecha_nacimiento($fecha_nacimiento);
  $estudiante->lugar_nacimiento($lugar_nacimiento);
  $estudiante->direccion($direccion);
  $estudiante->telefono_local($telefono_local);
  $estudiante->telefono_movil($telefono_movil);
  $estudiante->anio_a_cursar($anio_a_cursar);
  $estudiante->coordinacion_pedagogica($coordinacion_pedagogica);
  $estudiante->peso($peso);
  $estudiante->talla($talla);
  $estudiante->cedula_representante($cedula_representante);
  $estudiante->codigo_parentesco($codigo_parentesco);
  $estudiante->seccion($seccion);
  $estudiante->observacion($observacion);
  $confirmacion=false;
  $estudiante->Transaccion('iniciando');
  if($estudiante->Actualizar($_SESSION['user_name'],$oldci)){
    if($estudiante->ActualizarInscripcion($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $estudiante->Transaccion('finalizado');
    $_SESSION['datos']['mensaje']="¡El Estudiante ha sido modificado con éxito!";
    header("Location: ../view/menu_principal.php?estudiante&Opt=3&cedula_persona=".$estudiante->cedula_persona());
  }else{
    $estudiante->Transaccion('cancelado');
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el Estudiante!";
    header("Location: ../view/menu_principal.php?estudiante&Opt=3&cedula_persona=".$estudiante->cedula_persona());
  }
}

if($lOpt=='Desactivar'){
  $estudiante->cedula_persona($cedula_persona);
  if($estudiante->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Estudiante ha sido desactivado con éxito!";
    header("Location: ../view/menu_principal.php?estudiante&Opt=3&cedula_persona=".$estudiante->cedula_persona());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Estudiante!";
    header("Location: ../view/menu_principal.php?estudiante&Opt=3&cedula_persona=".$estudiante->cedula_persona());
  }
}

if($lOpt=='Activar'){
  $estudiante->cedula_persona($cedula_persona);
  if($estudiante->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Estudiante ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?estudiante&Opt=3&cedula_persona=".$estudiante->cedula_persona());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Estudiante!";
    header("Location: ../view/menu_principal.php?estudiante&Opt=3&cedula_persona=".$estudiante->cedula_persona());
  }
}   
?>