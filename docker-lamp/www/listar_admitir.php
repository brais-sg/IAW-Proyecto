<?php
session_start();

// Si la sesión no está iniciada (alguien acabó aquí sin pasar por el login, o expiró), lo redireccionamos a la página principal
if(!isset($_SESSION["user"])){
    header("Location: index.html", TRUE, 301);
    die();
}

// Mostramos el menú principal
echo "<div align=\"right\">";
echo "Hola <b>".$_SESSION["user"]."</b> [Como administrador]";
echo " <a href=\"salir.php\">Pechar sesión</a>";
echo " <a href=\"modificar.php\">Modificar os meus datos</a>";
echo "</div>";
echo "<hr>";


$link = mysqli_connect("db", "root", "test", "frota");
if(mysqli_connect_errno()){
    echo "Ha fallado la conexión a la base de datos";
    die();
} else {
    mysqli_set_charset($link, "utf8");

    // Mostramos todos os usuarios de novo_rexistro
    $select = "SELECT * FROM novo_rexistro;";
    $query = mysqli_query($link, $select);

    if($query == false){
        echo "Por alguna extraña razón no se pueden mostrar los usuarios de novo_rexistro, prueba otra vez a ver<br>";
        echo "Si no, F por la base de datos<br>";
    } else {
        echo "<h2>Lista de usuarios para admitir</h2>\n";
        echo "<table>";
        echo "<tr>
            <th>Usuario</th>
            <th>Contrasinal</th>
            <th>Nome</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>NIF</th>
            <th>Email</th>
        </tr>";
        while($actual = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            // Mostramos todos os campos (contraseña?)
            $usuario     = $actual["usuario"];
            $contrasinal = $actual["contrasinal"];
            $nome        = $actual["nome"];
            $direccion   = $actual["direccion"];
            $telefono    = $actual["telefono"];
            $nifdni      = $actual["nifdni"];
            $email       = $actual["email"];

            echo "<tr>";

            echo "<td>$usuario</td>";
            echo "<td>$contrasinal</td>";
            echo "<td>$nome</td>";
            echo "<td>$direccion</td>";
            echo "<td>$telefono</td>";
            echo "<td>$nifdni</td>";
            echo "<td>$email</td>";

            echo "</tr>";
        }

        echo "</table>";
        // Admitir novos usuarios, e atrás
        echo "<br>";
        echo "<input type=\"button\" onclick=\"location.href='admitir_todo.php'\" value=\"Admitir todo\"> ";

        echo '
        <form action="menu_admin.php" method="get" enctype="multipart/form-data" style="display: inline-block;">
            <input type="submit" value="Volver al menú">
        </form>
        ';

    }


    mysqli_close($link);
}




?>