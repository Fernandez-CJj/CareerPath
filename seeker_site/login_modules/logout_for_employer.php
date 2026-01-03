<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
header('Location: ../../employer_site/login_modules_employer/loginEmployer.php');
exit();
