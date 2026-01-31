<?php
include_once("config.php");

if (isset($_POST["part-btn"]) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $num = $_POST['num'];
    $age = $_POST['age'];

    setcookie("participant_name", $name, time() + (86400 * 7), "/");
    setcookie("participant_email", $email, time() + (86400 * 7), "/");

    $query = "INSERT INTO `part`(`part_name`, `part_email`, `part_num`, `part_age`) VALUES ('$name','$email','$num','$age')";

    $res = mysqli_query($conn, $query);

    if ($res) {
        $participant_id = mysqli_insert_id($conn);
        echo '<script>alert("Data Inserted Successfully")</script>';
        echo '<script>window.location.href = "take_test.php?id=' . $participant_id . '"</script>';
    }

}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Participate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin/forms/style.css">
</head>

<body>
    <div class="overlay"></div>
    <div class="main-container">
        <div class="form-container">
            <h2>Participate Now!</h2>

            <!-- Alert -->
            <?php if (isset($error)) { ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php } ?>

            <form method="post" class="needs-validation" novalidate>
                <div class="form-group mt-3">
                    <label class="form-label">Enter Full Name:</label>
                    <input type="text" class="form-control" placeholder="Enter Full Name" name="name" required>
                    <div class="invalid-feedback">
                        Please enter a valid Name.
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="form-label">Enter Email:</label>
                    <input type="email" class="form-control" placeholder="Enter Email" name="email" required>
                    <div class="invalid-feedback">
                        Please enter your Email.
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="form-label">Enter Phone Number:</label>
                    <input type="Number" class="form-control" placeholder="Enter Number" name="num" required>
                    <div class="invalid-feedback">
                        Please enter your 11 digits Number.
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="form-label">Enter Age:</label>
                    <input type="number" class="form-control" placeholder="Enter Age" name="age" required>
                    <div class="invalid-feedback">
                        Only under 18 can Participate.
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="" class="form-label">Select Proficiency Level:</label>
                    <select name="level" class="form-select">
                        <option value="">Select Proficiency level:</option>
                        <option value="">Beginner</option>
                        <option value="">Intermidiate</option>
                        <option value="">Advanced</option>
                        <option value="">Expert</option>
                    </select>
                    <div class="invalid-feedback">
                        Please Select your Proficiency.
                    </div>
                </div>

                <div class="form-group mt-4">
                    <input type="submit" class="btn btn-create-account" value="Participate" name="part-btn">
                </div>
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