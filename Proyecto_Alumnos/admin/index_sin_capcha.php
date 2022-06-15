<?php
    require_once ("../librerias/sesion_segura.php");
    require_once ("../librerias/libreria.php");
    require_once ("../conexion/database.php");
    require_once ("logica.php");


    if(!isset($_SESSION['verificador']))
    {
      $_SESSION['verificador']="VERIFICADO";
      $foo3= new sentencias_sql;
      $hora=" HORA ";
      $usuario4=" USUARIO ";
      $accion=" MENSAJE ";
      $origen=" DIRECCION IP "; 
      $foo3->generaLogs2($usuario4,$hora,$accion,$origen);
    //unset($_SESSION['verificador']);
    }

    //AntiCSRF();

    $_POST = LimpiarArray($_POST);

		$mensaje1 = ""; 
    $mensaje2 = "";
    $mensaje3 = ""; 
		$mensaje = ""; 

		function Validacion(){
      
			global $mensaje1, $mensaje2, $mensaje3, $mensaje;
			$login = $_POST['usuario'];
			$password = md5($_POST['password']);
			$btn_accion = $_POST['btn_accion'];
			unset($_SESSION['user_name']);
			if (isset($btn_accion) && $btn_accion == 'Ingresar') {
  				$conn = ConexionDB();
				if ($conn != NULL) {
					if (Login($conn, $login, $password) != "") {
						$_SESSION['user_name'] = $login;

            $foo= new sentencias_sql;
            $accion=" INGRESO AL SISTEMA ";
            $origen=$_SERVER['REMOTE_ADDR'];
            $foo->generaLogs($login,$accion,$origen);

						header("Location: sesion.php");
					  //exit();
					}
					else {
            $foo2= new sentencias_sql;
            $accion=" INGRESO DATOS ERRONEOS ";
            $origen=$_SERVER['REMOTE_ADDR'];
            $foo2->generaLogs($login,$accion,$origen);
						$mensaje1 = 'error';
						$mensaje = 'Datos erroneos';
           				http_response_code(401);
					}
				}
			}
		}
		if (isset($_POST) && isset($_POST['btn_accion'])) {
			LimpiarEntradas();
			Validacion();
		}
    ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Inicio de Sesión Admin</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
    <script async src="https://www.google.com/recaptcha/api.js"></script>
  </head>

  <body>
   
        <?php if(!empty($message)): ?>
        <p> <?= $message ?></p>
        <?php endif; ?>

        <h1></h1>
        <?php
            if ($mensaje2 != "") 
            {
            echo '<div class="leyend_error' . $mensaje3 . ' ">' . $mensaje2. '</div>';
            }
        ?>
        <?php
            if ($mensaje != "") 
            {
            echo '<div class="leyend_' . $mensaje1 . ' ">' . $mensaje . '</div>';
            }
        ?>

      <div style="margin: 50px 50;">
        <?php require_once "../partials/header_inicio.php";
          ?>
      </div>
    <form method="post">
      </div class= "error">
      <label for="usuario" class="form-element">Login:</label>
      <input id="usuario" name="usuario" type="text" placeholder="Ingrese su usuario" pattern="[a-zA-Z0-9]{1,15}" required>
      <div class="form-element">
      </div>
      <label for="usuario" class="form-element">Clave:</label>
      <input name="password" type="password" placeholder="Ingrese su contraseña" title="Una contraseña válida es una cadena con una longitud entre 8 y 20 caracteres, donde cada uno consiste en una letra mayúscula o minúscula, un dígito, o los símboloss '@', '#', '$' y '%'" required>
      <div class="form-element">
      <div style="text-align: center;">
     <!--<div
        class="g-recaptcha" 
        data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI" 
        
        style="display: inline-block;"
    ></div>-->
    </div>
      <input class="btn" type="submit" name="btn_accion" value="Ingresar">
      <div class="form-element">
      <a class="olvi" href="restablecer_password.php">¿Olvitaste tu Contraseña?</a>
      <div class="form-element">
      <!--<input type="hidden" name="csrf_token" id="token_AntiCSRF" value="<?php echo $_SESSION['AntiCSRF'];?>">-->
    </form>
  </body>
  <script type="text/javascript" src="../librerias/js/evitar_reenvio.js"></script>
</html>