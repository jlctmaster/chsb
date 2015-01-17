<?php
session_start();

include_once("../class/class_entrega.php");
include_once("../class/class_movimiento_inventario.php");

$entrega=new entrega();
$mov_inventario = new movimiento_inventario();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_entrega']))
  $codigo_entrega=trim($_POST['codigo_entrega']);

if(isset($_POST['codigo_prestamo']))
  $codigo_prestamo=trim($_POST['codigo_prestamo']);

if(isset($_POST['cedula_responsable']))
  $cedula_responsable=trim($_POST['cedula_responsable']);

if(isset($_POST['cedula_persona']))
  $cedula_persona=trim($_POST['cedula_persona']);

if(isset($_POST['fecha_entrada']))
  $fecha_entrada=trim($_POST['fecha_entrada']);

if(isset($_POST['cantidad_a_entregar']))
  $cantidad=trim($_POST['cantidad_a_entregar']);

if($lOpt=='Registrar'){
  $entrega->codigo_entrega($codigo_entrega);
  $entrega->codigo_prestamo($codigo_prestamo);
  $entrega->cedula_responsable($cedula_responsable);
  $entrega->cedula_persona($cedula_persona);
  $entrega->fecha_entrada($fecha_entrada);
  $entrega->cantidad($cantidad);
  $confirmacion=false;
  $entrega->Transaccion('iniciando');
  if(!$entrega->Registrar($_SESSION['user_name'])){
    if($entrega->EliminarEntregas()){
      if(isset($_POST['ejemplar']) && isset($_POST['cantidad']) && isset($_POST['ubicacion'])){
        if($entrega->InsertarEntregas($_SESSION['user_name'],$_POST['ejemplar'],$_POST['ubicacion'],$_POST['cantidad'])){
          //  Registrar Salidas
          $mov_inventario->fecha_movimiento($fecha);
          $mov_inventario->tipo_movimiento('S');
          $mov_inventario->numero_documento($entrega->codigo_entrega());
          $mov_inventario->tipo_transaccion('BE'); // Siglas para identificar la tabla relacionada al movimiento Biblioteca Entrega(BE)
          if($mov_inventario->RegistrarMovimiento($_SESSION['user_name'])){
            $mov_inventario->codigo_movimiento($mov_inventario->ObtenerCodigoMovimiento());
            $conS=0;
            for($i=0;$i<count($_POST['ejemplar']);$i++){
              $mov_inventario->codigo_item($_POST['ejemplar'][$i]);
              $mov_inventario->codigo_ubicacion($_POST['ubicacion'][$i]);
              $mov_inventario->cantidad_movimiento($_POST['cantidad'][$i]);
              $mov_inventario->valor_anterior($mov_inventario->ObtenerValorAnterior());
              $mov_inventario->valor_actual($mov_inventario->ObtenerValorActual($_POST['cantidad'][$i]) == 0 ? $_POST['cantidad'][$i] : $mov_inventario->ObtenerValorActual($_POST['cantidad'][$i]));
              if($mov_inventario->RegistrarDetalleMovimiento($_SESSION['user_name']))
                $conS++;
            }
          }
          else
            $confirmacion=0;
          //  Registrar Entradas
          $mov_inventario->fecha_movimiento($fecha_entrega);
          $mov_inventario->tipo_movimiento('E');
          $mov_inventario->numero_documento($entrega->codigo_entrega());
          $mov_inventario->tipo_transaccion('BE'); // Siglas para identificar la tabla relacionada al movimiento Biblioteca Entrega(BE)
          if($mov_inventario->RegistrarMovimiento($_SESSION['user_name'])){
            $mov_inventario->codigo_movimiento($mov_inventario->ObtenerCodigoMovimiento());
            $conE=0;
            for($i=0;$i<count($_POST['ejemplar']);$i++){
              $mov_inventario->codigo_item($_POST['ejemplar'][$i]);
              $mov_inventario->codigo_ubicacion($_POST['ubicacion'][$i]);
              $mov_inventario->cantidad_movimiento($_POST['cantidad'][$i]);
              $mov_inventario->valor_anterior($mov_inventario->ObtenerValorAnterior());
              $mov_inventario->valor_actual($mov_inventario->ObtenerValorActual($_POST['cantidad'][$i]) == 0 ? $_POST['cantidad'][$i] : $mov_inventario->ObtenerValorActual($_POST['cantidad'][$i]));
              if($mov_inventario->RegistrarDetalleMovimiento($_SESSION['user_name']))
                $conE++;
            }
          }
          else
            $confirmacion=0;

          if($conS==count($_POST['ejemplar']) && $conS==$conE)
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

  if($confirmacion==1){
    $entrega->Transaccion('finalizado');
    $_SESSION['datos']['procesado']="Y";
    $_SESSION['datos']['codigo_entrega']=$entrega->codigo_entrega();
    $_SESSION['datos']['mensaje']="¡La Entrega ha sido registrada con éxito!";
    header("Location: ../view/menu_principal.php?entrega&Opt=2");
  }else{
    $entrega->Transaccion('cancelado');
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar la Entrega!";
    header("Location: ../view/menu_principal.php?entrega&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $entrega->codigo_entrega($codigo_entrega);
  $entrega->codigo_prestamo($codigo_prestamo);
  $entrega->cedula_responsable($cedula_responsable);
  $entrega->cedula_persona($cedula_persona);
  $entrega->fecha_entrada($fecha_entrada);
  $entrega->cantidad($cantidad);
  $confirmacion=false;
  $entrega->Transaccion('iniciando');
  if($entrega->Actualizar($_SESSION['user_name'])){
    if($entrega->EliminarEntregas()){
      if(isset($_POST['ejemplar']) && isset($_POST['ubicacion']) && isset($_POST['cantidad'])){
        if($entrega->InsertarEntregas($_SESSION['user_name'],$_POST['ejemplar'],$_POST['ubicacion'],$_POST['cantidad'])){
          //  Registrar Salidas
          $mov_inventario->fecha_movimiento($fecha_entrega);
          $mov_inventario->tipo_movimiento('S');
          $mov_inventario->numero_documento($codigo_entrega);
          $mov_inventario->tipo_transaccion('BE'); // Siglas para identificar la tabla relacionada al movimiento Biblioteca Entrega(BE)
          $mov_inventario->codigo_movimiento($mov_inventario->ObtenerCodigoMovimiento());
          if($mov_inventario->ModificarMovimiento($_SESSION['user_name'])){
            $conS=0;
            for($i=0;$i<count($_POST['ejemplar']);$i++){
              $mov_inventario->codigo_item($_POST['ejemplar'][$i]);
              $mov_inventario->codigo_ubicacion($_POST['ubicacion'][$i]);
              $mov_inventario->cantidad_movimiento($_POST['cantidad'][$i]);
              $mov_inventario->valor_actual($mov_inventario->ObtenerValorActualModificado($_POST['cantidad'][$i]));
              $mov_inventario->codigo_detalle_movimiento($mov_inventario->ObtenerCodigoDetMovimiento());
              if($mov_inventario->ModificarDetalleMovimiento($_SESSION['user_name']))
                $conS++;
            }
          }
          else
            $confirmacion=0;
          //  Registrar Entradas
          $mov_inventario->fecha_movimiento($fecha_entrega);
          $mov_inventario->tipo_movimiento('E');
          $mov_inventario->numero_documento($codigo_entrega);
          $mov_inventario->tipo_transaccion('BE'); // Siglas para identificar la tabla relacionada al movimiento Biblioteca Entrega(BE)
          $mov_inventario->codigo_movimiento($mov_inventario->ObtenerCodigoMovimiento());
          if($mov_inventario->ModificarMovimiento($_SESSION['user_name'])){
            $conE=0;
            for($i=0;$i<count($_POST['ejemplar']);$i++){
              $mov_inventario->codigo_item($_POST['ejemplar'][$i]);
              $mov_inventario->codigo_ubicacion($_POST['ubicacion'][$i]);
              $mov_inventario->cantidad_movimiento($_POST['cantidad'][$i]);
              $mov_inventario->valor_actual($mov_inventario->ObtenerValorActualModificado($_POST['cantidad'][$i]));
              $mov_inventario->codigo_detalle_movimiento($mov_inventario->ObtenerCodigoDetMovimiento());
              if($mov_inventario->ModificarDetalleMovimiento($_SESSION['user_name']))
                $conE++;
            }
          }
          else
            $confirmacion=0;

          if($conS==count($_POST['ejemplar']) && $conS==$conE)
            $confirmacion=1;
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
    $entrega->Transaccion('finalizado');
    $_SESSION['datos']['mensaje']="¡La Entrega ha sido modificada con éxito!";
    header("Location: ../view/menu_principal.php?entrega&Opt=3&codigo_entrega=".$entrega->codigo_entrega());
  }else{
    $entrega->Transaccion('cancelado');
    echo $entrega->error()."<br>".$mov_inventario->error(); die();
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar la Entrega!";
    header("Location: ../view/menu_principal.php?entrega&Opt=3&codigo_entrega=".$entrega->codigo_entrega());
  }
}

if($lOpt=='Desactivar'){
  $entrega->codigo_entrega($codigo_entrega);
  if($entrega->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Entrega ha sido desactivada con éxito!";
    header("Location: ../view/menu_principal.php?entrega&Opt=3&codigo_entrega=".$entrega->codigo_entrega());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar la Entrega!";
    header("Location: ../view/menu_principal.php?entrega&Opt=3&codigo_entrega=".$entrega->codigo_entrega());
  }
}

if($lOpt=='Activar'){
  $entrega->codigo_entrega($codigo_entrega);
  if($entrega->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Entrega ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?entrega&Opt=3&codigo_entrega=".$entrega->codigo_entrega());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar la Entrega!";
    header("Location: ../view/menu_principal.php?entrega&Opt=3&codigo_entrega=".$entrega->codigo_entrega());
  }
}

if($lOpt=="BuscarCantidadDisponible"){
  echo $mov_inventario->BuscarCantidadDisponible($_POST['codigo_item'],$_POST['codigo_ubicacion']);
  unset($mov_inventario);
}
?>