<?php
session_start();
require_once __DIR__ . '/db.php'; // Ruta correcta dentro de includes

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'] ?? '';

    try {
        $stmt = $conn->prepare("SELECT id FROM administradores WHERE codigo = ?");
        $stmt->execute([$codigo]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            $_SESSION['codigo_verificado'] = true;
            $_SESSION['admin_id_temp'] = $admin['id'];
            
            echo json_encode([
                'success' => true,
                'redirect' => 'admin/login.php' // Ruta desde /includes/
            ]);
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'Código de acceso inválido'
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false, 
            'message' => 'Error en la base de datos: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Método no permitido'
    ]);
}
?>