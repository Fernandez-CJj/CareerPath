<?php
session_start();
include "../../config.php";

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action == 'post_job' || $action == 'update_job') {
    $title = $_POST['title'];
    $location = $_POST['location']; // New field
    $overview_text = $_POST['jobOverview'];
    $type = strtolower($_POST['job_type']); 
    $resp = $_POST['keyResponsibilities'];
    $qual = $_POST['qualifications'] ?? '';
    $wage = $_POST['wage'];
    $hours = $_POST['hoursPerWeek']; 
    $person = $_POST['contactPerson'];
    $skills = $_POST['skills'];
    
    $user_id = $_SESSION['user_id'] ?? 1;

    if ($action == 'post_job') {
        $sql = "INSERT INTO job (user_id, job_title, location, job_overview, type_of_work, salary, hours, key_responsibilities, qualifications, contact_person, skills_requirements) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssdisssss", $user_id, $title, $location, $overview_text, $type, $wage, $hours, $resp, $qual, $person, $skills);
    } else {
        $id = $_POST['job_id'];
        $sql = "UPDATE job SET job_title=?, location=?, job_overview=?, type_of_work=?, salary=?, hours=?, key_responsibilities=?, qualifications=?, contact_person=?, skills_requirements=? WHERE job_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssdissssi", $title, $location, $overview_text, $type, $wage, $hours, $resp, $qual, $person, $skills, $id);
    }

    if ($stmt->execute()) echo json_encode(['status' => 'success']);
    else echo json_encode(['status' => 'error', 'message' => $conn->error]);
}

if ($action == 'delete_job') {
    $id = $_GET['id'];
    $sql = "DELETE FROM job WHERE job_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) echo json_encode(['status' => 'success']);
    else echo json_encode(['status' => 'error', 'message' => $conn->error]);
}
?>