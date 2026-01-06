<?php
include "../header_admin/header_admin.html";
include "../../config.php";

$id = $_GET['id'] ?? 0;
$query = "SELECT job.*, users.username AS employer_name, users.created_at AS member_since 
          FROM job 
          LEFT JOIN users ON job.user_id = users.id 
          WHERE job.job_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$job = $stmt->get_result()->fetch_assoc();

if (!$job) {
    echo "Job not found.";
    exit;
}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    :root {
        --primary-blue: #0c4a86;
        --bg-gray: #f4f7f6;
    }

    body {
        background-color: var(--bg-gray);
        font-family: 'Segoe UI', sans-serif;
        margin: 0;
    }

    .details-banner {
        background: var(--primary-blue);
        color: white;
        padding: 80px 20px;
        text-align: center;
    }

    .details-container {
        max-width: 950px;
        margin: -50px auto 50px auto;
        padding: 0 20px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        background: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .stat-item {
        text-align: center;
        border-right: 1px solid #eee;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }

    .stat-item:last-child {
        border-right: none;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        background: var(--primary-blue);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .stat-label {
        font-size: 10px;
        text-transform: uppercase;
        color: #999;
        font-weight: bold;
        display: block;
        text-align: left;
    }

    .stat-value {
        font-weight: bold;
        color: #222;
        font-size: 14px;
        text-align: left;
    }

    .detail-card {
        background: white;
        border-radius: 8px;
        margin-bottom: 25px;
        border: 1px solid #dee2e6;
        overflow: hidden;
    }

    .detail-card h3 {
        background: #f8f9fa;
        border-bottom: 1px solid #eee;
        padding: 15px 25px;
        margin: 0;
        font-size: 14px;
        color: #333;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .detail-card-body {
        padding: 25px;
        line-height: 1.8;
        color: #555;
    }

    .skill-btn {
        background-color: var(--primary-blue);
        color: white;
        padding: 8px 20px;
        border-radius: 4px;
        border: none;
        margin: 0 10px 10px 0;
    }

    .btn-back {
        padding: 12px 30px;
        border: 2px solid var(--primary-blue);
        background: white;
        color: var(--primary-blue);
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        text-decoration: none;
        display: inline-block;
    }
</style>

<div class="details-banner">
    <h1>Urgently hiring for <?php echo htmlspecialchars($job['job_title']); ?></h1>
</div>

<div class="details-container">
    <div class="stats-grid">
        <div class="stat-item">
            <div class="stat-icon"><i class="fas fa-briefcase"></i></div>
            <div><span class="stat-label">TYPE</span><span class="stat-value"><?php echo strtoupper($job['type_of_work']); ?></span></div>
        </div>
        <div class="stat-item">
            <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
            <div><span class="stat-label">SALARY</span><span class="stat-value">₱<?php echo number_format($job['salary'], 2); ?></span></div>
        </div>
        <div class="stat-item">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div><span class="stat-label">POSTED</span><span class="stat-value"><?php echo $job['date_posted']; ?></span></div>
        </div>
        <div class="stat-item">
            <div class="stat-icon"><i class="fas fa-map-marker-alt"></i></div>
            <div><span class="stat-label">LOCATION</span><span class="stat-value"><?php echo htmlspecialchars($job['location']); ?></span></div>
        </div>
    </div>

    <div class="detail-card">
        <h3><i class="far fa-file-alt"></i> JOB OVERVIEW</h3>
        <div class="detail-card-body"><?php echo nl2br(htmlspecialchars($job['job_overview'])); ?></div>
    </div>

    <div class="detail-card">
        <h3><i class="fas fa-tasks"></i> SKILL REQUIREMENT</h3>
        <div class="detail-card-body">
            <?php
            $skills = explode('|', $job['skills_requirements']);
            foreach ($skills as $s) if (trim($s)) echo "<button class='skill-btn'>" . htmlspecialchars(trim($s)) . "</button>";
            ?>
        </div>
    </div>

    <div class="detail-card">
        <h3><i class="fas fa-building"></i> ABOUT THE EMPLOYER</h3>
        <div class="detail-card-body">
            <p><b>Contact Person:</b> <?php echo htmlspecialchars($job['contact_person']); ?></p>
            <p><b>Employer:</b> <?php echo htmlspecialchars($job['employer_name']); ?></p>
            <p><b>Member since:</b> <?php echo date('M Y', strtotime($job['member_since'])); ?></p>
        </div>
    </div>

    <div style="text-align: center;">
        <a href="job_approvals.php" class="btn-back">← Back to Approvals</a>
    </div>
</div>