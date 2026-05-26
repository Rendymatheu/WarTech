<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/mode-customer.php";

$title = "Edit Customer - Codingline POS";

require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

if (isset($_POST['update'])) {
    if (update($_POST)) {
        echo "<script>
                document.location.href = 'data-customer.php?msg=updated';
              </script>";
    }
}

$id = $_GET['id'];

$sqlEdit = "SELECT * FROM tbl_customer WHERE id_customer = '$id'";
$customer = getData($sqlEdit)[0];

?>

<div class="content-wrapper beach-page">

    <style>
        /* ===== BEACH THEME - EDIT CUSTOMER ===== */
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
            background: linear-gradient(135deg, #ffa000, #f57f17);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            box-shadow: 0 12px 28px rgba(245, 127, 23, .28);
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
            background: linear-gradient(90deg, #ffa000, #f57f17);
            color: #fff;
            padding: 20px 24px;
            border-bottom: none;
        }

        .beach-card .card-title {
            font-weight: 700;
            font-size: 18px;
        }

        .beach-card .card-body {
            padding: 30px;
        }

        .beach-card .form-group label {
            font-weight: 600;
            color: #0077b6;
            margin-bottom: 6px;
        }

        .beach-card .form-control {
            border-radius: 12px;
            border: 1.5px solid #b2ebf2;
            padding: 10px 14px;
            transition: border-color .25s, box-shadow .25s;
            background: #f9fdff;
        }

        .beach-card .form-control:focus {
            border-color: #00bcd4;
            box-shadow: 0 0 0 3px rgba(0, 188, 212, .15);
            background: #ffffff;
            outline: none;
        }

        .beach-card textarea.form-control {
            resize: vertical;
        }

        .section-label {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #f57f17;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 2px;
            background: linear-gradient(90deg, #ffe082, transparent);
            border-radius: 2px;
        }

        /* Action buttons */
        .btn-save-beach {
            background: #ffffff;
            color: #e65100;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            padding: 8px 18px;
            box-shadow: 0 8px 18px rgba(0,0,0,.12);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: background .2s, color .2s;
        }

        .btn-save-beach:hover {
            background: #fff3e0;
            color: #bf360c;
        }

        .btn-reset-beach {
            background: rgba(255,255,255,.85);
            color: #c62828;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            padding: 8px 18px;
            box-shadow: 0 8px 18px rgba(0,0,0,.12);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            margin-right: 8px;
            transition: background .2s, color .2s;
        }

        .btn-reset-beach:hover {
            background: #fff0f0;
            color: #b71c1c;
        }

        .btn-back-beach {
            background: rgba(255,255,255,.85);
            color: #0077b6;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            padding: 8px 18px;
            box-shadow: 0 8px 18px rgba(0,0,0,.12);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            margin-right: 8px;
            transition: background .2s, color .2s;
        }

        .btn-back-beach:hover {
            background: #e1f5fe;
            color: #005b8e;
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

        body.dark-mode .beach-title-box h1 { color: #48CAE4 !important; }
        body.dark-mode .beach-title-box p  { color: #90a4ae !important; }

        body.dark-mode .beach-breadcrumb {
            background: rgba(30, 45, 61, 0.85) !important;
            box-shadow: 0 8px 20px rgba(0,0,0,.3) !important;
        }

        body.dark-mode .beach-breadcrumb .breadcrumb-item a   { color: #48CAE4 !important; }
        body.dark-mode .beach-breadcrumb .breadcrumb-item.active { color: #90E0EF !important; }

        body.dark-mode .beach-card {
            background: rgba(30, 45, 61, 0.95) !important;
            box-shadow: 0 15px 35px rgba(0,0,0,.35) !important;
        }

        body.dark-mode .beach-card .card-header {
            background: linear-gradient(90deg, #b45309, #c17714) !important;
        }

        body.dark-mode .beach-card .form-group label { color: #48CAE4 !important; }

        body.dark-mode .beach-card .form-control {
            background: #1a2e3d !important;
            border-color: #1e4d5c !important;
            color: #cce7f0 !important;
        }

        body.dark-mode .beach-card .form-control:focus {
            border-color: #00bcd4 !important;
            box-shadow: 0 0 0 3px rgba(0, 188, 212, .2) !important;
            background: #1e3a4a !important;
        }

        body.dark-mode .beach-card .form-control::placeholder { color: #546e7a !important; }

        body.dark-mode .section-label { color: #ffcc80 !important; }
        body.dark-mode .section-label::after {
            background: linear-gradient(90deg, #5c3c00, transparent) !important;
        }

        body.dark-mode .btn-save-beach {
            background: rgba(245, 127, 23, 0.2) !important;
            color: #ffcc80 !important;
        }
        body.dark-mode .btn-save-beach:hover {
            background: rgba(245, 127, 23, 0.35) !important;
            color: #ffe0b2 !important;
        }

        body.dark-mode .btn-reset-beach {
            background: rgba(198, 40, 40, 0.15) !important;
            color: #ef9a9a !important;
        }
        body.dark-mode .btn-reset-beach:hover {
            background: rgba(198, 40, 40, 0.3) !important;
            color: #ffcdd2 !important;
        }

        body.dark-mode .btn-back-beach {
            background: rgba(0, 119, 182, 0.15) !important;
            color: #48CAE4 !important;
        }
        body.dark-mode .btn-back-beach:hover {
            background: rgba(0, 119, 182, 0.3) !important;
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
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div>
                            <h1>Edit Customer</h1>
                            <p>Perbarui data pelanggan yang sudah terdaftar</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right beach-breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= $main_url ?>dashboard.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= $main_url ?>customer/data-customer.php">Customer</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Customer</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card beach-card">

                <form action="" method="post">
                    <input type="hidden" name="id" value="<?= $customer['id_customer'] ?>">

                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-user-edit mr-2"></i> Edit Customer
                        </h3>
                        <div>
                            <a href="<?= $main_url ?>customer/data-customer.php" class="btn-back-beach">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="reset" class="btn-reset-beach">
                                <i class="fas fa-times"></i> Reset
                            </button>
                            <button type="submit" name="update" class="btn-save-beach">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8 mb-3">
                                <p class="section-label"><i class="fas fa-info-circle"></i> Informasi Customer</p>

                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-user mr-1"></i> Nama
                                    </label>
                                    <input type="text" name="nama" class="form-control"
                                        placeholder="Masukkan nama customer"
                                        value="<?= htmlspecialchars($customer['nama']) ?>" required>
                                </div>

                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-phone mr-1"></i> Telpon
                                    </label>
                                    <input type="text" name="telpon" class="form-control"
                                        placeholder="Masukkan nomor telpon"
                                        value="<?= htmlspecialchars($customer['telpon']) ?>" required>
                                </div>

                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-align-left mr-1"></i> Deskripsi
                                    </label>
                                    <textarea name="ketr" rows="2" class="form-control"
                                        placeholder="Masukkan deskripsi" required><?= htmlspecialchars($customer['deskripsi']) ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-map-marker-alt mr-1"></i> Alamat
                                    </label>
                                    <textarea name="alamat" rows="3" class="form-control"
                                        placeholder="Masukkan alamat customer" required><?= htmlspecialchars($customer['alamat']) ?></textarea>
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