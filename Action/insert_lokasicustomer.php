<?php
include("../config.php"); // Memastikan file konfigurasi database di-include

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan nilai dari form
    $dockCustomer = $_POST['dockCustomerTambah'];
    $bpid= $_POST['bpidTambah'];
    $cycle = $_POST['cycleTambah'];
    $alamat = $_POST['alamatTambah'];
    $noTelepon = $_POST['noTeleponTambah'];
    $latitude = $_POST['latitudeTambah'];
    $longitude = $_POST['longitudeTambah'];
    $ins_usr = $_SESSION['id_usr']; // Asumsi ada session user yang login

   

    // Query untuk memasukkan data ke dalam database
    $sql = "INSERT INTO kyb_mslokasicustomer (kyb_dock_customer,kyb_bpid,kyb_cycle, kyb_alamat, 
    kyb_phonenumber, kyb_lat, kyb_longi, kyb_ins_usr,kyb_status, kyb_ins_dt) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1,NOW())";

    // Mempersiapkan prepared statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssissssi", $dockCustomer,$bpid,$cycle, $alamat, $noTelepon, $latitude, $longitude, $ins_usr);

        // Menjalankan statement
        if ($stmt->execute()) {
            echo "Data berhasil ditambahkan.";
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
