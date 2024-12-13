<?php
date_default_timezone_set("Asia/Makassar");
$server = "localhost";
$username = "root";
$pass = "";
$db = "administrasi"; //sesuaikan nama databasenya
$koneksi = mysqli_connect($server, $username, $pass, $db); //pastikan urutan pemanggilan variabel nya sama.

//untuk cek jika koneksi gagal ke database
if (mysqli_connect_errno()) {
    echo "Koneksi gagal : " . mysqli_connect_error();
}

// Check if the function is already declared before declaring it
if (!function_exists('format_tanggal')) {
    function format_tanggal($waktu)
    {
        $hari_array = array(
            'Minggu',
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu'
        );
        $hr = date('w', strtotime($waktu));
        $hari = $hari_array[$hr];
        $tanggal = date('j', strtotime($waktu));
        $bulan_array = array(
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        );
        $bl = date('n', strtotime($waktu));
        $bulan = $bulan_array[$bl];
        $tahun = date('Y', strtotime($waktu));
        $jam = date('H:i:s', strtotime($waktu));

        //untuk menampilkan hari, tanggal bulan tahun jam
        //return "$hari, $tanggal $bulan $tahun $jam";

        //untuk menampilkan hari, tanggal bulan tahun$hari, 
        return "$tanggal/$bl/$tahun";
    }
}

// Check if the function is already declared before declaring it
if (!function_exists('rupiah')) {
    function rupiah($uang)
    {
        // Ensure the value is numeric; if not, set it to zero
        $uang = is_numeric($uang) ? $uang : 0;
        return number_format($uang, 0, ",", ".");
    }
}
