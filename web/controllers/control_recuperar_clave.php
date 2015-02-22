<?php
//Verificar Inicio de Session.
session_start(); 

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
  header("Location: ../../?p=olvidar-clave#intranet");
  exit;
}

if(isset($_POST['user_name']) || isset($_POST['respuesta'])){
   include("../class/class_usuario.php");
   $Usuario=new Usuario();
   $Usuario->nombre_usuario(trim($_POST['user_name']));
   if($_POST['accion']==1){
      $con=0;
      for($i=0;$i<$_SESSION['user_preguntas_a_responder'];$i++){
         if($_SESSION['user_respuesta'][$i]==$_POST['respuesta'][$i]){
            $con++;
         }else{
            $con--;
         }
      }
      if($con==$_SESSION['user_preguntas_a_responder']){
         $_SESSION['pregunta_respuesta']=4;
         $_SESSION['user_passwd'];
         header("Location: ../../?p=cambiar-contrasena#intranet");
      }
      else{
         $Usuario->nombre_usuario($_SESSION['user_name']);
         $res=$Usuario->Buscar_1();
         if($res!=null){
            for($i=0;$i<$res[0]['numero_preguntas'];$i++){
               $preguntas[]=$res[$i]['preguntas'];
               $respuestas[]=$res[$i]['respuestas'];
            }
            $_SESSION['user_pregunta']=$preguntas;
            $_SESSION['user_respuesta']=$respuestas;
            $_SESSION['datos']['mensaje']="¡La respuesta no coecide con los datos del sistema!";
            $_SESSION['pregunta_respuesta']=$_POST['accion']+1;
            header("Location: ../../?p=pregunta-seguridad#intranet");
         }else{
            $_SESSION['datos']['mensaje']="¡Ocurrió un error al realizar la transacción!";
            header("Location: ../../?p=olvidar-clave#intranet");
         }
      }
   }else if($_POST['accion']==2){
      $con=0;
      for($i=0;$i<$_SESSION['user_preguntas_a_responder'];$i++){
         if($_SESSION['user_respuesta'][$i]==$_POST['respuesta'][$i]){
            $con++;
         }else{
            $con--;
         }
      }
      if($con==$_SESSION['user_preguntas_a_responder']){
         $_SESSION['pregunta_respuesta']=4;
         $_SESSION['user_passwd'];
         header("Location: ../../?p=cambiar-contrasena#intranet");
      }
      else{
         $Usuario->nombre_usuario($_SESSION['user_name']);
         $res=$Usuario->Buscar_1();
         if($res!=null){
            for($i=0;$i<$res[0]['numero_preguntas'];$i++){
               $preguntas[]=$res[$i]['preguntas'];
               $respuestas[]=$res[$i]['respuestas'];
            }
            $_SESSION['user_pregunta']=$preguntas;
            $_SESSION['user_respuesta']=$respuestas;
            $_SESSION['datos']['mensaje']="¡La respuesta no coecide con los datos del sistema!";
            $_SESSION['pregunta_respuesta']=$_POST['accion']+1;
            header("Location: ../../?p=pregunta-seguridad#intranet");
         }else{
            $_SESSION['datos']['mensaje']="¡Ocurrió un error al realizar la transacción!";
            header("Location: ../../?p=olvidar-clave#intranet");
         }
      }
   }else if($_POST['accion']==3){
      $con=0;
      for($i=0;$i<$_SESSION['user_preguntas_a_responder'];$i++){
         if($_SESSION['user_respuesta'][$i]==$_POST['respuesta'][$i]){
            $con++;
         }else{
            $con--;
         }
      }
      if($con==$_SESSION['user_preguntas_a_responder']){
         $_SESSION['pregunta_respuesta']=4;
         $_SESSION['user_passwd'];
         header("Location: ../../?p=cambiar-contrasena#intranet");
      }
      else{
         unset($_SESSION['pregunta_respuesta']);
         $_SESSION['datos']['mensaje']="¡Ud. no es usuario de este sistema!";
         header("Location: ../../?p=olvidar-clave#intranet");
      }
   }else{
      $res=$Usuario->Buscar_1();
      $_SESSION['pregunta_respuesta']=0;
      if($res!=null){
         if($res[0]['estado_clave']==4){
            $_SESSION['ambiente']=$ambiente;
            $_SESSION['datos']['mensaje']="¡Usuario bloqueado, contacte al administrador!";
            header("Location: ../../?p=olvidar-clave#intranet");
         }
         else{
            $_SESSION['ambiente']=$ambiente;
            $_SESSION['user_name']=$_POST['user_name'];
            $_SESSION['user_passwd']=$res[0]['password'];
            $_SESSION['user_numero_preguntas']=$res[0]['numero_preguntas'];
            $_SESSION['user_codigo_perfil']=$res[0]['codigo_perfil'];
            $_SESSION['user_preguntas_a_responder']=$res[0]['numero_preguntasaresponder'];
            for($i=0;$i<$res[0]['numero_preguntas'];$i++){
               $preguntas[]=$res[$i]['preguntas'];
               $respuestas[]=$res[$i]['respuestas'];
            }
            $_SESSION['user_pregunta']=$preguntas;
            $_SESSION['user_respuesta']=$respuestas;
            $_SESSION['pregunta_respuesta']++;
            header("Location: ../../?p=pregunta-seguridad#intranet");
         }
      }else{
         $_SESSION['datos']['mensaje']="¡Usuario incorrecto!";
         header("Location: ../../?p=olvidar-clave#intranet");
      }
   }
}
?>