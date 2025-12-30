<?php
session_start();
$seeker_id = $_SESSION['seeker_id'];
include('../../config.php');

$upload_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
  $uploadDir = '../../assets/images/profiles/';
  if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
  }

  if (!empty($_FILES['profile_picture']['name'])) {
    $fileTmp = $_FILES['profile_picture']['tmp_name'];
    $fileName = basename($_FILES['profile_picture']['name']);
    $fileSize = $_FILES['profile_picture']['size'];
    $fileType = mime_content_type($fileTmp);
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    if (!in_array($fileType, $allowed)) {
      $upload_error = 'Please upload a JPG, PNG, GIF, or WEBP image.';
    } elseif ($fileSize > 2 * 1024 * 1024) {
      $upload_error = 'Image must be 2MB or smaller.';
    } else {
      $extension = pathinfo($fileName, PATHINFO_EXTENSION);
      $newName = 'profile_' . $seeker_id . '_' . time() . '.' . $extension;
      $targetPath = $uploadDir . $newName;

      if (move_uploaded_file($fileTmp, $targetPath)) {
        $safePath = mysqli_real_escape_string($conn, $targetPath);
        $updateSql = "UPDATE users SET profile='$safePath' WHERE id=$seeker_id";
        mysqli_query($conn, $updateSql);
        header('Location: profile.php');
        exit;
      } else {
        $upload_error = 'Upload failed. Please try again.';
      }
    }
  }
}

// Include header only after all header() calls are done
include('../header/profileHeader.html');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="profile.css?v=<?php echo time(); ?>">
</head>

<body>
  <div class="profile-container-div">
    <div class="profile-content-container">
      <div class="profile-content-header"></div>
      <div class="profile-details-container">
        <?php
        $sql = "SELECT * FROM users WHERE id=$seeker_id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $profileSrc = !empty($row['profile']) ? $row['profile'] : '../../assets/images/logo.png';
        ?>

        <form class="upload-form" method="post" enctype="multipart/form-data">
          <img src="<?php echo htmlspecialchars($profileSrc); ?>" alt="Profile" class="profile-avatar">
          <label for="profileUpload" class="upload-text">Change Profile Picture</label>
          <input type="file" name="profile_picture" id="profileUpload" class="hidden-file" accept="image/*" onchange="this.form.submit();">
          <?php if (!empty($upload_error)): ?>
            <div class="upload-error"><?php echo htmlspecialchars($upload_error); ?></div>
          <?php endif; ?>
        </form>

        <div class='name-text'><?php echo htmlspecialchars($row['username']); ?></div>
        <div class='border-line'></div>
        <div class='email-text'>Email</div>
        <div class='value-text'><?php echo htmlspecialchars($row['email']); ?></div>
        <div class='border-line'></div>
        <div class='email-text'>Mobile Phone</div>
        <div class='value-text'><?php echo htmlspecialchars($row['contactnumber']); ?></div>
        <div class='spacer'></div>
      </div>
    </div>
  </div>
</body>

</html>