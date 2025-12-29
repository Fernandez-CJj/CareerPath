<?php
include('../header/dashboardHeader.html');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="dashboard.css">
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
    <div class="dashboard-right-section"></div>
  </div>
</body>

</html>