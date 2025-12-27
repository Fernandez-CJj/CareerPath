<?php 
include "../header_employer/ManageJob.html";
?>

<style>
/* ===== FORM STYLES ===== */
.form-container {
  background-color: white;
  max-width: 600px;
  margin: 80px auto;
  padding: 40px 50px;
  border-radius: 10px;
}

.form-container h2 {
  color: #0c4a86;
  font-size: 30px;
  font-weight: 600;
  text-align: center;
  margin-bottom: 30px;
}

.form-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 25px;
}

.form-group label {
  color: #0c4a86;
  font-weight: 600;
  margin-bottom: 5px;
}

.form-group input,
.form-group textarea,
.form-group select {
  border: 2px solid #0c4a86;
  border-radius: 5px;
  padding: 12px 20px;
  font-size: 16px;
}

.form-group textarea {
  min-height: 120px;
  resize: vertical;
}

.form-row {
  display: flex;
  gap: 20px;
}

.form-row .form-group {
  flex: 1;
}

/* ===== BUTTONS ===== */
.btn-primary {
  background: #0c4a86;
  color: white;
  padding: 14px;
  border-radius: 5px;
  font-weight: 600;
  border: none;
  cursor: pointer;
}

.btn-danger {
  background: #e74c3c;
  color: white;
  padding: 14px;
  border-radius: 5px;
  font-weight: 600;
  border: none;
  cursor: pointer;
}

.action-row {
  display: flex;
  gap: 15px;
  margin-top: 20px;
}

/* ===== MODAL ===== */
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

.modal-box h3 {
  color: #0c4a86;
}

.modal-actions {
  display: flex;
  gap: 15px;
  margin-top: 20px;
}

.modal-actions button {
  flex: 1;
}
</style>

<div class="form-container">
  <h2>Edit Job</h2>

  <form id="edit-job-form">

    <div class="form-group">
      <label>Job Title</label>
      <input type="text" value="Mobile App Developer | Flutter">
    </div>

    <div class="form-group">
      <label>Job Description</label>
      <textarea>We are seeking a Mobile App Developer...</textarea>
    </div>

    <div class="form-group">
      <label>Type of Employment</label>
      <select>
        <option>Full-time</option>
        <option selected>Part-time</option>
        <option>Gig</option>
      </select>
    </div>

    <div class="form-group">
      <label>Key Responsibilities</label>
      <textarea>Build Flutter apps, integrate APIs...</textarea>
    </div>

    <div class="form-group">
      <label>Qualifications</label>
      <textarea>BSIT or equivalent experience</textarea>
    </div>

    <div class="form-group">
      <label>Wage / Salary per month</label>
      <input type="number" value="70000">
    </div>
     
   
     <div class="form-group">
      <label>Hours per Week</label>
      <input type="number" value="20">
    </div>
    <div class="form-group">
      <label>Contact Person</label>
      <input type="text" value="Cj Fernandez">
    </div>

    <div class="form-group">
      <label>Email</label>
      <input type="email" value="cj@email.com">
    </div>

    <div class="form-group">
      <label>Skills</label>
      <textarea>Flutter, Firebase, REST API</textarea>
    </div>
    

    <div class="action-row">
      <button type="button" class="btn-primary" onclick="confirmSave()">
        Save Changes
      </button>
      <button type="button" class="btn-danger" onclick="confirmDelete()">
        Delete Job
      </button>
    </div>

  </form>
</div>

<!-- ===== SAVE MODAL ===== -->
<div class="modal" id="saveModal">
  <div class="modal-box">
    <h3>Save Changes?</h3>
    <p>Are you sure you want to save these changes?</p>
    <div class="modal-actions">
      <button class="btn-primary" onclick="saveChanges()">Yes</button>
      <button onclick="closeModal('saveModal')">Cancel</button>
    </div>
  </div>
</div>

<!-- ===== DELETE MODAL ===== -->
<div class="modal" id="deleteModal">
  <div class="modal-box">
    <h3>Delete Job?</h3>
    <p>This action cannot be undone.</p>
    <div class="modal-actions">
      <button class="btn-danger" onclick="deleteJob()">Delete</button>
      <button onclick="closeModal('deleteModal')">Cancel</button>
    </div>
  </div>
</div>

<script>
function confirmSave() {
  document.getElementById('saveModal').style.display = "flex";
}

function confirmDelete() {
  document.getElementById('deleteModal').style.display = "flex";
}

function closeModal(id) {
  document.getElementById(id).style.display = "none";
}

function saveChanges() {
  closeModal('saveModal');
  alert("Changes saved (connect to PHP & DB)");
}

function deleteJob() {
  closeModal('deleteModal');
  alert("Job deleted (connect to PHP & DB)");
}
</script>
