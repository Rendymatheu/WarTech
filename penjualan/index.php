<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/mode-jual.php";

$title = "Transaksi";
require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
} else {
    $msg = '';
}   

// jika barang dihapus
if ($msg == 'deleted') {
    $barcode = $_GET['barcode'];
    $idjual  = $_GET['idjual'];
    $qty     = $_GET['qty'];
    $tgl     = $_GET['tgl'];
    delete($barcode, $idjual, $qty);
    echo "<script>
            alert('barang telah dihapus..');
            document.location = '?tgl=$tgl';
        </script>";
}

// jika ada barcode yang dikirim
$kode = @$_GET['barcode'] ? @$_GET['barcode'] : '';
if ($kode) {
    $tgl      = $_GET['tgl'];
    $dataBrg  = mysqli_query($koneksi, "SELECT * FROM tbl_barang WHERE barcode = '$kode'");
    $selectBrg = mysqli_fetch_assoc($dataBrg);
    if (!mysqli_num_rows($dataBrg)) {
        echo "<script>
            alert('barang dengan barcode tersebut tidak ada..');
            document.location = '?tgl=$tgl';
        </script>";
    }
}

// jika tombol tambah barang ditekan
if (isset($_POST['addbrg'])) {
    $tgl = $_POST['tglNota'];
    if (insert($_POST)) {
        echo "<script>
            document.location = '?tgl=$tgl';
        </script>";
    }
}

// jika tombol simpan ditekan
if (isset($_POST['simpan'])) {
    $nota = $_POST['nojual'];
    if (simpan($_POST)) {
        echo "<script>
                alert('data penjualan berhasil disimpan');
                window.onload = function(){
                    let win = window.open('../report/r-struk.php?nota=$nota',
                    'Struk Belanja','width=260,height=400,left=10,top=10','_blank');
                    if(win){
                        win.focus();
                        window.location = 'index.php';
                    }
                }
        </script>";
    }
}

$nojual = generateNo();

?>

