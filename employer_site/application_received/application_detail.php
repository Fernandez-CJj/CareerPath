<?php 
include "../header_employer/applicationReceived.html";

$applicantId = $_GET['id'] ?? 1;

// Example applicants (normally from DB)
$applicants = [
    1 => ['name'=>'Jaymar Doe', 'position'=>'US Recruiter Manager', 'resume'=>'resume_jaymar.pdf'],
    2 => ['name'=>'Anna Smith', 'position'=>'Frontend Developer', 'resume'=>'resume_anna.pdf']
];

$applicant = $applicants[$applicantId];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Applicant Detail</title>

<style>
:root {
  --primary-blue: #0c4a86;
  --danger-red: #e74c3c;
}

.detail-container {
  max-width: 800px;
  margin: 50px auto;
  background: white;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.applicant-info {
  display:flex;
  align-items:center;
  gap:20px;
}

.applicant-info img {
  width:60px;
  height:60px;
  border-radius:50%;
  object-fit:cover;
}

h2 { color: #0c4a86; margin-top:0; }

.resume-container {
  margin:30px 0;
  text-align:center;
  cursor:pointer;
}

.resume-container iframe {
  width:100%;
  height:300px;
  border:1px solid #ddd;
  border-radius:8px;
}

.action-footer {
  display:flex;
  justify-content:center;
  gap:20px;
  margin-top:30px;
}

.btn-accept {
  background: var(--primary-blue);
  color:white;
  padding:10px 40px;
  border:none;
  border-radius:5px;
  font-weight:bold;
  cursor:pointer;
}

.btn-decline {
  background:white;
  color: var(--danger-red);
  border:1px solid var(--danger-red);
  padding:10px 40px;
  border-radius:5px;
  font-weight:bold;
  cursor:pointer;
}

/* ===== Full-screen Resume Overlay ===== */
#resumeOverlay {
  display: none;
  position: fixed;
  top:0; left:0; width:100%; height:100%;
  background: rgba(0,0,0,0.9);
  justify-content: center;
  align-items: center;
  z-index: 3000;
}

#resumeOverlay iframe {
  width: 90%;
  height: 90%;
  border: none;
  border-radius: 8px;
}

#resumeOverlay .close-btn {
  position: absolute;
  top: 20px;
  right: 30px;
  font-size: 30px;
  color: white;
  cursor: pointer;
  font-weight: bold;
}
</style>
</head>
<body>

<div class="detail-container">
  <div class="applicant-info">
    <img src="avatar.jpg" alt="Avatar">
    <div>
      <h2><?php echo $applicant['name']; ?></h2>
      <p style="color:#666"><?php echo $applicant['position']; ?></p>
    </div>
  </div>

  <div class="resume-container" onclick="openResume()">
    <iframe src="<?php echo $applicant['resume']; ?>"></iframe>
    <p style="color:#666; margin-top:10px;">Click resume to view full screen</p>
  </div>

  <div class="action-footer">
    <button class="btn-decline" onclick="confirmAction('decline')">Decline</button>
    <button class="btn-accept" onclick="confirmAction('accept')">Accept</button>
  </div>
</div>

<!-- Full-screen Resume Overlay -->
<div id="resumeOverlay" onclick="closeResume(event)">
  <span class="close-btn" onclick="closeResume(event)">&times;</span>
  <iframe id="resumeFull" src=""></iframe>
</div>

<script>
function confirmAction(type){
    if(type==='accept'){
        alert('Application accepted!');
    }else{
        alert('Application declined!');
    }
    window.location.href = 'application_received.php';
}

// Open full-screen resume
function openResume(){
    const overlay = document.getElementById('resumeOverlay');
    const iframe = document.getElementById('resumeFull');
    iframe.src = "<?php echo $applicant['resume']; ?>";
    overlay.style.display = 'flex';
}

// Close overlay
function closeResume(e){
    e.stopPropagation();
    document.getElementById('resumeOverlay').style.display = 'none';
}
</script>

</body>
</html>
