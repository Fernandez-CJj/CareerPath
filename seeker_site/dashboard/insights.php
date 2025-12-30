<?php
session_start();
include('../../config.php');
include('../header/dashboardHeader.html');

$seeker_id = $_SESSION['seeker_id'] ?? 0;

// Fetch resumes for this seeker
$resumes = [];
if ($seeker_id) {
  $sql = "SELECT * FROM resumes WHERE seeker_id = $seeker_id ORDER BY id DESC";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $resumes[] = $row;
  }
}

// Heuristic fallback when AI is unavailable
function heuristic_insights($row)
{
  $weights = [
    ['w' => 15, 'v' => !empty($row['name']) && !empty($row['email']) && !empty($row['contact_number']) && !empty($row['address'])],
    ['w' => 20, 'v' => !empty($row['course1']) && !empty($row['institution_name1']) && !empty($row['graduation_year1'])],
    ['w' => 20, 'v' => !empty($row['job_title1']) && !empty($row['company1']) && !empty($row['start_year1']) && !empty($row['end_year1']) && !empty($row['job_overview1'])],
    ['w' => 20, 'v' => !empty($row['skills'])],
    ['w' => 5, 'v' => !empty($row['interests'])],
    ['w' => 10, 'v' => !empty($row['summary'])],
    ['w' => 10, 'v' => (!empty($row['reference_type']) && strtolower(trim($row['reference_type'])) === 'aur') || !empty($row['reference_name'])],
  ];
  $total = array_sum(array_column($weights, 'w'));
  $filled = 0;
  foreach ($weights as $f) {
    if ($f['v']) $filled += $f['w'];
  }
  $completion = $total ? round(($filled / $total) * 100) : 0;
  $skillsCount = count(array_filter(array_map('trim', explode('|', $row['skills'] ?? ''))));
  $skillStrength = min(100, $skillsCount * 10);
  $matchRate = $completion;

  $suggestions = [];
  if ($skillsCount < 5) $suggestions[] = 'Add more skills related to your job title';
  if (empty($row['achievements1']) && empty($row['achievements2'])) $suggestions[] = 'Add achievements';
  if (empty($row['summary'])) $suggestions[] = 'Add a summary';
  if (empty($row['job_overview1'])) $suggestions[] = 'Add a job overview for your primary role';
  if (empty($suggestions)) $suggestions[] = 'Looks good!';

  return [
    'completion_rate' => $completion,
    'match_rate' => $matchRate,
    'skill_strength' => $skillStrength,
    'suggestions' => $suggestions,
  ];
}

// AI insights using OpenAI (model and key follow resume_handler pattern)
function ai_insights($row)
{
  $apiKey = getenv('OPENAI_API_KEY');
  if (!$apiKey) return null;

  $skills = array_filter(array_map('trim', explode('|', $row['skills'] ?? '')));
  $interests = array_filter(array_map('trim', explode('|', $row['interests'] ?? '')));
  $resp = [
    'id' => $row['id'] ?? '',
    'name' => $row['name'] ?? '',
    'email' => $row['email'] ?? '',
    'contact_number' => $row['contact_number'] ?? '',
    'summary' => $row['summary'] ?? '',
    'skills' => $skills,
    'interests' => $interests,
    'experience' => [
      [
        'title' => $row['job_title1'] ?? '',
        'company' => $row['company1'] ?? '',
        'start' => $row['start_year1'] ?? '',
        'end' => $row['end_year1'] ?? '',
        'overview' => $row['job_overview1'] ?? '',
        'achievements' => array_filter(array_map('trim', explode('|', $row['achievements1'] ?? ''))),
      ],
      [
        'title' => $row['job_title2'] ?? '',
        'company' => $row['company2'] ?? '',
        'start' => $row['start_year2'] ?? '',
        'end' => $row['end_year2'] ?? '',
        'overview' => $row['job_overview2'] ?? '',
        'achievements' => array_filter(array_map('trim', explode('|', $row['achievements2'] ?? ''))),
      ],
    ],
    'education' => [
      [
        'course' => $row['course1'] ?? '',
        'institution' => $row['institution_name1'] ?? '',
        'graduation' => $row['graduation_year1'] ?? '',
      ],
      [
        'course' => $row['course2'] ?? '',
        'institution' => $row['institution_name2'] ?? '',
        'graduation' => $row['graduation_year2'] ?? '',
      ],
    ],
    'reference_type' => $row['reference_type'] ?? '',
  ];

  $prompt = "You are an ATS insights assistant. Given resume data, return JSON only with keys: completion_rate (0-100 int), match_rate (0-100 int), skill_strength (0-100 int), suggestions (array of up to 3 short sentences). Base scores on completeness, skill depth, and career clarity. Resume data: " . json_encode($resp);

  $payload = [
    'model' => 'gpt-4.1',
    'messages' => [
      ['role' => 'system', 'content' => 'Return JSON only, no prose.'],
      ['role' => 'user', 'content' => $prompt],
    ],
    'temperature' => 0.3,
  ];

  $ch = curl_init('https://api.openai.com/v1/chat/completions');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    "Authorization: Bearer $apiKey",
  ]);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
  $response = curl_exec($ch);
  curl_close($ch);

  $decoded = json_decode($response, true);
  if (!isset($decoded['choices'][0]['message']['content'])) return null;
  $content = trim($decoded['choices'][0]['message']['content']);
  $json = json_decode($content, true);
  if (!is_array($json)) return null;
  if (!isset($json['completion_rate'], $json['match_rate'], $json['skill_strength'])) return null;
  if (!isset($json['suggestions']) || !is_array($json['suggestions'])) $json['suggestions'] = [];
  return $json;
}

