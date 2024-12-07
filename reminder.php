<?php
include 'notification.php';
?>

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

// Process form submission
if (isset($_POST['submit'])) {
    $docType = $_POST['docType'];
    $issueDate = $_POST['issueDate'];
    $expiryDate = $_POST['expiryDate'];

    // Prepare an SQL statement for insertion
    $stmt = $conn->prepare("INSERT INTO documents (docType, issueDate, expiryDate) VALUES (?, ?, ?)");
    
    // Bind parameters to the SQL query
    $stmt->bind_param("sss", $docType, $issueDate, $expiryDate);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Handle delete request
if (isset($_POST['delete'])) {
    $id_to_delete = $_POST['id_to_delete'];

    // Prepare an SQL statement for deletion
    $stmt = $conn->prepare("DELETE FROM documents WHERE id = ?");
    
    // Bind parameters to the SQL query
    $stmt->bind_param("i", $id_to_delete);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicare Dashboard</title>

    <style>
        /* Include the styles from your original HTML */
        body {
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            background-image: url('https://assets.thehansindia.com/h-upload/2023/11/16/1399342-car-insurance2308d.jpg');
            background-size: 100%;
            background-position: center;
            background-attachment: fixed;
        }

        header {
            background-color: #00215E;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            text-align: center;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            font-weight: bold;
            text-decoration: double;
            color: #333;
        }

        nav ul li .bell {
            position: relative;
            display: inline-block;
        }

        nav ul li .bell .notification-count {
            position: absolute;
            top: -10px;
            right: -10px;
            background: red;
            color: white;
            border-radius: 50%;
            padding: 5px 10px;
            font-size: 12px;
        }

        main {
            display: flex;
            flex-wrap: wrap;
            padding: 10px;
        }

        #issue {
            float: right;
            margin-left: 200px;
        }

        #dt {
            border-radius: 7px;
        }

        #card {
            margin-left: 200px;
            border-radius: 10px;
            padding: 30px;
            width: 70%;
            height: 70px;
            text-align: center;
            border: 1px solid black;
            background-color: #f7f7f7;
            float: left;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .field {
            text-align: center;
            margin-top: 20px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #btn {
            background: #fff;
            color: #f7f7f7;
            font-weight: 600;
            border: none;
            padding: 10px 30px;
            cursor: pointer;
            border-radius: 10px;
            font-size: 16px;
            border: 2px solid transparent;
            background-color: #00215E;
            margin-top: 20px;
            align-items: center;
            transition: 0.3s ease;
            display: flex;
        }

        #btn:hover {
            color: #fff;
            border-color: #fff;
            background: rgba(255, 255, 255, 0.15);
        }

        table {
            width: 72%;
            border: 2px solid black;
            align-items: center;
            text-align: center;
            background-color: #f7f7f7;
            position: absolute;
            margin-left: 220px;
        }

        th {
            height: 70px;
        }

        .expired {
            color: red;
        }

        .expiry-date {
            color: red;
        }
    </style>
</head>
<body>

<header>
    <h1>VehiCare Reminder System</h1>
</header>
<nav>
    <ul>
        <li><a href="home.php">HOME</a></li>
        <li><a href="fuel.php">FUEL</a></li>
        <li><a href="reminder.php">ADD REMINDER</a></li>
        <li><a href="logout.php">LOGOUT</a></li>
        <li><a href="about.php">ABOUT</a></li>
        <li>
            <a href="notification.php" class="bell">NOTIFICATION
                <?php if (!empty($notifications)): ?>
                    <span class="notification-count"><?php echo count($notifications); ?></span>
                <?php endif; ?>
            </a>
        </li>
    </ul>
</nav>
<main>
    <div id="card">
        <form action="reminder.php" method="post">
            <label for="docType">Choose doc type:</label>
            <select id="docType" name="docType">
                <option value="licence">Licence</option>
                <option value="insurance">Insurance</option>
                <option value="PUC">PUC</option>
                <option value="servicing">Servicing</option>
                <option value="tire Gas">Tire Pressure</option>
            </select>
            
            <label for="issueDate">Issuing Date:</label>
            <input type="date" id="issueDate" name="issueDate">

            <label for="expiryDate">Expiry Date:</label>
            <input type="date" id="expiryDate" name="expiryDate" class="expiry-date">

            <div class="container">
                <input type="submit" id="btn" value="Submit" name="submit">
            </div><br>
        </form>
    </div>
</main><br><br>

<table border="2">
    <tr>
        <th>DocType</th>
        <th>IssueDate</th>
        <th>ExpiryDate</th>
        <th>Action</th>
    </tr>
    <?php
    $conn = new mysqli($server, $username, $password, $database);

    $sql = "SELECT * FROM documents";
    $result = $conn->query($sql);
    $current_date = date('Y-m-d');

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $expired = $row["expiryDate"] < $current_date ? 'expired' : '';
            echo "<tr>
                    <td>".$row["docType"]."</td>
                    <td>".$row["issueDate"]."</td>
                    <td class='expiry-date ".$expired."'>".$row["expiryDate"]."</td>
                    <td>
                        <form method='post' action='reminder.php'>
                            <input type='hidden' name='id_to_delete' value='".$row["id"]."'>
                            <input type='submit' name='delete' value='Delete'>
                        </form>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No records found</td></tr>";
    }
    
    $conn->close();
    ?>
</table>

</body>
</html>
