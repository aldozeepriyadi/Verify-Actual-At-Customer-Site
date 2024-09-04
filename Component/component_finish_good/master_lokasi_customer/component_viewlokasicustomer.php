<?php
include ("../Action/view_lokasicustomer.php");
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Kelola Lokasi Pelanggan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../Dashboard/dashboardFinishGood.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Kelola Lokasi Pelanggan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Lokasi Pelanggan</h5>
                        <div class="row mb-3">
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#tambahDataModal">Tambah Data</button>
                            </div>
                        </div>
                        <div class="container mt-3">
                            <div class="table-responsive">
                                <!-- Table with stripped rows -->
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Dock Customer</th>
                                            <th>Cycle</th>
                                            <th>Alamat</th>
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
                                                <td><?php echo $row['kyb_dock_customer'] ?></td>
                                                <td><?php echo $row['kyb_cycle'] ?></td>
                                                <td><?php echo $row['kyb_alamat'] ?></td>
                                                <td><?php echo $row['kyb_phonenumber'] ?></td>
                                                <td>
                                                    <div class="mb-3">
                                                        <button type="button" class="btn btn-warning btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#updateDataModal"
                                                            data-id="<?php echo $row['kyb_id_lokasicustomer']; ?>"
                                                            data-dockcustomer="<?php echo $row['kyb_dock_customer']; ?>"
                                                            data-bpid="<?php echo $row['kyb_bpid']; ?>"
                                                            data-cycle="<?php echo $row['kyb_cycle']; ?>"
                                                            data-alamat="<?php echo $row['kyb_alamat']; ?>"
                                                            data-notel="<?php echo $row['kyb_phonenumber']; ?>"
                                                            data-latitude="<?php echo $row['kyb_lat']; ?>"
                                                            data-longitude="<?php echo $row['kyb_longi']; ?>"><i
                                                                class="fas fa-edit"></i>Perbaharui</button>
                                                    </div>
                                                    <div class="mb-3">
                                                        <button type="button" class="btn btn-secondary btn-sm status-button"
                                                            data-id="<?php echo $row['kyb_id_lokasicustomer']; ?>"
                                                            data-status="<?php echo $row['kyb_status']; ?>"><?php echo $row['kyb_status'] == 1 ? 'Non-Aktifkan' : 'Aktifkan'; ?></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div><!-- End Table with stripped rows -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahDataModalLabel">Tambah Lokasi Pelanggan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formTambahData" action="../Action/insert_lokasicustomer.php" method="post">
                        <div class="modal-body">
                            <!-- Map container -->
                            <div id="mapTambah" style="height: 180px;"></div>
                            <div class="mb-3">
                                <label for="latitudeTambah" class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="latitudeTambah" name="latitudeTambah"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="longitudeTambah" class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="longitudeTambah" name="longitudeTambah"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="alamatTambah" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamatTambah" name="alamatTambah" required>
                            </div>
                            <div class="mb-3">
                                <label for="dockCustomerTambah" class="form-label">Dock Customer</label>
                                <input type="text" class="form-control" id="dockCustomerTambah"
                                    name="dockCustomerTambah" required>
                            </div>
                            <div class="mb-3">
                                <label for="bpidTambah" class="form-label">BPID</label>
                                <input type="text" class="form-control" id="bpidTambah" name="bpidTambah" required>
                            </div>
                            <div class="mb-3">
                                <label for="cycleTambah" class="form-label">Cycle</label>
                                <input type="text" class="form-control" id="cycleTambah" name="cycleTambah" required>
                            </div>
                            <div class="mb-3">
                                <label for="noTeleponTambah" class="form-label">No Telepon</label>
                                <input type="text" class="form-control" id="noTeleponTambah" name="noTeleponTambah"
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
                        <h5 class="modal-title" id="updateDataModalLabel">Update Data Lokasi Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formUpdateData" action="../Action/update_lokasicustomer.php" method="post">
                        <div class="modal-body">
                            <input type="hidden" id="updateIdlokasicustomer" name="updateIdlokasicustomer">
                            <!-- Map container -->
                            <div id="mapUpdate" style="height: 180px;"></div>
                            <div class="mb-3">
                                <label for="latitudeUpdate" class="form-label">Garis Lintang</label>
                                <input type="text" class="form-control" id="latitudeUpdate" name="latitudeUpdate"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="longitudeUpdate" class="form-label">Garis Bujur</label>
                                <input type="text" class="form-control" id="longitudeUpdate" name="longitudeUpdate"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="alamatUpdate" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamatUpdate" name="alamatUpdate" required>
                            </div>
                            <div class="mb-3">
                                <label for="dockCustomerUpdate" class="form-label">Dock Customer</label>
                                <input type="text" class="form-control" id="dockCustomerUpdate"
                                    name="dockCustomerUpdate" required>
                            </div>
                            <div class="mb-3">
                                <label for="bpidUpdate" class="form-label">BPID</label>
                                <input type="text" class="form-control" id="bpidUpdate" name="bpidUpdate" required>
                            </div>
                            <div class="mb-3">
                                <label for="cycleUpdate" class="form-label">Cycle</label>
                                <input type="text" class="form-control" id="cycleUpdate" name="cycleUpdate" required>
                            </div>
                            <div class="mb-3">
                                <label for="noTeleponUpdate" class="form-label">No Telepon</label>
                                <input type="text" class="form-control" id="noTeleponUpdate" name="noTeleponUpdate"
                                    required>
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
    </section>
    <!-- Modal Tambah Data -->
