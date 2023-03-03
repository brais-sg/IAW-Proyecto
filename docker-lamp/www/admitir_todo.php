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


    $select = "SELECT * FROM novo_rexistro;";
    $query = mysqli_query($link, $select);

    if($query == false){
        echo "Por alguna extraña razón no se pueden mostrar los usuarios de novo_rexistro, prueba otra vez a ver<br>";
        echo "Si no, F por la base de datos<br>";
    } else {
        // Ahora, por cada usuario que esté en la tabla, debemos buscar si está repetido

        while($actual = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            $usuario     = $actual["usuario"];
            $contrasinal = $actual["contrasinal"];
            $nome        = $actual["nome"];
            $direccion   = $actual["direccion"];
            $telefono    = $actual["telefono"];
            $nifdni      = $actual["nifdni"];
            $email       = $actual["email"];

            // Buscamos si está repetido
            $select_busqueda = sprintf("SELECT * FROM usuario WHERE usuario = '%s';", $usuario);
            $query_busqueda  = mysqli_query($link, $select_busqueda);

            if(mysqli_num_rows($query_busqueda) > 0){
                // Encontrado repetido!
                echo "Encontrado usuario repetido, evitando insercción para $usuario<br>";
            } else {
                // No repetido, insertamos y eliminamos

                $select_insert = sprintf("INSERT INTO usuario VALUES('%s','%s','%s','%s','%s','%s','%s','%s');", $usuario, $contrasinal, $nome, $direccion, $telefono, $nifdni, $email, "u");
                $query_insert  = mysqli_query($link, $select_insert);

                if($query_insert == false){
                    echo "Falló la insercción de $usuario<br>";
                } else {
                    // Eliminamos el usuario de la tabla novo_rexistro
                    $select_borrar = sprintf("DELETE FROM novo_rexistro WHERE usuario = '%s';", $usuario);
                    $query_borrar  = mysqli_query($link, $select_borrar);

                    if($query_borrar == false){
                        echo "Falló la eliminación de $usuario de la tabla novo_rexistro<br>";
                    }

                }
            }
        }
    };

    echo "Se han admitido los usuarios!<br>";
    echo '
        <form action="menu_admin.php" method="get" enctype="multipart/form-data" style="display: inline-block;">
            <input type="submit" value="Volver al menú">
        </form>
        ';



    mysqli_close($link);
}




?>
