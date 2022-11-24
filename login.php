<?php
include 'includes/DB.php';
$msg = false;
$db = new DB();
if (isset($_POST['email'])) {
    $email = $db->santize($_POST['email']);
    $password = $db->santize($_POST['password']);
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    if ($db->select($sql)) {
        header("location: index.php");
    } else {
        $msg = "Invalid email or password";
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Webeesocial Account Dashorad</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Jost&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Header -->
    <header class="bg-primary">
        <div class="container">
            <div class="row py-3 align-items-center">
                <div class="col-6">
                    <img src="https://www.webeesocial.com/wp-content/uploads/2020/12/logo-tm-white-compressed.png" alt="" width="125">
                </div>
                <div class="col-6 text-end">
                    <a href="#" class="ac-logout"><i class="bi bi-lock"></i>Logout</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Body -->
    <section class="wbs-account-login">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="account-login">
                        <form method="post" action="" class="login">
                            <div class="avatar"><i class="bi bi-person"></i></div>
                            <h4 class="modal-title">Login to Your Account</h4>
                            <?php if ($msg) : ?>    
                                <?php echo $msg; ?>
                            <?php endif; ?>
                            <div class="form-group">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Username" required="required">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="required">
                            </div>
                            <div class="form-group small clearfix">
                                <label class="checkbox-inline"><input type="checkbox"> Remember me</label>
                                <a href="#" class="forgot-link">Forgot Password?</a>
                            </div>
                            <input type="submit" class="btn btn-primary w-100" value="Login">
                        </form>
                        <div class="text-center small">Don't have an account? <a href="#">Sign up</a></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Js-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.1/classic/ckeditor.js"></script>
</body>

</html>