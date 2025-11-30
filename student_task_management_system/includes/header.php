<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$logged = isset($_SESSION['user']);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>STMS - Student Task Management System</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="/student_task_management_system/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container">
    <a class="navbar-brand" href="/student_task_management_system/index.php">STMS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbars"
        aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbars">
      <ul class="navbar-nav ms-auto">
        <?php if($logged): ?>
            <li class="nav-item"><a class="nav-link" href="/student_task_management_system/dashboard.php">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="/student_task_management_system/tasks.php">Tasks</a></li>
            <li class="nav-item"><a class="nav-link" href="/student_task_management_system/subjects.php">Subjects</a></li>
            <li class="nav-item"><a class="nav-link" href="/student_task_management_system/users.php">Users</a></li> <!-- Added Users link -->
            <li class="nav-item"><a class="nav-link" href="/student_task_management_system/logout.php">Logout</a></li>
        <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="/student_task_management_system/login.php">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="/student_task_management_system/register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
