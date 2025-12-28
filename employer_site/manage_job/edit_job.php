<?php 
// 1. Session and Logic MUST come first
if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
}

include "../../config.php"; 

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'];
$logged_in_user = $_SESSION['user_id'];

// Fetch the job
$sql = "SELECT job.*, users.email 
        FROM job 
        JOIN users ON job.user_id = users.id 
        WHERE job.job_id = ? AND job.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $logged_in_user);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0) {
    echo "<script>alert('Unauthorized!'); window.location.href='manage_job.php';</script>";
    exit();
}

$job = $result->fetch_assoc();

// 2. Now you can include HTML files
include "../header_employer/ManageJob.html";
?>

<style>
/* Your Exact CSS Provided Earlier */
.form-container { background-color: white; width: 100%; max-width: 700px; margin: 50px auto; padding: 40px 60px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.05); }
.form-group { display: flex; flex-direction: column; margin-bottom: 25px; }
.form-group label { color: #0c4a86; font-weight: 600; font-size: 18px; margin-bottom: 10px; }
.form-group input, .form-group textarea, .form-group select { border: 2px solid #0c4a86; border-radius: 8px; padding: 15px; font-size: 16px; width: 100%; }
.modal { position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; }
.modal-box { background: white; padding: 50px; border-radius: 20px; text-align: center; width: 500px; }
.btn-save-confirm { background: #0c4a86; color: white; padding: 15px 40px; border-radius: 8px; border: none; font-weight: bold; cursor: pointer; font-size: 18px; }
.btn-cancel-gray { background: #aaa; color: white; padding: 15px 40px; border-radius: 8px; border: none; font-weight: bold; cursor: pointer; font-size: 18px; }
</style>

<div class="form-container">
    <h1 style="color: #0c4a86; margin-bottom: 30px;">Edit Job Ad</h1>
    <form id="edit-form">
        <input type="hidden" name="job_id" value="<?php echo $id; ?>">
        
        <div class="form-group"><label>Job Title</label><input type="text" name="title" value="<?php echo htmlspecialchars($job['job_title']); ?>"></div>
        <div class="form-group"><label>Job Overview</label><textarea name="jobOverview" rows="5"><?php echo htmlspecialchars($job['job_overview']); ?></textarea></div>
        
        <div class="form-group">
            <label>Type of Employment</label>
            <select name="job_type">
                <option value="full-time" <?php if($job['type_of_work']=='full-time') echo 'selected'; ?>>Full Time</option>
                <option value="part-time" <?php if($job['type_of_work']=='part-time') echo 'selected'; ?>>Part Time</option>
                <option value="gig" <?php if($job['type_of_work']=='gig') echo 'selected'; ?>>Gig</option>
            </select>
        </div>
        
        <div class="form-group"><label>Key Responsibilities</label><textarea name="keyResponsibilities" rows="6"><?php echo htmlspecialchars($job['key_responsibilities']); ?></textarea></div>
        <div class="form-group"><label>Qualifications</label><textarea name="qualifications" rows="5"><?php echo htmlspecialchars($job['qualifications']); ?></textarea></div>
        <div class="form-group"><label>Wage/Salary</label><input type="number" name="wage" value="<?php echo $job['salary']; ?>"></div>
        <div class="form-group"><label>Hours per Week</label><input type="number" name="hoursPerWeek" value="<?php echo $job['hours']; ?>"></div>
        <div class="form-group"><label>Contact Person</label><input type="text" name="contactPerson" value="<?php echo htmlspecialchars($job['contact_person']); ?>"></div>
        
        <div class="form-group">
            <label>Email</label>
            <input type="email" value="<?php echo htmlspecialchars($job['email']); ?>" readonly style="background-color: #f9f9f9; cursor: not-allowed;">
        </div>
        
        <div class="form-group"><label>Location</label><input type="text" name="location" value="<?php echo htmlspecialchars($job['location']); ?>"></div>
        <div class="form-group"><label>Skills</label><textarea name="skills"><?php echo htmlspecialchars($job['skills_requirements']); ?></textarea></div>
        
        <button type="button" onclick="document.getElementById('saveModal').style.display='flex'" style="width: 100%; background: #0c4a86; color: white; padding: 18px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 18px;">Update Posting</button>
    </form>
</div>

<div class="modal" id="saveModal">
    <div class="modal-box">
        <img src="../../assets/images/save.png" style="width: 150px; height: auto; margin-bottom: 20px;" onerror="this.src='https://cdn-icons-png.flaticon.com/512/2874/2874050.png'">
        <h1 style="color: #0c4a86; margin-bottom: 10px;">Save Changes?</h1>
        <p style="color: #777; margin-bottom: 40px;">Save all of your changes</p>
        <div style="display: flex; justify-content: space-between;">
            <button class="btn-cancel-gray" onclick="document.getElementById('saveModal').style.display='none'">Cancel</button>
            <button class="btn-save-confirm" onclick="updateJob()">Save Changes</button>
        </div>
    </div>
</div>

<script>
function updateJob() {
    const formData = new FormData(document.getElementById('edit-form'));
    formData.append('action', 'update_job');
    fetch('job_operations.php', { method: 'POST', body: formData })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success') window.location.href='manage_job.php';
        else alert("Error: " + data.message);
    });
}
</script>