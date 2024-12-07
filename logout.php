<?php
// Perform logout actions here (e.g., session destroy, redirect, etc.)
session_start();
session_destroy();
header("Location: login.php");
exit;

