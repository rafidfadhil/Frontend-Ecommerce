<!-- Plugin for charts -->
<script src="{{ asset('assets/js/plugins/chartjs.min.js') }}" async></script>
<!-- Plugin for scrollbar -->
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}" async></script>
<!-- Main script file -->
<script src="{{ asset('assets/js/argon-dashboard-tailwind.js?v=1.0.1') }}" async></script>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
      const closeButton = document.querySelector('.alert-close');
  
      if (closeButton) {
          closeButton.addEventListener('click', function() {
              const alertBox = document.getElementById('alertBox');
              if (alertBox) {
                  alertBox.style.display = 'none';
              }
          });
      }
  });
</script>
