<?php
session_start();
session_unset();
session_destroy();
require 'includes/header.php';
?>

<div class="text-center py-5">
    <h2 class="card-title mb-4">Goodbye!</h2>
    <p class="lead text-muted mb-4">You have successfully logged out of STMS.</p>
    <a href="index.php" class="btn btn-pink btn-lg rounded-pill px-4">Return to Home</a>
</div>

<?php require 'includes/footer.php'; ?>
