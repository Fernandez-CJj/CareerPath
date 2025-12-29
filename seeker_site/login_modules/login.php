<?php
session_start();

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include('../../config.php');

  $email = strtolower(trim($_POST['email']));
  $password = $_POST['password'];

  $sql = "SELECT * FROM users";

  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    if ($row['email'] == $email && $row['password'] == $password) {
      $_SESSION['seeker_id'] = $row['id'];
      header('Location: ../dashboard/dashboard.php');
    } else {
      $message = 'invalid email or password';
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
  <link rel="stylesheet" href="styles/login.css">
</head>

<body>
  <form method="post">
    <div class="login-container">
      <div class="left-section">
        <img src="../../assets/images/login-image.png" alt="">
        <p class="slogan">
          “Your smart companion for building professional resumes and
          <span class="highlight">discovering</span> job opportunities tailored to your skills and goals.”
        </p>

      </div>
      <div class="right-section">
        <img src="../../assets/images/login-image2.png" alt="">
        <div class="label">Email</div>
        <input type="email" name="email" class="input-field" placeholder="enter your email">

        <div class="label">Password</div>
        <input type="password" name="password" class="input-field" placeholder="enter your password">
        <span class="message"><?php echo $message ?></span>
        <input type="submit" value="Sign in" class="login-button">
        <div class="sign-up-text">
          Don't have an account? <span class="sign-up" onclick="window.location.href='register.php'">Sign up for free!</span>
        </div>
      </div>
    </div>
  </form>
</body>

</html>