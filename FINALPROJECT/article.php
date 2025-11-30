<?php
require_once 'config.php';

// Get article ID from URL
$article_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($article_id === 0) {
    header("Location: index.php");
    exit();
}

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {
    $username = trim($_POST['username'] ?? '');
    $comment_text = trim($_POST['commentText'] ?? '');
    
    if (!empty($username) && !empty($comment_text)) {
        $conn = getDBConnection();
        $stmt = $conn->prepare("INSERT INTO comments (post_id, username, comment) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $article_id, $username, $comment_text);
        
        if ($stmt->execute()) {
            $success_msg = "Comment posted successfully!";
        }
        
        $stmt->close();
        $conn->close();
    }
}

// Fetch article details
$conn = getDBConnection();
$stmt = $conn->prepare("SELECT posts.*, users.username 
                        FROM posts 
                        JOIN users ON posts.user_id = users.id 
                        WHERE posts.id = ?");
$stmt->bind_param("i", $article_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: index.php");
    exit();
}

$article = $result->fetch_assoc();
$stmt->close();

// Fetch comments for this article
$stmt = $conn->prepare("SELECT * FROM comments WHERE post_id = ? ORDER BY date DESC");
$stmt->bind_param("i", $article_id);
$stmt->execute();
$comments_result = $stmt->get_result();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($article['title']); ?> | Find Your Hike!</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="header">
    <a href="index.php"><img class="logo" id="logo" src="logo.png" alt="Logo with mountains on it that spells 'Find Your Hike'"></a>
  </header>

  <article id="article-view" class="full-article"><h1><?php echo htmlspecialchars($article['title']); ?></h1>
    <p class="meta">Posted by <?php echo htmlspecialchars($article['username']); ?> on <?php echo date('M d, Y', strtotime($article['date'])); ?></p>
    <?php if (!empty($article['image'])): ?>
      <img src="<?php echo htmlspecialchars($article['image']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>">
    <?php endif; ?>
    <p><?php echo nl2br(htmlspecialchars($article['content'])); ?></p></article>

  <section id="comments">
    <h3>Comments (<?php echo $comments_result->num_rows; ?>)</h3>
    
    <div id="comments-list">
      <?php if ($comments_result->num_rows > 0): ?>
        <?php while ($comment = $comments_result->fetch_assoc()): ?>
          <div class="comment">
            <p><strong><?php echo htmlspecialchars($comment['username']); ?>:</strong> 
               <?php echo htmlspecialchars($comment['comment']); ?>
               <span style="color: #888; font-size: 0.9em; margin-left: 10px;">
                 (<?php echo date('M d, Y g:i A', strtotime($comment['date'])); ?>)
               </span>
            </p>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p style="color: #888;">No comments yet. Be the first to comment!</p>
      <?php endif; ?>
    </div>

    <form method="POST" action="article.php?id=<?php echo $article_id; ?>" id="commentForm">
      <label for="username">Name:</label>
      <input type="text" id="username" name="username" required>

      <label for="commentText">Comment:</label>
      <textarea id="commentText" name="commentText" rows="3" required></textarea>

      <button type="submit" name="submit_comment">Post Comment</button>
    </form>
    
    <?php if (isset($success_msg)): ?>
      <p id="commentMsg" style="color: green;"><?php echo $success_msg; ?></p>
    <?php endif; ?>
  </section>

  <footer>
    <p>© 2025 Hiking Spots Community</p>
  </footer>
</body>
</html>


