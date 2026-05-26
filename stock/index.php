<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/mode-barang.php";

$title = "Laporan";
require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

$stockBrg = getData("SELECT * FROM tbl_barang");

?>

<div class="content-wrapper beach-page">

    <style>
        /* ===== BEACH THEME - LAPORAN STOCK ===== */
        .beach-page {
            background:
                radial-gradient(circle at top left, rgba(0, 188, 212, .18), transparent 35%),
                linear-gradient(135deg, #e0f7fa 0%, #fdf6e3 100%);
            min-height: 100vh;
        }

        .beach-title-box {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .beach-icon {
            width: 62px;
            height: 62px;
            border-radius: 20px;
            background: linear-gradient(135deg, #00bcd4, #00a884);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            box-shadow: 0 12px 28px rgba(0, 168, 132, .25);
        }

        .beach-title-box h1 {
            margin: 0;
            font-weight: 800;
            color: #0077b6;
        }

        .beach-title-box p {
            margin: 4px 0 0;
            color: #6c757d;
        }

        .beach-breadcrumb {
            background: rgba(255,255,255,.75);
            padding: 10px 16px;
            border-radius: 14px;
            box-shadow: 0 8px 20px rgba(0,0,0,.05);
        }

        .beach-card {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,.08);
            background: rgba(255,255,255,.92);
        }

        .beach-card .card-header {
            background: linear-gradient(90deg, #00a884, #00bcd4);
            color: #fff;
            padding: 20px 24px;
            border-bottom: none;
        }

        .beach-card .card-title {
            font-weight: 700;
            font-size: 18px;
        }

        .btn-cetak-beach {
            background: #ffffff;
            color: #00a884;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            padding: 8px 15px;
            box-shadow: 0 8px 18px rgba(0,0,0,.12);
        }

        .btn-cetak-beach:hover {
            background: #e8fff8;
            color: #00796b;
        }

        .beach-table {
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .beach-table thead th {
            background: #f1fbfc;
            color: #0077b6;
            border: none;
            font-weight: 800;
        }

        .beach-table tbody tr {
            background: #ffffff;
            box-shadow: 0 8px 18px rgba(0,0,0,.04);
        }

        .beach-table tbody td {
            border-top: none;
            vertical-align: middle;
            padding: 16px 14px;
        }

        .beach-table tbody tr td:first-child {
            border-radius: 14px 0 0 14px;
        }

        .beach-table tbody tr td:last-child {
            border-radius: 0 14px 14px 0;
        }

        /* Badge status stock */
        .badge-stock-ok {
            background: #e8fff8;
            color: #00796b;
            border: 1.5px solid #b2dfdb;
            border-radius: 20px;
            padding: 4px 14px;
            font-size: 0.82rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .badge-stock-kurang {
            background: #fff0f0;
            color: #c62828;
            border: 1.5px solid #ffcdd2;
            border-radius: 20px;
            padding: 4px 14px;
            font-size: 0.82rem;
            font-weight: 700;
            white-space: nowrap;
        }

        /* ============================================================
           DARK MODE OVERRIDES
        ============================================================ */
        body.dark-mode .beach-page {
            background:
                radial-gradient(circle at top left, rgba(0, 100, 130, .25), transparent 35%),
                linear-gradient(135deg, #0d1b2a 0%, #1a1a2e 100%) !important;
        }

        body.dark-mode .beach-title-box h1 {
            color: #48CAE4 !important;
        }

        body.dark-mode .beach-title-box p {
            color: #90a4ae !important;
        }

        body.dark-mode .beach-breadcrumb {
            background: rgba(30, 45, 61, 0.85) !important;
            box-shadow: 0 8px 20px rgba(0,0,0,.3) !important;
        }

        body.dark-mode .beach-breadcrumb .breadcrumb-item a {
            color: #48CAE4 !important;
        }

        body.dark-mode .beach-breadcrumb .breadcrumb-item.active {
            color: #90E0EF !important;
        }

        body.dark-mode .beach-card {
            background: rgba(30, 45, 61, 0.95) !important;
            box-shadow: 0 15px 35px rgba(0,0,0,.35) !important;
        }

        body.dark-mode .beach-card .card-header {
            background: linear-gradient(90deg, #005f4e, #006a7a) !important;
        }

        body.dark-mode .beach-table thead th {
            background: #1a2e3d !important;
            color: #48CAE4 !important;
        }

        body.dark-mode .beach-table tbody tr {
            background: #1e2d3d !important;
            box-shadow: 0 8px 18px rgba(0,0,0,.2) !important;
        }

        body.dark-mode .beach-table tbody td {
            color: #cce7f0 !important;
        }

        body.dark-mode .beach-table tbody tr:hover td {
            background: #253545 !important;
        }

        body.dark-mode .btn-cetak-beach {
            background: #1e3a4a !important;
            color: #48CAE4 !important;
        }

        body.dark-mode .btn-cetak-beach:hover {
            background: #253f52 !important;
            color: #90E0EF !important;
        }

        body.dark-mode .badge-stock-ok {
            background: rgba(0, 121, 107, 0.2) !important;
            color: #80cbc4 !important;
            border-color: rgba(0, 121, 107, 0.4) !important;
        }

        body.dark-mode .badge-stock-kurang {
            background: rgba(198, 40, 40, 0.2) !important;
            color: #ef9a9a !important;
            border-color: rgba(198, 40, 40, 0.4) !important;
        }
    </style>

    <div class="content-header">
        <div class="container-fluid px-3">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <div class="beach-title-box">
                        <div class="beach-icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div>
                            <h1>Laporan Stock</h1>
                            <p>Rekap data stock barang dengan tampilan pantai yang lebih santai</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right beach-breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= $main_url ?>dashboard.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Laporan Stock</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid px-3">
            <div class="card beach-card mb-0">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-layer-group mr-2"></i> Data Stock Barang
                    </h3>
                    <a href="<?= $main_url ?>report/r-stock.php"
                       class="btn btn-sm btn-cetak-beach float-right" target="_blank">
                        <i class="fas fa-print"></i> Cetak
                    </a>
                </div>

                <div class="card-body table-responsive p-4">
                    <table class="table table-hover text-nowrap beach-table" id="tblData">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th class="text-center">Jumlah Stock</th>
                                <th class="text-center">Stock Minimal</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($stockBrg as $stock): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($stock['id_barang']) ?></td>
                                    <td><?= htmlspecialchars($stock['nama_barang']) ?></td>
                                    <td><?= htmlspecialchars($stock['satuan']) ?></td>
                                    <td class="text-center"><?= $stock['stock'] ?></td>
                                    <td class="text-center"><?= $stock['stock_minimal'] ?></td>
                                    <td class="text-center">
                                        <?php if ($stock['stock'] < $stock['stock_minimal']): ?>
                                            <span class="badge-stock-kurang">
                                                <i class="fas fa-exclamation-circle mr-1"></i> Stock Kurang
                                            </span>
                                        <?php else: ?>
                                            <span class="badge-stock-ok">
                                                <i class="fas fa-check-circle mr-1"></i> Stock Cukup
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>

<?php require "../template/footer.php"; ?>

</div>