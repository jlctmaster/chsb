<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_bien']))
  $codigo_bien=trim($_POST['codigo_bien']);

if(isset($_POST['nombre']))
  $nombre=trim($_POST['nombre']);

if(isset($_POST['nro_serial']))
  $nro_serial=trim($_POST['nro_serial']);

if(isset($_POST['codigo_tipo_bien']))
  $codigo_tipo_bien=trim($_POST['codigo_tipo_bien']);

if(isset($_POST['esconfigurable']))
  $esconfigurable=trim($_POST['esconfigurable']);

function comprobarCheckBox($value){
  if($value == "on")
    $chk = "Y";
  else
    $chk = "N";
  return $chk;
}

include_once("../class/class_bien.php");
$bien=new bien();
if($lOpt=='Registrar'){
  $bien->codigo_bien($codigo_bien);
  $bien->nombre($nombre);
  $bien->nro_serial($nro_serial);
  $bien->codigo_tipo_bien($codigo_tipo_bien);
  $bien->esconfigurable(comprobarCheckBox($esconfigurable));
  $confirmacion=false;
  $bien->Transaccion('iniciando');
  if(!$bien->Comprobar()){
    if($bien->Registrar($_SESSION['user_name'])){
      if($bien->EliminarBienes()){
        if(isset($_POST['items']) && isset($_POST['cantidades'])){
          if($bien->InsertarBienes($_SESSION['user_name'],$_POST['items'],$_POST['cantidades'],$_POST['item_base']))
            $confirmacion=1;
          else
            $confirmacion=0;
        }
        else
          $confirmacion=1;
      }
      else
        $confirmacion=0;
    }
    else
      $confirmacion=0;
  }else{
    if($bien->estatus()==1)
      $confirmacion=0;
    else{
      if($bien->Activar($_SESSION['user_name'])){
        if($bien->EliminarBienes()){
          if(isset($_POST['items']) && isset($_POST['cantidades'])){
            if($bien->InsertarBienes($_SESSION['user_name'],$_POST['items'],$_POST['cantidades'],$_POST['item_base'])){
              $confirmacion=1;
            }
            else
              $confirmacion=0;
          }
          else
            $confirmacion=1;
        }
        else
          $confirmacion=0;
      }
      else
        $confirmacion=0;
    }
  }
  if($confirmacion==1){
    $bien->Transaccion('finalizado');
    $_SESSION['datos']['mensaje']="¡El Bien ha sido registrado con éxito!";
    header("Location: ../view/menu_principal.php?bien&Opt=2");
  }else{
    $bien->Transaccion('cancelado');
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Bien!";
    header("Location: ../view/menu_principal.php?bien&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $bien->codigo_bien($codigo_bien);
  $bien->nombre($nombre);
  $bien->nro_serial($nro_serial);
  $bien->codigo_tipo_bien($codigo_tipo_bien);
  $bien->esconfigurable(comprobarCheckBox($esconfigurable));
  $confirmacion=false;
  $bien->Transaccion('iniciando');
  if($bien->Actualizar($_SESSION['user_name'])){
    if($bien->EliminarBienes()){
      if(isset($_POST['items']) && isset($_POST['cantidades'])){
        if($bien->InsertarBienes($_SESSION['user_name'],$_POST['items'],$_POST['cantidades'],$_POST['item_base']))
          $confirmacion=1;
        else
          $confirmacion=0;
      }
      else
        $confirmacion=1;
    }
    else
      $confirmacion=0;
  }
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $bien->Transaccion('finalizado');
    $_SESSION['datos']['mensaje']="¡El Bien ha sido modificado con éxito!";
    header("Location: ../view/menu_principal.php?bien&Opt=3&codigo_bien=".$bien->codigo_bien());
  }else{
    $bien->Transaccion('cancelado');
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el Bien!";
    header("Location: ../view/menu_principal.php?bien&Opt=3&codigo_bien=".$bien->codigo_bien());
  }
}

if($lOpt=='Desactivar'){
  $bien->codigo_bien($codigo_bien);
  if($bien->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Bien ha sido desactivado con éxito!";
    header("Location: ../view/menu_principal.php?bien&Opt=3&codigo_bien=".$bien->codigo_bien());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Bien!";
    header("Location: ../view/menu_principal.php?bien&Opt=3&codigo_bien=".$bien->codigo_bien());
  }
}

if($lOpt=='Activar'){
  $bien->codigo_bien($codigo_bien);
  if($bien->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Bien ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?bien&Opt=3&codigo_bien=".$bien->codigo_bien());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Bien!";
    header("Location: ../view/menu_principal.php?bien&Opt=3&codigo_bien=".$bien->codigo_bien());
  }
}   
?>