<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define las credenciales de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'USUARIO');
define('DB_PASS', 'PASS');
define('DB_NAME', 'afili');

// Intenta establecer la conexión a la base de datos
$conexion_db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
// Establece el conjunto de caracteres a UTF-8
$conexion_db->set_charset("utf8");

// Verifica la conexión
if ($conexion_db->connect_error) {
    die('Error al conectar a la base de datos: ' . $conexion_db->connect_error);
}

?>
