<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/mode-barang.php";

$title = "Form Barang";
require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
    $id  = $_GET['id'];
    $sqlEdit = "SELECT * FROM tbl_barang WHERE id_barang = '$id'";
    $barang  = getData($sqlEdit)[0];
} else {
    $msg = "";
}

$alert = '';

if (isset($_POST['simpan'])) {
    if ($msg != '') {
        if (update($_POST)) {
            echo "
                <script>document.location.href = 'index.php?msg=updated';</script>
            ";
        } else {
            echo "
                <script>document.location.href = 'index.php';</script>
            ";
        }
    } else {
        if (insert($_POST)) {
            $alert = 'success';
        }
    }
}

?>

<div class="content-wrapper beach-form-page">

    <style>
        /* ===== BEACH THEME - FORM BARANG ===== */
        .beach-form-page {
            background:
                radial-gradient(circle at top right, rgba(255, 183, 77, .15), transparent 40%),
                radial-gradient(circle at bottom left, rgba(0, 188, 212, .15), transparent 40%),
                linear-gradient(135deg, #e0f7fa 0%, #fff8e1 100%);
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
            background: linear-gradient(135deg, #ff8f00, #ffca28);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            box-shadow: 0 12px 28px rgba(255, 143, 0, .30);
            flex-shrink: 0;
        }

        .beach-title-box h1 {
            margin: 0;
            font-weight: 800;
            color: #e65100;
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

        .beach-breadcrumb a { color: #e65100; }
        .beach-breadcrumb .breadcrumb-item.active { color: #795548; }

        /* ---- Card ---- */
        .beach-card {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .09);
            background: rgba(255, 255, 255, .94);
        }

        .beach-card .card-header {
            background: linear-gradient(90deg, #ff8f00, #ffc107);
            color: #fff;
            padding: 20px 26px;
            border-bottom: none;
            display: flex;
            align-items: center;
        }

        .beach-card .card-title {
            font-weight: 700;
            font-size: 17px;
            margin: 0;
            flex: 1;
        }

        /* ---- Buttons ---- */
        .btn-save-beach {
            background: #ffffff;
            color: #e65100;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            padding: 8px 18px;
            box-shadow: 0 8px 18px rgba(0, 0, 0, .15);
            margin-left: 8px;
            transition: background .2s;
        }
        .btn-save-beach:hover { background: #fff3e0; color: #bf360c; }

        .btn-reset-beach {
            background: rgba(255,255,255,.25);
            color: #fff;
            border: 2px solid rgba(255,255,255,.55);
            border-radius: 12px;
            font-weight: 700;
            padding: 7px 16px;
            margin-left: 6px;
            transition: background .2s;
        }
        .btn-reset-beach:hover { background: rgba(255,255,255,.4); color: #fff; }

        /* ---- Form Labels & Controls ---- */
        .beach-label {
            font-weight: 700;
            color: #5d4037;
            font-size: 13.5px;
            margin-bottom: 6px;
        }

        .beach-input {
            border-radius: 12px !important;
            border: 2px solid #ffe0b2 !important;
            padding: 10px 14px !important;
            font-size: 14px;
            transition: border-color .2s, box-shadow .2s;
            background: #fffdf8 !important;
        }
        .beach-input:focus {
            border-color: #ffa726 !important;
            box-shadow: 0 0 0 3px rgba(255, 167, 38, .18) !important;
            outline: none;
        }

        .beach-select {
            border-radius: 12px !important;
            border: 2px solid #ffe0b2 !important;
            padding: 10px 14px !important;
            background: #fffdf8 !important;
            transition: border-color .2s, box-shadow .2s;
        }
        .beach-select:focus {
            border-color: #ffa726 !important;
            box-shadow: 0 0 0 3px rgba(255, 167, 38, .18) !important;
        }

        /* ---- Image Upload Area ---- */
        .beach-img-wrapper {
            background: linear-gradient(135deg, #fff8e1, #e0f7fa);
            border-radius: 20px;
            padding: 28px 20px;
            text-align: center;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            border: 2px dashed #ffcc80;
            gap: 14px;
        }

        .beach-img-wrapper .img-label {
            font-weight: 700;
            color: #5d4037;
            font-size: 13.5px;
            margin-bottom: 2px;
        }

        .beach-product-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 18px;
            box-shadow: 0 10px 28px rgba(0,0,0,.12);
            border: 3px solid #ffe082;
        }

        .beach-file-input {
            border-radius: 10px;
            border: 2px solid #ffe0b2;
            background: #fffdf8;
            padding: 8px;
            width: 100%;
            font-size: 13px;
        }

        .beach-img-hint {
            font-size: 12px;
            color: #a1887f;
            background: rgba(255,255,255,.65);
            padding: 5px 12px;
            border-radius: 10px;
        }

        /* ---- Alert ---- */
        .beach-alert {
            margin: 20px 20px 0;
            border-radius: 16px;
            border: none;
        }

        /* ---- Required badge ---- */
        .req-star { color: #ef5350; margin-left: 2px; }

        /* ---- Divider label ---- */
        .section-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 18px 0 14px;
            color: #e65100;
            font-weight: 800;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .06em;
        }
        .section-divider::after {
            content: '';
            flex: 1;
            height: 2px;
            background: linear-gradient(90deg, #ffcc80, transparent);
            border-radius: 2px;
        }

        /* ============================================================
           DARK MODE OVERRIDES
        ============================================================ */
        body.dark-mode .beach-form-page {
            background:
                radial-gradient(circle at top right, rgba(180, 100, 0, .18), transparent 40%),
                linear-gradient(135deg, #0d1b2a 0%, #1a1a2e 100%) !important;
        }

        body.dark-mode .beach-title-box h1 { color: #ffa726 !important; }
        body.dark-mode .beach-title-box p  { color: #90a4ae !important; }

        body.dark-mode .beach-breadcrumb {
            background: rgba(30, 45, 61, 0.85) !important;
        }
        body.dark-mode .beach-breadcrumb a         { color: #ffa726 !important; }
        body.dark-mode .beach-breadcrumb .active   { color: #ffcc80 !important; }

        body.dark-mode .beach-card {
            background: rgba(30, 45, 61, 0.95) !important;
            box-shadow: 0 15px 40px rgba(0,0,0,.40) !important;
        }

        body.dark-mode .beach-card .card-header {
            background: linear-gradient(90deg, #bf6000, #c68400) !important;
        }

        body.dark-mode .beach-label { color: #ffcc80 !important; }

        body.dark-mode .beach-input,
        body.dark-mode .beach-select {
            background: #1e2d3d !important;
            border-color: #5d4037 !important;
            color: #ffe0b2 !important;
        }
        body.dark-mode .beach-input:focus,
        body.dark-mode .beach-select:focus {
            border-color: #ffa726 !important;
        }

        body.dark-mode .beach-img-wrapper {
            background: linear-gradient(135deg, #1e2d3d, #0d2030) !important;
            border-color: #5d4037 !important;
        }
        body.dark-mode .beach-img-wrapper .img-label { color: #ffcc80 !important; }
        body.dark-mode .beach-img-hint { background: rgba(30,45,61,.8) !important; color: #bcaaa4 !important; }

        body.dark-mode .beach-file-input {
            background: #1e2d3d !important;
            border-color: #5d4037 !important;
            color: #ffe0b2 !important;
        }

        body.dark-mode .section-divider { color: #ffa726 !important; }
        body.dark-mode .section-divider::after { background: linear-gradient(90deg, #5d4037, transparent) !important; }

        body.dark-mode .beach-alert {
            background: rgba(30,45,61,.95) !important;
            color: #ffe0b2 !important;
        }
    </style>

    <!-- ===== Content Header ===== -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <div class="beach-title-box">
                        <div class="beach-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <div>
                            <h1><?= $msg != '' ? 'Edit Barang' : 'Input Barang' ?></h1>
                            <p><?= $msg != '' ? 'Perbarui data barang yang sudah ada' : 'Tambahkan barang baru ke dalam sistem' ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right beach-breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= $main_url ?>dashboard.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= $main_url ?>barang">Barang</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <?= $msg != '' ? 'Edit Barang' : 'Add Barang' ?>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== Main Content ===== -->
    <section class="content">
        <div class="container-fluid">
            <div class="card beach-card">

                <?php if ($alert == 'success'): ?>
                    <div class="alert alert-success alert-dismissible beach-alert">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                        Barang berhasil ditambahkan ke dalam sistem.
                    </div>
                <?php endif; ?>

                <form action="" method="post" enctype="multipart/form-data">

                    <!-- Card Header -->
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-umbrella-beach mr-2"></i>
                            <?= $msg != '' ? 'Edit Data Barang' : 'Form Input Barang' ?>
                        </h3>
                        <button type="reset" class="btn btn-reset-beach btn-sm">
                            <i class="fas fa-times"></i> Reset
                        </button>
                        <button type="submit" name="simpan" class="btn btn-save-beach btn-sm">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <div class="row">

                            <!-- ===== LEFT: Form Fields ===== -->
                            <div class="col-lg-8 pr-lg-4">

                                <div class="section-divider"><i class="fas fa-tag mr-1"></i> Identitas Barang</div>

                                <div class="form-group">
                                    <label class="beach-label">Kode Barang</label>
                                    <input type="text" name="kode" class="form-control beach-input"
                                        value="<?= $msg != '' ? $barang['id_barang'] : generateId() ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label class="beach-label">Barcode <span class="req-star">*</span></label>
                                    <input type="text" name="barcode" class="form-control beach-input"
                                        value="<?= $msg != '' ? $barang['barcode'] : null ?>"
                                        placeholder="Masukkan barcode..." autocomplete="off" autofocus required>
                                </div>

                                <div class="form-group">
                                    <label class="beach-label">Nama Barang <span class="req-star">*</span></label>
                                    <input type="text" name="name" class="form-control beach-input"
                                        value="<?= $msg != '' ? $barang['nama_barang'] : null ?>"
                                        placeholder="Nama barang..." autocomplete="off" required>
                                </div>

                                <div class="form-group">
                                    <label class="beach-label">Satuan <span class="req-star">*</span></label>
                                    <select name="satuan" class="form-control beach-select" required>
                                        <?php if ($msg != ""): ?>
                                            <?php foreach (["piece", "botol", "kaleng", "pouch"] as $sat): ?>
                                                <option value="<?= $sat ?>" <?= $barang['satuan'] == $sat ? 'selected' : '' ?>>
                                                    <?= $sat ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="">-- Pilih Satuan --</option>
                                            <option value="piece">piece</option>
                                            <option value="botol">botol</option>
                                            <option value="kaleng">kaleng</option>
                                            <option value="pouch">pouch</option>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="section-divider mt-4"><i class="fas fa-coins mr-1"></i> Harga & Stok</div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="beach-label">Harga Beli <span class="req-star">*</span></label>
                                            <input type="number" name="harga_beli" class="form-control beach-input"
                                                value="<?= $msg != '' ? $barang['harga_beli'] : null ?>"
                                                placeholder="Rp 0" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="beach-label">Harga Jual <span class="req-star">*</span></label>
                                            <input type="number" name="harga_jual" class="form-control beach-input"
                                                value="<?= $msg != '' ? $barang['harga_jual'] : null ?>"
                                                placeholder="Rp 0" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="beach-label">Stok Minimal <span class="req-star">*</span></label>
                                    <input type="number" name="stock_minimal" class="form-control beach-input"
                                        value="<?= $msg != '' ? $barang['stock_minimal'] : null ?>"
                                        placeholder="0" autocomplete="off" required>
                                </div>

                            </div>

                            <!-- ===== RIGHT: Image Upload ===== -->
                            <div class="col-lg-4 mt-3 mt-lg-0">
                                <div class="section-divider d-none d-lg-flex"><i class="fas fa-image mr-1"></i> Foto Barang</div>
                                <div class="beach-img-wrapper">
                                    <p class="img-label mb-0"><i class="fas fa-camera mr-1"></i> Gambar Produk</p>
                                    <input type="hidden" name="oldImg" value="<?= $msg != '' ? $barang['gambar'] : null ?>">
                                    <img id="previewImg"
                                        src="<?= $main_url ?>asset/image/<?= $msg != '' ? $barang['gambar'] : 'default-brg.jpg' ?>"
                                        class="beach-product-img" alt="Preview Gambar">
                                    <input type="file" name="image" class="beach-file-input" accept="image/*"
                                        onchange="previewImage(this)">
                                    <span class="beach-img-hint"><i class="fas fa-info-circle mr-1"></i> JPG &bull; PNG &bull; GIF</span>
                                </div>
                            </div>

                        </div><!-- /.row -->
                    </div><!-- /.card-body -->

                </form>
            </div><!-- /.card -->
        </div>
    </section>

</div><!-- /.content-wrapper -->

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('previewImg').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<?php require "../template/footer.php"; ?>