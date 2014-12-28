<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['oldrif']))
  $oldrif=trim($_POST['oldrif']);

if(isset($_POST['rif_organizacion']))
  $rif_organizacion=trim($_POST['rif_organizacion']);

if(isset($_POST['nombre']))
  $nombre=trim($_POST['nombre']);

if(isset($_POST['direccion']))
  $direccion=trim($_POST['direccion']);

if(isset($_POST['telefono']))
  $telefono=trim($_POST['telefono']);

if(isset($_POST['tipo_organizacion']))
  $tipo_organizacion=trim($_POST['tipo_organizacion']);

if(isset($_POST['codigo_parroquia']))
  $codigo_parroquia=trim($_POST['codigo_parroquia']);

include_once("../class/class_organizacion.php");
$organizacion=new organizacion();
if($lOpt=='Registrar'){
  $organizacion->rif_organizacion($rif_organizacion);
  $organizacion->nombre($nombre);
  $organizacion->direccion($direccion);
  $organizacion->telefono($telefono);
  $organizacion->tipo_organizacion($tipo_organizacion);
  $organizacion->codigo_parroquia($codigo_parroquia);
  if(!$organizacion->Comprobar()){
    if($organizacion->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($organizacion->estatus()==1)
      $confirmacion=0;
    else{
    if($organizacion->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Organización ha sido registrada con éxito!";
    header("Location: ../view/menu_principal.php?organizacion&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar la Organización!";
    header("Location: ../view/menu_principal.php?organizacion&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $organizacion->rif_organizacion($rif_organizacion);
  $organizacion->nombre($nombre); 
  $organizacion->direccion($direccion);
  $organizacion->telefono($telefono);
  $organizacion->tipo_organizacion($tipo_organizacion);
  $organizacion->codigo_parroquia($codigo_parroquia);
  if($organizacion->Actualizar($_SESSION['user_name'],$oldrif))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Organización ha sido modificada con éxito!";
    header("Location: ../view/menu_principal.php?organizacion&Opt=3&rif_organizacion=".$organizacion->rif_organizacion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar la Organización!";
    header("Location: ../view/menu_principal.php?organizacion&Opt=3&rif_organizacion=".$organizacion->rif_organizacion());
  }
}

if($lOpt=='Desactivar'){
  $organizacion->rif_organizacion($rif_organizacion);
  if($organizacion->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Organización ha sido desactivada con éxito!";
    header("Location: ../view/menu_principal.php?organizacion&Opt=3&rif_organizacion=".$organizacion->rif_organizacion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar la Organización!";
    header("Location: ../view/menu_principal.php?organizacion&Opt=3&rif_organizacion=".$organizacion->rif_organizacion());
  }
}

if($lOpt=='Activar'){
  $organizacion->rif_organizacion($rif_organizacion);
  if($organizacion->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Organización ha sido activada con éxito!";
    header("Location: ../view/menu_principal.php?organizacion&Opt=3&rif_organizacion=".$organizacion->rif_organizacion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar la Organización!";
    header("Location: ../view/menu_principal.php?organizacion&Opt=3&rif_organizacion=".$organizacion->rif_organizacion());
  }
}   
?>