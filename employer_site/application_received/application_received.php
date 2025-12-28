<?php 
include "../header_employer/applicationReceived.html"; 
include "../../config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Applications Received</title>

<style>
:root {
  --primary-blue: #0c4a86;
  --danger-red: #e74c3c;
  --border-color: #adc9eb;
}

.table-container {
  max-width: 900px;
  margin: 50px auto;
  border: 1px solid var(--border-color);
  border-radius: 8px;
  overflow: hidden;
  background: white;
}

.applicant-table {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
}

.applicant-table th {
  padding: 20px;
  border-bottom: 2px solid var(--border-color);
  color: #333;
  text-transform: uppercase;
  font-size: 14px;
  letter-spacing: 1px;
}

.applicant-table td {
  padding: 15px 20px;
  border-bottom: 1px solid #eee;
  vertical-align: middle;
}

.applicant-info { display: flex; align-items: center; gap: 15px; cursor:pointer; }
.avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }

.status-btn {
  padding: 8px 25px;
  border-radius: 5px;
  font-weight: bold;
  cursor: default;
  min-width: 120px;
  border: 1.5px solid var(--primary-blue);
}
.status-new { color: var(--primary-blue); background: white; }
.status-reviewing { color: var(--primary-blue); background: white; }
.status-reviewed { color: white; background: var(--primary-blue); }
</style>

</head>
<body>

<div class="table-container">
  <table class="applicant-table">
    <thead>
      <tr>
        <th>Applicant</th>
        <th>Position</th>
        <th>Date</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <tr onclick="goToDetail('1')">
        <td>
          <div class="applicant-info">
            <img src="avatar.jpg" class="avatar">
            <span>Jaymar Doe</span>
          </div>
        </td>
        <td>US Recruiter Manager</td>
        <td>April 2025</td>
        <td><button class="status-btn status-new">New</button></td>
      </tr>
      <tr onclick="goToDetail('2')">
        <td>
          <div class="applicant-info">
            <img src="avatar2.jpg" class="avatar">
            <span>Anna Smith</span>
          </div>
        </td>
        <td>Frontend Developer</td>
        <td>May 2025</td>
        <td><button class="status-btn status-reviewing">Reviewing</button></td>
      </tr>
    </tbody>
  </table>
</div>

<script>
function goToDetail(id){
    // Redirect to the detail page, passing applicant ID
    window.location.href = 'application_detail.php?id=' + id;
}
</script>

</body>
</html>
