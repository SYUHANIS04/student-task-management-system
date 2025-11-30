<?php 
require 'includes/header.php'; 
require 'includes/conn.php'; 
?>

<div class="row justify-content-center py-5">
  <div class="col-md-6">
    <div class="card shadow-lg rounded-4 p-4">
        <h2 class="card-title mb-4 text-center">Register</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="register" class="btn btn-pink w-100">Register</button>
        </form>

        <?php
        if (isset($_POST['register'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username,email,password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $name, $email, $password);

            if ($stmt->execute()) {
                echo "<p class='text-success mt-3 text-center'>Registration successful!</p>";
            } else {
                echo "<p class='text-danger mt-3 text-center'>Error: " . $stmt->error . "</p>";
            }

            $stmt->close();
            $conn->close();
        }
        ?>
    </div>
  </div>
</div>

<?php require 'includes/footer.php'; ?>
