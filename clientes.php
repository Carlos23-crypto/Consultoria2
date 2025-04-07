<?php
$pageTitle = "Nuestros Clientes";
include('includes/head.php');
include('includes/header.php');
include('includes/db.php'); // Incluir conexión a BD
?>

<main class="main-container">
    <h1 class="page-title">Testimonios de Clientes</h1>
    
    <div class="testimonials-container">
        <?php
        try {
            $stmt = $conn->query("SELECT nombre, `apellido_paterno`, fecha, comentario FROM clientes ORDER BY fecha DESC");
            $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if(count($clientes) > 0) {
                foreach($clientes as $cliente) {
                    echo '
                    <div class="testimonial-card">
                        <div class="client-info">
                            <h3>'.htmlspecialchars($cliente['nombre']).' '.htmlspecialchars($cliente['apellido_paterno']).'</h3>
                            <span class="testimonial-date">'.date('d/m/Y', strtotime($cliente['fecha'])).'</span>
                        </div>
                        <div class="testimonial-content">
                            <p>'.nl2br(htmlspecialchars($cliente['comentario'])).'</p>
                        </div>
                    </div>';
                }
            } else {
                echo '<p class="no-results">No hay testimonios disponibles aún.</p>';
            }
        } catch(PDOException $e) {
            echo '<p class="error">Error al cargar testimonios: '.$e->getMessage().'</p>';
        }
        ?>
    </div>
</main>

<?php include('includes/footer.php'); ?>