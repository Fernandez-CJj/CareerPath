<?php
session_start();
include "../../config.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$user_id = $_SESSION['user_id'];

$action = $_POST['action'] ?? $_GET['action'] ?? '';


if ($action == 'delete_job') {
    $job_id = $_GET['id'] ?? $_POST['job_id'] ?? null;

    if (!$job_id) {
        echo json_encode(['status' => 'error', 'message' => 'Missing Job ID']);
        exit();
    }

   
    $sql = "DELETE FROM job WHERE job_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $job_id, $user_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
    exit(); 
}

if ($action == 'post_job' || $action == 'update_job') {
    $title    = $_POST['title'];
    $location = $_POST['location'];
    $overview = $_POST['jobOverview'];
    $type     = $_POST['job_type']; 
    $wage     = $_POST['wage'];
    $hours    = $_POST['hoursPerWeek'];
    $resp     = $_POST['keyResponsibilities'];
    $qual     = $_POST['qualifications'];
    $person   = $_POST['contactPerson'];
    $skills   = $_POST['skills'];

    if ($action == 'post_job') {
        $sql = "INSERT INTO job (user_id, job_title, location, job_overview, type_of_work, salary, hours, key_responsibilities, qualifications, contact_person, skills_requirements) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssdsssss", $user_id, $title, $location, $overview, $type, $wage, $hours, $resp, $qual, $person, $skills);
    } else {
        $id = $_POST['job_id'];
        $sql = "UPDATE job SET job_title=?, location=?, job_overview=?, type_of_work=?, salary=?, hours=?, key_responsibilities=?, qualifications=?, contact_person=?, skills_requirements=? 
                WHERE job_id=? AND user_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssdissssii", $title, $location, $overview, $type, $wage, $hours, $resp, $qual, $person, $skills, $id, $user_id);
    }

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
}
?>