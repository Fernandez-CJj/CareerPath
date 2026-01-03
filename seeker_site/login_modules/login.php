<?php
session_start();

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include('../../config.php');

  $email = strtolower(trim($_POST['email']));
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE email = '" . mysqli_real_escape_string($conn, $email) . "'";

  $result = mysqli_query($conn, $sql);

  if ($row = mysqli_fetch_assoc($result)) {
    if ($row['password'] == $password) {
      // Admin shortcut
      if ($email === 'admin@careerpath.com' && $password === 'admin123') {
        header('Location: ../../admin/job_approvals/job_approvals.php');
        exit();
      }

      $user_type = trim(strtolower($row['type_of_user'] ?? ''));

      if ($user_type !== 'seeker') {
        $message = 'only job seekers can sign in here';
      } else {
        $_SESSION['seeker_id'] = $row['id'];
        header('Location: ../dashboard/dashboard.php');
        exit();
      }
    } else {
      $message = 'invalid email or password';
    }
  } else {
    $message = 'invalid email or password';
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