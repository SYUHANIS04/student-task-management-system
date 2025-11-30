<?php
session_start();
if(!isset($_SESSION['user'])) header('Location: login.php');

require 'includes/conn.php';
require 'includes/header.php';

$result = $conn->query("SELECT id, username, email, created_at FROM users ORDER BY id ASC");
?>

<div class="card shadow-lg py-4 px-3 mb-5">
    <h2 class="card-title mb-4">Registered Users</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registered At</th>
                </tr>
            </thead>
            <tbody>
            <?php while($user = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
$conn->close();
require 'includes/footer.php'; 
?>
