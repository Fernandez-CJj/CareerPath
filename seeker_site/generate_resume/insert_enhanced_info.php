<?php
session_start();
$seeker_id = $_SESSION['seeker_id'];
include('../../config.php');

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$contact = $_POST['contact_number'] ?? '';
$address = $_POST['address'] ?? '';
$course1 = $_POST['course1'] ?? '';
$institution_name1 = $_POST['institution_name1'] ?? '';
$graduation_year1 = $_POST['graduation_year1'] ?? '';
$course2 = $_POST['course2'] ?? '';
$institution_name2 = $_POST['institution_name2'] ?? '';
$graduation_year2 = $_POST['graduation_year2'] ?? '';
$job_title1 = $_POST['job_title1'] ?? '';
$company1 = $_POST['company1'] ?? '';
$start_year1 = $_POST['start_year1'] ?? '';
$end_year1 = $_POST['end_year1'] ?? '';
$job_overview1 = $_POST['job_overview1'] ?? '';
$job_title2 = $_POST['job_title2'] ?? '';
$company2 = $_POST['company2'] ?? '';
$start_year2 = $_POST['start_year2'] ?? '';
$end_year2 = $_POST['end_year2'] ?? '';
$job_overview2 = $_POST['job_overview2'] ?? '';
$key_responsibilities1 = $_POST['key_responsibilities1'] ?? '';
$key_responsibilities2 = $_POST['key_responsibilities2'] ?? '';
$achievements1 = $_POST['achievements1'] ?? '';
$achievements2 = $_POST['achievements2'] ?? '';
$skills = $_POST['skills'] ?? '';
$interests = $_POST['interests'] ?? '';
$summary = $_POST['summary'] ?? '';
$reference_type = $_POST['reference_type'] ?? '';
$reference_name = $_POST['reference_name'] ?? '';
$reference_position = $_POST['reference_position'] ?? '';
$reference_company = $_POST['reference_company'] ?? '';
$reference_contact = $_POST['reference_contact'] ?? '';

$sql = "INSERT INTO resumes (seeker_id, name, email, contact_number, address, course1, institution_name1, graduation_year1, course2, institution_name2, graduation_year2, job_title1, company1, start_year1, end_year1, job_overview1, key_responsibilities1, achievements1, job_title2, company2, start_year2, end_year2, job_overview2, key_responsibilities2, achievements2, skills, interests, summary, reference_type, reference_name, reference_position, reference_company, reference_contact) 
          VALUES ($seeker_id, '$name', '$email', '$contact', '$address', '$course1', '$institution_name1', '$graduation_year1', '$course2', '$institution_name2', '$graduation_year2', '$job_title1', '$company1', '$start_year1', '$end_year1', '$job_overview1', '$key_responsibilities1', '$achievements1', '$job_title2', '$company2', '$start_year2', '$end_year2', '$job_overview2', '$key_responsibilities2', '$achievements2', '$skills', '$interests', '$summary', '$reference_type', '$reference_name', '$reference_position', '$reference_company', '$reference_contact')";

$result = mysqli_query($conn, $sql);
