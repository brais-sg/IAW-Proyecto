<?php
function detectar_mateo(){
    if($_SERVER['REMOTE_ADDR'] == "10.0.9.15"){
        return true;
    }

    return false;
}

?>