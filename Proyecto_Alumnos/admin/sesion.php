<?php
  require_once ("../librerias/sesion_segura.php");
  require_once ("../librerias/libreria.php");
  require_once ("../conexion/database.php");
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Sesión</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=e3abfd12-dfb9-4b71-b7f6-4f4383ddd455"> </script>
  </head>
  <body>
  <section>
      <div>
    <?php require '../partials/header_salir.php' ?>
    
    <?php if(!isset($_SESSION['user_name'])){
      echo'
      <a href="index.php"></a>'
      ;} 
    else {
			echo '<div class="tex">Bienvenido ' .$_SESSION['user_name']. '.</div>';
        }
	?> 
	</div>
	<div>
	<label for="Name">Bienvenido</label>
	</div>
  <br>
    <div>
    <input class="btn" type="button" onclick="window.open('buscador_alumnos.php', '_blank');"  value="Buscar Alumnos">
    </div>
    <div>
    <input class="btn" type="button" onclick="window.open('buscador_cursos.php', '_blank');"  value="Buscar Cursos">
    </div>
    </section>
  </body>
</html>