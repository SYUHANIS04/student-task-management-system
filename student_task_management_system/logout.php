<?php
session_start();

session_unset();
session_destroy();

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Logged Out - STMS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="/student_task_management_system/css/style.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container text-center py-5">
    <div class="card shadow-lg p-5 mx-auto" style="max-width: 500px;">
        <h2 class="card-title mb-3">You are logged out</h2>
        <p class="text-muted mb-4">
            Thank you for using STMS. See you again!
        </p>
        <a href="login.php" class="btn btn-pink btn-lg rounded-pill px-4">
            Login Again
        </a>
    </div>
</div>

</body>
</html>
