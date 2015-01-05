<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_recuperacion']))
  $codigo_recuperacion=trim($_POST['codigo_recuperacion']);

if(isset($_POST['fecha']))
  $fecha=trim($_POST['fecha']);

if(isset($_POST['cedula_persona']))
  $cedula_persona=trim($_POST['cedula_persona']);

if(isset($_POST['codigo_ubicacion']))
  $codigo_ubicacion=trim($_POST['codigo_ubicacion']);

if(isset($_POST['codigo_bien']))
  $codigo_bien=trim($_POST['codigo_bien']);

if(isset($_POST['cantidad_a_recuperar']))
  $cantidad=trim($_POST['cantidad_a_recuperar']);

include_once("../class/class_recuperacion.php");
include_once("../class/class_movimiento_inventario.php");
$recuperacion=new recuperacion();
$mov_inventario = new movimiento_inventario();
if($lOpt=='Registrar'){
  $recuperacion->fecha($fecha);
  $recuperacion->cedula_persona($cedula_persona);
  $recuperacion->codigo_ubicacion($codigo_ubicacion);
  $recuperacion->codigo_bien($codigo_bien);
  $recuperacion->cantidad($cantidad);
  $confirmacion=false;
  $recuperacion->Transaccion('iniciando');
  if($recuperacion->Registrar($_SESSION['user_name'])){
    if($recuperacion->EliminarRecuperaciones()){
      if(isset($_POST['items']) && isset($_POST['cantidad']) && isset($_POST['ubicacion'])){
        if($recuperacion->InsertarRecuperaciones($_SESSION['user_name'],$_POST['items'],$_POST['cantidad'],$_POST['ubicacion'])){
          //  Registrar Salidas
          $mov_inventario->fecha_movimiento($fecha);
          $mov_inventario->tipo_movimiento('S');
          $mov_inventario->numero_documento($recuperacion->codigo_recuperacion());
          $mov_inventario->tipo_transaccion('BR'); // Siglas para identificar la tabla relacionada al movimiento Bienes Nacionales Recuperación (BR)
          if($mov_inventario->RegistrarMovimiento($_SESSION['user_name'])){
            $mov_inventario->codigo_movimiento($mov_inventario->ObtenerCodigoMovimiento());
            $mov_inventario->codigo_item($codigo_bien);
            $mov_inventario->codigo_ubicacion($codigo_ubicacion);
            $mov_inventario->cantidad_movimiento($cantidad);
            $mov_inventario->valor_anterior($mov_inventario->ObtenerValorAnterior());
            $mov_inventario->valor_actual($mov_inventario->ObtenerValorActual($cantidad) == 0 ? $cantidad : $mov_inventario->ObtenerValorActual($cantidad));
            if($mov_inventario->RegistrarDetalleMovimiento($_SESSION['user_name'])){
              //  Registrar Entradas
              $mov_inventario->fecha_movimiento($fecha);
              $mov_inventario->tipo_movimiento('E');
              $mov_inventario->numero_documento($recuperacion->codigo_recuperacion());
              $mov_inventario->tipo_transaccion('BR'); // Siglas para identificar la tabla relacionada al movimiento Bienes Nacionales Recuperación (BR)
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
    else
      $confirmacion=0;
  }
  if($confirmacion==1){
    $recuperacion->Transaccion('finalizado');
    $_SESSION['datos']['mensaje']="¡La Recuperación ha sido registrada con éxito!";
    header("Location: ../view/menu_principal.php?recuperacion&Opt=2");
  }else{
    $recuperacion->Transaccion('cancelado');
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar la Recuperación!";
    header("Location: ../view/menu_principal.php?recuperacion&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $recuperacion->codigo_recuperacion($codigo_recuperacion);
  $recuperacion->fecha($fecha);
  $recuperacion->cedula_persona($cedula_persona);
  $recuperacion->codigo_ubicacion($codigo_ubicacion);
  $recuperacion->codigo_bien($codigo_bien);
  $recuperacion->cantidad($cantidad);
  $confirmacion=false;
  $recuperacion->Transaccion('iniciando');
  if($recuperacion->Actualizar($_SESSION['user_name'])){
    if($recuperacion->EliminarRecuperaciones()){
      if(isset($_POST['items']) && isset($_POST['cantidad']) && isset($_POST['ubicacion'])){
        if($recuperacion->InsertarRecuperaciones($_SESSION['user_name'],$_POST['items'],$_POST['cantidad'],$_POST['ubicacion'])){
          //  Modificar Salidas
          $mov_inventario->fecha_movimiento($fecha);
          $mov_inventario->tipo_movimiento('S');
          $mov_inventario->numero_documento($codigo_recuperacion);
          $mov_inventario->tipo_transaccion('BR'); // Siglas para identificar la tabla relacionada al movimiento Bienes Nacionales Recuperación (BR)
          $mov_inventario->codigo_movimiento($mov_inventario->ObtenerCodigoMovimiento());
          if($mov_inventario->ModificarMovimiento($_SESSION['user_name'])){
            $mov_inventario->codigo_item($codigo_bien);
            $mov_inventario->codigo_ubicacion($codigo_ubicacion);
            $mov_inventario->cantidad_movimiento($cantidad);
            $mov_inventario->valor_actual($mov_inventario->ObtenerValorActualModificado($cantidad));
            $mov_inventario->codigo_detalle_movimiento($mov_inventario->ObtenerCodigoDetMovimiento());
            if($mov_inventario->ModificarDetalleMovimiento($_SESSION['user_name'])){
              //  Modificar Entradas
              $mov_inventario->fecha_movimiento($fecha);
              $mov_inventario->tipo_movimiento('E');
              $mov_inventario->numero_documento($codigo_recuperacion);
              $mov_inventario->tipo_transaccion('BR'); // Siglas para identificar la tabla relacionada al movimiento Bienes Nacionales Recuperación (BR)
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
    $recuperacion->Transaccion('finalizado');
    $_SESSION['datos']['mensaje']="¡La Recuperación ha sido modificada con éxito!";
    header("Location: ../view/menu_principal.php?recuperacion&Opt=3&codigo_recuperacion=".$recuperacion->codigo_recuperacion());
  }else{
    $recuperacion->Transaccion('cancelado');
    $recuperacion->error()." => ".$mov_inventario->error(); die();
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar la Recuperación!";
    header("Location: ../view/menu_principal.php?recuperacion&Opt=3&codigo_recuperacion=".$recuperacion->codigo_recuperacion());
  }
}

if($lOpt=='Desactivar'){
  $recuperacion->codigo_recuperacion($codigo_recuperacion);
  if($recuperacion->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Recuperación ha sido desactivada con éxito!";
    header("Location: ../view/menu_principal.php?recuperacion&Opt=3&codigo_recuperacion=".$recuperacion->codigo_recuperacion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar la Recuperación!";
    header("Location: ../view/menu_principal.php?recuperacion&Opt=3&codigo_recuperacion=".$recuperacion->codigo_recuperacion());
  }
}

if($lOpt=='Activar'){
  $recuperacion->codigo_recuperacion($codigo_recuperacion);
  if($recuperacion->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Recuperación ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?recuperacion&Opt=3&codigo_recuperacion=".$recuperacion->codigo_recuperacion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar la Recuperación!";
    header("Location: ../view/menu_principal.php?recuperacion&Opt=3&codigo_recuperacion=".$recuperacion->codigo_recuperacion());
  }
}

if($lOpt=='BuscarDisponibilidad'){
  echo $mov_inventario->BuscarDisponibilidad($_POST['codigo_bien']);
  unset($mov_inventario);
}

if($lOpt=='BuscarUbicacionFuente'){
  echo $mov_inventario->BuscarUbicacionFuente($_POST['codigo_item'],$_POST['cantidad']);
  unset($mov_inventario);
}
?>