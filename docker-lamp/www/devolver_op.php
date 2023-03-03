<?php
session_start();

// Si la sesión no está iniciada (alguien acabó aquí sin pasar por el login, o expiró), lo redireccionamos a la página principal
if(!isset($_SESSION["user"])){
    header("Location: index.html", TRUE, 301);
    die();
}

// Mostramos el menú principal

echo "<div align=\"right\">";
echo "Hola <b>".$_SESSION["user"]."</b>";
echo " <a href=\"salir.php\">Pechar sesión</a>";
echo "</div>";
echo "<hr>";


$link = mysqli_connect("db", "root", "test", "frota");
if(mysqli_connect_errno()){
    echo "Ha fallado la conexión a la base de datos";
    die();
} else {   
    mysqli_set_charset($link, "utf8");
    $usuario = $_SESSION["user"];
    $modelo  = $_REQUEST["devolver_alugado"];

    /*
        ALGORITMO:
            Se recibe o modelo de un vehículo a devoltar 
            Primer paso, comprobamos se o vehículo está na base de datos (E cantas unidades hay de este)
            Caso 1: Existe máis de unha unidade:
                - Restamos un a cantidade e modificamos o valor
            Caso 2: Existe unha única unidade:
                - Eliminamos a entrada da tabla
            Posteriormente:
            Introducimos o vehículo na taboa de vehículos devoltos (!)
            1: Comprobamos se temos un vehículo igual na táboa devoltos
                Si existe: Incrementamos unha unidade
                Se non: Insertamos, cantidade: 1

    */

    // Buscamos si el cliente tiene un vehículo igual en su tabla de alugados
    $select = sprintf("SELECT * FROM vehiculo_alugado WHERE modelo='%s' AND usuario='%s';", $modelo, $usuario);
    $query  = mysqli_query($link, $select);

    if(mysqli_num_rows($query) > 0){
        // Obtenemos a cantidade
        $elemento = mysqli_fetch_array($query, MYSQLI_ASSOC);
        $cantidade = $elemento["cantidade"];

        // Cantidade >1 ?
        if($cantidade > 1){
            // Restamos
            $select = sprintf("UPDATE vehiculo_alugado SET cantidade = cantidade - 1 WHERE modelo='%s' AND usuario='%s'", $modelo, $usuario);
            $query = mysqli_query($link, $select);

            if($query == false){
                echo "Error decrementando el vehículo de la tabla alugado!<br>";
            } else {
                echo "Vehículo modificado con éxito!<br>";
            }

        } else {
            // Borramos
            $select = sprintf("DELETE FROM vehiculo_alugado WHERE modelo='%s' AND usuario='%s'", $modelo, $usuario);
            $query  = mysqli_query($link, $select);

            if($query == false){
                echo "Error borrando el vehículo de la tabla alugado!<br>";
            } else {
                echo "Vehículo borrado con éxito de alugado!<br>";
            }
        }

        // Finalizamos, tabla devoltos
        $select = sprintf("SELECT * FROM vehiculo_devolto WHERE modelo='%s' AND usuario='%s';", $modelo, $usuario);
        $query  = mysqli_query($link, $select);
        if(mysqli_num_rows($query) > 0){
            // Existe un vehículo igual na táboa, incrementamos cantidade 
            $select = sprintf("UPDATE vehiculo_devolto SET cantidade = cantidade + 1 WHERE modelo='%s' AND usuario='%s'", $modelo, $usuario);
            $query = mysqli_query($link, $select);

            if($query == false){
                echo "Error incrementando el vehículo da taboa devolto!<br>";
            } else {
                echo "Vehículo modificado con éxito (devolto)!<br>";
            }

        } else {
            $select = sprintf("INSERT INTO vehiculo_devolto VALUES('%s','%s','%s','%s','%s','%s')", $elemento["modelo"], 1, $elemento["descricion"], $elemento["marca"], $elemento["foto"], $usuario);
            $query  = mysqli_query($link, $select);

            if($query == false){
                echo "Error insertando o elemento na taboa devoltos<br>";
            } else {
                echo "Vehículo devolto con éxito!<br>";
            }
        }
        
    } else {
        echo "O vehículo a devolver non existe na taboa de alugados (Como chegamos aquí?)\n";
    }

    echo "Pulsa <a href=\"menu.php\">aquí</a> para volver o menú principal<br>";


    mysqli_close($link);
}



?>