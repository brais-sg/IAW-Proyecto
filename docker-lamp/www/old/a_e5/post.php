<?php
$fd = fopen("/var/www/html/fichero.txt","w");

fprintf($fd, "O nome de usuario é: %s\n", $_REQUEST["nombre"]);
fprintf($fd, "O primeiro apelido do usuario é: %s\n", $_REQUEST["apelido1"]);
fprintf($fd, "O segundo apelido do usuario é: %s\n", $_REQUEST["apelido2"]);
fprintf($fd, "O contrasinal do usuario é: %s\n", $_REQUEST["contrasinal"]);
fprintf($fd, isset($_REQUEST["infoAdicional"]) ? "O usuario desexa recibir información\n" : "O usuario non desexa recibir información\n");


echo "<h1>Los datos fueron guardados correctamente</h1>";
?>