<?php
require '../php/db_connection.php'; 

try {
    $stmt = $conn->prepare('SELECT * FROM comments'); 
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC); 

    if (!$comments) {
        throw new Exception("No comments found.");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/design.css">

    <nav>       
        <ul>
            <li><a href="structure.html">Admin Dashboard</a></li>
            <li><a href="profile.html">Profile</a></li> 
            <li><a href="#Switch">Switch Account</a></li>
            <li><a href="NotesPage.html">Notes</a></li>
        </ul>
    </nav>

</br>
</head>
<body>
    <h1 class="heads"> Details</h1>
</body>
</html>



<table>
    <tr>
        <th>Comment ID</th>
        <th>User ID</th>
        <th>Room ID</th>
        <th>Comment</th>
        <th>Created At</th>
    </tr>
    <?php
  
    foreach ($comments as $comment) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($comment['comment_id']) . "</td>";
        echo "<td>" . htmlspecialchars($comment['user_id']) . "</td>";
        echo "<td>" . htmlspecialchars($comment['room_id']) . "</td>";
        echo "<td>" . htmlspecialchars($comment['comment_text']) . "</td>";
        echo "<td>" . htmlspecialchars($comment['created_at']) . "</td>";
        echo "</tr>";
    }
    ?>
</table>
