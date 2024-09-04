<main id="main" class="main">

    <div class="pagetitle">
        <h1>Monitoring Driver</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Dashboard</li>
                <li class="breadcrumb-item active">Monitoring Driver</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Filter Data</h5>
                        <form id="filterForm">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="dock_customer" class="form-label">Dock Customer</label>
                                    <select class="form-control" id="dock_customer" name="dock_customer">
                                        <option value="">All</option>
                                        <?php
                                        include ('../config.php');
                                        $sqlLocations = "SELECT DISTINCT kyb_cycle, kyb_dock_customer FROM kyb_mslokasicustomer";
                                        $resultLocations = mysqli_query($conn, $sqlLocations);

                                        while ($row = mysqli_fetch_assoc($resultLocations)) {
                                            echo "<option value='{$row['kyb_dock_customer']}'>{$row['kyb_dock_customer']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="dock_kybi" class="form-label">Dock Kybi</label>
                                    <select class="form-control" id="dock_kybi" name="dock_kybi">
                                        <option value="">All</option>
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
                                <div class="col-md-2">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="">All</option>
                                        <option value="On Time">On Time</option>
                                        <option value="Be late">Be late</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label for="actual_day" class="form-label">Day</label>
                                    <select class="form-control" id="actual_day" name="actual_day">
                                        <option value="">All</option>
                                        <?php for ($day = 1; $day <= 31; $day++): ?>
                                            <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label for="actual_month" class="form-label">Month</label>
                                    <select class="form-control" id="actual_month" name="actual_month">
                                        <option value="">All</option>
                                        <?php for ($month = 1; $month <= 12; $month++): ?>
                                            <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="actual_year" class="form-label">Year</label>
                                    <select class="form-control" id="actual_year" name="actual_year">
                                        <option value="">All</option>
                                        <?php for ($year = date('Y') - 10; $year <= date('Y') + 10; $year++): ?>
                                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-md-2 mt-4">
                                    <button type="button" class="btn btn-primary" id="downloadExcelBtn">Download
                                        Excel</button>
                                </div>
                            </div>
                        </form>
                        <div class="container mt-3">
                            <div class="table-responsive">
                                <h5 class="card-title">Monitoring Data</h5>
                                <table class="table table-borderless datatable" id="monitoringTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Cycle</th>
                                            <th scope="col">Dock Customer</th>
                                            <th scope="col">Dock Kybi</th>
                                            <th scope="col">Nama Driver</th>
                                            <th scope="col">Actual Arrival</th>
                                            <th scope="col">Qty Pallet</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody id="monitoringData">
                                        <!-- Data will be populated by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

<script>
    $(document).ready(function () {
        var table = $('#monitoringTable').DataTable({
            ajax: {
                url: '../Action/monitoring_driver.php',
                type: 'POST',
                data: function (d) {
                    d.dock_customer = $('#dock_customer').val();
                    d.dock_kybi = $('#dock_kybi').val();
                    d.status = $('#status').val();
                    d.actual_day = $('#actual_day').val();
                    d.actual_month = $('#actual_month').val();
                    d.actual_year = $('#actual_year').val();
                }
            },
            columns: [
                { data: 0 },
                { data: 1 },
                { data: 2 },
                { data: 3 },
                { data: 4 },
                { data: 5 },
                { data: 6 },
                { data: 7 },
                { data: 8 }
            ]
        });

        $('#dock_customer, #dock_kybi, #status, #actual_day, #actual_month, #actual_year').on('change', function () {
            table.ajax.reload();
        });

        $('#downloadExcelBtn').on('click', function () {
            var searchValue = table.search();
            $.ajax({
                url: '../Action/generate_excel.php',
                method: 'POST',
                data: {
                    dock_customer: $('#dock_customer').val(),
                    dock_kybi: $('#dock_kybi').val(),
                    status: $('#status').val(),
                    search: searchValue,
                    actual_day: $('#actual_day').val(),
                    actual_month: $('#actual_month').val(),
                    actual_year: $('#actual_year').val(),
                },
                success: function (response) {
                    var link = document.createElement('a');
                    link.href = response.path;
                    link.download = response.file;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            });
        });
    });

    function remarkProblem(id_schedule) {
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
                $.ajax({
                    url: '../Action/remark_problem.php',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ id_schedule: id_schedule }),
                    success: function (response) {
                        if (response.success) {
                            Swal.fire(
                                'Berhasil!',
                                'Status berhasil diperbarui.',
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
    }
</script>