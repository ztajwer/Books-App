<?php
include_once("db.php");
$rolesdata = mysqli_query($con, "SELECT * FROM roles");
include_once("includes/header.php");

// ───────────────────
// VALIDATE ID
// ───────────────────
if (!isset($_GET["id"])) {
    echo "<script>alert('User not found'); window.location='show_users.php';</script>";
    exit;
}

$idtobeupdated = intval($_GET["id"]); // SECURITY FIX

// ───────────────────
// GET USER DETAILS
// ───────────────────
$userdata = mysqli_query($con, "SELECT * FROM users WHERE user_id = $idtobeupdated");
$user = mysqli_fetch_assoc($userdata);

if (!$user) {
    echo "<script>alert('Invalid user ID'); window.location='show_users.php';</script>";
    exit;
}

// ───────────────────
// UPDATE USER
// ───────────────────
if (isset($_POST["btn-register"])) {

    $fullname = mysqli_real_escape_string($con, $_POST["fullname"]);
    $email = mysqli_real_escape_string($con, $_POST["useremail"]);
    $roleid = intval($_POST["roleid"]);

    // Keep previous image by default
    $imageName = $user["user_image"];

    // ───────────────────
    // NEW IMAGE UPLOADED?
    // ───────────────────
    if (!empty($_FILES["pfp"]["name"])) {

        $allowed = ["jpg", "jpeg", "png", "webp"];
        $ext = strtolower(pathinfo($_FILES["pfp"]["name"], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            echo "<script>alert('Invalid image type (Only JPG, PNG, WEBP allowed)');</script>";
        } else {

            // Generate new filename
            $imageName = $email . "." . $ext;

            $temp = $_FILES["pfp"]["tmp_name"];
            $path = "forms/useruploads/" . $imageName;

            move_uploaded_file($temp, $path);
        }
    }

    // ───────────────────
    // UPDATE QUERY
    // ───────────────────
    $updateQuery = "
        UPDATE users SET 
            user_name = '$fullname',
            user_email = '$email',
            role_id = $roleid,
            user_image = '$imageName'
        WHERE user_id = $idtobeupdated
    ";

    $update = mysqli_query($con, $updateQuery);

    if ($update) {
        echo "<script>alert('User updated successfully'); window.location='show_users.php';</script>";
    } else {
        echo "<script>alert('Something went wrong while updating');</script>";
    }
    // ───────────────────
// NEW IMAGE UPLOADED?
// ───────────────────
    if (!empty($_FILES["pfp"]["name"])) {

        $allowed = ["jpg", "jpeg", "png", "webp"];
        $ext = strtolower(pathinfo($_FILES["pfp"]["name"], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            echo "<script>alert('Invalid image type (Only JPG, PNG, WEBP allowed)');</script>";
        } else {

            // DELETE OLD IMAGE FIRST
            if (!empty($user["user_image"])) {
                $oldImagePath = "forms/useruploads/" . $user["user_image"];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $imageName = $email . "." . $ext;

            $temp = $_FILES["pfp"]["tmp_name"];
            $path = "forms/useruploads/" . $imageName;

            move_uploaded_file($temp, $path);
        }
    }

}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="forms/style.css">
</head>

<body>

    <div class="overlay"></div>
    <div class="main-container">
        <div class="form-container">
            <h2>Update User</h2>

            <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>

                <div class="form-group mt-3">
                    <label class="form-label">Profile Image:</label>
                    <input type="file" class="form-control" name="pfp">
                    <br>
                    <img src="forms/useruploads/<?php echo $user['user_image']; ?>" width="80" height="80"
                        style="border-radius:8px;">
                </div>

                <div class="form-group mt-3">
                    <label class="form-label">Full Name:</label>
                    <input type="text" class="form-control" name="fullname" value="<?php echo $user['user_name']; ?>"
                        required>
                </div>

                <div class="form-group mt-3">
                    <label class="form-label">Email:</label>
                    <input type="email" class="form-control" name="useremail" value="<?php echo $user['user_email']; ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="roleid" class="form-select" required>
                        <option disabled>-- Select Role --</option>
                        <?php foreach ($rolesdata as $role) { ?>
                            <option value="<?php echo $role['role_id']; ?>" <?php if ($user["role_id"] == $role["role_id"])
                                   echo "selected"; ?>>
                                <?php echo $role["role_name"]; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group mt-4">
                    <input type="submit" class="btn btn-create-account" value="Update" name="btn-register">
                </div>

            </form>

        </div>
    </div>

</body>

</html>