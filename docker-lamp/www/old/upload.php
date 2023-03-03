<html lang="es">
<meta charset="UTF-8">
<head>
    <title>Subir archivo en PHP</title>
</head>
<body>
<?php
$upload_dir  = "uploads/";
$upload_file = $upload_dir . basename($_FILES["to_upload"]["name"]);

// Subimos un archivo o pulsamos simplemente subir?
if(isset($_POST["submit"])){
    $check_size = getimagesize($_FILES["to_upload"]["tmp_name"]);
    if($check_size != false){
        if(file_exists($upload_file)){
            echo "<h3>Error, el archivo ya existe!</h3>";
        } else {
            if(move_uploaded_file($_FILES["to_upload"]["tmp_name"], $upload_file)){
                echo "<h2>El archivo fue subido correctamente!</h2>";
            } else {
                echo "<h3>Error, el archivo no pudo ser subido a la carpeta destino, permisos?</h3>";
            }
        }
    } else {
        echo "<h3>Error, el archivo seleccionado NO es una imagen</h3>";
    }
} else {
    echo "<h3>Error, el archivo seleccionado no es válido o no se seleccionó ningún archivo</h3>";
}



?>
</body>
</html>