<?php
include ("../config.php");
include ("../session.php");

$sqlProblem = "SELECT COUNT(kyb_status) AS problem_count FROM kyb_trsverifikasikedatangan WHERE kyb_status = 1";
$result = mysqli_query($conn, $sqlProblem);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $problem_count = $row['problem_count'];
} else {
    $problem_count = 0;
}
$sqlStatus = "SELECT COUNT(kyb_status) AS problem_count FROM kyb_trsverifikasikedatangan WHERE kyb_status = 0";
$result = mysqli_query($conn, $sqlStatus);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $problem_countng = $row['problem_count'];
} else {
    $problem_countng = 0;
}
$sqlCounts = "
    SELECT 
        SUM(CASE WHEN kyb_status = 1 THEN 1 ELSE 0 END) AS arrived_count,
        SUM(CASE WHEN kyb_status = 0 THEN 1 ELSE 0 END) AS not_arrived_count
    FROM kyb_trsverifikasikedatangan
    WHERE kyb_actual_arrival <= DATE_ADD( NOW( ) , INTERVAL 1 MONTH )
";

$result = mysqli_query($conn, $sqlCounts);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $arrived_count = $row['arrived_count'];
    $not_arrived_count = $row['not_arrived_count'];
} else {
    $arrived_count = 0;
    $not_arrived_count = 0;
}
$sqlCountArrived = "
SELECT SUM(
    CASE WHEN sd.kyb_plan_arrival <= vd.kyb_actual_arrival
    AND vd.kyb_status =1
    THEN 1
    ELSE 0
    END ) AS arrived_ontime, SUM(
    CASE WHEN sd.kyb_plan_arrival >= vd.kyb_actual_arrival
    AND vd.kyb_status =1
    THEN 1
    ELSE 0
    END ) AS arrived_belate
    FROM kyb_trscheduledelivery sd
    LEFT JOIN kyb_trsverifikasikedatangan vd ON sd.kyb_id_schedule = vd.kyb_id_schedule
    WHERE vd.kyb_actual_arrival <= DATE_ADD( NOW( ) , INTERVAL 1 MONTH )
";

$result = mysqli_query($conn, $sqlCountArrived);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $arrived_ontime = $row['arrived_ontime'];
    $arrived_belate = $row['arrived_belate'];
} else {
    $arrived_ontime = 0;
    $arrived_belate = 0;
}
?>


<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard Finish Good</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
        <section>
            <div class="row">

                <!-- Problem Count Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card problem-card">

                        <div class="card-body">
                            <h5 class="card-title">Total Driver Yang Sudah sampai di tempat Customer <span>|
                                    Total</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-truck"></i>
                                </div>
                                <div class="ps-4">
                                    <h6><?php echo $problem_count; ?></h6>
                                    <span class="text-muted small pt-2 ps-1">total</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Problem Count Card -->

                <!-- Problem Count Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card problem-card">

                        <div class="card-body">
                            <h5 class="card-title">Total Driver Yang Belum sampai di tempat Customer <span>|
                                    Total</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-truck"></i>
                                </div>
                                <div class="ps-4">
                                    <h6><?php echo $problem_countng; ?></h6>
                                    <span class="text-muted small pt-2 ps-1">total</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Problem Count Card -->

                <!-- Reports Card -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Driver Status <span></span></h5>

                            <!-- Line Chart -->
                            <div id="reportsChart"></div>

                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    new ApexCharts(document.querySelector("#reportsChart"), {
                                        series: [{
                                            name: 'Arrived',
                                            data: [<?php echo $arrived_count; ?>],
                                        }, {
                                            name: 'Not Arrived',
                                            data: [<?php echo $not_arrived_count; ?>]
                                        }],
                                        chart: {
                                            height: 350,
                                            type: 'bar',
                                            toolbar: {
                                                show: false
                                            },
                                        },
                                        plotOptions: {
                                            bar: {
                                                horizontal: false,
                                                columnWidth: '55%',
                                                endingShape: 'rounded'
                                            },
                                        },
                                        dataLabels: {
                                            enabled: false
                                        },
                                        stroke: {
                                            show: true,
                                            width: 2,
                                            colors: ['transparent']
                                        },
                                        xaxis: {
                                            categories: ['Status'],
                                        },
                                        yaxis: {
                                            title: {
                                                text: 'Total'
                                            },
                                            labels: {
                                                formatter: function (val) {
                                                    return parseInt(val);
                                                }
                                            }
                                        },
                                        fill: {
                                            opacity: 1
                                        },
                                        tooltip: {
                                            y: {
                                                formatter: function (val) {
                                                    return val + " drivers"
                                                }
                                            }
                                        }
                                    }).render();
                                });
                            </script>
                            <!-- End Line Chart -->

                        </div>
                    </div>
                </div><!-- End Reports Card -->

                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Driver Yang sudah yang telat dan tepat waktu </h5>

                            <!-- Line Chart -->
                            <div id="reportsChartArrived"></div>

                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    new ApexCharts(document.querySelector("#reportsChartArrived"), {
                                        series: [{
                                            name: 'Ontime',
                                            data: [<?php echo $arrived_ontime; ?>],
                                        }, {
                                            name: 'Be late',
                                            data: [<?php echo $arrived_belate; ?>]
                                        }],
                                        chart: {
                                            height: 350,
                                            type: 'bar',
                                            toolbar: {
                                                show: false
                                            },
                                        },
                                        plotOptions: {
                                            bar: {
                                                horizontal: false,
                                                columnWidth: '55%',
                                                endingShape: 'rounded'
                                            },
                                        },
                                        dataLabels: {
                                            enabled: false
                                        },
                                        stroke: {
                                            show: true,
                                            width: 2,
                                            colors: ['transparent']
                                        },
                                        xaxis: {
                                            categories: ['jadwal keberangkatan'],
                                        },
                                        yaxis: {
                                            title: {
                                                text: 'Total'
                                            },
                                            labels: {
                                                formatter: function (val) {
                                                    return parseInt(val);
                                                }
                                            }
                                        },
                                        fill: {
                                            opacity: 1
                                        },
                                        tooltip: {
                                            y: {
                                                formatter: function (val) {
                                                    return val + " drivers"
                                                }
                                            }
                                        }
                                    }).render();
                                });
                            </script>
                            <!-- End Line Chart -->

                        </div>
                    </div>
                </div><!-- End Reports Card -->

            </div>
        </section>
    </div>
</main>

<script>
    var ws = new WebSocket('ws://localhost:80');

    ws.onopen = function () {
        console.log('WebSocket connection established');
    };

    ws.onmessage = function (event) {
        console.log('Message from server: ', event.data);
    };

    ws.onclose = function () {
        console.log('WebSocket connection closed');
    };

    ws.onerror = function (error) {
        console.error('WebSocket error: ' + error);
    };

    function updateDriverLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;

                const locationData = JSON.stringify({
                    driver_id: <?php echo $driver_id; ?>,
                    latitude: latitude,
                    longitude: longitude
                });
                ws.send(locationData);
            }, error => {
                console.error('Error:', error);
            }, {
                enableHighAccuracy: true,
                maximumAge: 0,
                timeout: 5000
            });
        } else {
            console.error('Geolocation is not supported by this browser.');
        }
    }

    // Memulai pembaruan lokasi setiap 5 detik
    setInterval(updateDriverLocation, 5000);
</script>

