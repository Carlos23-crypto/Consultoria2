<header class="header-container">
  <div class="logo-section">
    <img src="assets/img/Logo.jpg" alt="Logo" class="logo">
    <h1 class="app-title"GQ-Services</h1>
  </div>
  
  <nav class="nav-menu">
    <button class="nav-button" id="registerBtn">Registrar</button>
    <?php
      $currentPage = basename($_SERVER['PHP_SELF']);
      $navItems = [
        'acerca-de.php' => 'Acerca de',
        'servicios.php' => 'Servicios',
        'clientes.php' => 'Clientes'
      ];
      
      foreach ($navItems as $file => $title) {
        $isActive = ($currentPage === $file) ? 'active' : '';
        echo "<a href=\"$file\" class=\"nav-link $isActive\">$title</a>";
      }
    ?>
  </nav>
</header>