<?php
include("../config.php"); // Pastikan file konfigurasi database di-include

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan nilai dari form
    $id = $_POST['updateIdlokasicustomer']; // Pastikan nama input hidden untuk ID sesuai dengan yang ada di form
    $dockCustomer = $_POST['dockCustomerUpdate'];
    $bpid = $_POST['bpidUpdate'];
    $cycle = $_POST['cycleUpdate'];
    $alamat = $_POST['alamatUpdate'];
    $noTelepon = $_POST['noTeleponUpdate'];
    $latitude = $_POST['latitudeUpdate'];
    $longitude = $_POST['longitudeUpdate'];
    $upd_usr = $_SESSION['id_usr']; // Asumsi ada session user yang login

    // Query untuk update data ke dalam database
    $sql = "UPDATE kyb_mslokasicustomer SET 
            kyb_dock_customer = ?,
            kyb_bpid = ? ,
            kyb_cycle = ?, 
            kyb_alamat = ?, 
            kyb_phonenumber = ?, 
            kyb_lat = ?, 
            kyb_longi = ?, 
            kyb_modi_usr = ?, 
            kyb_modi_dt = NOW() 
            WHERE kyb_id_lokasicustomer = ?";

    // Mempersiapkan prepared statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssissssii", $dockCustomer,$bpid, $cycle, $alamat, $noTelepon, $latitude, $longitude, $upd_usr, $id);

        // Menjalankan statement
        if ($stmt->execute()) {
            echo "Data berhasil diperbarui.";
            header("Location: ../Dashboard/view_lokasicustomer.php"); // Redirect ke halaman view
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
