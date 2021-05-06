
// prevenir evento submit si los campos son invalidos
(function () {
  'use strict';
  window.addEventListener('load', function () {
    // Buscar todos los formularios que queremos aplicar estilos de validación de bootstrap personalizados a
    
    var forms = document.getElementsByClassName('needs-validation');

    // Bucle sobre ellos y evitar la presentación
    var validation = Array.prototype.filter.call(forms, function (form) {
      form.addEventListener('submit', function (event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
