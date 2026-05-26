<?php

function uploadimg($url = null, $name = null)
{
    $namafile = $_FILES['image']['name'];
    $ukuran   = $_FILES['image']['size'];
    $tmp      = $_FILES['image']['tmp_name'];

    // Validasi ekstensi gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'gif'];
    $ekstensiGambar = explode('.', $namafile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {

        if ($url != null) {

            echo '<script>
                    alert("File yang anda upload bukan gambar!");
                    document.location.href="' . $url . '";
                  </script>';
            die();

        } else {

            echo '<script>
                    alert("File yang anda upload bukan gambar!");
                  </script>';
            return false;
        }
    }

    // Validasi ukuran max 1MB
    if ($ukuran > 1000000) {

        if ($url != null) {

            echo '<script>
                    alert("Ukuran gambar melebihi 1 MB!");
                    document.location.href="' . $url . '";
                  </script>';
            die();

        } else {

            echo '<script>
                    alert("Ukuran gambar tidak boleh melebihi 1 MB!");
                  </script>';
            return false;
        }
    }

    // Nama file baru
    if ($name != null) {
        $namaFileBaru = $name . '.' . $ekstensiGambar;
    } else {
        $namaFileBaru = rand(10, 1000) . '-' . $namafile;
    }

    move_uploaded_file($tmp, '../asset/image/' . $namaFileBaru);

    return $namaFileBaru;
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