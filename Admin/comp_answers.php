<?php
include_once("includes/header.php");
include_once "db.php";
session_start();

// Fetch answers with part using INNER JOIN
$query = "
    SELECT answers.id, part.part_name, answers.answer, part.id
    FROM answers
    INNER JOIN part 
    ON answers.id = part.id
    ORDER BY answers.id DESC
";
$data = mysqli_query($con, $query);

// Handle making winner
if (isset($_GET['winner_id'])) {
    $_SESSION['winner_id'] = $_GET['winner_id'];
    echo "<script>alert('Participant marked as winner!'); window.location.href='comp_answers.php';</script>";
}

// Function to limit words
function limit_words($text, $limit = 4)
{
    $words = explode(" ", $text);
    return implode(" ", array_slice($words, 0, $limit)) . (count($words) > $limit ? "..." : "");
}

// Handle Delete
if (isset($_GET['delete_id'])) {
    $del_id = intval($_GET['delete_id']);
    $delete_query = "DELETE FROM answers WHERE id = $del_id";
    $delete_part_query = "DELETE FROM part WHERE id = $del_id";

    mysqli_query($con, $delete_query);
    mysqli_query($con, $delete_part_query);

    echo "<script>alert('Participant and answer deleted successfully!'); window.location.href='comp_answers.php';</script>";
}

?>

<!-- jQuery & Bootstrap (only one version each) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

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

    table.dataTable tbody tr:hover td {
        background: rgba(255, 102, 0, 0.15) !important;
    }

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

<div class="content-area">
    <div class="panel mt-4">
        <h1 class="mb-3 fw-bold" style="color:#ff6600;">All Competition Answers</h1>

        <table id="answersTable" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Participant Name</th>
                    <th>Answer Preview</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($data) > 0) {
                    mysqli_data_seek($data, 0);
                    $count = 1;
                    while ($row = mysqli_fetch_assoc($data)) {
                        echo "<tr>
            <td>{$count}</td>
            <td>{$row['part_name']}</td>
            <td>" . limit_words($row['answer']) . "</td>
            <td>
                <button class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#viewAnswer-{$row['id']}'>View Full</button>
                <a href='?delete_id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this participant?\")'>Delete</a>
            </td>
          </tr>";
                        $count++;
                    }

                } else {
                    echo "<tr><td colspan='4' class='text-center'>No answers found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modals (outside table) -->
<?php
mysqli_data_seek($data, 0);
while ($row = mysqli_fetch_assoc($data)) {
    ?>
    <div class="modal fade" id="viewAnswer-<?php echo $row['id']; ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"
                style="background:rgba(255,255,255,0.07); backdrop-filter: blur(15px); border-radius:22px; border:1px solid rgba(255,255,255,0.12); color:white;">
                <div class="modal-header">
                    <h5 class="modal-title" style="color:#ff6600;">Full Answer by <?php echo $row['part_name']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php echo nl2br($row['answer']); ?>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="?winner_id=<?php echo $row['id']; ?>" class="btn btn-success">Make Winner</a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- DataTable JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function () {
        $('#answersTable').DataTable({
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