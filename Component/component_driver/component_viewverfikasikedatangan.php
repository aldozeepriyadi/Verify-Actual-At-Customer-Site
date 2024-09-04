<?php
include ("../config.php");
include ("../session.php");
include ("../Action/view_verifikasikedatangan.php");
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Verifikasi Kedatangan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../Dashboard/dashboardDriver.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Verifikasi Kedatangan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="section-title">
            <h2 class="text-primary">Current Event</h2>
            <hr class="mb-4">
        </div>
        <div class="row">
            <?php
            if (mysqli_num_rows($resultCurrentEvent) > 0) {
                $index = 1;
                while ($rowCurrentEvent = mysqli_fetch_assoc($resultCurrentEvent)) {
                    ?>
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php echo $rowCurrentEvent["kyb_dock_customer"] . "/" . $rowCurrentEvent['kyb_cycle']; ?>
                                </h5>

                                <p class="card-text"><strong>Pelanggan:</strong>
                                    <?php echo $rowCurrentEvent['kyb_bpid']; ?>
                                </p>

                                <p class="card-text"><strong>Rencana:</strong>
                                    <?php echo $rowCurrentEvent['kyb_plan_arrival']; ?>
                                </p>
                                <div class="row mb-3">
                                    <div class="col">
                                        <button type="button" class="btn btn-danger btn-sm problem-button"
                                            data-id_schedule="<?php echo $rowCurrentEvent['kyb_id_schedule']; ?>"
                                            data-plan_arr="<?php echo $rowCurrentEvent['kyb_plan_arrival']; ?>"
                                            data-waktu="<?php echo $rowCurrentEvent['kyb_waktu']; ?>"
                                            data-bpid="<?php echo $rowCurrentEvent['kyb_bpid']; ?>">Problem</button>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <button type="button" class="btn btn-success btn-sm verifikasi-button"
                                            data-bpid="<?php echo $rowCurrentEvent['kyb_bpid']; ?>"
                                            data-id_schedule="<?php echo $rowCurrentEvent['kyb_id_schedule']; ?>"
                                            data-lat="<?php echo $rowCurrentEvent['kyb_lat']; ?>"
                                            data-longi="<?php echo $rowCurrentEvent['kyb_longi']; ?>"
                                            data-id_verifikasi="<?php echo $rowCurrentEvent['kyb_id_verfikasi']; ?>">Verifikasi
                                            Kedatangan</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php
                    $index++;
                }
            } else {
                echo '<div class="col"><p>No data available.</p></div>';
            }
            ?>
        </div>
    </section>

    <section class="section">
        <div class="section-title">
            <h2 class="text-primary">Upcoming Event</h2>
            <hr class="mb-4">
        </div>
        <div class="row">
            <?php
            if (mysqli_num_rows($resultUpcomingEvents) > 0) {
                while ($rowUpcomingEvent = mysqli_fetch_assoc($resultUpcomingEvents)) {
                    ?>
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php echo $rowUpcomingEvent['kyb_dock_customer'] . "/" . $rowUpcomingEvent['kyb_cycle']; ?>
                                </h5>

                                <p class="card-text"><strong>Customer:</strong>
                                    <?php echo $rowUpcomingEvent['kyb_bpid']; ?>
                                </p>

                                <p class="card-text"><strong>Plan:</strong>
                                    <?php echo $rowUpcomingEvent['kyb_plan_arrival']; ?>
                                </p>

                                <div class="row mb-3">
                                    <div class="col">
                                        <button type="button" class="btn btn-danger btn-sm problem-button"
                                            data-bpid="<?php echo $rowUpcomingEvent['kyb_bpid']; ?>"
                                            data-id_schedule="<?php echo $rowUpcomingEvent['kyb_id_schedule']; ?>"
                                            data-plan_arr="<?php echo $rowUpcomingEvent['kyb_plan_arrival']; ?>"
                                            data-waktu="<?php echo $rowUpcomingEvent['kyb_waktu']; ?>">Problem</button>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <button type="button" class="btn btn-success btn-sm verifikasi-button"
                                            data-bpid="<?php echo $rowUpcomingEvent['kyb_bpid']; ?>"
                                            data-lat="<?php echo $rowUpcomingEvent['kyb_lat']; ?>"
                                            data-longi="<?php echo $rowUpcomingEvent['kyb_longi']; ?>"
                                            data-id_schedule="<?php echo $rowUpcomingEvent['kyb_id_schedule']; ?>"
                                            data-id_verifikasi="<?php echo $rowUpcomingEvent['kyb_id_verfikasi']; ?>">Verifikasi
                                            Kedatangan</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php
                    $index++;
                }
            } else {
                echo '<div class="col"><p>No data available.</p></div>';
            }
            ?>
        </div>
    </section>

    <section>
        <div class="modal fade" id="kirimfotoModal" tabindex="-1" role="dialog" aria-labelledby="kirimfotoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form class="form-horizontal" enctype="multipart/form-data" method="post"
                        action="../Action/insert_problem.php">
                        <div class="modal-header">
                            <h5 class="modal-title" id="kirimfotoModalLabel">Problem Driver</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="stopWebcam()"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <div class="row mb-3">
                                <label for="problem" class="col-sm-2 col-form-label">Problem</label>
                                <div class="col-sm-10">
                                    <textarea type="textarea" id="problem" name="problem" class="form-control"
                                        required></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <video id="webcam" autoplay playsinline></video>
                            </div>
                            <div class="row mb-3">
                                <canvas id="imageCanvas" width="640" height="480"></canvas>
                            </div>

                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">
                            <input type="hidden" id="id_schedule" name="id_schedule">
                            <input type="hidden" id="foto" name="foto">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="captureImageBtn">Ambil Gambar</button>
                            <button type="button" class="btn btn-secondary" id="toggleCameraBtn">Switch Camera</button>
                            <button type="submit" id="simpanBtn" name="simpan" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Form HTML di Modal Verifikasi -->
        <div class="modal fade" id="verifikasiModal" tabindex="-1" role="dialog" aria-labelledby="verifikasiModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form class="form-horizontal" enctype="multipart/form-data" method="post"
                        action="../Action/insert_verifikasikedatangan.php">
                        <div class="modal-header">
                            <h5 class="modal-title" id="verifikasiModalLabel">Detail</h5>
                            <button type="button" class="btn-close" onclick="stopWebcamverifikasi()"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <h4 class="card-title">Verifikasi Kedatangan</h4>
                                        <div class="row mb-3">
                                            <video id="webcamVerify" autoplay playsinline></video>
                                        </div>
                                        <div class="row mb-3">
                                            <canvas id="imageCanvasVerify" width="640" height="480"></canvas>
                                        </div>
                                        <input type="hidden" id="id_verifikasi" name="id_verifikasi">
                                        <input type="hidden" id="latitudeKedatangan" name="latitudeKedatangan">
                                        <input type="hidden" id="longitudeKedatangan" name="longitudeKedatangan">
                                        <input type="hidden" id="id_scheduleKedatangan" name="id_scheduleKedatangan">
                                        <input type="hidden" id="fotoBinary" name="fotoBinary">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="captureImageBtnVerify">Capture
                                Image</button>
                            <button type="button" class="btn btn-secondary" id="toggleCameraBtnVerify">Switch
                                Camera</button>
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>

