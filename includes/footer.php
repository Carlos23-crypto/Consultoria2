<footer class="footer">
  <p>&copy; <?= date('Y') ?> GQ Services. Todos los derechos reservados. 
    <a href="#" id="adminAccessLink" style="color: transparent; font-size: 0.8em;">🔒</a>
  </p>

  <!-- Modal de Código de Acceso -->
  <div id="codeModal" class="modal">
    <div class="modal-content">
      <span class="close-modal">&times;</span>
      <h3>Acceso Administrativo</h3>
      <div class="code-input-container">
        <input type="password" id="accessCode" placeholder="Ingrese código de acceso">
        <button id="verifyCode" type="button">Verificar</button>
      </div>
      <p id="codeError" style="color: red; display: none;">Código incorrecto</p>
    </div>
  </div>
</footer>

<script src="assets/js/admin-access.js"></script>
