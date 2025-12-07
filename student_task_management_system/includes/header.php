<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$logged = isset($_SESSION['user']);

$current_page = basename($_SERVER['PHP_SELF']);
$protected_pages = ['dashboard.php', 'tasks.php', 'subjects.php', 'users.php'];

if (!$logged && in_array($current_page, $protected_pages)) {
    header("Location: login.php");
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>STMS - Student Task Management System</title>
<meta name="description" content="Student Task Management System for managing assignments, subjects and schedules.">
<meta name="keywords" content="task manager, student portal, academic system, STMS">
<meta name="author" content="Syuhanis">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="css/style.css" rel="stylesheet">
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg shadow-sm" style="background-color:#ffe4f1;">
  <div class="container">
    
    <!-- Logo -->
    <a class="navbar-brand fw-bold text-pink" href="index.php">
        STMS
    </a>

    <!-- Mobile Toggle -->
    <button class="navbar-toggler border-0" type="button" 
        data-bs-toggle="collapse" data-bs-target="#navbarSTMS" 
        aria-controls="navbarSTMS" aria-expanded="false" 
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu Items -->
    <div class="collapse navbar-collapse" id="navbarSTMS">
      <ul class="navbar-nav ms-auto">

        <?php if ($logged): ?>

            <li class="nav-item">
                <a class="nav-link text-pink" href="dashboard.php">Dashboard</a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-pink" href="tasks.php">Tasks</a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-pink" href="subjects.php">Subjects</a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-pink" href="users.php">Users</a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-danger" href="logout.php">Logout</a>
            </li>

        <?php else: ?>

            <li class="nav-item">
                <a class="nav-link text-pink" href="login.php">Login</a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-pink" href="register.php">Register</a>
            </li>

        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>

<div class="container container-stms">
