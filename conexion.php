<?php

    include "conexion_bbdd.php";
    //require "conexion_bbdd.php"; da fallo si no encuentra fichero o ese falla

 /*else {
        echo "Conectado". "<br><br>";
    }*/
    
    $consulta = "SELECT * from USUARIOS"; //devuelve array con toda la info de los usuarios

    $resultado = $conexion->query($consulta);

    //print_r($resultado);

    $usuarios = $resultado->fetch_all(MYSQLI_ASSOC); //LO Q devolvió el query: el array asociativo

    //print_r($usuarios);
    //creo formulario. el submit envia action a conexion.php.
    //Recojo como $usuario_post cada usuario del formulario enviado como Post. 

    $usuario_post = $_POST["usuario"];
    $contraseña_post = $_POST["contraseña"];

    //recorro bucle y veo si el usuario&contraseña coinciden con los del array bbdd para mandarlo a clientes.php"
    // break para que no itere infinitamentwe

    foreach($usuarios as $usuario) {
        if($usuario["USER"] == $usuario_post && $usuario["PASS"] == $contraseña_post){
            header("Location: inicio.html");
        break;
        }
    }

?>
