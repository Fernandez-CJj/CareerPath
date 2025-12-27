const sections = document.querySelectorAll(
  ".form-1-container, .education-section, .career-section, .SI-section, .summary-section, .reference-section, .review-section"
);
let currentSection = 0;

// Show first section
sections[currentSection].classList.add("active-section");

// Next button logic
document.querySelectorAll(".next-button").forEach((button) => {
  button.addEventListener("click", (e) => {
    e.preventDefault();

    if (currentSection === 0) {
      updatePersonalReview();
    }

    if (currentSection === 1) {
      updateEducationReview();
    }

    if (currentSection === 2) {
      updateCareerReview();
    }

    if (currentSection === 3) {
      updateSIReview();
    }

    if (currentSection === 4) {
      updateSummaryReview();
    }

    if (currentSection === 5) {
      updateReferenceReview();
    }

    if (currentSection < sections.length - 1) {
      sections[currentSection].classList.remove("active-section");
      currentSection++;
      sections[currentSection].classList.add("active-section");
    }
  });
});

// Back button logic
document.querySelectorAll(".back-button").forEach((button) => {
  button.addEventListener("click", (e) => {
    e.preventDefault();
    if (currentSection > 0) {
      sections[currentSection].classList.remove("active-section");
      currentSection--;
      sections[currentSection].classList.add("active-section");
    }
  });
});

// 🔹 Add Another Education
const addEducationBtn = document.querySelector(".add-education-button");
const educationContainer = document.querySelector(
  ".education-left-section .education"
);

// Helper: count all education sets (static + dynamic)
function getEducationEntryCount() {
  // Always count the static set as 1 (even if empty)
  const dynamic =
    educationContainer.querySelectorAll(".education-entry").length;
  return 1 + dynamic;
}

function updateEducationAddButton() {
  // Only allow 2 total: static + 1 dynamic
  if (getEducationEntryCount() >= 2) {
    addEducationBtn.style.display = "none";
  } else {
    addEducationBtn.style.display = "";
  }
}

addEducationBtn.addEventListener("click", (e) => {
  e.preventDefault();

  // Only add if less than 2 total (static + dynamic)
  if (getEducationEntryCount() < 2) {
    const newSet = document.createElement("div");
    newSet.classList.add("education-entry");
    newSet.innerHTML = `
        <label class="label">Course or Qualification</label>
        <input type="text" name="course[]" class="input-button" placeholder="eg. “Bachelor of Science in Information Technology”">
        <label class="label">Institution Name</label>
        <input type="text" name="institution[]" class="input-button" placeholder="eg. “Pangasinan State University”">
        <label class="label">Graduation Year</label>
        <input type="date" name="graduation[]" class="date-button">
        <button class="remove-button">Remove</button>
      `;

    // Append to the form
    educationContainer.insertBefore(newSet, addEducationBtn);

    // Add remove button functionality
    newSet.querySelector(".remove-button").addEventListener("click", (e) => {
      e.preventDefault();
      newSet.remove();
      updateEducationAddButton();
    });

    updateEducationAddButton();
    // Immediately check and hide if at max
    if (getEducationEntryCount() >= 2) {
      addEducationBtn.style.display = "none";
    }
  } else {
    // If already at max, hide button just in case
    addEducationBtn.style.display = "none";
  }
});

// Initial check in case there is already one or two entries
// Ensure only 2 education entries max (including initial)
function enforceEducationLimit() {
  if (getEducationEntryCount() >= 2) {
    addEducationBtn.style.display = "none";
  } else {
    addEducationBtn.style.display = "";
  }
}
// Run on page load
enforceEducationLimit();
// Also run after any add/remove
educationContainer.addEventListener("DOMNodeInserted", enforceEducationLimit);
educationContainer.addEventListener("DOMNodeRemoved", enforceEducationLimit);

const addCareerBtn = document.querySelector(".add-career-button");
const careerContainer = document.querySelector(".career-left-section .career");

// Helper: count all career sets (static + dynamic)
function getCareerEntryCount() {
  // Always count the static set as 1 (even if empty)
  const dynamic = careerContainer.querySelectorAll(".career-entry").length;
  return 1 + dynamic;
}

function updateCareerAddButton() {
  // Only allow 2 total: static + 1 dynamic
  if (getCareerEntryCount() >= 2) {
    addCareerBtn.style.display = "none";
  } else {
    addCareerBtn.style.display = "";
  }
}

