<?php 
session_start();
include "../../config.php";
include "../header_employer/applicationReceived.html";

$app_id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? 'accepted'; 
if (!$app_id) {
    header("Location: application_received.php");
    exit();
}

$sql = "SELECT a.id, u.username, j.job_title FROM applications a 
        JOIN users u ON a.seeker_id = u.id 
        JOIN job j ON a.job_id = j.job_id WHERE a.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $app_id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (isset($_POST['confirm_action'])) {
    $message = $_POST['employer_message'];
    $status_to_set = $_POST['status_action'];

    $update_sql = "UPDATE applications SET status = ?, message = ? WHERE id = ?";
    $upd_stmt = $conn->prepare($update_sql);
    $upd_stmt->bind_param("ssi", $status_to_set, $message, $app_id);
    
    if ($upd_stmt->execute()) {
        $alert_msg = ($status_to_set == 'accepted') ? 'Application Accepted!' : 'Application Declined.';
        echo "<script>alert('$alert_msg Message sent to Seeker.'); window.location.href='application_received.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo ucfirst($action); ?> Application</title>
    <style>
   
        :root { 
            --primary-blue: #0c4a86; 
            --danger-red: #e74c3c;
            --bg-gray: #f4f7f6; 
            --theme-color: <?php echo ($action === 'declined') ? 'var(--danger-red)' : 'var(--primary-blue)'; ?>;
        }
        body { background-color: var(--bg-gray);  }
        .message-container { max-width: 650px; margin: 60px auto; background: white; padding: 45px; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); }
        h2 { color: var(--theme-color); margin-top: 0; }
        .info-box { background: #f0f7ff; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 5px solid var(--theme-color); }
        .info-box p { margin: 5px 0; color: #333; }
        label { display: block; margin-bottom: 10px; font-weight: bold; color: #555; }
        textarea { width: 100%; height: 180px; padding: 15px; border: 1px solid #ccd6e0; border-radius: 8px; font-family: inherit; font-size: 15px; resize: none; box-sizing: border-box; outline-color: var(--theme-color); }
        .btn-confirm { background: var(--theme-color); color: white; border: none; padding: 15px 30px; border-radius: 8px; width: 100%; font-size: 17px; font-weight: bold; cursor: pointer; margin-top: 20px; transition: 0.3s; }
        .btn-confirm:hover { filter: brightness(90%); }
        .back-link { display: block; text-align: center; margin-top: 20px; color: #888; text-decoration: none; font-size: 14px; }
        .back-link:hover { color: var(--theme-color); }
    </style>
</head>
<body>

<div class="message-container">
    <h2><?php echo ($action === 'declined') ? 'Decline Application' : 'Accept Application'; ?></h2>
    <div class="info-box">
        <p><strong>Applicant:</strong> <?php echo htmlspecialchars($data['username']); ?></p>
        <p><strong>Position:</strong> <?php echo htmlspecialchars($data['job_title']); ?></p>
    </div>

    <form method="POST">
        <input type="hidden" name="status_action" value="<?php echo $action; ?>">
        
        <label for="employer_message">Send a message to the seeker:</label>
        <textarea name="employer_message" id="employer_message" 
            placeholder="<?php echo ($action === 'declined') ? 'e.g. Thank you for your interest, but we have decided to move forward with other candidates, Please understand ...' : 'e.g. Congratulations! We would like to schedule an interview...'; ?>" 
            required></textarea>
        
        <button type="submit" name="confirm_action" class="btn-confirm">
            Confirm <?php echo ucfirst($action); ?> & Send Message
        </button>
    </form>
    
    <a href="application_detail.php?id=<?php echo $app_id; ?>" class="back-link">← Cancel and Go Back</a>
</div>

</body>
</html>