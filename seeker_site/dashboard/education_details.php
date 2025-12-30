<?php
session_start();
include('../../config.php');
$seeker_id = $_SESSION['seeker_id'];
$resume_id = $_GET['id'];

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $course1 = $_POST['course1'];
  $institution_name1 = $_POST['institution_name1'];
  $graduation_year1 = $_POST['graduation_year1'];
  $course2 = $_POST['course2'] ?? '';
  $institution_name2 = $_POST['institution_name2'] ?? '';
  $graduation_year2 = $_POST['graduation_year2'] ?? '';

  $sql = "UPDATE resumes SET course1='$course1', institution_name1='$institution_name1', graduation_year1='$graduation_year1', course2='$course2', institution_name2='$institution_name2', graduation_year2='$graduation_year2' WHERE id=$resume_id AND seeker_id=$seeker_id";

  if (mysqli_query($conn, $sql)) {
    header("Location: review_resume.php?id=$resume_id");
    exit;
  } else {
    $message = 'Error updating details';
  }
}

// Fetch current data
$sql = "SELECT * FROM resumes WHERE id=$resume_id AND seeker_id=$seeker_id";
$result = mysqli_query($conn, $sql);
$resume = mysqli_fetch_assoc($result);

include('../header/dashboardHeader.html');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Education Details</title>
  <style>
    .container-container {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .form-container {
      background: white;
      width: 600px;
      margin-top: 50px;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }

    .form-title {
      font-size: 28px;
      font-weight: bold;
      color: #0c4a86;
      text-align: center;
      margin-bottom: 30px;
    }

    .section-title {
      font-size: 20px;
      font-weight: bold;
      color: #0c4a86;
      margin-top: 30px;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid #e5e7eb;
    }

    .label {
      font-size: 16px;
      margin-left: 5px;
      font-weight: bold;
      color: #222;
      margin-bottom: 10px;
    }

    .input-field {
      width: 100%;
      padding-left: 20px;
      margin-top: 10px;
      margin-bottom: 20px;
      height: 50px;
      font-size: 16px;
      border-radius: 10px;
      border: 2px solid #0c4a86;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
      box-sizing: border-box;
    }

    .input-field:focus {
      outline: none;
      border-color: #2563eb;
    }

    .button-container {
      display: flex;
      gap: 15px;
      margin-top: 30px;
    }

    .submit-button,
    .cancel-button {
      flex: 1;
      border: none;
      height: 50px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      transition: opacity 0.2s;
    }

    .submit-button {
      background-color: #0c4a86;
      color: white;
    }

    .cancel-button {
      background-color: #e5e7eb;
      color: #222;
    }

    .submit-button:hover,
    .cancel-button:hover {
      opacity: 0.8;
    }

    .submit-button:active,
    .cancel-button:active {
      opacity: 0.5;
    }

    .message {
      color: #dc2626;
      font-size: 14px;
      margin-top: -10px;
      margin-bottom: 15px;
      text-align: center;
    }

    .optional-text {
      font-size: 12px;
      color: #6b7280;
      margin-left: 5px;
      font-weight: normal;
    }
  </style>
</head>

<body>
  <div class="container-container">
    <div class="form-container">
      <div class="form-title">Edit Education Details</div>

      <form action="" method="post">
        <div class="section-title">First Education</div>

        <div class="label">Course / Degree</div>
        <input type="text" name="course1" class="input-field" placeholder="e.g., Bachelor of Science in Information Technology" value="<?php echo htmlspecialchars($resume['course1']); ?>" required>

        <div class="label">Institution / School Name</div>
        <input type="text" name="institution_name1" class="input-field" placeholder="e.g., University of the Philippines" value="<?php echo htmlspecialchars($resume['institution_name1']); ?>" required>

        <div class="label">Graduation Year</div>
        <input type="text" name="graduation_year1" class="input-field" placeholder="e.g., May 2024" value="<?php echo htmlspecialchars($resume['graduation_year1']); ?>" required>

        <div class="section-title">Second Education <span class="optional-text">(Optional)</span></div>

        <div class="label">Course / Degree <span class="optional-text">(Optional)</span></div>
        <input type="text" name="course2" class="input-field" placeholder="e.g., Master of Science in Computer Science" value="<?php echo htmlspecialchars($resume['course2']); ?>">

        <div class="label">Institution / School Name <span class="optional-text">(Optional)</span></div>
        <input type="text" name="institution_name2" class="input-field" placeholder="e.g., Ateneo de Manila University" value="<?php echo htmlspecialchars($resume['institution_name2']); ?>">

        <div class="label">Graduation Year <span class="optional-text">(Optional)</span></div>
        <input type="text" name="graduation_year2" class="input-field" placeholder="e.g., March 2026" value="<?php echo htmlspecialchars($resume['graduation_year2']); ?>">

        <?php if ($message): ?>
          <div class="message">
            <?php echo $message; ?>
          </div>
        <?php endif; ?>

        <div class="button-container">
          <button type="button" class="cancel-button" onclick="window.location.href='review_resume.php?id=<?php echo $resume_id; ?>'">Cancel</button>
          <button type="submit" class="submit-button">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>