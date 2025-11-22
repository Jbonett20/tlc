<?php
// Iniciar la sesión (sin establecer un ID fijo, a menos que sea necesario por un caso de uso específico)
session_start();

// Destruir toda la información de la sesión
session_unset();
session_destroy();

// Eliminar la cookie de la sesión, si aplica
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirigir a la página de inicio de sesión
header('Location: https://ltc.tuingapp.com/#/login');
exit;
?>
