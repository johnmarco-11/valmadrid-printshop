document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('[data-auto-submit]').forEach(function (el) {
    el.addEventListener('change', function () { el.closest('form').submit(); });
  });
  document.querySelectorAll('.image-input').forEach(function (input) {
    input.addEventListener('change', function () {
      const preview = document.querySelector(input.dataset.preview);
      if (preview && input.files[0]) preview.src = URL.createObjectURL(input.files[0]);
    });
  });
  document.querySelectorAll('[data-print]').forEach(function (btn) { btn.addEventListener('click', () => window.print()); });
});