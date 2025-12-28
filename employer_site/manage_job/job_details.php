<?php 
include "../header_employer/ManageJob.html"; 
include "../../config.php"; 

$id = $_GET['id'] ?? 0;
$query = "SELECT job.*, users.username AS employer_name, users.email AS employer_email, users.created_at AS member_since 
          FROM job 
          LEFT JOIN users ON job.user_id = users.id 
          WHERE job.job_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$job = $stmt->get_result()->fetch_assoc();

if (!$job) { echo "<div style='text-align:center; margin-top:50px;'><h2>Job not found.</h2></div>"; exit; }

$employer_id = $job['user_id'];
$total_posts = $conn->query("SELECT COUNT(*) as total FROM job WHERE user_id = $employer_id")->fetch_assoc()['total'];
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
/* SCOPED CSS - Only affects elements inside .job-details-scope */
.job-details-scope { 
    background-color: #e9ecef; 
    font-family: 'Segoe UI', Arial, sans-serif; 
    margin-top: 0; 
    padding-bottom: 50px;
}

.job-details-scope .top-banner {
    background-color: #0c4a86;
    padding: 60px 20px 100px 20px;
    text-align: center;
    color: white;
}

.job-details-scope .info-bar-container {
    max-width: 900px;
    margin: -50px auto 30px auto;
    background: white;
    border-radius: 15px;
    display: flex;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    border: 1px solid #ddd;
}

.job-details-scope .info-item { flex: 1; display: flex; align-items: center; justify-content: center; gap: 15px; border-right: 1px solid #eee; }
.job-details-scope .info-item:last-child { border-right: none; }

.job-details-scope .info-icon { 
    width: 45px; height: 45px; background: #0c4a86; border-radius: 50%; 
    display: flex; align-items: center; justify-content: center; color: white;
}

.job-details-scope .detail-card {
    max-width: 900px; margin: 0 auto 20px auto; background: white; border-radius: 8px; border: 1px solid #dee2e6;
}

.job-details-scope .card-header {
    padding: 15px 25px; border-bottom: 1px solid #eee; color: #333; font-weight: bold; font-size: 14px;
}

.job-details-scope .skill-btn {
    background-color: #0c4a86; color: white; padding: 8px 20px; border-radius: 4px; border: none; margin-right: 10px;
    font-size: 14px; margin-bottom: 10px;
}

/* Bullet list styling to match screenshot */
.job-details-scope .bullet-list {
    padding-left: 20px;
    margin: 10px 0 20px 0;
    list-style-type: disc;
}
.job-details-scope .bullet-list li {
    margin-bottom: 8px;
}
.job-details-scope .section-title {
    font-weight: bold;
    display: block;
    margin-top: 15px;
    color: #333;
}
</style>

<div class="job-details-scope">
    <div class="top-banner">
        <h1>Urgently hiring for <?php echo htmlspecialchars($job['job_title']); ?>.</h1>
    </div>

    <div class="info-bar-container">
        <div class="info-item">
            <div class="info-icon"><i class="fas fa-briefcase"></i></div>
            <div style="display:flex; flex-direction:column;">
                <label style="font-size:11px; color:#777; font-weight:bold;">TYPE</label>
                <span style="font-weight:bold;"><?php echo ucfirst($job['type_of_work']); ?></span>
            </div>
        </div>
        <div class="info-item">
            <div class="info-icon"><i class="fas fa-money-bill-wave"></i></div>
            <div style="display:flex; flex-direction:column;">
                <label style="font-size:11px; color:#777; font-weight:bold;">SALARY</label>
                <span style="font-weight:bold;">₱<?php echo number_format($job['salary'], 0); ?></span>
            </div>
        </div>
        <div class="info-item">
            <div class="info-icon"><i class="fas fa-clock"></i></div>
            <div style="display:flex; flex-direction:column;">
                <label style="font-size:11px; color:#777; font-weight:bold;">HOURS</label>
                <span style="font-weight:bold;"><?php echo $job['hours']; ?>/wk</span>
            </div>
        </div>
        <div class="info-item">
            <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
            <div style="display:flex; flex-direction:column;">
                <label style="font-size:11px; color:#777; font-weight:bold;">LOCATION</label>
                <span style="font-weight:bold;"><?php echo htmlspecialchars($job['location']); ?></span>
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="card-header"><i class="far fa-file-alt"></i> JOB OVERVIEW</div>
        <div class="card-body" style="padding: 25px; line-height: 1.8; color: #444;">
            <p><?php echo nl2br(htmlspecialchars($job['job_overview'])); ?></p>
            
            <span class="section-title">Responsibilities:</span>
            <ul class="bullet-list">
                <?php 
                $resp = explode(',', $job['key_responsibilities']);
                foreach($resp as $item) {
                    if(trim($item)) echo "<li>" . htmlspecialchars(trim($item)) . "</li>";
                }
                ?>
            </ul>

            <span class="section-title">Qualifications:</span>
            <ul class="bullet-list">
                <?php 
                $qual = explode(',', $job['qualifications']);
                foreach($qual as $item) {
                    if(trim($item)) echo "<li>" . htmlspecialchars(trim($item)) . "</li>";
                }
                ?>
            </ul>
        </div>
    </div>

    <div class="detail-card">
        <div class="card-header"><i class="fas fa-tasks"></i> SKILL REQUIREMENT</div>
        <div class="card-body" style="padding: 25px;">
            <?php 
            $skills = explode(',', $job['skills_requirements']);
            foreach($skills as $skill) if(trim($skill)) echo "<button class='skill-btn'>".htmlspecialchars(trim($skill))."</button>";
            ?>
        </div>
    </div>

    <div class="detail-card">
        <div class="card-header">ABOUT THE EMPLOYER</div>
        <div class="card-body" style="padding: 25px;">
            <p style="margin:5px 0;"><b>Contact:</b> <?php echo htmlspecialchars($job['contact_person']); ?></p>
            <p style="margin:5px 0;"><b>Member since:</b> <?php echo date('M Y', strtotime($job['member_since'])); ?></p>
            <p style="margin:5px 0;"><b>Active Posts:</b> <?php echo $total_posts; ?></p>
        </div>
    </div>

    <div style="text-align: center; padding: 40px 0;">
        <a href="manage_job.php" style="
            display: inline-block;
            padding: 12px 30px;
            background-color: white;
            color: #0c4a86;
            border: 2px solid #0c4a86;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        " onmouseover="this.style.backgroundColor='#0c4a86'; this.style.color='white';" 
           onmouseout="this.style.backgroundColor='white'; this.style.color='#0c4a86';">
            <i class="fas fa-arrow-left"></i> Back to Manage Jobs
        </a>
    </div>
</div>