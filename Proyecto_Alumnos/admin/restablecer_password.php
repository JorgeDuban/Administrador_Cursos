<?php
require_once ("../librerias/sesion_segura.php");
require_once ("../librerias/libreria.php");
require_once ("../conexion/database.php");
require_once ("logica.php");

$_POST = LimpiarArray($_POST);

  function enviar_correo(){
     $btn_accion = $_POST['btn_accion'];
    if (isset($btn_accion) && $btn_accion == 'Enviar') {
        $rango=rand(100000,999999);
        $Codigo_aleatorio = $rango;
        $correo_usuario = $_POST['correo'];
        $usuario='Prueba';
        $conn = ConexionDB();

$foo = new sentencias_sql;
$foo2 = new sentencias_sql;

      if ($conn != NULL) {
        if ($foo->actualizar_codigo($conn,$Codigo_aleatorio,$correo_usuario) != "") {
          $foo2->buscar_usuario($conn, $correo_usuario);
            try{


   
                   $to      = $correo_usuario; //$email; // Send email to our user
                   $subject = 'Inicio de Sesion | Verificacion - Administrador '; // Give the email a subject 
                   $message = '
                   
                   Gracias por iniciar sesion con nosotros!
                   Para verificar tu acceso al sistema , hemos creado un código de autenticación para que lo ingreses como tu nueva contraseña y comprobar que eres tu!
                   
                   ------------------------

                   Login: '.$foo2->getLogin().'
                   Usuario: '.$foo2->getUsuario().'
                   Codigo de autenticacion: '.$Codigo_aleatorio.'
                   ------------------------
                   
                   
                   
                   
                   
                   
                   '; // Our message above including the link
                            
                   $headers = 'From:proyectosunicundi@corporation.com' . "\r\n"; // Set from headers
                   mail($to, $subject, $message, $headers); // Send our email
                 
       print("<script>alert('Si el correo coincide con alguno de nuestros registros, enviaremos un codigo de autenticacion a tu correo. Revisa tu SPAM si no llega a tu bandeja de entrada.');</script>");
                    
           }catch(Exception $e){
                echo 'Mailer Error: ' . $mail->ErrorInfo;
           }
           header("Location: cambiar_password.php");
        }
        else {
            print("<script>alert('Error');</script>");   
            http_response_code(401);
            
        }
      }

    }
}

if (isset($_POST) && isset($_POST['btn_accion'])){
  LimpiarEntradas();
  enviar_correo();
}

?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
    <script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=e3abfd12-dfb9-4b71-b7f6-4f4383ddd455"> </script>
  </head>
  <body>
      <div style="margin: 50px 50;">
        <?php require_once "../partials/header_login_admin.php" ;
          ?>
      </div>

    <form method="post">
      </div class= "error">
      <label for="usuario" class="form-element">Correo:</label>
      <input id="correo" name="correo" type="mail" placeholder="Ingrese su correo" autocomplete="off" required>
      <div class="form-element">
      </div>
      <input class="btn" type="submit" name="btn_accion" value="Enviar">
      <input type="hidden" name="csrf_token" id="token_AntiCSRF" value="<?php echo $_SESSION['AntiCSRF'];?>">
    </form>
  </body>
  <script type="text/javascript" src="../librerias/js/evitar_reenvio.js"></script>
</html>