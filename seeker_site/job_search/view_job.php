<?php
include('../header/jobSearchHeader.html');
include('../../config.php');

$job_id = $_GET['id'];
$sql = "SELECT * FROM job WHERE job_id='$job_id'";
$result = mysqli_query($conn, $sql);
$user_id = '';
$member_since = '';
$count = 0;
while ($row = mysqli_fetch_assoc($result)) {
  $user_id = $row['user_id'];
}

$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
  $member_since = date('F d, Y', strtotime($row['created_at']));
}

$sql = "SELECT * FROM job WHERE user_id='$user_id'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
  $count += 1;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="styles/view_job.css?v=<?php echo time(); ?>">
</head>

<body>
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
      <div class='apply-button-container'>
    <button class='apply-button' id='apply-button' onclick='showForm()'>APPLY NOW</button>
    <form method='post' id='apply-form' style='display:none'>
      <input type='file' accept='application/pdf' required>
      <input type='submit' value='submit' class='apply-button'>
    </form>
  </div>
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
  </script>
</body>

</html>