document.addEventListener('DOMContentLoaded', function() {
  const adminLink = document.getElementById('adminAccessLink');
  const codeModal = document.getElementById('codeModal');
  const accessCodeInput = document.getElementById('accessCode');
  const verifyBtn = document.getElementById('verifyCode');
  const codeError = document.getElementById('codeError');
  const closeModal = document.querySelector('.close-modal');

  // Mostrar modal al click en el link (🔒)
  adminLink.addEventListener('click', function(e) {
      e.preventDefault();
      codeModal.style.display = 'block';
      accessCodeInput.focus();
  });

  // Cerrar modal
  closeModal.addEventListener('click', function() {
      codeModal.style.display = 'none';
  });

  // Verificar código
  verifyBtn.addEventListener('click', function() {
      const codigo = accessCodeInput.value.trim();

      fetch('includes/verificar_codigo.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: 'codigo=' + encodeURIComponent(codigo)
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              window.location.href = 'admin/login.php'; // Redirige a login
          } else {
              codeError.textContent = data.message || 'Código incorrecto';
              codeError.style.display = 'block';
          }
      })
      .catch(error => {
          console.error('Error:', error);
          codeError.textContent = 'Error al verificar';
          codeError.style.display = 'block';
      });
  });

  // Cerrar modal al hacer clic fuera
  window.addEventListener('click', function(e) {
      if (e.target === codeModal) {
          codeModal.style.display = 'none';
      }
  });
});