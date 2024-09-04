<?php
include ("../Action/view_preparationbarang.php");
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Persiapan Delivery</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../Dashboard/dashboardFinishGood.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Persiapan Delivery</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Persiapan Delivery</h5>
                        <div class="row mb-3">
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#tambahDataModal">Persiapan Delivery</button>
                            </div>
                        </div>
                        <div class="container mt-3">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Dock Kayaba</th>
                                            <th>Jumlah Palet</th>
                                            <th>BPID</th>
                                            <th>Rencana Pengiriman</th>
                                            <th>Alamat</th>
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
                                                <td><?php echo $row['kyb_dock_kybi'] ?></td>
                                                <td><?php echo $row['kyb_qty_palet'] ?></td>
                                                <td><?php echo $row['kyb_bpid'] ?></td>
                                                <td><?php echo $row['kyb_plan_arrival'] ?></td>
                                                <td><?php echo $row['kyb_alamat'] ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-info btn-sm detail-button"
                                                        data-id="<?php echo $row['kyb_id_palet']; ?>">Detail</button>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataModalLabel">Persiapan Delivery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambahData">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="dock_customer" class="form-label">Customer</label>
                            <select class="form-select" id="dock_customer" name="dock_customer"
                                aria-label="Default select example">
                                <option selected>Pilih</option>
                                <?php
                                $q_res = $conn->query("SELECT * FROM kyb_mslokasicustomer");
                                while ($role_row = $q_res->fetch_assoc()) {
                                    $id = $role_row['kyb_id_lokasicustomer'];
                                    $jenis_barang = $role_row['kyb_dock_customer'];
                                    $bpid = $role_row['kyb_bpid'];
                                    $alamat = $role_row['kyb_alamat'];
                                    echo "<option value='" . $id . "' data-bpid='" . $jenis_barang . "' data-alamat='" . $alamat . "'>" . $bpid . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="updateBPID" class="form-label">Dock Customer</label>
                            <input type="text" class="form-control" id="updateBPID" name="updateBPID" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="updateAlamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="updateAlamat" name="updateAlamat" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="driver" class="form-label">Driver</label>
                            <select class="form-select" id="driver" name="driver" aria-label="Default select example">
                                <option selected>Pilih Driver</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="updatePlanArrival" class="form-label">Plan Arrival</label>
                            <input type="datetime-local" class="form-control" id="updatePlanArrival"
                                name="updatePlanArrival" required>
                        </div>
                        <div class="mb-3">
                            <label for="dock_kybi" class="form-label">Dock Kayaba Indonesia</label>
                            <select class="form-select" id="dock_kybi" name="dock_kybi"
                                aria-label="Default select example">
                                <option selected>Pilih</option>
                                <option value="Dock 1">Dock 1</option>
                                <option value="Dock 2">Dock 2</option>
                                <option value="Dock 3">Dock 3</option>
                                <option value="Dock 4">Dock 4</option>
                                <option value="Dock 5">Dock 5</option>
                                <option value="Dock 6">Dock 6</option>
                                <option value="Dock 7">Dock 7</option>
                                <option value="Dock 8">Dock 8</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="searchBarang" class="form-label">Cari/Scan Barcode Barang</label>
                            <input type="text" class="form-control" id="searchBarang"
                                placeholder="Masukkan nama atau scan barcode" autocomplete="off">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="keranjangTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Barang yang ditambahkan akan muncul di sini -->
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-3">
                            <label for="updateQuantity" class="form-label">Jumlah Pallet</label>
                            <input type="number" class="form-control" id="updateQuantity" name="updateQuantity">
                        </div>

                        <input type="hidden" id="keranjang" name="keranjang">
                        <div class="mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="detailDataModal" tabindex="-1" aria-labelledby="detailDataModalLabel"
        aria-hidden="true">
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
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
            order: [],
            columnDefs: [
                { orderable: false, targets: 5 } // Menonaktifkan pengurutan pada kolom pertama dan terakhir
            ],
            initComplete: function () {
                var api = this.api();
                // Gunakan header dari baris kedua dalam thead untuk event input filter
                $('.table thead tr:eq(1) th').each(function (i) {
                    var column = api.column(i);
                    $('input', this).on('keyup change clear', function () {
                        if (column.search() !== this.value) {
                            column
                                .search(this.value)
                                .draw();
                        }
                    });
                });
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const formTambahData = document.getElementById('formTambahData');
        const searchInput = document.getElementById('searchBarang');
        const keranjangTableBody = document.querySelector('#keranjangTable tbody');
        const totalQuantityInput = document.getElementById('updateQuantity');
        let keranjang = [];

        searchInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                const query = searchInput.value;
                if (query.length > 0) {
                    fetchBarang(query);
                }
            }
        });

        function fetchBarang(query) {
            fetch(`../Action/search_barang.php?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        addToKeranjang(data[0]); // Tambahkan barang pertama yang ditemukan
                    } else {
                        Swal.fire('Barang tidak ditemukan');
                    }
                })
                .catch(error => console.error('Error fetching barang:', error));
        }

        function addToKeranjang(barang) {
            const exists = keranjang.find(item => item.kyb_id_barang === barang.kyb_id_barang);
            if (exists) {
                if (exists.jumlah + 1 > barang.kyb_jumlah_barang) {
                    Swal.fire('Jumlah barang melebihi batas');
                } else {
                    exists.jumlah += 1;
                }
            } else {
                if (1 > barang.kyb_jumlah_barang) {
                    Swal.fire('Jumlah barang melebihi batas');
                } else {
                    keranjang.push({ ...barang, jumlah: 1 });
                    updateTotalQuantity(1);
                }
            }
            renderKeranjang();
            searchInput.value = ''; // Kosongkan input setelah menambah barang
        }

        function removeFromKeranjang(id) {
            const itemToRemove = keranjang.find(item => item.kyb_id_barang === id);
            if (itemToRemove) {
                keranjang = keranjang.filter(item => item.kyb_id_barang !== id);
                updateTotalQuantity(-1); // Kurangi 1 dari jumlah palet setiap kali barang dihapus
            }
            renderKeranjang();
        }

        function renderKeranjang() {
            keranjangTableBody.innerHTML = '';
            keranjang.forEach((item, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${index + 1}</td>
                <td>${item.kyb_nama_barang}</td>
                <td><input type="number" class="form-control jumlah-barang" data-id="${item.kyb_id_barang}" data-stok="${item.kyb_jumlah_barang}" value="${item.jumlah}" min="1"></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-button" data-id="${item.kyb_id_barang}">Hapus</button></td>
            `;
                keranjangTableBody.appendChild(row);
            });
            attachEventListeners();
        }

        function attachEventListeners() {
            const removeButtons = document.querySelectorAll('.remove-button');
            const jumlahInputs = document.querySelectorAll('.jumlah-barang');

            removeButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    removeFromKeranjang(id);
                });
            });

            jumlahInputs.forEach(input => {
                input.addEventListener('change', function () {
                    const id = this.getAttribute('data-id');
                    const stok = parseInt(this.getAttribute('data-stok'));
                    const newJumlah = parseInt(this.value);
                    const item = keranjang.find(item => item.kyb_id_barang === id);
                    if (item) {
                        if (newJumlah > stok) {
                            Swal.fire('Jumlah barang melebihi batas');
                            this.value = item.jumlah; // Kembalikan ke jumlah sebelumnya
                        } else {
                            item.jumlah = newJumlah;
                        }
                    }
                });
            });
        }

        function updateTotalQuantity(change) {
            const currentTotal = parseInt(totalQuantityInput.value) || 0;
            totalQuantityInput.value = currentTotal + change;
        }

        formTambahData.addEventListener('submit', function (e) {
            e.preventDefault();

            const dock_kybi = document.getElementById('dock_kybi').value;
            const updateQuantity = totalQuantityInput.value;

            if (!dock_kybi) {
                Swal.fire('Dock Kayaba Indonesia tidak boleh kosong');
                return;
            }

            if (!updateQuantity || updateQuantity <= 0) {
                Swal.fire('Quantity Pallet tidak boleh kosong atau kurang dari 1');
                return;
            }

            document.getElementById('keranjang').value = JSON.stringify(keranjang);

            const formData = new FormData(this);

            fetch('../Action/insert_preparationbarang.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Data berhasil ditambahkan').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Terjadi kesalahan saat menyimpan data: ' + data.message);
                    }
                })
                .catch(error => console.error('Error saving data:', error));
        });

        var selectElement = document.getElementById('dock_customer');
        selectElement.addEventListener('change', function () {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var bpid = selectedOption.getAttribute('data-bpid');
            var alamat = selectedOption.getAttribute('data-alamat');

            document.getElementById('updateBPID').value = bpid;
            document.getElementById('updateAlamat').value = alamat;

            // Fetch drivers based on selected customer location
            fetchDrivers(selectedOption.value);
        });

        function fetchDrivers(idLokasiCustomer) {
            fetch('../Action/get_drivers.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `kyb_id_lokasicustomer=${idLokasiCustomer}`
            })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('driver').innerHTML = data;
                })
                .catch(error => console.error('Error fetching drivers:', error));
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        var detailButtons = document.querySelectorAll('.detail-button');

        detailButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var preparationId = this.getAttribute('data-id');
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
                            <th>Nama Barang</th>
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
                        detailContent.innerHTML = '<p>Tidak ada detail barang untuk ID ini.</p>';
                    }
                    var detailDataModal = new bootstrap.Modal(document.getElementById('detailDataModal'));
                    detailDataModal.show();
                })
                .catch(error => console.error('Error fetching detail:', error));
        }
    });
</script>