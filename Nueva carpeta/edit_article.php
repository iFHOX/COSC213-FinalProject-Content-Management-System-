<?php
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get post ID
$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($post_id === 0) {
    header("Location: dashboard.php");
    exit();
}

// Get post details
$conn = getDBConnection();
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Post doesn't exist or doesn't belong to user
    header("Location: dashboard.php");
    exit();
}

$post = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $image = trim($_POST['image'] ?? '');
    $content = trim($_POST['content'] ?? '');
    
    if (empty($title) || empty($content)) {
        $error = "Please fill in all required fields!";
    } else {
        // Update post
        $stmt = $conn->prepare("UPDATE posts SET title = ?, image = ?, content = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("sssii", $title, $image, $content, $post_id, $user_id);
        
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            
            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Error updating post: " . $stmt->error;
        }
        
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Hiking Spot | Find Your Hike!</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="header">
      <a href="index.php"><img class="logo" id="logo" src="logo.png" alt="Logo with mountains on it that spells 'Find Your Hike'"></a>
  </header>

  <form method="POST" action="edit_article.php?id=<?php echo $post_id; ?>" class="form-container">
    <h2>Edit Hiking Spot</h2>

    <?php if (isset($error)): ?>
      <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <label>Title:</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>

    <label>Image URL:</label>
    <input type="text" name="image" value="<?php echo htmlspecialchars($post['image']); ?>" placeholder="https://example.com/image.jpg">

    <label>Description:</label>
    <textarea name="content" rows="6" required><?php echo htmlspecialchars($post['content']); ?></textarea>

    <div style="display: flex; gap: 10px;">
      <button type="submit">Update</button>
      <a href="dashboard.php"><button type="button" style="background: #888;">Cancel</button></a>
    </div>
  </form>

  <footer>
    <p>© 2025 Hiking Spots Community</p>
  </footer>
</body>
</html>
