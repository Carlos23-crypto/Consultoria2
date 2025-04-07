document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado - Listo para eventos');
  
    const loginLink = document.getElementById('hiddenLoginLink');
    
    if (!loginLink) {
      console.error('Error: Elemento hiddenLoginLink no encontrado');
      return;
    }
  
    document.addEventListener('keydown', function(e) {
      // Combinación: Alt + Shift + A (alternativa)
      if (e.altKey && e.shiftKey && e.key.toUpperCase() === 'A') {
        e.preventDefault();
        loginLink.style.display = 
          loginLink.style.display === 'block' ? 'none' : 'block';
        console.log('Estado del enlace:', loginLink.style.display);
      }
    });
  
    // Opcional: Mostrar temporalmente para pruebas
    // loginLink.style.display = 'block'; // ¡Quitar después de probar!
  });