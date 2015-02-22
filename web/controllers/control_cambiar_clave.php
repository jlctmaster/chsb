<?php
session_start(); 
if(isset($_POST['cambiar_clave_con_logeo']) and $_POST['cambiar_clave_con_logeo']==0 and isset($_POST['lOpt']) and $_POST['lOpt']=='Modificar'){
  if(!(isset($_SESSION['user_name']) and isset($_SESSION['user_password']) and $_SESSION['user_perfil']))
    header("Location: controllers/control_desconectar.php");
  else if($_POST['nueva_contrasena']!=$_POST['confirmar_contrasena']){
    $_SESSION['datos']['mensaje']="¡Las contraseñas no coeciden!";
    header("Location: ../view/menu_principal.php?cambiarcontrasena");
  }else if(strlen($_POST['nueva_contrasena'])< $_POST['nlongitud_minclave']){
    $_SESSION['datos']['mensaje']="¡La contraseña debe tener mínimo ".$_POST['nlongitud_minclave']." caracteres!";
    header("Location: ../view/menu_principal.php?cambiarcontrasena");
  }else if($_POST['nueva_contrasena']==$_POST['confirmar_contrasena']){
    include("../class/class_usuario.php");
    $Usuario=new Usuario();
    $Usuario->nombre_usuario($_SESSION['user_name']);
    $Usuario->contrasena($_POST['nueva_contrasena']);    
    if($Usuario->Buscar_ultimas_3_clave()==false){
      if($Usuario->Cambiar_Clave($_SESSION['user_name'])){
        $_SESSION['datos']['mensaje']="¡Tu contraseña ha sido cambiada con éxito!";
        $_SESSION['user_password']=sha1(md5($_POST['nueva_contrasena']));
        header("Location: ../view/menu_principal.php?cambiarcontrasena");
      }
      else{
        $_SESSION['datos']['mensaje']="¡Ocurrió un error al cambiar tu contraseña!";
        header("Location: ../view/menu_principal.php?cambiarcontrasena");
      }
    }else{
      $_SESSION['datos']['mensaje']="¡Esta contraseña ha sido usado anteriormente, usa una contraseña nueva!";
      header("Location: ../view/menu_principal.php?cambiarcontrasena");
    }
  }else{
    header("Location: ../view/menu_principal.php?cambiarcontrasena");
  }
}

if(isset($_POST['lOpt']) and $_POST['lOpt']=='Registrar'){
  include("../class/class_usuario.php");
  $Usuario=new Usuario();
  $Usuario->cedula_persona($_POST['cedula_persona']);
  if($Usuario->Consultar_personal()){
    $Usuario=new Usuario();
    $Usuario->codigo_perfil(trim($_POST['codigo_perfil']));
    $Usuario->nombre_usuario($Usuario->Generar_NombreUsuario(trim($_POST['cedula_persona']),trim($_POST['codigo_perfil'])));
    $Usuario->cedula_persona(trim($_POST['cedula_persona']));
    if(!$Usuario->Registrar($_SESSION['user_name'])){
      $_SESSION['datos']['mensaje']="¡Lo sentimos, el usuario no se ha podido registrar, intenta más tarde!";
      header("Location: ../view/menu_principal.php?nuevousuario");
    }else{
      $_SESSION['datos']['mensaje']="¡El usuario se ha creado con éxito!";
      header("Location: ../view/menu_principal.php?nuevousuario");
    }
  }else{
  $_SESSION['datos']['mensaje']="¡Lo sentimos, (".$_POST['cedula_persona'].") no esta registrado como personal administrativo!";
  }
  header("Location: ../view/menu_principal.php?nuevousuario");
}

