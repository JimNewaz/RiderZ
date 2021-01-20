<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message

if (isset($_POST['submit'])) {
if (empty($_POST['admin_username']) || empty($_POST['admin_password'])) {
$error = "Username or Password is invalid";
}
else
{
// Define $username and $password
$admin_username=$_POST['admin_username'];
$admin_password=$_POST['admin_password'];


// Establishing Connection with Server by passing server_name, user_id and password as a parameter
require 'connection.php';
$conn = Connect();

// SQL query to fetch information of registerd users and finds user match.
$query = "SELECT admin_username, admin_password FROM admin WHERE admin_username=? AND admin_password=? LIMIT 1";

// To protect MySQL injection for Security purpose
$stmt = $conn->prepare($query);
$stmt -> bind_param("ss", $admin_username, $admin_password);
$stmt -> execute();
$stmt -> bind_result($admin_username, $admin_password);
$stmt -> store_result();

if ($stmt->fetch())  //fetching the contents of the row
{
	$_SESSION['login_client']=$admin_username; // Initializing Session
	header("location: index.php"); // Redirecting To Other Page
} else {
$error = "Username or Password is invalid";
}
mysqli_close($conn); // Closing Connection
}
}
?>