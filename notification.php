<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "miniproject";

// Create connection
$conn = new mysqli($server, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the current date
$current_date = date('Y-m-d');

// Select expired documents
$sql = "SELECT * FROM documents WHERE expiryDate < '$current_date'";
$result = $conn->query($sql);

$notifications = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $notifications[] = [
            "docType" => $row["docType"],
            "expiryDate" => $row["expiryDate"]
        ];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <style>
        .notification {
            background-color: #ffcccc;
            border-left: 6px solid #ff0000;
            margin-bottom: 15px;
            padding: 4px 12px;
            color: #a94442;
        }
    </style>
</head>
<body>

<?php if (!empty($notifications)): ?>
    <div>
        <?php foreach ($notifications as $notification): ?>
            <div class="notification">
                <strong>Expired Document:</strong> <?php echo $notification["docType"]; ?> (Expiry Date: <?php echo $notification["expiryDate"]; ?>)
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No expired documents at this time.</p>
<?php endif; ?>

</body>
</html>
