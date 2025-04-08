<?php
require_once 'db.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'] ?? '';

    try {
        // Verificar si el código existe en cualquier usuario admin
        $stmt = $conn->prepare("SELECT COUNT(*) FROM administradores WHERE codigo = ?");
        $stmt->execute([$codigo]);
        $existe = $stmt->fetchColumn();

        if ($existe) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Código inválido']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error en la base de datos']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>