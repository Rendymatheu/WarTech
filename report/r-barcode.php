<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Barcode</title>
</head>
<body>
    <?php
    $jmlCetak = $_GET["jmlCetak"];
    $barcode  = $_GET['barcode'];

    $path1 = __DIR__ . '/../../vendor/autoload.php';
    $path2 = __DIR__ . '/../asset/barcodeGenerator/vendor/autoload.php';
    $path3 = __DIR__ . '/../vendor/autoload.php';

    if (file_exists($path1)) {
        require $path1;
        echo "<!-- path1 ok -->";
    } elseif (file_exists($path2)) {
        require $path2;
        echo "<!-- path2 ok -->";
    } elseif (file_exists($path3)) {
        require $path3;
        echo "<!-- path3 ok -->";
    } else {
        die("❌ vendor/autoload.php tidak ditemukan!");
    }

    for ($i = 1; $i <= $jmlCetak; $i++) { ?>
        <div style="text-align:center; width:210px; float:left; margin-right:30px; margin-bottom:30px;">
            <?php
            $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
            echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcode, $generator::TYPE_CODE_128)) . '" width="200px">';
            ?>
            <div><?= $barcode ?></div>
        </div>
    <?php } ?>

    <script>window.print();</script>
</body>
</html>