</main><!-- End #main -->

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    let currentStream;
    let isFrontCamera = true;

    function startWebcam(videoElement) {
        let constraints = {
            video: {
                facingMode: isFrontCamera ? "user" : "environment"
            }
        };

        navigator.mediaDevices.getUserMedia(constraints)
            .then(function (stream) {
                currentStream = stream;
                videoElement.srcObject = stream;
            })
            .catch(function (error) {
                console.error("Error accessing the webcam: ", error);
            });
    }

    function stopWebcam() {
        if (currentStream) {
            let tracks = currentStream.getTracks();
            tracks.forEach(track => track.stop());
        }
    }

    function toggleCamera(videoElement) {
        stopWebcam();
        isFrontCamera = !isFrontCamera;
        startWebcam(videoElement);
    }

    function captureImage(videoElement, canvasElement, inputElement) {
        if (!canvasElement || !videoElement) {
            console.error("Canvas or video element not found.");
            return;
        }
        let context = canvasElement.getContext('2d');
        if (!context) {
            console.error("Unable to get canvas context.");
            return;
        }
        context.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);
        let imageData = canvasElement.toDataURL('image/png');
        inputElement.value = imageData;
    }

    function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = deg2rad(lat2 - lat1);
        const dLon = deg2rad(lon2 - lon1);
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        const distance = R * c;
        return distance;
    }

    function deg2rad(deg) {
        return deg * (Math.PI / 180);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const problemButtons = document.querySelectorAll('.problem-button');
        const verifikasiButtons = document.querySelectorAll('.verifikasi-button');

        problemButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const id_schedule = this.getAttribute('data-id_schedule');
                const bpid = this.getAttribute('data-bpid');

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        const latDevice = position.coords.latitude;
                        const longiDevice = position.coords.longitude;
                        document.getElementById('latitude').value = latDevice;
                        document.getElementById('longitude').value = longiDevice;
                        document.getElementById('id_schedule').value = id_schedule;
                        document.getElementById('kirimfotoModalLabel').textContent = 'Problem Driver (' + bpid + ')';
                        const videoElement = document.getElementById('webcam');
                        startWebcam(videoElement);
                        $('#kirimfotoModal').modal('show');
                    }, function (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Tidak dapat mengambil lokasi perangkat Anda.'
                        });
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Geolocation tidak didukung oleh browser ini.'
                    });
                }
            });
        });

        verifikasiButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const bpid = this.getAttribute('data-bpid');
                const id_schedule = this.getAttribute('data-id_schedule');
                const id_verifikasi = this.getAttribute('data-id_verifikasi');
                const latCustomer = parseFloat(this.getAttribute('data-lat'));
                const longiCustomer = parseFloat(this.getAttribute('data-longi'));

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        const latDevice = -6.22592
                        const longiDevice = 106.8302336;
                        console.log(latDevice, longiDevice);
                        const distance = getDistanceFromLatLonInKm(latDevice, longiDevice, latCustomer, longiCustomer);

                        if (distance <= 5) {
                            const idVerifikasiElem = document.getElementById('id_verifikasi');
                            const idScheduleKedatanganElem = document.getElementById('id_scheduleKedatangan');
                            const latitudeKedatanganElem = document.getElementById('latitudeKedatangan');
                            const longitudeKedatanganElem = document.getElementById('longitudeKedatangan');

                            if (idVerifikasiElem && idScheduleKedatanganElem && latitudeKedatanganElem && longitudeKedatanganElem) {
                                idVerifikasiElem.value = id_verifikasi;
                                idScheduleKedatanganElem.value = id_schedule;
                                latitudeKedatanganElem.value = latDevice;
                                longitudeKedatanganElem.value = longiDevice;
                                document.getElementById('verifikasiModalLabel').textContent = 'Verifikasi Kedatangan (' + bpid + ')';
                                const videoElementVerify = document.getElementById('webcamVerify');
                                startWebcam(videoElementVerify);
                                $('#verifikasiModal').modal('show');
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Element tidak ditemukan di halaman. Silakan coba lagi.'
                                });
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Anda belum sampai ke tempat customer',
                                text: `Jarak Anda masih ${distance.toFixed(2)} Kilometer dari lokasi customer.`
                            });
                        }
                    }, function (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Tidak dapat mengambil lokasi perangkat Anda.'
                        });
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Geolocation tidak didukung oleh browser ini.'
                    });
                }
            });
        });

        $('#kirimfotoModal').on('hidden.bs.modal', function () {
            stopWebcam();
        });

        $('#verifikasiModal').on('hidden.bs.modal', function () {
            stopWebcam();
        });

        document.getElementById('captureImageBtn').addEventListener('click', function () {
            const videoElement = document.getElementById('webcam');
            const canvasElement = document.getElementById('imageCanvas');
            const inputElement = document.getElementById('foto');
            captureImage(videoElement, canvasElement, inputElement);
        });

        document.getElementById('captureImageBtnVerify').addEventListener('click', function () {
            const videoElementVerify = document.getElementById('webcamVerify');
            const canvasElementVerify = document.getElementById('imageCanvasVerify');
            const inputElementVerify = document.getElementById('fotoBinary');
            captureImage(videoElementVerify, canvasElementVerify, inputElementVerify);
        });

        document.getElementById('toggleCameraBtn').addEventListener('click', function () {
            const videoElement = document.getElementById('webcam');
            toggleCamera(videoElement);
        });

        document.getElementById('toggleCameraBtnVerify').addEventListener('click', function () {
            const videoElementVerify = document.getElementById('webcamVerify');
            toggleCamera(videoElementVerify);
        });

        // AJAX for Problem submission
        document.querySelector('#kirimfotoModal form').addEventListener('submit', function (e) {
            e.preventDefault();
            if (document.getElementById('foto').value === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Anda belum mengambil gambar.',
                });
                return;
            }
            const formData = new FormData(this);
            fetch('../Action/insert_problem.php', {
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
                            window.location.href = '../Dashboard/view_verifikasikedatangan.php';
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
                        text: 'Terjadi kesalahan saat mengirim data. Silakan coba lagi.',
                    });
                });
        });

        // AJAX for Verification submission
        document.querySelector('#verifikasiModal form').addEventListener('submit', function (e) {
            e.preventDefault();
            if (document.getElementById('fotoBinary').value === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Anda belum mengambil gambar.',
                });
                return;
            }
            const formData = new FormData(this);
            fetch('../Action/insert_verifikasikedatangan.php', {
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
                            window.location.href = '../Dashboard/view_verifikasikedatangan.php';
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
                        text: 'Terjadi kesalahan saat mengirim data. Silakan coba lagi.',
                    });
                });
        });
    });
</script>