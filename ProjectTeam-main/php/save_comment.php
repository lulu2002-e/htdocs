
<?php

include "../php/db_connection.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $comment_text = htmlspecialchars($_POST['comment_text'], ENT_QUOTES, 'UTF-8');
    

    if (empty($_POST['comment_text'])) {
        throw new Exception("Comment text is required.");
    }
    $room = $_GET['room_id'];
    
    // Insert comment
    $stmt = $conn->prepare("
        INSERT INTO comments (user_id, room_id, comment_text, created_at) 
        VALUES (1, $room, ?, NOW())
    ");
    $stmt->execute([$comment_text]);
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>