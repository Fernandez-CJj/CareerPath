<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../header_employer/ManageJob.html"; 
include "../../config.php"; 

// 2. Check if the user is actually logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page or show an error
    echo "<script>alert('Please log in to manage your jobs.'); window.location.href='../login.php';</script>";
    exit();
}

$logged_in_user_id = $_SESSION['user_id'];
?>

<style>
:root { --primary-blue: #0c4a86; --bg-gray: #f4f7f6; }
body { background-color: var(--bg-gray); font-family: Arial, sans-serif; }
.manage-container { max-width: 1000px; margin: 40px auto; }

/* Header Styling */
.manage-header { background: white; padding: 15px 40px; border-radius: 10px; margin-bottom: 30px; border: 1px solid #eee; text-align: center; }
.manage-header h1 { color: var(--primary-blue); margin: 0; font-size: 28px; }

/* Job Card Styling */
.job-card { background: white; border-radius: 15px; padding: 30px; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); position: relative; }
.badge-type { background-color: #d1e3f8; color: var(--primary-blue); padding: 4px 15px; border-radius: 5px; font-size: 13px; margin-left: 15px; border: 1px solid #accbee; vertical-align: middle; }
.skill-tag { background-color: var(--primary-blue); color: white; padding: 8px 20px; border-radius: 5px; font-size: 14px; margin-right: 10px; }

/* Action Buttons (Larger Size) */
.action-icon {
    width: 75px; 
    height: auto;
    cursor: pointer;
    transition: transform 0.2s ease, opacity 0.2s ease;
    padding: 5px;
}
.action-icon:hover {
    transform: scale(1.1);
    opacity: 0.8;
}

/* Modal Styling */
.modal { position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; }
.modal-box { background: white; padding: 40px; border-radius: 20px; text-align: center; width: 450px; }
.btn-cancel { background: #3f4a91; color: white; padding: 12px 35px; border-radius: 8px; border: none; cursor: pointer; font-weight: bold; }
.btn-delete-confirm { background: #888; color: white; padding: 12px 35px; border-radius: 8px; border: none; cursor: pointer; font-weight: bold; }
</style>

<div class="manage-container">
    <div class="manage-header">
        <h1>Manage Job</h1>
    </div>

    <?php
    // Fetch jobs along with employer name
  $stmt = $conn->prepare("SELECT job.*, users.username AS employer_name 
                            FROM job 
                            LEFT JOIN users ON job.user_id = users.id 
                            WHERE job.user_id = ? 
                            ORDER BY date_posted DESC");
    $stmt->bind_param("i", $logged_in_user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0):
        while($row = $result->fetch_assoc()):
    ?>
    <div class="job-card">
        <div style="display:flex; justify-content:space-between; align-items: flex-start;">
            <div>
                <h2 style="margin:0; font-size: 22px;">
                    <a href="job_details.php?id=<?php echo $row['job_id']; ?>" style="text-decoration: none; color: inherit;">
                        <?php echo htmlspecialchars($row['job_title']); ?> 
                    </a>
                    <span class="badge-type"><?php echo ucfirst($row['type_of_work']); ?></span>
                </h2>

                <div style="color: #0c4a86; font-weight: 600; margin-top: 3px;">
                    <i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($row['location']); ?>
                </div>

                <div style="color: #777; margin-top:5px;">
                    <?php echo htmlspecialchars($row['employer_name'] ?? 'Employer'); ?> • Posted on <?php echo date('F d, Y', strtotime($row['date_posted'])); ?>
                </div>

                <div style="font-weight: bold; margin-top:5px;">₱<?php echo number_format($row['salary'], 2); ?></div>
            </div>

            <div style="display: flex; gap: 15px;">
                <img src="../../assets/images/delete.png" 
                     class="action-icon" 
                     onclick="confirmDel(<?php echo $row['job_id']; ?>)" 
                     alt="Delete"
                     onerror="this.src='https://cdn-icons-png.flaticon.com/512/3096/3096673.png'">
                     
                <img src="../../assets/images/edit.png" 
                     class="action-icon" 
                     onclick="location.href='edit_job.php?id=<?php echo $row['job_id']; ?>'" 
                     alt="Edit"
                     onerror="this.src='https://cdn-icons-png.flaticon.com/512/1159/1159633.png'">
            </div>
        </div>

        <p style="color: #555; line-height: 1.6; margin: 20px 0;">
            <?php echo substr(htmlspecialchars($row['job_overview']), 0, 250); ?>... 
            <a href="job_details.php?id=<?php echo $row['job_id']; ?>" style="color: var(--primary-blue); font-weight: bold; text-decoration: none;">See More</a>
        </p>

        <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 20px;">
            <?php 
            $skillsArr = explode(',', $row['skills_requirements']);
            foreach($skillsArr as $s) {
                if(trim($s)) echo "<span class='skill-tag'>".htmlspecialchars(trim($s))."</span>"; 
            }
            ?>
        </div>
    </div>
    <?php 
        endwhile; 
    else:
        echo "<p style='text-align:center; color:#777;'>No job postings found.</p>";
    endif;
    ?>
</div>

<div class="modal" id="delModal">
    <div class="modal-box">
        <img src="../../assets/images/delete.png" style="width: 80px; margin-bottom: 20px;" onerror="this.src='https://cdn-icons-png.flaticon.com/512/3096/3096673.png'">
        <h2 style="color: var(--primary-blue); margin-bottom: 10px;">Delete Job Posting?</h2>
        <p style="color: #777; margin-bottom: 30px;">This action is irreversible. Continue Deletion?</p>
        <div style="display: flex; justify-content: space-around;">
            <button class="btn-cancel" onclick="document.getElementById('delModal').style.display='none'">Cancel</button>
            <button class="btn-delete-confirm" id="finalDel">Delete</button>
        </div>
    </div>
</div>

<script>
let deleteId = null;

function confirmDel(id) { 
    deleteId = id; 
    document.getElementById('delModal').style.display = 'flex'; 
}

document.getElementById('finalDel').onclick = () => {
    // We call the script with the action and the ID
    fetch(`job_operations.php?action=delete_job&id=${deleteId}`)
    .then(res => res.text()) // Get text first to check for PHP errors
    .then(text => {
        try {
            const data = JSON.parse(text);
            if(data.status === 'success') {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        } catch (e) {
            console.error("Server Error Response:", text);
            alert("Database Error: Check console for details.");
        }
    })
    .catch(err => {
        console.error('Fetch Error:', err);
        alert('Could not connect to the server.');
    });
}

window.onclick = function(event) {
    let modal = document.getElementById('delModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>