<?php
include('includes/db.php'); // Incluir conexión a BD

// --- Insertar nuevo servicio (tu código existente) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $link = $_POST['link'];

    try {
        if (empty($nombre) || empty($link)) {
            throw new Exception("Nombre y link son campos obligatorios.");
        }

        $sql = "INSERT INTO servicios (nombre, descripcion, link) VALUES (:nombre, :descripcion, :link)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':link', $link, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $mensaje = "✅ Servicio agregado correctamente.";
        } else {
            $mensaje = "❌ Error al agregar el servicio.";
        }
    } catch (PDOException $e) {
        $mensaje = "⚠️ Error de base de datos: " . $e->getMessage();
    } catch (Exception $e) {
        $mensaje = "⚠️ " . $e->getMessage();
    }
}

// --- Eliminar servicio ---
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    try {
        $stmt = $conn->prepare("DELETE FROM servicios WHERE id = ?");
        $stmt->execute([$id]);
        $mensaje = "✅ Servicio eliminado correctamente.";
    } catch (PDOException $e) {
        $mensaje = "⚠️ Error al eliminar: " . $e->getMessage();
    }
}

// --- Obtener todos los servicios ---
$servicios = $conn->query("SELECT * FROM servicios ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador - Servicios</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f4f4f9; }
        .form-container, .tabla-container { 
            max-width: 800px; margin: 20px auto; padding: 20px; 
            background: white; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); 
        }
        h1 { color: #333; text-align: center; }
        label { display: block; margin: 10px 0 5px; font-weight: bold; }
        input, textarea { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #218838; }
        .mensaje { padding: 10px; margin: 10px 0; border-radius: 4px; text-align: center; }
        .exito { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; }
        tr:hover { background: #f1f1f1; }
        .acciones a { 
            margin-right: 10px; text-decoration: none; padding: 5px 10px; border-radius: 3px; 
        }
        .editar { background: #ffc107; color: #000; }
        .eliminar { background: #dc3545; color: #fff; }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Agregar Nuevo Servicio</h1>
        
        <?php if (!empty($mensaje)): ?>
            <div class="mensaje <?php echo strpos($mensaje, 'Error') === false ? 'exito' : 'error'; ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <form action="administrador.php" method="POST">
            <label for="nombre">Nombre del servicio:</label>
            <input type="text" name="nombre" required>
            
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" rows="3"></textarea>
            
            <label for="link">Link (URL):</label>
            <input type="url" name="link" placeholder="https://ejemplo.com" required>
            
            <button type="submit">Guardar Servicio</button>
        </form>
    </div>

    <div class="tabla-container">
        <h2>Servicios Registrados</h2>
        <?php if (empty($servicios)): ?>
            <p>No hay servicios registrados.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Link</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($servicios as $servicio): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($servicio['id']); ?></td>
                            <td><?php echo htmlspecialchars($servicio['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($servicio['descripcion']); ?></td>
                            <td>
                                <a href="<?php echo htmlspecialchars($servicio['link']); ?>" target="_blank">Ver</a>
                            </td>
                            <td class="acciones">
                                <a href="editar_servicio.php?id=<?php echo $servicio['id']; ?>" class="editar">Editar</a>
                                <a href="administrador.php?eliminar=<?php echo $servicio['id']; ?>" class="eliminar" 
                                   onclick="return confirm('¿Eliminar este servicio?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>