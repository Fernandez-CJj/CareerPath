  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/form.css?v=<?php echo time(); ?>">
  </head>

  <body>
    <?php include '../header/resumegen.html'; ?>
    <form action="resumeHandler.php" method="POST">
      <div class="form-1-container">
        <div class="form-1">
          <div class="form1-left-section">
            <div class="form1">
              <div class="title">Create a Resume</div>
              <label class="label">Full name</label>
              <input type="text" id="js-fullName" name="full_name" class="input-button" placeholder="eg. “Rose B. Santos">
              <label class="label">Email </label>
              <input type="text" id="js-email" name="email" class="input-button" placeholder="eg. “cf94070xx@gmail.com”">
              <label class="label">Contact Number</label>
              <input type="text" id="js-contactNumber" name="contact_number" class="input-button" placeholder="09xx xxx xxx">
              <label class="label">Address</label>
              <input type="text" id="js-street" name="street" class="input-button" placeholder="Street/House No.">
              <input type="text" id="js-barangay" name="barangay" class="input-button" placeholder="Barangay">
              <input type="text" id="js-city" name="city" class="input-button" placeholder="City/Municipality">
              <input type="text" id="js-province" name="province" class="input-button" placeholder="Province">
              <button class="next-button">Next</button>
            </div>
          </div>
          <div class="form1-right-section">
            <div class="steps">Step 1 out of 7</div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Personal Info</div>
            </div>
            <div class="steps-container">
              <div class="circle-outline"></div>
              <div class="step-name">Education</div>
            </div>
            <div class="steps-container">
              <div class="circle-outline"></div>
              <div class="step-name">Career History</div>
            </div>
            <div class="steps-container">
              <div class="circle-outline"></div>
              <div class="step-name">Skills and Interests</div>
            </div>
            <div class="steps-container">
              <div class="circle-outline"></div>
              <div class="step-name">Summary</div>
            </div>
            <div class="steps-container">
              <div class="circle-outline"></div>
              <div class="step-name">Reference</div>
            </div>
            <div class="steps-container">
              <div class="circle-outline"></div>
              <div class="step-name">Review</div>
            </div>
          </div>
        </div>
      </div>

      <div class="education-section">
        <div class="education-container">
          <div class="education-left-section">
            <div class="education">
              <div class="title">Create a Resume</div>
              <label class="label">Course or Qualification</label>
              <input type="text" id="js-course" name="course[]" class="input-button" placeholder="eg. “bachelors of science in information technology">
              <label class="label">Institution Name</label>
              <input type="text" id="js-institution" name="institution[]" class="input-button" placeholder="eg. “pangasinan state university">
              <label class="label">Graduation Year</label>
              <input type="date" id="js-graduation" name="graduation[]" class="date-button">
              <button class="add-education-button">Add Another Education</button>
              <div class="buttons-container"><button class="back-button">Back</button><button class="next-button">Next</button></div>
            </div>
          </div>
          <div class="education-right-section">
            <div class="steps">Step 2 out of 7</div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Personal Info</div>
            </div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Education</div>
            </div>
            <div class="steps-container">
              <div class="circle-outline"></div>
              <div class="step-name">Career History</div>
            </div>
            <div class="steps-container">
              <div class="circle-outline"></div>
              <div class="step-name">Skills and Interests</div>
            </div>
            <div class="steps-container">
              <div class="circle-outline"></div>
              <div class="step-name">Summary</div>
            </div>
            <div class="steps-container">
              <div class="circle-outline"></div>
              <div class="step-name">Reference</div>
            </div>
            <div class="steps-container">
              <div class="circle-outline"></div>
              <div class="step-name">Review</div>
            </div>
          </div>
        </div>
      </div>

      <div class="career-section">
        <div class="career-container">
          <div class="career-left-section">
            <div class="career">
              <div class="title">Create a Resume</div>
              <label class="label">Position</label>
              <input type="text" id="js-position" name="position[]" class="input-button" placeholder="enter your position">
              <label class="label">Company Name</label>
              <input type="text" id="js-intitution" name="company_name[]" class="input-button" placeholder="enter your company name">
              <div class=" career-date-container">
                <div class="career-start-date-container">
                  <label class="label">Graduation Year</label>
                  <input type="date" id="js-intitution" name="start_date[]" class="start-date-button">
                </div>
                <div class="career-end-date-container">
                  <label class="label">Graduation Year</label>
                  <input type="date" id="js-intitution" name="end_date[]" class="end-date-button">
                </div>
              </div>
              <label class="label">Key Responsibilities</label>
              <textarea
                id="key_responsibilities"
                name="key_responsibilities[]"
                class="textarea-input"
                placeholder="e.g. Managed team workflows, coordinated client communications..."></textarea>
              <label class="label">Achivements</label>
              <textarea
                id="achievements"
                name="achievements[]"
                class="textarea-input"
                placeholder="e.g. best employee of the month, best employee of the year"></textarea>
              <button class="add-career-button">Add Another Career</button>
              <div class="buttons-container"><button class="back-button">Back</button><button class="next-button">Next</button></div>
            </div>
          </div>
          <div class="career-right-section">
            <div class="steps">Step 3 out of 7</div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Personal Info</div>
            </div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Education</div>
            </div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Career History</div>
            </div>
            <div class="steps-container">
              <div class="circle-outline"></div>
              <div class="step-name">Skills and Interests</div>
            </div>
            <div class="steps-container">
              <div class="circle-outline"></div>
              <div class="step-name">Summary</div>
            </div>
            <div class="steps-container">
              <div class="circle-outline"></div>
              <div class="step-name">Reference</div>
            </div>
            <div class="steps-container">
              <div class="circle-outline"></div>
              <div class="step-name">Review</div>
            </div>
          </div>
        </div>
      </div>

      <div class="SI-section">
        <div class="SI-container">
          <div class="SI-left-section">
            <div class="SI">
              <div class="title">Create a Resume</div>
              <label class="label">Skills</label>
              <textarea
                id="js-skills"
                name="skills"
                class="textarea-input"
                placeholder="e.g. HTML, CSS, JAVASCRIPT"></textarea>
              <label class="label">Interest(optional)</label>
              <textarea
                id="js-interests"
                name="interests"
                class="textarea-input"
                placeholder="e.g. running, sleeping, gaming"></textarea>
              <div class="buttons-container"><button class="back-button">Back</button><button class="next-button">Next</button></div>
            </div>
          </div>
          <div class="SI-right-section">
            <div class="steps">Step 4 out of 7</div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Personal Info</div>
            </div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Education</div>
            </div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Career History</div>
            </div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Skills and Interests</div>
            </div>
            <div class="steps-container">
              <div class="circle-outline"></div>
              <div class="step-name">Summary</div>
            </div>
            <div class="steps-container">
              <div class="circle-outline"></div>
              <div class="step-name">Reference</div>
            </div>
            <div class="steps-container">
              <div class="circle-outline"></div>
              <div class="step-name">Review</div>
            </div>
          </div>
        </div>
      </div>

      <div class="summary-section">
        <div class="summary-container">
          <div class="summary-left-section">
            <div class="summary">
              <div class="title">Create a Resume</div>
              <label class="label">Summary</label>
              <textarea
                id="js-summary"
                name="summary"
                class="summary-textarea-input"
                placeholder="This is your elevator pitch where you have just a few lines of text to sell yourself to a potential employer. Try to keep it brief and to the point. "></textarea>

              <div class="buttons-container"><button class="back-button">Back</button><button class="next-button">Next</button></div>
            </div>
          </div>
          <div class="summary-right-section">
            <div class="steps">Step 5 out of 7</div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Personal Info</div>
            </div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Education</div>
            </div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Career History</div>
            </div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Skills and Interests</div>
            </div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Summary</div>
            </div>
            <div class="steps-container">
              <div class="circle-outline"></div>
              <div class="step-name">Reference</div>
            </div>
            <div class="steps-container">
              <div class="circle-outline"></div>
              <div class="step-name">Review</div>
            </div>
          </div>
        </div>
      </div>

      <div class="reference-section">
        <div class="reference-container">
          <div class="reference-left-section">
            <div class="reference">
              <div class="title">Create a Resume</div>
              <div class="reference-radio-container">
                <label>
                  <input type="radio" name="reference-type" value="AUR" class="radio-button">
                  Available upon request
                </label>
              </div>
              <div class="reference-radio-container">
                <label>
                  <input type="radio" name="reference-type" value="ARD" class="radio-button">
                  Add reference details
                </label>
              </div>
              <label class="label">Reference Name</label>
              <input type="text" name="reference_name" class="input-button" placeholder="e.g. John Doe">

              <label class="label">Position</label>
              <input type="text" name="reference_position" class="input-button" placeholder="e.g. Manager">

              <label class="label">Company</label>
              <input type="text" name="reference_company" class="input-button" placeholder="e.g. ABC Corp">

              <label class="label">Contact Information</label>
              <input type="text" name="reference_contact" class="input-button" placeholder="e.g. 09123456789">


              <div class="buttons-container"><button class="back-button">Back</button><button class="next-button">Next</button></div>
            </div>
          </div>
          <div class="reference-right-section">
            <div class="steps">Step 6 out of 7</div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Personal Info</div>
            </div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Education</div>
            </div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Career History</div>
            </div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Skills and Interests</div>
            </div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Summary</div>
            </div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Reference</div>
            </div>
            <div class="steps-container">
              <div class="circle-outline"></div>
              <div class="step-name">Review</div>
            </div>
          </div>
        </div>
      </div>

      <div class="review-section">
        <div class="review-container">
          <div class="review-left-section">
            <div class="review">
              <div class="title">Create a Resume</div>
              <div class="personal-review-container">
                <div class="review-label">Personal Information</div>
                <div class="review-title">Full name: <span id="review-fullName" class="details"></span></div>
                <div class="review-title">Email: <span id="review-email" class="details"></span></div>
                <div class="review-title">Contact Number: <span id="review-contactNumber" class="details"></span></div>
                <div class="review-title">Street/House No.: <span id="review-street" class="details"></span></div>
                <div class="review-title">Barangay: <span id="review-barangay" class="details"></span></div>
                <div class="review-title">City/Municipality: <span id="review-city" class="details"></span></div>
                <div class="review-title">Province: <span id="review-province" class="details"></span></div>
              </div>
              <div class="education-review-container">
                <div class="review-label">Education</div>
                <div id="education-review-list">
                  <div class="review-title">Course/Qualifications: </div>
                  <div class="review-title">Institution Name: </div>
                  <div class="review-title">Graduation Year: </div>
                </div>
              </div>
              <div class="career-review-container">
                <div class="review-label">Career History</div>
                <div class="review-title">Position: </div>
                <div class="review-title">Company Name: </div>
                <div class="review-title">Start Date: </div>
                <div class="review-title">End Date: </div>
                <div class="review-title">Key Responsibilities: </div>
                <div class="review-title">Achievements: </div>
              </div>
              <div class="SI-review-container">
                <div class="review-label">Skills & Interests</div>
                <div class="review-title">Skills: <span id="review-skills" class="details"></div>
                <div class="review-title">Interests: <span id="review-interests" class="details"></div>
              </div>
              <div class="summary-review-container">
                <div class="review-label">Summary</div>
                <div class="review-title">About me: <span id="review-summary" class="details"></div>
              </div>
              <div class="reference-review-container">
                <div class="review-label">Reference</div>
                <div id="review-reference" class="review-title"></div>
              </div>
              <div class="buttons-container"><button class="back-button">Back</button><input type="submit" class="submit-button" value="GENERATE RESUME"></div>
            </div>
          </div>
          <div class="review-right-section">
            <div class="steps">Step 7 out of 7</div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Personal Info</div>
            </div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Education</div>
            </div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Career History</div>
            </div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Skills and Interests</div>
            </div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Summary</div>
            </div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Reference</div>
            </div>
            <div class="steps-container">
              <div class="circle-filled">
                <div class="circle-check">✔</div>
              </div>
              <div class="step-name">Review</div>
            </div>
          </div>
        </div>
      </div>

    </form>

    <script src="scripts/form.js?v=<?php echo time(); ?>"></script>
  </body>

  </html>