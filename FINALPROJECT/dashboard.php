<?php
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle delete request
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $post_id = intval($_GET['delete']);
    $user_id = $_SESSION['user_id'];
    
    $conn = getDBConnection();
    // Delete only if post belongs to current user
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    
    header("Location: dashboard.php");
    exit();
}

// User's posts request
$conn = getDBConnection();
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY date DESC, created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_posts_result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard | Find Your Hike!</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="header">
    <a href="index.php"><img class="logo" id="logo" src="logo.png" alt="Logo with mountains on it that spells 'Find Your Hike'"></a>
    <nav id="links">
      <a href="index.php">Home</a>
      <a href="new_article.php">New Spot</a>
      <a href="dashboard.php">Dashboard</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <div style="padding: 20px;">
    <h2>My Hiking Posts</h2>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
    
    <?php if ($user_posts_result->num_rows > 0): ?>
      <table style="width: 100%; margin-top: 20px;">
        <tr>
          <th>Title</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
        <?php while ($post = $user_posts_result->fetch_assoc()): ?>
          <tr>
            <td>
              <a href="article.php?id=<?php echo $post['id']; ?>" style="color: var(--green-dark);">
                <?php echo htmlspecialchars($post['title']); ?>
              </a>
            </td>
            <td><?php echo date('M d, Y', strtotime($post['date'])); ?></td>
            <td>
              <a href="edit_article.php?id=<?php echo $post['id']; ?>">
                <button class="edit-btn">Edit</button>
              </a>
              <a href="dashboard.php?delete=<?php echo $post['id']; ?>" 
                 onclick="return confirm('Are you sure you want to delete this post?');">
                <button class="delete-btn">Delete</button>
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p style="margin-top: 20px; color: #888;">You haven't posted any hiking spots yet.</p>
      <a href="new_article.php"><button style="margin-top: 10px;">Create Your First Post</button></a>
    <?php endif; ?>
  </div>

  <footer>
    <p>© 2025 Hiking Spots Community</p>
  </footer>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>


