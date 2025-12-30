<?php
session_start();
include('../../config.php');
$seeker_id = $_SESSION['seeker_id'];
$resume_id = $_GET['id'];

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $reference_type = $_POST['reference_type'];

  if ($reference_type == 'AUR') {
    // Clear other reference fields
    $reference_name = '';
    $reference_position = '';
    $reference_company = '';
    $reference_contact = '';
  } else {
    $reference_name = $_POST['reference_name'];
    $reference_position = $_POST['reference_position'];
    $reference_company = $_POST['reference_company'];
    $reference_contact = $_POST['reference_contact'];
  }

  $sql = "UPDATE resumes SET reference_type='$reference_type', reference_name='$reference_name', reference_position='$reference_position', reference_company='$reference_company', reference_contact='$reference_contact' WHERE id=$resume_id AND seeker_id=$seeker_id";

  if (mysqli_query($conn, $sql)) {
    header("Location: review_resume.php?id=$resume_id");
    exit;
  } else {
    $message = 'Error updating details';
  }
}

// Fetch current data
$sql = "SELECT * FROM resumes WHERE id=$resume_id AND seeker_id=$seeker_id";
$result = mysqli_query($conn, $sql);
$resume = mysqli_fetch_assoc($result);

include('../header/dashboardHeader.html');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Reference</title>
  <style>
    .container-container {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .form-container {
      background: white;
      width: 700px;
      margin-top: 50px;
      margin-bottom: 50px;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }

    .form-title {
      font-size: 28px;
      font-weight: bold;
      color: #0c4a86;
      text-align: center;
      margin-bottom: 30px;
    }

    .label {
      font-size: 16px;
      margin-left: 5px;
      font-weight: bold;
      color: #222;
      margin-bottom: 10px;
    }

    .input-field {
      width: 100%;
      padding-left: 20px;
      padding-right: 20px;
      margin-top: 10px;
      margin-bottom: 20px;
      font-size: 16px;
      border-radius: 10px;
      border: 2px solid #0c4a86;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
      box-sizing: border-box;
      font-family: Arial, Helvetica, sans-serif;
      height: 50px;
    }

    .input-field:focus {
      outline: none;
      border-color: #2563eb;
    }

    .button-container {
      display: flex;
      gap: 15px;
      margin-top: 30px;
    }

    .submit-button,
    .cancel-button {
      flex: 1;
      border: none;
      height: 50px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      transition: opacity 0.2s;
    }

    .submit-button {
      background-color: #0c4a86;
      color: white;
    }

    .cancel-button {
      background-color: #e5e7eb;
      color: #222;
    }

    .submit-button:hover,
    .cancel-button:hover {
      opacity: 0.8;
    }

    .submit-button:active,
    .cancel-button:active {
      opacity: 0.5;
    }

    .message {
      color: #dc2626;
      font-size: 14px;
      margin-top: -10px;
      margin-bottom: 15px;
      text-align: center;
    }

    .helper-text {
      font-size: 12px;
      color: #6b7280;
      margin-top: -15px;
      margin-bottom: 15px;
      margin-left: 5px;
    }

    .radio-group {
      margin-top: 10px;
      margin-bottom: 20px;
    }

    .radio-option {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
    }

    .radio-option input[type="radio"] {
      width: 20px;
      height: 20px;
      margin-right: 10px;
      cursor: pointer;
    }

    .radio-option label {
      font-size: 16px;
      color: #222;
      cursor: pointer;
    }

    .reference-fields {
      transition: opacity 0.3s ease;
    }

    .reference-fields.hidden {
      display: none;
    }
  </style>
</head>

<body>
  <div class="container-container">
    <div class="form-container">
      <div class="form-title">Edit Reference</div>

      <form action="" method="post" id="referenceForm">
        <div class="label">Reference Type</div>
        <div class="radio-group">
          <div class="radio-option">
            <input type="radio" id="addReference" name="reference_type" value="ARD" <?php echo ($resume['reference_type'] == 'ARD' || ($resume['reference_type'] != 'AUR' && !empty($resume['reference_type']))) ? 'checked' : ''; ?> required>
            <label for="addReference">Add Reference Details (ARD)</label>
          </div>
          <div class="radio-option">
            <input type="radio" id="available" name="reference_type" value="AUR" <?php echo ($resume['reference_type'] == 'AUR') ? 'checked' : ''; ?> required>
            <label for="available">Available Upon Request (AUR)</label>
          </div>
        </div>

        <div class="reference-fields" id="referenceFields">
          <div class="label">Reference Name</div>
          <input type="text" name="reference_name" class="input-field" placeholder="e.g., John Doe" value="<?php echo htmlspecialchars($resume['reference_name']); ?>" id="referenceName">

          <div class="label">Reference Position</div>
          <input type="text" name="reference_position" class="input-field" placeholder="e.g., Senior Manager, Professor" value="<?php echo htmlspecialchars($resume['reference_position']); ?>" id="referencePosition">

          <div class="label">Reference Company / Institution</div>
          <input type="text" name="reference_company" class="input-field" placeholder="e.g., ABC Corporation, XYZ University" value="<?php echo htmlspecialchars($resume['reference_company']); ?>" id="referenceCompany">

          <div class="label">Reference Contact</div>
          <input type="text" name="reference_contact" class="input-field" placeholder="e.g., +63 912 345 6789 or john.doe@email.com" value="<?php echo htmlspecialchars($resume['reference_contact']); ?>" id="referenceContact">
          <div class="helper-text">Phone number or email address</div>
        </div>

        <?php if ($message): ?>
          <div class="message">
            <?php echo $message; ?>
          </div>
        <?php endif; ?>

        <div class="button-container">
          <button type="button" class="cancel-button" onclick="window.location.href='review_resume.php?id=<?php echo $resume_id; ?>'">Cancel</button>
          <button type="submit" class="submit-button">Save Changes</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const radioButtons = document.querySelectorAll('input[name="reference_type"]');
    const referenceFields = document.getElementById('referenceFields');
    const referenceName = document.getElementById('referenceName');
    const referencePosition = document.getElementById('referencePosition');
    const referenceCompany = document.getElementById('referenceCompany');
    const referenceContact = document.getElementById('referenceContact');

    function toggleReferenceFields() {
      const selectedValue = document.querySelector('input[name="reference_type"]:checked').value;

      if (selectedValue === 'AUR') {
        referenceFields.classList.add('hidden');
        // Remove required attribute when hidden
        referenceName.removeAttribute('required');
        referencePosition.removeAttribute('required');
        referenceCompany.removeAttribute('required');
        referenceContact.removeAttribute('required');
      } else {
        referenceFields.classList.remove('hidden');
        // Add required attribute when visible
        referenceName.setAttribute('required', 'required');
        referencePosition.setAttribute('required', 'required');
        referenceCompany.setAttribute('required', 'required');
        referenceContact.setAttribute('required', 'required');
      }
    }

    // Add event listeners to all radio buttons
    radioButtons.forEach(radio => {
      radio.addEventListener('change', toggleReferenceFields);
    });

    // Initialize on page load
    toggleReferenceFields();
  </script>
</body>

</html>