<?php
require '../php/db_connection.php'; 

try {
    $stmt = $conn->prepare("SELECT booking_id, user_id, room_id, booking_date, time_slot, status FROM bookings");
    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information System Department</title>
    <link rel="stylesheet" href="../css/design.css">
</head>
<body>

<nav>       
        <ul>
            <li><a href="structure.html">Admin Dashboard</a></li>
            <li><a href="profile.html">Profile</a></li> 
            <li><a href="#Switch">Switch Account</a></li>
            <li><a href="NotesPage.html">Notes</a></li>
        </ul>
</nav>

    <h1 class="heads">History of Booked Rooms</h1>
    <table>
        <tr>
            <th>Booking ID</th>
            <th>User ID</th>
            <th>Room ID</th>
            <th>Booking Date</th>
            <th>Time Slot</th>
            <th>Status</th>
            <th>Actions</th> 
        </tr>

        <?php
        foreach ($bookings as $booking) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($booking['booking_id']) . "</td>";
            echo "<td>" . htmlspecialchars($booking['user_id']) . "</td>";
            echo "<td>" . htmlspecialchars($booking['room_id']) . "</td>";
            echo "<td>" . htmlspecialchars($booking['booking_date']) . "</td>";
            echo "<td>" . htmlspecialchars($booking['time_slot']) . "</td>";
            echo "<td>" . htmlspecialchars($booking['status']) . "</td>";
            echo "<td>
                    <a href='../php/edit_booking.php?id=" . $booking['booking_id'] . "'>Edit</a> | 
                    <a href='../php/delete_booking.php?id=" . $booking['booking_id'] . "'>Delete</a>
                  </td>";  
            echo "</tr>";
        }
        ?>
        
    </table>

</body>
</html>
