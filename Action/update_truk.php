<?php
include("../config.php"); // Pastikan file konfigurasi database di-include

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan nilai dari form
    $id = $_POST['updateIdtruk']; // Pastikan nama input hidden untuk ID sesuai dengan yang ada di form
    $UpdatenamaTruk = $_POST['UpdatenamaTruk'];
    $UpdateNumberPoliceFront = $_POST['UpdateNumberPoliceFront'];
    $UpdateNumberPoliceMiddle = $_POST['UpdateNumberPoliceMiddle'];
    $UpdateNumberPoliceBack = $_POST['UpdateNumberPoliceBack'];
    $UpdateNumberPolice = $UpdateNumberPoliceFront . " " . $UpdateNumberPoliceMiddle . " " . $UpdateNumberPoliceBack;
    $UpdatecapacityTruk = $_POST['UpdatecapacityTruk'];
    $UpdatejenisTruk = $_POST['UpdatejenisTruk'];
    $upd_usr = $_SESSION['id_usr']; // Asumsi ada session user yang login

    // Query untuk update data ke dalam database
    $sql = "UPDATE kyb_mstruk SET 
            kyb_namatruk = ?, 
            kyb_numberpolice = ?, 
            kyb_capacity = ?, 
            kyb_jenistruk = ?, 
            kyb_modi_usr = ?, 
            kyb_modi_dt = NOW() 
            WHERE kyb_idtruk = ?";

    // Mempersiapkan prepared statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssiisi", $UpdatenamaTruk, $UpdateNumberPolice, $UpdatecapacityTruk, $UpdatejenisTruk, $upd_usr, $id);

        // Menjalankan statement
        if ($stmt->execute()) {
            echo "Data berhasil diperbarui.";
            header("Location: ../Dashboard/view_truk.php"); // Redirect ke halaman view
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
