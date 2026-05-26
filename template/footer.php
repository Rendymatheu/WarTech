</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
</aside>

<!-- Main Footer -->
<footer class="main-footer beach-footer">
  <style>
    .beach-footer {
      background: linear-gradient(90deg, #00a884, #00bcd4) !important;
      color: #e0f7fa !important;
      border-top: none !important;
      box-shadow: 0 -4px 18px rgba(0, 168, 132, .18);
      font-weight: 500;
      letter-spacing: 0.2px;
    }
    .beach-footer a { color: #ffffff !important; font-weight: 700; text-decoration: none; }
    .beach-footer a:hover { color: #b2ebf2 !important; }
    .beach-footer .text-info { color: #ffffff !important; font-weight: 800; }
    .beach-footer .beach-version {
      background: rgba(255,255,255,.18);
      border-radius: 8px;
      padding: 2px 10px;
      font-weight: 700;
      font-size: 0.85rem;
      color: #ffffff;
      letter-spacing: 0.5px;
    }
    .beach-footer .beach-wave-icon { font-size: 1rem; margin-right: 6px; opacity: 0.8; }

    body.dark-mode .beach-footer {
      background: linear-gradient(90deg, #005f4e, #006a7a) !important;
      color: #90E0EF !important;
      box-shadow: 0 -4px 18px rgba(0,0,0,.3) !important;
    }
    body.dark-mode .beach-footer .text-info { color: #48CAE4 !important; }
    body.dark-mode .beach-footer .beach-version {
      background: rgba(72, 202, 228, .15) !important;
      color: #48CAE4 !important;
    }
  </style>

  <i class="fas fa-water beach-wave-icon"></i>
  <strong>Copyright &copy; 2026 <span class="text-info">Kelompok 6</span></strong>
  &mdash; All rights reserved.
  <div class="float-right d-none d-sm-inline-block">
    <span class="beach-version"><b>Version</b> 1.0</span>
  </div>
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/dist/js/adminlte.js"></script>
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/chart.js/Chart.min.js"></script>

<script>
$(function () {

    // ── 1. DARK MODE — restore dari sessionStorage ──
    if (sessionStorage.getItem('tema') === 'dark-mode') {
        $('body').addClass('dark-mode');
        $('#cekDark').prop('checked', true);
    }

    $('#cekDark').on('change', function(e) {
        e.stopPropagation();
        if ($(this).is(':checked')) {
            $('body').addClass('dark-mode');
            sessionStorage.setItem('tema', 'dark-mode');
        } else {
            $('body').removeClass('dark-mode');
            sessionStorage.removeItem('tema');
        }
    });

    $('#cekDark, label[for="cekDark"]').on('click', function(e) {
        e.stopPropagation();
    });

    // ── 2. SIDEBAR COLLAPSE — restore dari sessionStorage ──
    if (sessionStorage.getItem('sidebarCollapsed') === 'true') {
        $('body').addClass('sidebar-collapse');
    }

    // Simpan state pakai event resmi AdminLTE
    $(document).on('collapsed.lte.pushmenu', function () {
        sessionStorage.setItem('sidebarCollapsed', 'true');
    });

    $(document).on('shown.lte.pushmenu', function () {
        sessionStorage.removeItem('sidebarCollapsed');
    });

    // ── 3. DataTable ──
    if ($('#tblData').length) {
        $("#tblData").DataTable();
    }

});
</script>

</body>
</html>