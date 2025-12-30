<?php 
session_start();
include "../../config.php";

// 1. DATA AND SESSION CHECK
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login_modules/login.php"); 
    exit();
}

$app_id = $_GET['id'] ?? null;

if (!$app_id) {
    header("Location: application_received.php");
    exit();
}

// 2. LOGIC PROCESSING
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Both actions now redirect to send_message.php to allow for a custom message
    $action = $_POST['action']; // This will be 'accepted' or 'declined'
    header("Location: send_message.php?id=" . $app_id . "&action=" . $action); 
    exit();
}

// 3. FETCH DATA FOR DISPLAY
$sql = "SELECT a.*, u.username, u.email, u.contactnumber, j.job_title 
        FROM applications a
        JOIN users u ON a.seeker_id = u.id
        JOIN job j ON a.job_id = j.job_id
        WHERE a.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $app_id);
$stmt->execute();
$applicant = $stmt->get_result()->fetch_assoc();

// 4. INCLUDE THE HEADER
include "../header_employer/applicationReceived.html"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Applicant Detail | CareerPath</title>
    <style>
        :root { 
            --primary-blue: #0c4a86; 
            --danger-red: #e74c3c; 
            --bg-gray: #f4f7f6; 
        }

        body { 
            background-color: var(--bg-gray); 
            margin: 0; 
        }

        .detail-container { 
            max-width: 850px; 
            margin: 40px auto; 
            background: white; 
            padding: 40px; 
            border-radius: 12px; 
            box-shadow: 0 5px 25px rgba(0,0,0,0.1); 
        }

        .header-flex { 
            display: flex; 
            justify-content: space-between; 
            align-items: flex-start; 
            border-bottom: 1px solid #eee; 
            padding-bottom: 20px; 
        }

        .applicant-meta h2 { color: var(--primary-blue); margin: 0; font-size: 32px; }

        .status-tag { 
            background: #eef4ff; 
            padding: 8px 20px; 
            border-radius: 20px; 
            color: var(--primary-blue); 
            font-weight: bold; 
            text-transform: uppercase; 
            font-size: 12px; 
        }

        .resume-preview { 
            width: 100%; 
            height: 550px; 
            border: 2px solid #eaeff5; 
            border-radius: 10px; 
            margin: 25px 0; 
            overflow: hidden; 
            position: relative; 
            cursor: pointer;
            background: #fdfdfd;
        }

        .resume-preview iframe { 
            width: 100%; 
            height: 100%; 
            border: none; 
            pointer-events: none; 
        }

        .action-bar { 
            display: flex; 
            justify-content: center; 
            gap: 25px; 
            margin-top: 30px; 
        }

        .btn { 
            padding: 14px 50px; 
            border-radius: 8px; 
            font-weight: bold; 
            cursor: pointer; 
            font-size: 16px; 
            transition: all 0.2s; 
            border: none;
        }

        .btn-accept { background: var(--primary-blue); color: white; }
        .btn-decline { background: white; color: var(--danger-red); border: 2px solid var(--danger-red); }
        .btn:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); opacity: 0.9; }

        #overlay { 
            display: none; 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            background: rgba(0,0,0,0.9); 
            z-index: 9999; 
            justify-content: center; 
            align-items: center; 
        }

        #overlay iframe { 
            width: 85%; 
            height: 90vh; 
            background: white;
            border-radius: 5px;
            border: none;
        }

        .close-btn { 
            position: absolute; 
            top: 20px; 
            right: 40px; 
            color: white; 
            font-size: 50px; 
            cursor: pointer; 
            line-height: 1;
        }
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

    <div class="resume-preview" onclick="openFullResume()">
        <?php if(!empty($applicant['resume_path'])): ?>
            <iframe src="../../<?php echo htmlspecialchars($applicant['resume_path']); ?>"></iframe>
        <?php else: ?>
            <div style="display:flex; justify-content:center; align-items:center; height:100%; color:#888;">No Resume Uploaded</div>
        <?php endif; ?>
    </div>
    <p style="text-align:center; color:#888; font-size: 13px;">Click the box above to view Resume in Full Screen</p>

    <form method="POST" class="action-bar">
        <button type="submit" name="action" value="declined" class="btn btn-decline">Decline Applicant</button>
        <button type="submit" name="action" value="accepted" class="btn btn-accept">Accept & Message</button>
    </form>
</div>

<div id="overlay">
    <span class="close-btn" onclick="closeFullResume()">&times;</span>
    <iframe id="fullScreenIframe" src="../../<?php echo htmlspecialchars($applicant['resume_path']); ?>"></iframe>
</div>

<script>
    function openFullResume() {
        document.getElementById('overlay').style.display = 'flex';
        const iframe = document.getElementById('fullScreenIframe');
        iframe.src = iframe.src;
    }

    function closeFullResume() {
        document.getElementById('overlay').style.display = 'none';
    }

    window.onclick = function(event) {
        const overlay = document.getElementById('overlay');
        if (event.target == overlay) {
            closeFullResume();
        }
    }
</script>

</body>
</html>