<?php
include ("../config.php"); // Memastikan file konfigurasi database di-include

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan nilai dari form
    $namaTruk = $_POST['namaTrukAbsensi'];
    $numberPoliceFront = $_POST['numberPoliceFrontAbsensi'];
    $numberPoliceMiddle = $_POST['numberPoliceMiddleAbsensi'];
    $numberPoliceBack = $_POST['numberPoliceBackAbsensi'];
    $numberPolice = $numberPoliceFront . " " . $numberPoliceMiddle . " " . $numberPoliceBack;
    $capacityTruk = $_POST['capacityTrukAbsensi'];
    $jenisTruk = $_POST['jenisTrukAbsensi'];
    $ins_usr = $_SESSION['id_usr']; // Asumsi ada session user yang login

    // Query untuk memasukkan data ke dalam database
    $sql = "INSERT INTO kyb_mstruk (kyb_namatruk, kyb_capacity, kyb_jenistruk, kyb_numberpolice, kyb_ins_usr, kyb_ins_dt, kyb_status) 
            VALUES (?, ?, ?, ?, ?, NOW(), 1)";

    // Mempersiapkan prepared statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("siisi", $namaTruk, $capacityTruk, $jenisTruk, $numberPolice, $ins_usr);

        // Menjalankan statement
        if ($stmt->execute()) {
            echo "Data berhasil ditambahkan.";
            
            header("Location: ../Dashboard/view_absensikedatangantruk.php"); // Redirect ke halaman view
            exit(); // Pastikan tidak ada kode yang dieksekusi setelah redirect
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
