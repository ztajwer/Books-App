<?php
include_once("config.php");
session_start();

if (isset($_POST["btn-login"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $recordGetQuery = "SELECT * FROM users WHERE user_email = '$email'";
    $userdata = mysqli_query($conn, $recordGetQuery);

    if ($userdata && mysqli_num_rows($userdata) > 0) {
        $user = mysqli_fetch_assoc($userdata);
        if (password_verify($password, $user["user_password"])) {
            $_SESSION["username"] = $user["user_name"];
            $_SESSION["useremail"] = $user["user_email"];
            $_SESSION["user_image"] = $user["user_image"];
            $_SESSION["userrole"] = $user["role_id"];

            if ($user["role_id"] == 1) {
                header("Location: ../index.php");
                exit;
            } else {
                header("Location: ../../index.php");
                exit;
            }
        } else {
            $error = "Incorrect Password!";
        }
    } else {
        $error = "Account Not Found!";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="overlay"></div>
<div class="main-container">
    <div class="form-container">
        <h2>Sign In!</h2>

        <!-- Alert -->
        <?php if(isset($error)) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>

        <form method="post" class="needs-validation" novalidate>
            <div class="form-group mt-3">
                <label class="form-label">Enter Email:</label>
                <input type="email" class="form-control" placeholder="Enter Email" name="email" required>
                <div class="invalid-feedback">
                    Please enter a valid email.
                </div>
            </div>

            <div class="form-group mt-3">
                <label class="form-label">Enter Password:</label>
                <input type="password" class="form-control" placeholder="Enter Password" name="password" required>
                <div class="invalid-feedback">
                    Please enter your password.
                </div>
            </div>

            <div class="form-group mt-4">
                <input type="submit" class="btn btn-create-account" value="Login" name="btn-login">
            </div>

            <p class="text-center mt-3">Don't have an Account? 
                <a href="register.php">Register</a>
            </p>
        </form>
    </div>
</div>
<script>
(() => {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
