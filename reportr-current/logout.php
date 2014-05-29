<?php 
session_start();
$companyID=$_SESSION['companyID'];
unset($_SESSION['companyID']);
unset($_SESSION['login-time']);
unset($_SESSION['logged-in']);
session_destroy();

$query = "?logout=success&companyID=$companyID";
$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
header('HTTP/1.1 303 See Other');
$next_page = "login.php";
header('Location: http://' . $server_dir . $next_page . $query);

?>