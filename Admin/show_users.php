<?php
include_once("includes/header.php");
include_once "db.php";

$query = "SELECT users.*, roles.role_name 
          FROM users 
          JOIN roles ON users.role_id = roles.role_id";
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
        <?php if (isset($_GET['msg'])) { ?>
            <div class="alert alert-<?php echo $_GET['msgtype']; ?>">
                <?php echo $_GET['msg']; ?>
            </div>
        <?php } ?>

        <div style="display:flex; justify-content: space-between; align-items: center;">
            <h1 class="mb-3 fw-bold" style="color:#ff6600;">All Users</h1>
            <a href="add_users.php" class="btn btn-secondary" style="background-color:#ff6600 !important;">Add User</a>
        </div>

        <table id="userTable" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($data as $user) { ?>
                    <tr>
                        <td><?php echo $user["user_id"]; ?></td>
                        <td><?php echo $user["user_name"]; ?></td>
                        <td> <img src="forms/useruploads/<?php echo $user['user_image']; ?>" width="80" height="80"
                                style="border-radius:8px;"></td>
                        <td><?php echo $user["user_email"]; ?></td>
                        <td><?php echo $user["role_name"]; ?></td>
                        <?php if ($user["role_id"] == 1) { ?>
                            <td>
                                <button disabled class="btn btn-warning">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>

                                <button disabled class="btn btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        <?php } else { ?>
                            <td>
                                <a href="update_user.php?id=<?php echo $user['user_id']; ?>" class="btn btn-warning">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>

                                <!-- OPEN DELETE MODAL -->
                                <button class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteUser-<?php echo $user['user_id']; ?>">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
</div>

<!-- DELETE USER MODALS -->
<?php foreach ($data as $user) { ?>
    <div class="modal fade" id="deleteUser-<?php echo $user["user_id"]; ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background:rgba(255,255,255,0.07); backdrop-filter: blur(15px);
             border-radius:22px; border:1px solid rgba(255,255,255,0.12); color:white;">

                <div class="modal-header">
                    <h5 class="modal-title" style="color:#ff6600;">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    Are you sure you want to delete
                    <strong><?php echo $user["user_name"]; ?></strong>?
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="delete_users.php?index=<?php echo $user["user_id"]; ?>" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- DATATABLE INIT -->
<script>
    $(document).ready(function () {
        $('#userTable').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            buttons: [
                { extend: 'copy', text: 'Copy', className: 'btn btn-primary text-dark' },
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