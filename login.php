<?php
include "config.php";
include "lib/phpPasswordHashingLib-master/passwordLib.php";

$err = "";
$username = "";
$rememberMe = "";
$redirectUrl = "";
$message = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $enteredCaptcha = $_POST['captcha'];

    // Validate captcha
    if (isset($_SESSION['captcha_code']) && strtoupper($enteredCaptcha) === strtoupper($_SESSION['captcha_code'])) {
        // Captcha is correct
        unset($_SESSION['captcha_code']); // Remove captcha code after successful validation

        // Validate user credentials
        $query = "SELECT * FROM kyb_msuser WHERE kyb_username='$username' and kyb_status = 1";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['kyb_password'])) {
                // Password is correct
                $_SESSION['id_usr'] = $user['kyb_id_usr'];
                $_SESSION['username'] = $user['kyb_username'];
                $_SESSION['nama'] = $user['kyb_nama_usr'];
                $_SESSION['customer'] = $user['kyb_id_lokasi_customer'];

                // Fetch user role
                $role_query = "SELECT * FROM kyb_msrole WHERE kyb_id_role = " . $user['kyb_id_role'];
                $role_result = $conn->query($role_query);
                $role = $role_result->fetch_assoc();

                if (isset($_POST['rememberMe']) && $_POST['rememberMe'] == '1') {
                    $cookie_name = "username";
                    $cookie_value = $user['kyb_password'];
                    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
                }

                $_SESSION['role'] = $role['kyb_role'];
                $_SESSION['role_id'] = $role['kyb_id_role'];

                if ($role['kyb_id_role'] == 3) {
                    // Redirect to kadept finish good dashboard
                    $redirectUrl = "Dashboard/view_monitoringdriver.php";
                    $message = "Login sukses! Selamat Datang Ketua Departemen \t" . $_SESSION['nama'];
                } elseif ($role['kyb_id_role'] == 2) {
                    // Redirect to finish good dashboard
                    $redirectUrl = "Dashboard/dashboardFinishGood.php";
                    $message = "Login sukses! Selamat Datang Admin \t" . $_SESSION['nama'];
                } elseif ($role['kyb_id_role'] == 1) {
                    // Redirect to driver dashboard
                    $redirectUrl = "Dashboard/dashboardDriver.php";
                    $message = "Login sukses! Selamat Datang Driver \t" . $_SESSION['nama'];
                } else {
                    // Role not recognized
                    $err = "bad credentials";
                }

            } else {
                $err = "bad credentials";
            }
        } else {
            $err = "bad credentials";
        }
    } else {
        // Captcha is incorrect
        $err = "bad credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Verifikasi Kedatangan</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="assets/img/kybgambar-removebg-preview.png" rel="icon">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i"
        rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php if ($redirectUrl && $message): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: 'Sukses!',
                    text: '<?php echo $message ?>',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(function () {
                    window.location.href = '<?php echo $redirectUrl ?>';
                });
            });
        </script>
    <?php endif; ?>
    <main>
        <div class="container">
            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <div class='w-100 text-center pb-0 fs-4'>
                                            <img class='w-50' src="assets/img/kyb-merah.png" alt="">
                                        </div>
                                        <h5 class="card-title text-center pb-0 fs-4">Verifikasi Kedatangan Driver</h5>
                                        <p class="text-center small">Masukan Username dan Password</p>
                                    </div>
                                    <?php if ($err) { ?>
                                        <div id="login-alert" class="alert alert-danger col-sm-12">
                                            <ul>
                                                <?php echo $err ?>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                    <form class="row g-3 needs-validation" class="login"
                                        action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <div class="col-12">
                                            <label for="username" class="form-label">Username</label>
                                            <div clas s="input-group has-validation">
                                                <input type="text" name="username" class="form-control" id="username"
                                                    required>
                                                <div class="invalid-feedback">Masukan username</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group has-validation">
                                                <input type="password" name="password" class="form-control"
                                                    id="password" required>
                                                <div class="invalid-feedback">Masukan password!</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="showPasswordCheckbox">
                                                <label class="form-check-label" for="showPasswordCheckbox">Tampilkan
                                                    Password</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="rememberMe"
                                                    value="true" id="rememberMe" <?php if ($rememberMe == '1')
                                                        echo "checked" ?>>
                                                    <label class="form-check-label" for="rememberMe">Ingat Aku</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <img src="captcha.php" id="captchaImg" alt="Captcha Image" />
                                                <div class="invalid-feedback">Captcha Salah</div>
                                            </div>
                                            <div class="col-12">
                                                <label for="captcha" class="form-label">Captcha</label>
                                                <a href="#" onclick="refreshCaptcha(); return false;">Muat Ulang</a>
                                                <input type="text" name="captcha" class="form-control" id="captcha"
                                                    required>
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-primary w-100" type="submit" id="login"
                                                    name="login">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main><!-- End #main -->
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script>
            setTimeout(function () {
                document.getElementById('login-alert').style.display = 'none';
            }, 5000);   
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Get the password input and the show password checkbox
                var passwordInput = document.getElementById("password");
                var showPasswordCheckbox = document.getElementById("showPasswordCheckbox");

                // Toggle the password visibility on checkbox change
                showPasswordCheckbox.addEventListener("change", function () {
                    passwordInput.type = showPasswordCheckbox.checked ? "text" : "password";
                });
            });
            function refreshCaptcha() {
                var captchaImg = document.getElementById("captchaImg");
                captchaImg.src = "captcha.php";
            }
            window.history.forward(); // Prevent going back to the login page
            window.onpageshow = function (event) {
                if (event.persisted) {
                    window.history.forward();
                }
            };
        </script>
    </body>

</html>
