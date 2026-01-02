<?php
include "../../config.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $job_id = mysqli_real_escape_string($conn, $_POST['job_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']); 

    $sql = "UPDATE job SET status = '$status' WHERE job_id = '$job_id'";
    
    if (mysqli_query($conn, $sql)) {
        // We use 'status' here to match your frontend JavaScript check
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
}