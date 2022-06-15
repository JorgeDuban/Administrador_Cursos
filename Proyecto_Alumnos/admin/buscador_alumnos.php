<?php
    require_once ("../librerias/sesion_segura.php");
    require_once ("../librerias/libreria.php");
    require_once ("../conexion/database.php");

    $_POST = LimpiarArray($_POST);

  $servidor= "localhost";
  $usuario= 'u207044934_jorgedubanbc19';
  $password = 'Jorge#01';
  $nombreBD= 'u207044934_proyecto_linea';	
  $conexion = new mysqli($servidor, $usuario, $password, $nombreBD);
  if ($conexion->connect_error) {
      die("la conexión ha fallado: " . $conexion->connect_error);
  }

  if (!isset($_POST['buscar'])){$_POST['buscar'] = '';}
  if (!isset($_REQUEST["mostrar_todo"])){$_REQUEST["mostrar_todo"] = '';}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Description" content="Enter your description here"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="assets/css/style.css">
<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=e3abfd12-dfb9-4b71-b7f6-4f4383ddd455"> </script>
<title>Buscador de Alumnos</title>
</head>
<body>

<div class="container mt-5">
<div class="col-12">

<form method="POST" action="buscador_alumnos.php">
<div class="mb-3">
<label class="fs-1 fw-bold">Alumno a Buscar</label>
<input type="text" class="form-control" id="buscar" name="buscar"  placeholder="Introduzca: Codigo, Cedula, o Apellido" value="<?php echo $_POST['buscar']; ?>" autocomplete="off">
</div>
<button type="text" class="btn btn-primary">Buscar</button>
</form>
<a class="btn btn-primary mt-2" href="buscador_alumnos.php?mostrar_todo=ok">Mostrar todos</a>


<div class="card col-12 mt-0 border-0">
<div class="card-body border-0">

<?php 
if(!empty($_POST))
{

        // resaltamos el resultado
        function resaltar_frase($string, $frase, $taga = '<b>', $tagb = '</b>'){
            return ($string !== '' && $frase !== '')
            ? preg_replace('/('.preg_quote($frase, '/').')/i'.('true' ? 'u' : ''), $taga.'\\1'.$tagb, $string)
            : $string;
             }
    
  
      $aKeyword = explode(" ", $_POST['buscar']);
      $filtro = "WHERE cc LIKE LOWER('%".$aKeyword[0]."%') OR apellido1 LIKE LOWER('%".$aKeyword[0]."%') OR nif LIKE LOWER('%".$aKeyword[0]."%')";
      $query ="SELECT * FROM alumno WHERE cc LIKE LOWER('%".$aKeyword[0]."%') OR apellido1 LIKE LOWER('%".$aKeyword[0]."%') OR nif LIKE LOWER('%".$aKeyword[0]."%') OR apellido2 LIKE LOWER('%".$aKeyword[0]."%')";
  

     for($i = 1; $i < count($aKeyword); $i++) {
        if(!empty($aKeyword[$i])) {
            $query .= " OR cc LIKE '%" . $aKeyword[$i] . "%' OR apellido1 LIKE '%" . $aKeyword[$i] . "%' OR nif LIKE '%" . $aKeyword[$i] . "%' OR apellido2 LIKE '%" . $aKeyword[$i] . "%'";
        }
      }
     
     $result = $conexion->query($query);
     $numero = mysqli_num_rows($result);
     if (!isset($_POST['buscar'])){
     echo "Has buscado la palabra:<b> ". $_POST['buscar']."</b>";
     }

     if( mysqli_num_rows($result) > 0 AND $_POST['buscar'] != '') {
        $row_count=0;
        echo "<br>Resultados encontrados:<b> ".$numero."</b>";
        echo "<br><br><table class='table table-striped'>";
        While($row = $result->fetch_assoc()) {   
            $row_count++;     
            echo "<tr><td>".$row_count." </td><td>". resaltar_frase($row['nombre'] ,$_POST['buscar']) . "</td><td>". resaltar_frase($row['apellido1'] ,$_POST['buscar']) . "</td><td>". resaltar_frase($row['apellido2'] ,$_POST['buscar']) . "</td><td>". resaltar_frase($row['cc'] ,$_POST['buscar']) . "</td><td>". resaltar_frase($row['direccion'] ,$_POST['buscar']) . "</td><td>". resaltar_frase($row['correo'] ,$_POST['buscar']) . "</td><td>". resaltar_frase($row['nif'] ,$_POST['buscar']) . "</td></tr>";
        }
        echo "</table>";
	
    }
    else {
      //mostramos todos los resultados
      if( $_REQUEST["mostrar_todo"] == 'ok') {
        $row_count=0;
        echo "<br>Resultados encontrados:<b> ".$numero."</b>";
        echo "<br><br><table class='table table-striped'>";
        While($row = $result->fetch_assoc()) {   
            $row_count++; 
            echo "<tr><td>".$row_count." </td><td>". resaltar_frase($row['nombre'] ,$_POST['buscar']) . "</td><td>". resaltar_frase($row['apellido1'] ,$_POST['buscar']) . "</td><td>". resaltar_frase($row['apellido2'] ,$_POST['buscar']) . "</td><td>". resaltar_frase($row['cc'] ,$_POST['buscar']) . "</td><td>". resaltar_frase($row['direccion'] ,$_POST['buscar']) . "</td><td>". resaltar_frase($row['correo'] ,$_POST['buscar']) . "</td><td>". resaltar_frase($row['nif'] ,$_POST['buscar']) . "</td></tr>";  
        }
        echo "</table>";
    }
    }
}
?>

</div>
</div>

</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../librerias/js/evitar_reenvio.js"></script>
  </body>
</html>