if(isset($_POST['lOpt']) and $_POST['lOpt']=='Modificar'){
  include("../class/class_usuario.php");
  $Usuario=new Usuario();
  if($_SESSION['user_estado']<>3){
    $Usuario->nombre_usuario($_POST['nombre_usuario']);
    if($Usuario->Actualizar($_SESSION['user_name'],$_SESSION['user_pregunta'],$_POST['pregunta'],$_POST['respuesta'])){
      $Usuario->nombre_usuario($_POST['nombre_usuario']);
      $res=$Usuario->Buscar();
      if($res!=null){
        for($i=0;$i<$res[0]['numero_preguntas'];$i++){
           $preguntas[]=$res[$i]['preguntas'];
           $respuestas[]=$res[$i]['respuestas'];
        }
        unset($_SESSION['user_pregunta']);
        unset($_SESSION['user_respuesta']);
        $_SESSION['user_pregunta']=$preguntas;
        $_SESSION['user_respuesta']=$respuestas;
      }
      $_SESSION['datos']['mensaje']="¡Se han realizado los cambios exitosamente!";
      $_SESSION['user_estado']=1;
      header("Location: ../view/menu_principal.php?perfil");
    }else{
      $_SESSION['datos']['mensaje']="¡Ocurrió un error al actualizar los datos, intenta más tarde!";
      header("Location: ../view/menu_principal.php?perfil");
    }
  }
  else{
    $Usuario->nombre_usuario($_POST['nombre_usuario']);
    $Usuario->contrasena($_POST['nueva_contrasena']);
    if($Usuario->Cambiar_Clave($_SESSION['user_name'])){
      if($Usuario->CompletarDatos($_SESSION['user_name'],$_POST['pregunta'],$_POST['respuesta'])){
        $Usuario->nombre_usuario($_POST['nombre_usuario']);
        $res=$Usuario->Buscar();
        if($res!=null){
          for($i=0;$i<$res[0]['numero_preguntas'];$i++){
             $preguntas[]=$res[$i]['preguntas'];
             $respuestas[]=$res[$i]['respuestas'];
          }
          unset($_SESSION['user_pregunta']);
          unset($_SESSION['user_respuesta']);
          $_SESSION['user_pregunta']=$preguntas;
          $_SESSION['user_respuesta']=$respuestas;
        }
        $_SESSION['datos']['mensaje']="¡Se han realizado los cambios exitosamente!";
        $_SESSION['user_estado']=1;
        header("Location: ../view/menu_principal.php");
      }else{
        $_SESSION['datos']['mensaje']="¡Ocurrió un error al actualizar los datos, intenta más tarde!";
        header("Location: ../view/menu_principal.php");
      }
    }else{
      $_SESSION['datos']['mensaje']="¡Ocurrió un error al actualizar los datos, intenta más tarde!";
      header("Location: ../view/menu_principal.php");
    }
  }
}

if(isset($_POST['cambiar_clave_sin_logeo'])){	

  if(isset($_POST['ambiente']) && $_POST['ambiente']=="1"){
     $file = fopen("../class/conf.php", "w");
     fwrite($file, "<?php" . PHP_EOL);
     fwrite($file, "define('SERVER','localhost');" . PHP_EOL);
     fwrite($file, "define('PORT','5432');" . PHP_EOL);
     fwrite($file, "define('USER','admin');" . PHP_EOL);
     fwrite($file, "define('PASSWORD','4dm1n12tr4t0r');" . PHP_EOL);
     fwrite($file, "define('BD','chsbdb');" . PHP_EOL);
     fwrite($file, "?>" . PHP_EOL);
     fclose($file);
     $ambiente=$_POST['ambiente'];
  }else if(isset($_POST['ambiente']) && $_POST['ambiente']=="2"){
     $file = fopen("../class/conf.php", "w");
     fwrite($file, "<?php" . PHP_EOL);
     fwrite($file, "define('SERVER','localhost');" . PHP_EOL);
     fwrite($file, "define('PORT','5432');" . PHP_EOL);
     fwrite($file, "define('USER','admin');" . PHP_EOL);
     fwrite($file, "define('PASSWORD','4dm1n12tr4t0r');" . PHP_EOL);
     fwrite($file, "define('BD','bdchsb');" . PHP_EOL);
     fwrite($file, "?>" . PHP_EOL);
     fclose($file);
     $ambiente=$_POST['ambiente'];
  }else{
     $_SESSION['datos']['mensaje']="¡No se ha definido una conexión al servidor para el ambiente para el sistema!";
     header("Location: ../../#intranet");
  }

  if($_POST['nueva_contrasena']!=$_POST['confirmar_contrasena']){
    $_SESSION['datos']['mensaje']="Las contraseñas no coeciden!";
    header("Location: ../view/intranet.php?p=cambiar-contrasena");
  }else if($_POST['nueva_contrasena']==$_POST['confirmar_contrasena']){
    include("../class/class_usuario.php");
    $Usuario=new Usuario();
    $Usuario->nombre_usuario($_SESSION['user_name']);
    $Usuario->contrasena($_POST['nueva_contrasena']);
    if($Usuario->Buscar_ultimas_3_clave()==false){
      if($Usuario->Cambiar_Clave($_SESSION['user_name'])){
        $_SESSION['datos']['mensaje']="¡Tu contraseña ha sido cambiada exitosamente!";
        $_SESSION['user_password']=sha1(md5($_POST['nueva_contrasena']));
        header("Location: ../../#intranet");
      }
      else{
        $_SESSION['datos']['mensaje']="¡Ocurrió un error al cambiar tu contraseña!";
        header("Location: ../../#intranet");
      }
    }else{
      $_SESSION['ambiente']=$ambiente;
      $_SESSION['pregunta_respuesta']=4;
      $_SESSION['datos']['mensaje']="¡Esta contraseña ha sido usado anteriormente, usa una contraseña nueva!";
      header("Location: ../../?p=cambiar-contrasena#intranet");
    }
  }else{
    header("Location: ../../");
  }
}	
?>