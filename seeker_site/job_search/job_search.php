<?php
include('../header/jobSearchHeader.html');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    .search-container {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 20px;
      height: 100px;
      background-color: #0c4a86;
      padding-left: 50px;
      padding-right: 50px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);

    }


    .search-position {
      width: 780px;
      height: 50px;
      border: none;
      border-radius: 7px;
      padding-left: 20px;
      font-size: 16px;

    }

    .search-location {
      width: 380px;
      height: 50px;
      border: none;
      border-radius: 7px;
      padding-left: 20px;
      font-size: 16px;
    }

    .search-button {
      height: 50px;
      width: 150px;
      border: none;
      border-radius: 7px;
      color: #0c4a86;
      background-color: #f9a826;
      font-size: 16px;
      font-weight: bolder;
      cursor: pointer;
    }

    .search-button:hover {
      opacity: 0.8;
    }

    .search-button:active {
      opacity: 0.6;
    }

    input::placeholder {
      font-size: 16px;
    }

    .main-content {
      margin-top: 20px;
      padding-left: 50px;
      padding-right: 50px;
      display: flex;
      flex-direction: row;
      gap: 50px;
      align-items: flex-start;
    }

    .body-left-section {
      flex: 1;
      display: flex;
      flex-direction: column;
      background-color: white;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
      padding-bottom: 20px;
      border-radius: 10px;
    }

    .body-right-section {
      flex: 6;
      background-color: orange;
    }

    .job-search-filter-container {
      background-color: #0c4a86;
      font-size: 16px;
      color: white;
      padding: 20px;
      padding-top: 30px;
      padding-bottom: 30px;
      font-weight: bold;
      display: flex;
      align-items: center;
      justify-content: center;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }

    .filter-by-skills {
      font-size: 16px;
      color: black;
      margin: 20px;
      margin-bottom: 15px;
      margin-top: 15px;
      font-weight: bold;
    }

    .select-3-skills {
      font-size: 16px;
      color: #9a9a9a;
      margin-left: 20px;
      margin-right: 20px;
      margin-bottom: 20px;
    }

    .search-skills {
      border: 1px solid #0c4a86;
      border-radius: 5px;
      background-color: #f5f5f5;
      height: 50px;

      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
      padding-left: 20px;
      font-size: 16px;
      margin-left: 20px;
      margin-right: 20px;
      margin-bottom: 20px;
    }

    .result-button {
      margin-left: 20px;
      margin-right: 20px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
      height: 50px;
      border-radius: 30px;
      border: 1px solid #0c4a86;
      font-size: 16px;
      font-weight: bold;
      color: #0c4a86;
    }

    .result-button:hover {
      background-color: #0c4a86;
      color: white;
    }

    .result-button:active {
      opacity: 0.6;
    }

    .job-type-container {
      margin-left: 20px;
      margin-bottom: 20px;
      display: flex;
      flex-direction: column;
    }

    .custom-radio {
      display: flex;
      align-items: center;
      cursor: pointer;
      font-size: 16px;
      font-weight: 400;
      color: #9a9a9a;
      margin-bottom: 10px;
      user-select: none;
    }

    .custom-radio input[type="radio"] {
      display: none;
    }

    .custom-radio-box {
      width: 20px;
      height: 20px;
      border: 2px solid #9a9a9a;
      border-radius: 4px;
      margin-right: 10px;
      background: #fff;
      box-sizing: border-box;
      position: relative;
      transition: border-color 0.2s;
    }

    .custom-radio input[type="radio"]:checked+.custom-radio-box {
      background: #0c4a86;
      border-color: #0c4a86;
    }
  </style>
</head>

<body>
  <div class="search-container">
    <div class="search-position-container">
      <input type="text" name="search-position" class="search-position" placeholder="Search for a job title or company">
    </div>
    <div class="search-location-container">
      <input type="text" name="search-location" class="search-location" placeholder="Search for a location">
    </div>
    <div class="search-button-container">
      <button class="search-button">FIND</button>
    </div>
  </div>

  <div class="main-content">
    <div class="body-left-section">
      <div class="job-search-filter-container">
        <div class="text">JOB SEARCH</div>
      </div>
      <div class="filter-by-skills">Filter by skills:</div>
      <div class="select-3-skills">Select up to 3 skills</div>
      <input type="text" class="search-skills" name="search-skills" placeholder="Search for skills">
      <div class="job-type-container">
        <label class="custom-radio">
          <input type="radio" name="job-type" value="gig">
          <span class="custom-radio-box"></span>
          GIG
        </label><br>
        <label class="custom-radio">
          <input type="radio" name="job-type" value="part-time">
          <span class="custom-radio-box"></span>
          PART-TIME
        </label><br>
        <label class="custom-radio">
          <input type="radio" name="job-type" value="full-time">
          <span class="custom-radio-box"></span>
          FULL-TIME
        </label>
      </div>
      <button class="result-button">RESULT</button>

    </div>
    <div class="body-right-section"></div>
  </div>
</body>

</html>