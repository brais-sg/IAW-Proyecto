<?php
session_start();

// Si la sesión no está iniciada (alguien acabó aquí sin pasar por el login, o expiró), lo redireccionamos a la página principal
if(!isset($_SESSION["user"])){
    header("Location: index.html", TRUE, 301);
    die();
}

echo "<div align=\"right\">";
echo "Hola <b>".$_SESSION["user"]."</b>";
echo " <a href=\"salir.php\">Pechar sesión</a>";
echo "</div>";
echo "<hr>";
echo "<h2>Modificar os meus datos</h2>";

// Iniciar comunicación con la base de datos, obtenemos todos los datos y los mostramos en el respectivo campo de texto
// Submit actualizará las modificaciones
$link = mysqli_connect("db", "root", "test", "frota");
if(mysqli_connect_errno()){
    echo "Ha fallado la conexión a la base de datos";
} else {
    mysqli_set_charset($link, "utf8");
    // Obtenemos los datos actuales
    $select = sprintf("SELECT * FROM usuario WHERE usuario='%s'", $_SESSION["user"]);
    $query  = mysqli_query($link, $select);

    if($query == false){
        echo "Non se puido obter información do usuario dado";
    } else {
        $value = mysqli_fetch_array($query, MYSQLI_ASSOC);

        // Mostramos los inputs para el usuario (form)
        // TODO: Campos vacíos originalmente, modificamos SOLO los no nulos
        echo '
            <form action="modificacion.php" method="post" enctype="multipart/form-data" style="border: 1px solid black;">
                <p>Completa los campos que quieras editar, deja vacíos los que no quieras modificar</p>
                <br>
                Usuario: <b>'.$value["usuario"].'<br>
                Nombre: <input type="text" name="user_name" value=""><br>
                Contrasinal: <input type="password" name="user_pwd"  value=""><br>
                Direccion: <input type="text" name="user_address" value=""><br>
                Telefono: <input type="text" name="user_phone" value=""><br>
                NIF: <input type="text" name="user_nif" value=""><br>
                Email: <input type="email" name="user_email" value=""><br>
                <br>

                <input type="submit" value="Modificar datos">
                <input type="button" onclick="history.back()" value="Cancelar">
            </form>
        ';
    }



    mysqli_close($link);
}

?>