<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    if (autenticar($usuario, $contrasena)) {
        header("Location: administrador.php");
        exit;
    } else {
        $error = "Credenciales incorrectas";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include '../includes/head.php'; ?>
    <title>Login Administrador</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="login-container">
        <h2>Acceso Administrativo</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>
</html>