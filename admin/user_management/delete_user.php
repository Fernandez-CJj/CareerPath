<?php
session_start();
include "../../config.php";

if (isset($_GET['id'])) {
  $user_id = intval($_GET['id']);

  // Delete the user
  $sql = "DELETE FROM users WHERE id = $user_id AND type_of_user != 'admin'";

  if (mysqli_query($conn, $sql)) {
    header("Location: user_management.php?success=User deleted successfully");
  } else {
    header("Location: user_management.php?error=Failed to delete user");
  }
} else {
  header("Location: user_management.php?error=Invalid request");
}

exit();
