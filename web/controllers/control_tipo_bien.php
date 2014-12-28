<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_tipo_bien']))
  $codigo_tipo_bien=trim($_POST['codigo_tipo_bien']);

if(isset($_POST['descripcion']))
  $descripcion=trim($_POST['descripcion']);

include_once("../class/class_tipo_bien.php");
$tipo_bien=new tipobien();
if($lOpt=='Registrar'){
  $tipo_bien->codigo_tipo_bien($codigo_tipo_bien);
  $tipo_bien->descripcion($descripcion);
  if(!$tipo_bien->Comprobar()){
    if($tipo_bien->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($tipo_bien->estatus()==1)
      $confirmacion=0;
    else{
    if($tipo_bien->Activar())            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Tipo de Bien Nacional ha sido registrado con éxito!";
    header("Location: ../view/menu_principal.php?tipo_bien&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Tipo de Bien Nacional!";
    header("Location: ../view/menu_principal.php?tipo_bien&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $tipo_bien->codigo_tipo_bien($codigo_tipo_bien);
  $tipo_bien->descripcion($descripcion);
  if($tipo_bien->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Tipo de Bien Nacional ha sido modificado con éxito!";
    header("Location: ../view/menu_principal.php?tipo_bien&Opt=3&codigo_tipo_bien=".$tipo_bien->codigo_tipo_bien());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el Tipo de Bien Nacional!";
    header("Location: ../view/menu_principal.php?tipo_bien&Opt=3&codigo_tipo_bien=".$tipo_bien->codigo_tipo_bien());
  }
}

if($lOpt=='Desactivar'){
  $tipo_bien->codigo_tipo_bien($codigo_tipo_bien);
  if($tipo_bien->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Tipo de Bien Nacional ha sido desactivado con éxito!";
    header("Location: ../view/menu_principal.php?tipo_bien&Opt=3&codigo_tipo_bien=".$tipo_bien->codigo_tipo_bien());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Tipo de Bien Nacional!";
    header("Location: ../view/menu_principal.php?tipo_bien&Opt=3&codigo_tipo_bien=".$tipo_bien->codigo_tipo_bien());
  }
}

if($lOpt=='Activar'){
  $tipo_bien->codigo_tipo_bien($codigo_tipo_bien);
  if($tipo_bien->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Tipo de Bien Nacional ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?tipo_bien&Opt=3&codigo_tipo_bien=".$tipo_bien->codigo_tipo_bien());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Tipo de Bien Nacional!";
    header("Location: ../view/menu_principal.php?tipo_bien&Opt=3&codigo_tipo_bien=".$tipo_bien->codigo_tipo_bien());
  }
}   
?>