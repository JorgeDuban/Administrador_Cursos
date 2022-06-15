<?php
    require_once ("../librerias/sesion_segura.php");
    require_once ("../librerias/libreria.php");
    require_once ("../conexion/database.php");
    require_once ("logica.php");
    //AntiCSRF();
    $_POST = LimpiarArray($_POST);

    $message = "";
    $tipoMensaje = "";

        function ActualizarClave(){
            global $message;
            $btn_accion = $_POST['btn_accion'];

            if (isset($btn_accion) && $btn_accion == 'Actualizar') {
              $codigo = md5($_POST['codigo']);
              $clave_nueva = md5($_POST['clave_nueva']);
              $clave_repetir = md5($_POST['clave_repetir']);
                $conn = ConexionDB();

        $foo= new sentencias_sql;
                if ($conn != NULL) {
                  if ($clave_nueva == $clave_repetir){
                      if($codigo != $clave_nueva && $clave_nueva == $clave_repetir){					
                    if($foo->actualizar_password($conn, $clave_nueva, $codigo)!= "");
                    
                    $message .='Calve actualizada.';
                    $tipoMensaje = "";
                    header("Location: index.php");
                      }else{
                        $message .='Código y Clave tienen que ser diferentes';
                        $tipoMensaje = "error";
                    }
                }else{
                    $message .='Claves no coinciden';
                    $tipoMensaje = "error";
                }
            }
            }				     
      }
        if (isset($_POST) && isset($_POST['btn_accion'])) {
            LimpiarEntradas();
            ActualizarClave();
        }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cambiar Clave</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
    <script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=e3abfd12-dfb9-4b71-b7f6-4f4383ddd455"> </script>
  </head>
  <body>  
  <section>
    <h1>Cambio de Clave</h1>
</section>
    <?php
      if ($message != "") 
        {
          echo '<div class="error_"' . $tipoMensaje . ' ">' . $message . '</div>';
        }
    ?>

    <form class="cambio_clave" action="" method="POST" enctype="multipart/form-data">
      <div>
      <label class="clave" for="codigo">Código:</label>
      <input name="codigo" type="password" required>
      </div>
      <div>
      <label class="clave" for="clave_nueva">Nueva Clave:</label>
      <input name="clave_nueva" type="password" pattern="[A-Za-z0-9@#$%]{8,20}" title="Una contraseña válida es una cadena con una longitud entre 8 y 20 caracteres, donde cada uno consiste en una letra mayúscula o minúscula, un dígito, o los símboloss '@', '#', '$' y '%'" required>
      </div>
      <div>
      <label class="clave" for="clave_repetir">Repetir Clave:</label>
      <input name="clave_repetir" type="password" required>
      </div>
      <div>
        <br>
      <input class="btn" type="submit" name="btn_accion" value="Actualizar">
      </div>
      <!--<input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $_SESSION['AntiCSRF'];?>">-->
    </form>
  </body>
  <script type="text/javascript" src="../librerias/js/evitar_reenvio.js"></script>
</html>