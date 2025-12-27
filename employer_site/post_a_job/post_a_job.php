<?php 
include "../header_employer/postAJob.html";
?>

<!-- PAGE-SPECIFIC STYLES -->
<style>
.form-container {
  background-color: white;
  width: 100%;
  max-width: 600px;
  margin: 80px auto;
  padding: 40px 50px;
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

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  outline: none;
  box-shadow: 0 0 0 2px rgba(12, 74, 134, 0.2);
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
  transition: opacity 0.3s ease;
}

.btn-primary:hover {
  opacity: 0.85;
}
</style>

<!-- PAGE CONTENT -->
<div class="form-container">
  <h2>Post a New Job</h2>

  <form id="post-job-form" onsubmit="postJob(event)">

    <div class="form-group">
      <label>Job Title *</label>
      <input type="text" name="title" placeholder="e.g. Junior Web Developer" required>
    </div>

    <div class="form-group">
      <label>Job Description *</label>
      <textarea name="jobDescription" placeholder="Enter Job Description" required></textarea>
    </div>

    <div class="form-row">
      

      <div class="form-group">
        <label>Type of Employment *</label>
        <select name="job_type" required>
          <option value="">Select type</option>
          <option value="Full-time">Full-time</option>
          <option value="Part-time">Part-time</option>
          <option value="Gig">Gig</option>
         
        </select>
      </div>
    </div>


 

    <div class="form-group">
      <label>Key Responsibilities *</label>
      <textarea name="keyResponsibilities" placeholder="e.g. Managed team of developers, conducted code reviews. Use commas as separator" required></textarea>
    </div>

    <div class="form-group">
      <label>Qualifications</label>
      <textarea name="qualifications" placeholder="e.g. Bachelor's degree in Computer Science, 2+ years of experience, Use commas as separator"></textarea>
    </div>
   <div class="form-group">
      <label>Wage/Salary per month *</label>
      <input type="number" name="wage" placeholder="e.g. 50000" required>
      
    </div>
     <div class="form-group">
      <label>Hours per Week *</label>
      <input type="number" name="hoursPerWeek" placeholder="e.g. 40" required>
      
    </div>
    
  <div class="form-group">
      <label>Contact Person *</label>
      <input type="text" name="contactPerson" placeholder="e.g. John Doe" required>
    </div>
      <div class="form-group">
      <label>Email *</label>
      <input type="email" name="email" placeholder="e.g. JohnDoe@email.com" required>
    </div>
    
    <div class="form-group">
      <label>Skills</label>
      <textarea name="skills" placeholder="e.g. PHP, JavaScript, HTML. Use commas as separator"></textarea>
    </div>
  
    <button type="submit" class="btn-primary" style="width:100%">
      Post Job
    </button>

  </form>
</div>

<!-- AJAX SCRIPT -->

