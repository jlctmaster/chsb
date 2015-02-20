<?php
session_start();

//  Variables para indicar si hace la comprobación del registro

$comprobar=true;

if(isset($_POST['oldperfil']))
  $oldperfil=trim($_POST['oldperfil']);

//  Fin

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_perfil']))
  $codigo_perfil=trim($_POST['codigo_perfil']);

if(isset($_POST['codigo_configuracion']))
  $codigo_configuracion=trim($_POST['codigo_configuracion']);

if(isset($_POST['nombre_perfil']))
$nombre_perfil=trim($_POST['nombre_perfil']);

include_once("../class/class_perfil.php");
$perfil=new Perfil();
if($lOpt=='Registrar'){
  $perfil->codigo_perfil($codigo_perfil);
  $perfil->codigo_configuracion($codigo_configuracion);
  $perfil->nombre_perfil($nombre_perfil);
  if(!$perfil->Comprobar($comprobar)){
    if($perfil->Registrar($_SESSION['user_name'])){
      $confirmacion=1;
      if(isset($_POST['modulos']) && isset($_POST['servicios']) && isset($_POST['opciones'])){
        $perfil->ELIMINAR_OPCION_SERVICIO_PERFIL();
        $perfil->INSERTAR_OPCION_SERVICIO_PERFIL($_SESSION['user_name'],$_POST['modulos'],$_POST['servicios'],$_POST['opciones']);
      }
    }else
      $confirmacion=-1;
  }else{
    if($perfil->estatus()==1)
      $confirmacion=0;
    else{
      if($perfil->Activar($_SESSION['user_name']))					  
        $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Perfil ha sido registrado con éxito!";
    header("Location: ../view/menu_principal.php?perfiles&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Perfil!";
    header("Location: ../view/menu_principal.php?perfiles&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $perfil->codigo_perfil($codigo_perfil);
  $perfil->codigo_configuracion($codigo_configuracion);
  $perfil->nombre_perfil($nombre_perfil);
  if($oldperfil==$nombre_perfil)
    $comprobar=false;
  if(!$perfil->Comprobar($comprobar)){
    if($perfil->Actualizar($_SESSION['user_name'])){
      $confirmacion=1;
      if(isset($_POST['modulos']) && isset($_POST['servicios']) && isset($_POST['opciones'])){
        $perfil->ELIMINAR_OPCION_SERVICIO_PERFIL();
        $perfil->INSERTAR_OPCION_SERVICIO_PERFIL($_SESSION['user_name'],$_POST['modulos'],$_POST['servicios'],$_POST['opciones']);
      }
    }
    else
      $confirmacion=-1;
  }else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Perfil ha sido modificado con éxito!";
    @header("Location: ../view/menu_principal.php?perfiles&Opt=3&codigo_perfil=".$perfil->codigo_perfil());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el perfil!";
    header("Location: ../view/menu_principal.php?perfiles&Opt=3&codigo_perfil=".$perfil->codigo_perfil());
  }
}

if($lOpt=='Desactivar'){
  $perfil->codigo_perfil($codigo_perfil);
  if($perfil->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Perfil ha sido desactivado con éxito!";
    header("Location: ../view/menu_principal.php?perfiles&Opt=3&codigo_perfil=".$perfil->codigo_perfil());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Perfil!";
    header("Location: ../view/menu_principal.php?perfiles&Opt=3&codigo_perfil=".$perfil->codigo_perfil());
  }
}

if($lOpt=='Activar'){
  $perfil->codigo_perfil($codigo_perfil);
  if($perfil->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Perfil ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?perfiles&Opt=3&codigo_perfil=".$perfil->codigo_perfil());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Perfil!";
    header("Location: ../view/menu_principal.php?perfiles&Opt=3&codigo_perfil=".$perfil->codigo_perfil());
  }
}	  
?>