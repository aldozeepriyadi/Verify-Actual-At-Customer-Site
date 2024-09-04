<?php
include ("../Action/view_barang.php");
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Kelola Barang</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../Dashboard/dashboardFinishGood.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Kelola Barang</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Barang</h5>
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
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Jenis Barang</th>
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
                                                <td><?php echo $row['kyb_nama_barang'] ?></td>
                                                <td><?php echo $row['kyb_jumlah_barang'] ?></td>
                                                <td>
                                                    <?php echo $row['kyb_namajenis'] ?>
                                                </td>


                                                <td>
                                                    <div class="mb-3">
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#updateDataModal"
                                                            data-id="<?php echo $row['kyb_id_barang']; ?>"
                                                            data-nama="<?php echo $row['kyb_nama_barang']; ?>"
                                                            data-jenis="<?php echo $row['kyb_jenis_barang']; ?>"
                                                            data-jumlah="<?php echo $row['kyb_jumlah_barang']; ?>">Perbaharui</button>
                                                    </div>
                                                    <div class="mb-3">
                                                        <button type="button"
                                                            class="btn btn-<?php echo $row['kyb_status'] == 1 ? 'danger' : 'success'; ?> btn-sm delete-button"
                                                            data-id="<?php echo $row['kyb_id_barang']; ?>"><?php echo $row['kyb_status'] == 1 ? 'Nonaktifkan' : 'Aktifkan'; ?></button>
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
                    <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form id="formTambahData" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="namaBarang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="namaBarang" name="namaBarang" required>
                        </div>
                        <div class="mb-3">
                            <label for="jumlahBarang" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="jumlahBarang" name="jumlahBarang" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenisBarang" class="form-label">Jenis Barang</label>
                            <select class="form-select" id="jenisBarang" name="jenisBarang"
                                aria-label="Default select example">
                                <option selected>Pilih</option>
                                <?php
                                $q_res = $conn->query("SELECT kyb_id, kyb_namajenis FROM kyb_msjenisbarang");
                                while ($role_row = $q_res->fetch_assoc()) {
                                    $id = $role_row['kyb_id'];
                                    $jenis_barang = $role_row['kyb_namajenis'];
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
                    <h5 class="modal-title" id="updateDataModalLabel">Perbaharui Data Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formUpdateData" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="updateIdBarang" name="updateIdBarang">
                        <div class="mb-3">
                            <label for="updateNamaBarang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="updateNamaBarang" name="updateNamaBarang"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="updateJumlahBarang" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="updateJumlahBarang" name="updateJumlahBarang"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="updateJenisBarang" class="form-label">Jenis Barang</label>
                            <select class="form-select" id="updateJenisBarang" name="updateJenisBarang">
                                <option selected>Pilih</option>
                                <?php
                                $q_res = $conn->query("SELECT kyb_id, kyb_namajenis FROM kyb_msjenisbarang");
                                while ($role_row = $q_res->fetch_assoc()) {
                                    $id = $role_row['kyb_id'];
                                    $jenis_barang = $role_row['kyb_namajenis'];
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        var table = $('.table').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/id.json' // Lokalisasi Bahasa Indonesia
            },
            orderCellsTop: true,
            columnDefs: [
                { orderable: false, targets: 4 } // Menonaktifkan pengurutan pada kolom "Aksi"
            ],
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        var updateModal = document.getElementById('updateDataModal');
        updateModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var id = button.getAttribute('data-id');
            var nama = button.getAttribute('data-nama');
            var jumlah = button.getAttribute('data-jumlah');
            var jenis = button.getAttribute('data-jenis');

            var modalId = updateModal.querySelector('#updateIdBarang');
            var modalNama = updateModal.querySelector('#updateNamaBarang');
            var modalJumlah = updateModal.querySelector('#updateJumlahBarang');
            var modalJenis = updateModal.querySelector('#updateJenisBarang');

            modalId.value = id;
            modalNama.value = nama;
            modalJumlah.value = jumlah;
            modalJenis.value = jenis;
        });

        // Handle insert form submission
        $('#formTambahData').submit(function (event) {
            event.preventDefault();
            $.ajax({
                url: '../Action/insert_barang.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data berhasil ditambahkan.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function () {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat menambahkan data.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // Handle update form submission
        $('#formUpdateData').submit(function (event) {
            event.preventDefault();
            $.ajax({
                url: '../Action/update_barang.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data berhasil diperbarui.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function () {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat memperbarui data.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        var deleteButtons = document.querySelectorAll('.delete-button');
        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var userId = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Konfirmasi Ubah Status',
                    text: "Apakah Anda yakin ingin mengubah status data ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Ubah',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request to delete_barang.php
                        fetch('../Action/delete_barang.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ deleteId: userId })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire(
                                        'Berhasil!',
                                        data.message,
                                        'success'
                                    ).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'Gagal!',
                                        data.message,
                                        'error'
                                    );
                                }
                            })
                            .catch(error => {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat mengubah status data.',
                                    'error'
                                );
                            });
                    }
                });
            });
        });
    });
</script>