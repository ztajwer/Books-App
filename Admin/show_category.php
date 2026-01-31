<?php
include_once "includes/header.php";
include_once "db.php";

$query = "SELECT * FROM category";
$category = mysqli_query($con, $query);
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
    *{
        margin: 0;
    }
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
    border-bottom: 1px solid rgba(255,255,255,0.08);
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

.btn-primary { background: #ff6600 !important; border: none;}
.btn-success { background: #3cb371 !important; border: none;}
.btn-info { background: #17a2b8 !important; border: none;}
.btn-danger { background: #e63946 !important; border: none;}
.btn-warning { background: #ff9933 !important; border: none;}

</style>

<!-- CONTENT -->
<div class="content-area">
    <div class="panel mt-4">
        <h1 class="mb-3 fw-bold" style="color:#ff6600;">All Categories</h1>

        <table id="categoryTable" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($category as $cat) { ?>
                    <tr>
                        <td><?php echo $cat["category_id"] ?></td>
                        <td><?php echo $cat["category_name"] ?></td>

                        <td>
                            <a href="update_category.php?index=<?php echo $cat["category_id"] ?>" 
                               class="btn btn-warning btn-sm">Edit</a>

                            <button 
                                type="button" 
                                class="btn btn-danger btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal-<?php echo $cat["category_id"] ?>">
                                Delete
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
</div>

<!-- DELETE MODALS (OUTSIDE TABLE — CORRECT WAY) -->
<?php foreach ($category as $cat) { ?>
<div class="modal fade" id="deleteModal-<?php echo $cat["category_id"] ?>" tabindex="-1">
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
                <strong><?php echo $cat["category_name"]; ?></strong>?
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="delete_category.php?index=<?php echo $cat["category_id"] ?>" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<!-- DATATABLE INITIALIZATION -->
<script>
$(document).ready(function() {
    $('#categoryTable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            { extend: 'copy', text: 'Copy', className: 'btn btn-primary' },
            { extend: 'excel', text: 'Excel', className: 'btn btn-success' },
            { extend: 'csv', text: 'CSV', className: 'btn btn-info' },
            { extend: 'pdf', text: 'PDF', className: 'btn btn-danger' },
            { extend: 'print', text: 'Print', className: 'btn btn-warning' }
        ],
        pageLength: 5,
        ordering: true
    });
});
</script>

<?php include_once "includes/footer.php"; ?>
