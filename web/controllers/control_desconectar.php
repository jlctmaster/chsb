<?php
// On récupère la session
session_start();
session_unset(); 
// Puis on la détruit la session donc le numéro unique de session
session_destroy();
header('Location: ../../index.php');
?>