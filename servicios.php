<?php
$pageTitle = "Nuestros Servicios";
include('includes/head.php');
include('includes/header.php');
include('includes/db.php');

// Procesar formulario de comentarios
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comentario'])) {
    $nombre = htmlspecialchars($_POST['nombre'] ?? '');
    $apellido_paterno = htmlspecialchars($_POST['apellido_paterno'] ?? '');
    $apellido_materno = htmlspecialchars($_POST['apellido_materno'] ?? '');
    $comentario = htmlspecialchars($_POST['comentario'] ?? '');
    $fecha = date('Y-m-d H:i:s');

    try {
        $stmt = $conn->prepare("INSERT INTO clientes (nombre, apellido_paterno, apellido_materno, comentario, fecha) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $apellido_paterno, $apellido_materno, $comentario, $fecha]);
        
        $mensajeExito = "¡Gracias por tu comentario!";
    } catch(PDOException $e) {
        $mensajeError = "Error al guardar el comentario: " . $e->getMessage();
    }
}
?>

<main class="main-container">
    <h1 class="page-title">Nuestros Servicios</h1>
    
    <!-- Contenedor de servicios existente (sin cambios) -->
    <div class="services-grid">
        <?php
        try {
            $stmt = $conn->query("SELECT nombre, descripcion, link FROM servicios");
            $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if(count($servicios) > 0) {
                foreach($servicios as $servicio) {
                    echo '
                    <div class="service-card">
                        <h3>'.htmlspecialchars($servicio['nombre']).'</h3>
                        <div class="service-description">
                            <p>'.nl2br(htmlspecialchars($servicio['descripcion'])).'</p>
                        </div>
                        <button class="video-btn" data-video-url="'.htmlspecialchars($servicio['link']).'">
                            Ver Video Explicativo
                        </button>
                    </div>';
                }
            } else {
                echo '<p class="no-results">No hay servicios disponibles aún.</p>';
            }
        } catch(PDOException $e) {
            echo '<p class="error">Error al cargar servicios: '.$e->getMessage().'</p>';
        }
        ?>
    </div>

    <!-- Nuevo formulario de comentarios -->
    <section class="comment-section">
        <h2>Deja tu comentario</h2>
        
        <?php if (isset($mensajeExito)): ?>
            <div class="alert success"><?= $mensajeExito ?></div>
        <?php elseif (isset($mensajeError)): ?>
            <div class="alert error"><?= $mensajeError ?></div>
        <?php endif; ?>
        
        <form method="POST" class="comment-form">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            
            <div class="form-group">
                <label for="apellido_paterno">Apellido Paterno:</label>
                <input type="text" id="apellido_paterno" name="apellido_paterno">
            </div>
            
            <div class="form-group">
                <label for="apellido_materno">Apellido Materno:</label>
                <input type="text" id="apellido_materno" name="apellido_materno">
            </div>
            
            <div class="form-group">
                <label for="comentario">Comentario:</label>
                <textarea id="comentario" name="comentario" rows="4" required></textarea>
            </div>
            
            <button type="submit" class="submit-btn">Enviar Comentario</button>
        </form>
    </section>
</main>

<!-- Modal para videos (existente) -->
<div id="videoModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <iframe id="videoFrame" width="560" height="315" frameborder="0" allowfullscreen></iframe>
    </div>
</div>

<?php include('includes/footer.php'); ?>