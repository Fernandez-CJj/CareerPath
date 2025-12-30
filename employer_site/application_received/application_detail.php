<?php 
session_start();
include "../../config.php";

// 1. GET DATA FIRST
$app_id = $_GET['id'] ?? null;

if (!$app_id) {
    header("Location: application_received.php");
    exit();
}

// 2. HANDLE LOGIC BEFORE ANY HTML OUTPUT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'declined') {
        $update_sql = "UPDATE applications SET status = 'declined' WHERE id = ?";
        $upd_stmt = $conn->prepare($update_sql);
        $upd_stmt->bind_param("i", $app_id);
        $upd_stmt->execute();
        header("Location: application_received.php"); // This will now work
        exit();
    } elseif (isset($_POST['action']) && $_POST['action'] === 'accepted') {
        header("Location: send_message.php?id=" . $app_id); // This will now work
        exit();
    }
}

// 3. FETCH DATA FOR THE UI
$sql = "SELECT a.*, u.username, u.email, u.contactnumber, j.job_title 
        FROM applications a
        JOIN users u ON a.seeker_id = u.id
        JOIN job j ON a.job_id = j.job_id
        WHERE a.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $app_id);
$stmt->execute();
$applicant = $stmt->get_result()->fetch_assoc();

// 4. NOW START OUTPUTTING HTML
include "../header_employer/applicationReceived.html"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Applicant Detail</title>
    <style>
        :root { --primary-blue: #0c4a86; --danger-red: #e74c3c; --bg-gray: #f4f7f6; }
        body { background-color: var(--bg-gray); font-family: 'Segoe UI', Arial, sans-serif; margin: 0; }
        .detail-container { max-width: 850px; margin: 40px auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 5px 25px rgba(0,0,0,0.1); }
        .header-flex { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 1px solid #eee; padding-bottom: 20px; }
        .applicant-meta h2 { color: var(--primary-blue); margin: 0; font-size: 32px; }
        .status-tag { background: #eef4ff; padding: 8px 20px; border-radius: 20px; color: var(--primary-blue); font-weight: bold; text-transform: uppercase; font-size: 12px; }
        .resume-preview { width: 100%; height: 550px; border: 2px solid #eaeff5; border-radius: 10px; margin: 25px 0; overflow: hidden; position: relative; }
        .resume-preview iframe { width: 100%; height: 100%; border: none; }
        .action-bar { display: flex; justify-content: center; gap: 25px; margin-top: 30px; }
        .btn { padding: 14px 50px; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 16px; transition: all 0.2s; text-decoration: none; display: inline-block; text-align: center; border: none; }
        .btn-accept { background: var(--primary-blue); color: white; }
        .btn-decline { background: white; color: var(--danger-red); border: 2px solid var(--danger-red); }
        .btn:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); opacity: 0.9; }
        #overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 9999; justify-content: center; align-items: center; }
        #overlay iframe { width: 90%; height: 95%; }
        .close-btn { position: absolute; top: 20px; right: 40px; color: white; font-size: 45px; cursor: pointer; }
    </style>
</head>
<body>

<div class="detail-container">
    <div class="header-flex">
        <div class="applicant-meta">
            <h2><?php echo htmlspecialchars($applicant['username']); ?></h2>
            <p style="color:#444; font-size: 18px; margin: 8px 0; font-weight: 500;"><?php echo htmlspecialchars($applicant['job_title']); ?></p>
            <p style="color:#777; font-size: 14px;">📧 <?php echo htmlspecialchars($applicant['email']); ?> | 📞 <?php echo htmlspecialchars($applicant['contactnumber']); ?></p>
        </div>
        <div class="status-tag">Status: <?php echo htmlspecialchars($applicant['status']); ?></div>
    </div>

    <div class="resume-preview" onclick="document.getElementById('overlay').style.display='flex'">
        <?php if(!empty($applicant['resume_path'])): ?>
            <iframe src="../../<?php echo htmlspecialchars($applicant['resume_path']); ?>"></iframe>
        <?php else: ?>
            <div style="display:flex; justify-content:center; align-items:center; height:100%; color:#888;">No Resume Uploaded</div>
        <?php endif; ?>
    </div>
    <p style="text-align:center; color:#888; font-size: 13px;">Click preview to view Full Screen</p>

    <form method="POST" class="action-bar">
        <button type="submit" name="action" value="declined" class="btn btn-decline">Decline Applicant</button>
        <button type="submit" name="action" value="accepted" class="btn btn-accept">Accept & Message</button>
    </form>
</div>

<div id="overlay">
    <span class="close-btn" onclick="document.getElementById('overlay').style.display='none'">&times;</span>
    <iframe src="../../<?php echo htmlspecialchars($applicant['resume_path']); ?>"></iframe>
</div>

</body>
</html>