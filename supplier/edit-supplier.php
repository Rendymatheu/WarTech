<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/mode-supplier.php";

$title = "Edit Supplier";
require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

// jalankan fungsi update data
if (isset($_POST['update'])){
    if (update($_POST)) {
        echo "<script>
                document.location.href = 'data-supplier.php?msg=updated';
        </script>";
    }
}

$id = $_GET['id'];

$sqlEdit = "SELECT * FROM tbl_supplier WHERE id_supplier = '$id'";
$supplier = getData($sqlEdit)[0];

?>

<div class="content-wrapper beach-page">

    <style>
        /* ===== BEACH THEME - EDIT SUPPLIER ===== */
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
            display: flex;
            align-items: center;
        }

        .beach-card .card-title {
            font-weight: 700;
            font-size: 18px;
            margin: 0;
            flex: 1;
        }

        .beach-card .card-body {
            padding: 28px;
        }

        /* Form Styling */
        .beach-form-label {
            font-weight: 700;
            color: #0077b6;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .beach-form-control {
            border: 2px solid #e0f7fa;
            border-radius: 12px;
            padding: 10px 16px;
            font-size: 14px;
            transition: border-color .2s, box-shadow .2s;
            background: #fafdff;
        }

        .beach-form-control:focus {
            border-color: #00bcd4;
            box-shadow: 0 0 0 3px rgba(0, 188, 212, .15);
            outline: none;
            background: #fff;
        }

        .beach-form-group {
            margin-bottom: 20px;
        }

        /* Buttons */
        .btn-save-beach {
            background: #ffffff;
            color: #00a884;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            padding: 8px 18px;
            box-shadow: 0 8px 18px rgba(0,0,0,.12);
            transition: background .2s, color .2s;
        }

        .btn-save-beach:hover {
            background: #e8fff8;
            color: #00796b;
        }

        .btn-reset-beach {
            background: rgba(255,255,255,.25);
            color: #fff;
            border: 2px solid rgba(255,255,255,.5);
            border-radius: 12px;
            font-weight: 700;
            padding: 7px 18px;
            margin-right: 8px;
            transition: background .2s;
        }

        .btn-reset-beach:hover {
            background: rgba(255,255,255,.4);
            color: #fff;
        }

        .btn-back-beach {
            background: rgba(255,255,255,.15);
            color: #fff;
            border: 2px solid rgba(255,255,255,.4);
            border-radius: 12px;
            font-weight: 700;
            padding: 7px 14px;
            margin-right: 8px;
            transition: background .2s;
        }

        .btn-back-beach:hover {
            background: rgba(255,255,255,.3);
            color: #fff;
            text-decoration: none;
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

        body.dark-mode .beach-form-label {
            color: #48CAE4 !important;
        }

        body.dark-mode .beach-form-control {
            background: #1a2e3d !important;
            border-color: #1e3d52 !important;
            color: #cce7f0 !important;
        }

        body.dark-mode .beach-form-control:focus {
            border-color: #48CAE4 !important;
            box-shadow: 0 0 0 3px rgba(72, 202, 228, .15) !important;
            background: #1e3548 !important;
        }

        body.dark-mode .beach-form-control::placeholder {
            color: #4a6a80 !important;
        }

        body.dark-mode .btn-save-beach {
            background: #1e3a4a !important;
            color: #48CAE4 !important;
        }

        body.dark-mode .btn-save-beach:hover {
            background: #253f52 !important;
            color: #90E0EF !important;
        }
    </style>

    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <div class="beach-title-box">
                        <div class="beach-icon">
                            <i class="fas fa-truck-loading"></i>
                        </div>
                        <div>
                            <h1>Supplier</h1>
                            <p>Edit data supplier dengan tampilan pantai yang lebih santai</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right beach-breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= $main_url ?>dashboard.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= $main_url ?>supplier/data-supplier.php">Supplier</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Supplier</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card beach-card">
                <form action="" method="post">

                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-water mr-2"></i> Edit Supplier
                        </h3>

                        <a href="data-supplier.php" class="btn btn-sm btn-back-beach">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>

                        <button type="reset" class="btn btn-sm btn-reset-beach">
                            <i class="fas fa-times"></i> Reset
                        </button>

                        <button type="submit" name="update" class="btn btn-sm btn-save-beach">
                            <i class="fas fa-save"></i> Update
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" name="id" value="<?= $supplier['id_supplier'] ?>">

                            <div class="col-lg-8">
                                <div class="beach-form-group">
                                    <label for="nama" class="beach-form-label">
                                        <i class="fas fa-user mr-1"></i> Nama
                                    </label>
                                    <input type="text" name="nama" class="form-control beach-form-control" id="nama"
                                        placeholder="Nama supplier" autofocus
                                        value="<?= $supplier['nama'] ?>" required>
                                </div>

                                <div class="beach-form-group">
                                    <label for="telpon" class="beach-form-label">
                                        <i class="fas fa-phone mr-1"></i> Telpon
                                    </label>
                                    <input type="text" name="telpon" class="form-control beach-form-control" id="telpon"
                                        placeholder="Nomor telpon supplier"
                                        pattern="[0-9]{5,}" title="Minimal 5 angka"
                                        value="<?= $supplier['telpon'] ?>" required>
                                </div>

                                <div class="beach-form-group">
                                    <label for="ketr" class="beach-form-label">
                                        <i class="fas fa-align-left mr-1"></i> Deskripsi
                                    </label>
                                    <textarea name="ketr" id="ketr" rows="2"
                                        class="form-control beach-form-control"
                                        placeholder="Keterangan supplier" required><?= $supplier['deskripsi'] ?></textarea>
                                </div>

                                <div class="beach-form-group">
                                    <label for="alamat" class="beach-form-label">
                                        <i class="fas fa-map-marker-alt mr-1"></i> Alamat
                                    </label>
                                    <textarea name="alamat" id="alamat" rows="3"
                                        class="form-control beach-form-control"
                                        placeholder="Alamat supplier" required><?= $supplier['alamat'] ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>

</div>

<?php require "../template/footer.php"; ?>