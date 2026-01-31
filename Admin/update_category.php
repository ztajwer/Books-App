<?php
include_once("includes/header.php");
include_once("db.php");

$idtobeupdated = $_GET["index"];
$datau = mysqli_query($con, "SELECT * FROM category WHERE category_id = $idtobeupdated");
$categorydata = mysqli_fetch_assoc($datau);

if (isset($_POST["btnupdatecategory"])) {
    $categoryname = $_POST["categoryname"];
    $res = mysqli_query($con, "UPDATE `category` SET `category_name`='$categoryname' WHERE category_id = $idtobeupdated");
    if ($res) {
        echo "<script>window.location.href = 'show_category.php'</script>";
    } else {
        echo "<script>alert('Something Went Wrong')</script>";
        echo "<script>window.location.href = 'show_category.php'</script>";
    }
}
?>

<br><br><br><br>

<style>
body {
    background: #0d0d0d !important;
    color: #fff !important;
    font-family: "Poppins", sans-serif;
}

/* Glass Card */
.card {
    background: rgba(255, 255, 255, 0.07) !important;
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 22px;
    box-shadow: 0 0 25px rgba(0, 0, 0, 0.4);
}

/* Label aesthetic */
.form-label {
    font-weight: 500;
    color: #ffa766;
    letter-spacing: 0.5px;
}

/* Beautiful Rounded Inputs */
input,
select,
textarea {
    background: rgba(255, 255, 255, 0.08) !important;
    color: #ffffff !important;
    border: 1px solid rgba(255, 255, 255, 0.18) !important;
    border-radius: 30px !important;
    padding: 12px 18px !important;
    transition: 0.3s ease;
    font-size: 15px;
}

/* Focus Glow */
input:focus,
select:focus,
textarea:focus {
    border-color: #ff6600 !important;
    box-shadow: 0 0 10px rgba(255, 102, 0, 0.5) !important;
    background: rgba(255, 255, 255, 0.12) !important;
}

/* White placeholders */
::placeholder {
    color: #e4e4e4 !important;
    opacity: 0.8;
}

/* Submit Button */
.btn-submit {
    background: linear-gradient(45deg, #ff6600, #ff8c33);
    border: none;
    padding: 20px;
    border-radius: 40px;
    font-size: 20px;
    color: #fff;
    margin-top: 10px;
    transition: 0.3s ease;
    font-weight: 600;
    letter-spacing: 0.5px;
}
.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 0 12px rgba(255, 102, 0, 0.6);
}
</style>

<div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg rounded-4 p-5" style="width: 100%; max-width: 700px;">
        <h1 class="text-center mb-4" style="color:#ff6600;">Update Category</h1>
        <form class="needs-validation" novalidate method="post">
            <div class="mb-3">
                <label for="categoryName" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="categoryName" placeholder="Enter category name" required
                    name="categoryname" value="<?php echo $categorydata["category_name"] ?>">
                <div class="invalid-feedback">
                    Please enter a category name.
                </div>
            </div>
            <button type="submit" class="btn-submit w-100" name="btnupdatecategory">Update Category</button>
        </form>
    </div>
</div>

<script>
(() => {
    'use strict'
    const forms = document.querySelectorAll('.needs-validation')
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>

<?php include_once("includes/footer.php"); ?>
