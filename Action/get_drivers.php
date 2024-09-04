<?php
include "../config.php"; // Include file konfigurasi database

if (isset($_POST['kyb_id_lokasicustomer'])) {
    $idLokasiCustomer = $_POST['kyb_id_lokasicustomer'];
    
    $sqlDrivers = "SELECT kyb_id_usr, kyb_nama_usr FROM kyb_msuser WHERE kyb_id_role = 1 AND kyb_id_lokasi_customer = ?";
    $stmt = $conn->prepare($sqlDrivers);
    $stmt->bind_param("i", $idLokasiCustomer);
    $stmt->execute();
    $stmt->bind_result($id_user, $name);
    
    $options = "<option selected>Pilih Driver</option>";
    while ($stmt->fetch()) {
        $options .= "<option value='" . $id_user . "'>" . $name . "</option>";
    }
    
    $stmt->close();
    echo $options;
}
?>
