<?php
session_start();

// Verifica si el usuario está autenticado
function verificarAutenticacion() {
    if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
        header("Location: ../admin/login.php");
        exit;
    }
}

// Valida credenciales (ejemplo básico - ideal usar DB)
function autenticar($usuario, $contrasena) {
    // Ejemplo: usuario "admin" / contraseña "123" (¡Cambia esto en producción!)
    if ($usuario === 'admin' && $contrasena === '123') {
        $_SESSION['autenticado'] = true;
        return true;
    }
    return false;
}
?>