addCareerBtn.addEventListener("click", (e) => {
  e.preventDefault();

  // Only add if less than 2 total (static + dynamic)
  if (getCareerEntryCount() < 2) {
    const newSet = document.createElement("div");
    newSet.classList.add("career-entry");
    newSet.innerHTML = `
      <label class="label">Position</label>
      <input type="text" name="position[]" class="input-button" placeholder="Enter your position">
      <label class="label">Company Name</label>
      <input type="text" name="company_name[]" class="input-button" placeholder="Enter your company name">
      <div class="career-date-container">
        <div class="career-start-date-container">
          <label class="label">Start Date</label>
          <input type="date" name="start_date[]" class="start-date-button">
        </div>
        <div class="career-end-date-container">
          <label class="label">End Date</label>
          <input type="date" name="end_date[]" class="end-date-button">
        </div>
      </div>
      <label class="label">Key Responsibilities</label>
      <textarea name="key_responsibilities[]" class="textarea-input" placeholder="e.g. Managed team workflows, coordinated client communications..."></textarea>
      <label class="label">Achievements</label>
      <textarea name="achievements[]" class="textarea-input" placeholder="e.g. Best employee of the month"></textarea>
      <button class="remove-button">Remove</button>
    `;

    // Insert new set before the Add Career button
    careerContainer.insertBefore(newSet, addCareerBtn);

    // Add remove button functionality
    newSet.querySelector(".remove-button").addEventListener("click", (e) => {
      e.preventDefault();
      newSet.remove();
      updateCareerAddButton();
    });

    updateCareerAddButton();
    // Immediately check and hide if at max
    if (getCareerEntryCount() >= 2) {
      addCareerBtn.style.display = "none";
    }
  } else {
    // If already at max, hide button just in case
    addCareerBtn.style.display = "none";
  }
});

// Initial check in case there is already one or two entries
// Ensure only 2 career entries max (including initial)
function enforceCareerLimit() {
  if (getCareerEntryCount() >= 2) {
    addCareerBtn.style.display = "none";
  } else {
    addCareerBtn.style.display = "";
  }
}
// Run on page load
enforceCareerLimit();
// Also run after any add/remove
careerContainer.addEventListener("DOMNodeInserted", enforceCareerLimit);
careerContainer.addEventListener("DOMNodeRemoved", enforceCareerLimit);

const referenceRadios = document.querySelectorAll(
  'input[name="reference-type"]'
);
const referenceInputs = document.querySelectorAll(
  ".reference .input-button, .reference .label"
);

referenceRadios.forEach((radio) => {
  radio.addEventListener("change", () => {
    if (radio.value === "ARD" && radio.checked) {
      // Show reference input fields
      referenceInputs.forEach((el) => (el.style.display = "block"));
    } else if (radio.value === "AUR" && radio.checked) {
      // Hide reference input fields
      referenceInputs.forEach((el) => (el.style.display = "none"));
    }
  });
});

// Hide by default
referenceInputs.forEach((el) => (el.style.display = "none"));

function updatePersonalReview() {
  // Get values from input fields
  const fullName = document.getElementById("js-fullName").value;
  const email = document.getElementById("js-email").value;
  const contactNumber = document.getElementById("js-contactNumber").value;
  const street = document.getElementById("js-street").value;
  const barangay = document.getElementById("js-barangay").value;
  const city = document.getElementById("js-city").value;
  const province = document.getElementById("js-province").value;

  // Display in review section
  document.getElementById("review-fullName").textContent = fullName;
  document.getElementById("review-email").textContent = email;
  document.getElementById("review-contactNumber").textContent = contactNumber;
  document.getElementById("review-street").textContent = street;
  document.getElementById("review-barangay").textContent = barangay;
  document.getElementById("review-city").textContent = city;
  document.getElementById("review-province").textContent = province;
}

function updateEducationReview() {
  const reviewContainer = document.getElementById("education-review-list");
  reviewContainer.innerHTML = ""; // clear previous entries

  // Select all course inputs, including array ones
  const courses = document.querySelectorAll(
    'input[name="course"], input[name="course[]"]'
  );
  const institutions = document.querySelectorAll(
    'input[name="intitution"], input[name="institution"], input[name="institution[]"], input[name="intitution[]"]'
  );
  const graduations = document.querySelectorAll(
    'input[name="graduation"], input[name="graduation[]"]'
  );

  // Use the largest length (in case one field is missing)
  const count = Math.max(
    courses.length,
    institutions.length,
    graduations.length
  );

  for (let i = 0; i < count; i++) {
    const course = courses[i]?.value || "";
    const institution = institutions[i]?.value || "";
    const graduation = graduations[i]?.value || "";

    if (course || institution || graduation) {
      const div = document.createElement("div");
      div.classList.add("review-education-item");
      div.innerHTML = `
        <div class="review-title">Course/Qualification: <span class="details">${course}</span></div>
        <div class="review-title">Institution Name: <span class="details">${institution}</span></div>
        <div class="review-title">Graduation Year: <span class="details">${graduation}</span></div>
        <hr>
      `;
      reviewContainer.appendChild(div);
    }
  }
}

