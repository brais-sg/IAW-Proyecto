<?php


function check_empty($value){
    if(!isset($value)) return true;
    if(empty($value)) return true;

    return false;
}

if(check_empty($_REQUEST["user"]) || check_empty($_REQUEST["user_pwd"])){
    echo "Login incompleto, hay campos vacíos!<br>";
    echo "Pulsa <a href=\"index.html\">aquí</a> para volver al inicio<br>";

    die();
}


$link = mysqli_connect("localhost", "root", "", "frota");
if(mysqli_connect_errno()){
    echo "Ha fallado la conexión a la base de datos";
} else {
    mysqli_set_charset($link, "utf8");
    //$select = "SELECT * FROM usuario WHERE usuario='".$_REQUEST["user"]."';";
    $select = sprintf("SELECT * FROM usuario WHERE usuario='%s';", $_REQUEST["user"]);
    $query = mysqli_query($link, $select);

    // Mostrar columnas (debug)
    // echo "Columnas: ".mysqli_num_rows($query);
    // echo "<br>";

    // Importante: Si $query = false ya no se evalúa la siguiente condición!
    if($query == false || mysqli_num_rows($query) == 0){
        echo "El usuario: ".$_REQUEST["user"]." no existe en la base de datos";
        echo "<br>Pulsa <a href=\"registro.html\">aquí</a> para registrarlo";

        // echo "<br> Query: ".$select;
    } else {
        // El usuario existe, comprobamos contraseña correcta
        //$select = "SELECT * FROM usuario WHERE usuario='".$_REQUEST["user"]."' AND contrasinal='".$_REQUEST["user_pwd"]."';";
        $select = sprintf("SELECT * FROM usuario WHERE usuario='%s' AND contrasinal='%s';", $_REQUEST["user"], $_REQUEST["user_pwd"]);
        $query = mysqli_query($link, $select);

        if($query == false || mysqli_num_rows($query) == 0){
            echo "Contraseña incorrecta para el usuario ".$_REQUEST["user"]."<br>";
            echo "<br>Pulsa <a href=\"index.html\">aquí</a> para volver al índice";
        } else {
            session_start();
            // Comprobamos se é administrador
            $datos_db = mysqli_fetch_array($query, MYSQLI_ASSOC);
            $_SESSION["user"] = $_REQUEST["user"];

            if($datos_db["tipo_usuario"] == "a"){
                $_SESSION["isAdmin"] = true;
                header("Location: menu_admin.php", TRUE, 301);
            } else {
                header("Location: menu.php", TRUE, 301);
            }
        }
    }

    mysqli_close($link);
}
?>
