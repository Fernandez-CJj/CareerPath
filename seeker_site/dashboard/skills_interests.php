<?php
session_start();
include('../../config.php');
$seeker_id = $_SESSION['seeker_id'];
$resume_id = $_GET['id'];

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $skills = $_POST['skills'];
  $interests = $_POST['interests'];

  $sql = "UPDATE resumes SET skills='$skills', interests='$interests' WHERE id=$resume_id AND seeker_id=$seeker_id";

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
  <title>Edit Skills & Interests</title>
  <style>
    .container-container {
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: Arial, Helvetica, sans-serif;
      background-color: #f5f5f5;
    }

    .form-container {
      background: white;
      width: 700px;
      margin-top: 50px;
      margin-bottom: 50px;
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

    .label {
      font-size: 16px;
      margin-left: 5px;
      font-weight: bold;
      color: #222;
      margin-bottom: 10px;
    }

    .textarea-field {
      width: 100%;
      padding-left: 20px;
      padding-right: 20px;
      padding-top: 15px;
      margin-top: 10px;
      margin-bottom: 20px;
      font-size: 16px;
      border-radius: 10px;
      border: 2px solid #0c4a86;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
      box-sizing: border-box;
      font-family: Arial, Helvetica, sans-serif;
      height: 120px;
      resize: vertical;
    }

    .textarea-field:focus {
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

    .helper-text {
      font-size: 12px;
      color: #6b7280;
      margin-top: -15px;
      margin-bottom: 15px;
      margin-left: 5px;
    }
  </style>
</head>

<body>
  <div class="container-container">
    <div class="form-container">
      <div class="form-title">Edit Skills & Interests</div>

      <form action="" method="post">
        <div class="label">Skills</div>
        <textarea name="skills" class="textarea-field" placeholder="Separate each skill with | (e.g., JavaScript | Python | SQL | Project Management)" required><?php echo htmlspecialchars($resume['skills']); ?></textarea>
        <div class="helper-text">Use | to separate multiple skills</div>

        <div class="label">Interests</div>
        <textarea name="interests" class="textarea-field" placeholder="Separate each interest with | (e.g., Web Development | Machine Learning | Data Analysis)" required><?php echo htmlspecialchars($resume['interests']); ?></textarea>
        <div class="helper-text">Use | to separate multiple interests</div>

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