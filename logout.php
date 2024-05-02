<!-- <?php

// Inicia la sesión
session_start();

// Verifica si la solicitud es de tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si el usuario está autenticado
    if (isset($_SESSION['autenticado'])) {
        // Elimina todas las variables de sesión
        session_unset();

        // Destruye la sesión
        session_destroy();

        // Responde con un mensaje de éxito
        header('Content-Type: application/json');
        echo json_encode(array('message' => 'Sesión cerrada con éxito'));
    } else {
        // Si el usuario no está autenticado, responde con un mensaje de error
        header('HTTP/1.1 401 Unauthorized');
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'No se ha iniciado sesión'));
    }
} else {
    // Si la solicitud no es de tipo POST, retorna un error
    header('HTTP/1.1 405 Method Not Allowed');
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'Método no permitido'));
}

?> -->