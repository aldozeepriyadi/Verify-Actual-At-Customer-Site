<?php
include ("../config.php");
include ("../session.php");

$sqlProblem = "SELECT vd.kyb_id_schedule, vd.kyb_lat, vd.kyb_longi, 
vd.kyb_actual_arrival, vd.kyb_bukti_foto, sd.kyb_plan_arrival, vd.kyb_status, vd.kyb_id_user, lc.kyb_cycle, lc.kyb_dock_customer, sd.kyb_qty_palet, sd.kyb_dock_kybi
FROM kyb_trsverifikasikedatangan vd
LEFT JOIN kyb_trscheduledelivery sd ON vd.kyb_id_schedule = sd.kyb_id_schedule
LEFT JOIN kyb_mslokasicustomer lc ON sd.kyb_id_lokasicustomer = lc.kyb_id_lokasicustomer
WHERE vd.kyb_id_user  ='" . $_SESSION['id_usr'] . "' AND vd.kyb_status = 1";

$result = mysqli_query($conn, $sqlProblem);
$driver_id = $_SESSION['id_usr'];
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard Driver</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
        <section>
            <div class="row">
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">Riwayat Kedatangan</h5>
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Dock</th>
                                        <th scope="col">Pelanggan</th>
                                        <th scope="col">Rencana Kedatangan</th>
                                        <th scope="col">Aktual Kedatangan</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Keterlambatan</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['kyb_dock_kybi'] . "</td>";
                                        echo "<td><a>" . $row['kyb_dock_customer'] . "</a></td>";
                                        $dateTimePlan = new DateTime($row['kyb_plan_arrival']);
                                        $formattedDatePlan = $dateTimePlan->format("d-m-Y H:i:s");
                                        echo "<td><a>" . $formattedDatePlan . "</a></td>";
                                        $dateTime = new DateTime($row['kyb_actual_arrival']);
                                        $formattedDate = $dateTime->format("d-m-Y H:i:s");
                                        echo "<td><a>" . $formattedDate . "</a></td>";

                                        // Calculate delay in minutes
                                        $interval = $dateTimePlan->diff($dateTime);
                                        $delayInMinutes = ($interval->h * 60) + $interval->i;
                                        if ($row['kyb_plan_arrival'] >= $row['kyb_actual_arrival']) {
                                            $status = "ON TIME";
                                            $statusClass = "bg-success";
                                            $delay = "-";
                                        } else {
                                            $status = "BE LATE";
                                            $statusClass = "bg-warning";
                                            if ($delayInMinutes <= 5) {
                                                $delay = "5 minutes";
                                            } else {
                                                $delay = $delayInMinutes . " minutes";
                                            }
                                        }

                                        echo "<td><span class='badge " . $statusClass . "'>" . $status . "</span></td>";
                                        echo "<td>" . $delay . "</td>";
                                        echo "<td><button type='button' class='btn btn-info btn-sm detail-button' data-id_schedule='" . $row['kyb_id_schedule'] . "'>Detail</button></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- End Recent Sales -->
            </div>

            <!-- Cards untuk Remark Problem -->
            <div class="row">
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">Remark Problem</h5>
                            <div class="row">
                                <?php
                                $sqlRemark = "SELECT vd.kyb_id_schedule, vd.kyb_lat, vd.kyb_longi, 
                                vd.kyb_actual_arrival, vd.kyb_bukti_foto, sd.kyb_plan_arrival, vd.kyb_status, vd.kyb_id_user, lc.kyb_cycle, lc.kyb_dock_customer, sd.kyb_qty_palet, sd.kyb_dock_kybi
                                FROM kyb_trsverifikasikedatangan vd
                                LEFT JOIN kyb_trscheduledelivery sd ON vd.kyb_id_schedule = sd.kyb_id_schedule
                                LEFT JOIN kyb_mslokasicustomer lc ON sd.kyb_id_lokasicustomer = lc.kyb_id_lokasicustomer
                                WHERE vd.kyb_id_user  ='" . $_SESSION['id_usr'] . "' AND sd.kyb_status = 4";

                                $resultRemark = mysqli_query($conn, $sqlRemark);

                                while ($rowRemark = mysqli_fetch_assoc($resultRemark)) {
                                    echo "<div class='col-lg-4 mb-4'>";
                                    echo "<div class='card'>";
                                    echo "<div class='card-body'>";
                                    echo "<h5 class='card-title'>Dock: " . $rowRemark['kyb_dock_kybi'] . "</h5>";
                                    echo "<p class='card-text'><strong>Pelanggan:</strong> " . $rowRemark['kyb_dock_customer'] . "</p>";
                                    $dateTimePlan = new DateTime($rowRemark['kyb_plan_arrival']);
                                    $formattedDatePlan = $dateTimePlan->format("d-m-Y H:i:s");
                                    echo "<p class='card-text'><strong>Rencana Kedatangan:</strong> " . $formattedDatePlan . "</p>";
                                    $dateTime = new DateTime($rowRemark['kyb_actual_arrival']);
                                    $formattedDate = $dateTime->format("d-m-Y H:i:s");
                                    echo "<p class='card-text'><strong>Aktual Kedatangan:</strong> " . $formattedDate . "</p>";

                                    // Calculate delay in minutes
                                    $interval = $dateTimePlan->diff($dateTime);
                                    $delayInMinutes = ($interval->h * 60) + $interval->i;
                                    $delay = $delayInMinutes . " minutes";

                                    echo "<p class='card-text'><strong>Keterlambatan:</strong> " . $delay . "</p>";
                                    echo "<button type='button' class='btn btn-warning btn-sm remark-button' data-id_schedule='" . $rowRemark['kyb_id_schedule'] . "'>Remark Problem</button>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Histori Pengambilan Barang</h5>
                            <div class="row">
                                <?php
                                $sqlHistori = "SELECT DISTINCT
                                a.*, b.kyb_dock_customer, d.kyb_qty_palet, d.kyb_plan_arrival, d.kyb_id_schedule
                                FROM 
                                kyb_trspreparationbarang a
                                LEFT JOIN 
                                kyb_mslokasicustomer b ON a.kyb_id_lokasicustomer = b.kyb_id_lokasicustomer
                                LEFT JOIN 
                                kyb_palet c ON a.kyb_id_palet = c.kyb_id_palet
                                LEFT JOIN 
                                kyb_detail_palet e ON e.kyb_id_palet = c.kyb_id_palet
                                LEFT JOIN 
                                kyb_trscheduledelivery d ON a.kyb_idpreparationbarang = d.kyb_idpreparationbarang
                                WHERE 
                                e.kyb_id_barang IN (SELECT kyb_id_barang FROM kyb_msbarang)
                                AND d.kyb_status = 2 AND b.kyb_id_lokasicustomer =" . $_SESSION['customer'] . "
                                GROUP BY
                                a.kyb_idpreparationbarang";
                                $resultHistori = mysqli_query($conn, $sqlHistori);

                                if (mysqli_num_rows($resultHistori) > 0) {
                                    while ($rowHistori = mysqli_fetch_assoc($resultHistori)) {
                                        ?>
                                        <div class="col-lg-4 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo $rowHistori["kyb_dock_customer"]; ?></h5>
                                                    <p class="card-text"><strong>Quantity Palet:</strong>
                                                        <?php echo $rowHistori['kyb_qty_palet']; ?></p>
                                                    <p class="card-text"><strong>Plan Arrival:</strong>
                                                        <?php echo $rowHistori['kyb_plan_arrival']; ?></p>
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <button type="button" class="btn btn-danger btn-sm cancel-button"
                                                                data-id_schedule="<?php echo $rowHistori['kyb_id_schedule']; ?>">Batalkan
                                                                Pengiriman</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    echo '<div class="col"><p>No data available.</p></div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div><!-- End Histori Pengambilan Barang -->
            </div>
        </section>
    </div>
</main>

<!-- Modal Kirim Foto Remark Problem -->
<div class="modal fade" id="kirimfotoRemarkModal" tabindex="-1" role="dialog"
    aria-labelledby="kirimfotoRemarkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kirimfotoRemarkModalLabel">Remark Problem Driver</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="stopWebcamRemark()"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="row mb-3">
                    <label for="problemRemark" class="col-sm-2 col-form-label">Problem</label>
                    <div class="col-sm-10">
                        <textarea type="textarea" id="problemRemark" name="problemRemark" class="form-control"
                            required></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <video id="webcamRemark" autoplay playsinline></video>
                </div>
                <div class="row mb-3">
                    <canvas id="imageCanvasRemark" width="640" height="480"></canvas>
                </div>
                <input type="hidden" id="latitudeRemark" name="latitudeRemark">
                <input type="hidden" id="longitudeRemark" name="longitudeRemark">
                <input type="hidden" id="id_scheduleRemark" name="id_scheduleRemark">
                <input type="hidden" id="fotoRemark" name="fotoRemark">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="captureImageBtnRemark">Ambil Gambar</button>
                <button type="button" class="btn btn-secondary" id="toggleCameraBtnRemark">Switch Camera</button>
                <button type="button" id="simpanBtnRemark" name="simpanRemark" class="btn btn-primary">Kirim</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Kedatangan -->
<div class="modal fade" id="detailKedatanganModal" tabindex="-1" role="dialog"
    aria-labelledby="detailKedatanganModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailKedatanganModalLabel">Detail Kedatangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="detailContent"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.remark-button').on('click', function () {
            var id_schedule = $(this).data('id_schedule');

            Swal.fire({
                title: 'Remark Problem',
                text: "Anda ingin menginput problem untuk jadwal ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, input problem!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#id_scheduleRemark').val(id_schedule);
                    var myModal = new bootstrap.Modal(document.getElementById('kirimfotoRemarkModal'));
                    myModal.show();
                }
            });
        });

        $('.detail-button').on('click', function () {
            var id_schedule = $(this).data('id_schedule');
            $.ajax({
                url: '../Action/get_problem_details.php',
                type: 'POST',
                data: { id_schedule: id_schedule },
                success: function (response) {
                    if (response.success) {
                        var detailContent = '<ul>';
                        $.each(response.data, function (index, item) {
                            detailContent += '<li><strong>Problem:</strong> ' + item.kyb_problem + '</li>';
                            detailContent += '<li><strong>Foto Bukti:</strong><br><img src="' + item.kyb_bukti_foto + '" alt="Foto Bukti" class="img-fluid"></li>';
                        });
                        detailContent += '</ul>';
                        $('#detailContent').html(detailContent);
                        var detailModal = new bootstrap.Modal(document.getElementById('detailKedatanganModal'));
                        detailModal.show();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan, silahkan coba lagi.'
                    });
                }
            });
        });
        $('.cancel-button').on('click', function () {
            var id_schedule = $(this).data('id_schedule');

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda ingin membatalkan jadwal ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, batalkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../Action/insert_cancelpengiriman.php',
                        method: 'POST',
                        data: { id_schedule: id_schedule },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire(
                                    'Dibatalkan!',
                                    'Pengiriman telah dibatalkan.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function () {
                            Swal.fire(
                                'Error!',
                                'Terjadi kesalahan, silahkan coba lagi.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

        $('#captureImageBtnRemark').on('click', function () {
            const context = document.getElementById('imageCanvasRemark').getContext('2d');
            context.drawImage(document.getElementById('webcamRemark'), 0, 0, 640, 480);
            $('#fotoRemark').val(document.getElementById('imageCanvasRemark').toDataURL('image/png'));
        });

        let currentStreamRemark;
        let videoElementRemark = document.getElementById('webcamRemark');
        let constraintsRemark = { video: { facingMode: 'environment' } }; // Start with back camera

        async function initWebcamRemark() {
            if (currentStreamRemark) {
                currentStreamRemark.getTracks().forEach(track => track.stop());
            }

            try {
                currentStreamRemark = await navigator.mediaDevices.getUserMedia(constraintsRemark);
                videoElementRemark.srcObject = currentStreamRemark;
            } catch (error) {
                console.error('Error accessing the camera', error);
            }
        }

        $('#toggleCameraBtnRemark').on('click', () => {
            constraintsRemark.video.facingMode = constraintsRemark.video.facingMode === 'environment' ? 'user' : 'environment';
            initWebcamRemark();
        });

        $('#kirimfotoRemarkModal').on('shown.bs.modal', () => {
            initWebcamRemark();
            getLocationRemark();
        });

        $('#kirimfotoRemarkModal').on('hidden.bs.modal', () => {
            if (currentStreamRemark) {
                currentStreamRemark.getTracks().forEach(track => track.stop());
            }
        });

        function getLocationRemark() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    $('#latitudeRemark').val(position.coords.latitude);
                    $('#longitudeRemark').val(position.coords.longitude);
                });
            } else {
                Swal.fire('Error', 'Geolocation is not supported by this browser.', 'error');
            }
        }

        function stopWebcamRemark() {
            if (currentStreamRemark) {
                currentStreamRemark.getTracks().forEach(track => track.stop());
            }
        }

        $('#simpanBtnRemark').on('click', function (e) {
            e.preventDefault();
            if (!$('#problemRemark').val()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Anda belum mengisi problem.'
                });
                return;
            }
            if (!$('#fotoRemark').val()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Anda belum meng-capture gambar.'
                });
                return;
            }
            var formData = new FormData();
            formData.append('id_scheduleRemark', $('#id_scheduleRemark').val());
            formData.append('problemRemark', $('#problemRemark').val());
            formData.append('fotoRemark', $('#fotoRemark').val());
            formData.append('latitudeRemark', $('#latitudeRemark').val());
            formData.append('longitudeRemark', $('#longitudeRemark').val());

            $.ajax({
                url: '../Action/insert_problem_remark.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Problem berhasil diinputkan.'
                        }).then(() => {
                            window.location.href = '../Dashboard/dashboardDriver.php';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan, silahkan coba lagi.'
                    });
                }
            });
        });
    });
</script>