<?php
// ==============================================
// SECCIÓN DE SEGURIDAD Y CONFIGURACIÓN INICIAL
// ==============================================

// 1. Iniciar sesión y validar autenticación
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Incluir archivos necesarios con rutas absolutas
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

// 3. Verificar autenticación
verificarAutenticacion();

// ==============================================
// MANEJO DE OPERACIONES CRUD
// ==============================================

// --- Insertar nuevo servicio ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre'])) {
    $nombre = htmlspecialchars($_POST['nombre']);
    $descripcion = htmlspecialchars($_POST['descripcion']);
    $link = htmlspecialchars($_POST['link']);

    try {
        // Validación de campos
        if (empty($nombre) || empty($link)) {
            throw new Exception("Nombre y link son campos obligatorios.");
        }

        // Validación de URL
        if (!filter_var($link, FILTER_VALIDATE_URL)) {
            throw new Exception("El link debe ser una URL válida.");
        }

        $sql = "INSERT INTO servicios (nombre, descripcion, link) VALUES (:nombre, :descripcion, :link)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':link', $link, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $mensaje = [
                'texto' => "✅ Servicio agregado correctamente.",
                'tipo' => 'exito'
            ];
        }
    } catch (PDOException $e) {
        $mensaje = [
            'texto' => "⚠️ Error de base de datos: " . $e->getMessage(),
            'tipo' => 'error'
        ];
    } catch (Exception $e) {
        $mensaje = [
            'texto' => "⚠️ " . $e->getMessage(),
            'tipo' => 'error'
        ];
    }
}

// --- Eliminar servicio ---
if (isset($_GET['eliminar'])) {
    $id = filter_var($_GET['eliminar'], FILTER_VALIDATE_INT);
    
    if ($id) {
        try {
            $stmt = $conn->prepare("DELETE FROM servicios WHERE id = ?");
            $stmt->execute([$id]);
            
            $mensaje = [
                'texto' => "✅ Servicio eliminado correctamente.",
                'tipo' => 'exito'
            ];
        } catch (PDOException $e) {
            $mensaje = [
                'texto' => "⚠️ Error al eliminar: " . $e->getMessage(),
                'tipo' => 'error'
            ];
        }
    } else {
        $mensaje = [
            'texto' => "⚠️ ID de servicio inválido",
            'tipo' => 'error'
        ];
    }
}

// --- Obtener todos los servicios ---
$servicios = $conn->query("SELECT * FROM servicios ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

// ==============================================
// VISTA HTML
// ==============================================
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador - Servicios</title>
    <style>
        :root {
            --color-exito: #d4edda;
            --color-error: #f8d7da;
            --color-texto-exito: #155724;
            --color-texto-error: #721c24;
            --color-primario: #28a745;
            --color-primario-hover: #218838;
        }
        
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: #f4f4f9; 
            line-height: 1.6;
        }
        
        .contenedor-principal {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .tarjeta {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        h1, h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .formulario-grupo {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        input, textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .boton {
            background: var(--color-primario);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }
        
        .boton:hover {
            background: var(--color-primario-hover);
        }
        
        .mensaje {
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            text-align: center;
        }
        
        .mensaje.exito {
            background: var(--color-exito);
            color: var(--color-texto-exito);
        }
        
        .mensaje.error {
            background: var(--color-error);
            color: var(--color-texto-error);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background: #f8f9fa;
            font-weight: 600;
        }
        
        tr:hover {
            background: #f1f1f1;
        }
        
        .acciones {
            white-space: nowrap;
        }
        
        .acciones a {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 3px;
            margin-right: 5px;
            display: inline-block;
        }
        
        .editar {
            background: #ffc107;
            color: #000;
        }
        
        .eliminar {
            background: #dc3545;
            color: #fff;
        }
        
        .cerrar-sesion {
            display: block;
            text-align: right;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="contenedor-principal">
        <a href="../acerca-de.php" class="cerrar-sesion">Cerrar Sesión</a>
        
        <!-- Formulario para agregar servicios -->
        <div class="tarjeta">
            <h1>Agregar Nuevo Servicio</h1>
            
            <?php if (isset($mensaje)): ?>
                <div class="mensaje <?= $mensaje['tipo'] ?>">
                    <?= $mensaje['texto'] ?>
                </div>
            <?php endif; ?>

            <form action="administrador.php" method="POST">
                <div class="formulario-grupo">
                    <label for="nombre">Nombre del servicio:</label>
                    <input type="text" name="nombre" required>
                </div>
                
                <div class="formulario-grupo">
                    <label for="descripcion">Descripción:</label>
                    <textarea name="descripcion" rows="3"></textarea>
                </div>
                
                <div class="formulario-grupo">
                    <label for="link">Link (URL):</label>
                    <input type="url" name="link" placeholder="https://ejemplo.com" required>
                </div>
                
                <button type="submit" class="boton">Guardar Servicio</button>
            </form>
        </div>

        <!-- Listado de servicios -->
        <div class="tarjeta">
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
                                <td><?= htmlspecialchars($servicio['id']) ?></td>
                                <td><?= htmlspecialchars($servicio['nombre']) ?></td>
                                <td><?= htmlspecialchars($servicio['descripcion']) ?></td>
                                <td>
                                    <a href="<?= htmlspecialchars($servicio['link']) ?>" target="_blank">Ver</a>
                                </td>
                                <td class="acciones">
                                    <a href="editar_servicio.php?id=<?= $servicio['id'] ?>" class="editar">Editar</a>
                                    <a href="administrador.php?eliminar=<?= $servicio['id'] ?>" class="eliminar" 
                                       onclick="return confirm('¿Estás seguro de eliminar este servicio?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>