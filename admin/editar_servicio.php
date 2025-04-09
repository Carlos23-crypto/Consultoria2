<?php
// ==============================================
// CONFIGURACIÓN INICIAL
// ==============================================
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

// Verificar autenticación
if (session_status() === PHP_SESSION_NONE) session_start();
verificarAutenticacion();

// ==============================================
// OBTENER DATOS DEL SERVICIO A EDITAR
// ==============================================
$id = filter_var($_GET['id'] ?? 0, FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: administrador.php?error=id_invalido");
    exit;
}

// Obtener el servicio actual
$stmt = $conn->prepare("SELECT * FROM servicios WHERE id = ?");
$stmt->execute([$id]);
$servicio = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$servicio) {
    header("Location: administrador.php?error=servicio_no_encontrado");
    exit;
}

// ==============================================
// PROCESAR ACTUALIZACIÓN
// ==============================================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST['nombre'] ?? '');
    $descripcion = htmlspecialchars($_POST['descripcion'] ?? '');
    $link = htmlspecialchars($_POST['link'] ?? '');

    try {
        // Validaciones
        if (empty($nombre) || empty($link)) {
            throw new Exception("Nombre y link son campos obligatorios.");
        }

        if (!filter_var($link, FILTER_VALIDATE_URL)) {
            throw new Exception("El link debe ser una URL válida.");
        }

        // Actualizar en la base de datos
        $stmt = $conn->prepare("UPDATE servicios SET nombre = ?, descripcion = ?, link = ? WHERE id = ?");
        $stmt->execute([$nombre, $descripcion, $link, $id]);

        header("Location: administrador.php?success=servicio_actualizado");
        exit;
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

// ==============================================
// VISTA HTML
// ==============================================
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Servicio</title>
    <style>
        /* Usa los mismos estilos que administrador.php */
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
            max-width: 800px;
            margin: 0 auto;
        }
        
        .tarjeta {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        h1 {
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
        
        input, textarea {
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
            display: inline-block;
            margin-right: 10px;
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
    </style>
</head>
<body>
    <div class="contenedor-principal">
        <a href="administrador.php" class="boton">← Volver</a>
        
        <div class="tarjeta">
            <h1>Editar Servicio</h1>
            
            <?php if (isset($mensaje)): ?>
                <div class="mensaje <?= $mensaje['tipo'] ?>">
                    <?= $mensaje['texto'] ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="formulario-grupo">
                    <label for="nombre">Nombre del servicio:</label>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($servicio['nombre']) ?>" required>
                </div>
                
                <div class="formulario-grupo">
                    <label for="descripcion">Descripción:</label>
                    <textarea name="descripcion" rows="3"><?= htmlspecialchars($servicio['descripcion']) ?></textarea>
                </div>
                
                <div class="formulario-grupo">
                    <label for="link">Link (URL):</label>
                    <input type="url" name="link" value="<?= htmlspecialchars($servicio['link']) ?>" placeholder="https://ejemplo.com" required>
                </div>
                
                <button type="submit" class="boton">Guardar Cambios</button>
                <a href="administrador.php" class="boton" style="background: #6c757d;">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>