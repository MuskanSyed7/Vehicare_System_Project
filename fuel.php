<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "miniproject";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $fuelDate = $_POST['fuelDate'];
    $price = $_POST['price'];

    $sql = "INSERT INTO fuel_details (fuelDate, price) VALUES ('$fuelDate', '$price')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_POST['delete_row'])) {
    $id_to_delete = $_POST['id_to_delete'];
    $sql = "DELETE FROM fuel_details WHERE id = '$id_to_delete'";
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_POST['delete_all'])) {
    $sql = "DELETE FROM fuel_details";
    if ($conn->query($sql) === TRUE) {
        echo "All records deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT id, fuelDate, price FROM fuel_details";
$result = $conn->query($sql);

$total_amount = 0;
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $total_amount += $row["price"];
    }
}
$conn->close();
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

main {
    display: flex;
    flex-wrap: wrap;
    padding: 10px;
}
#vehicleForm{
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    width: 400px;
    border-radius: 8px;
    padding: 30px;
    text-align: center;
    border-color: black;
    border: 1px solid rgba(255, 255, 255, 0.5);
    background-color:#f7f7f7;
    margin-left: 100px;
}

        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 15px;
        }
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 15px;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color:#00215E;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        #result {
            margin-top: 20px;
            font-weight: bold;
        }
        h1 {
            text-align: center;
        }

#card {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 100%;
    height: 200px;
    margin-left: 180px;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 5px;
    color: #555;
}

input[type="date"],
input[type="text"] 
{
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
    box-sizing: border-box;
}

#btn {
    background-color:#00215E;
    color: #fff;
    border: none;
    padding: 10px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.container {
    display: flex;
    justify-content: center;
}
#form1 , #form2
{
    width: 700px;
    float: left;
}
#ht{

margin-left: 30px;
color: aqua;
margin-top: 20px;
text-align: center;
color: #333;
margin-bottom: 20px;
text-align: center;
}
h2 {
    text-align: center;
    color: darkturquoise;
}

table {

    width: 50%;
    border-collapse: collapse;
    margin-top: 100px;
}

table, th, td {

    border: 1px solid #ddd;
    padding: 8px;
}

th {

    background-color: #4CAF50;
    color: white;
    text-align: left;
}

td {
    text-align: left;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
 
    background-color: #ddd;
}

#btnDeleteAll {
    margin-left: 10px;
    background-color: #f44336;
    border-radius: 10px;
}

#btnDeleteAll:hover {
    background-color: #e53935;
}


label {
    display: block;
    margin-bottom: 8px;
    color: #333;
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
    <div id="form1" >
    <h2 id="ht">Calculate Vehicle Distance</h2>

    <form id="vehicleForm" action="fuel.php" method="post">
        <label for="vehicleType">Select Vehicle Type:</label>
        <select id="vehicleType" name="vehicleType">
            <option value="bike">Bike</option>
            <option value="car">Car</option>
            <option value="auto">Auto</option>
            <option value="truck">Truck</option>

        </select>

        <label for="average">Average Mileage (km/liter):</label>
        <input type="number" id="average" name="average" step="any" required>

        <label for="fuel">Fuel Consumed (liters):</label>
        <input type="number" id="fuel" name="fuel" step="any" required>

        <button type="button" onclick="calculateDistance()">Calculate</button>  
    </form>
    </div>

    <div id="result"></div>

    <script>
        function calculateDistance() {
            const vehicleType = document.getElementById('vehicleType').value;
            const average = parseFloat(document.getElementById('average').value);
            const fuel = parseFloat(document.getElementById('fuel').value);

            if (isNaN(average) || isNaN(fuel) || average <= 0 || fuel <= 0) {
                alert('Please enter valid values for average mileage and fuel consumed.');
                return;
            }

            let vehicleName = '';
            switch (vehicleType) {
                case 'bike':
                    vehicleName = 'Bike';
                    break;
                case 'car':
                    vehicleName = 'Car';
                    break;
                case 'auto':
                    vehicleName = 'Auto';
                    break;
                case 'truck':
                    vehicleName = 'Truck';
                    break;
                // Add more cases for other vehicle types if needed
            }

            const distance = average * fuel;
            const resultElement = document.getElementById('result');
            resultElement.textContent = `The ${vehicleName} traveled ${distance.toFixed(2)} kilometers.`;
        }
    </script>
<div id="form2">
    <h2 id="ht">Daily Fuel Detail</h2>
    <div id="card">
        <form id="fuel" action="fuel.php" method="post">
            <label for="fuelDate">Fuel Fill date:</label>
            <input type="date" id="fuelDate" name="fuelDate">
            <label for="price">Price:</label>
            <input type="text" id="price" name="price"><br>
            <div class="container">
                <input type="submit" id="btn" value="Submit" name="submit">
                <input type="submit" id="btnDeleteAll" value="Delete All" name="delete_all">
            </div><br>
        </form>
    </div>
</div><br><br>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Fuel Fill Date</th>
        <th>Price</th>
        <th>Action</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        $result->data_seek(0);
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $row["id"]. "</td>
                <td>" . $row["fuelDate"]. "</td>
                <td>" . $row["price"]. "</td>
                <td>
                    <form method='post' action='fuel.php' style='display:inline;'>
                        <input type='hidden' name='id_to_delete' value='" . $row["id"] . "'>
                        <input type='submit' name='delete_row' value='Delete'>
                    </form>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No records found</td></tr>";
    }
    ?>
    <tr>
        <td colspan="3" style="text-align:right"><strong>Total Amount:</strong></td>
        <td><strong><?php echo $total_amount; ?></strong></td>
    </tr>
</table>
</body>
</html>