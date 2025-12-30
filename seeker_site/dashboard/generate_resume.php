<?php
session_start();
include('../../config.php');

$seeker_id = $_SESSION['seeker_id'] ?? 0;
$resume_id = $_GET['id'] ?? 0;

$resume = null;
if ($resume_id && $seeker_id) {
  $sql = "SELECT * FROM resumes WHERE id=$resume_id AND seeker_id=$seeker_id";
  $result = mysqli_query($conn, $sql);
  $resume = mysqli_fetch_assoc($result);
}

if (!$resume) {
  die('Resume not found.');
}

// Map values from DB to template variables (reuse existing variable names for display)
$enhancedName = $resume['name'] ?? '';
$email = $resume['email'] ?? '';
$contact_number = $resume['contact_number'] ?? '';
$enhancedAddress = $resume['address'] ?? '';
$enhancedSummary = $resume['summary'] ?? '';

$enhancedCourse1 = $resume['course1'] ?? '';
$enhancedInstitution1 = $resume['institution_name1'] ?? '';
$convertedGraduation1 = $resume['graduation_year1'] ?? '';
$enhancedCourse2 = $resume['course2'] ?? '';
$enhancedInstitution2 = $resume['institution_name2'] ?? '';
$convertedGraduation2 = $resume['graduation_year2'] ?? '';

$enhancedPosition1 = $resume['job_title1'] ?? '';
$enhancedCompany1 = $resume['company1'] ?? '';
$converted_start_date1 = $resume['start_year1'] ?? '';
$converted_end_date1 = $resume['end_year1'] ?? '';
$positionOverview1 = $resume['job_overview1'] ?? '';

$enhancedPosition2 = $resume['job_title2'] ?? '';
$enhancedCompany2 = $resume['company2'] ?? '';
$converted_start_date2 = $resume['start_year2'] ?? '';
$converted_end_date2 = $resume['end_year2'] ?? '';
$positionOverview2 = $resume['job_overview2'] ?? '';

// Pipe-separated lists to arrays
$enhancedSkills = array_filter(array_map('trim', explode('|', $resume['skills'] ?? '')));
$enhancedInterests = array_filter(array_map('trim', explode('|', $resume['interests'] ?? '')));
$enhancedKeyResponsibilities1 = array_filter(array_map('trim', explode('|', $resume['key_responsibilities1'] ?? '')));
$enhancedKeyResponsibilities2 = array_filter(array_map('trim', explode('|', $resume['key_responsibilities2'] ?? '')));
$enhancedAchievements1 = array_filter(array_map('trim', explode('|', $resume['achievements1'] ?? '')));
$enhancedAchievements2 = array_filter(array_map('trim', explode('|', $resume['achievements2'] ?? '')));

