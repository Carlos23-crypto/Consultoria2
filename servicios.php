<?php
$pageTitle = "Nuestros Servicios";
include('includes/head.php');
include('includes/header.php');
include('includes/db.php');
?>

<main class="main-container">
    <h1 class="page-title">Nuestros Servicios</h1>
    
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
</main>

<!-- Modal para videos -->
<div id="videoModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <iframe id="videoFrame" width="560" height="315" frameborder="0" allowfullscreen></iframe>
    </div>
</div>

<?php include('includes/footer.php'); ?>