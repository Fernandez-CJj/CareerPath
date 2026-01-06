<?php
include "../../config.php";
include "../header_admin/header_admin.html";

$sql = "SELECT * FROM job WHERE status = 'pending' ORDER BY date_posted DESC";
$res = mysqli_query($conn, $sql);
?>

<style>
    :root {
        --primary-blue: #0c4a86;
        --bg-gray: #f4f7f6;
        --text-dark: #333;
    }

    body {
        background-color: var(--bg-gray);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
    }

    .admin-body {
        padding: 40px;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 80vh;
    }

    .approval-card {
        display: flex;
        background: white;
        border-radius: 15px;
        width: 100%;
        max-width: 1000px;
        margin-bottom: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .info-section {
        flex: 1;
        padding: 30px;
        border-right: 1px solid #f0f0f0;
    }

    .button-section {
        width: 220px;
        display: flex;
        flex-direction: column;
        background: #fafafa;
    }

    .job-title {
        font-size: 22px;
        font-weight: bold;
        color: var(--text-dark);
        margin: 0;
    }

    .badge {
        background: #d1e3f8;
        color: var(--primary-blue);
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .admin-btn {
        flex: 1;
        border: none;
        background: transparent;
        cursor: pointer;
        font-weight: bold;
        font-size: 15px;
        border-bottom: 1px solid #eee;
        transition: 0.3s;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-accept {
        color: #28a745;
    }

    .btn-reject {
        color: #dc3545;
    }

    .btn-details {
        color: var(--primary-blue);
    }

    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        z-index: 3000;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: white;
        padding: 50px;
        border-radius: 25px;
        width: 480px;
        text-align: center;
    }

    .modal-content img {
        width: 100px;
        margin-bottom: 25px;
    }

    .m-btn {
        padding: 14px 40px;
        border-radius: 10px;
        border: none;
        font-weight: bold;
        cursor: pointer;
        min-width: 140px;
    }

    .m-cancel {
        background: #2e3b8e;
        color: white;
    }

    .m-confirm {
        background: #888;
        color: white;
    }

    .m-confirm.accept-theme {
        background: #22c55e;
    }

    /* Style for empty state */
    .empty-message {
        padding: 50px;
        text-align: center;
        color: #666;
        font-size: 18px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        width: 100%;
        max-width: 1000px;
    }
</style>

<div class="admin-body">
    <?php if (mysqli_num_rows($res) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($res)): ?>
            <div class="approval-card" id="job-<?php echo $row['job_id']; ?>">
                <div class="info-section">
                    <div class="job-header" style="display:flex; align-items:center; gap:10px;">
                        <h2 class="job-title"><?php echo htmlspecialchars($row['job_title']); ?></h2>
                        <span class="badge"><?php echo htmlspecialchars($row['type_of_work']); ?></span>
                    </div>

                    <div style="color: #0c4a86; font-weight: bold; margin-top: 5px;"><?php echo htmlspecialchars($row['location']); ?></div>

                    <div style="font-size: 19px; font-weight: bold; margin: 12px 0;">₱<?php echo number_format($row['salary'], 2); ?></div>
                    <p style="color: #666;"><?php echo htmlspecialchars(substr($row['job_overview'], 0, 150)); ?>...</p>

                    <div class="skills-flex" style="display: flex; flex-wrap: wrap; gap: 12px; margin-top: 20px;">
                        <?php
                        $skill_list = explode('|', $row['skills_requirements']);
                        foreach ($skill_list as $skill) {
                            if (trim($skill)) {
                                echo '<div class="skill-box" style="background-color: #0c4a86; color: white; padding: 8px 22px; border-radius: 6px; font-size: 14px; font-weight: 500;">' . htmlspecialchars(trim($skill)) . '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="button-section">
                    <button class="admin-btn btn-accept" onclick="openDecisionModal(<?php echo $row['job_id']; ?>, 'active')">Accept</button>
                    <button class="admin-btn btn-reject" onclick="openDecisionModal(<?php echo $row['job_id']; ?>, 'rejected')">Reject</button>
                    <a href="view_job_details.php?id=<?php echo $row['job_id']; ?>" class="admin-btn btn-details">View Full Details</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="empty-message">
            <p>No pending job approvals at the moment.</p>
        </div>
    <?php endif; ?>
</div>

<div id="decisionModal" class="modal-overlay">
    <div class="modal-content">
        <h2 id="modalTitle">Confirm Action</h2>
        <p id="modalText">Continue?</p>
        <div class="modal-btns">
            <button class="m-btn m-cancel" onclick="closeDecisionModal()">Cancel</button>
            <button class="m-btn m-confirm" id="confirmBtn">Confirm</button>
        </div>
    </div>
</div>

<script>
    let targetJobId = null;
    let targetStatus = null;

    function openDecisionModal(id, status) {
        targetJobId = id;
        targetStatus = status;
        const btn = document.getElementById('confirmBtn');

        if (status === 'active') {
            document.getElementById('modalTitle').innerText = "Approve Job Posting?";
            btn.className = "m-btn m-confirm accept-theme";
        } else {
            document.getElementById('modalTitle').innerText = "Reject Job Posting?";
            btn.className = "m-btn m-confirm";
        }
        document.getElementById('decisionModal').style.display = 'flex';
    }

    function closeDecisionModal() {
        document.getElementById('decisionModal').style.display = 'none';
    }

    document.getElementById('confirmBtn').addEventListener('click', function() {
        let fd = new FormData();
        fd.append('job_id', targetJobId);
        fd.append('status', targetStatus);

        fetch('process_approval.php', {
                method: 'POST',
                body: fd
            })
            .then(r => r.json()).then(res => {
                if (res.status === 'success') {
                    const card = document.getElementById('job-' + targetJobId);
                    if (card) card.remove();

                    // Check if any cards are left, if not, reload to show empty message
                    const remainingCards = document.getElementsByClassName('approval-card');
                    if (remainingCards.length === 0) {
                        location.reload();
                    }

                    closeDecisionModal();
                }
            });
    });
</script>