<div class="content-wrapper beach-page">

    <style>
        /* ===== BEACH THEME - PENJUALAN ===== */
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

        /* Total Penjualan card */
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

        .beach-page .input-group-text {
            border-radius: 0 10px 10px 0;
            border: 1.5px solid #d0eef5;
            border-left: none;
            background: #e8f8fb;
            color: #0077b6;
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

        /* Kembalian highlight */
        .kembalian-box {
            background: linear-gradient(135deg, #e0f7fa, #f0fff8);
            border-radius: 14px;
            padding: 16px 20px;
            border: 1.5px solid #b2ebf2;
        }

        .kembalian-box .kem-label {
            font-size: 12px;
            font-weight: 700;
            color: #0077b6;
            margin-bottom: 4px;
        }

        .kembalian-box .kem-value {
            font-size: 26px;
            font-weight: 800;
            color: #00796b;
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

        body.dark-mode .beach-breadcrumb .breadcrumb-item a      { color: #48CAE4 !important; }
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

        body.dark-mode .beach-page .input-group-text {
            background: #1e3a4a !important;
            border-color: #2e4057 !important;
            color: #48CAE4 !important;
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

        body.dark-mode .kembalian-box {
            background: #1a2e3d !important;
            border-color: #2e4057 !important;
        }

        body.dark-mode .kembalian-box .kem-label { color: #48CAE4 !important; }
        body.dark-mode .kembalian-box .kem-value { color: #48CAE4 !important; }
    </style>

    <!-- Page Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <div class="beach-title-box">
                        <div class="beach-icon">
                            <i class="fas fa-cash-register"></i>
                        </div>
                        <div>
                            <h1>Penjualan Barang</h1>
                            <p>Input transaksi penjualan baru</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right beach-breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= $main_url ?>dashboard.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah Penjualan</li>
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
                                <i class="fas fa-file-invoice mr-2"></i> Info Penjualan
                            </div>
                            <div class="beach-card-body">
                                <div class="form-group row mb-3">
                                    <label class="col-sm-2 col-form-label">No Nota</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="nojual" class="form-control"
                                            id="noNota" value="<?= $nojual ?>">
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
                                    <label class="col-sm-2 col-form-label">Barcode</label>
                                    <div class="col-sm-10 input-group">
                                        <input type="text" name="barcode" id="barcode"
                                            value="<?= @$_GET['barcode'] ? $_GET['barcode'] : '' ?>"
                                            class="form-control"
                                            placeholder="Masukkan barcode barang">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fas fa-barcode"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="total-card">
                            <div class="label">Total Penjualan</div>
                            <input type="hidden" name="total" id="total" value="<?= totalJual($nojual) ?>">
                            <div class="amount">
                                Rp <?= number_format(totalJual($nojual), 0, ',', '.') ?>
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
                                    <input type="hidden" value="<?= @$_GET['barcode'] ? $selectBrg['barcode'] : '' ?>" name="barcode">
                                    <label>Nama Barang</label>
                                    <input type="text" name="namaBrg" class="form-control form-control-sm"
                                        id="namaBrg"
                                        value="<?= @$_GET['barcode'] ? $selectBrg['nama_barang'] : '' ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <div class="form-group">
                                    <label>Stok</label>
                                    <input type="number" name="stok" class="form-control form-control-sm"
                                        id="stok"
                                        value="<?= @$_GET['barcode'] ? $selectBrg['stock'] : '' ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input type="text" name="satuan" class="form-control form-control-sm"
                                        id="satuan"
                                        value="<?= @$_GET['barcode'] ? $selectBrg['satuan'] : '' ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="number" name="harga" class="form-control form-control-sm"
                                        id="harga"
                                        value="<?= @$_GET['barcode'] ? $selectBrg['harga_jual'] : '' ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Qty</label>
                                    <input type="number" name="qty" class="form-control form-control-sm"
                                        id="qty"
                                        value="<?= @$_GET['barcode'] ? 1 : '' ?>">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Jumlah Harga</label>
                                    <input type="number" name="jmlHarga" class="form-control form-control-sm"
                                        id="jmlHarga"
                                        value="<?= @$_GET['barcode'] ? $selectBrg['harga_jual'] : '' ?>"
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
                        <i class="fas fa-list mr-2"></i> Daftar Barang Dijual
                    </div>
                    <div class="card-body table-responsive p-3">
                        <table class="table table-hover text-nowrap beach-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Barcode</th>
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
                                $brgDetail = getData("SELECT * FROM tbl_jual_detail WHERE no_jual = '$nojual'");
                                foreach ($brgDetail as $detail): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $detail['barcode'] ?></td>
                                        <td><?= $detail['nama_brg'] ?></td>
                                        <td class="text-right"><?= number_format($detail['harga_jual'], 0, ',', '.') ?></td>
                                        <td class="text-right"><?= $detail['qty'] ?></td>
                                        <td class="text-right"><?= number_format($detail['jml_harga'], 0, ',', '.') ?></td>
                                        <td class="text-center">
                                            <a href="?barcode=<?= $detail['barcode'] ?>&idjual=<?= $detail['no_jual'] ?>&qty=<?= $detail['qty'] ?>&tgl=<?= $detail['tgl_jual'] ?>&msg=deleted"
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

                <!-- Row 4: Customer + Bayar + Simpan -->
                <div class="row">
                    <!-- Customer & Keterangan -->
                    <div class="col-lg-4">
                        <div class="beach-card">
                            <div class="beach-card-header">
                                <i class="fas fa-user mr-2"></i> Informasi Customer
                            </div>
                            <div class="beach-card-body">
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3 col-form-label col-form-label-sm">Customer</label>
                                    <div class="col-sm-9">
                                        <select name="customer" id="customer" class="form-control form-control-sm">
                                            <?php
                                            $customers = getData("SELECT * FROM tbl_customer");
                                            foreach ($customers as $customer): ?>
                                                <option value="<?= $customer['nama'] ?>"><?= $customer['nama'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-form-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <textarea name="ketr" id="ketr" rows="4"
                                            class="form-control form-control-sm"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bayar & Kembalian -->
                    <div class="col-lg-4">
                        <div class="beach-card">
                            <div class="beach-card-header">
                                <i class="fas fa-money-bill-wave mr-2"></i> Pembayaran
                            </div>
                            <div class="beach-card-body">
                                <div class="form-group row mb-3">
                                    <label class="col-sm-4 col-form-label">Bayar</label>
                                    <div class="col-sm-8">
                                        <input type="number" name="bayar"
                                            class="form-control form-control-sm text-right"
                                            id="bayar">
                                    </div>
                                </div>
                                <div class="kembalian-box">
                                    <div class="kem-label">Kembalian</div>
                                    <div class="kem-value" id="kembalianDisplay">Rp 0</div>
                                    <input type="hidden" name="kembalian" id="kembalian">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Simpan -->
                    <div class="col-lg-4 d-flex align-items-center">
                        <button type="submit" name="simpan" id="simpan" class="btn-beach-save">
                            <i class="fa fa-save mr-2"></i> Simpan Penjualan
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </section>

    <script>
        let barcode        = document.getElementById('barcode');
        let tgl            = document.getElementById('tglNota');
        let qty            = document.getElementById('qty');
        let harga          = document.getElementById('harga');
        let jmlHarga       = document.getElementById('jmlHarga');
        let bayar          = document.getElementById('bayar');
        let kembalian      = document.getElementById('kembalian');
        let kembalianDisplay = document.getElementById('kembalianDisplay');
        let total          = document.getElementById('total');

        barcode.addEventListener('change', function () {
            document.location.href = '?barcode=' + barcode.value + '&tgl=' + tgl.value;
        });

        qty.addEventListener('input', function () {
            jmlHarga.value = qty.value * harga.value;
        });

        bayar.addEventListener('input', function () {
            let kem = bayar.value - total.value;
            kembalian.value = kem;
            kembalianDisplay.textContent = 'Rp ' + Number(kem).toLocaleString('id-ID');
        });
    </script>

<?php require "../template/footer.php"; ?>
</div>