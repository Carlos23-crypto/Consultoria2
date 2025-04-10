document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('videoModal');
    const videoFrame = document.getElementById('videoFrame');
    const closeBtn = document.querySelector('.close-modal');
    const videoBtns = document.querySelectorAll('.video-btn');

    // Abrir modal con el link directo (ya viene listo desde PHP)
    videoBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const videoID = this.getAttribute('data-video-id');
            if (!videoID) {
                alert("Video no disponible");
                return;
            }
    
            const videoUrl = `https://www.youtube.com/embed/${videoID}`;
            videoFrame.src = videoUrl;
            modal.style.display = 'flex';
        });
    });
    

    // Cerrar modal
    closeBtn.addEventListener('click', function() {
        videoFrame.src = ''; // Limpia el iframe al cerrar
        modal.style.display = 'none';
    });

    // Cerrar al hacer clic fuera del modal
    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            videoFrame.src = '';
            modal.style.display = 'none';
        }
    });
});
