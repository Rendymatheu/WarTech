<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/mode-supplier.php";

$title = "Data Supplier";
require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
} else {
    $msg = '';
}

$alert = '';

if ($msg == 'deleted') {
    $alert = '<div class="alert alert-success alert-dismissible beach-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> Alert!</h5>
                Supplier berhasil dihapus..
              </div>';
}

if ($msg == 'updated') {
    $alert = '<div class="alert alert-success alert-dismissible beach-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check-circle"></i> Alert!</h5>
                Supplier berhasil diperbarui..
              </div>';
}

if ($msg == 'aborted') {
    $alert = '<div class="alert alert-danger alert-dismissible beach-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                Supplier gagal dihapus..
              </div>';
}

?>

<div class="content-wrapper beach-page">

    <style>
        /* ===== BEACH THEME - SUPPLIER ===== */
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

        .btn-add-beach {
            background: #ffffff;
            color: #00a884;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            padding: 8px 15px;
            box-shadow: 0 8px 18px rgba(0,0,0,.12);
        }

        .btn-add-beach:hover {
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

        .btn-edit-beach {
            background: #ffc107;
            border: none;
            border-radius: 10px;
            color: #1f2d3d;
            padding: 7px 11px;
        }

        .btn-delete-beach {
            border-radius: 10px;
            padding: 7px 11px;
        }

        .beach-alert {
            margin: 20px 20px 0;
            border-radius: 16px;
            border: none;
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

        body.dark-mode .btn-add-beach {
            background: #1e3a4a !important;
            color: #48CAE4 !important;
        }

        body.dark-mode .btn-add-beach:hover {
            background: #253f52 !important;
            color: #90E0EF !important;
        }

        body.dark-mode .beach-alert {
            background: rgba(30, 45, 61, 0.95) !important;
            color: #cce7f0 !important;
        }
    </style>

    <div class="content-header">
        <div class="container-fluid px-3">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <div class="beach-title-box">
                        <div class="beach-icon">
                            <i class="fas fa-truck-loading"></i>
                        </div>
                        <div>
                            <h1>Supplier</h1>
                            <p>Kelola data supplier dengan tampilan pantai yang lebih santai</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right beach-breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= $main_url ?>dashboard.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Data Supplier</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid px-3">
            <div class="card beach-card mb-0">

                <?php if ($alert != '') { echo $alert; } ?>

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-water mr-2"></i> Data Supplier
                    </h3>
                    <a href="<?= $main_url ?>supplier/add-supplier.php"
                        class="btn btn-sm btn-add-beach float-right">
                        <i class="fas fa-plus fa-sm"></i> Add Supplier
                    </a>
                </div>

                <div class="card-body table-responsive px-4 py-3">
                    <table class="table table-hover text-nowrap beach-table" id="tblData">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Telpon</th>
                                <th>Alamat</th>
                                <th>Deskripsi</th>
                                <th style="width: 10%;">Operasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $suppliers = getData("SELECT * FROM tbl_supplier");
                            foreach ($suppliers as $supplier): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $supplier['nama'] ?></td>
                                    <td><?= $supplier['telpon'] ?></td>
                                    <td><?= $supplier['alamat'] ?></td>
                                    <td><?= $supplier['deskripsi'] ?></td>
                                    <td>
                                        <a href="edit-supplier.php?id=<?= $supplier['id_supplier'] ?>"
                                            class="btn btn-sm btn-edit-beach"
                                            title="edit supplier">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a href="del-supplier.php?id=<?= $supplier['id_supplier'] ?>"
                                            class="btn btn-sm btn-danger btn-delete-beach"
                                            title="hapus supplier"
                                            onclick="return confirm('Anda yakin akan menghapus supplier ini ?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
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