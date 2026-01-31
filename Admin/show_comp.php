<?php
include_once("includes/header.php");
include_once "db.php";

$query = "SELECT * FROM competition ORDER BY comp_id DESC";
$data = mysqli_query($con, $query);
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

<!-- EXPORT SUPPORT -->
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

    /* Table Styles */
    table.dataTable tbody td {
        background: rgba(255, 255, 255, 0.04) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    table.dataTable thead th {
        background: #ff6600 !important;
        color: white !important;
        font-size: 19px;
        padding: 14px;
    }

    /* Hover Effect */
    table.dataTable tbody tr:hover td {
        background: rgba(255, 102, 0, 0.15) !important;
    }

    /* Button Theme */
    .dt-buttons .btn {
        border-radius: 6px !important;
        margin-right: 8px;
        color: white !important;
    }

    .btn-primary {
        background: #ff6600 !important;
    }

    .btn-success {
        background: #3cb371 !important;
    }

    .btn-info {
        background: #17a2b8 !important;
    }

    .btn-danger {
        background: #e63946 !important;
    }

    .btn-warning {
        background: #ff9933 !important;
    }
</style>

<!-- CONTENT -->
<div class="content-area">
    <div class="panel mt-4">
        <h1 class="mb-3 fw-bold" style="color:#ff6600;">All Competitions</h1>
        <?php if (isset($_GET['msg']) && $_GET['msg'] == "deleted") { ?>
            <div class="alert alert-success">Competition deleted successfully!</div>
        <?php } ?>

        <?php if (isset($_GET['msg']) && $_GET['msg'] == "updated") { ?>
            <div class="alert alert-success">Competition updated successfully!</div>
        <?php } ?>

        <?php if (isset($_GET['msg']) && $_GET['msg'] == "error") { ?>
            <div class="alert alert-danger">Error occurred!</div>
        <?php } ?>

        <table id="compTable" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Question</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php // Always put at very top

if (mysqli_num_rows($data) > 0) {
    $count = 1;

    function limit_words($text, $limit = 5)
    {
        $words = explode(" ", $text);
        return implode(" ", array_slice($words, 0, $limit)) . (count($words) > $limit ? "..." : "");
    }

    while ($row = mysqli_fetch_assoc($data)) {

        // ❌ Remove this
        // $_SESSION['comp_time'] = date("d M Y H:i", strtotime($row["start_time"]));

        ?>
        <tr>
            <td><?php echo $count++; ?></td>
            <td><?php echo $row['comp_name']; ?></td>
            <td><?php echo limit_words($row['comp_desc'], 3); ?></td>
            <td><?php echo $row['comp_category']; ?></td>
            <td><?php echo $row['comp_question']; ?></td>
            <td><?php echo date("d M Y H:i", strtotime($row['start_time'])); ?></td>
            <td><?php echo date("d M Y H:i", strtotime($row['end_time'])); ?></td>
            <td>
                <a href="edit_comp.php?id=<?php echo $row['comp_id']; ?>" class="btn btn-sm btn-warning me-2">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                    data-bs-target="#deleteComp-<?php echo $row['comp_id']; ?>">
                    <i class="bi bi-trash-fill"></i> Delete
                </button>
            </td>
        </tr>
        <?php
    }
} else {
    echo "<tr><td colspan='8' class='text-center'>No competitions found</td></tr>";
}
?>
            </tbody>
        </table>
    </div>
</div>

<!-- DELETE COMPETITION MODALS -->
<?php
if (mysqli_num_rows($data) > 0) {
    mysqli_data_seek($data, 0); // Reset pointer
    while ($row = mysqli_fetch_assoc($data)) { ?>
        <div class="modal fade" id="deleteComp-<?php echo $row['comp_id']; ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background:rgba(255,255,255,0.07); backdrop-filter: blur(15px);
                 border-radius:22px; border:1px solid rgba(255,255,255,0.12); color:white;">

                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#ff6600;">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        Are you sure you want to delete
                        <strong><?php echo $row['comp_name']; ?></strong>?
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <a href="delete_comp.php?id=<?php echo $row['comp_id']; ?>" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    <?php }
} ?>

<!-- DATATABLE INIT -->
<script>
    $(document).ready(function () {
        $('#compTable').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            buttons: [
                { extend: 'copy', text: 'Copy', className: 'btn btn-primary' },
                { extend: 'excel', text: 'Excel', className: 'btn btn-success' },
                { extend: 'csv', text: 'CSV', className: 'btn btn-info' },
                { extend: 'pdf', text: 'PDF', className: 'btn btn-danger' },
                { extend: 'print', text: 'Print', className: 'btn btn-warning' }
            ],
            pageLength: 5
        });
    });
</script>

<?php include_once("includes/footer.php"); ?>