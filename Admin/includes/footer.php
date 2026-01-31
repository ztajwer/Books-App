<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
(function () {
  const body = document.body;
  const toggle = document.getElementById('themeToggle');
  const themeIcon = document.getElementById('themeIcon');
  const themeText = document.getElementById('themeText');

  // Load saved theme or default
  const saved = localStorage.getItem('eb_theme') || 'dark';
  applyTheme(saved);

  toggle.addEventListener('click', () => {
    const next = body.classList.contains('light-mode') ? 'dark' : 'light';
    applyTheme(next);
    localStorage.setItem('eb_theme', next);
  });

  function applyTheme(theme) {
    if(theme === 'light') {
      body.classList.add('light-mode');
      body.classList.remove('dark-mode');
      themeIcon.className = 'bi bi-sun-fill';
      themeText.innerText = 'Light';
      toggle.classList.replace('btn-dark','btn-light');
    } else {
      body.classList.add('dark-mode');
      body.classList.remove('light-mode');
      themeIcon.className = 'bi bi-moon-fill';
      themeText.innerText = 'Dark';
      toggle.classList.replace('btn-light','btn-dark');
    }
  }
})();
</script>

  <!-- JS -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

  <script>
    
    $(document).ready(function () {
      $('#ebookTable').DataTable({
        responsive: true,
        paging: true,
        searching: true,
        ordering: true,
        lengthMenu: [5, 10, 25, 50, 100],
        pageLength: 10,
        dom: 'Bfrtip',
        buttons: [
          { extend: 'copy', className: 'btn btn-light btn-sm' },
          { extend: 'excel', className: 'btn btn-light  btn-sm' },
          { extend: 'csv', className: 'btn btn-light  btn-sm' },
          { extend: 'pdf', className: 'btn btn-light  btn-sm' },
          { extend: 'print', className: 'btn btn-light  btn-sm' }
        ]
      });
    });

  </script>

</body>
</html>
