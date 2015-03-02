<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['oldrif']))
  $oldrif=trim($_POST['oldrif']);

if(isset($_POST['rif_negocio']))
  $rif_negocio=trim($_POST['rif_negocio']);

if(isset($_POST['nombre']))
  $nombre=trim($_POST['nombre']);

if(isset($_POST['telefono']))
  $telefono=trim($_POST['telefono']);

if(isset($_POST['email']))
  $email=trim($_POST['email']);

if(isset($_POST['clave_email']))
  $clave_email=trim($_POST['clave_email']);

if(isset($_POST['direccion']))
  $direccion=trim($_POST['direccion']);

if(isset($_POST['mision']))
  $mision=trim($_POST['mision']);

if(isset($_POST['vision']))
  $vision=trim($_POST['vision']);

if(isset($_POST['objetivo']))
  $objetivo=trim($_POST['objetivo']);

if(isset($_POST['historia']))
  $historia=trim($_POST['historia']);

if(isset($_POST['codigo_parroquia'])){
  $parroquia=explode("_",trim($_POST['codigo_parroquia']));
  $codigo_parroquia=$parroquia[0];
}

include_once("../class/class_sistema.php");
$sistema=new sistema();
if($lOpt=='Modificar'){
  $sistema->rif_negocio($rif_negocio);
  $sistema->nombre($nombre);
  $sistema->telefono($telefono);
  $sistema->email($email);
  $sistema->clave_email($clave_email);
  $sistema->direccion($direccion);
  $sistema->mision($mision);
  $sistema->vision($vision);
  $sistema->objetivo($objetivo);
  $sistema->historia($historia);
  $sistema->codigo_parroquia($codigo_parroquia);
  if($sistema->Actualizar($_SESSION['user_name'],$oldrif))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡Los Datos del Sistema han sido modificados con éxito!";
    header("Location: ../view/menu_principal.php?sistema&Opt=3&rif_negocio=".$sistema->rif_negocio());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar los Datos del Sistema!";
    header("Location: ../view/menu_principal.php?sistema&Opt=3&rif_negocio=".$sistema->rif_negocio());
  }
} 
?>