<?php

include "../../config.php";
include "../header_admin/header_usermanagement.html";

// Fetch all users except admins
$sql = "SELECT id, username, profile, contactnumber, email, type_of_user, created_at FROM users WHERE type_of_user != 'admin' ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

// Store all users in an array and count by type
$users = [];
$employer_count = 0;
$seeker_count = 0;

while ($row = mysqli_fetch_assoc($result)) {
  $users[] = $row;
  $user_type = trim(strtolower($row['type_of_user']));

  if ($user_type == 'employer') {
    $employer_count++;
  } elseif ($user_type == 'seeker') {
    $seeker_count++;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Management - CareerPath</title>
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
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
    }

    .container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 30px;
    }

    .filter-badges {
      display: flex;
      justify-content: flex-end;
      gap: 15px;
      margin-bottom: 20px;
    }

    .badge {
      padding: 8px 20px;
      border-radius: 20px;
      color: white;
      font-weight: 700;
      font-size: 14px;
    }

    .badge-employers {
      background-color: #28a745;
    }

    .badge-seekers {
      background-color: #17a2b8;
    }

    .table-container {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    thead {
      background-color: #e8f1f8;
    }

    th {
      padding: 15px;
      text-align: left;
      font-weight: 700;
      color: #0c4a86;
      font-size: 14px;
      text-transform: uppercase;
    }

    td {
      padding: 15px;
      border-bottom: 1px solid #e0e0e0;
      color: #333;
    }

    tbody tr:hover {
      background-color: #f8f9fa;
    }

    .user-type-badge {
      padding: 5px 15px;
      border-radius: 15px;
      color: white;
      font-weight: 700;
      font-size: 12px;
      display: inline-block;
    }

    .employer-badge {
      background-color: #28a745;
    }

    .seeker-badge {
      background-color: #17a2b8;
    }

    .action-buttons {
      display: flex;
      gap: 10px;
    }

    .btn {
      padding: 8px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: 600;
      font-size: 13px;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }

    .btn-edit {
      background-color: #007bff;
      color: white;
    }

    .btn-edit:hover {
      background-color: #0056b3;
    }

    .btn-delete {
      background-color: white;
      color: #dc3545;
      border: 2px solid #dc3545;
    }

    .btn-delete:hover {
      background-color: #dc3545;
      color: white;
    }

    .alert {
      padding: 15px;
      border-radius: 5px;
      margin-bottom: 20px;
      font-weight: 600;
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .alert-error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }
  </style>
</head>

<body>
  <div class="page-header">
    <span>👥</span> MASTER USER LIST
  </div>

  <div class="container">
    <?php if (isset($_GET['success'])): ?>
      <div class="alert alert-success">✓ <?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-error">✖ <?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

    <div class="filter-badges">
      <span class="badge badge-employers">EMPLOYERS: <?php echo $employer_count; ?></span>
      <span class="badge badge-seekers">SEEKERS: <?php echo $seeker_count; ?></span>
    </div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>User Type</th>
            <th>Username</th>
            <th>Contact Number</th>
            <th>Email Address</th>
            <th>Registration Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (count($users) > 0) {
            foreach ($users as $row) {
              $user_type = trim(strtolower($row['type_of_user']));
              $badge_class = ($user_type == 'employer') ? 'employer-badge' : 'seeker-badge';
              $display_type = ($user_type == 'employer') ? 'EMPLOYER' : 'JOB SEEKER';
          ?>
              <tr>
                <td><?php echo $row['id']; ?></td>
                <td>
                  <span class="user-type-badge <?php echo $badge_class; ?>">
                    <?php echo $display_type; ?>
                  </span>
                </td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['contactnumber'] ?? '-'); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo date('M d, Y H:i:s', strtotime($row['created_at'])); ?></td>
                <td>
                  <div class="action-buttons">
                    <button class="btn btn-edit" onclick="editUser(<?php echo $row['id']; ?>)">
                      ✏️ Edit
                    </button>
                    <button class="btn btn-delete" onclick="deleteUser(<?php echo $row['id']; ?>)">
                      🗑️ Delete
                    </button>
                  </div>
                </td>
              </tr>
          <?php
            }
          } else {
            echo "<tr><td colspan='7' style='text-align:center; padding: 30px;'>No users found</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    function editUser(userId) {
      window.location.href = 'edit_user.php?id=' + userId;
    }

    function deleteUser(userId) {
      if (confirm('Are you sure you want to delete this user?')) {
        window.location.href = 'delete_user.php?id=' + userId;
      }
    }
  </script>
</body>

</html>