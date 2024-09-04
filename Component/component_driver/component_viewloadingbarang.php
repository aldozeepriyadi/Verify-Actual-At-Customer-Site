<?php
include ("../Action/view_loadingbarang.php");
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Loading Barang</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../Dashboard/dashboardDriver.php">Dashboard</a></li>
                <li class="breadcrumb-item active"> Loading Barang</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <?php if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['kyb_dock_kybi']); ?></h5>
                                <p class="card-text"><strong>Jumlah Barang:</strong>
                                    <?php echo htmlspecialchars($row['kyb_qty_palet']); ?></p>
                                <p class="card-text"><strong>Dock Pelanggan:</strong>
                                    <?php echo htmlspecialchars($row['kyb_dock_customer']); ?></p>
                                <div class="row mb-3">
                                    <div class="col">
                                        <button type="button" class="btn btn-warning btn-sm detail-button"
                                            data-bs-toggle="modal" data-bs-target="#detailDataModal"
                                            data-id="<?php echo htmlspecialchars($row['kyb_id_schedule']); ?>"
                                            data-keranjang="<?php echo htmlspecialchars($row['kyb_id_palet']); ?>">Rincian</button>
                                    </div>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" value="3"
                                        id="checkBarang<?php echo htmlspecialchars($row['kyb_id_schedule']); ?>"
                                        data-id="<?php echo htmlspecialchars($row['kyb_id_schedule']); ?>">
                                    <label class="form-check-label"
                                        for="checkBarang<?php echo htmlspecialchars($row['kyb_id_schedule']); ?>">
                                        Barang lengkap dan siap
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>Tidak ada data yang ditemukan.</p>
            <?php } ?>
        </div>
    </section>
</main>

<!-- Modal untuk Menampilkan Detail Barang -->
<div class="modal fade" id="detailDataModal" tabindex="-1" aria-labelledby="detailDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailDataModalLabel">Detail Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Konten detail akan diisi dengan AJAX -->
                <div id="detailContent">
                    <!-- Data detail akan ditampilkan di sini -->
                </div>
            </div>
            <div class="modal-footer">
                <div class="mt-3">
                    <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var detailButtons = document.querySelectorAll('.detail-button');

        detailButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var preparationId = this.getAttribute('data-keranjang');
                fetchDetail(preparationId);
            });
        });

        function fetchDetail(id) {
            fetch(`../Action/view_detailbarang.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    var detailContent = document.getElementById('detailContent');
                    detailContent.innerHTML = '';
                    if (data.length > 0) {
                        var table = document.createElement('table');
                        table.classList.add('table', 'table-bordered', 'table-striped');
                        var thead = document.createElement('thead');
                        var tbody = document.createElement('tbody');

                        thead.innerHTML = `
                            <tr>
                                <th>No</th>
                                <th>Nama Pallet</th>
                                <th>Jumlah</th>
                            </tr>
                        `;

                        data.forEach((item, index) => {
                            var row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${index + 1}</td>
                                <td>${item.kyb_nama_barang}</td>
                                <td>${item.kuantitas}</td>
                            `;
                            tbody.appendChild(row);
                        });

                        table.appendChild(thead);
                        table.appendChild(tbody);
                        detailContent.appendChild(table);
                    } else {
                        detailContent.innerHTML = '<p>Tidak ada detail pallet untuk ID ini.</p>';
                    }
                })
                .catch(error => console.error('Error fetching detail:', error));
        }

        const checkboxes = document.querySelectorAll(".form-check-input");

        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener("change", function () {
                if (checkbox.checked) {
                    Swal.fire({
                        title: 'Apakah Anda Yakin?',
                        text: "Pastikan semua barang sudah lengkap!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Lanjutkan',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var scheduleId = checkbox.getAttribute('data-id');
                            var statusValue = checkbox.value;
                            updateStatus(scheduleId, statusValue);
                        } else {
                            checkbox.checked = false;
                        }
                    });
                }
            });
        });

        function updateStatus(id, value) {
            fetch(`../Action/insert_loadingbarang.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: id,
                    value: value
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            'Sukses!',
                            'Status berhasil diperbarui.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Gagal',
                            'Terjadi kesalahan saat memperbarui status.',
                            'error'
                        );
                    }
                })
                .catch(error => console.error('Error updating status:', error));
        }

        $('#detailDataModal').on('hidden.bs.modal', function () {
            var detailDataModal = bootstrap.Modal.getInstance(document.getElementById('detailDataModal'));
            if (detailDataModal) {
                detailDataModal.hide();
            }
            $('#detailContent').html('');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        });
    });
</script>
