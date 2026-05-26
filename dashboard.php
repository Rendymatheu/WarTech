<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: auth/login.php");
    exit();
}

require "config/config.php";
require "config/functions.php";

$title = "Dashboard";
require "template/header.php";
require "template/navbar.php";
require "template/sidebar.php";

$users = getData("SELECT * FROM tbl_user");
$userNum = count($users);

$suppliers = getData("SELECT * FROM tbl_supplier");
$supplierNum = count($suppliers);

$customers = getData("SELECT * FROM tbl_customer");
$customerNum = count($customers);

$barang = getData("SELECT * FROM tbl_barang");
$brgNum = count($barang);

?>

<style>
  /* ===== BEACH THEME OVERRIDE ===== */
  @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap');

  .content-wrapper {
    background: linear-gradient(135deg, #e0f7fa 0%, #e8f5e9 50%, #fff9e6 100%);
    font-family: 'Nunito', sans-serif;
    min-height: 100vh;
  }

  /* ===== WELCOME BANNER ===== */
  .beach-banner {
    background: linear-gradient(135deg, #0077B6 0%, #00B4D8 60%, #48CAE4 100%);
    border-radius: 20px;
    padding: 28px 32px;
    color: #fff;
    position: relative;
    overflow: hidden;
    margin-bottom: 24px;
    box-shadow: 0 8px 32px rgba(0, 180, 216, 0.3);
  }
  .beach-banner::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 200px; height: 200px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
  }
  .beach-banner::after {
    content: '';
    position: absolute;
    bottom: -60px; right: 80px;
    width: 280px; height: 280px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
  }
  .beach-banner h2 {
    font-size: 1.8rem;
    font-weight: 800;
    margin: 0 0 6px;
  }
  .beach-banner p {
    margin: 0;
    opacity: 0.85;
    font-size: 0.95rem;
  }
  .beach-banner .wave-icon {
    position: absolute;
    right: 32px; top: 50%;
    transform: translateY(-50%);
    font-size: 5rem;
    opacity: 0.18;
  }

  /* ===== STAT BOXES ===== */
  .beach-stat-card {
    border-radius: 18px;
    padding: 22px 20px;
    color: #fff;
    position: relative;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    transition: transform 0.2s, box-shadow 0.2s;
    display: block;
    text-decoration: none;
    margin-bottom: 20px;
  }
  .beach-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.18);
    color: #fff;
  }
  .beach-stat-card .card-bg-icon {
    position: absolute;
    right: -10px; bottom: -10px;
    font-size: 5rem;
    opacity: 0.15;
  }
  .beach-stat-card .stat-label {
    font-size: 0.82rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.85;
    margin-bottom: 4px;
  }
  .beach-stat-card .stat-number {
    font-size: 2.6rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 12px;
  }
  .beach-stat-card .stat-footer {
    font-size: 0.8rem;
    opacity: 0.8;
    border-top: 1px solid rgba(255,255,255,0.25);
    padding-top: 10px;
    margin-top: 4px;
  }

  /* Box Colors */
  .card-users    { background: linear-gradient(135deg, #FF8C00, #FFA940); }
  .card-supplier { background: linear-gradient(135deg, #0096C7, #00B4D8); }
  .card-customer { background: linear-gradient(135deg, #E63946, #FF6B6B); }
  .card-barang   { background: linear-gradient(135deg, #D4AC0D, #F4D03F); color: #333; }
  .card-barang:hover { color: #333; }
  .card-barang .stat-footer { border-top-color: rgba(0,0,0,0.15); }

  /* ===== INFO CARDS (Stock & Omzet) ===== */
  .beach-card {
    border-radius: 18px;
    background: #fff;
    box-shadow: 0 4px 20px rgba(0, 150, 199, 0.10);
    border: none;
    overflow: hidden;
    margin-bottom: 24px;
  }
  .beach-card .beach-card-header {
    background: linear-gradient(90deg, #0096C7, #48CAE4);
    color: #fff;
    padding: 14px 20px;
    font-weight: 700;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .beach-card .beach-card-header a {
    color: rgba(255,255,255,0.85);
    font-size: 1rem;
  }
  .beach-card .beach-card-header a:hover { color: #fff; }

  .beach-card table { margin: 0; }
  .beach-card table td {
    padding: 12px 20px;
    border-bottom: 1px solid #f0f9fc;
    font-size: 0.88rem;
  }
  .beach-card table tr:last-child td { border-bottom: none; }
  .beach-card table tr:hover td { background: #f0f9fc; }

  /* Omzet card */
  .omzet-card .beach-card-header {
    background: linear-gradient(90deg, #27AE60, #2ECC71);
  }
  .omzet-value {
    padding: 28px 24px;
    font-size: 2.2rem;
    font-weight: 800;
    color: #0096C7;
  }
  .omzet-value span { font-size: 1rem; font-weight: 600; color: #48CAE4; }

  /* ===== PAGE TITLE ===== */
  .beach-page-title {
    font-weight: 800;
    font-size: 1.5rem;
    color: #0077B6;
    margin-bottom: 4px;
  }
  .breadcrumb { background: transparent; padding: 0; }
  .breadcrumb-item a { color: #00B4D8; }
  .breadcrumb-item.active { color: #0077B6; }
  .breadcrumb-item + .breadcrumb-item::before { color: #90E0EF; }

  /* ===== EMPTY STATE ===== */
  .empty-stock {
    padding: 24px;
    text-align: center;
    color: #b0c4cb;
    font-size: 0.9rem;
  }

  /* ============================================================
     DARK MODE OVERRIDES
     Semua override dark mode pakai !important supaya bisa
     mengalahkan style default di atas
  ============================================================ */
  body.dark-mode .content-wrapper {
    background: linear-gradient(135deg, #0d1b2a 0%, #1b2838 50%, #1a1a2e 100%) !important;
  }

  body.dark-mode .beach-page-title {
    color: #48CAE4 !important;
  }

  body.dark-mode .breadcrumb-item a {
    color: #48CAE4 !important;
  }

  body.dark-mode .breadcrumb-item.active {
    color: #90E0EF !important;
  }

  body.dark-mode .breadcrumb-item + .breadcrumb-item::before {
    color: #4a6278 !important;
  }

  /* Banner tetap sama di dark mode (sudah gelap) */
  body.dark-mode .beach-banner {
    background: linear-gradient(135deg, #023e58 0%, #0077B6 60%, #0096C7 100%) !important;
    box-shadow: 0 8px 32px rgba(0, 119, 182, 0.4) !important;
  }

  /* Stat cards — warnanya sedikit digelapkan */
  body.dark-mode .card-users {
    background: linear-gradient(135deg, #b85c00, #cc6f00) !important;
  }
  body.dark-mode .card-supplier {
    background: linear-gradient(135deg, #005f7a, #0077B6) !important;
  }
  body.dark-mode .card-customer {
    background: linear-gradient(135deg, #a01e29, #c0392b) !important;
  }
  body.dark-mode .card-barang {
    background: linear-gradient(135deg, #8a6d00, #b8860b) !important;
    color: #f5f5f5 !important;
  }
  body.dark-mode .card-barang:hover {
    color: #f5f5f5 !important;
  }

  /* Info cards */
  body.dark-mode .beach-card {
    background: #1e2d3d !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4) !important;
  }

  body.dark-mode .beach-card table td {
    color: #cce7f0 !important;
    border-bottom-color: #2a3f52 !important;
  }

  body.dark-mode .beach-card table tr:hover td {
    background: #253545 !important;
  }

  body.dark-mode .omzet-value {
    color: #48CAE4 !important;
  }

  body.dark-mode .omzet-value span {
    color: #90E0EF !important;
  }

  body.dark-mode .empty-stock {
    color: #4a6278 !important;
  }
</style>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center">
        <div class="col-sm-6">
          <h1 class="beach-page-title m-0">Dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">

      <!-- Welcome Banner -->
      <div class="beach-banner">
        <div class="wave-icon">🌊</div>
        <h2>Selamat Datang, <?= htmlspecialchars(userLogin()['username']) ?>!</h2>
        <p>Semoga harimu menyenangkan seperti angin sepoi di tepi pantai 🌴</p>
      </div>

      <!-- Stat Boxes -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <a href="<?= $main_url ?>user" class="beach-stat-card card-users">
            <div class="stat-label">Users</div>
            <div class="stat-number"><?= $userNum ?></div>
            <div class="stat-footer">More info &rarr;</div>
            <div class="card-bg-icon"><i class="fas fa-users"></i></div>
          </a>
        </div>
        <div class="col-lg-3 col-6">
          <a href="<?= $main_url ?>supplier" class="beach-stat-card card-supplier">
            <div class="stat-label">Supplier</div>
            <div class="stat-number"><?= $supplierNum ?></div>
            <div class="stat-footer">More info &rarr;</div>
            <div class="card-bg-icon"><i class="fas fa-truck"></i></div>
          </a>
        </div>
        <div class="col-lg-3 col-6">
          <a href="<?= $main_url ?>customer" class="beach-stat-card card-customer">
            <div class="stat-label">Customer</div>
            <div class="stat-number"><?= $customerNum ?></div>
            <div class="stat-footer">More info &rarr;</div>
            <div class="card-bg-icon"><i class="fas fa-user-friends"></i></div>
          </a>
        </div>
        <div class="col-lg-3 col-6">
          <a href="<?= $main_url ?>barang" class="beach-stat-card card-barang">
            <div class="stat-label">Item Barang</div>
            <div class="stat-number"><?= $brgNum ?></div>
            <div class="stat-footer">More info &rarr;</div>
            <div class="card-bg-icon"><i class="fas fa-boxes"></i></div>
          </a>
        </div>
      </div>

      <!-- Info Stock & Omzet -->
      <div class="row">
        <div class="col-lg-6">
          <div class="beach-card">
            <div class="beach-card-header">
              <span><i class="fas fa-exclamation-circle mr-2"></i>Info Stock Barang</span>
              <a href="<?= $main_url ?>stock" title="Laporan Stock"><i class="fas fa-arrow-right"></i></a>
            </div>
            <table class="table mb-0">
              <tbody>
                <?php 
                  $stockMin = getData("SELECT * FROM tbl_barang WHERE stock < stock_minimal");
                  if (count($stockMin) > 0):
                    foreach($stockMin as $min): ?>
                    <tr>
                      <td><?= htmlspecialchars($min['nama_barang']) ?></td>
                      <td class="text-danger font-weight-bold">
                        <i class="fas fa-exclamation-triangle mr-1"></i>Stock Kurang
                      </td>
                    </tr>
                  <?php endforeach;
                  else: ?>
                    <tr><td colspan="2" class="empty-stock">✅ Semua stok aman</td></tr>
                  <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="beach-card omzet-card">
            <div class="beach-card-header">
              <span><i class="fas fa-chart-line mr-2"></i>Omzet Penjualan</span>
            </div>
            <div class="omzet-value">
              <span>Rp </span><?= omzet() ?>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <!-- /.content -->

  <?php require "template/footer.php"; ?>
</div>