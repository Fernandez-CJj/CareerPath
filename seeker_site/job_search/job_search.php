<?php
include('../header/jobSearchHeader.html');
$sql = "SELECT * FROM job";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $position = $_POST['search-position'] ?? '';
  $location = $_POST['search-location'] ?? '';
  $skill = $_POST['search-skills'] ?? '';
  $job_type = $_POST['job-type'] ?? '';

  if (!empty($position) && !empty($location)) {
    $sql = "SELECT * FROM job WHERE job_title LIKE '%$position%' AND location LIKE '%$location%'";
  }

  if (!empty($position)) {
    $sql = "SELECT * FROM job WHERE job_title LIKE '%$position%'";
  }

  if (!empty($location)) {
    $sql = "SELECT * FROM job WHERE location LIKE '%$location%'";
  }

  if (!empty($skill)) {
    $sql = "SELECT * FROM job WHERE skills_requirements LIKE '%$skill%'";
  }

  if (!empty($job_type)) {
    $sql = "SELECT * FROM job WHERE type_of_work LIKE '%$job_type%'";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="styles/job_search.css?v=<?php echo time(); ?>">
</head>

<body>
  <form action="" method="post">
    <div class="search-container">
      <div class="search-position-container">
        <input type="text" name="search-position" class="search-position" placeholder="Search for a job title or company">
      </div>
      <div class="search-location-container">
        <input type="text" name="search-location" class="search-location" placeholder="Search for location">
      </div>
      <div class="search-button-container">
        <input type="submit" value="FIND" class="search-button">
      </div>
    </div>
    <div class="main-content">
      <div class="body-left-section">
        <div class="job-search-filter-container">
          <div class="text">JOB SEARCH</div>
        </div>
        <div class="filter-by-skills">Filter by skill:</div>
        <input type="text" class="search-skills" name="search-skills" placeholder="Search for skills">
        <div class="job-type-container">
          <label class="custom-radio">
            <input type="radio" name="job-type" value="any">
            <span class="custom-radio-box"></span>
            Any
          </label><br>
          <label class="custom-radio">
            <input type="radio" name="job-type" value="gig">
            <span class="custom-radio-box"></span>
            GIG
          </label><br>
          <label class="custom-radio">
            <input type="radio" name="job-type" value="part-time">
            <span class="custom-radio-box"></span>
            PART-TIME
          </label><br>
          <label class="custom-radio">
            <input type="radio" name="job-type" value="full-time">
            <span class="custom-radio-box"></span>
            FULL-TIME
          </label>
        </div>
        <button class="result-button">RESULT</button>

      </div>
  </form>
  <div class='body-right-section'>
    <?php
    include('../../config.php');
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
      $job_id = $row['job_id'];
      $date = date('F d, Y', strtotime($row['date_posted']));
      echo "<div class='job-container' onclick=\"window.location.href='view_job.php?id={$job_id}'\">
    <div class='job-position-type-container'>
      <div class='job-position'>{$row['job_title']}</div>
      <button class='job-type'>{$row['type_of_work']}</button>
    </div>
    <div class='location'>{$row['location']}</div>
    <div class='employer-details-container'>
      <div class='employer-name'>{$row['contact_person']} -</div>
      <div class='posted-on'>posted on $date</div>
    </div>
    <div class='salary'>₱{$row['salary']}/month</div>
    <div class='description'>{$row['job_overview']}</div>
    <div class='skills-container'>";
      $skills = explode('|', $row['skills_requirements']);
      foreach ($skills as $skill) {
        $skill = trim($skill);
        if (!empty($skill)) {
          echo "<button class='skill'>" . htmlspecialchars($skill) . "</button>";
        }
      }
      echo "</div>
      </div>";
    }
    ?>
  </div>
  </div>
</body>

</html>