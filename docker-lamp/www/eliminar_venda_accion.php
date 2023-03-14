<?php
session_start();

// Si la sesión no está iniciada (alguien acabó aquí sin pasar por el login, o expiró), lo redireccionamos a la página principal
if(!isset($_SESSION["user"])){
    header("Location: index.html", TRUE, 301);
    die();
}


$link = mysqli_connect("localhost", "root", "", "frota");
if(mysqli_connect_errno()){
    echo "Ha fallado la conexión a la base de datos";
    die();
} else {   
    mysqli_set_charset($link, "utf8");

    $modelo    = $_REQUEST["vehiculo"];
    $cantidade = $_REQUEST["cantidade"];

    if(!(isset($modelo) && isset($cantidade))){
        echo "Modelo o cantidade non especificada!\n";
        die();
    }

    $select = sprintf("SELECT * FROM vehiculo_venda WHERE modelo = '%s'", $modelo);
    $query  = mysqli_query($link, $select);

    if(mysqli_num_rows($query) > 0){
        // El vehículo existe, decrementamos ou eliminamos
        $vehiculo_tabla = mysqli_fetch_array($query, MYSQLI_ASSOC);
        
        $restante = $vehiculo_tabla["cantidade"] - $cantidade;
        
        if($restante < 1){
            // Borramos
            $select = sprintf("DELETE FROM vehiculo_venda WHERE modelo = '%s'", $modelo);
            $query  = mysqli_query($link, $select);

            if($query == false){
                echo "No se pudo borrar el vehiculo!\n";
            } else {
                echo "Borrouse o vehiculo $modelo da base de datos\n";
            }
        } else {
            // Actualizamos
            $select = sprintf("UPDATE vehiculo_venda SET cantidade = '%s'", $restante);
            $query  = mysqli_query($link, $select);

            if($query == false){
                echo "No se puido modificar a cantidade de unidades do vehículo!\n";
            } else {
                echo "Se modificou a cantidade do vehículo a $restante unidades!\n";
            }
        }

    } else {
        echo "O vehículo espeficado non existe na base de datos!\n";
    }


    echo "<br>Pulsa <a href='menu_admin.php'>aquí</a> para volver al menú de administrador\n";


    mysqli_close($link);
}





?>