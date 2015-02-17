<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['nid_combovalor']))
  $nid_combovalor=trim($_POST['nid_combovalor']);

if(isset($_POST['ctabla']))
  $ctabla=trim($_POST['ctabla']);

if(isset($_POST['cdescripcion']))
  $cdescripcion=trim($_POST['cdescripcion']);

include_once("../class/class_combovalor.php");
$combovalor=new Combovalor();
if($lOpt=='Registrar'){
  $combovalor->nid_combovalor($nid_combovalor);
  $combovalor->ctabla($ctabla);
  $combovalor->cdescripcion($cdescripcion);
  if(!$combovalor->Comprobar()){
    if($combovalor->Registrar())
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($combovalor->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($combovalor->Activar())            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El valor del combo ha sido registrado con exito!";
    header("Location: ../view/menu_principal.php?combovalor&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el valor del combo!";
    header("Location: ../view/menu_principal.php?combovalor&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $combovalor->nid_combovalor($nid_combovalor);
  $combovalor->ctabla($ctabla);
  $combovalor->cdescripcion($cdescripcion);
  if(!$combovalor->Comprobar()){
    if($combovalor->Actualizar())
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El valor del combo ha sido modificado con exito!";
    header("Location: ../view/menu_principal.php?combovalor&Opt=3&nid_combovalor=".$combovalor->nid_combovalor());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el valor del combo!";
    header("Location: ../view/menu_principal.php?combovalor&Opt=3&nid_combovalor=".$combovalor->nid_combovalor());
  }
}

if($lOpt=='Desactivar'){
  $combovalor->nid_combovalor($nid_combovalor);
  if($combovalor->Consultar()){
    if($combovalor->Desactivar())
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El valor del combo ha sido desactivado con exito!";
    header("Location: ../view/menu_principal.php?combovalor&Opt=3&nid_combovalor=".$combovalor->nid_combovalor());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el valor del combo!";
    header("Location: ../view/menu_principal.php?combovalor&Opt=3&nid_combovalor=".$combovalor->nid_combovalor());
  }
}

if($lOpt=='Activar'){
  $combovalor->nid_combovalor($nid_combovalor);
  if($combovalor->Consultar()){
    if($combovalor->Activar())
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El valor del combo ha sido activado con exito!";
    header("Location: ../view/menu_principal.php?combovalor&Opt=3&nid_combovalor=".$combovalor->nid_combovalor());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el valor del combo!";
    header("Location: ../view/menu_principal.php?combovalor&Opt=3&nid_combovalor=".$combovalor->nid_combovalor());
  }
}   
?>