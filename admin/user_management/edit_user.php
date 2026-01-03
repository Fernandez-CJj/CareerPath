<?php
session_start();
include "../../config.php";
include "../header_admin/header_usermanagement.html";

$message = '';
$user = null;

if (isset($_GET['id'])) {
  $user_id = intval($_GET['id']);

  // Fetch user details
  $sql = "SELECT * FROM users WHERE id = $user_id AND type_of_user != 'admin'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
  } else {
    header("Location: user_management.php?error=User not found");
    exit();
  }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user_id = intval($_POST['id']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $contactnumber = mysqli_real_escape_string($conn, $_POST['contactnumber']);
  $type_of_user = mysqli_real_escape_string($conn, $_POST['type_of_user']);

  // Only update password if provided
  if (!empty($_POST['password'])) {
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $sql = "UPDATE users SET username='$username', email='$email', contactnumber='$contactnumber', 
            type_of_user='$type_of_user', password='$password' WHERE id=$user_id AND type_of_user != 'admin'";
  } else {
    $sql = "UPDATE users SET username='$username', email='$email', contactnumber='$contactnumber', 
            type_of_user='$type_of_user' WHERE id=$user_id AND type_of_user != 'admin'";
  }

  if (mysqli_query($conn, $sql)) {
    header("Location: user_management.php?success=User updated successfully");
    exit();
  } else {
    $message = "Error updating user: " . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User - CareerPath</title>
  <style>
    body {
      font-family: "Segoe UI", Arial, sans-serif;
      background-color: #f5f5f5;
      margin: 0;
    }

    .page-header {
      background-color: #0c4a86;
      color: white;
      padding: 30px;
      text-align: center;
      font-size: 28px;
      font-weight: 700;
    }

    .container {
      max-width: 800px;
      margin: 30px auto;
      padding: 40px;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
      margin-bottom: 25px;
    }

    .form-label {
      display: block;
      font-weight: 600;
      color: #0c4a86;
      margin-bottom: 8px;
      font-size: 14px;
    }

    .form-input,
    .form-select {
      width: 100%;
      padding: 12px;
      border: 2px solid #e0e0e0;
      border-radius: 5px;
      font-size: 15px;
      box-sizing: border-box;
    }

    .form-input:focus,
    .form-select:focus {
      outline: none;
      border-color: #0c4a86;
    }

    .button-group {
      display: flex;
      gap: 15px;
      margin-top: 30px;
    }

    .btn {
      padding: 12px 30px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: 600;
      font-size: 15px;
      flex: 1;
    }

    .btn-save {
      background-color: #28a745;
      color: white;
    }

    .btn-save:hover {
      background-color: #218838;
    }

    .btn-cancel {
      background-color: #6c757d;
      color: white;
    }

    .btn-cancel:hover {
      background-color: #5a6268;
    }

    .error-message {
      background-color: #f8d7da;
      color: #721c24;
      padding: 12px;
      border-radius: 5px;
      margin-bottom: 20px;
      border: 1px solid #f5c6cb;
    }

    .info-text {
      font-size: 13px;
      color: #666;
      margin-top: 5px;
    }
  </style>
</head>

<body>
  <div class="page-header">
    ✏️ EDIT USER
  </div>

  <div class="container">
    <?php if ($message): ?>
      <div class="error-message"><?php echo $message; ?></div>
    <?php endif; ?>

    <?php if ($user): ?>
      <form method="POST">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

        <div class="form-group">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-input" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>

        <div class="form-group">
          <label class="form-label">Email Address</label>
          <input type="email" name="email" class="form-input" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>

        <div class="form-group">
          <label class="form-label">Contact Number</label>
          <input type="text" name="contactnumber" class="form-input" value="<?php echo htmlspecialchars($user['contactnumber']); ?>">
        </div>

        <div class="form-group">
          <label class="form-label">User Type</label>
          <select name="type_of_user" class="form-select" required>
            <option value="seeker" <?php echo ($user['type_of_user'] == 'seeker') ? 'selected' : ''; ?>>Job Seeker</option>
            <option value="employer" <?php echo ($user['type_of_user'] == 'employer') ? 'selected' : ''; ?>>Employer</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-input" placeholder="Leave blank to keep current password">
          <div class="info-text">Only fill this field if you want to change the password</div>
        </div>

        <div class="button-group">
          <button type="submit" class="btn btn-save">💾 Save Changes</button>
          <button type="button" class="btn btn-cancel" onclick="window.location.href='user_management.php'">✖️ Cancel</button>
        </div>
      </form>
    <?php endif; ?>
  </div>
</body>

</html>