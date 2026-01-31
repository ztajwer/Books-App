<?php
include_once("includes/header.php");
include_once "db.php";

if (isset($_POST["btncategory"])) {
    $categoryname = $_POST["categoryname"];
    $query = "INSERT INTO category (category_name) VALUES ('$categoryname')";
    $res = mysqli_query($con, $query);

    echo "<script>window.location.href = 'show_category.php'</script>";
}
?>

<br><br><br><br>

<!-- ================= AESTHETIC GLASS ORANGE THEME ================= -->
<style>
body {
    background: #0d0d0d !important;
    color: #fff;
    font-family: "Poppins", sans-serif;
}

/* Glass Card */
.card {
    background: rgba(255,255,255,0.07);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 22px;
    box-shadow: 0 0 25px rgba(0,0,0,0.4);
}

/* Labels */
.form-label {
    font-weight: 500;
    color: #ffa766;
    letter-spacing: 0.5px;
}

/* Rounded Inputs */
input {
    background: rgba(255,255,255,0.08) !important;
    color: #fff !important;
    border: 1px solid rgba(255,255,255,0.18) !important;
    border-radius: 30px !important;
    padding: 12px 18px !important;
    font-size: 15px;
    transition: 0.3s ease;
}

/* Focus Glow */
input:focus {
    border-color: #ff6600 !important;
    background: rgba(255,255,255,0.12) !important;
    box-shadow: 0 0 10px rgba(255, 102, 0, 0.5) !important;
}

/* Placeholder */
::placeholder {
    color: #ffffff !important;
    opacity: 0.8;
}

/* Submit Button */
.btn-submit {
    background: linear-gradient(45deg, #ff6600, #ff8c33);
    border: none;
    padding: 18px;
    border-radius: 40px;
    font-size: 20px;
    color: #fff;
    margin-top: 10px;
    transition: 0.3s ease;
    font-weight: 600;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 0 12px rgba(255,102,0,0.6);
}
</style>

<!-- ================= FORM CARD ================= -->
<div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg rounded-4 p-5" style="width: 100%; max-width: 500px;">

        <h2 class="mb-4 " style="color:#ff6600;">Add New Category</h2>

        <form class="needs-validation" novalidate method="post">

            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" class="form-control" placeholder="Enter category name" required name="categoryname">
                <div class="invalid-feedback">Please enter a category name.</div>
            </div>

            <button type="submit" class="btn-submit w-100" name="btncategory">Add Category</button>

        </form>

    </div>
</div>

<!-- Validation Script -->
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
        });
    });
})();
</script>

<?php include_once "includes/footer.php"; ?>
