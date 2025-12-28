<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
header('Location: ../../seeker_site/login_modules/login.php');
exit();
