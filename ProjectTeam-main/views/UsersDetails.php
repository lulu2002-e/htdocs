<?php
require '../php/db_connection.php'; 

try {
    $stmt = $conn->prepare('SELECT * FROM users'); 
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC); 

    if (!$users) {
        throw new Exception("No users found.");
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

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>

    <nav>       
        <ul>
            <li><a href="structure.html">Admin Dashboard</a></li>
            <li><a href="profile.html">Profile</a></li> 
            <li><a href="#Switch">Switch Account</a></li>
            <li><a href="NotesPage.html">Notes</a></li>
        </ul>
    </nav>

</head>
<body>
    <h1 class="heads">All User Details</h1>

    <table>
        <thead>
            <tr>
                <?php 
             
                if (!empty($users)) {
                    foreach (array_keys($users[0]) as $column) {
                        echo "<th>" . htmlspecialchars($column) . "</th>";
                    }
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($users as $user) {
                echo "<tr>";
                foreach ($user as $column => $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
