<?php include "../header_employer/postAJob.html";
include "../../config.php"; ?>

<style>
  .form-container {
    background-color: white;
    width: 100%;
    max-width: 600px;
    margin: 80px auto;
    padding: 40px 50px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }

  .form-container h2 {
    color: #0c4a86;
    font-size: 30px;
    font-weight: 600;
    margin-bottom: 30px;
    text-align: center;
  }

  .form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 25px;
  }

  .form-group label {
    color: #0c4a86;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 5px;
  }

  .form-group input,
  .form-group select {
    border: 2px solid #0c4a86;
    border-radius: 5px;
    height: 50px;
    padding: 0 20px;
    font-size: 16px;
  }

  .form-row {
    display: flex;
    gap: 20px;
  }

  .form-row .form-group {
    flex: 1;
  }

  .form-group textarea {
    border: 2px solid #0c4a86;
    border-radius: 5px;
    padding: 15px 20px;
    font-size: 16px;
    font-family: Arial;
    resize: vertical;
    min-height: 120px;
  }

  .btn-primary {
    background-color: #0c4a86;
    border: none;
    color: white;
    font-size: 16px;
    font-weight: 600;
    padding: 15px 0;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
  }

  .btn-primary:hover {
    opacity: 0.9;
  }

  .modal {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
  }

  .modal-box {
    background: white;
    padding: 40px;
    border-radius: 15px;
    text-align: center;
    max-width: 400px;
  }
</style>

<div class="form-container">
  <h2>Post a New Job</h2>
  <form id="post-job-form" onsubmit="submitJob(event)">
    <div class="form-group"><label>Job Title *</label><input type="text" name="title" placeholder="e.g. Junior Web Developer" required></div>
    <div class="form-group"><label>Job Overview *</label><textarea name="jobOverview" placeholder="Enter Job Overview" required></textarea></div>

    <div class="form-group">
      <label>Type of Employment *</label>
      <select name="job_type" required>
        <option value="">Select type</option>
        <option value="full-time">Full-time</option>
        <option value="part-time">Part-time</option>
        <option value="gig">Gig</option>
      </select>
    </div>

    <div class="form-group"><label>Key Responsibilities *</label><textarea name="keyResponsibilities" placeholder="Responsibility 1, Responsibility 2... (Use commas to separate items)" required></textarea></div>
    <div class="form-group"><label>Qualifications</label><textarea name="qualifications" placeholder="Qualification 1, Qualification 2... (Use commas to separate items)"></textarea></div>

    <div class="form-row">
      <div class="form-group"><label>Wage/Salary *</label><input type="number" name="wage" placeholder="e.g. 50000" required></div>
      <div class="form-group"><label>Hours per Week *</label><input type="number" name="hoursPerWeek" placeholder="e.g. 40" required></div>
    </div>

    <div class="form-group"><label>Contact Person *</label><input type="text" name="contactPerson" placeholder="e.g. John Doe" required></div>
    <div class="form-group"><label>Email *</label><input type="email" name="email" placeholder="e.g. JohnDoe@email.com" required></div>
    <div class="form-group"><label>Location *</label><input type="text" name="location" placeholder="e.g. Baguio City" required></div>
    <div class="form-group"><label>Skills</label><textarea name="skills" placeholder="PHP| JavaScript| HTML (Use | to separate)"></textarea></div>

    <button type="submit" class="btn-primary" style="width:100%">Post Job</button>
  </form>
</div>

<div class="modal" id="postSuccessModal">
  <div class="modal-box">
    <h3 style="color: #0c4a86;">Application Sent!</h3>
    <p>Your job post has been sent to the <strong>Admin for approval</strong>.</p>
    <p style="font-size: 14px; color: #666;">You will be notified once the status changes.</p>
    <button class="btn-primary" onclick="window.location.href='../manage_job/manage_job.php'" style="width: 100%; margin-top: 20px;">Check Status</button>
  </div>
</div>

<script>
  function submitJob(e) {
    e.preventDefault();
    const formData = new FormData(document.getElementById('post-job-form'));
    formData.append('action', 'post_job');
    fetch('../manage_job/job_operations.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json()).then(data => {
        if (data.status === 'success') document.getElementById('postSuccessModal').style.display = 'flex';
        else alert("Error: " + data.message);
      });
  }
</script>