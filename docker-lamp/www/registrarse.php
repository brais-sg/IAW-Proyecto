<html lang="es">
    <meta charset="UTF-8">
    <head>
        <title>Registro</title>
    </head>
    <body>
<?php

// Función para comprobar si un campo existe y NO es nulo.
// Retorna true si el campo es nulo o NO existe, false de lo contrario
function check_empty($value){
    if(!isset($value)) return true;
    if(empty($value)) return true;

    return false;
}


$link = mysqli_connect("localhost", "root", "", "frota");
if(mysqli_connect_errno()){
    echo "Ha fallado la conexión a la base de datos";
} else {
    mysqli_set_charset($link, "utf8");
    // Valores vacíos?
    if(check_empty($_REQUEST["user"]) || check_empty($_REQUEST["user_pwd"]) || check_empty($_REQUEST["user_name"]) || check_empty($_REQUEST["user_address"]) || check_empty($_REQUEST["user_telf"]) || check_empty($_REQUEST["user_nif"]) || check_empty($_REQUEST["user_email"])){
        echo "Datos incompletos, hay campos vacíos!<br>";
        echo "Pulsa <a href=\"registro.html\">aquí</a> para volver al registro<br>";
        die();
    }

    // Insertamos el nuevo usuario
    $select = sprintf("INSERT INTO novo_rexistro VALUES('%s','%s','%s','%s','%s','%s','%s');", $_REQUEST["user"], $_REQUEST["user_pwd"], $_REQUEST["user_name"], $_REQUEST["user_address"], $_REQUEST["user_telf"], $_REQUEST["user_nif"], $_REQUEST["user_email"]);
    
    // echo "Query: ".$select."<br>";
    // Insertamos el usuario
    $query = mysqli_query($link, $select);
    
    if($query == false){
        echo "No se pudo guardar la órden de registro!<br>";
        echo "Comprueba los campos y vuelve a intentarlo<br>";

    } else {
        echo "Se guardó la órden de registro correctamente!<br>";
        echo "Pulsa <a href=\"index.html\">aquí</a> para volver al índice<br>";
    }

    mysqli_close($link);
}

?>
</body>
</html>