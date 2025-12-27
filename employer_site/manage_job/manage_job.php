<?php 
include "../header_employer/ManageJob.html";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Jobs</title>
<style>
:root {
  --primary-blue: #0c4a86;
  --bg-gray: #f4f7f6;
  --text-gray: #555;
  --danger-red: #e74c3c;
}

body {
  background-color: var(--bg-gray);
  font-family: 'Arial', sans-serif;
}

/* Header Title Style */
.page-title-container {
  background-color: white;
  width: fit-content;
  padding: 10px 60px;
  margin: 20px auto 40px;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.page-title-container h1 {
  color: var(--primary-blue);
  margin: 0;
  font-size: 28px;
  font-weight: 700;
}

/* Job Card Styling */
.manage-container {
  max-width: 1000px;
  margin: 0 auto;
}

.job-card {
  background: white;
  border-radius: 15px;
  padding: 30px;
  margin-bottom: 25px;
  position: relative;
  box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

.job-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
}

.job-title-section h2 {
  color: #333;
  font-size: 22px;
  margin: 0 0 5px 0;
  display: inline-block;
}

.badge-type {
  background-color: #d1e3f8;
  color: var(--primary-blue);
  padding: 4px 15px;
  border-radius: 5px;
  font-size: 13px;
  margin-left: 15px;
  border: 1px solid #adc9eb;
  vertical-align: middle;
}

.job-meta {
  color: var(--text-gray);
  font-size: 14px;
  margin: 5px 0;
}

.job-description {
  color: #444;
  font-size: 15px;
  line-height: 1.5;
  margin: 15px 0;
}

.see-more {
  color: var(--primary-blue);
  text-decoration: none;
  font-weight: 600;
  font-size: 13px;
}

/* Action Icons */
.action-icons {
  display: flex;
  gap: 20px;
}

.icon-btn {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 24px;
  transition: transform 0.2s;
}

.delete-icon { color: var(--danger-red); }
.edit-icon { color: var(--primary-blue); }

/* Skill Tags */
.skills-row {
  display: flex;
  gap: 10px;
  margin-top: 20px;
}

.skill-tag {
  background-color: var(--primary-blue);
  color: white;
  padding: 8px 25px;
  border-radius: 5px;
  font-size: 14px;
  font-weight: 500;
}

/* Modal */
.modal {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.5);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 999;
}

.modal-box {
  background: white;
  padding: 30px;
  border-radius: 10px;
  max-width: 400px;
  text-align: center;
}

.modal-actions {
  display: flex;
  gap: 15px;
  margin-top: 20px;
}

.modal-actions button {
  flex: 1;
  padding: 10px;
  font-weight: 600;
  border-radius: 5px;
  border: none;
  cursor: pointer;
}

.modal-actions .btn-primary { background: var(--primary-blue); color: white; }
.modal-actions .btn-danger { background: var(--danger-red); color: white; }
</style>
</head>
<body>

<div class="page-title-container">
  <h1>Manage Job</h1>
</div>

<div class="manage-container">
  
  <div class="job-card">
    <div class="job-header">
      <div class="job-title-section">
        <h2>Mobile App Developer | Flutter</h2>
        <span class="badge-type">Part Time</span>
        <div class="job-meta">Cj Fernandez • Posted on October 10, 2025</div>
        <div class="job-meta"><strong>$70,000</strong></div>
      </div>
      <div class="action-icons">
        <button class="icon-btn delete-icon" title="Delete">🗑️</button>
        <button class="icon-btn edit-icon" title="Edit">📝</button>
      </div>
    </div>
    
    <p class="job-description">
      We are seeking a Mobile App Developer (Flutter) to join our team...
      <a href="#" class="see-more">See More</a>
    </p>

    <div class="skills-row">
      <span class="skill-tag">Mobile Development</span>
      <span class="skill-tag">Flutter</span>
      <span class="skill-tag">Firebase</span>
    </div>
  </div>

  <div class="job-card">
    <div class="job-header">
      <div class="job-title-section">
        <h2>Web Developer - Urgent Hire</h2>
        <span class="badge-type" style="background:#eee; color:#666; border-color:#ccc;">Any</span>
        <div class="job-meta">Ryan Fernandez • Posted on October 10, 2025</div>
        <div class="job-meta"><strong>$500 - $1,500/month</strong></div>
      </div>
      <div class="action-icons">
        <button class="icon-btn delete-icon">🗑️</button>
        <button class="icon-btn edit-icon">📝</button>
      </div>
    </div>
    
    <p class="job-description">
      We're looking for a full-time web developer experienced in marketing funnels...
      <a href="#" class="see-more">See More</a>
    </p>
  </div>

</div>

<!-- Delete Modal -->
<div class="modal" id="deleteModal">
  <div class="modal-box">
    <h3>Delete Job?</h3>
    <p>This action cannot be undone.</p>
    <div class="modal-actions">
      <button class="btn-danger" id="confirmDeleteBtn">Delete</button>
      <button onclick="closeModal('deleteModal')">Cancel</button>
    </div>
  </div>
</div>

<script>
// Edit buttons
document.querySelectorAll('.edit-icon').forEach(btn => {
  btn.addEventListener('click', () => {
    window.location.href = 'edit_job.php';
  });
});

// Delete buttons
let deleteTarget = null;
document.querySelectorAll('.delete-icon').forEach(btn => {
  btn.addEventListener('click', (e) => {
    deleteTarget = e.target.closest('.job-card');
    document.getElementById('deleteModal').style.display = 'flex';
  });
});

document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
  if(deleteTarget){
    deleteTarget.remove();
    alert('Job deleted (connect to DB)');
    closeModal('deleteModal');
  }
});

function closeModal(id){
  document.getElementById(id).style.display = 'none';
}
</script>

</body>
</html>
