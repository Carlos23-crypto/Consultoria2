<?php
include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];

    $stmt = $conn->prepare("SELECT * FROM administradores WHERE codigo = ?");
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $result = $stmt->get_result();

    echo ($result->num_rows > 0) ? 'success' : 'error';
}
?>
