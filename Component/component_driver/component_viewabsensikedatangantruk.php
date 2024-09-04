<!-- component_viewabsensikedatangantruk.php -->
<?php
include ("../Action/view_absensikedatangantruk.php");
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Absensi Kedatangan Truk</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../Dashboard/dashboardDriver.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Absensi Kedatangan Truk</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <p class="card-text"><strong>Pelanggan:</strong> <?php echo $row['kyb_dock_customer']; ?>
                                    </p>
                                    <p class="card-text"><strong>Dock Kayaba:</strong> <?php echo $row['kyb_dock_kybi']; ?></p>
                                    <p class="card-text"><strong>Plan:</strong>
                                        <?php
                                        $dateTime = new DateTime($row['kyb_plan_arrival']);
                                        $formattedDate = $dateTime->format("d-m-Y");
                                        echo $formattedDate;
                                        ?>
                                    </p>
                                    <p class="card-text">
                                    <div class="row mb-3">
                                        <div class="col">
                                            <button type="button" class="btn btn-success btn-sm action-verifikasi"
                                                onclick="checkProximity('<?php echo $row['kyb_id_schedule']; ?>', '<?php echo $row['kyb_id_palet']; ?>')">Absen</button>
                                        </div>
                                    </div>
                                    </p>
                                    <input type="hidden" id="id_schedule" value="<?php echo $row['kyb_id_schedule']; ?>">
                                </h5>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No data found</p>";
            }
            ?>
        </div>
    </section>

    <section>
        <div class="modal fade" id="absensiModal" tabindex="-1" role="dialog" aria-labelledby="absensiModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="absensiModalLabel">Absensi Kedatangan</h5>
                        <button type="button" class="btn-close" onclick="stopWebcam()" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="absensiForm">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <div class="card-body">
                                            <h4 class="card-title">Absensi</h4>
                                            <div class="row mb-3">
                                                <video id="webcamVerify" autoplay playsinline></video>
                                            </div>
                                            <div class="row mb-3">
                                                <canvas id="imageCanvasVerify" width="640" height="480"></canvas>
                                            </div>
                                            <div class="mb-3">
                                                <label for="absensiTruck" class="form-label">Truk</label>
                                                <div class="input-group mb-3">
                                                    <select class="form-select" id="absensiTruck" name="absensiTruck"
                                                        aria-label="Default select example" required>
                                                        <option selected>Pilih</option>
                                                        <?php
                                                        $q_res = $conn->query("SELECT * from kyb_mstruk");
                                                        while ($role_row = $q_res->fetch_assoc()) {
                                                            $id = $role_row['kyb_idtruk'];
                                                            $nama_truk = $role_row['kyb_namatruk'];
                                                            $numberPolice = $role_row['kyb_numberpolice'];
                                                            $capacityTruk = $role_row['kyb_capacity'];
                                                            echo "<option value='" . $id . "' data-capacity='" . $capacityTruk . "'>" . $nama_truk . "\t-\t" . $numberPolice . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        data-bs-toggle="modal" data-bs-target="#tambahTrukModal">Tambah
                                                        Truk</button>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="updateCapacity" class="form-label">Kapasitas</label>
                                                <input type="number" class="form-control" id="updateCapacity"
                                                    name="updateCapacity" readonly required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="updateMaxcapacity" class="form-label">Maksimal
                                                    Kapasitas</label>
                                                <input type="number" class="form-control" id="updateMaxcapacity"
                                                    name="updateMaxcapacity" readonly required>
                                            </div>
                                            <input type="hidden" id="fotoBinary" name="fotoBinary">
                                            <input type="hidden" id="latitude" name="latitude">
                                            <input type="hidden" id="longitude" name="longitude">
                                            <input type="hidden" id="kyb_id_schedule" name="kyb_id_schedule">
                                            <input type="hidden" id="kyb_id_palet" name="kyb_id_palet">
                                        </div>
                                        <div class="border-top">
                                            <div class="card-body">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        id="toggleCameraBtn">
                                                        <i class="fas fa-camera"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-primary"
                                                        id="captureImageBtn">Tangkap Gambar</button>
                                                    <button type="button" class="btn btn-primary"
                                                        id="submitFormBtn">Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </section>

    <!-- Modal Tambah Truk -->
    <div class="modal fade" id="tambahTrukModal" tabindex="-1" role="dialog" aria-labelledby="tambahTrukModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahTrukModalLabel">Tambah Truk Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahTruk" method="post" action="../Action/insert_trukdriver.php">
                        <div class="mb-3">
                            <label for="namaTrukAbsensi" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="namaTrukAbsensi" name="namaTrukAbsensi"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="numberPoliceFrontAbsensi" class="form-label">Nomor Polisi</label>
                            <div class="d-flex">
                                <input type="text" class="form-control me-2" id="numberPoliceFrontAbsensi"
                                    name="numberPoliceFrontAbsensi" maxlength="1" required>
                                <input type="text" class="form-control me-2" id="numberPoliceMiddleAbsensi"
                                    name="numberPoliceMiddleAbsensi" maxlength="4" required>
                                <input type="text" class="form-control" id="numberPoliceBackAbsensi"
                                    name="numberPoliceBackAbsensi" maxlength="3" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="capacityTruk" class="form-label">Kapasitas</label>
                            <input type="number" class="form-control" id="capacityTrukAbsensi"
                                name="capacityTrukAbsensi" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenisTruk" class="form-label">Jenis Truk</label>
                            <select class="form-select" id="jenisTrukAbsensi" name="jenisTrukAbsensi"
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main><!-- End #main -->

<script>
    let currentStream;
    let videoElement = document.getElementById('webcamVerify');
    let canvasElement = document.getElementById('imageCanvasVerify');
    let captureButton = document.getElementById('captureImageBtn');
    let switchButton = document.getElementById('toggleCameraBtn');
    let constraints = { video: { facingMode: 'environment' } }; // Start with back camera

    async function initWebcam() {
        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop());
        }

        try {
            currentStream = await navigator.mediaDevices.getUserMedia(constraints);
            videoElement.srcObject = currentStream;
        } catch (error) {
            console.error('Error accessing the camera', error);
        }
    }

    switchButton.addEventListener('click', () => {
        constraints.video.facingMode = constraints.video.facingMode === 'environment' ? 'user' : 'environment';
        initWebcam();
    });

    captureButton.addEventListener('click', () => {
        const context = canvasElement.getContext('2d');
        context.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);
        const imageDataURL = canvasElement.toDataURL('image/png');
        const fotoBinaryElement = document.getElementById('fotoBinary');
        if (fotoBinaryElement) {
            fotoBinaryElement.value = imageDataURL;
        } else {
            console.error('Element with ID "fotoBinary" not found');
        }
    });

    function openModal(id, qtyPalet) {
        initWebcam();
        var myModal = new bootstrap.Modal(document.getElementById('absensiModal'));
        document.getElementById('updateCapacity').value = qtyPalet; // Set QTY Palet in capacity field
        document.getElementById('kyb_id_schedule').value = id; // Set kyb_id_schedule in hidden input
        document.getElementById('kyb_id_palet').value = kyb_id_palet; // Set kyb_id_palet in hidden input
        myModal.show();
    }

    function stopWebcam() {
        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop());
        }
    }

    document.getElementById('absensiModal').addEventListener('hidden.bs.modal', stopWebcam);

    // Geolocation and distance calculation
    const targetLat = -6.311555483224414;
    const targetLng = 107.09959752392139;

    function checkProximity(id, kyb_id_palet) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    const userLat = -6.311555483224414;
                    const userLng = 107.09959752392139;

                    // Set the values of the hidden inputs
                    document.getElementById('latitude').value = userLat;
                    document.getElementById('longitude').value = userLng;

                    const distance = getDistanceFromLatLonInKm(userLat, userLng, targetLat, targetLng);

                    if (distance <= 0.5) {
                        fetchPaletCapacity(kyb_id_palet, (qtyPalet) => {
                            document.getElementById('updateCapacity').value = qtyPalet; // Set QTY Palet in capacity field
                            document.getElementById('kyb_id_schedule').value = id; // Set kyb_id_schedule in hidden input
                            document.getElementById('kyb_id_palet').value = kyb_id_palet; // Set kyb_id_palet in hidden input

                            openModal(id, qtyPalet);
                        });
                    } else {
                        // Hide the modal
                        var myModal = bootstrap.Modal.getInstance(document.getElementById('absensiModal'));
                        if (myModal) {
                            myModal.hide();
                        }

                        // Show SweetAlert2 message and refresh the page
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: 'Anda Belum Sampai PT Kayaba Indonesia',
                        }).then(() => {
                            location.reload();
                        });
                    }
                },
                error => {
                    if (error.code === error.PERMISSION_DENIED) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Lokasi dinonaktifkan. Silakan aktifkan lokasi Anda untuk melanjutkan.',
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan dalam mengakses lokasi. Silakan coba lagi.',
                        }).then(() => {
                            location.reload();
                        });
                    }
                }
            );
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Geolocation is not supported by this browser.',
            });
        }
    }

    function fetchPaletCapacity(kyb_id_palet, callback) {
        fetch(`../Action/get_palet_capacity.php?kyb_id_palet=${kyb_id_palet}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    callback(data.jumlah_barang);
                } else {
                    console.error('Error fetching palet capacity:', data.message);
                }
            })
            .catch(error => console.error('Error fetching palet capacity:', error));
    }

    function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
        const R = 6371; // Radius of the Earth in km
        const dLat = deg2rad(lat2 - lat1);
        const dLon = deg2rad(lon1 - lon2); // Corrected the sign for longitude difference
        const a =
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        const distance = R * c;
        return distance;
    }

    function deg2rad(deg) {
        return deg * (Math.PI / 180);
    }

    // Event listener for truck selection
    document.getElementById('absensiTruck').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const capacity = selectedOption.getAttribute('data-capacity');
        document.getElementById('updateMaxcapacity').value = capacity;
    });

    // Submit form with AJAX
    document.getElementById('submitFormBtn').addEventListener('click', function () {
        if (document.getElementById('fotoBinary').value === '') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Anda belum mengambil gambar.',
            });
            return;
        }

        const formData = new FormData(document.getElementById('absensiForm'));
        fetch('../Action/insert_absensitruk.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                    }).then(() => {
                        window.location.href = '../Dashboard/dashboardDriver.php';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message,
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat menyimpan absensi. Silakan coba lagi.',
                });
            });
    });
</script>