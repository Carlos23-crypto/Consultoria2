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
  });document.addEventListener('DOMContentLoaded', function () {
        const videoButtons = document.querySelectorAll('.video-btn');
        const videoModal = document.getElementById('videoModal');
        const videoFrame = document.getElementById('videoFrame');
        const closeModal = document.querySelector('.close-modal');

        // Función para convertir el enlace de Drive a formato embebido
        function convertirDriveAEmbed(url) {
            const match = url.match(/\/file\/d\/([^/]+)\//);
            if (match && match[1]) {
                return `https://drive.google.com/file/d/${match[1]}/preview`;
            }
            return url; // Si no es un link de Drive, se deja igual
        }

        // Mostrar el video al hacer clic en el botón
        videoButtons.forEach(button => {
            button.addEventListener('click', function () {
                const videoUrl = convertirDriveAEmbed(this.getAttribute('data-video-url'));
                videoFrame.src = videoUrl;
                videoModal.style.display = 'block';
            });
        });

        // Cerrar el modal
        closeModal.addEventListener('click', function () {
            videoModal.style.display = 'none';
            videoFrame.src = ''; // Limpia el iframe para detener el video
        });

        // También cerrar si el usuario hace clic fuera del contenido del modal
        window.addEventListener('click', function (event) {
            if (event.target === videoModal) {
                videoModal.style.display = 'none';
                videoFrame.src = '';
            }
        });
    });