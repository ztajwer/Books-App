<?php
include_once("config.php");
require '../../vendor/autoload.php'; // PHPMailer autoload
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST["btn-register"]) && $_SERVER['REQUEST_METHOD'] == "POST") {

    $username = $_POST['fullname'];
    $useremail = $_POST['useremail'];
    $userpass = $_POST['userpass'];
    $userconfirmpass = $_POST['userconfirmpassword'];
    $userimage = $_FILES['pfp']['name'];
    $userimagetemp = $_FILES['pfp']['tmp_name'];
    $ext = pathinfo($userimage, PATHINFO_EXTENSION);

    $checkemailquery = mysqli_query($conn, "SELECT * FROM users WHERE user_email='$useremail'");
    if (mysqli_num_rows($checkemailquery) > 0) {
        $error = "Email Already Exists!";
    } elseif ($userpass != $userconfirmpass) {
        $error = "Password & Confirm Password do not match!";
    } elseif (empty($userimage)) {
        $error = "Upload Profile Image!";
    } else {
        $newimagename = $useremail . "." . $ext;
        move_uploaded_file($userimagetemp, "useruploads/" . $newimagename);

        $encryptedpass = password_hash($userpass, PASSWORD_DEFAULT);
        $insertUserQuery = "INSERT INTO users(user_name, user_email, user_password, role_id, user_image) 
                            VALUES('$username','$useremail','$encryptedpass',2,'$newimagename')";

        if (mysqli_query($conn, $insertUserQuery)) {

            // ---------------- PHPMailer ----------------
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'zimaltajwer@gmail.com'; // your email
                $mail->Password   = 'lveq wfhq cewi hovh'; // app password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;

                $mail->setFrom('zimaltajwer@gmail.com', 'E-Books Panel');
                $mail->addAddress($useremail, $username);

                $mail->isHTML(true);
                $mail->Subject = 'Welcome to E-Books Panel!';

                $mail->Body = '
                <html>
                <head>
                <style>
                    body { font-family: Arial, sans-serif; background-color:#fff8f0; color:#333; }
                    .container { max-width:600px; margin:auto; background:#fff4e6; border-radius:10px; padding:30px; border-left:6px solid #ff8800; }
                    h2 { color:#ff6a00; text-align:center; }
                    p { font-size:16px; line-height:1.5; }
                    .btn-orange {
                        display:inline-block;
                        background-color:#ff8800;
                        color:#fff !important;
                        text-decoration:none;
                        padding:12px 25px;
                        border-radius:8px;
                        font-weight:bold;
                        margin-top:15px;
                    }
                    .btn-orange:hover { background-color:#ff6a00; }
                </style>
                </head>
                <body>
                    <div class="container">
                        <h2>Welcome, ' . htmlspecialchars($username) . '!</h2>
                        <p>Thank you for registering at <b>E-Books Panel</b>. You can now access your dashboard and explore exciting competitions, books, and much more.</p>
                        <p>Click the button below to login and get started:</p>
                        <a href="https://yourwebsite.com/login.php" class="btn-orange">Go to Dashboard</a>
                        <p style="margin-top:20px;">— The E-Books Panel Team</p>
                    </div>
                </body>
                </html>
                ';

                $mail->send();
                // Optional: you can set a success message
                $success = "Registration successful! A welcome email has been sent.";

            } catch (Exception $e) {
                $error = "Registration successful, but email could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            header("Location: login.php");
            exit;

        } else {
            $error = "Something went wrong!";
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="overlay"></div>
    <div class="main-container">
        <div class="form-container">
            <h2>Create Account</h2>

            <!-- Alert -->
            <?php if (isset($error)) { ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php } ?>

            <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="form-group mt-3">
                    <label class="form-label">Profile Image:</label>
                    <input type="file" class="form-control" name="pfp" required>
                    <div class="invalid-feedback">
                        Upload your profile image.
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="form-label">Full Name:</label>
                    <input type="text" class="form-control" name="fullname" required>
                    <div class="invalid-feedback">
                        Enter your full name.
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="form-label">Email:</label>
                    <input type="email" class="form-control" name="useremail" required>
                    <div class="invalid-feedback">
                        Enter a valid email.
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="form-label">Password:</label>
                    <input type="password" class="form-control" name="userpass" required>
                    <div class="invalid-feedback">
                        Enter a password.
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="form-label">Confirm Password:</label>
                    <input type="password" class="form-control" name="userconfirmpassword" required>
                    <div class="invalid-feedback">
                        Confirm your password.
                    </div>
                </div>

                <div class="form-group mt-4">
                    <input type="submit" class="btn btn-create-account" value="Register" name="btn-register">
                </div>

                <p class="text-center mt-3">Already have an account?
                    <a href="login.php">Login</a>
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