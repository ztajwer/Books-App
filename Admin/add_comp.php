<?php
include_once "db.php";
include_once "includes/header.php";

if (isset($_POST["btncomp"])) {
    // Sanitize inputs
    $name = mysqli_real_escape_string($con, $_POST['compname']);
    $desc = mysqli_real_escape_string($con, $_POST['compdesc']);
    $cat = mysqli_real_escape_string($con, $_POST['compcat']);
    $ques = mysqli_real_escape_string($con, $_POST['compques']);
    
    // Format datetime
    $start = str_replace("T", " ", $_POST['start_time']) . ":00";
    $end = str_replace("T", " ", $_POST['end_time']) . ":00";

    // Insert query
    $query = "INSERT INTO competition (comp_name, comp_desc, comp_category, comp_question, start_time, end_time)
              VALUES ('$name', '$desc', '$cat', '$ques', '$start', '$end')";

    $result = mysqli_query($con, $query);

    if ($result) {
        echo '<script>alert("Competition Added Successfully"); window.location.href="show_comp.php";</script>';
        exit();
    } else {
        echo '<div class="alert alert-danger mt-3">Error: ' . mysqli_error($con) . '</div>';
    }
}
?>

<div class="d-flex justify-content-center align-items-center">
    <div class="card shadow-lg rounded-4 p-5" style="width: 100%; max-width: 700px;">
        <h1 class="text-center mb-4" style="color:#ff6600;">Add Competition</h1>

        <form class="needs-validation" novalidate method="post">
            <div class="mb-3">
                <label class="form-label">Competition Name</label>
                <input type="text" class="form-control" name="compname" placeholder="Enter Competition name" required>
                <div class="invalid-feedback">Please enter a Competition name.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Competition Description</label>
                <textarea name="compdesc" class="form-control" placeholder="Enter Competition Description" required></textarea>
                <div class="invalid-feedback">Please enter a description.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Select Competition Type</label>
                <select name="compcat" class="form-control" required>
                    <option selected disabled>-- Select Category --</option>
                    <option value="Biography">Biography</option>
                    <option value="Short Story Contest">Short Story Contest</option>
                    <option value="Children’s Story Contest">Children’s Story Contest</option>
                    <option value="Essay Writing Contest">Essay Writing Contest</option>
                </select>
                <div class="invalid-feedback">Please select a category.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Competition Start Time</label>
                <input type="datetime-local" class="form-control" name="start_time" required>
                <div class="invalid-feedback">Please enter a start time.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Competition End Time</label>
                <input type="datetime-local" class="form-control" name="end_time" required>
                <div class="invalid-feedback">Please enter an end time.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Competition Question</label>
                <textarea name="compques" class="form-control" placeholder="Enter Competition Main Question" required></textarea>
                <div class="invalid-feedback">Please enter a question.</div>
            </div>

            <button type="submit" class="btn-submit w-100" name="btncomp">Add Competition</button>
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
        margin-top: 5%;
    }

    /* Labels */
    .form-label {
        font-weight: 500;
        color: #ffa766;
        letter-spacing: 0.5px;
    }

    /* Inputs */
    input,
    textarea {
        background: rgba(255, 255, 255, 0.08) !important;
        color: #fff !important;
        border: 1px solid rgba(255, 255, 255, 0.18) !important;
        border-radius: 30px !important;
        padding: 12px 18px !important;
        transition: 0.3s ease;
        font-size: 15px;
    }

    select {
        background: rgba(255, 255, 255, 0.08) !important;
        color: #ff6600 !important;
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

    /* Placeholder */
    ::placeholder {
        color: #e4e4e4 !important;
        opacity: 0.8;
    }

    /* Textarea */
    textarea {
        height: 90px !important;
        resize: none !important;
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

    /* Custom File Input */
    .custom-file-input-wrapper {
        position: relative;
        width: 100%;
        margin-bottom: 15px;
    }

    .custom-file-input {
        width: 100%;
        height: 50px;
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
        cursor: pointer;
        z-index: 2;
    }

    .custom-file-label {
        display: block;
        width: 100%;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 30px;
        padding: 12px 18px;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
        text-align: left;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .custom-file-input:focus+.custom-file-label,
    .custom-file-input:hover+.custom-file-label {
        border-color: #ff6600;
        box-shadow: 0 0 10px rgba(255, 102, 0, 0.5);
        background: rgba(255, 255, 255, 0.12);
    }
</style>

<?php include_once "includes/footer.php"; ?>
