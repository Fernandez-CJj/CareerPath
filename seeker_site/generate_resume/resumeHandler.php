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
  <?php include '../header/resumegen.html'; ?>

  <?php
  require_once __DIR__ . '/functions/date_helpers.php';
  if ($_SERVER['REQUEST_METHOD'] == "POST") {

    //PERSONAL INFORMATION
    $full_name = $_POST['full_name'];
    $email =  strtolower($_POST['email']);
    $contact_number = $_POST['contact_number'];
    $street = $_POST['street'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $address = "$street, $barangay, $city, $province";
    // Simple prompt (validation removed for learning)
    $nameContent = "Fix capitalization for the name. Return just the corrected name labeled Name: $full_name";
    $addressContent = "Fix capitalization for the address only. Return just the corrected address labeled Address: $address";

    //EDUCATION INFORMATION
    $courses = $_POST['course'];
    $firstCourse = $courses[0];
    $secondCourse = $courses[1] ?? "";
    $firstCourseContent = "Expand any course abbreviation or acronym to its full meaning (e.g., 'BSIT' to 'Bachelor of Science in Information Technology'). Fix capitalization. Return as: Course 1: <expanded course>. Course 1: $firstCourse";
    $secondCourseContent = "Expand any course abbreviation or acronym to its full meaning (e.g., 'BSIT' to 'Bachelor of Science in Information Technology'). Fix capitalization. Return as: Course 2: <expanded course>. Course 2: $secondCourse";
    $institutions = $_POST['institution'];
    $firstInstitution = $institutions[0];
    $secondInstitution = $institutions[1] ?? "";
    $firstInstitutionContent = "Fix capitalization for the institution. Return just the corrected institution labeled First Institution: $firstInstitution";
    $secondInstitutionContent = "Fix capitalization for the institution. Return just the corrected institution labeled Second Institution: $secondInstitution";

    $graduations = $_POST['graduation'];
    $firstGraduation = $graduations[0];
    $secondGraduation = $graduations[1] ?? "";

    // Use helper from separate file to convert to "Month Year" (e.g. "August 2027")
    $convertedGraduation1 = convertToMonthYear($firstGraduation);
    $convertedGraduation2 = convertToMonthYear($secondGraduation);


    //CAREER INFORMATION
    $positions = $_POST['position'];
    $position1 = $positions[0];
    $position2 = $positions[1] ?? '';
    $position1Content = "Correct capitalization and rewrite as a concise, professional job title. Return only the corrected title labeled Position 1: <title>. Position 1: $position1";
    $position2Content = "Correct capitalization and rewrite as a concise, professional job title. Return only the corrected title labeled Position 2: <title>. Position 2: $position2";
    $companies = $_POST['company_name'];
    $company1 = $companies[0];
    $company2 = $companies[1] ?? '';
    $company1Content = "Fix capitalization for the company name. Return only the corrected company name labeled Company 1: <company>. Company 1: $company1";
    $company2Content = "Fix capitalization for the company name. Return only the corrected company name labeled Company 2: <company>. Company 2: $company2";
    $start_dates = $_POST['start_date'];
    $start_date1 = $start_dates[0];
    $start_date2 = $start_dates[1] ?? '';
    $converted_start_date1 = convertToMonthYear($start_date1);
    $converted_start_date2 = convertToMonthYear($start_date2);
    $end_dates = $_POST['end_date'];
    $end_date1 = $end_dates[0];
    $end_date2 = $end_dates[1] ?? '';
    $converted_end_date1 = convertToMonthYear($end_date1);
    $converted_end_date2 = convertToMonthYear($end_date2);
    $key_responsibilities = $_POST['key_responsibilities'];
    $keyResponsibility1 = $key_responsibilities[0];
    $keyResponsibility2 = $key_responsibilities[1] ?? '';
    // Split by comma and 'and', trim, and filter empty
    function split_and_clean($str)
    {
      $parts = preg_split('/,|\band\b/i', $str);
      return array_values(array_filter(array_map('trim', $parts), function ($v) {
        return $v !== '';
      }));
    }
    $keyResp1Parts = split_and_clean($keyResponsibility1);
    $keyResp2Parts = split_and_clean($keyResponsibility2);
    $keyResponsibilityContents = [];
    foreach ($keyResp1Parts as $i => $resp) {
      $keyResponsibilityContents[] = "Enhance this responsibility for a resume. Make it concise, action-oriented, and impactful. Return only the improved responsibility labeled Key Responsibility 1." . ($i + 1) . ": <responsibility>. Key Responsibility 1." . ($i + 1) . ": $resp";
    }
    foreach ($keyResp2Parts as $i => $resp) {
      $keyResponsibilityContents[] = "Enhance this responsibility for a resume. Make it concise, action-oriented, and impactful. Return only the improved responsibility labeled Key Responsibility 2." . ($i + 1) . ": <responsibility>. Key Responsibility 2." . ($i + 1) . ": $resp";
    }

    $achievements = $_POST['achievements'];
    $achievement1 = $achievements[0];
    $achievement2 = $achievements[1] ?? '';
    $achieve1Parts = split_and_clean($achievement1);
    $achieve2Parts = split_and_clean($achievement2);
    $achievementContents = [];
    foreach ($achieve1Parts as $i => $ach) {
      $achievementContents[] = "Enhance this achievement for a resume. Make it concise, measurable if possible, and impactful. Return only the improved achievement labeled Achievement 1." . ($i + 1) . ": <achievement>. Achievement 1." . ($i + 1) . ": $ach";
    }
    foreach ($achieve2Parts as $i => $ach) {
      $achievementContents[] = "Enhance this achievement for a resume. Make it concise, measurable if possible, and impactful. Return only the improved achievement labeled Achievement 2." . ($i + 1) . ": <achievement>. Achievement 2." . ($i + 1) . ": $ach";
    }

    //OVERVIEW OF THE ROLE
    $roleOverview1 = '';
    $roleOverviewContent1 = "Write a concise, professional 1-sentence overview that summarizes the key responsibilities and impact of this position for a resume. Position: $position1.";
    $roleOverview2 = '';
    $roleOverviewContent2 = "Write a concise, professional 1-sentence overview that summarizes the key responsibilities and impact of this position for a resume. Position: $position2.";

    //SKILLS AND INTERESTS INFORMATION
    $skills = $_POST['skills'];
    $interests = $_POST['interests'];
    $skillsParts = split_and_clean($skills);
    $interestsParts = split_and_clean($interests);
    $skillsContents = [];
    foreach ($skillsParts as $i => $skill) {
      $skillsContents[] = "Enhance this skill for a resume. Make it concise, professional, and impactful. Return only the improved skill labeled Skill " . ($i + 1) . ": <skill>. Skill " . ($i + 1) . ": $skill";
    }
    $interestsContents = [];
    foreach ($interestsParts as $i => $interest) {
      $interestsContents[] = "Enhance this interest for a resume. Make it concise and professional. Return only the improved interest labeled Interest " . ($i + 1) . ": <interest>. Interest " . ($i + 1) . ": $interest";
    }


    //SUMMARY INFORMATION
    $summary = $_POST['summary'];
    $summaryContent = "Enhance this resume summary. Make it concise, professional, and impactful. Return only the improved summary labeled Summary: <summary>. Summary: $summary";

    // REFERENCE ENHANCEMENT
    $reference_type = $_POST['reference-type'];
    $reference_name = $_POST['reference_name'];
    $reference_position = $_POST['reference_position'];
    $reference_company = $_POST['reference_company'];
    $reference_contact = $_POST['reference_contact'];
    $referenceNameContent = "Fix capitalization and enhance this reference name for a resume. Return only the improved name labeled Reference Name: <name>. Reference Name: $reference_name";
    $referencePositionContent = "Fix capitalization and enhance this reference position for a resume. Return only the improved position labeled Reference Position: <position>. Reference Position: $reference_position";
    $referenceCompanyContent = "Fix capitalization and enhance this reference company for a resume. Return only the improved company labeled Reference Company: <company>. Reference Company: $reference_company";


    // REFERENCE INFORMATION
    $reference_type = $_POST['reference-type'];
    $reference_AUR = 'Available Upon Request';
    $reference_name = $_POST['reference_name'];
    $reference_position = $_POST['reference_position'];
    $reference_company = $_POST['reference_company'];
    $reference_contact = $_POST['reference_contact'];


    // Simplified: just read environment variable (no validation/fallback)
    $apiKey = getenv('OPENAI_API_KEY'); // If empty, request will fail and show raw response below
    $url = "https://api.openai.com/v1/chat/completions";

    // Build request payload
    $overviewPrompt1 = "Write a concise, professional 1-sentence overview that summarizes the key responsibilities and impact of this position for a resume. Return as: Overview 1: <overview>. Position: $position1 at $company1.";
    $overviewPrompt2 = "Write a concise, professional 1-sentence overview that summarizes the key responsibilities and impact of this position for a resume. Return as: Overview 2: <overview>. Position: $position2 at $company2.";
    $data = [
      "model" => "gpt-4.1",
      "messages" => [
        ["role" => "system", "content" => "You are a resume assistant. For each field:\n- Expand any course abbreviations/acronyms to their full meaning (e.g., 'BSIT' to 'Bachelor of Science in Information Technology').\n- Fix capitalization for names, addresses, institutions, companies, and positions.\n- Rewrite job titles to be concise and professional.\n- Enhance company names for clarity and professionalism.\n- Enhance responsibilities to be concise, action-oriented, and impactful.\n- Enhance achievements to be concise, measurable if possible, and impactful.\n- Enhance skills to be concise, professional, and impactful.\n- Enhance interests to be concise and professional.\n- Enhance the summary to be concise, professional, and impactful.\n- Enhance reference name, position, and company for professionalism and capitalization.\n- For each position, also generate a 1-sentence professional overview as instructed.\nReturn only the improved values for each field as instructed in the user prompt."],
        [
          "role" => "user",
          "content" =>
          $nameContent . "\n" .
            $addressContent . "\n" .
            $firstCourseContent . "\n" .
            $secondCourseContent . "\n" .
            $firstInstitutionContent . "\n" .
            $secondInstitutionContent . "\n" .
            $position1Content . "\n" .
            $position2Content . "\n" .
            $company1Content . "\n" .
            $company2Content . "\n" .
            implode("\n", $keyResponsibilityContents) . "\n" .
            implode("\n", $achievementContents) . "\n" .
            implode("\n", $skillsContents) . "\n" .
            implode("\n", $interestsContents) . "\n" .
            $summaryContent . "\n" .
            $referenceNameContent . "\n" .
            $referencePositionContent . "\n" .
            $referenceCompanyContent . "\n" .
            $overviewPrompt1 . "\n" .
            $overviewPrompt2
        ]
      ]
    ];


    // --- Generate AI-powered overview for each position (localized, not echoed) ---
    $positionOverview1 = '';
    $positionOverview2 = '';
    // Only generate after enhancedPosition1/2 and enhancedCompany1/2 are set
    if (!empty($enhancedPosition1) && !empty($enhancedCompany1)) {
      $overviewPrompt1 = "Write a concise, professional 1-sentence overview that summarizes the key responsibilities and impact of this position for a resume. Position: $enhancedPosition1 at $enhancedCompany1.";
      $overviewData1 = [
        "model" => "gpt-4.1",
        "messages" => [
          ["role" => "system", "content" => "You are a resume assistant. Return only the overview sentence as instructed."],
          ["role" => "user", "content" => $overviewPrompt1]
        ]
      ];
      $ch1 = curl_init($url);
      curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch1, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $apiKey"
      ]);
      curl_setopt($ch1, CURLOPT_POST, true);
      curl_setopt($ch1, CURLOPT_POSTFIELDS, json_encode($overviewData1));
      $overviewResponse1 = curl_exec($ch1);
      curl_close($ch1);
      $overviewDecoded1 = json_decode($overviewResponse1, true);
      if (isset($overviewDecoded1['choices'][0]['message']['content'])) {
        $positionOverview1 = trim($overviewDecoded1['choices'][0]['message']['content']);
      } else {
        $positionOverview1 = trim($overviewResponse1);
      }
    }
    if (!empty($enhancedPosition2) && !empty($enhancedCompany2)) {
      $overviewPrompt2 = "Write a concise, professional 1-sentence overview that summarizes the key responsibilities and impact of this position for a resume. Position: $enhancedPosition2 at $enhancedCompany2.";
      $overviewData2 = [
        "model" => "gpt-4.1",
        "messages" => [
          ["role" => "system", "content" => "You are a resume assistant. Return only the overview sentence as instructed."],
          ["role" => "user", "content" => $overviewPrompt2]
        ]
      ];
      $ch2 = curl_init($url);
      curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch2, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $apiKey"
      ]);
      curl_setopt($ch2, CURLOPT_POST, true);
      curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode($overviewData2));
      $overviewResponse2 = curl_exec($ch2);
      curl_close($ch2);
      $overviewDecoded2 = json_decode($overviewResponse2, true);
      if (isset($overviewDecoded2['choices'][0]['message']['content'])) {
        $positionOverview2 = trim($overviewDecoded2['choices'][0]['message']['content']);
      } else {
        $positionOverview2 = trim($overviewResponse2);
      }
    }

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      "Content-Type: application/json",
      "Authorization: Bearer $apiKey"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Send the request
    $response = curl_exec($ch);

    // Close the connection
    curl_close($ch);

    // Decode and store enhanced output in a variable
    // Decode response and try to separate Name and Address if API returned both
    $responseData = json_decode($response, true);
    $combined = null;
    if (isset($responseData['choices'][0]['message']['content'])) {
      $combined = trim($responseData['choices'][0]['message']['content']);
    } else {
      // if not JSON-parsable into choices, fall back to raw response
      $combined = trim($response);
    }

    // Initialize enhanced parts
    $enhancedName = null;
    $enhancedAddress = null;

    if ($combined) {
      // Try to extract lines like "Name: ..." and "Address: ..."
      if (preg_match('/^\s*Name\s*:\s*(.+)$/im', $combined, $m)) {
        $enhancedName = trim($m[1]);
      }
      if (preg_match('/^\s*Address\s*:\s*(.+)$/im', $combined, $m2)) {
        $enhancedAddress = trim($m2[1]);
      }

      // If not found, try a simple heuristic: first non-empty line = name, last non-empty line = address
      if (!$enhancedName || !$enhancedAddress) {
        $lines = array_values(array_filter(array_map('trim', preg_split('/\r?\n/', $combined))));
        if (!$enhancedName && count($lines) >= 1) {
          $enhancedName = $lines[0];
        }
        if (!$enhancedAddress && count($lines) >= 2) {
          $enhancedAddress = $lines[count($lines) - 1];
        }
      }
    }

    // Fallbacks if extraction failed
    if (!$enhancedName) {
      $enhancedName = ucwords(strtolower($full_name));
    }
    if (!$enhancedAddress) {
      $enhancedAddress = ucwords(strtolower($address));
    }

    // Extract and localize enhanced courses and institutions
    $enhancedCourse1 = null;
    $enhancedCourse2 = null;
    $enhancedInstitution1 = null;
    $enhancedInstitution2 = null;

    // Extract and localize enhanced career fields
    $enhancedPosition1 = null;
    $enhancedPosition2 = null;
    $enhancedCompany1 = null;
    $enhancedCompany2 = null;
    // Always reset these arrays before extraction to prevent duplicates
    $enhancedKeyResponsibilities1 = [];
    $enhancedKeyResponsibilities2 = [];
    $enhancedAchievements1 = [];
    $enhancedAchievements2 = [];
    $enhancedSkills = [];
    $enhancedInterests = [];
    $enhancedSummary = null;
    $enhancedReferenceName = null;
    $enhancedReferencePosition = null;
    $enhancedReferenceCompany = null;
    // Reference fields
    if (preg_match('/^Reference Name\s*:\s*(.+)$/im', $combined, $refNameMatch)) {
      $enhancedReferenceName = trim($refNameMatch[1]);
    }
    if (preg_match('/^Reference Position\s*:\s*(.+)$/im', $combined, $refPosMatch)) {
      $enhancedReferencePosition = trim($refPosMatch[1]);
    }
    if (preg_match('/^Reference Company\s*:\s*(.+)$/im', $combined, $refCompMatch)) {
      $enhancedReferenceCompany = trim($refCompMatch[1]);
    }
    // Overview fields
    $positionOverview1 = '';
    $positionOverview2 = '';
    if (preg_match('/^Overview 1\s*:\s*(.+)$/im', $combined, $overview1Match)) {
      $positionOverview1 = trim($overview1Match[1]);
    }
    if (preg_match('/^Overview 2\s*:\s*(.+)$/im', $combined, $overview2Match)) {
      $positionOverview2 = trim($overview2Match[1]);
    }
    if (!$enhancedReferenceName) {
      $enhancedReferenceName = ucwords(strtolower($reference_name));
    }
    if (!$enhancedReferencePosition) {
      $enhancedReferencePosition = ucwords(strtolower($reference_position));
    }
    if (!$enhancedReferenceCompany) {
      $enhancedReferenceCompany = ucwords(strtolower($reference_company));
    }
    // Output enhanced reference if not 'upon request' or 'AUR'
    $refType = strtolower(trim($reference_type));
    // Reference output removed
    // Summary
    if (preg_match('/^Summary\s*:\s*(.+)$/im', $combined, $sumMatch)) {
      $enhancedSummary = trim($sumMatch[1]);
    }
    if (!$enhancedSummary) {
      $enhancedSummary = $summary;
    }
    // Display enhanced summary
    // AI-Enhanced Summary output removed

    // Try to extract using regex (positions, companies, responsibilities, achievements)
    if ($combined) {
      // Positions
      if (preg_match('/^\s*' . preg_quote($position1, '/') . '\s*$/im', $combined, $m) || preg_match('/^\s*Position 1\s*:\s*(.+)$/im', $combined, $m)) {
        $enhancedPosition1 = trim($m[1] ?? $m[0]);
      } elseif (preg_match('/^.+/m', $position1)) {
        $enhancedPosition1 = trim($position1);
      }
      if (preg_match('/^\s*' . preg_quote($position2, '/') . '\s*$/im', $combined, $m2) || preg_match('/^\s*Position 2\s*:\s*(.+)$/im', $combined, $m2)) {
        $enhancedPosition2 = trim($m2[1] ?? $m2[0]);
      } elseif (preg_match('/^.+/m', $position2)) {
        $enhancedPosition2 = trim($position2);
      }
      // Companies
      if (preg_match('/^\s*' . preg_quote($company1, '/') . '\s*$/im', $combined, $m3) || preg_match('/^\s*Company 1\s*:\s*(.+)$/im', $combined, $m3)) {
        $enhancedCompany1 = trim($m3[1] ?? $m3[0]);
      } elseif (preg_match('/^.+/m', $company1)) {
        $enhancedCompany1 = trim($company1);
      }
      if (preg_match('/^\s*' . preg_quote($company2, '/') . '\s*$/im', $combined, $m4) || preg_match('/^\s*Company 2\s*:\s*(.+)$/im', $combined, $m4)) {
        $enhancedCompany2 = trim($m4[1] ?? $m4[0]);
      } elseif (preg_match('/^.+/m', $company2)) {
        $enhancedCompany2 = trim($company2);
      }
      // Key Responsibilities (extract all Key Responsibility 1.x and 2.x)
      // Skills (extract all Skill x)
      preg_match_all('/Skill (\d+)\s*:\s*(.+)/i', $combined, $skillMatches, PREG_SET_ORDER);
      foreach ($skillMatches as $match) {
        $enhancedSkills[] = trim($match[2]);
      }
      // Interests (extract all Interest x)
      preg_match_all('/Interest (\d+)\s*:\s*(.+)/i', $combined, $interestMatches, PREG_SET_ORDER);
      foreach ($interestMatches as $match) {
        $enhancedInterests[] = trim($match[2]);
      }
      // Fallbacks if extraction failed
      if (empty($enhancedSkills)) {
        $enhancedSkills = $skillsParts;
      }
      if (empty($enhancedInterests)) {
        $enhancedInterests = $interestsParts;
      }
      // Display enhanced skills and interests
      // AI-Enhanced Skills and Interests output removed
      preg_match_all('/Key Responsibility 1\\.(\\d+)\s*:\s*(.+)/i', $combined, $kr1Matches, PREG_SET_ORDER);
      foreach ($kr1Matches as $match) {
        $enhancedKeyResponsibilities1[] = trim($match[2]);
      }
      preg_match_all('/Key Responsibility 2\\.(\\d+)\s*:\s*(.+)/i', $combined, $kr2Matches, PREG_SET_ORDER);
      foreach ($kr2Matches as $match) {
        $enhancedKeyResponsibilities2[] = trim($match[2]);
      }
      // Achievements (extract all Achievement 1.x and 2.x)
      preg_match_all('/Achievement 1\\.(\\d+)\s*:\s*(.+)/i', $combined, $ach1Matches, PREG_SET_ORDER);
      foreach ($ach1Matches as $match) {
        $enhancedAchievements1[] = trim($match[2]);
      }
      preg_match_all('/Achievement 2\\.(\\d+)\s*:\s*(.+)/i', $combined, $ach2Matches, PREG_SET_ORDER);
      foreach ($ach2Matches as $match) {
        $enhancedAchievements2[] = trim($match[2]);
      }
    }

    // Fallbacks if extraction failed
    if (!$enhancedPosition1) {
      $enhancedPosition1 = ucwords(strtolower($position1));
    }
    if (!$enhancedPosition2) {
      $enhancedPosition2 = ucwords(strtolower($position2));
    }
    if (!$enhancedCompany1) {
      $enhancedCompany1 = ucwords(strtolower($company1));
    }
    if (!$enhancedCompany2) {
      $enhancedCompany2 = ucwords(strtolower($company2));
    }

    // --- Generate AI-powered overview for each position (localized, not echoed) ---
    $positionOverview1 = '';
    $positionOverview2 = '';
    // Debug: Log values before API call
    error_log('DEBUG: enhancedPosition1=' . $enhancedPosition1);
    error_log('DEBUG: enhancedCompany1=' . $enhancedCompany1);
    if (!empty($enhancedPosition1) && !empty($enhancedCompany1)) {
      $overviewPrompt1 = "Write a concise, professional 1-sentence overview that summarizes the key responsibilities and impact of this position for a resume. Position: $enhancedPosition1 at $enhancedCompany1.";
      $overviewData1 = [
        "model" => "gpt-4.1",
        "messages" => [
          ["role" => "system", "content" => "You are a resume assistant. Return only the overview sentence as instructed."],
          ["role" => "user", "content" => $overviewPrompt1]
        ]
      ];
      $ch1 = curl_init($url);
      curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch1, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $apiKey"
      ]);
      curl_setopt($ch1, CURLOPT_POST, true);
      curl_setopt($ch1, CURLOPT_POSTFIELDS, json_encode($overviewData1));
      $overviewResponse1 = curl_exec($ch1);
      curl_close($ch1);
      error_log('DEBUG: overviewResponse1=' . $overviewResponse1);
      $overviewDecoded1 = json_decode($overviewResponse1, true);
      if (isset($overviewDecoded1['choices'][0]['message']['content'])) {
        $positionOverview1 = trim($overviewDecoded1['choices'][0]['message']['content']);
      } else {
        $positionOverview1 = trim($overviewResponse1);
      }
    }
    if (!empty($enhancedPosition2) && !empty($enhancedCompany2)) {
      $overviewPrompt2 = "Write a concise, professional 1-sentence overview that summarizes the key responsibilities and impact of this position for a resume. Position: $enhancedPosition2 at $enhancedCompany2.";
      $overviewData2 = [
        "model" => "gpt-4.1",
        "messages" => [
          ["role" => "system", "content" => "You are a resume assistant. Return only the overview sentence as instructed."],
          ["role" => "user", "content" => $overviewPrompt2]
        ]
      ];
      $ch2 = curl_init($url);
      curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch2, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $apiKey"
      ]);
      curl_setopt($ch2, CURLOPT_POST, true);
      curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode($overviewData2));
      $overviewResponse2 = curl_exec($ch2);
      curl_close($ch2);
      error_log('DEBUG: overviewResponse2=' . $overviewResponse2);
      $overviewDecoded2 = json_decode($overviewResponse2, true);
      if (isset($overviewDecoded2['choices'][0]['message']['content'])) {
        $positionOverview2 = trim($overviewDecoded2['choices'][0]['message']['content']);
      } else {
        $positionOverview2 = trim($overviewResponse2);
      }
    }
    // Fallbacks if extraction failed
    if (empty($enhancedKeyResponsibilities1)) {
      $enhancedKeyResponsibilities1 = $keyResp1Parts;
    }
    if (empty($enhancedKeyResponsibilities2)) {
      $enhancedKeyResponsibilities2 = $keyResp2Parts;
    }
    if (empty($enhancedAchievements1)) {
      $enhancedAchievements1 = $achieve1Parts;
    }
    if (empty($enhancedAchievements2)) {
      $enhancedAchievements2 = $achieve2Parts;
    }

    // Try to extract using regex (Course 1:, Course 2:, First Institution:, Second Institution:)
    if ($combined) {
      if (preg_match('/Course 1\s*:\s*(.+)/i', $combined, $m)) {
        $enhancedCourse1 = trim($m[1]);
      }
      if (preg_match('/Course 2\s*:\s*(.+)/i', $combined, $m2)) {
        $enhancedCourse2 = trim($m2[1]);
      }
      if (preg_match('/First Institution\s*:\s*(.+)/i', $combined, $m3)) {
        $enhancedInstitution1 = trim($m3[1]);
      }
      if (preg_match('/Second Institution\s*:\s*(.+)/i', $combined, $m4)) {
        $enhancedInstitution2 = trim($m4[1]);
      }
    }

    // Fallbacks if extraction failed
    if (!$enhancedCourse1) {
      $enhancedCourse1 = ucwords(strtolower($firstCourse));
    }
    if (!$enhancedCourse2) {
      $enhancedCourse2 = ucwords(strtolower($secondCourse));
    }
    if (!$enhancedInstitution1) {
      $enhancedInstitution1 = ucwords(strtolower($firstInstitution));
    }
    if (!$enhancedInstitution2) {
      $enhancedInstitution2 = ucwords(strtolower($secondInstitution));
    }
  }

  ?>

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
  <script src="https://cdn.jsdelivr.net/npm/html2pdf.js@0.10.1/dist/html2pdf.bundle.min.js"></script>
  <script src="scripts/template.js?v=<?php echo time(); ?>"></script>

</body>

</html>