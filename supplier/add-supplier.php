<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/mode-supplier.php";

$title = "Tambah Supplier";
require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

$alert = "";

if (isset($_POST['simpan'])) {
    if (insert($_POST)) {
        $alert = 'success';
    }
}

?>

<div class="content-wrapper beach-page">

<style>
/* ===== BEACH THEME - ADD SUPPLIER ===== */
.beach-page {
    background:
        radial-gradient(circle at top left, rgba(0, 188, 212, .18), transparent 35%),
        linear-gradient(135deg, #e0f7fa 0%, #fdf6e3 100%);
    min-height: 100vh;
}

/* ── Title box ── */
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
    font-size: 26px;
    box-shadow: 0 12px 28px rgba(0, 168, 132, .25);
    flex-shrink: 0;
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

/* ── Breadcrumb ── */
.beach-breadcrumb {
    background: rgba(255, 255, 255, .75);
    padding: 10px 16px;
    border-radius: 14px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, .05);
}

.beach-breadcrumb .breadcrumb-item a {
    color: #0077b6;
    font-weight: 600;
    text-decoration: none;
}

/* ── Card ── */
.beach-card {
    border: none;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(0, 0, 0, .10);
    background: rgba(255, 255, 255, .93);
}

.beach-card .card-header {
    background: linear-gradient(90deg, #00a884, #00bcd4);
    color: #fff;
    padding: 20px 28px;
    border-bottom: none;
    display: flex;
    align-items: center;
    gap: 10px;
}

.beach-card .card-title {
    font-weight: 700;
    font-size: 18px;
    margin: 0;
    flex: 1;
}

/* ── Action buttons ── */
.btn-save-beach {
    background: #ffffff;
    color: #00a884;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    padding: 8px 18px;
    font-size: .85rem;
    box-shadow: 0 6px 16px rgba(0, 0, 0, .12);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    transition: all .2s;
}

.btn-save-beach:hover {
    background: #e8fff8;
    color: #00796b;
}

.btn-reset-beach {
    background: rgba(255,255,255,.18);
    color: #fff;
    border: 1.5px solid rgba(255,255,255,.45);
    border-radius: 12px;
    font-weight: 700;
    padding: 8px 18px;
    font-size: .85rem;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    transition: all .2s;
    margin-right: 8px;
}

.btn-reset-beach:hover {
    background: rgba(255,255,255,.28);
    color: #fff;
}

/* ── Form body ── */
.beach-card .card-body {
    padding: 32px 28px;
}

/* ── Alert ── */
.beach-alert-success {
    display: flex;
    align-items: center;
    gap: 12px;
    background: linear-gradient(90deg, #e8fff8, #f0fff4);
    border: 1.5px solid #a5d6a7;
    border-radius: 14px;
    padding: 14px 18px;
    color: #2e7d32;
    font-weight: 600;
    margin-bottom: 24px;
    animation: fadeSlideIn .4s ease;
}

.beach-alert-success .alert-icon {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #00a884, #4caf50);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 16px;
    flex-shrink: 0;
}

.beach-alert-success .btn-close-alert {
    margin-left: auto;
    background: none;
    border: none;
    color: #2e7d32;
    font-size: 18px;
    cursor: pointer;
    opacity: .6;
    padding: 0 4px;
}

.beach-alert-success .btn-close-alert:hover { opacity: 1; }

@keyframes fadeSlideIn {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Form label & input ── */
.beach-label {
    font-weight: 700;
    font-size: .82rem;
    letter-spacing: .4px;
    color: #0077b6;
    margin-bottom: 6px;
    display: block;
}

.beach-input {
    width: 100%;
    background: #f4fcff;
    border: 1.5px solid #b2ebf2;
    border-radius: 12px;
    padding: 11px 15px;
    font-size: .9rem;
    color: #1a3a4a;
    transition: border-color .2s, box-shadow .2s;
    outline: none;
    font-family: inherit;
}

.beach-input:focus {
    border-color: #00bcd4;
    box-shadow: 0 0 0 3px rgba(0, 188, 212, .15);
    background: #fff;
}

.beach-input::placeholder { color: #90a4ae; }

textarea.beach-input { resize: vertical; }

/* ── Input icon wrapper ── */
.beach-input-wrap {
    position: relative;
}

.beach-input-wrap .field-icon {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #b2ebf2;
    font-size: .9rem;
    pointer-events: none;
}

.beach-input-wrap textarea ~ .field-icon {
    top: 14px;
    transform: none;
}

/* ── Divider ── */
.beach-divider {
    border: none;
    border-top: 1.5px solid rgba(0, 188, 212, .12);
    margin: 8px 0 24px;
}

/* ── Section label ── */
.beach-section-label {
    font-size: .7rem;
    font-weight: 800;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #90a4ae;
    margin-bottom: 18px;
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
    background: rgba(30, 45, 61, .85) !important;
    box-shadow: 0 8px 20px rgba(0,0,0,.3) !important;
}

body.dark-mode .beach-breadcrumb .breadcrumb-item a { color: #48CAE4 !important; }
body.dark-mode .beach-breadcrumb .breadcrumb-item.active { color: #90E0EF !important; }

body.dark-mode .beach-card {
    background: rgba(30, 45, 61, .95) !important;
    box-shadow: 0 15px 40px rgba(0,0,0,.35) !important;
}

body.dark-mode .beach-card .card-header {
    background: linear-gradient(90deg, #005f4e, #006a7a) !important;
}

body.dark-mode .beach-label { color: #48CAE4 !important; }

body.dark-mode .beach-input {
    background: #1a2e3d !important;
    border-color: rgba(0,188,212,.2) !important;
    color: #cce7f0 !important;
}

body.dark-mode .beach-input:focus {
    border-color: #00bcd4 !important;
    background: #1e3547 !important;
    box-shadow: 0 0 0 3px rgba(0,188,212,.12) !important;
}

body.dark-mode .beach-input::placeholder { color: #4a6a7a !important; }

body.dark-mode .beach-section-label { color: #4a6a7a !important; }

body.dark-mode .beach-divider { border-color: rgba(0,188,212,.08) !important; }

body.dark-mode .beach-alert-success {
    background: linear-gradient(90deg, rgba(0,100,80,.25), rgba(0,120,60,.15)) !important;
    border-color: rgba(0,168,132,.35) !important;
    color: #80cbc4 !important;
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

    <!-- ── Content Header ── -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <div class="beach-title-box">
                        <div class="beach-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div>
                            <h1>Tambah Supplier</h1>
                            <p>Tambahkan data supplier baru ke sistem</p>
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
                        <li class="breadcrumb-item active">Add Supplier</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Content ── -->
    <section class="content">
        <div class="container-fluid">
            <div class="card beach-card">
                <form action="" method="post" autocomplete="off">

                    <!-- Card Header -->
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-plus-circle mr-2"></i> Add Supplier
                        </h3>
                        <button type="reset" class="btn-reset-beach">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                        <button type="submit" name="simpan" class="btn-save-beach">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">

                                <!-- Alert success -->
                                <?php if ($alert === 'success'): ?>
                                <div class="beach-alert-success" id="beach-alert">
                                    <div class="alert-icon">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <span>Supplier berhasil ditambahkan!</span>
                                    <button class="btn-close-alert" onclick="document.getElementById('beach-alert').remove()">
                                        &times;
                                    </button>
                                </div>
                                <?php endif; ?>

                                <!-- Section: Info Supplier -->
                                <p class="beach-section-label">Informasi Supplier</p>
                                <hr class="beach-divider">

                                <!-- Nama -->
                                <div class="form-group">
                                    <label class="beach-label" for="nama">
                                        <i class="fas fa-user mr-1" style="opacity:.6"></i> Nama Supplier
                                    </label>
                                    <div class="beach-input-wrap">
                                        <input type="text" name="nama" id="nama"
                                               class="beach-input"
                                               placeholder="Masukkan nama supplier"
                                               autofocus required>
                                        <i class="fas fa-building field-icon"></i>
                                    </div>
                                </div>

                                <!-- Telpon -->
                                <div class="form-group">
                                    <label class="beach-label" for="telpon">
                                        <i class="fas fa-phone mr-1" style="opacity:.6"></i> Nomor Telpon
                                    </label>
                                    <div class="beach-input-wrap">
                                        <input type="text" name="telpon" id="telpon"
                                               class="beach-input"
                                               placeholder="Contoh: 08123456789"
                                               pattern="[0-9]{5,}"
                                               title="Minimal 5 angka"
                                               required>
                                        <i class="fas fa-mobile-alt field-icon"></i>
                                    </div>
                                </div>

                                <!-- Deskripsi -->
                                <div class="form-group">
                                    <label class="beach-label" for="ketr">
                                        <i class="fas fa-info-circle mr-1" style="opacity:.6"></i> Deskripsi
                                    </label>
                                    <div class="beach-input-wrap">
                                        <textarea name="ketr" id="ketr" rows="2"
                                                  class="beach-input"
                                                  placeholder="Keterangan singkat mengenai supplier"
                                                  required></textarea>
                                        <i class="fas fa-align-left field-icon"></i>
                                    </div>
                                </div>

                                <!-- Alamat -->
                                <div class="form-group">
                                    <label class="beach-label" for="alamat">
                                        <i class="fas fa-map-marker-alt mr-1" style="opacity:.6"></i> Alamat
                                    </label>
                                    <div class="beach-input-wrap">
                                        <textarea name="alamat" id="alamat" rows="3"
                                                  class="beach-input"
                                                  placeholder="Alamat lengkap supplier"
                                                  required></textarea>
                                        <i class="fas fa-map-pin field-icon"></i>
                                    </div>
                                </div>

                            </div><!-- /col -->
                        </div><!-- /row -->
                    </div><!-- /card-body -->

                </form>
            </div><!-- /beach-card -->
        </div>
    </section>

<?php require "../template/footer.php"; ?>

</div><!-- /content-wrapper -->