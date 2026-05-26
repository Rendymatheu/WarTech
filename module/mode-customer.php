<?php

function insert($data)
{
    global $koneksi;

    $nama   = mysqli_real_escape_string($koneksi, $data['nama']);
    $telpon = mysqli_real_escape_string($koneksi, $data['telpon']);
    $alamat = mysqli_real_escape_string($koneksi, $data['alamat']);
    $ketr   = mysqli_real_escape_string($koneksi, $data['ketr']);

    $sqlCustomer = "INSERT INTO tbl_customer VALUES (
                        null,
                        '$nama',
                        '$telpon',
                        '$alamat',
                        '$ketr'
                    )";

    mysqli_query($koneksi, $sqlCustomer);

    return mysqli_affected_rows($koneksi);
}

function delete($id)
{
    global $koneksi;

    $sqlDelete = "DELETE FROM tbl_customer WHERE id_customer = $id";

    mysqli_query($koneksi, $sqlDelete);

    return mysqli_affected_rows($koneksi);
}

function update($data)
{
    global $koneksi;

    $id      = $data['id'];
    $nama    = mysqli_real_escape_string($koneksi, $data['nama']);
    $telpon  = mysqli_real_escape_string($koneksi, $data['telpon']);
    $alamat  = mysqli_real_escape_string($koneksi, $data['alamat']);
    $ketr    = mysqli_real_escape_string($koneksi, $data['ketr']);

    $sqlUpdate = "UPDATE tbl_customer SET
                    nama       = '$nama',
                    telpon     = '$telpon',
                    alamat     = '$alamat',
                    deskripsi  = '$ketr'
                  WHERE id_customer = '$id'";

    mysqli_query($koneksi, $sqlUpdate);

    return mysqli_affected_rows($koneksi);
}