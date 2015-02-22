<?php
session_start();
if(isset($_POST['ambiente']) && $_POST['ambiente']=="1"){
   $file = fopen("../class/conf.php", "w");
   fwrite($file, "<?php" . PHP_EOL);
   fwrite($file, "define('SERVER','127.0.0.1');" . PHP_EOL);
   fwrite($file, "define('PORT','5432');" . PHP_EOL);
   fwrite($file, "define('USER','admin');" . PHP_EOL);
   fwrite($file, "define('PASSWORD','4dm1n12tr4t0r');" . PHP_EOL);
   fwrite($file, "define('BD','chsbdb');" . PHP_EOL);
   fwrite($file, "?>" . PHP_EOL);
   fclose($file);
   $ambiente="Producción";
}else if(isset($_POST['ambiente']) && $_POST['ambiente']=="2"){
   $file = fopen("../class/conf.php", "w");
   fwrite($file, "<?php" . PHP_EOL);
   fwrite($file, "define('SERVER','127.0.0.1');" . PHP_EOL);
   fwrite($file, "define('PORT','5432');" . PHP_EOL);
   fwrite($file, "define('USER','postgres');" . PHP_EOL);
   fwrite($file, "define('PASSWORD','postgres');" . PHP_EOL);
   fwrite($file, "define('BD','bdchsb');" . PHP_EOL);
   fwrite($file, "?>" . PHP_EOL);
   fclose($file);
   $ambiente="Prueba";
}else{
   $_SESSION['datos']['mensaje']="¡No se ha definido una conexión al servidor para el ambiente para el sistema!";
   header("Location: ../../#intranet");
   exit;
}

include("../class/class_usuario.php");
$preguntas=null;
$respuestas=null;
$Usuario=new Usuario();
$Usuario->nombre_usuario(trim($_POST['usuario']));
$Usuario->contrasena(trim($_POST['contrasena']));
$res=$Usuario->Buscar();
if($res!=null){
   if($res[0]['estado']==4){
      $_SESSION['datos']['mensaje']="Usuario bloqueado, contacte al administrador!";
      header("Location: ../../#intranet");
   }else{
      $_SESSION['ambiente']=$ambiente;
      $_SESSION['user_name']=$res[0]['name'];
      $_SESSION['fullname_user']=$res[0]['fullname_user'];
      $_SESSION['user_cedula']=$res[0]['cedula'];
      $_SESSION['user_pregunta']=$preguntas;
      $_SESSION['user_respuesta']=$respuestas;
      $_SESSION['user_password']=$res[0]['contrasena'];
      $_SESSION['user_perfil']=$res[0]['perfil'];
      $_SESSION['user_codigo_perfil']=$res[0]['codigo_perfil'];
      $_SESSION['user_caducidad']=$res[0]['caducidad'];
      $_SESSION['user_diasaviso']=$res[0]['dias_aviso'];
      $_SESSION['user_preguntas']=$res[0]['numero_preguntas'];
      $_SESSION['user_respuestas']=$res[0]['numero_preguntasaresponder'];
      $_SESSION['user_estado']=$res[0]['estado'];
      for($i=0;$i<$res[0]['numero_preguntas'];$i++){
         $preguntas[]=$res[$i]['preguntas'];
         $respuestas[]=$res[$i]['respuestas'];
      }
      $_SESSION['user_pregunta']=$preguntas;
      $_SESSION['user_respuesta']=$respuestas;
      $Usuario->Intento_Fallido(false);
      header("Location: ../view/menu_principal.php");
   }
}else{
   $Usuario->Intento_Fallido(true);
   $Usuario->Bloquear_Usuario();
   $_SESSION['datos']['mensaje']="Usuario/Clave incorrecto!";
   header("Location: ../../#intranet");
}
?>