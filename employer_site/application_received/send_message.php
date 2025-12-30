<?php 
session_start();
include "../../config.php";
include "../header_employer/applicationReceived.html";

$app_id = $_GET['id'] ?? null;

if (!$app_id) {
    header("Location: application_received.php");
    exit();
}

// Fetch info for the UI
$sql = "SELECT a.id, u.username, j.job_title FROM applications a 
        JOIN users u ON a.seeker_id = u.id 
        JOIN job j ON a.job_id = j.job_id WHERE a.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $app_id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

// Handle Message Submission
if (isset($_POST['confirm_acceptance'])) {
    $message = $_POST['employer_message'];
    
    // Update status to accepted and save the message
    $update_sql = "UPDATE applications SET status = 'accepted', message = ? WHERE id = ?";
    $upd_stmt = $conn->prepare($update_sql);
    $upd_stmt->bind_param("si", $message, $app_id);
    
    if ($upd_stmt->execute()) {
        echo "<script>alert('Application Accepted! Message sent to Seeker.'); window.location.href='application_received.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Acceptance Message</title>
    <style>
        :root { --primary-blue: #0c4a86; --bg-gray: #f4f7f6; }
        body { background-color: var(--bg-gray); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .message-container { max-width: 650px; margin: 60px auto; background: white; padding: 45px; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); }
        h2 { color: var(--primary-blue); margin-top: 0; }
        .info-box { background: #f0f7ff; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 5px solid var(--primary-blue); }
        .info-box p { margin: 5px 0; color: #333; }
        label { display: block; margin-bottom: 10px; font-weight: bold; color: #555; }
        textarea { width: 100%; height: 180px; padding: 15px; border: 1px solid #ccd6e0; border-radius: 8px; font-family: inherit; font-size: 15px; resize: none; box-sizing: border-box; outline-color: var(--primary-blue); }
        .btn-confirm { background: var(--primary-blue); color: white; border: none; padding: 15px 30px; border-radius: 8px; width: 100%; font-size: 17px; font-weight: bold; cursor: pointer; margin-top: 20px; transition: 0.3s; }
        .btn-confirm:hover { background: #083a6b; }
        .back-link { display: block; text-align: center; margin-top: 20px; color: #888; text-decoration: none; font-size: 14px; }
        .back-link:hover { color: var(--primary-blue); }
    </style>
</head>
<body>

<div class="message-container">
    <h2>Accept Application</h2>
    <div class="info-box">
        <p><strong>Applicant:</strong> <?php echo htmlspecialchars($data['username']); ?></p>
        <p><strong>Position:</strong> <?php echo htmlspecialchars($data['job_title']); ?></p>
    </div>

    <form method="POST">
        <label for="employer_message">Send a message to the seeker:</label>
        <textarea name="employer_message" id="employer_message" placeholder="e.g. Congratulations! We would like to schedule an interview with you on..." required></textarea>
        
        <button type="submit" name="confirm_acceptance" class="btn-confirm">Confirm Acceptance & Send Message</button>
    </form>
    
    <a href="application_detail.php?id=<?php echo $app_id; ?>" class="back-link">← Cancel and Go Back</a>
</div>

</body>
</html>