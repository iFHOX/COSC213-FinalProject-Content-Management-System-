<?php
require_once 'config.php';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Basic validation
    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {
        // Check credentials in database
        $conn = getDBConnection();
        
        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, email, password, username, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Login successful: Create session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                $stmt->close();
                $conn->close();
                
                // Redirect to dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid credentials!";
            }
        } else {
            $error = "Invalid credentials!";
        }
        
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | Find Your Hike!</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="header">
      <a href="index.php"><img class="logo" id="logo" src="logo.png" alt="Logo with mountains on it that spells 'Find Your Hike'"></a>
  </header>

  <form method="POST" action="login.php" class="form-container">
    <h2>Login</h2>

    <?php if (isset($error)): ?>
        <p id="message" style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <label>Email:</label>
    <input type="email" id="email" name="email" required>

    <label>Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Login</button>
    
    <p style="margin-top: 15px;">Demo credentials: admin@hiking.com / admin123<br>user@hiking.com / user123</p>
  </form>

  <footer>
    <p>© 2025 Hiking Spots Community</p>
  </footer>
</body>
</html>

