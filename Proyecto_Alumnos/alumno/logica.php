<?php 
    require_once ("../conexion/database.php");

    function Login($conn, $login, $clave)
    {
        $stm = 
            $conn->prepare("SELECT `login` FROM `alumno` WHERE `login` = :Login and `password` = :Password");
        
        $stm->bindParam(':Login', $login); 
        $stm->bindParam(':Password', $clave);
        $stm->execute();
        $user =$stm->fetch();
        if($user){
            return $user['login'];
        }
        return '';
    }

?>

<?php

class sentencias_sql {

    protected $conn;
    protected $Codigo_aleatorio;
    protected $correo;
    protected $login;
    protected $usuario;
    protected $codigo_recuperacion;


    public function getLogin()
    {
        return $this->login;
    }
    public function getUsuario()
    {
        return $this->usuario;
    }


    function __construct(){

    }


    function actualizar_codigo($conn, $Codigo_aleatorio, $correo){
        $nuevo_codigo= md5($Codigo_aleatorio);
                    $stm = 
            $conn->prepare("UPDATE alumno SET password=:codigo, codigo_recuperacion=:codigo WHERE `correo` = :correo");

        $stm->bindParam(':codigo', $nuevo_codigo);
        $stm->bindParam(':correo', $correo);
        
        try {           
            if ($stm->execute()) {
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (\Throwable $th) {
            return FALSE;
        }
    }

    function buscar_usuario($conn, $correo){
                    $stm = 
            $conn->prepare("SELECT login, concat(nombre, ' ', apellido1, ' ', apellido2) as Nombre From alumno Where email =:correo");

        $stm->bindParam(':correo', $correo);


        if ($stm->execute()) {
                   
            $rows = $stm->fetchAll();

             //con esto imprimo los valores de la base de datos
             
            foreach ($rows as $row) {
                $this->login = $row['login'];
                $this->usuario = $row['Nombre'];
              // $this->Clave = $row['Clave'];

               break;
            }
            
            return TRUE;
        } else {
            return FALSE;
        }
        try {           
            if ($stm->execute()) {
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (\Throwable $th) {
            return FALSE;
        }
    }
    function actualizar_password($conn, $password, $codigo_recuperacion){
        $stm = 
        $conn->prepare("UPDATE alumno SET password=:password WHERE `codigo_recuperacion` = :codigo_recuperacion");

            $stm->bindParam(':password', $password);
            $stm->bindParam(':codigo_recuperacion', $codigo_recuperacion);


            try {           
                if ($stm->execute()) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } catch (\Throwable $th) {
                return FALSE;
            }
        }
        function generaLogs($usuario,$accion,$origen){
            //Definimos la hora de la accion
            $hora=str_pad(date("H:i:s"),10," "); //hhmmss;
            //Definimos el contenido de cada registro de accion por usuario.
            $usuario=strtoupper(str_pad($usuario,15," "));
            $accion=strtoupper(str_pad($accion,50," "));
            $cadena=$hora.$usuario.$accion.$origen;
            //Creamos dinamicamente el nombre del archivo por dia
            $pre="log";
            $date=date("ymd"); //aammddhhmmss
            $fileName=$pre.$date;
            // echo "$fileName";
            $f = fopen("logs/$fileName.TXT","a"); //EL PROBLEMA ERA LA CARPETA
            fputs($f,$cadena."\r\n") or die("no se pudo crear o insertar el fichero");
            fclose($f);
            
            }//end generaLogs function      
}
?>