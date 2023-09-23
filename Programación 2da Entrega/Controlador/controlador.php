<?php


if ($_SERVER['REQUEST_METHOD']) {

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode('/', $uri);

    
    $principal = $uri[4];
    $archivo = $uri[5];
    $clase = $archivo;
    $metodo = $uri[6];

    require_once "$principal/$archivo.php";
    $context = ['post' => $_POST];
    $controllerInstance = new $clase();
    $controllerInstance->$metodo($context);




}
?>