<?php
include ("../Action/view_truk.php");
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Kelola Truk</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../Dashboard/dashboardFinishGood.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Kelola Truk</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Truk</h5>
                        <div class="row mb-3">
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#tambahDataModal">Tambah Data</button>
                            </div>
                        </div>

                        <!-- Table with stripped rows -->
                        <div class="container mt-3">
                            <div class="table-responsive">
                                <!-- Table with stripped rows -->
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Truk</th>
                                            <th>Kapasitas</th>
                                            <th>Jenis Truk</th>
                                            <th>Nomor Polisi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i ?></td>
                                                <td><?php echo $row['kyb_namatruk'] ?></td>
                                                <td><?php echo $row['kyb_capacity'] ?></td>
                                                <td><?php echo $row['kyb_jenis_truk'] ?></td>
                                                <td><?php echo $row['kyb_numberpolice'] ?></td>
                                                <td>
                                                    <div class="mb-3">
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#updateDataModal"
                                                            data-id="<?php echo $row['kyb_idtruk']; ?>"
                                                            data-nama="<?php echo $row['kyb_namatruk']; ?>"
                                                            data-capacity="<?php echo $row['kyb_capacity']; ?>"
                                                            data-jenis="<?php echo $row['kyb_jenistruk']; ?>"
                                                            data-numberpolice="<?php echo $row['kyb_numberpolice']; ?>">Perbaharui</button>
                                                    </div>
                                                    <div class="mb-3">
                                                        <button type="button" class="btn btn-warning btn-sm status-button"
                                                            data-id="<?php echo $row['kyb_idtruk']; ?>"
                                                            data-status="<?php echo $row['kyb_status']; ?>"><?php echo $row['kyb_status'] == 1 ? 'Non-Aktifkan' : 'Aktifkan'; ?></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php

                                            $i++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>
            </div>

        </div>

    </section>

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Truk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambahData" action="../Action/insert_truk.php" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="namaTruk" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="namaTruk" name="namaTruk" required>
                        </div>
                        <div class="mb-3">
                            <label for="numberPoliceFront" class="form-label">Nomor Polisi</label>
                            <div class="d-flex">
                                <input type="text" class="form-control me-2" id="numberPoliceFront"
                                    name="numberPoliceFront" maxlength="1" required>
                                <input type="text" class="form-control me-2" id="numberPoliceMiddle"
                                    name="numberPoliceMiddle" maxlength="4" required>
                                <input type="text" class="form-control" id="numberPoliceBack" name="numberPoliceBack"
                                    maxlength="3" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="capacityTruk" class="form-label">Kapasitas</label>
                            <input type="number" class="form-control" id="capacityTruk" name="capacityTruk" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenisTruk" class="form-label">Jenis Truk</label>
                            <select class="form-select" id="jenisTruk" name="jenisTruk"
                                aria-label="Default select example">
                                <option selected>Pilih</option>
                                <?php
                                $q_res = $conn->query("SELECT kyb_idjenistruk, kyb_jenis_truk FROM kyb_msjenistruk");
                                while ($role_row = $q_res->fetch_assoc()) {
                                    $id = $role_row['kyb_idjenistruk'];
                                    $jenis_barang = $role_row['kyb_jenis_truk'];
                                    echo "<option value='" . $id . "'>" . $jenis_barang . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Modal Update Data -->
    <div class="modal fade" id="updateDataModal" tabindex="-1" aria-labelledby="updateDataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateDataModalLabel">Perbaharui Data Driver</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formUpdateData" action="../Action/update_truk.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="updateIdtruk" name="updateIdtruk">
                        <div class="mb-3">
                            <label for="UpdatenamaTruk" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="UpdatenamaTruk" name="UpdatenamaTruk" required>
                        </div>
                        <div class="mb-3">
                            <label for="UpdateNumberPoliceFront" class="form-label">Nomor Polisi</label>
                            <div class="d-flex">
                                <input type="text" class="form-control me-2" id="UpdateNumberPoliceFront"
                                    name="UpdateNumberPoliceFront" maxlength="1" required>
                                <input type="text" class="form-control me-2" id="UpdateNumberPoliceMiddle"
                                    name="UpdateNumberPoliceMiddle" maxlength="4" required>
                                <input type="text" class="form-control" id="UpdateNumberPoliceBack"
                                    name="UpdateNumberPoliceBack" maxlength="3" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="UpdatecapacityTruk" class="form-label">Kapasitas</label>
                            <input type="number" class="form-control" id="UpdatecapacityTruk" name="UpdatecapacityTruk"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="UpdatejenisTruk" class="form-label">Jenis Truk</label>
                            <select class="form-select" id="UpdatejenisTruk" name="UpdatejenisTruk"
                                aria-label="Default select example">
                                <option selected>Pilih</option>
                                <?php
                                $q_res = $conn->query("SELECT kyb_idjenistruk, kyb_jenis_truk FROM kyb_msjenistruk");
                                while ($role_row = $q_res->fetch_assoc()) {
                                    $id = $role_row['kyb_idjenistruk'];
                                    $jenis_barang = $role_row['kyb_jenis_truk'];
                                    echo "<option value='" . $id . "'>" . $jenis_barang . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</main><!-- End #main -->

<script>
    $(document).ready(function () {
        var table = $('.table').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/id.json' // Lokalisasi Bahasa Indonesia
            },
            orderCellsTop: true,
            order: [], // Tambahkan ini untuk menonaktifkan pengurutan default
            columnDefs: [
                { orderable: false, targets: 5 } // Menonaktifkan pengurutan pada kolom "Aksi"
            ]
        });

        $('.status-button').on('click', function () {
            var truckId = $(this).data('id');
            var currentStatus = $(this).data('status');
            var newStatus = currentStatus === 'Aktif' ? 'Non-Aktif' : 'Aktif';

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Anda akan mengubah truk ini menjadi ${newStatus}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, ubah!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../Action/delete_truk.php',
                        method: 'POST',
                        data: {
                            statusId: truckId,
                            newStatus: newStatus
                        },
                        success: function (response) {
                            Swal.fire(
                                'Berhasil!',
                                'Status truk telah diubah.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr, status, error) {
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat mengubah status truk.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        var updateModal = document.getElementById('updateDataModal');
        updateModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var nama = button.getAttribute('data-nama');
            var capacity = button.getAttribute('data-capacity');
            var jenis = button.getAttribute('data-jenis');
            var numberPolice = button.getAttribute('data-numberpolice').split(' ');

            var modalId = updateModal.querySelector('#updateIdtruk');
            var modalNama = updateModal.querySelector('#UpdatenamaTruk');
            var modalCapacity = updateModal.querySelector('#UpdatecapacityTruk');
            var modalJenis = updateModal.querySelector('#UpdatejenisTruk');
            var modalNumberPoliceFront = updateModal.querySelector('#UpdateNumberPoliceFront');
            var modalNumberPoliceMiddle = updateModal.querySelector('#UpdateNumberPoliceMiddle');
            var modalNumberPoliceBack = updateModal.querySelector('#UpdateNumberPoliceBack');

            modalId.value = id;
            modalNama.value = nama;
            modalCapacity.value = capacity;
            modalJenis.value = jenis;
            modalNumberPoliceFront.value = numberPolice[0];
            modalNumberPoliceMiddle.value = numberPolice[1];
            modalNumberPoliceBack.value = numberPolice[2];

            // Jika menggunakan form submit, tambahkan hidden field untuk ID
            var formUpdate = updateModal.querySelector('form');
            formUpdate.action = '../Action/update_truk.php?id=' + id;
        });
    });
</script>