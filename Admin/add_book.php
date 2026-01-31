<?php
include_once "includes/header.php";
include_once "db.php";

// Fetch categories
$categorydata = mysqli_query($con, "SELECT * FROM category");

if (isset($_POST["btnbook"])) {
    $bookcat = $_POST["bookcat"];

    // Book Image
    $bookimage = $_FILES["bookimage"]["name"];
    $bookimage_tmp = $_FILES["bookimage"]["tmp_name"];
    $imageMoved = move_uploaded_file($bookimage_tmp, "../bookimages/" . $bookimage);

    // Book PDF
    $bookpdf = $_FILES["bookpdf"]["name"];
    $bookpdf_tmp = $_FILES["bookpdf"]["tmp_name"];
    $pdfMoved = move_uploaded_file($bookpdf_tmp, "../bookpdfs/" . $bookpdf);

    if ($imageMoved && $pdfMoved) {
        $bookname = mysqli_real_escape_string($con, $_POST["bookname"]);
        $bookprice = $_POST["bookprice"];
        $bookdesc = mysqli_real_escape_string($con, $_POST["bookdesc"]);

        $query = "INSERT INTO books 
                  (book_name, book_category, book_image, book_price, book_desc, book_pdf)
                  VALUES ('$bookname', $bookcat, '$bookimage', $bookprice, '$bookdesc', '$bookpdf')";

        $res = mysqli_query($con, $query);

        if ($res) {
            echo "<script>alert('Book added successfully')</script>";
            echo "<script>window.location.href = 'show_book.php'</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "')</script>";
        }
    } else {
        echo "<script>alert('Failed to upload image or PDF')</script>";
    }
}
?>

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

/* Labels */
.form-label {
    font-weight: 500;
    color: #ffa766;
    letter-spacing: 0.5px;
}

/* Inputs */
input, select, textarea {
    background: rgba(255, 255, 255, 0.08) !important;
    color: #fff !important;
    border: 1px solid rgba(255, 255, 255, 0.18) !important;
    border-radius: 30px !important;
    padding: 12px 18px !important;
    transition: 0.3s ease;
    font-size: 15px;
}

/* Focus Glow */
input:focus, select:focus, textarea:focus {
    border-color: #ff6600 !important;
    box-shadow: 0 0 10px rgba(255, 102, 0, 0.5) !important;
    background: rgba(255, 255, 255, 0.12) !important;
}

/* Placeholder */
::placeholder { color: #e4e4e4 !important; opacity: 0.8; }

/* Textarea */
textarea { height: 90px !important; resize: none !important; }

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
.custom-file-input-wrapper { position: relative; width: 100%; margin-bottom: 15px; }
.custom-file-input {
    width: 100%; height: 50px; opacity: 0;
    position: absolute; top: 0; left: 0; cursor: pointer; z-index: 2;
}
.custom-file-label {
    display: block; width: 100%; background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.18);
    border-radius: 30px; padding: 12px 18px; color: #fff;
    font-size: 16px; cursor: pointer; transition: 0.3s; text-align: left;
    overflow: hidden; white-space: nowrap; text-overflow: ellipsis;
}
.custom-file-input:focus + .custom-file-label,
.custom-file-input:hover + .custom-file-label {
    border-color: #ff6600;
    box-shadow: 0 0 10px rgba(255, 102, 0, 0.5);
    background: rgba(255,255,255,0.12);
}
</style>

<div class="d-flex justify-content-center align-items-center">
    <div class="card shadow-lg rounded-4 p-5" style="width: 100%; max-width: 700px;">
        <h1 class="text-center mb-4" style="color:#ff6600;">Add Book Below</h1>

        <form class="needs-validation" novalidate method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Book Name</label>
                <input type="text" class="form-control" placeholder="Enter Book name" required name="bookname">
                <div class="invalid-feedback">Please enter a book name.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Book Category</label>
                <select name="bookcat" class="form-control" required>
                    <option selected disabled>-- Select Category --</option>
                    <?php foreach ($categorydata as $category) { ?>
                        <option value="<?= $category["category_id"] ?>">
                            <?= $category["category_name"]; ?>
                        </option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">Please select a category.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Book Image</label>
                <div class="custom-file-input-wrapper">
                    <input type="file" class="custom-file-input" name="bookimage" required>
                    <span class="custom-file-label">Choose Image</span>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Book PDF</label>
                <div class="custom-file-input-wrapper">
                    <input type="file" class="custom-file-input" name="bookpdf" accept="application/pdf" required>
                    <span class="custom-file-label">Choose PDF</span>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Book Price</label>
                <input type="number" class="form-control" placeholder="Enter Book Price" required name="bookprice">
                <div class="invalid-feedback">Please enter a price.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Book Description</label>
                <textarea name="bookdesc" placeholder="Enter Book Description" class="form-control"></textarea>
                <div class="invalid-feedback">Please enter a description.</div>
            </div>

            <button type="submit" class="btn-submit w-100" name="btnbook">Add Book</button>
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

const fileInputs = document.querySelectorAll(".custom-file-input");
fileInputs.forEach(input => {
    input.addEventListener("change", function () {
        const fileName = this.files[0]?.name || "Choose file";
        this.nextElementSibling.textContent = fileName;
    });
});
</script>

<?php include_once "includes/footer.php"; ?>
