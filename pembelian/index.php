<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/mode-beli.php";

$title = "Transaksi";
require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
} else {
    $msg = '';
}   

if ($msg == 'deleted') {
    $idbrg = $_GET['idbrg'];
    $idbeli = $_GET['idbeli'];
    $qty = $_GET['qty'];
    $tgl= $_GET['tgl'];
    delete($idbrg, $idbeli, $qty);
    echo "<script>
            document.location = '?tgl=$tgl';
        </script>";
}

$kode = @$_GET['pilihbrg'] ? @$_GET['pilihbrg'] : '';
if ($kode) {
    $selectBrg = getData("SELECT * FROM tbl_barang WHERE id_barang = '$kode'")[0];
}

if (isset($_POST['addbrg'])) {
    $tglNota = $_POST['tglNota'];
    if (insert($_POST)) {
        echo "<script>
            document.location = '?tgl=$tgl';
        </script>";
    }
}

if (isset($_POST['simpan'])) {
    if (simpan($_POST)) {
        echo "<script>
            alert('data pembelian berhasil disimpan');
            document.location = 'index.php?msg=sukses';
        </script>";
    }
}

$noBeli = generateNo();

?>

<div class="content-wrapper beach-page">

    <style>
        /* ===== BEACH THEME - PEMBELIAN ===== */
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

        /* === Cards === */
        .beach-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 28px rgba(0,0,0,.07);
            background: rgba(255,255,255,.93);
            margin-bottom: 20px;
        }

        .beach-card-header {
            background: linear-gradient(90deg, #00a884, #00bcd4);
            color: #fff;
            padding: 14px 20px;
            border-radius: 20px 20px 0 0;
            font-weight: 700;
            font-size: 15px;
        }

        .beach-card-body {
            padding: 20px;
        }

        /* Total Pembelian card */
        .total-card {
            border: none;
            border-radius: 20px;
            background: linear-gradient(135deg, #00a884, #0077b6);
            color: #fff;
            padding: 20px 24px;
            box-shadow: 0 12px 30px rgba(0, 119, 182, .25);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .total-card .label {
            font-size: 13px;
            font-weight: 600;
            opacity: .8;
            text-align: right;
            margin-bottom: 6px;
        }

        .total-card .amount {
            font-size: 36px;
            font-weight: 800;
            text-align: right;
            line-height: 1;
        }

        /* Form controls */
        .beach-page .form-control {
            border-radius: 10px;
            border: 1.5px solid #d0eef5;
            background: #f7fdfe;
        }

        .beach-page .form-control:focus {
            border-color: #00bcd4;
            box-shadow: 0 0 0 3px rgba(0,188,212,.15);
            background: #fff;
        }

        .beach-page label {
            font-weight: 600;
            color: #0077b6;
            font-size: 13px;
        }

        /* Buttons */
        .btn-beach-add {
            background: linear-gradient(90deg, #00a884, #00bcd4);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            padding: 10px 0;
            width: 100%;
            transition: opacity .2s;
        }

        .btn-beach-add:hover {
            opacity: .88;
            color: #fff;
        }

        .btn-beach-save {
            background: linear-gradient(90deg, #0077b6, #00a884);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            padding: 12px 0;
            width: 100%;
            font-size: 15px;
            transition: opacity .2s;
        }

        .btn-beach-save:hover {
            opacity: .88;
            color: #fff;
        }

        /* Table */
        .beach-table {
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .beach-table thead th {
            background: #f1fbfc;
            color: #0077b6;
            border: none;
            font-weight: 800;
            font-size: 13px;
        }

        .beach-table tbody tr {
            background: #ffffff;
            box-shadow: 0 4px 14px rgba(0,0,0,.05);
        }

        .beach-table tbody td {
            border-top: none;
            vertical-align: middle;
            padding: 12px 10px;
            font-size: 13px;
        }

        .beach-table tbody tr td:first-child { border-radius: 12px 0 0 12px; }
        .beach-table tbody tr td:last-child  { border-radius: 0 12px 12px 0; }

        .btn-del-beach {
            background: #ef5350;
            border: none;
            border-radius: 8px;
            color: #fff;
            padding: 5px 10px;
        }

        .btn-del-beach:hover {
            background: #c62828;
            color: #fff;
        }

        /* ============================================================
           DARK MODE OVERRIDES
        ============================================================ */
        body.dark-mode .beach-page {
            background:
                radial-gradient(circle at top left, rgba(0, 100, 130, .25), transparent 35%),
                linear-gradient(135deg, #0d1b2a 0%, #1a1a2e 100%) !important;
        }

        body.dark-mode .beach-title-box h1  { color: #48CAE4 !important; }
        body.dark-mode .beach-title-box p   { color: #90a4ae !important; }

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

        body.dark-mode .beach-card-header {
            background: linear-gradient(90deg, #005f4e, #006a7a) !important;
        }

        body.dark-mode .beach-page .form-control {
            background: #253545 !important;
            border: 1px solid #2e4057 !important;
            color: #cce7f0 !important;
        }

        body.dark-mode .beach-page label { color: #90E0EF !important; }

        body.dark-mode .beach-table thead th {
            background: #1a2e3d !important;
            color: #48CAE4 !important;
        }

        body.dark-mode .beach-table tbody tr {
            background: #1e2d3d !important;
        }

        body.dark-mode .beach-table tbody td { color: #cce7f0 !important; }

        body.dark-mode .beach-table tbody tr:hover td {
            background: #253545 !important;
        }

        body.dark-mode .total-card {
            background: linear-gradient(135deg, #005f4e, #004a6e) !important;
        }
    </style>

    <!-- Page Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <div class="beach-title-box">
                        <div class="beach-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div>
                            <h1>Pembelian Barang</h1>
                            <p>Input transaksi pembelian baru</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right beach-breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= $main_url ?>dashboard.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah Pembelian</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="" method="post">

                <!-- Row 1: Nota + Total -->
                <div class="row mb-3">
                    <div class="col-lg-7">
                        <div class="beach-card">
                            <div class="beach-card-header">
                                <i class="fas fa-file-invoice mr-2"></i> Info Pembelian
                            </div>
                            <div class="beach-card-body">
                                <div class="form-group row mb-3">
                                    <label class="col-sm-2 col-form-label">No Nota</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="nobeli" class="form-control"
                                            id="noNota" value="<?= $noBeli ?>">
                                    </div>
                                    <label class="col-sm-2 col-form-label">Tgl Nota</label>
                                    <div class="col-sm-4">
                                        <input type="date" name="tglNota" class="form-control"
                                            id="tglNota"
                                            value="<?= @$_GET['tgl'] ? $_GET['tgl'] : date('Y-m-d') ?>"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label class="col-sm-2 col-form-label">SKU</label>
                                    <div class="col-sm-10">
                                        <select name="kodeBrg" id="kodeBrg" class="form-control">
                                            <option value="">-- Pilih kode barang --</option>
                                            <?php
                                            $barang = getData("SELECT * FROM tbl_barang");
                                            foreach ($barang as $brg): ?>
                                                <option value="?pilihbrg=<?= $brg['id_barang'] ?>"
                                                    <?= @$_GET['pilihbrg'] == $brg['id_barang'] ? 'selected' : '' ?>>
                                                    <?= $brg['id_barang'] . " | " . $brg['nama_barang'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="total-card">
                            <div class="label">Total Pembelian</div>
                            <input type="hidden" name="total" value="<?= totalBeli($noBeli) ?>">
                            <div class="amount">
                                Rp <?= number_format(totalBeli($noBeli), 0, ',', '.') ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row 2: Detail Barang -->
                <div class="beach-card">
                    <div class="beach-card-header">
                        <i class="fas fa-box-open mr-2"></i> Detail Barang
                    </div>
                    <div class="beach-card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <input type="hidden" value="<?= @$_GET['pilihbrg'] ? $selectBrg['id_barang'] : '' ?>" name="kodeBrg">
                                    <label>Nama Barang</label>
                                    <input type="text" name="namaBrg" class="form-control form-control-sm"
                                        id="namaBrg"
                                        value="<?= @$_GET['pilihbrg'] ? $selectBrg['nama_barang'] : '' ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <div class="form-group">
                                    <label>Stok</label>
                                    <input type="number" name="stok" class="form-control form-control-sm"
                                        id="stok"
                                        value="<?= @$_GET['pilihbrg'] ? $selectBrg['stock'] : '' ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input type="text" name="satuan" class="form-control form-control-sm"
                                        id="satuan"
                                        value="<?= @$_GET['pilihbrg'] ? $selectBrg['satuan'] : '' ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="number" name="harga" class="form-control form-control-sm"
                                        id="harga"
                                        value="<?= @$_GET['pilihbrg'] ? $selectBrg['harga_beli'] : '' ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Qty</label>
                                    <input type="number" name="qty" class="form-control form-control-sm"
                                        id="qty"
                                        value="<?= @$_GET['pilihbrg'] ? 1 : '' ?>">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Jumlah Harga</label>
                                    <input type="number" name="jmlHarga" class="form-control form-control-sm"
                                        id="jmlHarga"
                                        value="<?= @$_GET['pilihbrg'] ? $selectBrg['harga_beli'] : '' ?>"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn-beach-add" name="addbrg">
                            <i class="fas fa-cart-plus mr-1"></i> Tambah Barang
                        </button>
                    </div>
                </div>

                <!-- Row 3: Tabel Detail -->
                <div class="beach-card">
                    <div class="beach-card-header">
                        <i class="fas fa-list mr-2"></i> Daftar Barang Dibeli
                    </div>
                    <div class="card-body table-responsive p-3">
                        <table class="table table-hover text-nowrap beach-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th class="text-right">Harga</th>
                                    <th class="text-right">Qty</th>
                                    <th class="text-right">Jumlah Harga</th>
                                    <th class="text-center" width="10%">Operasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $brgDetail = getData("SELECT * FROM tbl_beli_detail WHERE no_beli = '$noBeli'");
                                foreach ($brgDetail as $detail): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $detail['kode_brg'] ?></td>
                                        <td><?= $detail['nama_brg'] ?></td>
                                        <td class="text-right"><?= number_format($detail['harga_beli'], 0, ',', '.') ?></td>
                                        <td class="text-right"><?= $detail['qty'] ?></td>
                                        <td class="text-right"><?= number_format($detail['jml_harga'], 0, ',', '.') ?></td>
                                        <td class="text-center">
                                            <a href="?idbrg=<?= $detail['kode_brg'] ?>&idbeli=<?= $detail['no_beli'] ?>&qty=<?= $detail['qty'] ?>&tgl=<?= $detail['tgl_beli'] ?>&msg=deleted"
                                                class="btn-del-beach"
                                                title="Hapus barang"
                                                onclick="return confirm('Anda yakin akan menghapus barang ini?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Row 4: Supplier + Simpan -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="beach-card">
                            <div class="beach-card-header">
                                <i class="fas fa-truck mr-2"></i> Informasi Supplier
                            </div>
                            <div class="beach-card-body">
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3 col-form-label col-form-label-sm">Suplier</label>
                                    <div class="col-sm-9">
                                        <select name="suplier" id="suplier" class="form-control form-control-sm">
                                            <option value="">-- Pilih Suplier --</option>
                                            <?php
                                            $suppliers = getData("SELECT * FROM tbl_supplier");
                                            foreach ($suppliers as $supplier): ?>
                                                <option value="<?= $supplier['nama'] ?>"><?= $supplier['nama'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <textarea name="ketr" id="ketr" class="form-control form-control-sm" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex align-items-center">
                        <button type="submit" name="simpan" id="simpan" class="btn-beach-save">
                            <i class="fa fa-save mr-2"></i> Simpan Pembelian
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </section>

    <script>
        let pilihbrg = document.getElementById('kodeBrg');
        let tgl      = document.getElementById('tglNota');
        pilihbrg.addEventListener('change', function () {
            document.location.href = this.options[this.selectedIndex].value + '&tgl=' + tgl.value;
        });

        let qty      = document.getElementById('qty');
        let jmlHarga = document.getElementById('jmlHarga');
        let harga    = document.getElementById('harga');
        qty.addEventListener('input', function () {
            jmlHarga.value = qty.value * harga.value;
        });
    </script>

<?php require "../template/footer.php"; ?>
</div>