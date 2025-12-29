<?php
session_start();
include('../../config.php');
include('../header/dashboardHeader.html');

$seeker_id = $_SESSION['seeker_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="dashboard.css?v=<?php echo time(); ?>">
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
      <div class="job-applications-text">JOB APPLICATIONS</div>
      <?php
      $sql = "SELECT * FROM applications WHERE seeker_id='$seeker_id'";
      $result = mysqli_query($conn, $sql);

      while ($app_row = mysqli_fetch_assoc($result)) {
        $date = date('F d, Y', strtotime($app_row['created_at']));
        $job_id = $app_row['job_id'];
        $sql = "SELECT * FROM job WHERE job_id='$job_id'";
        $job_result = mysqli_query($conn, $sql);
        $position = '';
        while ($job_row = mysqli_fetch_assoc($job_result)) {
          $position = $job_row['job_title'];
        }

        echo "<div class='application-container' onclick=\"window.location.href='../job_search/view_job.php?id={$job_id}'\">
  <div class='application-left-section'>
    <div class='position-text'>$position</div>
    <div class='status-text'>{$app_row['status']}</div>
  </div>
  <div class='application-right-section'>$date ></div>
</div>";
      }
      ?>
    </div>
  </div>
</body>

</html>