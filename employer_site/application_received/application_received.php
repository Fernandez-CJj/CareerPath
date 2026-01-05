<?php
session_start();
include "../../config.php";

// Handle delete when employer chooses to remove an application (only if accepted/declined)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = (int)($_POST['delete_id'] ?? 0);
    if ($deleteId > 0 && isset($_SESSION['user_id'])) {
        $employerId = (int)$_SESSION['user_id'];
        $deleteSql = "DELETE FROM applications WHERE id = ? AND employer_id = ? AND status IN ('accepted','declined')";
        $delStmt = $conn->prepare($deleteSql);
        if ($delStmt) {
            $delStmt->bind_param("ii", $deleteId, $employerId);
            $delStmt->execute();
            $delStmt->close();
        }
    }
    header("Location: application_received.php");
    exit();
}
include "../header_employer/applicationReceived.html";


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

        body {
            background-color: var(--bg-gray);
        }

        .table-container {
            max-width: 1000px;
            margin: 50px auto;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .applicant-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .applicant-table th {
            padding: 20px;
            border-bottom: 2px solid var(--border-color);
            color: #333;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 1px;
            background-color: #fafafa;
        }

        .applicant-table td {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        .applicant-table tr:hover {
            background-color: #f9fbff;
            cursor: pointer;
        }

        .applicant-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ddd;
            object-fit: cover;
        }

        .status-btn {
            padding: 6px 20px;
            border-radius: 5px;
            font-weight: bold;
            min-width: 110px;
            border: 1.5px solid var(--primary-blue);
            text-transform: capitalize;
            font-size: 13px;
        }

        .status-pending {
            color: var(--primary-blue);
            background: white;
        }

        .status-accepted {
            color: white;
            background: var(--primary-blue);
        }

        .status-declined {
            color: #e74c3c;
            border-color: #e74c3c;
            background: white;
        }

        .action-cell {
            text-align: center;
        }

        .delete-btn {
            padding: 6px 14px;
            border-radius: 5px;
            border: 1px solid #e74c3c;
            background: #e74c3c;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s ease;
        }

        .delete-btn:hover {
            opacity: 0.9;
        }

        .delete-btn:disabled {
            background: #ccc;
            border-color: #ccc;
            cursor: not-allowed;
        }
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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php

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
                    while ($row = $result->fetch_assoc()) {
                        $date = date('F Y', strtotime($row['created_at']));
                        $statusClass = "status-" . strtolower($row['status']);
                        $canDelete = in_array(strtolower($row['status']), ['accepted', 'declined']);
                ?>
                        <tr>
                            <td onclick="location.href='application_detail.php?id=<?php echo $row['id']; ?>'">
                                <div class='applicant-info'>
                                    <span><?php echo htmlspecialchars($row['username']); ?></span>
                                </div>
                            </td>
                            <td onclick="location.href='application_detail.php?id=<?php echo $row['id']; ?>'"><?php echo htmlspecialchars($row['job_title']); ?></td>
                            <td onclick="location.href='application_detail.php?id=<?php echo $row['id']; ?>'"><?php echo $date; ?></td>
                            <td onclick="location.href='application_detail.php?id=<?php echo $row['id']; ?>'"><button class='status-btn <?php echo $statusClass; ?>'><?php echo $row['status']; ?></button></td>
                            <td class='action-cell'>
                                <?php if ($canDelete) { ?>
                                    <form method='post' style='margin:0;'>
                                        <input type='hidden' name='delete_id' value='<?php echo $row['id']; ?>'>
                                        <button type='submit' class='delete-btn' onclick="return confirm('Delete this application?');">Delete</button>
                                    </form>
                                <?php } else { ?>
                                    <button class='delete-btn' disabled>Delete</button>
                                <?php } ?>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align:center; padding:30px;'>No applications received yet.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>