<?php
include_once "includes/header.php";
include_once "db.php";

// Fetch categories
$categorydata = mysqli_query($con, "SELECT * FROM category");

// Get book ID from URL
$idtobeupdated = $_GET["index"];

// Fetch book data
$bookdataResult = mysqli_query($con, "SELECT * FROM books WHERE book_id = $idtobeupdated");
$bookdata = mysqli_fetch_assoc($bookdataResult);

// Handle form submission
if(isset($_POST["btnupdatebook"])){

    $bookname = $_POST["bookname"];
    $bookcat = $_POST["bookcat"];
    $bookprice = $_POST["bookprice"];
    $bookdesc = $_POST["bookdesc"];

    $bookimageindb = $bookdata["book_image"];

    // Handle image upload
    if(!empty($_FILES["bookimage"]["name"])){
        $newimagename = $_FILES["bookimage"]["name"];
        $newimagetempname = $_FILES["bookimage"]["tmp_name"];

        if(!is_dir("../bookimages")) mkdir("../bookimages", 0777, true);

        move_uploaded_file($newimagetempname, "../bookimages/".$newimagename);

        // Delete old image
        $oldimagepath = "../bookimages/".$bookimageindb;
        if(file_exists($oldimagepath)){
            unlink($oldimagepath);
        }
    } else {
        $newimagename = $bookimageindb;
    }

    // Update book
    $updatebookquery = "UPDATE `books` SET 
        `book_name`='$bookname',
        `book_category`='$bookcat',
        `book_image`='$newimagename',
        `book_price`=$bookprice,
        `book_desc`='$bookdesc'
        WHERE book_id = $idtobeupdated";

    $res = mysqli_query($con,$updatebookquery);

    if($res){
        echo "<script>alert('Book updated successfully');</script>";
        echo "<script>window.location.href='show_book.php';</script>";
        exit();
    } else {
        echo "<script>alert('Update Error');</script>";
    }

    $bookdataResult = mysqli_query($con, "SELECT * FROM books WHERE book_id = $idtobeupdated");
    $bookdata = mysqli_fetch_assoc($bookdataResult);
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

/* Textarea height fix */
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
.custom-file-input-wrapper { position: relative; width: 100%; }
.custom-file-input {
    width: 100%; height: 50px; opacity: 0; position: absolute; top: 0; left: 0; cursor: pointer; z-index: 2;
}
.custom-file-label {
    display: block; width: 100%; background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255,255,255,0.18);
    border-radius: 30px; padding: 12px 18px; color: #fff; font-size: 20px; cursor: pointer; text-align: left;
    transition: 0.3s; z-index:1;
}
.custom-file-input:focus + .custom-file-label,
.custom-file-input:hover + .custom-file-label {
    border-color: #ff6600;
    box-shadow: 0 0 10px rgba(255, 102, 0, 0.5);
    background: rgba(255, 255, 255, 0.12);
}
</style>

<div class="d-flex justify-content-center align-items-center">
    <div class="card shadow-lg rounded-4 p-5" style="width: 100%; max-width: 700px;">

        <h1 class="text-center mb-4" style="color:#ff6600;">Edit Book</h1>

        <form class="needs-validation" novalidate method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Book Name</label>
                <input type="text" class="form-control" placeholder="Enter Book name" required name="bookname"
                    value="<?php echo $bookdata['book_name']; ?>">
                <div class="invalid-feedback">Please enter a book name.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Book Category</label>
                <select name="bookcat" class="form-control" required>
                    <option selected disabled>-- Select Category --</option>
                    <?php foreach ($categorydata as $category) { ?>
                        <option value="<?php echo $category["category_id"] ?>" 
                            <?php echo ($bookdata['book_category'] == $category['category_id']) ? 'selected' : ''; ?>>
                            <?php echo $category["category_name"]; ?>
                        </option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">Please select a category.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Current Book Image</label><br>
                <img src="../bookimages/<?php echo $bookdata['book_image']; ?>?v=<?php echo time(); ?>" width="200" class="img-thumbnail mb-2">
            </div>

            <div class="mb-3">
                <label class="form-label">Change Book Image</label>
                <div class="custom-file-input-wrapper">
                    <input type="file" class="custom-file-input" name="bookimage">
                    <span class="custom-file-label">Choose file</span>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Book Price</label>
                <input type="number" class="form-control" placeholder="Enter Book Price" required name="bookprice"
                    value="<?php echo $bookdata['book_price']; ?>">
                <div class="invalid-feedback">Please enter a price.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Book Description</label>
                <textarea name="bookdesc" placeholder="Enter Book Description" class="form-control"><?php echo $bookdata['book_desc']; ?></textarea>
                <div class="invalid-feedback">Please enter a description.</div>
            </div>

            <button type="submit" class="btn-submit w-100" name="btnupdatebook">Update Book</button>
        </form>
    </div>
</div>

<script>
(() => {
    'use strict'
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
