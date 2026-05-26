<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require "../config/config.php";
require "../config/functions.php";


$tgl1 = $_GET['tgl1'];
$tgl2 = $_GET['tgl2'];
$dataBeli = getData("SELECT * FROM tbl_beli_head WHERE tgl_beli 
BETWEEN '$tgl1' AND '$tgl2'");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, 
    initial-scale=1.0">
    <title>Laporan Pembelian</title>

    <style>
    table{
        width: 100%;
        border-collapse: collapse;
    }

    th, td{
        padding: 5px 10px;
    }

    .center{
        text-align: center;
    }

    .right{
        text-align: right;
    }
</style>
</head>
<body>
    
    <div style="text-align: center;">
        <h2 style="margin-bottom: -15px;">Rekap Laporan Pembelian</h2>
        <h2 style="margin-bottom: 15px;">POS</h2>
    </div>

    <table>
        <thead>
            <tr>
                <td colspan="5" style="height: 5px;">
                    <hr style="margin-bottom: 2px; margin-left: 
                    -5px;", size="3", color="grey">
                </td>
            </tr>
            <tr>
                <th style="width: 5%;">No</th>

                <th style="width: 20%;">
                    Tgl Pembelian
                </th>

                <th style="width: 20%;">
                    ID Pembelian
                </th>

                <th style="width: 35%;">
                    Suplier
                </th>

                <th style="width: 20%;">
                    Total Pembelian
                </th>
            </tr>
            <tr>
                <td colspan="5" style="height: 5px;">
                    <hr style="margin-bottom: 2px; margin-left: 
                    -5px; margin-top: 1px;", size="3", color="grey">
                </td>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($dataBeli as $data){ ?>
                <tr>
                    <td class="center"><?= $no++ ?></td>
                    <td class="center"><?= in_date($data['tgl_beli']) ?></td>
                    <td class="center"><?= $data['no_beli'] ?></td>
                    <td class="center"><?= $data['suplier'] ?></td>
                    <td class="center"><?= number_format($data['total'],0,',','.') ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="height: 5px;">
                    <hr style="margin-bottom: 2px; margin-left: 
                    -5px; margin-top: 1px;", size="3", color="grey">
                </td>
            </tr>
        </tfoot>
    </table>

    <script>
        window.print();
    </script>

</body>
</html>
