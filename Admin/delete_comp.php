<?php
include_once "db.php";

if(isset($_GET['id'])){
    $comp_id = $_GET['id'];
    $delete = mysqli_query($con, "DELETE FROM competition WHERE comp_id = '$comp_id'");

    if($delete){
        header("Location: show_comp.php?msg=deleted");
    } else {
        header("Location: show_comp.php?msg=error");
    }
}
?>
