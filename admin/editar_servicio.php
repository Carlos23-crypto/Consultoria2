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

// Convertir URL almacenada a solo ID para mostrarla en el formulario
if ($servicio && !empty($servicio['link'])) {
    $servicio['link'] = extractYouTubeId($servicio['link']);
}

if (!$servicio) {
    header("Location: administrador.php?error=servicio_no_encontrado");
    exit;
}

// Función para extraer ID de YouTube de una URL
function extractYouTubeId($url) {
    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/)|youtu\.be\/)([0-9a-z_-]{11})/i', $url, $matches)) {
        return $matches[1];
    }
    return $url; // Si no es URL, asumimos que ya es un ID
}

// ==============================================
// PROCESAR ACTUALIZACIÓN
// ==============================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST['nombre'] ?? '');
    $descripcion = htmlspecialchars($_POST['descripcion'] ?? '');
    $video_id = trim(htmlspecialchars($_POST['link'] ?? ''));

    try {
        // Validaciones
        if (empty($nombre) || empty($video_id)) {
            throw new Exception("Nombre e ID del video son campos obligatorios.");
        }

        // Validar formato del ID de YouTube (11 caracteres alfanuméricos)
        if (!preg_match('/^[0-9a-z_-]{11}$/i', $video_id)) {
            throw new Exception("El ID del video debe tener exactamente 11 caracteres alfanuméricos (ejemplo: am21eumHG6w)");
        }

        // Aquí solo guardamos el ID del video, no la URL completa
        $link = $video_id;  // Solo almacenamos el ID del video (no la URL completa)

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
// VISTA HTML (MODIFICADA PARA MOSTRAR SOLO EL ID)
// ==============================================
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Servicio</title>
    <style>
        /* Estilos anteriores se mantienen igual */
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
        
        .video-id-example {
            font-size: 0.9em;
            color: #666;
            margin-top: 5px;
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
                    <label for="link">ID del Video de YouTube:</label>
                    <input type="text" name="link" value="<?= htmlspecialchars($servicio['link']) ?>" 
                           placeholder="Ejemplo: am21eumHG6w" required
                           pattern="[0-9a-zA-Z_-]{11}" 
                           title="11 caracteres alfanuméricos (puede incluir guiones y guiones bajos)">
                    <div class="video-id-example">
                        Solo ingresa el ID del video (ejemplo: am21eumHG6w)<br>
                        El sistema convertirá automáticamente a formato embebido
                    </div>
                </div>
                
                <button type="submit" class="boton">Guardar Cambios</button>
                <a href="administrador.php" class="boton" style="background: #6c757d;">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>