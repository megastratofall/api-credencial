<?php

// Configuración de CORS
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inicia la sesión
session_start();

// Incluye el modelo y la conexión a la base de datos
require_once "./app/Models/UserModel.php";
require_once "./config/conexiondb.php";

class UserController {
    private $conexion_db;

    public function __construct($conexion_db) {
        $this->conexion_db = $conexion_db;
    }

    public function autenticarUsuario($tipdoc, $numdoc, $clave) {
        // Verifica que los campos no estén vacíos
        if (empty($tipdoc) || empty($numdoc) || empty($clave)) {
            header('Content-Type: application/json');
            echo json_encode(array('success' => false, 'error' => 'Todos los campos deben estar completos'));
            return;
        }

        // Crea una instancia del modelo
        $userModel = new UserModel($this->conexion_db);

        // Escapa las variables para prevenir la inyección SQL
        $tipdoc = mysqli_real_escape_string($this->conexion_db, $tipdoc);
        $numdoc = mysqli_real_escape_string($this->conexion_db, $numdoc);
        $clave = mysqli_real_escape_string($this->conexion_db, $clave);

        // Obtener los datos del usuario en particular
        $usuario = $userModel->obtenerDatosAfiliadoPorNumDoc($tipdoc, $numdoc, $clave);

        // Realiza la consulta adicional para obtener el campo descrip utilizando el modelo
        $descrip = $userModel->obtenerDescripPorPlan($tipdoc, $numdoc, $clave);

        if ($usuario !== null) {
            // Si se encontró el usuario, establece la variable de sesión para indicar que está autenticado
            $_SESSION['autenticado'] = true;

            // Ajusta el formato de respuesta con los campos requeridos
            $response = array(
                'success' => true,
                'data' => array(
                    'tipdoc' => $usuario['tipdoc'],
                    'numdoc' => $usuario['numdoc'],
                    'nombre' => $usuario['nombre'],
                    'baja' => ($usuario['baja'] == '0000-00-00 00:00:00') ? null : $usuario['baja'],
                    'numero' => $usuario['numero'],  
                    'orden' => $usuario['orden'],    
                    'ingre' => $usuario['ingre'],    
                    'nacim' => $usuario['nacim'],
                    'descrip' => $descrip  // Agrega el campo descrip al array de respuesta    
                )
            );

            // Devuelve los datos del usuario en formato JSON junto con un mensaje de éxito
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } else {
            // Si no se encontró el usuario o las credenciales no son válidas, puedes mostrar un mensaje de error
            header('Content-Type: application/json');
            echo json_encode(array('success' => false, 'error' => 'Credenciales inexistentes'));
        }
    }
}

// Verifica si la solicitud es de tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se enviaron los datos de inicio de sesión y que no estén vacíos
    if (isset($_POST['tipdoc']) && isset($_POST['numdoc']) && isset($_POST['clave'])) {
        $tipdoc = $_POST['tipdoc'];
        $numdoc = $_POST['numdoc'];
        $clave = $_POST['clave'];

        // Crea una instancia del controlador y llama al método para autenticar al usuario
        $controllerInstance = new UserController($conexion_db);
        $controllerInstance->autenticarUsuario($tipdoc, $numdoc, $clave);
    } else {
        // Datos faltantes en la solicitud
        header('Content-Type: application/json');
        echo json_encode(array('success' => false, 'error' => 'Datos faltantes en la solicitud'));
    }
} else {
    // eRROR inesperado
    header('Content-Type: application/json');
    echo json_encode(array('success' => false, 'error' => 'Error inesperado'));
}
?>
