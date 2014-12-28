<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_configuracion']))
  $codigo_configuracion=trim($_POST['codigo_configuracion']);

if(isset($_POST['descripcion']))
  $descripcion=trim($_POST['descripcion']);

if(isset($_POST['longitud_minclave']))
  $longitud_minclave=trim($_POST['longitud_minclave']);

if(isset($_POST['longitud_maxclave']))
  $longitud_maxclave=trim($_POST['longitud_maxclave']);

if(isset($_POST['cantidad_letrasmayusculas']))
  $cantidad_letrasmayusculas=trim($_POST['cantidad_letrasmayusculas']);

if(isset($_POST['cantidad_letrasminusculas']))
  $cantidad_letrasminusculas=trim($_POST['cantidad_letrasminusculas']);

if(isset($_POST['cantidad_caracteresespeciales']))
  $cantidad_caracteresespeciales=trim($_POST['cantidad_caracteresespeciales']);

if(isset($_POST['cantidad_numeros']))
  $cantidad_numeros=trim($_POST['cantidad_numeros']);

if(isset($_POST['dias_vigenciaclave']))
  $dias_vigenciaclave=trim($_POST['dias_vigenciaclave']);

if(isset($_POST['numero_ultimasclaves']))
  $numero_ultimasclaves=trim($_POST['numero_ultimasclaves']);

if(isset($_POST['dias_aviso']))
  $dias_aviso=trim($_POST['dias_aviso']);

if(isset($_POST['intentos_fallidos']))
  $intentos_fallidos=trim($_POST['intentos_fallidos']);

if(isset($_POST['numero_preguntas']))
  $numero_preguntas=trim($_POST['numero_preguntas']);

if(isset($_POST['numero_preguntasaresponder']))
  $numero_preguntasaresponder=trim($_POST['numero_preguntasaresponder']);

include_once("../class/class_configuracion.php");
$configuracion=new configuracion();
if($lOpt=='Registrar'){
  $configuracion->codigo_configuracion($codigo_configuracion);
  $configuracion->descripcion($descripcion);
  $configuracion->longitud_minclave($longitud_minclave);
  $configuracion->longitud_maxclave($longitud_maxclave);
  $configuracion->cantidad_letrasmayusculas($cantidad_letrasmayusculas);
  $configuracion->cantidad_letrasminusculas($cantidad_letrasminusculas);
  $configuracion->cantidad_caracteresespeciales($cantidad_caracteresespeciales);
  $configuracion->cantidad_numeros($cantidad_numeros);
  $configuracion->dias_vigenciaclave($dias_vigenciaclave);
  $configuracion->numero_ultimasclaves($numero_ultimasclaves);
  $configuracion->dias_aviso($dias_aviso);
  $configuracion->intentos_fallidos($intentos_fallidos);
  $configuracion->numero_preguntas($numero_preguntas);
  $configuracion->numero_preguntasaresponder($numero_preguntasaresponder);
  if(!$configuracion->Comprobar()){
    if($configuracion->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($configuracion->estatus()==1)
      $confirmacion=0;
    else{
    if($configuracion->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Configuración del Sistema ha sido registrada con exito!";
    header("Location: ../view/menu_principal.php?configuracion&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar la Configuración del Sistema!";
    header("Location: ../view/menu_principal.php?configuracion&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $configuracion->codigo_configuracion($codigo_configuracion);
  $configuracion->descripcion($descripcion);
  $configuracion->longitud_minclave($longitud_minclave);
  $configuracion->longitud_maxclave($longitud_maxclave);
  $configuracion->cantidad_letrasmayusculas($cantidad_letrasmayusculas);
  $configuracion->cantidad_letrasminusculas($cantidad_letrasminusculas);
  $configuracion->cantidad_caracteresespeciales($cantidad_caracteresespeciales);
  $configuracion->cantidad_numeros($cantidad_numeros);
  $configuracion->dias_vigenciaclave($dias_vigenciaclave);
  $configuracion->numero_ultimasclaves($numero_ultimasclaves);
  $configuracion->dias_aviso($dias_aviso);
  $configuracion->intentos_fallidos($intentos_fallidos);
  $configuracion->numero_preguntas($numero_preguntas);
  $configuracion->numero_preguntasaresponder($numero_preguntasaresponder);
  if($configuracion->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Configuración del Sistema ha sido modificada con exito!";
    header("Location: ../view/menu_principal.php?configuracion&Opt=3&codigo_configuracion=".$configuracion->codigo_configuracion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar la Configuración del Sistema!";
    header("Location: ../view/menu_principal.php?configuracion&Opt=3&codigo_configuracion=".$configuracion->codigo_configuracion());
  }
}

if($lOpt=='Desactivar'){
  $configuracion->codigo_configuracion($codigo_configuracion);
  if($configuracion->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Configuración del Sistema ha sido desactivada con exito!";
    header("Location: ../view/menu_principal.php?configuracion&Opt=3&codigo_configuracion=".$configuracion->codigo_configuracion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar la Configuración del Sistema!";
    header("Location: ../view/menu_principal.php?configuracion&Opt=3&codigo_configuracion=".$configuracion->codigo_configuracion());
  }
}

if($lOpt=='Activar'){
  $configuracion->codigo_configuracion($codigo_configuracion);
  if($configuracion->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Configuración del Sistema ha sido activada con exito!";
    header("Location: ../view/menu_principal.php?configuracion&Opt=3&codigo_configuracion=".$configuracion->codigo_configuracion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar la Configuración del Sistema!";
    header("Location: ../view/menu_principal.php?configuracion&Opt=3&codigo_configuracion=".$configuracion->codigo_configuracion());
  }
}   
?>