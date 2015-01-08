<?php
session_start();

include_once("../class/class_adquisicion.php");
include_once("../class/class_movimiento_inventario.php");

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_adquisicion']))
  $codigo_adquisicion=trim($_POST['codigo_adquisicion']);

if(isset($_POST['fecha_adquisicion']))
  $fecha_adquisicion=trim($_POST['fecha_adquisicion']);

if(isset($_POST['tipo_adquisicion']))
  $tipo_adquisicion=trim($_POST['tipo_adquisicion']);

if(isset($_POST['rif_organizacion']))
  $rif_organizacion=trim($_POST['rif_organizacion']);

if(isset($_POST['cedula_persona']))
  $cedula_persona=trim($_POST['cedula_persona']);

if(isset($_POST['sonlibros']))
  $sonlibros=trim($_POST['sonlibros']);

function comprobarCheckBox($value){
  if($value == "on")
    $chk = "Y";
  else
    $chk = "N";
  return $chk;
}

$adquisicion=new adquisicion();
$mov_inventario = new movimiento_inventario();
if($lOpt=='Registrar'){
  $adquisicion->codigo_adquisicion($codigo_adquisicion);
  $adquisicion->fecha_adquisicion($fecha_adquisicion);
  $adquisicion->tipo_adquisicion($tipo_adquisicion);
  $adquisicion->rif_organizacion($rif_organizacion);
  $adquisicion->cedula_persona($cedula_persona);
  $adquisicion->sonlibros(comprobarCheckBox($sonlibros));
  $confirmacion=false;
  $adquisicion->Transaccion('iniciando');
  if(!$adquisicion->Comprobar()){
    if($adquisicion->Registrar($_SESSION['user_name'])){
      if($adquisicion->EliminarAdquisiciones()){
        if(isset($_POST['items']) && isset($_POST['cantidad']) && isset($_POST['ubicacion'])){
          if($adquisicion->InsertarAdquisiciones($_SESSION['user_name'],$_POST['items'],$_POST['cantidad'],$_POST['ubicacion'])){
            $mov_inventario->fecha_movimiento($fecha_adquisicion);
            $mov_inventario->tipo_movimiento('E');
            $mov_inventario->numero_documento($adquisicion->codigo_adquisicion());
            $mov_inventario->tipo_transaccion('IA'); // Siglas para identificar la tabla relacionada al movimiento Inventario Adquisicion (IA)
            if($mov_inventario->RegistrarMovimiento($_SESSION['user_name'])){
              $mov_inventario->codigo_movimiento($mov_inventario->ObtenerCodigoMovimiento());
              $con=0;
              for($i=0;$i<count($_POST['items']);$i++){
                $mov_inventario->codigo_item($_POST['items'][$i]);
                $mov_inventario->codigo_ubicacion($_POST['ubicacion'][$i]);
                $mov_inventario->cantidad_movimiento($_POST['cantidad'][$i]);
                $mov_inventario->valor_anterior($mov_inventario->ObtenerValorAnterior());
                $mov_inventario->valor_actual($mov_inventario->ObtenerValorActual($_POST['cantidad'][$i]) == 0 ? $_POST['cantidad'][$i] : $mov_inventario->ObtenerValorActual($_POST['cantidad'][$i]));
                if($mov_inventario->RegistrarDetalleMovimiento($_SESSION['user_name']))
                  $con++;
              }
              if($con==count($_POST['items']))
                $confirmacion=1;
              else
                $confirmacion=0;
            }
            else
              $confirmacion=0;
          }
          else
            $confirmacion=0;
        }
        else
          $confirmacion=0;
      }
      else
        $confirmacion=0;
    }
    else
      $confirmacion=0;
  }else{
    if($adquisicion->estatus()==1)
      $confirmacion=0;
    else{
      if($adquisicion->Activar($_SESSION['user_name'])){
        if($adquisicion->EliminarAdquisiciones()){
          if(isset($_POST['items']) && isset($_POST['cantidad']) && isset($_POST['ubicacion'])){
            if($adquisicion->InsertarAdquisiciones($_SESSION['user_name'],$_POST['items'],$_POST['cantidad'],$_POST['ubicacion'])){
              $mov_inventario->fecha_movimiento($fecha_adquisicion);
              $mov_inventario->tipo_movimiento('E');
              $mov_inventario->numero_documento($adquisicion->codigo_adquisicion());
              if($mov_inventario->RegistrarMovimiento($_SESSION['user_name'])){
                $mov_inventario->codigo_movimiento($mov_inventario->ObtenerCodigoMovimiento());
                $con=0;
                for($i=0;$i<count($_POST['items']);$i++){
                  $mov_inventario->codigo_item($_POST['items'][$i]);
                  $mov_inventario->codigo_ubicacion($_POST['ubicacion'][$i]);
                  $mov_inventario->cantidad_movimiento($_POST['cantidad'][$i]);
                  $mov_inventario->valor_anterior($mov_inventario->ObtenerValorAnterior());
                  $mov_inventario->valor_actual($mov_inventario->ObtenerValorActual($_POST['cantidad'][$i]) == 0 ? $_POST['cantidad'][$i] : $mov_inventario->ObtenerValorActual($_POST['cantidad'][$i]));
                  if($mov_inventario->RegistrarDetalleMovimiento($_SESSION['user_name']))
                    $con++;
                }
                if($con==count($_POST['items']))
                  $confirmacion=1;
                else
                  $confirmacion=0;
              }
              else
                $confirmacion=0;
            }
            else
              $confirmacion=0;
          }
          else
            $confirmacion=0;
        }
        else
          $confirmacion=0;
      }
      else
        $confirmacion=0;
    }
  }
  if($confirmacion==1){
    $adquisicion->Transaccion('finalizado');
    $_SESSION['datos']['procesado']="Y";
    $_SESSION['datos']['codigo_adquisicion']=$adquisicion->codigo_adquisicion();
    $_SESSION['datos']['mensaje']="¡La Adquisición ha sido registrada con éxito!";
    header("Location: ../view/menu_principal.php?adquisicion&Opt=2");
  }else{
    $adquisicion->Transaccion('cancelado');
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar la Adquisición!";
    header("Location: ../view/menu_principal.php?adquisicion&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $adquisicion->codigo_adquisicion($codigo_adquisicion);
  $adquisicion->fecha_adquisicion($fecha_adquisicion);
  $adquisicion->tipo_adquisicion($tipo_adquisicion);
  $adquisicion->rif_organizacion($rif_organizacion);
  $adquisicion->cedula_persona($cedula_persona);
  $adquisicion->sonlibros(comprobarCheckBox($sonlibros));
  $confirmacion=false;
  $adquisicion->Transaccion('iniciando');
  if($adquisicion->Actualizar($_SESSION['user_name'])){
    if($adquisicion->EliminarAdquisiciones()){
      if(isset($_POST['items']) && isset($_POST['cantidad']) && isset($_POST['ubicacion'])){
        if($adquisicion->InsertarAdquisiciones($_SESSION['user_name'],$_POST['items'],$_POST['cantidad'],$_POST['ubicacion'])){
          $mov_inventario->fecha_movimiento($fecha_adquisicion);
          $mov_inventario->tipo_movimiento('E');
          $mov_inventario->numero_documento($codigo_adquisicion);
          $mov_inventario->tipo_transaccion('IA'); // Siglas para identificar la tabla relacionada al movimiento Inventario Adquisicion (IA)
          $mov_inventario->codigo_movimiento($mov_inventario->ObtenerCodigoMovimiento());
          if($mov_inventario->ModificarMovimiento($_SESSION['user_name'])){
            $con=0;
            for($i=0;$i<count($_POST['items']);$i++){
              $mov_inventario->codigo_item($_POST['items'][$i]);
              $mov_inventario->codigo_ubicacion($_POST['ubicacion'][$i]);
              $mov_inventario->cantidad_movimiento($_POST['cantidad'][$i]);
              $mov_inventario->valor_actual($mov_inventario->ObtenerValorActualModificado($_POST['cantidad'][$i]));
              $mov_inventario->codigo_detalle_movimiento($mov_inventario->ObtenerCodigoDetMovimiento());
              if($mov_inventario->ModificarDetalleMovimiento($_SESSION['user_name']))
                $con++;
            }
            if($con==count($_POST['items']))
              $confirmacion=1;
            else
              $confirmacion=0;
          }
          else
            $confirmacion=0;
        }
        else
          $confirmacion=0;
      }
      else
        $confirmacion=1;
    }
    else
      $confirmacion=1;
  }
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $adquisicion->Transaccion('finalizado');
    $_SESSION['datos']['mensaje']="¡La Adquisición ha sido modificada con éxito!";
    header("Location: ../view/menu_principal.php?adquisicion&Opt=3&codigo_adquisicion=".$adquisicion->codigo_adquisicion());
  }else{
    $adquisicion->Transaccion('cancelado');
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar la Adquisición!";
    header("Location: ../view/menu_principal.php?adquisicion&Opt=3&codigo_adquisicion=".$adquisicion->codigo_adquisicion());
  }
}

if($lOpt=='Desactivar'){
  $adquisicion->codigo_adquisicion($codigo_adquisicion);
  if($adquisicion->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Adquisición ha sido desactivada con éxito!";
    header("Location: ../view/menu_principal.php?adquisicion&Opt=3&codigo_adquisicion=".$adquisicion->codigo_adquisicion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar la Adquisición!";
    header("Location: ../view/menu_principal.php?adquisicion&Opt=3&codigo_adquisicion=".$adquisicion->codigo_adquisicion());
  }
}

if($lOpt=='Activar'){
  $adquisicion->codigo_adquisicion($codigo_adquisicion);
  if($adquisicion->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Adquisición ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?adquisicion&Opt=3&codigo_adquisicion=".$adquisicion->codigo_adquisicion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar la Adquisición!";
    header("Location: ../view/menu_principal.php?adquisicion&Opt=3&codigo_adquisicion=".$adquisicion->codigo_adquisicion());
  }
}   
?>