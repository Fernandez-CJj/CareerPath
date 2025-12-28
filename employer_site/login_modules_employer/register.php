<?php
include "../../config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $name = trim($_POST['name']);
  $contact = trim($_POST['contactNumber']);
  $email = strtolower(trim($_POST['email']));
  $password = trim($_POST['password']);
  $confirm = trim($_POST['confirmpassword']);

  // Password mismatch
  if ($password !== $confirm) {
    $error = "Passwords do not match";
  } else {

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
      $error = "Email already registered";
    } else {

      // Insert new user (plaintext for now)
      $stmt = $conn->prepare(
        "INSERT INTO users (username, contactnumber, email, password)
         VALUES (?, ?, ?, ?)"
      );
      $stmt->bind_param("ssss", $name, $contact, $email, $password);

      if ($stmt->execute()) {
        // ✅ Redirect to employer login page
        header("Location: loginEmployer.php?registered=success");
        exit;
      } else {
        $error = "Registration failed. Please try again.";
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Employer Registration</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      background-color: #f5f7fa;
      margin: 0;
    }

    .right-section {
      position: absolute;
      top: 20px;
      right: 30px;
    }

    .form-container {
      background-color: white;
      width: 520px;
      margin: 100px auto;
      padding: 40px 50px;
      border-radius: 8px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    h2 {
      color: #0c4a86;
      text-align: center;
      margin-bottom: 30px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      margin-bottom: 20px;
    }

    .form-group label {
      color: #0c4a86;
      font-weight: 600;
      margin-bottom: 6px;
    }

    .form-group input {
      height: 48px;
      padding: 0 15px;
      font-size: 15px;
      border-radius: 6px;
      border: 2px solid #0c4a86;
    }

    .form-group input:focus {
      outline: none;
      box-shadow: 0 0 0 2px rgba(12, 74, 134, 0.2);
    }

    .btn-primary {
      width: 100%;
      height: 48px;
      background-color: #0c4a86;
      border: none;
      color: white;
      font-weight: bold;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
    }

    .btn-primary:hover {
      opacity: 0.85;
    }

    .error-message {
      color: red;
      text-align: center;
      margin-bottom: 15px;
      font-size: 14px;
    }

    .form-footer {
      margin-top: 20px;
      text-align: center;
      font-size: 14px;
    }

    .form-footer a {
      color: #0c4a86;
      font-weight: bold;
      text-decoration: none;
    }
  </style>
</head>

<body>

<div class="right-section">
  <img src="../../assets/images/logo.png" width="120">
</div>

<div class="form-container">
  <h2>Create Employer Account</h2>

  <?php if (!empty($error)): ?>
    <div class="error-message"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="form-group">
      <label>Full Name</label>
      <input type="text" name="name" required>
    </div>

    <div class="form-group">
      <label>Contact Number</label>
      <input type="text" name="contactNumber" required>
    </div>

    <div class="form-group">
      <label>Email Address</label>
      <input type="email" name="email" required>
    </div>

    <div class="form-group">
      <label>Password</label>
      <input type="password" name="password" required minlength="6">
    </div>

    <div class="form-group">
      <label>Confirm Password</label>
      <input type="password" name="confirmpassword" required minlength="6">
    </div>

    <button type="submit" class="btn-primary">Create Account</button>
  </form>

  <div class="form-footer">
    Already have an account?
    <a href="loginEmployer.php">Login here</a>
  </div>
</div>

</body>
</html>
