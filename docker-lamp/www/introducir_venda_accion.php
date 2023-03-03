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
    die();
} else {   
    mysqli_set_charset($link, "utf8");

    // Recibimos los datos del formulario (POST)
    $modelo     = $_REQUEST["modelo_venda"];
    $cantidade  = $_REQUEST["cantidade_venda"];
    $descricion = $_REQUEST["descricion_venda"];
    $marca      = $_REQUEST["marca_venda"];
    $prezo      = $_REQUEST["prezo_venda"];
    $foto       = $_REQUEST["foto_venda"];

    /*
        ALGORITMO:
            - Comprobamos si ese vehículo está en la tabla venda (modelo)
            - En caso de que esté, incrementamos $cantidade unidades en este
            - De lo contrario, insertamos
    */

    // Comprobamos
    $select = sprintf("SELECT * FROM vehiculo_venda WHERE modelo = '%s'", $modelo);
    $query  = mysqli_query($link, $select);

    if(mysqli_num_rows($query) > 0){
        // Existe, incrementamos
        $select = sprintf("UPDATE vehiculo_venda SET cantidade = cantidade + %s WHERE modelo = '%s'", $cantidade, $modelo);
        $query  = mysqli_query($link, $select);

        if($query == false){
            echo "Error al incrementar la cantidad<br>";
        } else {
            echo "Incremento de unidades de vehículo existente con éxito<br>";
        }
    } else {
        $select = sprintf("INSERT INTO vehiculo_venda VALUES('%s','%s','%s','%s','%s','%s')", $modelo, $cantidade, $descricion, $marca, $prezo, $foto);
        $query  = mysqli_query($link, $select);

        if($query == false){
            echo "Error al añadir un nuevo vehículo!<br>";
        } else {
            echo "Insercción con éxito!<br>";
        }
    }

    echo "<input type=\"button\" onclick=\"location.href='menu_admin.php'\" value=\"Volver al menú\">";

    mysqli_close($link);
}   




?>