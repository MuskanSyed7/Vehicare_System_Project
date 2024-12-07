<?php

include '../api/dbconnect.php';
include 'dashboard.php';
while($res=mysqli_fetch_array($result)){

    echo '<tr>';
    echo '<td>'.$res['docname'].'</td>';
    echo '<td>'.$res['issueDate'].'</td>';
    echo '<td>'.$res['expiryDate'].'</td>';
    echo '</tr>';

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicare Dashboard</title>

<style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f7f7f7;
    background-image: url('https://assets.thehansindia.com/h-upload/2023/11/16/1399342-car-insurance2308d.jpg');
    background-size: 100%;
    background-position: center;
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

#card {
  margin-left: 200px;
  border-radius: 10px;
  padding: 30px;
  text-align: center;
  border: 1px solid rgba(255, 255, 255, 0.5);
  backdrop-filter: blur(5px);
  -webkit-backdrop-filter: blur(8px);
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
table {
  width: 70%;
  border:1px solid black;
  align-items: center;
  text-align: center;
  border: 1px solid rgba(255, 255, 255, 0.5);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  position: absolute;
  margin-left: 200px;
}

th {
  height: 70px;
}

    </style>
</head>
<body>

<form action="insert.php" method="post">
    <header>
        <h1>VehiCare Reminder System</h1>
    </header>
    <nav>
       <ul>
            <li><a href="index.php">HOME</a></li>
            <li><a href="">FUEL</a></li>
            <li><a href="">REMINDER</a></li>
            <li><a href="logout.php">LOGOUT</a></li>
        </ul>
    </nav>
    <main>
    <table border="2">
  <tr>
    <th>DocType</th>
    <th>IssueDate</th>
    <th>ExpiryDate</th>
  </tr>
  </table>      
    </main> 
</body>
</html>