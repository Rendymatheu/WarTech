<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/mode-password.php";

$title = "Change Password";
require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

// update password
if (isset($_POST['simpan'])) {
    if (update($_POST)) {
        echo "<script>
                alert('Password berhasil diperbarui..');
                document.location='change-password.php';
              </script>";
    }
}

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
} else {
    $msg = '';
}

$alert1 = '<small class="text-danger pl-2 font-italic">konfirmasi password tidak sama dengan password baru</small>';
$alert2 = '<small class="text-danger pl-2 font-italic">current password tidak sama</small>';

?>

<div class="content-wrapper beach-page">

    <style>
        /* ===== BEACH THEME - CHANGE PASSWORD ===== */
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

        /* Tombol Submit & Reset */
        .btn-submit-beach {
            background: #ffffff;
            color: #00a884;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            padding: 8px 16px;
            box-shadow: 0 8px 18px rgba(0,0,0,.12);
        }

        .btn-submit-beach:hover {
            background: #e8fff8;
            color: #00796b;
        }

        .btn-reset-beach {
            background: rgba(255,255,255,.2);
            color: #fff;
            border: 2px solid rgba(255,255,255,.5);
            border-radius: 12px;
            font-weight: 700;
            padding: 7px 16px;
        }

        .btn-reset-beach:hover {
            background: rgba(255,255,255,.35);
            color: #fff;
        }

        /* Input field */
        .beach-form-control {
            background: #f7feff !important;
            border: 2px solid #e0f7fa !important;
            border-radius: 12px !important;
            padding: 12px 16px !important;
            font-size: 15px !important;
            color: #1f2d3d !important;
            transition: border-color .2s, box-shadow .2s;
        }

        .beach-form-control:focus {
            border-color: #00bcd4 !important;
            box-shadow: 0 0 0 4px rgba(0,188,212,.12) !important;
            background: #fff !important;
        }

        .beach-form-control::placeholder {
            color: #90cad4;
        }

        /* Label */
        .beach-label {
            font-weight: 700;
            color: #0077b6;
            margin-bottom: 6px;
            font-size: 14px;
        }

        /* Section divider dalam card */
        .beach-section-title {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #0077b6;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .beach-section-title::after {
            content: '';
            flex: 1;
            height: 2px;
            background: repeating-linear-gradient(90deg, #00bcd4 0px, #00bcd4 4px, transparent 4px, transparent 8px);
            border-radius: 2px;
        }

        /* Input group icon */
        .beach-input-wrap {
            position: relative;
        }

        .beach-input-wrap .beach-form-control {
            padding-left: 46px !important;
        }

        .beach-input-wrap .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #00a884;
            font-size: 15px;
            pointer-events: none;
            z-index: 5;
        }

        /* Toggle show/hide password */
        .beach-input-wrap .toggle-pass {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #90cad4;
            font-size: 15px;
            cursor: pointer;
            z-index: 5;
            transition: color .2s;
        }

        .beach-input-wrap .toggle-pass:hover {
            color: #00a884;
        }

        .beach-input-wrap .beach-form-control {
            padding-right: 46px !important;
        }

        /* Password strength bar */
        .strength-bar-wrap {
            height: 5px;
            background: #e0f7fa;
            border-radius: 10px;
            margin-top: 8px;
            overflow: hidden;
        }

        .strength-bar {
            height: 100%;
            width: 0%;
            border-radius: 10px;
            transition: width .35s, background .35s;
        }

        .strength-text {
            font-size: 11px;
            margin-top: 4px;
            font-weight: 600;
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

        body.dark-mode .beach-section-title {
            color: #48CAE4 !important;
        }

        body.dark-mode .beach-label {
            color: #90E0EF !important;
        }

        body.dark-mode .beach-form-control {
            background: #253545 !important;
            border-color: #2e4057 !important;
            color: #cce7f0 !important;
        }

        body.dark-mode .beach-form-control:focus {
            border-color: #48CAE4 !important;
            box-shadow: 0 0 0 4px rgba(72,202,228,.12) !important;
            background: #1e2d3d !important;
        }

        body.dark-mode .beach-form-control::placeholder {
            color: #4a7a8a !important;
        }

        body.dark-mode .beach-input-wrap .input-icon {
            color: #48CAE4 !important;
        }

        body.dark-mode .beach-input-wrap .toggle-pass {
            color: #4a7a8a !important;
        }

        body.dark-mode .beach-input-wrap .toggle-pass:hover {
            color: #48CAE4 !important;
        }

        body.dark-mode .strength-bar-wrap {
            background: #1a2e3d !important;
        }

        body.dark-mode .text-danger {
            color: #ff6b6b !important;
        }
    </style>

    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid px-3">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <div class="beach-title-box">
                        <div class="beach-icon">
                            <i class="fas fa-key"></i>
                        </div>
                        <div>
                            <h1>Change Password</h1>
                            <p>Perbarui keamanan akun Anda dengan mudah</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right beach-breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= $main_url ?>dashboard.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid px-3">
            <div class="card beach-card mb-0">

                <form action="" method="post">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-water mr-2"></i> Change Password
                        </h3>
                        <button type="submit" name="simpan" class="btn btn-sm btn-submit-beach float-right">
                            <i class="fas fa-save mr-1"></i> Submit
                        </button>
                        <button type="reset" name="reset" class="btn btn-sm btn-reset-beach float-right mr-2">
                            <i class="fas fa-times mr-1"></i> Reset
                        </button>
                    </div>

                    <div class="card-body p-4">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-md-8">

                                <div class="beach-section-title">
                                    <i class="fas fa-shield-alt"></i> Informasi Password
                                </div>

                                <!-- Current Password -->
                                <div class="form-group mb-4">
                                    <label class="beach-label">
                                        <i class="fas fa-lock mr-1"></i> Current Password
                                    </label>
                                    <div class="beach-input-wrap">
                                        <i class="fas fa-lock input-icon"></i>
                                        <input type="password" name="curPass" id="curPass"
                                            class="form-control beach-form-control"
                                            placeholder="Masukkan password saat ini" required>
                                        <i class="fas fa-eye toggle-pass" onclick="togglePass('curPass', this)"></i>
                                    </div>
                                    <?php if ($msg == 'err2') { echo $alert2; } ?>
                                </div>

                                <!-- New Password -->
                                <div class="form-group mb-2">
                                    <label class="beach-label">
                                        <i class="fas fa-key mr-1"></i> New Password
                                    </label>
                                    <div class="beach-input-wrap">
                                        <i class="fas fa-key input-icon"></i>
                                        <input type="password" name="newPass" id="newPass"
                                            class="form-control beach-form-control"
                                            placeholder="Masukkan password baru"
                                            required oninput="checkStrength(this.value)">
                                        <i class="fas fa-eye toggle-pass" onclick="togglePass('newPass', this)"></i>
                                    </div>
                                    <!-- Password strength indicator -->
                                    <div class="strength-bar-wrap mt-2">
                                        <div class="strength-bar" id="strengthBar"></div>
                                    </div>
                                    <small class="strength-text" id="strengthText" style="color:#90cad4;"></small>
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group mt-4 mb-2">
                                    <label class="beach-label">
                                        <i class="fas fa-check-circle mr-1"></i> Confirm Password
                                    </label>
                                    <div class="beach-input-wrap">
                                        <i class="fas fa-check-circle input-icon"></i>
                                        <input type="password" name="confPass" id="confPass"
                                            class="form-control beach-form-control"
                                            placeholder="Ulangi password baru" required>
                                        <i class="fas fa-eye toggle-pass" onclick="togglePass('confPass', this)"></i>
                                    </div>
                                    <?php if ($msg == 'err1') { echo $alert1; } ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </section>

    <script>
        // Toggle show/hide password
        function togglePass(fieldId, icon) {
            const field = document.getElementById(fieldId);
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // Password strength checker
        function checkStrength(val) {
            const bar  = document.getElementById('strengthBar');
            const text = document.getElementById('strengthText');
            let score = 0;

            if (val.length >= 8)              score++;
            if (/[A-Z]/.test(val))            score++;
            if (/[0-9]/.test(val))            score++;
            if (/[^A-Za-z0-9]/.test(val))     score++;

            const levels = [
                { pct: '0%',   color: '',          label: '' },
                { pct: '25%',  color: '#e74c3c',   label: '🔴 Lemah' },
                { pct: '50%',  color: '#f39c12',   label: '🟠 Cukup' },
                { pct: '75%',  color: '#00bcd4',   label: '🔵 Kuat' },
                { pct: '100%', color: '#00a884',   label: '🟢 Sangat Kuat' },
            ];

            const lvl = val.length === 0 ? levels[0] : levels[score] || levels[1];
            bar.style.width    = lvl.pct;
            bar.style.background = lvl.color;
            text.textContent   = lvl.label;
            text.style.color   = lvl.color;
        }
    </script>

<?php require "../template/footer.php"; ?>
</div>