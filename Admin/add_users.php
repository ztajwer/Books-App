<?php
include_once("db.php");
require '../vendor/autoload.php'; // PHPMailer autoload
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ---- FORM SUBMITTED ----
if (isset($_POST["btn-register"]) && $_SERVER['REQUEST_METHOD'] == "POST") {

    $username = $_POST['fullname'];
    $useremail = $_POST['useremail'];
    $userpass = $_POST['userpass'];
    $userconfirmpass = $_POST['userconfirmpassword'];
    $userimage = $_FILES['pfp']['name'];
    $userimagetemp = $_FILES['pfp']['tmp_name'];
    $ext = pathinfo($userimage, PATHINFO_EXTENSION);

    // ---- CHECK IF EMAIL EXISTS ----
    $checkemailquery = mysqli_query($con, "SELECT * FROM users WHERE user_email='$useremail'");
    if (mysqli_num_rows($checkemailquery) > 0) {
        header("Location: show_users.php?msg=" . urlencode("Email Already Exists!") . "&msgtype=danger");
        exit;
    }

    // ---- PASSWORD MATCH ----
    if ($userpass != $userconfirmpass) {
        header("Location: show_users.php?msg=" . urlencode("Password & Confirm Password do not match!") . "&msgtype=danger");
        exit;
    }

    // ---- IMAGE UPLOAD CHECK ----
    if (empty($userimage)) {
        header("Location: show_users.php?msg=" . urlencode("Upload Profile Image!") . "&msgtype=danger");
        exit;
    }

    $newimagename = $useremail . "." . $ext;
    move_uploaded_file($userimagetemp, "forms/useruploads/" . $newimagename);

    $encryptedpass = password_hash($userpass, PASSWORD_DEFAULT);
    $insertUserQuery = "INSERT INTO users(user_name, user_email, user_password, role_id, user_image) 
                        VALUES('$username','$useremail','$encryptedpass',2,'$newimagename')";

    if (mysqli_query($con, $insertUserQuery)) {

        // -------- Send Email --------
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'zimaltajwer@gmail.com';
            $mail->Password   = 'lveq wfhq cewi hovh';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom('zimaltajwer@gmail.com', 'E-Books Panel');
            $mail->addAddress($useremail, $username);

            $mail->isHTML(true);
            $mail->Subject = 'Welcome to E-Books Panel!';
            $mail->Body = '
            <html><body>
                <h2>Welcome, ' . htmlspecialchars($username) . '!</h2>
                <p>Your account has been successfully created.</p>
            </body></html>';

            $mail->send();

            header("Location: show_users.php?msg=" . urlencode("User Added Successfully! Email sent.") . "&msgtype=success");
            exit;

        } catch (Exception $e) {

            header("Location: show_users.php?msg=" . urlencode("User added but email not sent. Error: " . $mail->ErrorInfo) . "&msgtype=warning");
            exit;
        }

    } else {
        header("Location: show_users.php?msg=" . urlencode("Something went wrong!") . "&msgtype=danger");
        exit;
    }
}

include_once("includes/header.php");
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="forms/style.css">
</head>

<body>

    <div class="overlay"></div>
    <div class="main-container">
        <div class="form-container">
            <h2>Create Account</h2>

            <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                
                <div class="form-group mt-3">
                    <label class="form-label">Profile Image:</label>
                    <input type="file" class="form-control" name="pfp" required>
                </div>

                <div class="form-group mt-3">
                    <label class="form-label">Full Name:</label>
                    <input type="text" class="form-control" name="fullname" required>
                </div>

                <div class="form-group mt-3">
                    <label class="form-label">Email:</label>
                    <input type="email" class="form-control" name="useremail" required>
                </div>

                <div class="form-group mt-3">
                    <label class="form-label">Password:</label>
                    <input type="password" class="form-control" name="userpass" required>
                </div>

                <div class="form-group mt-3">
                    <label class="form-label">Confirm Password:</label>
                    <input type="password" class="form-control" name="userconfirmpassword" required>
                </div>

                <div class="form-group mt-4">
                    <input type="submit" class="btn btn-create-account" value="Register" name="btn-register">
                </div>

            </form>

        </div>
    </div>

</body>
</html>
