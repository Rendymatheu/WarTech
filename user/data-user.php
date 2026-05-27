<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/mode-user.php";

$title = "Users - Codingline POS";
require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

?>

<div class="content-wrapper beach-page">

    <style>
        /* ===== BEACH THEME - DATA USER ===== */
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
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-add-beach:hover {
            background: #e8fff8;
            color: #00796b;
            text-decoration: none;
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
            padding: 14px 14px;
        }

        .beach-table tbody tr td:first-child {
            border-radius: 14px 0 0 14px;
        }

        .beach-table tbody tr td:last-child {
            border-radius: 0 14px 14px 0;
        }

        /* Level badge */
        .badge-level-pemilik {
            background: #fff8e1;
            color: #f57f17;
            border: 1.5px solid #ffe082;
            border-radius: 20px;
            padding: 4px 14px;
            font-size: 0.82rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .badge-level-kasir {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1.5px solid #a5d6a7;
            border-radius: 20px;
            padding: 4px 14px;
            font-size: 0.82rem;
            font-weight: 700;
            white-space: nowrap;
        }

        /* Action buttons */
        .btn-edit-beach {
            background: #fff8e1;
            color: #f57f17;
            border: 1.5px solid #ffe082;
            border-radius: 10px;
            padding: 6px 12px;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-edit-beach:hover {
            background: #ffe082;
            color: #e65100;
            text-decoration: none;
        }

        .btn-del-beach {
            background: #fff0f0;
            color: #c62828;
            border: 1.5px solid #ffcdd2;
            border-radius: 10px;
            padding: 6px 12px;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-del-beach:hover {
            background: #ffcdd2;
            color: #b71c1c;
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

        body.dark-mode .badge-level-pemilik {
            background: rgba(245, 127, 23, 0.15) !important;
            color: #ffcc80 !important;
            border-color: rgba(245, 127, 23, 0.35) !important;
        }

        body.dark-mode .badge-level-kasir {
            background: rgba(46, 125, 50, 0.15) !important;
            color: #a5d6a7 !important;
            border-color: rgba(46, 125, 50, 0.35) !important;
        }

        body.dark-mode .btn-edit-beach {
            background: rgba(245, 127, 23, 0.15) !important;
            color: #ffcc80 !important;
            border-color: rgba(245, 127, 23, 0.35) !important;
        }

        body.dark-mode .btn-edit-beach:hover {
            background: rgba(245, 127, 23, 0.3) !important;
            color: #ffe0b2 !important;
        }

        body.dark-mode .btn-del-beach {
            background: rgba(198, 40, 40, 0.15) !important;
            color: #ef9a9a !important;
            border-color: rgba(198, 40, 40, 0.35) !important;
        }

        body.dark-mode .btn-del-beach:hover {
            background: rgba(198, 40, 40, 0.3) !important;
            color: #ffcdd2 !important;
        }
    </style>

    <div class="content-header">
        <div class="container-fluid px-3">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <div class="beach-title-box">
                        <div class="beach-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h1>Data Users</h1>
                            <p>Kelola data pengguna dengan tampilan pantai yang lebih santai</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right beach-breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= $main_url ?>dashboard.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">User</li>
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
                        <i class="fas fa-id-card mr-2"></i> Data User
                    </h3>
                    <a href="<?= $main_url ?>user/add-user.php" class="btn btn-sm btn-add-beach float-right">
                        <i class="fas fa-plus"></i> Add User
                    </a>
                </div>

                <div class="card-body table-responsive p-4">
                    <table class="table table-hover text-nowrap beach-table" id="tblData">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Username</th>
                                <th>Fullname</th>
                                <th>Alamat</th>
                                <th>Level User</th>
                                <th style="width: 10%;" class="text-center">Operasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $users = getData("SELECT * FROM tbl_user");

                            foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <img src="<?= $user['foto'] ?>"
                                             class="rounded-circle"
                                             alt="foto"
                                             width="48px"
                                             height="48px"
                                             style="object-fit:cover; border: 2px solid #00bcd4;">
                                    </td>
                                    <td><?= htmlspecialchars($user['username']) ?></td>
                                    <td><?= htmlspecialchars($user['fullname']) ?></td>
                                    <td><?= htmlspecialchars($user['address']) ?></td>
                                    <td>
                                        <?php if ($user['level'] == 1): ?>
                                            <span class="badge-level-pemilik">
                                                <i class="fas fa-crown mr-1"></i> Pemilik
                                            </span>
                                        <?php elseif ($user['level'] == 2): ?>
                                            <span class="badge-level-kasir">
                                                <i class="fas fa-cash-register mr-1"></i> Kasir
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="edit-user.php?id=<?= $user['userid'] ?>"
                                           class="btn-edit-beach mr-1" title="Edit user">
                                            <i class="fas fa-user-edit"></i>
                                        </a>
                                        <a href="del-user.php?id=<?= $user['userid'] ?>&foto=<?= $user['foto'] ?>"
                                           class="btn-del-beach" title="Hapus user"
                                           onclick="return confirm('Anda yakin akan menghapus user ini ?')">
                                            <i class="fas fa-user-times"></i>
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