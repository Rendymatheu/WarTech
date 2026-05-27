<?php

session_save_path('/tmp');
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

$id        = $_GET['id'];
$tgl       = $_GET['tgl'];
$penjualan = getData("SELECT * FROM tbl_jual_detail WHERE no_jual = '$id'");

?>

<div class="content-wrapper beach-penjualan-page">

    <style>
        /* BEACH THEME - DETAIL PENJUALAN  */
        .beach-penjualan-page {
            background:
                radial-gradient(circle at top right, rgba(63, 81, 181, .14), transparent 40%),
                radial-gradient(circle at bottom left, rgba(156, 39, 176, .10), transparent 40%),
                linear-gradient(135deg, #e8eaf6 0%, #f3e5f5 100%);
            min-height: 100vh;
        }

        /* ---- Header Title ---- */
        .beach-title-box {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .beach-icon {
            width: 62px;
            height: 62px;
            border-radius: 20px;
            background: linear-gradient(135deg, #3949ab, #8e24aa);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            box-shadow: 0 12px 28px rgba(57, 73, 171, .30);
            flex-shrink: 0;
        }

        .beach-title-box h1 {
            margin: 0;
            font-weight: 800;
            color: #1a237e;
        }

        .beach-title-box p {
            margin: 4px 0 0;
            color: #6c757d;
            font-size: 14px;
        }

        /* ---- Breadcrumb ---- */
        .beach-breadcrumb {
            background: rgba(255, 255, 255, .80);
            padding: 10px 18px;
            border-radius: 14px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .05);
        }
        .beach-breadcrumb a       { color: #3949ab; }
        .beach-breadcrumb .active { color: #7b1fa2; }

        /* ---- Card ---- */
        .beach-card {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .09);
            background: rgba(255, 255, 255, .94);
        }

        .beach-card .card-header {
            background: linear-gradient(90deg, #3949ab, #7b1fa2);
            color: #fff;
            padding: 20px 26px;
            border-bottom: none;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        .beach-card .card-title {
            font-weight: 700;
            font-size: 17px;
            margin: 0;
            flex: 1;
        }

        /* ---- Badge pills ---- */
        .beach-badge {
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 13px;
            padding: 7px 14px;
            box-shadow: 0 6px 16px rgba(0,0,0,.15);
        }
        .beach-badge-id {
            background: #ffffff;
            color: #1a237e;
        }
        .beach-badge-tgl {
            background: rgba(255,255,255,.22);
            color: #ffffff;
            border: 2px solid rgba(255,255,255,.50);
        }

        /* ---- Table ---- */
        .beach-table {
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .beach-table thead th {
            background: #f3f0ff;
            color: #3949ab;
            border: none;
            font-weight: 800;
            padding: 14px 16px;
        }
        .beach-table thead th:first-child { border-radius: 12px 0 0 12px; }
        .beach-table thead th:last-child  { border-radius: 0 12px 12px 0; }

        .beach-table tbody tr {
            background: #ffffff;
            box-shadow: 0 6px 16px rgba(0,0,0,.05);
            transition: transform .15s, box-shadow .15s;
        }
        .beach-table tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(0,0,0,.10);
        }

        .beach-table tbody td {
            border-top: none;
            vertical-align: middle;
            padding: 15px 16px;
        }
        .beach-table tbody tr td:first-child { border-radius: 14px 0 0 14px; }
        .beach-table tbody tr td:last-child  { border-radius: 0 14px 14px 0; }

        /* ---- Barcode pill ---- */
        .barcode-pill {
            background: #ede7f6;
            color: #4527a0;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-family: monospace;
        }

        /* ---- Total row ---- */
        .total-row td {
            background: linear-gradient(90deg, #ede7f6, #f3e5f5) !important;
            font-weight: 800;
            color: #1a237e !important;
            border-top: 2px solid #b39ddb !important;
            box-shadow: none !important;
        }
        .total-row:hover { transform: none !important; }
        .total-row td:first-child { border-radius: 14px 0 0 14px; }
        .total-row td:last-child  { border-radius: 0 14px 14px 0; }

        /* DARK MODE OVERRIDES */
        body.dark-mode .beach-penjualan-page {
            background:
                radial-gradient(circle at top right, rgba(40, 50, 120, .25), transparent 40%),
                linear-gradient(135deg, #0d0e1f 0%, #1a0e2e 100%) !important;
        }

        body.dark-mode .beach-title-box h1  { color: #9fa8da !important; }
        body.dark-mode .beach-title-box p   { color: #90a4ae !important; }

        body.dark-mode .beach-breadcrumb {
            background: rgba(20, 20, 50, 0.85) !important;
        }
        body.dark-mode .beach-breadcrumb a       { color: #9fa8da !important; }
        body.dark-mode .beach-breadcrumb .active { color: #ce93d8 !important; }

        body.dark-mode .beach-card {
            background: rgba(18, 18, 40, 0.95) !important;
            box-shadow: 0 15px 40px rgba(0,0,0,.50) !important;
        }

        body.dark-mode .beach-card .card-header {
            background: linear-gradient(90deg, #1a237e, #4a148c) !important;
        }

        body.dark-mode .beach-badge-id {
            background: #1a1a40 !important;
            color: #9fa8da !important;
        }

        body.dark-mode .beach-table thead th {
            background: #16163a !important;
            color: #9fa8da !important;
        }

        body.dark-mode .beach-table tbody tr {
            background: #1c1c3a !important;
            box-shadow: 0 6px 16px rgba(0,0,0,.30) !important;
        }

        body.dark-mode .beach-table tbody td {
            color: #c5cae9 !important;
        }

        body.dark-mode .beach-table tbody tr:hover td {
            background: #242450 !important;
        }

        body.dark-mode .barcode-pill {
            background: #1a1040 !important;
            color: #b39ddb !important;
        }

        body.dark-mode .total-row td {
            background: linear-gradient(90deg, #1a1040, #200d30) !important;
            color: #9fa8da !important;
            border-top-color: #4527a0 !important;
        }
    </style>

    <!-- ===== Content Header ===== -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <div class="beach-title-box">
                        <div class="beach-icon">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div>
                            <h1>Detail Penjualan</h1>
                            <p>Rincian item barang dalam transaksi penjualan</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right beach-breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= $main_url ?>dashboard.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= $main_url ?>laporan-penjualan">Penjualan</a>
                        </li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== Main Content ===== -->
    <section class="content">
        <div class="container-fluid">
            <div class="card beach-card">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list-alt mr-2"></i> Rincian Barang
                    </h3>
                    <span class="beach-badge beach-badge-tgl">
                        <i class="fas fa-calendar-alt mr-1"></i> <?= $tgl ?>
                    </span>
                    <span class="beach-badge beach-badge-id">
                        <i class="fas fa-hashtag mr-1"></i> <?= $id ?>
                    </span>
                </div>

                <div class="card-body table-responsive p-4">
                    <table class="table text-nowrap beach-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Barcode</th>
                                <th>Nama Barang</th>
                                <th class="text-right">Harga Jual</th>
                                <th class="text-center">Qty</th>
                                <th class="text-right">Jumlah Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $grand_total = 0;
                            foreach ($penjualan as $jual):
                                $grand_total += $jual['jml_harga'];
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><span class="barcode-pill"><?= $jual['barcode'] ?></span></td>
                                    <td><strong><?= $jual['nama_brg'] ?></strong></td>
                                    <td class="text-right">Rp <?= number_format($jual['harga_jual'], 0, ',', '.') ?></td>
                                    <td class="text-center"><strong><?= $jual['qty'] ?></strong></td>
                                    <td class="text-right">Rp <?= number_format($jual['jml_harga'], 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>

                            <!-- Total Row -->
                            <tr class="total-row">
                                <td colspan="4"></td>
                                <td class="text-center"><strong>TOTAL</strong></td>
                                <td class="text-right">
                                    <strong>Rp <?= number_format($grand_total, 0, ',', '.') ?></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>

<!-- /.content-wrapper -->

<?php require "../template/footer.php"; ?>
</div>
