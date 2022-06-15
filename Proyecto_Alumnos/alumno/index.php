<?php
    require_once ("../librerias/sesion_segura.php");
    require_once ("../librerias/libreria.php");
    require_once ("../conexion/database.php");
    require_once ("logica.php");

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
        if(isset($_POST['g-recaptcha-response'])){ //Aqui comienza el captcha

					$secret = '6LcUlYUcAAAAAF2a4vUFAe657MQjGd60io5zFgyy';

					$query = http_build_query(array('secret'=>$secret, 'response'=>$_POST['g-recaptcha-response']));

					$url = "https://www.google.com/recaptcha/api/siteverify?" . $query;

					$res_google = file_get_contents($url);

					$res = json_decode($res_google);

					if ($res->success){
						$autorizado = 1; //es valido
					}
					else{
						$autorizado =2; //es terminator
					}
				}
				else{
					$autorizado = 3; //No intento resolver el captcha
				}
			}
      if ($mensaje2 != "") 
      {
        echo '<div class="leyend_' . $mensaje3 . ' ">' . $mensaje2 .'</div>';
      }
			switch($autorizado){
				case 1:
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
                     //http_response_code(401);
            }
          }
        break;

				case 2:
          $mensaje3 = 'error';
					$mensaje2= 'Apruebe el Captcha';
					break;

				case 3:
          $mensaje3 = 'error';
					$mensaje2=  'Ni intento';
					break;
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
    <!--<meta http-equiv="Content-Security-Policy" content="default-src https://cdn.example.net; child-src 'none'; object-src 'none'">-->
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
      <input name="password" type="password" placeholder="Ingrese su contraseña" pattern="[A-Za-z0-9@#$%]{8,20}" title="Una contraseña válida es una cadena con una longitud entre 8 y 20 caracteres, donde cada uno consiste en una letra mayúscula o minúscula, un dígito, o los símboloss '@', '#', '$' y '%'" autocomplete="off" required>
      <div class="form-element">
      <div style="text-align: center;">
          <div class="g-recaptcha" data-sitekey="6LcUlYUcAAAAAGlIRzU78ARgl8NdU_DZusKKDdSg"></div>
    </div>
      <input class="btn" type="submit" name="btn_accion" value="Ingresar">
      <!--<input type="hidden" name="csrf_token" id="token_AntiCSRF" value="<?php echo $_SESSION['AntiCSRF'];?>">-->
    </form>
  </body>
  <script type="text/javascript" src="../librerias/js/evitar_reenvio.js"></script>
</html>