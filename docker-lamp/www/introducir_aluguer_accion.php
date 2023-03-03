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
    $modelo     = $_REQUEST["modelo_aluguer"];
    $cantidade  = $_REQUEST["cantidade_aluguer"];
    $descricion = $_REQUEST["descricion_aluguer"];
    $marca      = $_REQUEST["marca_aluguer"];
    $prezo      = $_REQUEST["prezo_aluguer"];
    $foto       = $_REQUEST["foto_aluguer"];

    /*
        ALGORITMO:
            - Comprobamos si ese vehículo está en la tabla aluguer (modelo)
            - En caso de que esté, incrementamos $cantidade unidades en este
            - De lo contrario, insertamos
    */

    // Comprobamos
    $select = sprintf("SELECT * FROM vehiculo_aluguer WHERE modelo = '%s';", $modelo);
    $query  = mysqli_query($link, $select);

    if(mysqli_num_rows($query) > 0){
        // Existe, incrementamos
        $select = sprintf("UPDATE vehiculo_aluguer SET cantidade = cantidade + %s WHERE modelo = '%s';", $cantidade, $modelo);
        $query  = mysqli_query($link, $select);

        if($query == false){
            echo "Error al incrementar la cantidad<br>";
        } else {
            echo "Incremento de unidades de vehículo existente con éxito<br>";
        }
    } else {
        $select = sprintf("INSERT INTO vehiculo_aluguer VALUES('%s','%s','%s','%s','%s','%s')", $modelo, $cantidade, $descricion, $marca, $prezo, $foto);
        $query  = mysqli_query($link, $select);

        if($query == false){
            echo "Error al añadir un nuevo vehículo!<br>";
        } else {
            echo "Insercción con éxito!<br>";
        }
    }


    echo '
        <form action="menu_admin.php" method="get" enctype="multipart/form-data" style="display: inline-block;">
            <input type="submit" value="Volver al menú">
        </form>
        ';

    mysqli_close($link);
}   




?>