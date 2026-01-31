<?php
session_start();
if (isset($_SESSION["useremail"]) && $_SESSION["user_image"] && $_SESSION["userrole"] == 1){

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E-Book Admin Panel</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"/>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    :root {
      --bg: #0d0d0d;
      --panel-bg: #0b0b0b;
      --text: #e9e9e9;
      --muted: #bdbdbd;
      --accent: #ff7a00;
      --sidebar-bg: #000000;
      --search-bg: rgba(255, 255, 255, 0.03);
    }

    body {
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      transition: 0.25s;
      overflow-x: hidden;
    }

    .navbar-admin {
      height: 70px;
      background: var(--accent) !important;
      box-shadow: 0 4px 18px rgba(0, 0, 0, 0.25);
    }

    .navbar-admin .navbar-brand,
    .navbar-admin .nav-link,
    .navbar-admin .nav-text {
      color: #fff;
    }

    .sidebar {
      position: fixed;
      top: 70px;
      left: 0;
      width: 280px;
      height: calc(100% - 70px);
      background: var(--sidebar-bg);
      padding: 60px 20px 20px;
      overflow-y: auto;
      border-right: 2px solid rgba(255, 122, 0, 0.12);
    }

    .sidebar a {
      color: var(--text);
      text-decoration: none;
      display: block;
      padding: 10px;
      border-radius: 6px;
      margin-bottom: 5px;
      font-size: 24px;
      transition: 0.2s;
      margin: 5%;
    }

    .sidebar a:hover {
      background: rgba(255, 255, 255, 0.1);
    }

    .sidebar .dropdown-menu {
      background: var(--panel-bg);
      border: 1px solid rgba(255, 122, 0, 0.2);
    }

    .sidebar .dropdown-item {
      color: var(--text);
    }

    .sidebar .dropdown-item:hover {
      background: rgba(255, 122, 0, 0.15);
      color: #fff;
    }

    .content-area {
      margin-left: 280px;
      padding: 100px 30px 40px;
    }

    .panel {
      background: var(--panel-bg);
      border-radius: 12px;
      padding: 18px;
      color: var(--text);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.18);
      border: 1px solid rgba(255, 255, 255, 0.02);
    }

    @media (max-width: 991px) {
      .sidebar {
        width: 220px;
      }

      .content-area {
        margin-left: 220px;
        padding-top: 180px;
      }
    }

    @media (max-width: 767px) {
      .sidebar {
        display: none;
      }

      .content-area {
        margin-left: 0;
        padding-top: 180px;
      }
    }

    .btn-orange {
      background-color: #ff6600;
      color: #fff;
      border: none;
    }

    .btn-orange:hover {
      background-color: #ff8533;
      color: #fff;
    }

    .dropdown-menu-orange {
      background-color: #ff6600;
    }

    .dropdown-menu-orange .dropdown-item {
      color: #fff;
    }

    .dropdown-menu-orange .dropdown-item:hover {
      background-color: #ff8533;
    }

    .sidebar .nav-link:hover {
      color: rgba(255, 115, 0, 0.836) !important;
    }

    body.light-mode .sidebar .nav-link:hover {
      color: rgba(255, 115, 0, 0.849) !important;
    }
  </style>
</head>

<body>

  <!-- TOP NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-admin px-3 fixed-top">
    <div class="container-fluid">

      <a class="navbar-brand fs-4 fw-bold" href="#">E-Book Admin</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navTop">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navTop">
        <ul class="navbar-nav ms-auto align-items-center">

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle nav-text" href="#" role="button" data-bs-toggle="dropdown">
              <i class="bi bi-person-circle"></i> Admin
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="forms/logout.php">Logout</a></li>
            </ul>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <!-- SIDEBAR -->
  <div class="sidebar">
    <nav class="nav flex-column pt-2">

      <a class="nav-link" href="./index.php">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>
      <hr>
      <!-- USERS DROPDOWN -->
      <div class="dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-people-fill"></i> Users
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="show_users.php">All Users</a></li>
          <li><a class="dropdown-item" href="add_users.php">Add Users</a></li>
        </ul>
      </div>
      <hr>
      <!-- competition -->
      <div class="dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-trophy-fill"></i> Competitions
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="add_comp.php">Add Competitions</a></li>
          <li><a class="dropdown-item" href="show_comp.php">Show Competitions</a></li>
          <li><a class="dropdown-item" href="comp_answers.php">Competitions Answers</a></li>
        </ul>
      </div>
      <hr>
      <!-- CATEGORIES DROPDOWN -->
      <div class="dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-grid-fill"></i> Categories
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="add_category.php">Add Category</a></li>
          <li><a class="dropdown-item" href="show_category.php">Show Category</a></li>
        </ul>
      </div>
      <hr>
      <!-- BOOKS DROPDOWN -->
      <div class="dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-book-fill"></i> Books
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="add_book.php">Add Book</a></li>
          <li><a class="dropdown-item" href="show_book.php">Show Book</a></li>
        </ul>
      </div>

    </nav>
  </div>

  <!-- BOOTSTRAP JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
  <?php }
else{
header("Location: forms/login.php");
}
?>