// Prepare insights list
$insights = [];
foreach ($resumes as $row) {
  $ai = ai_insights($row);
  $data = $ai ?: heuristic_insights($row);
  $insights[] = [
    'id' => $row['id'],
    'completion' => $data['completion_rate'],
    'match' => $data['match_rate'],
    'skill' => $data['skill_strength'],
    'suggestions' => $data['suggestions'],
  ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Insights</title>
  <link rel="stylesheet" href="styles/dashboard.css">
  <style>
    .insights-wrapper {
      padding: 24px;
      background: #f5f5f5;
      min-height: 100vh;
    }

    .insights-card {
      background: #fff;
      border: 2px solid #0c4a86;
      border-radius: 16px;
      padding: 16px;
      margin-bottom: 20px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .insights-table {
      width: 100%;
      border-collapse: collapse;
    }

    .insights-table th,
    .insights-table td {
      border: 1px solid #d1d5db;
      padding: 12px;
      text-align: center;
      font-weight: 600;
    }

    .suggestion-title {
      font-weight: 700;
      margin-top: 16px;
      margin-bottom: 6px;
    }
  </style>
</head>

<body>
  <div class="dashboard-content-container">
    <div class="dashboard-left-section">
      <div class="icon-container" onclick="window.location.href='dashboard.php'">
        <div><img src="../../assets/images/applications-icon.png" alt=""></div>
        <div>APPLICATIONS</div>
      </div>
      <div class="icon-container" onclick="window.location.href='resume_version.php'">
        <div><img src="../../assets/images/resume-icon.png" alt=""></div>
        <div>RESUME VERSIONS</div>
      </div>
      <div class="icon-container" onclick="window.location.href='insights.php'">
        <div><img src="../../assets/images/insights-icon.png" alt=""></div>
        <div>SUCCESS INSIGHTS</div>
      </div>
    </div>
    <div class="dashboard-right-section">
      <div class="insights-wrapper">
        <h2>Insights</h2>
        <?php if (empty($insights)): ?>
          <div>No resumes found. Generate one to see insights.</div>
        <?php else: ?>
          <?php $resIndex = 1; ?>
          <?php foreach ($insights as $i): ?>
            <div class="insights-card">
              <table class="insights-table">
                <tr>
                  <th>RESUME ID</th>
                  <th>COMPLETION RATE</th>
                  <th>MATCH RATE</th>
                  <th>SKILL STRENGTH</th>
                </tr>
                <tr>
                  <td><?php echo 'Resume ' . $resIndex; ?></td>
                  <td><?php echo $i['completion']; ?>%</td>
                  <td><?php echo $i['match']; ?>%</td>
                  <td><?php echo $i['skill']; ?></td>
                </tr>
              </table>
              <div class="suggestion-title">SUGGESTIONS</div>
              <div>
                <?php echo htmlspecialchars(implode('. ', $i['suggestions'])); ?>
              </div>
            </div>
            <?php $resIndex++; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>

</html>