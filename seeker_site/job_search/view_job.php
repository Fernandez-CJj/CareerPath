<?php
session_start();
$seeker_id = $_SESSION['seeker_id'];

include('../../config.php');

$job_id = $_GET['id'];
$sql = "SELECT * FROM job WHERE job_id='$job_id'";
$result = mysqli_query($conn, $sql);
$employer_id = '';
$member_since = '';
$count = 0;
while ($row = mysqli_fetch_assoc($result)) {
  $employer_id = $row['user_id'];
}

$sql = "SELECT * FROM users WHERE id='$employer_id'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
  $member_since = date('F d, Y', strtotime($row['created_at']));
}

$sql = "SELECT * FROM job WHERE user_id='$employer_id'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
  $count += 1;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["resume-pdf"])) {
  $target_dir = "../../resumes/";

  if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
  }

  $new_filename = "resume_" . $_SESSION['seeker_id'] . "_" . time() . "." . pathinfo($_FILES["resume-pdf"]["name"], PATHINFO_EXTENSION);
  $target_file = $target_dir . $new_filename;

  move_uploaded_file($_FILES["resume-pdf"]["tmp_name"], $target_file);

  $resume_path = "resumes/" . $new_filename;

  $sql = "INSERT INTO applications (seeker_id, employer_id, job_id, resume_path) VALUES ('$seeker_id','$employer_id', '$job_id','$resume_path');";

  $result = mysqli_query($conn, $sql);

  if ($result) {
    $_SESSION['applied_success'] = true;
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
  }
}

$applied_success = false;
if (isset($_SESSION['applied_success'])) {
  $applied_success = true;
  unset($_SESSION['applied_success']);
}

$application_status = '';
$has_applied = false;
$app_sql = "SELECT status FROM applications WHERE seeker_id='$seeker_id' AND job_id='$job_id' LIMIT 1";
$app_result = mysqli_query($conn, $app_sql);
if ($app_result && mysqli_num_rows($app_result) > 0) {
  $app_row = mysqli_fetch_assoc($app_result);
  $has_applied = true;
  $application_status = strtoupper($app_row['status'] ?: 'APPLIED');
}

$apply_label = 'APPLY NOW';
$apply_block = '';

if ($has_applied) {
  $apply_label = $application_status ?: 'APPLIED';
  $apply_block = "<div class='apply-button-container'>
    <button class='apply-button' id='apply-button' disabled>{$apply_label}</button>
  </div>";
} else {
  $apply_block = "<div class='apply-button-container'>
    <button class='apply-button' id='apply-button' onclick='showForm()'>APPLY NOW</button>
    <form method='post' id='apply-form' style='display:none' enctype='multipart/form-data'>
      <input type='file' name='resume-pdf' accept='application/pdf' required>
      <input type='submit' id='apply-submit' value='submit' class='apply-button'>
    </form>
  </div>";
}
?>

