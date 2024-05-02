<!-- <?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluye el modelo y la conexión a la base de datos
require_once "./app/Models/UserModel.php";
require_once "./config/conexiondb.php";

class UserController {
    private $conexion_db;

    public function __construct($conexion_db) {
        $this->conexion_db = $conexion_db;
    }

    public function autenticarUsuario() {
        // Crea una instancia del modelo
        $userModel = new UserModel($this->conexion_db);

        // Maneja la solicitud HTTP
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtén los datos del usuario desde la solicitud POST
            if (isset($_POST['tipdoc']) && isset($_POST['numdoc']) && isset($_POST['clave'])) {
                $tipdoc = $_POST['tipdoc'];
                $numdoc = $_POST['numdoc'];
                $clave = $_POST['clave'];

                // Obtener los datos del usuario en particular
                $usuario = $userModel->obtenerDatosAfiliadoPorNumDoc($tipdoc, $numdoc, $clave);

                if ($usuario !== null) {
                    // Si se encontró el usuario, devuelve sus datos en formato JSON
                    header('Content-Type: application/json');
                    echo json_encode($usuario);
                    var_dump($usuario); // Línea para depuración
                } else {
                    // Si no se encontró el usuario o las credenciales no son válidas, puedes mostrar un mensaje de error
                    header('Content-Type: application/json');
                    echo json_encode(array('error' => 'Credenciales no válidas'));
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(array('error' => 'Datos faltantes en la solicitud'));
            }
        } else {
            // Maneja otros tipos de solicitudes (puedes mostrar un mensaje de error o realizar alguna acción específica)
            header('Content-Type: application/json');
            echo json_encode(array('error' => 'Método no permitido'));
        }
    }
}
?> -->
