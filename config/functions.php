<?php

function uploadimg($url = null, $name = null) {
    $namafile = $_FILES['image']['name'];
    $ukuran   = $_FILES['image']['size'];
    $tmp      = $_FILES['image']['tmp_name'];

    $ekstensiValid = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($namafile, PATHINFO_EXTENSION));

    if (!in_array($ext, $ekstensiValid)) {
        echo "<script>alert('File bukan gambar!');</script>";
        return false;
    }

    if ($ukuran > 1000000) {
        echo "<script>alert('Ukuran gambar melebihi 1 MB!');</script>";
        return false;
    }

    // Upload ke Cloudinary
    $cloud     = getenv('CLOUDINARY_CLOUD_NAME');
    $key       = getenv('CLOUDINARY_API_KEY');
    $secret    = getenv('CLOUDINARY_API_SECRET');
    $timestamp = time();

    $publicId  = $name ?? pathinfo($namafile, PATHINFO_FILENAME) . '_' . $timestamp;
    $signature = sha1("public_id=$publicId&timestamp=$timestamp$secret");

    $data      = base64_encode(file_get_contents($tmp));
    $mime      = mime_content_type($tmp);

    $ch = curl_init("https://api.cloudinary.com/v1_1/$cloud/image/upload");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => [
            'file'      => "data:$mime;base64,$data",
            'public_id' => $publicId,
            'timestamp' => $timestamp,
            'api_key'   => $key,
            'signature' => $signature,
        ]
    ]);
    $res = json_decode(curl_exec($ch), true);
    curl_close($ch);

    return $res['secure_url'] ?? null;
}



function getData($sql)
{
    global $koneksi;

    $result = mysqli_query($koneksi, $sql);

    // Cek error query
    if (!$result) {
        die("Query Error : " . mysqli_error($koneksi));
    }

    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}



function userLogin()
{
    global $koneksi;

    if (!isset($_SESSION["ssUserPOS"])) {
        return null;
    }

    $userActive = $_SESSION["ssUserPOS"];

    $dataUser = getData("SELECT * FROM tbl_user WHERE username = '$userActive'");

    return isset($dataUser[0]) ? $dataUser[0] : null;
}



function userMenu()
{
    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $uri_segments = explode('/', trim($uri_path, '/'));

    return isset($uri_segments[1]) ? $uri_segments[1] : '';
}



function menuHome()
{
    return userMenu() == 'dashboard.php' ? 'active' : null;
}



function menuMaster()
{
    if (
        userMenu() == 'supplier' ||
        userMenu() == 'customer' ||
        userMenu() == 'barang'
    ) {
        return 'menu-is-opening menu-open';
    }

    return null;
}



function menuSetting()
{
    return userMenu() == 'user' ? 'menu-is-opening menu-open' : null;
}



function menuUser()
{
    return userMenu() == 'user' ? 'active' : null;
}



function menuSupplier()
{
    return userMenu() == 'supplier' ? 'active' : null;
}



function menuBarang()
{
    return userMenu() == 'barang' ? 'active' : null;
}



function menuBeli()
{
    return userMenu() == 'pembelian' ? 'active' : null;
}



function menuJual()
{
    return userMenu() == 'penjualan' ? 'active' : null;
}



function laporanStock()
{
    return userMenu() == 'stock' ? 'active' : null;
}



function laporanBeli()
{
    return userMenu() == 'laporan-pembelian' ? 'active' : null;
}



function laporanJual()
{
    return userMenu() == 'laporan-penjualan' ? 'active' : null;
}



function menuCustomer()
{
    return userMenu() == 'customer' ? 'active' : null;
}



function in_date($tgl)
{
    $tg  = substr($tgl, 8, 2);
    $bln = substr($tgl, 5, 2);
    $thn = substr($tgl, 0, 4);

    return $tg . "-" . $bln . "-" . $thn;
}



function omzet()
{
    global $koneksi;

    $queryOmzet = mysqli_query($koneksi, "SELECT SUM(total) as omzet FROM tbl_jual_head");

    // Cek error query
    if (!$queryOmzet) {
        die("Query Omzet Error : " . mysqli_error($koneksi));
    }

    $data = mysqli_fetch_assoc($queryOmzet);

    $totalOmzet = $data['omzet'] ?? 0;

    return number_format($totalOmzet, 0, ',', '.');
}