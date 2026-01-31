<?php
session_start();
if(!isset($_SESSION["username"]) || $_SESSION["userrole"] == 1) {
    header("Location: login.php");
}
?>