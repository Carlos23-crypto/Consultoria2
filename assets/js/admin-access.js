document.addEventListener('DOMContentLoaded', function () {
    const adminLink = document.getElementById('adminAccessLink');
    const codeModal = document.getElementById('codeModal');
    const accessCodeInput = document.getElementById('accessCode');
    const verifyBtn = document.getElementById('verifyCode');
    const codeError = document.getElementById('codeError');
    const closeButtons = document.querySelectorAll('.close-modal');
  
    adminLink.addEventListener('click', function (e) {
      e.preventDefault();
      codeModal.style.display = 'block';
    });
  
    verifyBtn.addEventListener('click', function () {
      const codigo = accessCodeInput.value.trim();
  
      fetch('includes/verificar_codigo.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'codigo=' + encodeURIComponent(codigo)
      })
        .then(response => response.text())
        .then(result => {
          if (result.trim() === 'success') {
            window.location.href = 'login.php'; // redirige a la página de login
          } else {
            codeError.style.display = 'block';
          }
        })
        .catch(error => {
          console.error('Error al verificar código:', error);
        });
    });
  
    closeButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        codeModal.style.display = 'none';
      });
    });
  
    window.addEventListener('click', function (e) {
      if (e.target === codeModal) {
        codeModal.style.display = 'none';
      }
    });
  });
  