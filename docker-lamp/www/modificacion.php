<?php
session_start();

// Si la sesión no está iniciada (alguien acabó aquí sin pasar por el login, o expiró), lo redireccionamos a la página principal
if(!isset($_SESSION["user"])){
    header("Location: index.html", TRUE, 301);
    die();
}

$link = mysqli_connect("db", "root", "test", "frota");
if(mysqli_connect_errno()){
    echo "Ha fallado la conexión a la base de datos";
} else {
    // Obtenemos los datos actuales
    // TODO: Cuidado con los blancos
    mysqli_set_charset($link, "utf8");

    $user_name  = $_REQUEST["user_name"];
    $user_pwd   = $_REQUEST["user_pwd"];
    $user_addr  = $_REQUEST["user_address"];
    $user_phone = $_REQUEST["user_phone"];
    $user_nif   = $_REQUEST["user_nif"];
    $user_email = $_REQUEST["user_email"];

    // Detectamos blancos, modificamos campos que no estén en blanco
    if(isset($user_name) && !empty($user_name)){
        $select = sprintf("UPDATE usuario SET nome='%s' WHERE usuario='%s'", $user_name, $_SESSION["user"]);
        $query  = mysqli_query($link, $select);

        if($query == false){
            echo "Error al modificar el nombre del usuario!<br>";
        } else {
            echo "Se modificó el nombre del usuario a: ".$user_name."<br>";
        }
    }

    if(isset($user_pwd) && !empty($user_pwd)){
        $select = sprintf("UPDATE usuario SET contrasinal='%s' WHERE usuario='%s'", $user_pwd, $_SESSION["user"]);
        $query  = mysqli_query($link, $select);

        if($query == false){
            echo "Error al modificar el contrasinal del usuario!<br>";
        } else {
            echo "Se modificó el contrasinal del usuario<br>";
        }
    }

    if(isset($user_addr) && !empty($user_addr)){
        $select = sprintf("UPDATE usuario SET direccion='%s' WHERE usuario='%s'", $user_addr, $_SESSION["user"]);
        $query  = mysqli_query($link, $select);

        if($query == false){
            echo "Error al modificar la dirección del usuario!<br>";
        } else {
            echo "Se modificó la dirección del usuario";
        }
    }

    if(isset($user_phone) && !empty($user_phone)){
        $select = sprintf("UPDATE usuario SET telefono='%s' WHERE usuario='%s'", $user_addr, $_SESSION["user"]);
        $query  = mysqli_query($link, $select);

        if($query == false){
            echo "Error al modificar el teléfono del usuario!<br>";
        } else {
            echo "Se modificó el teléfono del usuario<br>";
        }
    }

    if(isset($user_nif) && !empty($user_nif)){
        $select = sprintf("UPDATE usuario SET nifdni='%s' WHERE usuario='%s'", $user_addr, $_SESSION["user"]);
        $query  = mysqli_query($link, $select);

        if($query == false){
            echo "Error al modificar el NIF del usuario!<br>";
        } else {
            echo "Se modificó el NIF del usuario<br>";
        }
    }
    
    if(isset($user_email) && !empty($user_email)){
        $select = sprintf("UPDATE usuario SET email='%s' WHERE usuario='%s'", $user_addr, $_SESSION["user"]);
        $query  = mysqli_query($link, $select);

        if($query == false){
            echo "Error el email del usuario!<br>";
        } else {
            echo "Se modificó el email del usuario";
        }
    }


    /*
    // TODO: Este query!
    $select = sprintf("UPDATE usuario SET nome='%s', contrasinal='%s', direccion='%s', telefono='%s', nifdni='%s', email='%s' WHERE usuario='%s'", $user_name, $user_pwd, $user_addr, $user_phone, $user_nif, $user_email, $_SESSION["user"]);
    $query  = mysqli_query($link, $select);

    if($query == false){
        echo "Error al realizar la modificación! Revisa los campos a modificar";
    } else {
        echo "Se ha modificado el usuario correctamente!<br>";
        echo "Pulsa <a href='menu.php'>aquí</a> para volver al menú";
    }
    */

    echo "<br>Pulsa <a href='menu.php'>aquí</a> para volver al menú principal\n";
    mysqli_close($link);
}



?>