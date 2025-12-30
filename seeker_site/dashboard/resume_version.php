<?php
session_start();
include('../header/dashboardHeader.html');
include('../../config.php');
$seeker_id = $_SESSION['seeker_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="styles/dashboard.css?v=<?php echo time(); ?>">
</head>

<body>
  <div class="dashboard-content-container">
    <div class="dashboard-left-section">
      <div class="icon-container" onclick="window.location.href='dashboard.php'">
        <div><img src="../../assets/images/applications-icon.png" alt=""></div>
        <div>APPLICATIONS</div>
      </div>
      <div class="icon-container" onclick="window.location.href='resume_version.php'">
        <div><img src="../../assets/images/resume-icon.png" alt=""></div>
        <div>RESUME VERSIONS</div>
      </div>
      <div class="icon-container" onclick="window.location.href='insights.php'">
        <div><img src="../../assets/images/insights-icon.png" alt=""></div>
        <div>SUCCESS INSIGHTS</div>
      </div>
    </div>
    <div class="dashboard-right-section">
      <div class="job-applications-text">RESUME VERSIONS</div>
      <?php
      $sql = "SELECT * FROM resumes WHERE seeker_id = $seeker_id";
      $result = mysqli_query($conn, $sql);
      $count = 0;
      while ($row = mysqli_fetch_assoc($result)) {
        $date = date('F d, Y', strtotime($row['created_at']));
        $count += 1;
        echo "<div class='application-container' onclick=\"window.location.href='review_resume.php?id={$row['id']}'\">
        <div class='application-left-section'>
          <div class='position-text'>{$row['name']}</div>
          <div class='status-text'>Resume $count</div>
        </div>
        <div class='edit-text'>Edit ></div>
      </div>";
      }
      ?>

    </div>
  </div>
</body>

</html>