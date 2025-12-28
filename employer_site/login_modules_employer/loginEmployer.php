<?php 
include "../../config.php";

session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = strtolower(trim($_POST['email']));
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // Plain-text for now (same as seeker)
    if ($row['password'] === $password) {
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['username'] = $row['username'];

      header("Location: ../company_profile/company_profile.php");
      exit;
    } else {
      $message = "Invalid email or password";
    }
  } else {
    $message = "Invalid email or password";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Employer Login</title>
  <link rel="stylesheet" href="styles/login.css">

  <style>
    body {

  background-color: white;
}
  </style>
</head>

<body>
<form method="POST">
  <div class="login-container">

    <div class="left-section">
      <img src="../../assets/images/login-image.png">
      <p class="slogan">
       “Your smart companion for building professional resumes and  <span class="highlight">discovering</span> job opportunities tailored to your skills and goals.”
        
      </p>
    </div>

    <div class="right-section">
      <img src="../../assets/images/logo.png">

      <div class="label">Email</div>
      <input type="email" name="email" class="input-field" placeholder="Enter your email" required>

      <div class="label">Password</div>
      <input type="password" name="password" class="input-field" placeholder="Enter your password" required>

      <!-- ⚠ ERROR MESSAGE -->
      <?php if (!empty($message)): ?>
        <div class="message"><?= $message ?></div>
      <?php endif; ?>

      <input type="submit" value="Sign In" class="login-button">

      <div class="sign-up-text">
        Don’t have an account?
        <span class="sign-up" onclick="location.href='register.php'">
          Sign up free!
        </span>
      </div>
    </div>

  </div>
</form>
</body>
</html>