$reference_type = $resume['reference_type'] ?? '';
$enhancedReferenceName = $resume['reference_name'] ?? '';
$enhancedReferencePosition = $resume['reference_position'] ?? '';
$enhancedReferenceCompany = $resume['reference_company'] ?? '';
$reference_contact = $resume['reference_contact'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles/resumeHandler.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="styles/modern.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="styles/professional.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="styles/simple.css?v=<?php echo time(); ?>">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <title>Document</title>
</head>

<body>
  <?php include '../header/dashboardHeader.html'; ?>

  <div class="templates-container">
    <div class="template-container">
      <div class="title">Choose Your Resume Template</div>
      <div class="sub-title">
        Select one of our professionally design templates to generate your
        resume
      </div>
      <div class="templates">
        <div class="template">
          <img src="../../assets/images/modern.png" class="template-image" />
          <div class="template-title">Modern</div>
          <div class="template-description">
            an eye catching template with a colored header that highlights
            your name and details.
          </div>
          <button class="template-button" onclick="showModernTemplate()">Use Template</button>
        </div>
        <div class="template">
          <img
            src="../../assets/images/professional.png"
            class="template-image" />
          <div class="template-title">Professional</div>
          <div class="template-description">
            a polished template with clean formatting and a classic, versatile
            design.
          </div>
          <button class="template-button" onclick="showProfessionalTemplate()">Use Template</button>
        </div>
        <div class="template">
          <img src="../../assets/images/simple.png" class="template-image" />
          <div class="template-title">Simple</div>
          <div class="template-description">
            an easy-to-read template that prioritises your career history and
            education.
          </div>
          <button class="template-button" onclick="showSimpleTemplate()">Use Template</button>
        </div>
      </div>
    </div>
  </div>

  <div class="all-template-container">
    <div class="modern-resume">
      <div class="modern" id="modern">
        <div class="modern-header">
          <div class="full-name"><?php echo $enhancedName; ?></div>
          <div class="personal-details">
            <div class="email"><?php echo $email; ?></div>
            <div class="vertical-line"></div>
            <div class="contact-number"><?php echo $contact_number; ?></div>
            <div class="vertical-line"></div>
            <div class="address">
              <?php echo $enhancedAddress; ?>
            </div>
          </div>
        </div>
        <div class="main-content">
          <div class="resume-left-section">
            <div class="label">Key Skills</div>
            <div class="key-skills">
              <div class="line"></div>
              <ul>
                <?php if (!empty($enhancedSkills)): ?>
                  <?php foreach ($enhancedSkills as $skill): ?>
                    <li class="skills"><?php echo htmlspecialchars($skill); ?></li>
                  <?php endforeach; ?>
                <?php endif; ?>
              </ul>
            </div>
            <div class="label">Education</div>
            <div class="line"></div>
            <?php
            $enhancedCourses = [$enhancedCourse1];
            $enhancedInstitutions = [$enhancedInstitution1];
            $convertedGraduations = [$convertedGraduation1];
            if (!empty($enhancedCourse2) && !empty($enhancedInstitution2) && !empty($convertedGraduation2)) {
              $enhancedCourses[] = $enhancedCourse2;
              $enhancedInstitutions[] = $enhancedInstitution2;
              $convertedGraduations[] = $convertedGraduation2;
            }
            for ($i = 0; $i < count($enhancedCourses); $i++):
            ?>
              <div class="<?php echo $i === 0 ? 'education' : 'education-2'; ?>">
                <div class="course"><?php echo htmlspecialchars($enhancedCourses[$i]); ?></div>
                <div class="institution"><?php echo htmlspecialchars($enhancedInstitutions[$i]); ?></div>
                <div class="graduation-date"><?php echo htmlspecialchars($convertedGraduations[$i]); ?></div>
              </div>
            <?php endfor; ?>
          </div>
          <div class="resume-right-section">
            <div class="label">Summary </div>
            <div class="summary">
              <div class="line"></div>
              <?php echo $enhancedSummary; ?>
            </div>

            <div class="label">Career History</div>
            <div class="line"></div>
            <?php
            $positionsArr = [$enhancedPosition1];
            $companiesArr = [$enhancedCompany1];
            $startDatesArr = [$converted_start_date1];
            $endDatesArr = [$converted_end_date1];
            $overviewsArr = [$positionOverview1];
            $keyRespsArr = [$enhancedKeyResponsibilities1];
            $achievementsArr = [$enhancedAchievements1];
            if (!empty($enhancedPosition2) && !empty($enhancedCompany2) && !empty($converted_start_date2) && !empty($converted_end_date2) && !empty($positionOverview2) && !empty($enhancedKeyResponsibilities2) && !empty($enhancedAchievements2)) {
              $positionsArr[] = $enhancedPosition2;
              $companiesArr[] = $enhancedCompany2;
              $startDatesArr[] = $converted_start_date2;
              $endDatesArr[] = $converted_end_date2;
              $overviewsArr[] = $positionOverview2;
              $keyRespsArr[] = $enhancedKeyResponsibilities2;
              $achievementsArr[] = $enhancedAchievements2;
            }
            for ($i = 0; $i < count($positionsArr); $i++):
            ?>
              <div class="<?php echo $i === 0 ? 'career-history' : 'career-history-2'; ?>">
                <div class="role-company">
                  <div class="position"><?php echo htmlspecialchars($positionsArr[$i]); ?></div>
                  <div class="company">&nbsp;at <?php echo htmlspecialchars($companiesArr[$i]); ?></div>
                </div>
                <div class="career-dates">
                  <div class="start-date"><?php echo htmlspecialchars($startDatesArr[$i]); ?></div>
                  <div>&nbsp;&nbsp;-&nbsp;&nbsp;</div>
                  <div class="end-date"><?php echo htmlspecialchars($endDatesArr[$i]); ?></div>
                </div>
                <div class="overview">
                  <ul>
                    <li><?php echo htmlspecialchars($overviewsArr[$i]); ?></li>
                  </ul>
                </div>
                <div class="key-responsibilities">Key Responsibilities
                  <ul>
                    <?php foreach (array_slice($keyRespsArr[$i], 0, 3) as $resp): ?>
                      <li class="responsibility"><?php echo htmlspecialchars($resp); ?></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
                <div class="achievements">Achievements
                  <ul>
                    <?php foreach (array_slice($achievementsArr[$i], 0, 3) as $ach): ?>
                      <li class="achievement"><?php echo htmlspecialchars($ach); ?></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>
            <?php endfor; ?>
            <div class="label">Interests</div>
            <div class="interest">
              <div class="line"></div>
              <ul>
                <?php foreach (array_slice($enhancedInterests, 0, 3) as $interest): ?>
                  <li class="interest"><?php echo htmlspecialchars($interest); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <div class="reference-label">Reference</div>
            <div class="reference">
              <div class="line"></div>
              <?php if (strtolower(trim($reference_type)) === 'aur'): ?>
                <div class="reference-detail">Available Upon Request</div>
              <?php elseif (strtolower(trim($reference_type)) === 'ard'): ?>
                <div class="reference-detail"><strong>Name:</strong> <?php echo $enhancedReferenceName; ?></div>
                <div class="reference-detail"><strong>Position:</strong> <?php echo $enhancedReferencePosition; ?></div>
                <div class="reference-detail"><strong>Company:</strong> <?php echo $enhancedReferenceCompany; ?></div>
                <div class="reference-detail"><strong>Contact Number:</strong> <?php echo $reference_contact; ?></div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="download-remove-button">
        <button class="remove-button" onclick="hideTemplates()">Remove</button>
        <button class="download-button" onclick="downloadModernPDF()">Download Template</button>
      </div>
    </div>
  </div>

  <div class="pro-all-template-container">
    <div class="professional-resume">
      <div class="professional">
        <div class="professional-header">
          <div class="professional-full-name"><?php echo $enhancedName; ?></div>
          <div class="professional-personal-details">
            <div class="professional-email"><?php echo $email; ?></div>
            <div class="vertical-line"></div>
            <div class="professional-contact-number"><?php echo $contact_number; ?></div>
            <div class="vertical-line"></div>
            <div class="professional-address">
              <?php echo $enhancedAddress; ?>
            </div>
          </div>
        </div>
        <div class="professional-main-content">
          <div class="resume-left-section">
            <div class="label">Key Skills</div>
            <div class="key-skills">
              <div class="line"></div>
              <ul>
                <?php if (!empty($enhancedSkills)): ?>
                  <?php foreach ($enhancedSkills as $skill): ?>
                    <li class="skills"><?php echo htmlspecialchars($skill); ?></li>
                  <?php endforeach; ?>
                <?php endif; ?>
              </ul>
            </div>
            <div class="label">Education</div>
            <div class="line"></div>
            <?php
            $enhancedCourses = [$enhancedCourse1];
            $enhancedInstitutions = [$enhancedInstitution1];
            $convertedGraduations = [$convertedGraduation1];
            if (!empty($enhancedCourse2) && !empty($enhancedInstitution2) && !empty($convertedGraduation2)) {
              $enhancedCourses[] = $enhancedCourse2;
              $enhancedInstitutions[] = $enhancedInstitution2;
              $convertedGraduations[] = $convertedGraduation2;
            }
            for ($i = 0; $i < count($enhancedCourses); $i++):
            ?>
              <div class="<?php echo $i === 0 ? 'education' : 'education-2'; ?>">
                <div class="course"><?php echo htmlspecialchars($enhancedCourses[$i]); ?></div>
                <div class="institution"><?php echo htmlspecialchars($enhancedInstitutions[$i]); ?></div>
                <div class="graduation-date"><?php echo htmlspecialchars($convertedGraduations[$i]); ?></div>
              </div>
            <?php endfor; ?>
          </div>

          <div class="resume-right-section">
            <div class="label">Summary </div>
            <div class="summary">
              <div class="line"></div>
              <?php echo $enhancedSummary; ?>
            </div>

            <div class="label">Career History</div>
            <div class="line"></div>
            <?php
            $positionsArr = [$enhancedPosition1];
            $companiesArr = [$enhancedCompany1];
            $startDatesArr = [$converted_start_date1];
            $endDatesArr = [$converted_end_date1];
            $overviewsArr = [$positionOverview1];
            $keyRespsArr = [$enhancedKeyResponsibilities1];
            $achievementsArr = [$enhancedAchievements1];
            if (!empty($enhancedPosition2) && !empty($enhancedCompany2) && !empty($converted_start_date2) && !empty($converted_end_date2) && !empty($positionOverview2) && !empty($enhancedKeyResponsibilities2) && !empty($enhancedAchievements2)) {
              $positionsArr[] = $enhancedPosition2;
              $companiesArr[] = $enhancedCompany2;
              $startDatesArr[] = $converted_start_date2;
              $endDatesArr[] = $converted_end_date2;
              $overviewsArr[] = $positionOverview2;
              $keyRespsArr[] = $enhancedKeyResponsibilities2;
              $achievementsArr[] = $enhancedAchievements2;
            }
            for ($i = 0; $i < count($positionsArr); $i++):
            ?>
              <div class="<?php echo $i === 0 ? 'career-history' : 'career-history-2'; ?>">
                <div class="role-company">
                  <div class="position"><?php echo htmlspecialchars($positionsArr[$i]); ?></div>
                  <div class="company">&nbsp;at <?php echo htmlspecialchars($companiesArr[$i]); ?></div>
                </div>
                <div class="career-dates">
                  <div class="start-date"><?php echo htmlspecialchars($startDatesArr[$i]); ?></div>
                  <div>&nbsp;&nbsp;-&nbsp;&nbsp;</div>
                  <div class="end-date"><?php echo htmlspecialchars($endDatesArr[$i]); ?></div>
                </div>
                <div class="overview">
                  <ul>
                    <li><?php echo htmlspecialchars($overviewsArr[$i]); ?></li>
                  </ul>
                </div>
                <div class="key-responsibilities">Key Responsibilities
                  <ul>
                    <?php foreach (array_slice($keyRespsArr[$i], 0, 3) as $resp): ?>
                      <li class="responsibility"><?php echo htmlspecialchars($resp); ?></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
                <div class="achievements">Achievements
                  <ul>
                    <?php foreach (array_slice($achievementsArr[$i], 0, 3) as $ach): ?>
                      <li class="achievement"><?php echo htmlspecialchars($ach); ?></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>
            <?php endfor; ?>
            <div class="label">Interests</div>
            <div class="interest">
              <div class="line"></div>
              <ul>
                <?php foreach (array_slice($enhancedInterests, 0, 3) as $interest): ?>
                  <li class="interest"><?php echo htmlspecialchars($interest); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <div class="reference-label">Reference</div>
            <div class="reference">
              <div class="line"></div>
              <?php if (strtolower(trim($reference_type)) === 'aur'): ?>
                <div class="reference-detail">Available Upon Request</div>
              <?php elseif (strtolower(trim($reference_type)) === 'ard'): ?>
                <div class="reference-detail"><strong>Name:</strong> <?php echo $enhancedReferenceName; ?></div>
                <div class="reference-detail"><strong>Position:</strong> <?php echo $enhancedReferencePosition; ?></div>
                <div class="reference-detail"><strong>Company:</strong> <?php echo $enhancedReferenceCompany; ?></div>
                <div class="reference-detail"><strong>Contact Number:</strong> <?php echo $reference_contact; ?></div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="download-remove-button">
        <button class="remove-button" onclick="hideTemplates()">Remove</button>
        <button class="download-button" onclick="downloadProfessionalPDF()">Download Template</button>
      </div>
    </div>
  </div>

  <div class="simple-all-template-container">
    <div class="simple-resume">
      <div class="simple">
        <div class="simple-header">
          <div class="simple-full-name"><?php echo $enhancedName; ?></div>
          <div class="simple-personal-details">
            <div class="simple-email"><?php echo $email; ?></div>
            <div class="vertical-line"></div>
            <div class="simple-contact-number"><?php echo $contact_number; ?></div>
            <div class="vertical-line"></div>
            <div class="simple-address">
              <?php echo $enhancedAddress; ?>
            </div>
          </div>
        </div>
        <div class="divider"></div>
        <div class="simple-main-content">
          <div class="simple-summary simple-flex-row">
            <div class="simple-label">Summary</div>
            <div class="simple-summary-content"><?php echo $enhancedSummary ?></div>
          </div>
          <div class="simple-line"></div>
          <div class="simple-career simple-flex-row">
            <div class="simple-label">Career History</div>
            <div class="simple-career-content">
              <?php
              $positionsArr = [$enhancedPosition1];
              $companiesArr = [$enhancedCompany1];
              $startDatesArr = [$converted_start_date1];
              $endDatesArr = [$converted_end_date1];
              $overviewsArr = [$positionOverview1];
              $keyRespsArr = [$enhancedKeyResponsibilities1];
              $achievementsArr = [$enhancedAchievements1];
              if (!empty($enhancedPosition2) && !empty($enhancedCompany2) && !empty($converted_start_date2) && !empty($converted_end_date2) && !empty($positionOverview2) && !empty($enhancedKeyResponsibilities2) && !empty($enhancedAchievements2)) {
                $positionsArr[] = $enhancedPosition2;
                $companiesArr[] = $enhancedCompany2;
                $startDatesArr[] = $converted_start_date2;
                $endDatesArr[] = $converted_end_date2;
                $overviewsArr[] = $positionOverview2;
                $keyRespsArr[] = $enhancedKeyResponsibilities2;
                $achievementsArr[] = $enhancedAchievements2;
              }
              for ($i = 0; $i < count($positionsArr); $i++):
              ?>
                <div class="<?php echo $i === 0 ? 'career-history' : 'simple-career-history-2'; ?>">
                  <div class="role-company">
                    <div class="position"><?php echo htmlspecialchars($positionsArr[$i]); ?></div>
                    <div class="company">&nbsp;at <?php echo htmlspecialchars($companiesArr[$i]); ?></div>
                  </div>
                  <div class="career-dates">
                    <div class="start-date"><?php echo htmlspecialchars($startDatesArr[$i]); ?></div>
                    <div>&nbsp;&nbsp;-&nbsp;&nbsp;</div>
                    <div class="end-date"><?php echo htmlspecialchars($endDatesArr[$i]); ?></div>
                  </div>
                  <div class="overview">
                    <ul>
                      <li><?php echo htmlspecialchars($overviewsArr[$i]); ?></li>
                    </ul>
                  </div>
                  <div class="key-responsibilities">Key Responsibilities
                    <ul>
                      <?php foreach (array_slice($keyRespsArr[$i], 0, 3) as $resp): ?>
                        <li class="responsibility"><?php echo htmlspecialchars($resp); ?></li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                  <div class="achievements">Achievements
                    <ul>
                      <?php foreach (array_slice($achievementsArr[$i], 0, 3) as $ach): ?>
                        <li class="achievement"><?php echo htmlspecialchars($ach); ?></li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
              <?php endfor; ?>
            </div>
          </div>
          <div class="simple-line"></div>
          <div class="simple-education ">
            <div class="simple-label">Education</div>
            <div class="simple-education-content">
              <?php
              $enhancedCourses = [$enhancedCourse1];
              $enhancedInstitutions = [$enhancedInstitution1];
              $convertedGraduations = [$convertedGraduation1];
              if (!empty($enhancedCourse2) && !empty($enhancedInstitution2) && !empty($convertedGraduation2)) {
                $enhancedCourses[] = $enhancedCourse2;
                $enhancedInstitutions[] = $enhancedInstitution2;
                $convertedGraduations[] = $convertedGraduation2;
              }
              for ($i = 0; $i < count($enhancedCourses); $i++):
              ?>
                <div class="<?php echo $i === 0 ? 'education' : 'education-2'; ?>">
                  <div class="course"><?php echo htmlspecialchars($enhancedCourses[$i]); ?></div>
                  <div class="institution"><?php echo htmlspecialchars($enhancedInstitutions[$i]); ?></div>
                  <div class="graduation-date"><?php echo htmlspecialchars($convertedGraduations[$i]); ?></div>
                </div>
              <?php endfor; ?>
            </div>
          </div>
          <div class="simple-line"></div>
          <div class="simple-skills">
            <div class="simple-label">Key Skills</div>
            <div class="simple-skills-content">
              <?php if (!empty($enhancedSkills)): ?>
                <?php echo htmlspecialchars(implode(', ', $enhancedSkills)); ?>
              <?php endif; ?>
            </div>
          </div>
          <div class="simple-line"></div>
          <div class="simple-reference">
            <div class="simple-label">References</div>
            <div class="simple-references-content">
              <?php if (strtolower(trim($reference_type)) === 'aur'): ?>
                <div class="reference-detail">Available Upon Request</div>
              <?php elseif (strtolower(trim($reference_type)) === 'ard'): ?>
                <div class="reference-detail"><strong>Name:</strong> <?php echo $enhancedReferenceName; ?></div>
                <div class="reference-detail"><strong>Position:</strong> <?php echo $enhancedReferencePosition; ?></div>
                <div class="reference-detail"><strong>Company:</strong> <?php echo $enhancedReferenceCompany; ?></div>
                <div class="reference-detail"><strong>Contact Number:</strong> <?php echo $reference_contact; ?></div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="download-remove-button">
        <button class="remove-button" onclick="hideTemplates()">Remove</button>
        <button class="download-button" onclick="downloadSimplePDF()">Download Template</button>
      </div>
    </div>
  </div>
  <script src="scripts/template.js?v=<?php echo time(); ?>"></script>


</body>

</html>