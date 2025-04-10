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

    <div class="services-grid">
        <?php
        try {
            $stmt = $conn->query("SELECT nombre, descripcion, link FROM servicios");
            $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($servicios) > 0) {
                foreach ($servicios as $servicio) {
                    $videoID = trim($servicio['link']); // Limpiamos posibles saltos de línea

                    echo '
                    <div class="service-card">
                        <h3>' . htmlspecialchars($servicio['nombre']) . '</h3>
                        <div class="service-description">
                            <p>' . nl2br(htmlspecialchars($servicio['descripcion'])) . '</p>
                        </div>';

                    if (!empty($videoID)) {
                        echo '
                        <button class="video-btn" data-video-id="' . htmlspecialchars($videoID) . '">
                            Ver Video Explicativo
                        </button>';
                    }

                    echo '</div>';
                }
            } else {
                echo '<p class="no-results">No hay servicios disponibles aún.</p>';
            }
        } catch (PDOException $e) {
            echo '<p class="error">Error al cargar servicios: ' . $e->getMessage() . '</p>';
        }
        ?>
    </div>


    <!-- Sección de comentarios -->
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

<!-- Modal para videos de YouTube -->
<div id="videoModal" class="modal" style="display:none; justify-content:center; align-items:center; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.6); z-index:1000;">
    <div class="modal-content" style="position:relative; width:90%; max-width:800px; background:#fff; padding:1rem; border-radius:8px;">
        <span class="close-modal" style="position:absolute; top:10px; right:20px; font-size:1.5rem; cursor:pointer;">&times;</span>
        <iframe id="videoFrame" width="100%" height="450" frameborder="0" allowfullscreen></iframe>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('videoModal');
    const videoFrame = document.getElementById('videoFrame');
    const closeBtn = document.querySelector('.close-modal');
    const videoBtns = document.querySelectorAll('.video-btn');

    videoBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const videoID = this.getAttribute('data-video-id');
            if (!videoID || videoID === "null") {
                alert("Video no disponible");
                return;
            }

            const embedUrl = `https://www.youtube.com/embed/${videoID}`;
            videoFrame.src = embedUrl;
            modal.style.display = 'flex';
        });
    });

    closeBtn.addEventListener('click', function () {
        modal.style.display = 'none';
        videoFrame.src = '';
    });

    window.addEventListener('click', function (e) {
        if (e.target === modal) {
            modal.style.display = 'none';
            videoFrame.src = '';
        }
    });
});
</script>


<!-- Estilos básicos para el modal -->
<style>
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: #fff;
    padding: 1rem;
    border-radius: 8px;
    max-width: 90%;
    max-height: 90%;
    overflow: auto;
    position: relative;
}

.close-modal {
    position: absolute;
    top: 0.5rem;
    right: 1rem;
    font-size: 1.5rem;
    cursor: pointer;
}

#videoFrame {
    width: 100%;
    height: 400px;
}
</style>
