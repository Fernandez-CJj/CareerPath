<?php
session_start();
include('../../config.php');
$seeker_id = $_SESSION['seeker_id'];
$resume_id = $_GET['id'];

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $job_title1 = $_POST['job_title1'];
  $company1 = $_POST['company1'];
  $start_year1 = $_POST['start_year1'];
  $end_year1 = $_POST['end_year1'];
  $job_overview1 = $_POST['job_overview1'];
  $key_responsibilities1 = $_POST['key_responsibilities1'];
  $achievements1 = $_POST['achievements1'];

  $job_title2 = $_POST['job_title2'] ?? '';
  $company2 = $_POST['company2'] ?? '';
  $start_year2 = $_POST['start_year2'] ?? '';
  $end_year2 = $_POST['end_year2'] ?? '';
  $job_overview2 = $_POST['job_overview2'] ?? '';
  $key_responsibilities2 = $_POST['key_responsibilities2'] ?? '';
  $achievements2 = $_POST['achievements2'] ?? '';

  $sql = "UPDATE resumes SET job_title1='$job_title1', company1='$company1', start_year1='$start_year1', end_year1='$end_year1', job_overview1='$job_overview1', key_responsibilities1='$key_responsibilities1', achievements1='$achievements1', job_title2='$job_title2', company2='$company2', start_year2='$start_year2', end_year2='$end_year2', job_overview2='$job_overview2', key_responsibilities2='$key_responsibilities2', achievements2='$achievements2' WHERE id=$resume_id AND seeker_id=$seeker_id";

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
  <title>Edit Experience Details</title>
  <style>
    .container-container {
      display: flex;
      align-items: center;
      justify-content: center;
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

    .input-field,
    .textarea-field {
      width: 100%;
      padding-left: 20px;
      padding-right: 20px;
      margin-top: 10px;
      margin-bottom: 20px;
      font-size: 16px;
      border-radius: 10px;
      border: 2px solid #0c4a86;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
      box-sizing: border-box;
      font-family: Arial, Helvetica, sans-serif;
    }

    .input-field {
      height: 50px;
    }

    .textarea-field {
      height: 100px;
      padding-top: 15px;
      resize: vertical;
    }

    .input-field:focus,
    .textarea-field:focus {
      outline: none;
      border-color: #2563eb;
    }

    .date-row {
      display: flex;
      gap: 15px;
    }

    .date-row>div {
      flex: 1;
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
      <div class="form-title">Edit Experience Details</div>

      <form action="" method="post">
        <div class="section-title">First Experience</div>

        <div class="label">Job Title / Position</div>
        <input type="text" name="job_title1" class="input-field" placeholder="e.g., Software Engineer" value="<?php echo htmlspecialchars($resume['job_title1']); ?>" required>

        <div class="label">Company Name</div>
        <input type="text" name="company1" class="input-field" placeholder="e.g., Google Philippines" value="<?php echo htmlspecialchars($resume['company1']); ?>" required>

        <div class="date-row">
          <div>
            <div class="label">Start Date</div>
            <input type="text" name="start_year1" class="input-field" placeholder="e.g., January 2020" value="<?php echo htmlspecialchars($resume['start_year1']); ?>" required>
          </div>
          <div>
            <div class="label">End Date</div>
            <input type="text" name="end_year1" class="input-field" placeholder="e.g., December 2023" value="<?php echo htmlspecialchars($resume['end_year1']); ?>" required>
          </div>
        </div>

        <div class="label">Job Overview</div>
        <textarea name="job_overview1" class="textarea-field" placeholder="Brief description of your role and responsibilities" required><?php echo htmlspecialchars($resume['job_overview1']); ?></textarea>

        <div class="label">Key Responsibilities</div>
        <textarea name="key_responsibilities1" class="textarea-field" placeholder="Separate each responsibility with | (e.g., Developed web apps | Led team meetings | Code reviews)" required><?php echo htmlspecialchars($resume['key_responsibilities1']); ?></textarea>
        <div class="helper-text">Use | to separate multiple responsibilities</div>

        <div class="label">Achievements</div>
        <textarea name="achievements1" class="textarea-field" placeholder="Separate each achievement with | (e.g., Improved performance by 50% | Led 5-person team)" required><?php echo htmlspecialchars($resume['achievements1']); ?></textarea>
        <div class="helper-text">Use | to separate multiple achievements</div>

        <div class="section-title">Second Experience <span class="optional-text">(Optional)</span></div>

        <div class="label">Job Title / Position <span class="optional-text">(Optional)</span></div>
        <input type="text" name="job_title2" class="input-field" placeholder="e.g., Junior Developer" value="<?php echo htmlspecialchars($resume['job_title2']); ?>">

        <div class="label">Company Name <span class="optional-text">(Optional)</span></div>
        <input type="text" name="company2" class="input-field" placeholder="e.g., Tech Startup Inc." value="<?php echo htmlspecialchars($resume['company2']); ?>">

        <div class="date-row">
          <div>
            <div class="label">Start Date <span class="optional-text">(Optional)</span></div>
            <input type="text" name="start_year2" class="input-field" placeholder="e.g., June 2018" value="<?php echo htmlspecialchars($resume['start_year2']); ?>">
          </div>
          <div>
            <div class="label">End Date <span class="optional-text">(Optional)</span></div>
            <input type="text" name="end_year2" class="input-field" placeholder="e.g., December 2019" value="<?php echo htmlspecialchars($resume['end_year2']); ?>">
          </div>
        </div>

        <div class="label">Job Overview <span class="optional-text">(Optional)</span></div>
        <textarea name="job_overview2" class="textarea-field" placeholder="Brief description of your role and responsibilities"><?php echo htmlspecialchars($resume['job_overview2']); ?></textarea>

        <div class="label">Key Responsibilities <span class="optional-text">(Optional)</span></div>
        <textarea name="key_responsibilities2" class="textarea-field" placeholder="Separate each responsibility with |"><?php echo htmlspecialchars($resume['key_responsibilities2']); ?></textarea>
        <div class="helper-text">Use | to separate multiple responsibilities</div>

        <div class="label">Achievements <span class="optional-text">(Optional)</span></div>
        <textarea name="achievements2" class="textarea-field" placeholder="Separate each achievement with |"><?php echo htmlspecialchars($resume['achievements2']); ?></textarea>
        <div class="helper-text">Use | to separate multiple achievements</div>

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