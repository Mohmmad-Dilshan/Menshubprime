<?php
// admin_footer.php
?>
  </main>

  <script>
    // Modern Admin Helper Scripts
    document.addEventListener("DOMContentLoaded", function() {
      // Auto-hide alert messages
      const alerts = document.querySelectorAll('.alert');
      alerts.forEach(alert => {
        setTimeout(() => {
          alert.style.opacity = '0';
          setTimeout(() => alert.remove(), 500);
        }, 3000);
      });
    });
  </script>
</body>
</html>
<?php ob_end_flush(); ?>
