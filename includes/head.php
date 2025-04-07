<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($pageTitle ?? 'GQ Services'); ?></title>
  
  <!-- Estilos globales (siempre se cargan) -->
  <link rel="stylesheet" href="assets/css/styles.css">
  <link rel="stylesheet" href="assets/css/header.css">
  <link rel="stylesheet" href="assets/css/footer.css"> <!-- Aquí añades el footer -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- Carga condicional de estilos específicos -->
  <?php 
  $currentPage = basename($_SERVER['PHP_SELF']);
  
  // Definir qué CSS adicionales cargar según la página
  $pageStyles = [
    'acerca-de.php' => 'acerca-de.css',
    'clientes.php' => 'clientes.css',
    'servicios.php' => 'servicios.css'
  ];
  
  if(array_key_exists($currentPage, $pageStyles)): ?>
    <link rel="stylesheet" href="assets/css/<?php echo $pageStyles[$currentPage]; ?>">
  <?php endif; ?>
  
  <!-- Cargar JS solo en servicios.php -->
  <?php if($currentPage === 'servicios.php'): ?>
    <script src="assets/js/servicios.js" defer></script>
  <?php endif; ?>
</head>
<body>