function updateCareerReview() {
  const reviewContainer = document.querySelector(".career-review-container");
  reviewContainer.innerHTML = '<div class="review-label">Career History</div>'; // clear previous entries

  // Select all career input fields
  const positions = document.querySelectorAll(
    'input[name="position"], input[name="position[]"]'
  );
  const companyNames = document.querySelectorAll(
    'input[name="company_name"], input[name="company_name[]"]'
  );
  const startDates = document.querySelectorAll(
    'input[name="start_date"], input[name="start_date[]"]'
  );
  const endDates = document.querySelectorAll(
    'input[name="end_date"], input[name="end_date[]"]'
  );
  const responsibilities = document.querySelectorAll(
    'textarea[name="key_responsibilities"], textarea[name="key_responsibilities[]"]'
  );
  const achievements = document.querySelectorAll(
    'textarea[name="achievements"], textarea[name="achievements[]"]'
  );

  const count = Math.max(
    positions.length,
    companyNames.length,
    startDates.length,
    endDates.length,
    responsibilities.length,
    achievements.length
  );

  for (let i = 0; i < count; i++) {
    const position = positions[i]?.value || "";
    const companyName = companyNames[i]?.value || "";
    const startDate = startDates[i]?.value || "";
    const endDate = endDates[i]?.value || "";
    const responsibility = responsibilities[i]?.value || "";
    const achievement = achievements[i]?.value || "";

    if (
      position ||
      companyName ||
      startDate ||
      endDate ||
      responsibility ||
      achievement
    ) {
      const div = document.createElement("div");
      div.classList.add("review-career-item");
      div.innerHTML = `
        <div class="review-title">Position: <span class="details">${position}</span></div>
        <div class="review-title">Company Name: <span class="details">${companyName}</span></div>
        <div class="review-title">Start Date: <span class="details">${startDate}</span></div>
        <div class="review-title">End Date: <span class="details">${endDate}</span></div>
        <div class="review-title">Key Responsibilities: <span class="details">${responsibility}</span></div>
        <div class="review-title">Achievements: <span class="details">${achievement}</span></div>
        <hr>
      `;
      reviewContainer.appendChild(div);
    }
  }
}

function updateSIReview() {
  // Get values from input fields
  const skills = document.getElementById("js-skills").value;
  const interests = document.getElementById("js-interests").value;

  // Display in review section
  document.getElementById("review-skills").textContent = skills;
  document.getElementById("review-interests").textContent = interests;
}

function updateSummaryReview() {
  // Get values from input fields
  const summary = document.getElementById("js-summary").value;

  // Display in review section
  document.getElementById("review-summary").textContent = summary;
}

function updateReferenceReview() {
  const reviewContainer = document.getElementById("review-reference");
  const selectedRadio = document.querySelector(
    'input[name="reference-type"]:checked'
  );

  if (!selectedRadio) {
    reviewContainer.innerHTML = ""; // nothing selected
    return;
  }

  if (selectedRadio.value === "AUR") {
    reviewContainer.innerHTML = `Available upon request`;
  } else if (selectedRadio.value === "ARD") {
    // Grab the reference input fields
    const name =
      document.querySelector('.reference input[name="reference_name"]')
        ?.value || "";
    const position =
      document.querySelector('.reference input[name="reference_position"]')
        ?.value || "";
    const company =
      document.querySelector('.reference input[name="reference_company"]')
        ?.value || "";
    const contact =
      document.querySelector('.reference input[name="reference_contact"]')
        ?.value || "";

    reviewContainer.innerHTML = `
      <div class="review-title">Reference Name: <span class="details">${name}</span></div>
      <div class="review-title">Position: <span class="details">${position}</span></div>
      <div class="review-title">Company: <span class="details">${company}</span></div>
      <div class="review-title">Contact Information: <span class="details">${contact}</span></div>
    `;
  }
}
