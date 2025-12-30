<?php 
session_start();
include "../../config.php";
include "../header_employer/applicationReceived.html"; 

// Assume the logged-in employer ID is stored in the session
$employer_id = $_SESSION['user_id']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applications Received</title>
    <style>
        :root {
            --primary-blue: #0c4a86;
            --bg-gray: #f4f7f6;
            --border-color: #adc9eb;
        }
        body { background-color: var(--bg-gray); font-family: Arial, sans-serif; }
        
        .table-container {
            max-width: 1000px;
            margin: 50px auto;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .applicant-table { width: 100%; border-collapse: collapse; text-align: left; }
        .applicant-table th {
            padding: 20px;
            border-bottom: 2px solid var(--border-color);
            color: #333;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 1px;
            background-color: #fafafa;
        }

        .applicant-table td { padding: 15px 20px; border-bottom: 1px solid #eee; vertical-align: middle; }
        .applicant-table tr:hover { background-color: #f9fbff; cursor: pointer; }

        .applicant-info { display: flex; align-items: center; gap: 15px; }
        .avatar { width: 40px; height: 40px; border-radius: 50%; background: #ddd; object-fit: cover; }

        .status-btn {
            padding: 6px 20px;
            border-radius: 5px;
            font-weight: bold;
            min-width: 110px;
            border: 1.5px solid var(--primary-blue);
            text-transform: capitalize;
            font-size: 13px;
        }
        .status-pending { color: var(--primary-blue); background: white; }
        .status-accepted { color: white; background: var(--primary-blue); }
        .status-declined { color: #e74c3c; border-color: #e74c3c; background: white; }
    </style>
</head>
<body>

<div class="table-container">
    <table class="applicant-table">
        <thead>
            <tr>
                <th>Applicant</th>
                <th>Position</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch applications for this employer
            $sql = "SELECT a.id, a.status, a.created_at, u.username, j.job_title 
                    FROM applications a
                    JOIN users u ON a.seeker_id = u.id
                    JOIN job j ON a.job_id = j.job_id
                    WHERE a.employer_id = ?
                    ORDER BY a.created_at DESC";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $employer_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $date = date('F Y', strtotime($row['created_at']));
                    $statusClass = "status-" . strtolower($row['status']);
                    echo "<tr onclick=\"location.href='application_detail.php?id={$row['id']}'\">
                            <td>
                                <div class='applicant-info'>
                                    <div class='avatar'></div>
                                    <span>" . htmlspecialchars($row['username']) . "</span>
                                </div>
                            </td>
                            <td>" . htmlspecialchars($row['job_title']) . "</td>
                            <td>$date</td>
                            <td><button class='status-btn $statusClass'>{$row['status']}</button></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4' style='text-align:center; padding:30px;'>No applications received yet.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>