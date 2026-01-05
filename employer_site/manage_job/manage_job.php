<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../header_employer/ManageJob.html";
include "../../config.php";

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='../login.php';</script>";
    exit();
}
$logged_in_user_id = $_SESSION['user_id'];
?>

<style>
    :root {
        --primary-blue: #0c4a86;
        --bg-gray: #f4f7f6;
        --delete-red: #dc3545;
    }

    body {
        background-color: var(--bg-gray);
        font-family: Arial, sans-serif;
    }

    .manage-container {
        max-width: 1100px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .manage-header {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 30px;
        text-align: center;
        border: 1px solid #ddd;
    }

    .manage-header h1 {
        color: var(--primary-blue);
        margin: 0;
        font-size: 28px;
    }

    .job-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 25px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        position: relative;
    }

    /* STATUS BADGE STYLES */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 15px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .status-rejected {
        background-color: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .status-active {
        background-color: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .check-icon {
        background-color: #22c55e;
        color: white;
        border-radius: 4px;
        padding: 0 4px;
        font-size: 11px;
    }

    /* SKILL TAGS */
    .skills-flex {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 20px;
    }

    .skill-box {
        background-color: var(--primary-blue);
        color: white;
        padding: 8px 22px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
    }

    .job-title {
        font-size: 22px;
        font-weight: bold;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .type-label {
        background: #d1e3f8;
        color: #0c4a86;
        padding: 2px 10px;
        border-radius: 4px;
        font-size: 12px;
    }

    .action-btns {
        position: absolute;
        top: 30px;
        right: 30px;
        display: flex;
        gap: 20px;
    }

    .action-btns img {
        width: 40px;
        cursor: pointer;
        transition: 0.2s;
    }

    /* CUSTOM DELETE MODAL STYLES */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: white;
        padding: 40px;
        border-radius: 20px;
        width: 450px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .modal-content img {
        width: 80px;
        margin-bottom: 20px;
    }

    .modal-content h2 {
        color: var(--primary-blue);
        margin-bottom: 10px;
        font-size: 24px;
    }

    .modal-content p {
        color: #666;
        margin-bottom: 30px;
    }

    .modal-btns {
        display: flex;
        justify-content: space-between;
        gap: 20px;
    }

    .btn-modal {
        flex: 1;
        padding: 12px;
        border-radius: 8px;
        border: none;
        font-weight: bold;
        cursor: pointer;
        font-size: 16px;
    }

    .btn-cancel {
        background: #2e3b8e;
        color: white;
    }

    .btn-delete {
        background: #888;
        color: white;
    }
</style>

<div class="manage-container">
    <div class="manage-header">
        <h1>Manage Job</h1>
    </div>

    <?php
    $stmt = $conn->prepare("SELECT * FROM job WHERE user_id = ? ORDER BY date_posted DESC");
    $stmt->bind_param("i", $logged_in_user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()):
    ?>
        <div class="job-card" id="job-card-<?php echo $row['job_id']; ?>">
            <div class="action-btns">
                <img src="../../assets/images/delete.png" onclick="openDeleteModal(<?php echo $row['job_id']; ?>)">
                <img src="../../assets/images/edit.png" onclick="location.href='edit_job.php?id=<?php echo $row['job_id']; ?>'">
            </div>

            <?php if ($row['status'] == 'active'): ?>
                <div class="status-badge status-active"><span></span>Live & Posted</div>
            <?php elseif ($row['status'] == 'rejected'): ?>
                <div class="status-badge status-rejected">Rejected</div>
            <?php else: ?>
                <div class="status-badge status-pending">Pending</div>
            <?php endif; ?>

            <div class="job-title">
                <?php echo htmlspecialchars($row['job_title']); ?>
                <span class="type-label"><?php echo htmlspecialchars($row['type_of_work']); ?></span>
            </div>

            <div style="color: #0c4a86; font-weight: bold; margin-top: 5px;"><?php echo htmlspecialchars($row['location']); ?></div>
            <div style="color: #777; font-size: 14px; margin-bottom: 5px;">Posted on <?php echo date('F d, Y', strtotime($row['date_posted'])); ?></div>
            <div style="font-weight: bold; font-size: 18px;">₱<?php echo number_format($row['salary'], 2); ?></div>

            <p style="color: #555; line-height: 1.6; margin: 15px 0;">
                <?php echo htmlspecialchars(substr($row['job_overview'], 0, 250)); ?>...
                <a href="job_details.php?id=<?php echo $row['job_id']; ?>" style="color: #0c4a86; text-decoration: none; font-weight: bold;">See More</a>
            </p>

            <div class="skills-flex">
                <?php
                $skill_list = explode('|', $row['skills_requirements']);
                foreach ($skill_list as $skill) {
                    if (trim($skill)) {
                        echo '<div class="skill-box">' . htmlspecialchars(trim($skill)) . '</div>';
                    }
                }
                ?>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<div id="deleteModal" class="modal-overlay">
    <div class="modal-content">
        <img src="../../assets/images/delete.png" alt="Delete Icon">
        <h2>Delete Job Posting ?</h2>
        <p>This action is irreversible, Continue Deletion?</p>
        <div class="modal-btns">
            <button class="btn-modal btn-cancel" onclick="closeDeleteModal()">Cancel</button>
            <button class="btn-modal btn-delete" id="confirmDeleteBtn">Delete</button>
        </div>
    </div>
</div>

<script>
    let currentJobIdToDelete = null;

    function openDeleteModal(jobId) {
        currentJobIdToDelete = jobId;
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
        currentJobIdToDelete = null;
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (currentJobIdToDelete) {
            fetch('job_operations.php?action=delete_job&id=' + currentJobIdToDelete)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Remove the card visually
                        const card = document.getElementById('job-card-' + currentJobIdToDelete);
                        if (card) card.remove();
                        closeDeleteModal();
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("An error occurred.");
                });
        }
    });

    // Close modal if clicking outside the white content area
    window.onclick = function(event) {
        let modal = document.getElementById('deleteModal');
        if (event.target == modal) {
            closeDeleteModal();
        }
    }
</script>