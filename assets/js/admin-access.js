document.addEventListener('DOMContentLoaded', function() {
    // Elementos
    const adminLink = document.getElementById('adminAccessLink');
    const codeModal = document.getElementById('codeModal');
    const loginModal = document.getElementById('loginModal');
    const accessCodeInput = document.getElementById('accessCode');
    const verifyBtn = document.getElementById('verifyCode');
    const codeError = document.getElementById('codeError');
    
    // Código de acceso (cámbialo por uno seguro en producción)
    const VALID_CODE = "GQ2024"; 
    
    // Mostrar modal de código al hacer clic en el enlace
    adminLink.addEventListener('click', function(e) {
      e.preventDefault();
      codeModal.style.display = 'block';
    });
    
    // Verificar código
    verifyBtn.addEventListener('click', function() {
      if(accessCodeInput.value === VALID_CODE) {
        codeModal.style.display = 'none';
        loginModal.style.display = 'block';
        codeError.style.display = 'none';
        accessCodeInput.value = '';
      } else {
        codeError.style.display = 'block';
      }
    });
    
    // Cerrar modales
    document.querySelectorAll('.close-modal').forEach(btn => {
      btn.addEventListener('click', function() {
        codeModal.style.display = 'none';
        loginModal.style.display = 'none';
      });
    });
    
    // Cerrar al hacer clic fuera del modal
    window.addEventListener('click', function(e) {
      if(e.target === codeModal || e.target === loginModal) {
        codeModal.style.display = 'none';
        loginModal.style.display = 'none';
      }
    });
  });