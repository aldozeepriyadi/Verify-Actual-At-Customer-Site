<!-- ======= Header ======= -->
<style>
    @media (max-width: 767px) {
        .nav-profile .dropdown-toggle {
            display: inline !important;
        }
    }
</style>
<header class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="<?php if ($_SESSION['role_id'] == 1) {
            echo "../Dashboard/dashboardDriver.php";
        } else if ($_SESSION['role_id'] == 2) {
            echo "../Dashboard/dashboardFinishGood.php";
        } else if ($_SESSION['role_id'] == 3) {
            echo "../Dashboard/view_monitoringdriver.php";
        }
        ?>" class="logo d-flex align-items-center">
            <img src="../assets/img/kybgambar-removebg-preview.png" alt="">
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">
                <button class="nav-link nav-profile d-flex align-items-center pe-0" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <span class="dropdown-toggle ps-2">
                        <?php echo $_SESSION['nama']; ?>
                    </span>
                </button><!-- End Profile Image Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?php echo $_SESSION['nama']; ?></h6>
                        <span><?php echo ucwords($_SESSION['role']) ?></span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center" id="logoutButton">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </button>
                        <form method="post" name="logoutForm" id="logoutForm" style="display: none;">
                            <input type="hidden" name="logout" value="1">
                        </form>
                    </li>
                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->
        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->

<!-- Load Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('logoutButton').addEventListener('click', function () {
        Swal.fire({
            title: 'Apakah Anda yakin ingin keluar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, keluar',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    });
</script>