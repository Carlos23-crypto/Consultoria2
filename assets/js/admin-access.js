document.addEventListener('DOMContentLoaded', function() {
    const adminLink = document.getElementById('adminAccessLink');
    const codeModal = document.getElementById('codeModal');
    const accessCodeInput = document.getElementById('accessCode');
    const verifyBtn = document.getElementById('verifyCode');
    const codeError = document.getElementById('codeError');
    const closeModal = document.querySelector('.close-modal');

    // Mostrar modal al hacer clic en el icono de candado
    adminLink.addEventListener('click', function(e) {
        e.preventDefault();
        codeModal.style.display = 'block';
        accessCodeInput.focus();
        codeError.style.display = 'none'; // Resetear mensajes de error
    });

    // Cerrar modal
    closeModal.addEventListener('click', function() {
        codeModal.style.display = 'none';
    });

    // Verificar código de acceso
    verifyBtn.addEventListener('click', function() {
        const codigo = accessCodeInput.value.trim();
        
        // Validación básica del lado del cliente
        if (!codigo) {
            codeError.textContent = 'Por favor ingresa un código';
            codeError.style.display = 'block';
            return;
        }

        // Mostrar estado de carga
        verifyBtn.disabled = true;
        verifyBtn.textContent = 'Verificando...';
        
        fetch('includes/verificar_codigo.php', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'codigo=' + encodeURIComponent(codigo)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la red');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Redirigir al formulario de login
                window.location.href = data.redirect;
            } else {
                codeError.textContent = data.message || 'Código incorrecto';
                codeError.style.display = 'block';
                accessCodeInput.focus();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            codeError.textContent = 'Error al conectar con el servidor';
            codeError.style.display = 'block';
        })
        .finally(() => {
            verifyBtn.disabled = false;
            verifyBtn.textContent = 'Verificar';
        });
    });

    // Cerrar modal al hacer clic fuera del contenido
    window.addEventListener('click', function(e) {
        if (e.target === codeModal) {
            codeModal.style.display = 'none';
        }
    });

    // Cerrar modal con tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && codeModal.style.display === 'block') {
            codeModal.style.display = 'none';
        }
    });
});