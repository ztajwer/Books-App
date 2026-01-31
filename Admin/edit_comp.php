<?php
include_once "includes/header.php";
include_once "db.php";

// Get competition ID from URL safely
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch competition data
$q = mysqli_query($con, "SELECT * FROM competition WHERE comp_id = $id");
if(!$q || mysqli_num_rows($q) == 0){
    echo "<div class='alert alert-danger mt-4'>Competition not found.</div>";
    include_once "includes/footer.php";
    exit();
}
$data = mysqli_fetch_assoc($q);

// Handle form submission
if(isset($_POST['update'])){
    $name = mysqli_real_escape_string($con, $_POST['comp_name']);
    $desc = mysqli_real_escape_string($con, $_POST['comp_desc']);
    $cat = mysqli_real_escape_string($con, $_POST['comp_category']);
    $ques = mysqli_real_escape_string($con, $_POST['comp_question']);
    $start = $_POST['start_time'];
    $end = $_POST['end_time'];

    $updateQuery = "UPDATE competition SET 
        comp_name='$name',
        comp_desc='$desc',
        comp_category='$cat',
        comp_question='$ques',
        start_time='$start',
        end_time='$end'
        WHERE comp_id=$id";

    if(mysqli_query($con, $updateQuery)){
        echo "<script>
            window.location='show_comp.php?msg=updated';
        </script>";
        exit();
    } else {
        echo "<div class='alert alert-danger'>Update failed: ".mysqli_error($con)."</div>";
    }
}
?>

<div class="container col-md-5 card p-5">
    <h2 class="mb-4" style="color:#ff6600;">Edit Competition</h2>

    <form method="POST" class="needs-validation" novalidate>
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="comp_name" class="form-control" 
                value="<?php echo htmlspecialchars($data['comp_name']); ?>" required>
            <div class="invalid-feedback">Please enter competition name.</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="comp_desc" class="form-control" required><?php echo htmlspecialchars($data['comp_desc']); ?></textarea>
            <div class="invalid-feedback">Please enter description.</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <input type="text" name="comp_category" class="form-control" 
                value="<?php echo htmlspecialchars($data['comp_category']); ?>" required>
            <div class="invalid-feedback">Please enter category.</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Question</label>
            <textarea name="comp_question" class="form-control" required><?php echo htmlspecialchars($data['comp_question']); ?></textarea>
            <div class="invalid-feedback">Please enter question.</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Start Time</label>
            <input type="datetime-local" name="start_time" class="form-control" 
                value="<?php echo date('Y-m-d\TH:i', strtotime($data['start_time'])); ?>" required>
            <div class="invalid-feedback">Please select start time.</div>
        </div>

        <div class="mb-3">
            <label class="form-label">End Time</label>
            <input type="datetime-local" name="end_time" class="form-control" 
                value="<?php echo date('Y-m-d\TH:i', strtotime($data['end_time'])); ?>" required>
            <div class="invalid-feedback">Please select end time.</div>
        </div>

        <button type="submit" name="update" class="btn-submit w-100">Update</button>
    </form>
</div>

<script>
// Bootstrap validation
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
})();
</script>

<style>
body {
    background: #0d0d0d !important;
    color: #fff !important;
    font-family: "Poppins", sans-serif;
}

.card {
    background: rgba(255, 255, 255, 0.07) !important;
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 22px;
    box-shadow: 0 0 25px rgba(0, 0, 0, 0.4);
    margin-top: 5%;
}

.form-label {
    font-weight: 500;
    color: #ffa766;
    letter-spacing: 0.5px;
}

input, textarea {
    background: rgba(255, 255, 255, 0.08) !important;
    color: #fff !important;
    border: 1px solid rgba(255, 255, 255, 0.18) !important;
    border-radius: 30px !important;
    padding: 12px 18px !important;
    transition: 0.3s ease;
    font-size: 15px;
}

input:focus, textarea:focus {
    border-color: #ff6600 !important;
    box-shadow: 0 0 10px rgba(255, 102, 0, 0.5) !important;
    background: rgba(255, 255, 255, 0.12) !important;
}

textarea { height: 90px !important; resize: none !important; }

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

<?php include_once "includes/footer.php"; ?>
