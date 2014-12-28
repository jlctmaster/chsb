<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_configuracion_bien']))
  $codigo_configuracion_bien=trim($_POST['codigo_configuracion_bien']);

if(isset($_POST['codigo_bien']))
  $codigo_bien=trim($_POST['codigo_bien']);

if(isset($_POST['codigo_item']))
  $codigo_item=trim($_POST['codigo_item']);

if(isset($_POST['cantidad']))
  $cantidad=trim($_POST['cantidad']);

if(isset($_POST['item_base']))
  $item_base=trim($_POST['item_base']);

include_once("../class/class_configuracion_bien.php");
$configuracionbien= new configuracion_bien();
if($lOpt=='Registrar'){
  $configuracionbien->codigo_configuracion_bien($codigo_configuracion_bien);
  $configuracionbien->codigo_bien($codigo_bien);
  $configuracionbien->codigo_item($codigo_item);
  $configuracionbien->cantidad($cantidad);
  $configuracionbien->item_base($item_base);
  if(!$configuracionbien->Comprobar()){
    if($configuracionbien->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($configuracionbien->estatus()==1)
      $confirmacion=0;
    else{
    if($configuracionbien->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Configuración del bien ha sido registrada con éxito!";
    header("Location: ../view/menu_principal.php?configuracionbien&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar la Configuración del bien!";
    header("Location: ../view/menu_principal.php?configuracionbien&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $configuracionbien->codigo_configuracion_bien($codigo_configuracion_bien);
  $configuracionbien->codigo_bien($codigo_bien);
  $configuracionbien->codigo_item($codigo_item);
  $configuracionbien->cantidad($cantidad);
  $configuracionbien->item_base($item_base);
  if($configuracionbien->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Configuración del bien ha sido modificada con éxito!";
    header("Location: ../view/menu_principal.php?configuracionbien&Opt=3&codigo_configuracion_bien=".$configuracionbien->codigo_configuracion_bien());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar la Configuración del bien!";
    header("Location: ../view/menu_principal.php?configuracionbien&Opt=3&codigo_configuracion_bien=".$configuracionbien->codigo_configuracion_bien());
  }
}

if($lOpt=='Desactivar'){
  $configuracionbien->codigo_configuracion_bien($codigo_configuracion_bien);
  if($configuracionbien->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Configuración del bien ha sido desactivada con éxito!";
    header("Location: ../view/menu_principal.php?configuracionbien&Opt=3&codigo_configuracion_bien=".$configuracionbien->codigo_configuracion_bien());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar la Configuración del bien!";
    header("Location: ../view/menu_principal.php?configuracionbien&Opt=3&codigo_configuracion_bien=".$configuracionbien->codigo_configuracion_bien());
  }
}

if($lOpt=='Activar'){
  $configuracionbien->codigo_configuracion_bien($codigo_configuracion_bien);
  if($configuracionbien->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Configuración del bien ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?configuracionbien&Opt=3&codigo_configuracion_bien=".$configuracionbien->codigo_configuracion_bien());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar la Configuración del bien!";
    header("Location: ../view/menu_principal.php?configuracionbien&Opt=3&codigo_configuracion_bien=".$configuracionbien->codigo_configuracion_bien());
  }
}   
?>