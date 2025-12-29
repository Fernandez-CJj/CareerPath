<?php
session_start();
// Handle PDF display on POST BEFORE any output or includes
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['resume_path'])) {
  $resume_path = $_POST['resume_path'];
  $file_path = '../../' . $resume_path;
  if (file_exists($file_path)) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . basename($file_path) . '"');
    readfile($file_path);
    exit;
  } else {
    die("Resume file not found.");
  }
}
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
      $sql = "SELECT * FROM applications WHERE seeker_id='$seeker_id'";
      $result = mysqli_query($conn, $sql);
      $count = 0;
      while ($app_row = mysqli_fetch_assoc($result)) {
        $count += 1;
        $date = date('F d, Y', strtotime($app_row['created_at']));

        echo "<form method='post' style='margin:0;'>
          <input type='hidden' name='resume_path' value='" . htmlspecialchars($app_row['resume_path']) . "'>
          <div class='application-container resume-card-clickable' style='cursor:pointer;' onclick='this.closest(\"form\").submit();'>
            <div class='application-left-section'>
              <div class='position-text'>Resume $count</div>
              <div class='status-text'>$date</div>
            </div>
            <div class='view-text'>View</div>
          </div>
        </form>";
      }
      ?>

    </div>
  </div>
</body>

</html>