<?php include('../header/jobSearchHeader.html'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="styles/view_job.css?v=<?php echo time(); ?>">
</head>

<body>
  <div id="apply-success-modal">
    <div class="apply-success-card">
      <div class="apply-success-icon">✓</div>
      <div class="apply-success-title">Application Submitted</div>
      <div class="apply-success-text">Your application was sent successfully.</div>
      <div class="apply-success-actions">
        <button id="apply-success-close" class="apply-button">Close</button>
      </div>
    </div>
  </div>
  <?php
  $sql = "SELECT * FROM job WHERE job_id='$job_id'";
  $result = mysqli_query($conn, $sql);

  while ($row = mysqli_fetch_assoc($result)) {
    $date = date('F d, Y', strtotime($row['date_posted']));

    echo "<div class='title-container'>
    <div class='title-text'>{$row['job_title']}</div>
  </div><div class='details-container'>
    <div class='details'>
      <div class='etona-details'>
        <div class='type-of-work'>
          <img src='../../assets/images/tow.png' alt=''>
          <div class='type-of-work-text'>
            <div class='towt'>Type of work</div>
            <div class='job-type-text'>{$row['type_of_work']}</div>
          </div>
        </div>
        <div class='type-of-work'>
          <img src='../../assets/images/salary.png' alt=''>
          <div class='type-of-work-text'>
            <div class='towt'>Salary</div>
            <div class='job-type-text'>₱{$row['salary']}/month</div>
          </div>
        </div>
        <div class='type-of-work'>
          <img src='../../assets/images/hpw.png' alt=''>
          <div class='type-of-work-text'>
            <div class='towt'>Hours per week</div>
            <div class='job-type-text'>{$row['hours']}</div>
          </div>
        </div>
        <div class='type-of-work'>
          <img src='../../assets/images/du.png' alt=''>
          <div class='type-of-work-text'>
            <div class='towt'>Date updated</div>
            <div class='job-type-text'>$date</div>
          </div>
        </div>
      </div> 
      {$apply_block}
  </div>
  <div class='job-overview'>
    <div class='img-text-container'>
      <img src='../../assets/images/job-overview.png' class='overview-img'>
      <div class='job-overview-text'>Job Overview</div>
    </div>
    <div class='overview-div'>Location: {$row['location']}</div>
    <div class='overview-div'>
      {$row['job_overview']}
    </div>
    <div class='responsibility-div'>
      <div class='responsibility-text'>Responsibilities</div>
      <div>
        <ul>";
    $responsibilities = explode('|', $row['key_responsibilities']);
    foreach ($responsibilities as $responsibility) {
      if (!empty($responsibility)) {
        echo "<li>$responsibility</li>";
      }
    }

    echo " </ul>
  </div>
  </div>
  <div class='qualification-div'>
    <div class='responsibility-text'>Responsibilities</div>
    <div>
      <ul>";

    $qualifications = explode('|', $row['qualifications']);
    foreach ($qualifications as $quality) {
      if (!empty($quality)) {
        echo "<li>$quality</li>";
      }
    }

    echo "</ul>
  </div>
  </div>
  </div>
  <div class='skills-requirement'>
    <div class='img-text-container'>
      <img src='../../assets/images/skills.png' class='overview-img'>
      <div class='job-overview-text'>Skill Requirements</div>
    </div>
    <div class='skills-container'>";

    $skills = explode('|', $row['skills_requirements']);
    foreach ($skills as $skill) {
      $skill = trim($skill);
      if (!empty($skill)) {
        echo "<button class='skill'>$skill</button>";
      }
    }

    echo "</div>
  </div>

  <div class='about-employer'>
    <div class='img-text-container'>
      <img src='../../assets/images/job-overview.png' class='overview-img'>
      <div class='employer-text'>About The Employer</div>
    </div>
    <div class='employer-div'>
      <div>Contact Person: <span class='value'>{$row['contact_person']}</span></div>
      <div>Member since: <span class='value'>$member_since</span></div>
      <div>Total Job Post: <span class='value'>$count</span></div>
    </div>
  </div>
  </div>";
  }

  ?>
  <script>
    function showForm() {
      document.getElementById('apply-form').style.display = 'block';
      document.getElementById('apply-button').style.display = 'none';
    }

    const applyForm = document.getElementById('apply-form');
    const applyButton = document.getElementById('apply-button');
    const applySubmit = document.getElementById('apply-submit');
    const successModal = document.getElementById('apply-success-modal');
    const successClose = document.getElementById('apply-success-close');

    if (applyForm && applySubmit && applyButton) {
      applyForm.addEventListener('submit', function() {
        applySubmit.value = 'Submitting...';
        applySubmit.disabled = true;
        applyButton.disabled = true;
        applyButton.textContent = 'APPLIED';
      });
    }

    const appliedSuccess = <?php echo $applied_success ? 'true' : 'false'; ?>;
    if (appliedSuccess && successModal) {
      successModal.style.display = 'flex';
    }

    if (successClose && successModal) {
      successClose.addEventListener('click', function() {
        successModal.style.display = 'none';
      });
      successModal.addEventListener('click', function(e) {
        if (e.target === successModal) successModal.style.display = 'none';
      });
    }
  </script>
</body>

</html>