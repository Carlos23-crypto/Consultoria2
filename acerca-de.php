<?php
$pageTitle = "Acerca de Nosotros";
include('includes/head.php');
include('includes/header.php');
?>

<main class="about-container">
  <!-- Contenido específico de About -->
  <section class="section">
    <h2 class="section-title">¿Quiénes somos?</h2>
    <p class="section-content">Texto descriptivo...</p>
  </section>
  
  <!-- Sección del equipo -->
  <?php include('includes/team-section.php'); ?>
</main>

<?php include('includes/footer.php'); ?>