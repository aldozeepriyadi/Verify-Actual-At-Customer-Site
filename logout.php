<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../"); // Redirect jika belum login
    exit();
}

// Hapus semua data sesi
session_destroy();

// Redirect ke halaman login dengan pesan sukses
header("Location: ../");
exit();
?>