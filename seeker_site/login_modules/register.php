<?php
$message = '';
$hasError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include('../../config.php');

  $username = trim($_POST['username']);
  $contact_number = $_POST['contact-number'];
  $email = strtolower(trim($_POST['email']));
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm-password'];

  if ($password != $confirm_password) {
    $message = "password mismatched!!!";
    $hasError = true;
  }

  if (!$hasError) {
    $sql = "INSERT INTO users (username, contactnumber, email, password, type_of_user) VALUES ('$username','$contact_number','$email','$password', 'seeker');";

    $result = mysqli_query($conn, $sql);

    if ($result) {
      header('Location: login.php');
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="styles/register.css">
</head>

<body>
  <div class="register-container">
    <img src="../../assets/images/login-image2.png" alt="">
    <div class="title">Create an account</div>
    <span class="message"><?php echo $message ?></span>
    <form method="post">
      <div>
        <div class="label">Username</div>
        <input type="text" name="username" class="input-field" placeholder="enter your username" required>

      </div>
      <div>
        <div class="label">Contact Number</div>
        <input type="number" name="contact-number" class="input-field" placeholder="eg. 09929579473" required>

      </div>
      <div>
        <div class="label">Email</div>
        <input type="email" name="email" class="input-field" placeholder="enter your email" required>
      </div>
      <div>
        <div class="label">Password</div>
        <input type="password" name="password" class="input-field" placeholder="enter your password" required>
      </div>
      <div>
        <div class="label">Confirm Password</div>
        <input type="password" name="confirm-password" class="input-field" placeholder="confirm your password" required>
      </div>
      <input type="submit" value="Sign up" class="login-button">
    </form>
    <div class="sign-up-text">
      Already have an account? <span class="sign-up" onclick="window.location.href='login.php'">Sign in!</span>
    </div>
  </div>
</body>

</html>