<?php
include ("../Action/view_user.php");

?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Kelola Driver</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../Dashboard/dashboardFinishGood.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Kelola Sopir</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Sopir</h5>
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
                                            <th>Nama</th>
                                            <th>No Telepon</th>

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
                                                <td><?php echo $row['kyb_nama_usr'] ?></td>
                                                <td><?php echo $row['kyb_no_telp'] ?></td>

                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#updateDataModal"
                                                        data-id="<?php echo $row['kyb_id_usr']; ?>"
                                                        data-nama="<?php echo $row['kyb_nama_usr']; ?>"
                                                        data-telepon="<?php echo $row['kyb_no_telp']; ?>"
                                                        data-username="<?php echo $row['kyb_username']; ?>">Perbaharui</button>
                                                    <button type="button" class="btn btn-danger btn-sm delete-button"
                                                        data-id="<?php echo $row['kyb_id_usr']; ?>">Nonaktifkan</button>
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
                    <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Sopir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambahData" action="../Action/insert_user.php" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="namaDriver" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="namaDriver" name="namaDriver" required>
                        </div>
                        <div class="mb-3">
                            <label for="noTeleponDriver" class="form-label">No Telepon</label>
                            <input type="text" class="form-control" id="noTeleponDriver" name="noTeleponDriver"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="usernameDriver" class="form-label">Username</label>
                            <input type="text" class="form-control" id="usernameDriver" name="usernameDriver" required>
                        </div>
                        <div class="mb-3">
                            <label for="passwordDriver" class="form-label">Password</label>
                            <input type="password" class="form-control" id="passwordDriver" name="passwordDriver"
                                required>
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
                    <h5 class="modal-title" id="updateDataModalLabel">Perbaharui Data Sopir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formUpdateData" action="../Action/update_user.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="updateIdDriver" name="updateIdDriver">
                        <div class="mb-3">
                            <label for="updateNamaDriver" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="updateNamaDriver" name="updateNamaDriver"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="updateNoTeleponDriver" class="form-label">No Telepon</label>
                            <input type="text" class="form-control" id="updateNoTeleponDriver"
                                name="updateNoTeleponDriver" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateusernameDriver" class="form-label">Username</label>
                            <input type="text" class="form-control" id="updateusernameDriver"
                                name="updateusernameDriver" required>
                        </div>
                        <div class="mb-3">
                            <label for="updatepasswordDriver" class="form-label">Password</label>
                            <input type="password" class="form-control" id="updatepasswordDriver"
                                name="updatepasswordDriver" required>
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
            order: [], // Tambahkan ini untuk menonaktifkan pengurutan default
            columnDefs: [
                { orderable: false, targets: 3 } // Menonaktifkan pengurutan pada kolom "Aksi"
            ]
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        var updateModal = document.getElementById('updateDataModal');
        updateModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var nama = button.getAttribute('data-nama');
            var telepon = button.getAttribute('data-telepon');
            var username = button.getAttribute('data-username');

            var modalId = updateModal.querySelector('#updateIdDriver');
            var modalNama = updateModal.querySelector('#updateNamaDriver');
            var modalTelepon = updateModal.querySelector('#updateNoTeleponDriver');
            var modalUsername = updateModal.querySelector('#updateusernameDriver');

            modalId.value = id;
            modalNama.value = nama;
            modalTelepon.value = telepon;
            modalUsername.value = username;

            // Jika menggunakan form submit, tambahkan hidden field untuk ID
            var formUpdate = updateModal.querySelector('form');
            formUpdate.action = '../Action/update_user.php?id=' + id;
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        var deleteButtons = document.querySelectorAll('.delete-button');

        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var userId = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menonaktifkan user ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Nonaktifkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '../Action/delete_user.php',
                            type: 'POST',
                            data: { deleteId: userId },
                            dataType: 'json',
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Sukses!',
                                        text: response.message,
                                        icon: 'success',
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Gagal!',
                                        text: response.message,
                                        icon: 'error'
                                    });
                                }
                            },
                            error: function (xhr, status, error) {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat menghubungi server.',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            });
        });
    });
</script>