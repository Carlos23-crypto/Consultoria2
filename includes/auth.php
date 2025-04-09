<?php
function iniciarSesionSegura() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function verificarAutenticacion() {
    iniciarSesionSegura();
    
    if (!isset($_SESSION['autenticado'])) {
        header("Location: login.php");
        exit;
    }
}

function autenticar($conn, $usuario, $contrasena) {
    iniciarSesionSegura();
    
    $stmt = $conn->prepare("SELECT id, contrasenia FROM administradores WHERE nombre_usuario = ?");
    $stmt->execute([$usuario]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && $contrasena === $admin['contrasenia']) {
        $_SESSION['autenticado'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        return true;
    }
    return false;
}