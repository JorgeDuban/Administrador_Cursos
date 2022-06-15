<?php
require_once ("../librerias/sesion_segura.php");

  session_unset();


  session_destroy();

  header('Location: ../index.php');
?>
