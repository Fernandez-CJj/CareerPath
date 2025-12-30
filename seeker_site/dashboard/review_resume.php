<?php
session_start();
include('../header/dashboardHeader.html');
include('../../config.php');
$seeker_id = $_SESSION['seeker_id'];
$resume_id = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="styles/review_resume.css?v=<?php echo time(); ?>">
</head>

<body>
  <div class="review-resume-container">
    <?php
    $sql = "SELECT * FROM resumes WHERE id=$resume_id AND seeker_id=$seeker_id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
      echo "  <div class='details-container'>
      <div class='review-resume-left-section'>
        <div class='title'>PERSONAL DETAILS</div>
        <div>Name: <span class='values'>{$row['name']}</span></div>
        <div>Gmail: <span class='values'>{$row['email']}</span></div>
        <div>Contact Number: <span class='values'>{$row['contact_number']}</span></div>
        <div>Address: <span class='values'>{$row['address']}</span></div>
      </div>
      <div class='review-resume-right-section' onclick=\"window.location.href='personal_details.php?id=$resume_id'\">Edit ></div>
    </div>
    
    <div class='details-container'>
      <div class='review-resume-left-section'>
        <div class='title'>EDUCATION</div>
        <div>Course 1: <span class='values'>{$row['course1']}</span></div>
        <div>Institution Name 1: <span class='values'>{$row['institution_name1']}</span></div>
        <div>Graduation Year 1: <span class='values'>{$row['graduation_year1']}</span></div>
        <div>Course 2: <span class='values'>{$row['course2']}</span></div>
        <div>Institution Name 2: <span class='values'>{$row['institution_name2']}</span></div>
        <div>Graduation Year 2: <span class='values'>{$row['graduation_year2']}</span></div>
      </div>
      <div class='review-resume-right-section' onclick=\"window.location.href='education_details.php?id=$resume_id'\">Edit ></div>
    </div>
    
    <div class='details-container'>
      <div class='review-resume-left-section'>
        <div class='title'>EXPERIENCE</div>
        <div> Position 1: <span class='values'>{$row['job_title1']}</span></div>
        <div> Company Name 1: <span class='values'>{$row['company1']}</span></div>
        <div> Started Year 1: <span class='values'>{$row['start_year1']}</span></div>
        <div> End Year 1: <span class='values'>{$row['end_year1']}</span></div>
        <div> Job Overview 1: <span class='values'>{$row['job_overview1']}</span></div>
        <div> Key Responsibilities 1: <span class='values'>{$row['key_responsibilities1']}</span></div>
        <div> Achievements 1: <span class='values'>{$row['achievements1']}</span></div>
        <div> Position 2: <span class='values'>{$row['job_title2']}</span></div>
        <div> Company Name 2: <span class='values'>{$row['company2']}</span></div>
        <div> Started Year 2: <span class='values'>{$row['start_year2']}</span></div>
        <div> End Year 2: <span class='values'>{$row['end_year2']}</span></div>
        <div> Job Overview 2: <span class='values'>{$row['job_overview2']}</span></div>
        <div> Key Responsibilities 2: <span class='values'>{$row['key_responsibilities2']}</span></div>
        <div> Achievements 2: <span class='values'>{$row['achievements2']}</span></div>
      </div>
      <div class='review-resume-right-section' onclick=\"window.location.href='experience_details.php?id=$resume_id'\">Edit ></div>
    </div>
    
    <div class='details-container'>
      <div class='review-resume-left-section'>
        <div class='title'>SKILLS & INTERESTS</div>
        <div>Skills: <span class='values'>{$row['skills']}</span></div>
        <div>Interests: <span class='values'>{$row['interests']}</span></div>
      </div>
      <div class='review-resume-right-section' onclick=\"window.location.href='skills_interests.php?id=$resume_id'\">Edit ></div>
    </div>
    
     
    <div class='details-container'>
      <div class='review-resume-left-section'>
        <div class='title'>SUMMARY</div>
        <div>Summary: <span class='values'>{$row['summary']}</span></div>
      </div>
      <div class='review-resume-right-section' onclick=\"window.location.href='summary_details.php?id=$resume_id'\">Edit ></div>
    </div>

    <div class='details-container'>
      <div class='review-resume-left-section'>
        <div class='title'>REFERENCE</div>
        <div>Reference Type: <span class='values'>{$row['reference_type']}</span></div>
        <div>Reference Name: <span class='values'>{$row['reference_name']}</span></div>
        <div>Reference Position: <span class='values'>{$row['reference_position']}</span></div>
        <div>Reference Company: <span class='values'>{$row['reference_company']}</span></div>
        <div>Reference Contact: <span class='values'>{$row['reference_contact']}</span></div>
      </div>
      <div class='review-resume-right-section' onclick=\"window.location.href='reference_details.php?id=$resume_id'\">Edit ></div>
    </div>  
    ";
    }
    ?>
  </div>

  <div class="generate-resume-button">
    <button class="gr-button" onclick="window.location.href='generate_resume.php?id=<?php echo $resume_id; ?>'">GENERATE RESUME</button>
  </div>

  <div class="spacing"></div>
</body>

</html>