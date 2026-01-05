<?php
include('../header/jobSearchHeader.html');
include('../../config.php');

// Pagination setup
$perPage = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $perPage;

$conditions = ["status='active'"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $position = mysqli_real_escape_string($conn, $_POST['search-position'] ?? '');
  $location = mysqli_real_escape_string($conn, $_POST['search-location'] ?? '');
  $skill = mysqli_real_escape_string($conn, $_POST['search-skills'] ?? '');
  $job_type = mysqli_real_escape_string($conn, $_POST['job-type'] ?? '');

  if (!empty($position)) {
    $conditions[] = "job_title LIKE '%$position%'";
  }
  if (!empty($location)) {
    $conditions[] = "location LIKE '%$location%'";
  }
  if (!empty($skill)) {
    $conditions[] = "skills_requirements LIKE '%$skill%'";
  }
  if (!empty($job_type) && $job_type != 'any') {
    $conditions[] = "type_of_work LIKE '%$job_type%'";
  }
}
$where = implode(' AND ', $conditions);

// Get total count for pagination
$countSql = "SELECT COUNT(*) as total FROM job WHERE $where";
$countResult = mysqli_query($conn, $countSql);
$totalRows = $countResult ? (int)mysqli_fetch_assoc($countResult)['total'] : 0;

// Main query with LIMIT/OFFSET
$sql = "SELECT * FROM job WHERE $where ORDER BY date_posted DESC LIMIT $perPage OFFSET $offset";
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
    $result = mysqli_query($conn, $sql);
    $shownCount = 0;
    $jobs = [];
    while ($result && $row = mysqli_fetch_assoc($result)) {
      $jobs[] = $row;
    }
    $shownCount = count($jobs);
    echo "<div style='margin-bottom:20px;font-weight:bold;'>Showing $shownCount out of $totalRows jobs</div>";
    foreach ($jobs as $row) {
      $job_id = $row['job_id'];
      $date = date('F d, Y', strtotime($row['date_posted']));
      echo "<div class='job-container' onclick=\"window.location.href='view_job.php?id={$job_id}'\">";
      echo "<div class='job-position-type-container'>";
      echo "<div class='job-position'>{$row['job_title']}</div>";
      echo "<button class='job-type'>{$row['type_of_work']}</button>";
      echo "</div>";
      echo "<div class='location'>{$row['location']}</div>";
      echo "<div class='employer-details-container'>";
      echo "<div class='employer-name'>{$row['contact_person']} -</div>";
      echo "<div class='posted-on'>posted on $date</div>";
      echo "</div>";
      echo "<div class='salary'>₱{$row['salary']}/month</div>";
      echo "<div class='description'>{$row['job_overview']}</div>";
      echo "<div class='skills-container'>";
      $skills = explode('|', $row['skills_requirements']);
      foreach ($skills as $skill) {
        $skill = trim($skill);
        if (!empty($skill)) {
          echo "<button class='skill'>" . htmlspecialchars($skill) . "</button>";
        }
      }
      echo "</div></div>";
    }
    // Pagination controls
    $nextPage = $page + 1;
    $hasNext = ($offset + $perPage) < $totalRows;
    echo "<div class='pagination'>";
    if ($page > 1) {
      $prevPage = $page - 1;
      echo "<a href='?page=$prevPage' class='page-link'>Previous</a>";
    }
    if ($hasNext) {
      echo "<a href='?page=$nextPage' class='page-link'>Next</a>";
    }
    echo "</div>";
    ?>
  </div>
  </div>
</body>

</html>