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

main{
    align-items: center;
    margin-top: 100px;
    margin-left: 100px;
    margin-right: 100px;

}

#about{
  margin-left: 200px;
  border-radius: 10px;
  padding: 30px;
  width: 70%;
  height: 200px;
  text-align: center;
  border: 1px solid black;
  background-color:#f7f7f7;
  float: left;
  text-align: justify;
  font-family: Arial, Helvetica, sans-serif;
  font-style: normal;
  font-size: 27px;
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
    <div id="about"> 
        The VehiCare Reminder system aims to develop a comprehensive system for managing essential 
        vehicle-related information, including Pollution Under Control (PUC) certification, insurance 
        details, and fuel-related data. The project emphasizes the importance of timely maintenance and 
        compliance with regulatory requirements by providing reminders for expiry dates of PUC certification
         and insurance policies.
         </div>
</main>
</body>
</html>