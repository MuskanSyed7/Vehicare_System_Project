<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "miniproject";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $category_id = $_POST['category_id'];
    $owner_name = $_POST['owner_name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $vehicle_name = $_POST['vehicle_name'];
    $vehicle_color = $_POST['vehicle_color'];
    $vehicle_registration_number = $_POST['vehicle_registration_number'];
    $vehicle_model = $_POST['vehicle_model'];

    $sql = "INSERT INTO vehicle_details (category_id, owner_name, contact, email, address, vehicle_name, vehicle_color, vehicle_registration_number, vehicle_model)
            VALUES ('$category_id', '$owner_name', '$contact', '$email', '$address', '$vehicle_name', '$vehicle_color', '$vehicle_registration_number', '$vehicle_model')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id_to_delete = $_POST['id_to_delete'];

    // Prepare an SQL statement for deletion
    $stmt = $conn->prepare("DELETE FROM vehicle_details WHERE id = ?");
    
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

// Fetch data from the database
$sql = "SELECT * FROM vehicle_details";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
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

        #tagline {
            text-align: center;
            margin-top: 30px;
            text-decoration: #00215E;
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

        #openFormBtn {
            float: initial;
            color: white;
            background-color: #00215E;
            width: 300px;
            height: 60px;
            font-family: Apple Chancery, cursive;
            font-size: larger;
            font-weight: bold;
            border-radius: 20px;
            border: 3px solid #f7f7f7;
        }

        main {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .modal-header {
            text-align: center;
        }

        #openFormBtn {
            padding: 10px 20px;
            font-size: 16px;
        }

        .popup-form {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 95%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 50%;
            max-height: 100%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow-y: auto;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
        }

        .form-group {
            margin: 20px;
        }

        .modal-body {
            font-weight: bolder;
            font-size: larger;
        }

        #submit {
            float: inline-end;
            color: white;
            background-color: #00215E;
            width: 100px;
            height: 40px;
            font-family: Apple Chancery, cursive;
            font-size: larger;
            font-weight: bold;
            text-align: center;
            border-radius: 5px;
            border: 1px solid #f7f7f7;
        }

        #category_id, #owner_name, #contact, #email, #address, #vehicle_name, #vehicle_color, #vehicle_registration_number, #vehicle_model {
            width: 90%;
            height: 50px;
        }

        /* New styles for vertical table */
        .vehicle-details {
            width: 200%;
            align-items: center;
            margin: 20px auto;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .vehicle-details h3 {
            background-color: #00215E;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            
        }

        .vehicle-details p {
            align-items: center;
            margin: 10px 0;
            font-size: 16px;
        }

        .vehicle-details label {
            font-weight: bold;
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
        <h1 id="tagline"> WELCOME  TO  OUR  WEBSITE !! </h1>
        <button id="openFormBtn">Add vehicle Details</button>

        <div id="popupForm" class="popup-form">
            <div class="form-container">
                <span class="close" id="closeFormBtn">&times;</span>
                <!-- POPUP FORM -->
                <form action="home.php" method="POST">
                    <div class="modal-header">
                        <h2 class="modal-title">Fill the Vehicle Detail Form</h2>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <input type="hidden" name="id">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category_id" class="control-label">Vehicle Type</label><br>
                                            <input type="text" name="category_id" id="category_id" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="owner_name" class="control-label">Owner Fullname</label><br>
                                            <input type="text" name="owner_name" id="owner_name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="contact" class="control-label">Owner Contact #</label><br>
                                            <input type="text" name="contact" id="contact" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="control-label">Owner Email</label><br>
                                            <input type="email" name="email" id="email" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="address" class="control-label">Address</label><br>
                                            <textarea rows="3" name="address" id="address" style="resize:none" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vehicle_name" class="control-label">Vehicle Name</label><br>
                                            <input type="text" name="vehicle_name" id="vehicle_name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="vehicle_color" class="control-label">Vehicle Color</label><br>
                                            <input type="text" name="vehicle_color" id="vehicle_color" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="vehicle_registration_number" class="control-label">Vehicle Registration Number</label><br>
                                            <input type="text" name="vehicle_registration_number" id="vehicle_registration_number" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="vehicle_model" class="control-label">Vehicle Model</label><br>
                                            <input type="text" name="vehicle_model" id="vehicle_model" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit" id="submit">Submit</button>
                     </div>
                 </form>
             </div>
         </div>

         <div class="container">
             <h2>Stored Vehicle Details</h2>

             <?php
             if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='vehicle-details'>
                            <h3>Vehicle Information</h3>
                            <p><label>Vehicle Type:</label> " . $row["category_id"] . "</p>
                            <p><label>Owner Name:</label> " . $row["owner_name"] . "</p>
                            <p><label>Contact:</label> " . $row["contact"] . "</p>
                            <p><label>Email:</label> " . $row["email"] . "</p>
                            <p><label>Address:</label> " . $row["address"] . "</p>
                            <p><label>Vehicle Name:</label> " . $row["vehicle_name"] . "</p>
                            <p><label>Vehicle Color:</label> " . $row["vehicle_color"] . "</p>
                            <p><label>Registration Number:</label> " . $row["vehicle_registration_number"] . "</p>
                            <p><label>Vehicle Model:</label> " . $row["vehicle_model"] . "</p>
                            <form action='home.php' method='POST'>
                                <input type='hidden' name='id_to_delete' value='" . $row["id"] . "'>
                                <button type='submit' name='delete' style='color: white; background-color: red; border: none; padding: 10px; border-radius: 5px; cursor: pointer;'>Delete</button>
                            </form>
                          </div>";
                }
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
        </div>
    </main>

    <script>
        var popupForm = document.getElementById("popupForm");
        var openFormBtn = document.getElementById("openFormBtn");
        var closeFormBtn = document.getElementById("closeFormBtn");

        openFormBtn.onclick = function() {
            popupForm.style.display = "flex";
        }

        closeFormBtn.onclick = function() {
            popupForm.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == popupForm) {
                popupForm.style.display = "none";
            }
        }
    </script>
</body>
</html>
