document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('videoModal');
    const videoFrame = document.getElementById('videoFrame');
    const closeBtn = document.querySelector('.close-modal');
    const videoBtns = document.querySelectorAll('.video-btn');
    
    // Abrir modal con video
    videoBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const videoUrl = this.getAttribute('data-video-url');
            // Convertir enlace de Drive a embed
            const embedUrl = videoUrl.replace('/view?usp=sharing', '/preview')
                                    .replace('/file/d/', '/embed/')
                                    .replace('/view', '');
            
            videoFrame.src = embedUrl;
            modal.style.display = 'flex';
        });
    });
    
    // Cerrar modal
    closeBtn.addEventListener('click', function() {
        videoFrame.src = '';
        modal.style.display = 'none';
    });
    
    // Cerrar al hacer clic fuera
    window.addEventListener('click', function(e) {
        if(e.target === modal) {
            videoFrame.src = '';
            modal.style.display = 'none';
        }
    });
});