<?php
session_start(); 

// Function that unsets these session variables and hence logging the user out of their account and clearing the items in their basket. 

unset($_SESSION['EMAIL']); 
unset($_SESSION['USER_ID']);
unset($_SESSION['basket']);

// Redirects user to login page
header('Location: login.php');
exit();
?>