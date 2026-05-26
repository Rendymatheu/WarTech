<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/mode-user.php";

$title = "Edit User - Codingline POS";
require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

$id = $_GET['id'];

$sqlEdit = "SELECT * FROM tbl_user WHERE userid = $id";
$user    = getData($sqlEdit)[0];
$level   = $user['level'];

if (isset($_POST['koreksi'])) {
    if (update($_POST)) {
        echo '<script>
                alert("Data user berhasil diupdate..");
                document.location.href = "data-user.php";
              </script>';
    }
}

?>

<div class="content-wrapper beach-page">

    <style>
        /* ===== BEACH THEME - EDIT USER ===== */
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
            background: linear-gradient(90deg, #f57f17, #ffa000);
            color: #fff;
            padding: 20px 24px;
            border-bottom: none;
        }

        .beach-card .card-title {
            font-weight: 700;
            font-size: 18px;
        }

        /* Form styling */
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

        .beach-card select.form-control {
            cursor: pointer;
        }

        .beach-card textarea.form-control {
            resize: vertical;
        }

        /* Profile image upload area */
        .upload-area {
            background: linear-gradient(135deg, #fff8e1, #fffde7);
            border: 2px dashed #ffa000;
            border-radius: 20px;
            padding: 28px 20px;
            text-align: center;
            transition: background .25s;
        }

        .upload-area:hover {
            background: linear-gradient(135deg, #ffe082, #fff8e1);
        }

        .upload-area .profile-user-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 3px solid #ffa000;
            box-shadow: 0 8px 20px rgba(255, 160, 0, .25);
            margin-bottom: 16px;
        }

        .upload-area .form-control {
            border-radius: 10px;
            font-size: 0.85rem;
        }

        .upload-area .text-sm {
            color: #546e7a;
            font-size: 0.8rem;
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

        /* Section divider label */
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
            background: linear-gradient(90deg, #b45309, #c17714) !important;
        }

        body.dark-mode .beach-card .form-group label {
            color: #48CAE4 !important;
        }

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

        body.dark-mode .beach-card .form-control::placeholder {
            color: #546e7a !important;
        }

        body.dark-mode .upload-area {
            background: linear-gradient(135deg, #2a1f0d, #1e1a0f) !important;
            border-color: #b45309 !important;
        }

        body.dark-mode .upload-area:hover {
            background: linear-gradient(135deg, #33260f, #252015) !important;
        }

        body.dark-mode .upload-area .text-sm {
            color: #78909c !important;
        }

        body.dark-mode .section-label {
            color: #ffcc80 !important;
        }

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
                        <div class="beach-icon" style="background: linear-gradient(135deg, #ffa000, #f57f17);">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div>
                            <h1>Edit User</h1>
                            <p>Perbarui data pengguna yang sudah terdaftar</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right beach-breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= $main_url ?>dashboard.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= $main_url ?>user/data-user.php">Users</a>
                        </li>
                        <li class="breadcrumb-item active">Edit User</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card beach-card">

                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $user['userid'] ?>">

                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-user-edit mr-2"></i> Edit User
                        </h3>
                        <div>
                            <a href="<?= $main_url ?>user/data-user.php" class="btn-back-beach">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="reset" class="btn-reset-beach">
                                <i class="fas fa-times"></i> Reset
                            </button>
                            <button type="submit" name="koreksi" class="btn-save-beach">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <!-- Left: Form Fields -->
                            <div class="col-lg-8 mb-3">
                                <p class="section-label"><i class="fas fa-info-circle"></i> Informasi Akun</p>

                                <div class="form-group">
                                    <label for="username">
                                        <i class="fas fa-user mr-1"></i> Username
                                    </label>
                                    <input type="text" name="username" class="form-control" id="username"
                                        placeholder="Masukkan username" autofocus autocomplete="off"
                                        value="<?= htmlspecialchars($user['username']) ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="fullname">
                                        <i class="fas fa-id-card mr-1"></i> Fullname
                                    </label>
                                    <input type="text" name="fullname" class="form-control" id="fullname"
                                        placeholder="Masukkan nama lengkap"
                                        value="<?= htmlspecialchars($user['fullname']) ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="level">
                                        <i class="fas fa-user-tag mr-1"></i> Level
                                    </label>
                                    <select name="level" id="level" class="form-control" required>
                                        <option value="">-- Pilih Level User --</option>
                                        <option value="1" <?= selectUser1($level) ?>>👑 Pemilik</option>
                                        <option value="2" <?= selectUser2($level) ?>>🖥️ Kasir</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="address">
                                        <i class="fas fa-map-marker-alt mr-1"></i> Address
                                    </label>
                                    <textarea name="address" id="address" rows="3" class="form-control"
                                        placeholder="Masukkan alamat user"
                                        required><?= htmlspecialchars($user['address']) ?></textarea>
                                </div>
                            </div>

                            <!-- Right: Photo Upload -->
                            <div class="col-lg-4">
                                <p class="section-label"><i class="fas fa-camera"></i> Foto Profil</p>

                                <div class="upload-area">
                                    <input type="hidden" name="oldImg" value="<?= $user['foto'] ?>">

                                    <img src="<?= $main_url ?>asset/image/<?= $user['foto'] ?>"
                                        class="profile-user-img img-circle"
                                        id="previewImg"
                                        alt="Foto profil">

                                    <div class="mt-3">
                                        <input type="file" class="form-control" name="image" id="imageInput"
                                            accept="image/jpg, image/jpeg, image/png, image/gif">
                                    </div>

                                    <div class="mt-2">
                                        <span class="text-sm"><i class="fas fa-info-circle mr-1"></i>Type file: JPG | PNG | GIF</span><br>
                                        <span class="text-sm"><i class="fas fa-crop-alt mr-1"></i>Disarankan: Width = Height</span><br>
                                        <span class="text-sm text-warning"><i class="fas fa-exclamation-triangle mr-1"></i>Kosongkan jika tidak ingin mengganti foto</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>

            </div>
        </div>
    </section>

</div>

<script>
    // Live preview foto profil saat file baru dipilih
    document.getElementById('imageInput').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (ev) {
                document.getElementById('previewImg').src = ev.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>

<?php require "../template/footer.php"; ?>