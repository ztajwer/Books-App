<?php
include_once "includes/header.php";
include_once "db.php";

$query = "SELECT * FROM books INNER JOIN category ON books.book_category = category.category_id;";
$bookdata = mysqli_query($con, $query);
?>

<!-- DATATABLE CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DATATABLE JS -->
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

<!-- DATATABLE BUTTONS -->
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>

<!-- EXPORT LIBRARIES -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<style>
    body {
        background: #0d0d0d !important;
        color: #fff !important;
        font-family: "Poppins", sans-serif;
        font-size: 20px;
    }

    .content-area {
        margin-left: 280px;
        padding: 100px 30px 40px;
    }

    .panel {
        background: rgba(255, 255, 255, 0.07);
        backdrop-filter: blur(15px);
        border-radius: 22px;
        padding: 30px;
        border: 1px solid rgba(255, 255, 255, 0.12);
    }

    /* Table Styling */
    table.dataTable {
        color: #fff;
        font-size: 20px;
    }

    table.dataTable thead th {
        background: #ff6600 !important;
        color: #fff !important;
        padding: 15px !important;
        border: none !important;
    }

    table.dataTable tbody td {
        background: rgba(255, 255, 255, 0.05) !important;
        padding: 12px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    table.dataTable tbody tr:hover td {
        background: rgba(255, 102, 0, 0.14) !important;
    }

    /* Buttons Theme */
    .dt-buttons .btn {
        border-radius: 6px !important;
        margin-right: 8px;
        color: white !important;
    }

    .btn-primary {
        background: #ff6600 !important;
        border: none;
    }

    .btn-success {
        background: #3cb371 !important;
        border: none;
    }

    .btn-info {
        background: #17a2b8 !important;
        border: none;
    }

    .btn-danger {
        background: #e63946 !important;
        border: none;
    }

    .btn-warning {
        background: #ff9933 !important;
        border: none;
    }

    img {
        max-width: 130px;
        border-radius: 12px;
    }

    .book-desc {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        /* number of lines to show */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<!-- CONTENT -->
<div class="content-area background-dark">
    <div class="panel mt-4">
        <h1 class="mb-3 fw-bold" style="color:#ff6600;">All Books</h1>

        <table id="ebookTable" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Book ID</th>
                    <th>Book Name</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Actions</th>
                    <th>PDF Download</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($bookdata as $book) {
                    $descWords = explode(' ', $book["book_desc"]);
                    $shortDesc = count($descWords) > 4 ? implode(' ', array_slice($descWords, 0, 4)) . '...' : $book["book_desc"];
                    ?>
                    <tr>
                        <td><?php echo $book["book_id"]; ?></td>
                        <td><?php echo $book["book_name"]; ?></td>
                        <td><?php echo $book["category_name"]; ?></td>

                        <td>
                            <img src="../bookimages/<?php echo $book["book_image"]; ?>" alt=""
                                style="width:80px; height:auto;">
                        </td>

                        <td>$<?php echo $book["book_price"]; ?></td>
                        <td><?php echo $shortDesc; ?></td>

                        <td>
                            <a href="update_book.php?index=<?php echo $book["book_id"]; ?>"
                                class="btn btn-warning btn-sm">Edit</a>

                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteModal-<?php echo $book["book_id"]; ?>">
                                Delete
                            </button>
                        </td>
                        <td>
                            <?php if ($book['book_pdf']) { ?>
                                <a class="btn btn-primary" href="../bookpdfs/<?= $book['book_pdf'] ?>" download>Download PDF</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>

    </div>
</div>

<?php foreach ($bookdata as $book) { ?>
    <div class="modal fade" id="deleteModal-<?php echo $book["book_id"] ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="
            background: rgba(255,255,255,0.07);
            backdrop-filter: blur(15px);
            color: #fff;
            border-radius: 22px;
            border:1px solid rgba(255,255,255,0.12);
        ">

                <div class="modal-header">
                    <h5 class="modal-title" style="color:#ff6600;">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    Are you sure you want to delete
                    <strong><?php echo $book["book_name"]; ?></strong>?
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="delete_book.php?index=<?php echo $book["book_id"] ?>" class="btn btn-danger">Delete</a>
                </div>

            </div>
        </div>
    </div>
<?php } ?>

<?php include_once "includes/footer.php"; ?>