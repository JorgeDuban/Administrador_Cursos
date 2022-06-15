<?php
  require_once ("../librerias/sesion_segura.php");
  require_once ("../librerias/libreria.php");
  require_once ("../conexion/database.php");
  $conexion=mysqli_connect('localhost','root','','s_proyecto_linea_3');
    //$sql="SELECT foto FROM usuarios WHERE usuario = '$user'";
    //$result=mysqli_query($conexion,$sql);
    $message = "";
    $tipo_mensaje = "";
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Sesión</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styles.css">
  </head>
  <body>
  <section>
    <?php require '../partials/header_salir.php' ?>
    
    <?php if(!isset($_SESSION['user_name'])){
      echo'
      <a href="index.php"></a>'
      ;} 
    else {
			echo '<div class="tex">Bienvenido ' .$_SESSION['user_name']. '.</div>';
        }
	?> 
    </section>
    
<!--------------------------------------------------------------------------------------------------->
 <form class ="form_art" method="post">
    </div>
    <br>
        <table border="1" >
          <thead>
            <tr>
                <th>Código</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Cédula</th>
                <th>N° Celular</th>
                <th>Dirección</th>
            </tr>
            </thead>
            <?php 
            $sesion=$_SESSION['user_name'];
            $sql="SELECT nif, nombre, concat(apellido1, ' ', apellido2) as apellidos, cc, fecha_nacimiento, semestre, celular, direccion, correo FROM  alumno  WHERE `login` = '$sesion'";
            $result=mysqli_query($conexion,$sql);
            while($mostrar=mysqli_fetch_array($result)){
            ?>
            <tr>
                    <td><?php echo $mostrar['nif'] ?></td> 
                    <td><?php echo $mostrar['nombre'] ?></td>        
                    <td><?php echo $mostrar['apellidos'] ?></td>
                    <td><?php echo $mostrar['cc'] ?></td> 
                    <td><?php echo $mostrar['celular'] ?></td>        
                    <td><?php echo $mostrar['direccion'] ?></td>     

            </tr>
        <?php 
        }
        ?>
        </table>
     <br>
     <br>

        <form class ="form_art" method="post">
    </div>
    <br>
        <table border="1" >
          <thead>
            <tr>
                <th>Cursos Registrados</th>
            </tr>
            </thead>
            <?php 
            $sesion=$_SESSION['user_name'];
            $sql="SELECT c.nombre FROM registro_curso r INNER JOIN alumno a ON r.id_alumno = a.id INNER JOIN curso c ON r.id_curso = c.id WHERE a.login='$sesion'";
            $result=mysqli_query($conexion,$sql);
            while($mostrar=mysqli_fetch_array($result)){
            ?>
            <tr>
                    <td><?php echo $mostrar['nombre'] ?></td>         

            </tr>
        <?php 
        }
        ?>
        </table>
      <!--<input type="hidden" name="csrf_token" id="token_AntiCSRF" value="<?php echo $_SESSION['AntiCSRF'];?>">-->
      </form>
  </body>
  <script type="text/javascript" src="../librerias/js/evitar_reenvio.js"></script>
</html>