</main><!-- End #main -->
x
<script>
    $(document).ready(function () {
        var table = $('.table').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/id.json' // Lokalisasi Bahasa Indonesia
            },
            orderCellsTop: true,
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });

        $('.status-button').on('click', function () {
            var locId = $(this).data('id');
            var currentStatus = $(this).data('status');
            var newStatus = currentStatus === 'Aktif' ? 'Non-Aktif' : 'Aktif';

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Anda akan mengubah lokasi ini menjadi ${newStatus}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, ubah!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../Action/delete_lokasicustomer.php',
                        method: 'POST',
                        data: {
                            statusId: locId,
                            newStatus: newStatus
                        },
                        success: function (response) {
                            Swal.fire(
                                'Berhasil!',
                                'Status lokasi telah diubah.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr, status, error) {
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat mengubah status lokasi.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        initializeMap('mapTambah', 'latitudeTambah', 'longitudeTambah', 'alamatTambah');
    });

    function initializeMap(mapId, latId, lngId, addrId, lat = null, lng = null) {
        var map = L.map(mapId).setView([lat || -6.175110, lng || 106.865039], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var customIcon = L.icon({
            iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        var marker;

        // Check if we have existing coordinates
        if (lat && lng) {
            var existingLatlng = new L.LatLng(lat, lng);
            marker = L.marker(existingLatlng, { icon: customIcon }).addTo(map);
            map.setView(existingLatlng, 13); // Adjust zoom level as needed
        }

        map.on('click', function (e) {
            var coord = e.latlng;
            if (marker) {
                marker.setLatLng(coord);
            } else {
                marker = L.marker(coord, { icon: customIcon }).addTo(map);
            }

            document.getElementById(latId).value = coord.lat.toFixed(6);
            document.getElementById(lngId).value = coord.lng.toFixed(6);
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${coord.lat}&lon=${coord.lng}&zoom=18`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById(addrId).value = data.display_name;
                })
                .catch(error => console.error('Error fetching address:', error));
        });

        // Add Leaflet Control Geocoder
        L.Control.geocoder({
            defaultMarkGeocode: false
        }).on('markgeocode', function (e) {
            var coord = e.geocode.center;
            if (marker) {
                marker.setLatLng(coord);
            } else {
                marker = L.marker(coord, { icon: customIcon }).addTo(map);
            }

            map.setView(coord, 13); // Adjust zoom level as needed

            document.getElementById(latId).value = coord.lat.toFixed(6);
            document.getElementById(lngId).value = coord.lng.toFixed(6);
            document.getElementById(addrId).value = e.geocode.name;
        }).addTo(map);
    }

    document.addEventListener('DOMContentLoaded', function () {
        var updateModal = document.getElementById('updateDataModal');
        updateModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var id = button.getAttribute('data-id');
            var dockCustomer = button.getAttribute('data-dockcustomer');
            var cycle = button.getAttribute('data-cycle');
            var alamat = button.getAttribute('data-alamat');
            var noTelepon = button.getAttribute('data-notel');
            var latitude = button.getAttribute('data-latitude');
            var longitude = button.getAttribute('data-longitude');
            var bpid = button.getAttribute('data-bpid');

            // Update the modal's content.
            var modalId = updateModal.querySelector('#updateIdlokasicustomer');
            var modalDockCustomer = updateModal.querySelector('#dockCustomerUpdate');
            var modalCycle = updateModal.querySelector('#cycleUpdate');
            var modalAlamat = updateModal.querySelector('#alamatUpdate');
            var modalNoTelepon = updateModal.querySelector('#noTeleponUpdate');
            var modalLatitude = updateModal.querySelector('#latitudeUpdate');
            var modalLongitude = updateModal.querySelector('#longitudeUpdate');
            var modalBpid = updateModal.querySelector('#bpidUpdate');

            modalId.value = id;
            modalDockCustomer.value = dockCustomer;
            modalCycle.value = cycle;
            modalAlamat.value = alamat;
            modalNoTelepon.value = noTelepon;
            modalLatitude.value = latitude;
            modalLongitude.value = longitude;
            modalBpid.value = bpid;

            initializeMap('mapUpdate', 'latitudeUpdate', 'longitudeUpdate', 'alamatUpdate', latitude, longitude);
        });
    });
</script>