<?php 
include "../header_employer/companyProfile.html";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <style>
  :root {
    --primary-blue: #0c4a86;
    --text-dark: #333;
    --text-muted: #666;
    --bg-light: #f4f7f6;
  }

  body {
    background-color: var(--bg-light);
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
  }

  /* Banner Section */
  .profile-banner {
    display: flex;
    max-width: 1100px;
    margin: 40px auto;
    gap: 20px;
    padding: 0 20px;
  }

  .company-logo-card {
    background: linear-gradient(135deg, #4ef0b4 0%, #30cfd0 100%);
    width: 280px;
    height: 280px;
    border-radius: 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    color: white;
    text-align: center;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
  }

  .company-logo-card img { width: 120px; margin-bottom: 10px; }
  .company-logo-card h2 { margin: 0; font-size: 20px; font-weight: bold; }

  .info-banner {
    flex: 1;
    background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
    border-radius: 5px;
    padding: 40px;
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .info-banner h1 { font-size: 38px; margin: 0; font-style: italic; font-weight: 800; }
  .info-banner p.tagline { font-size: 16px; margin: 10px 0 30px 0; opacity: 0.9; }
  
  .contact-details p { margin: 5px 0; font-size: 14px; }
  .contact-details strong { font-weight: 600; }

  /* Content Sections */
  .content-container {
    max-width: 1000px;
    margin: 0 auto 60px;
    padding: 0 20px;
  }

  .section-title {
    color: var(--text-dark);
    font-size: 26px;
    text-decoration: underline;
    margin: 40px 0 10px 0;
  }

  .stats-row { color: var(--text-muted); font-size: 15px; margin-bottom: 20px; }
  
  .company-overview-text, .reviews-text {
    color: var(--text-muted);
    line-height: 1.6;
    font-size: 16px;
  }

  .perks-list {
    list-style: none;
    padding: 0;
    margin-top: 20px;
  }

  .perks-list li {
    position: relative;
    padding-left: 20px;
    margin-bottom: 10px;
    color: var(--text-muted);
  }

  .perks-list li::before {
    content: "•";
    position: absolute;
    left: 0;
    color: var(--text-muted);
  }
</style>
</head>
<body>
   

<div class="profile-banner">
  <div class="company-logo-card">
    <img src="/CAREERPATH/assets/images/airplane.png" alt="Plane Icon">
    <h2>Skyline Apps Innovations</h2>
  </div>

  <div class="info-banner">
    <h1>Skyline Apps Innovation</h1>
    <p class="tagline">"Recognized for excellence in mobile app innovation and cross-platform development"</p>
    
    <div class="contact-details">
      <p><strong>Location:</strong> Urdaneta City</p>
      <p><strong>Email us:</strong> skylineappsinnovationcorp2025@gmail.com</p>
      <p><strong>Contact us:</strong> 123-3456-6789</p>
    </div>
  </div>
</div>

<div class="content-container">
  <h2 class="section-title">Skyline Apps Innovation</h2>
  <div class="stats-row">
    ⭐ 4.4 · 187 reviews<br>
    Industry: Mobile App Development & Digital Solutions<br>
    Company size: 201–500 employees<br>
    Primary location: Quezon City, Metro Manila
  </div>

  <h3 style="color: var(--text-dark);">Company Overview</h3>
  <p class="company-overview-text">
    Skyline Apps Innovation is a creative and future-focused software development company specializing in mobile and web applications tailored for diverse global clients. We are passionate about designing user-friendly, scalable, and secure digital platforms that transform the way businesses and individuals connect in today's digital-first world. 
  </p>

  <h3 style="color: var(--text-dark); margin-top: 40px;">Reviews Overview</h3>
  <div class="reviews-text">
    4.4 rating (187 ratings in total)<br>
    89% rate workplace culture as positive<br>
    85% recommend this employer to friends<br><br>
    What it's like working at Skyline Apps Innovation:<br>
    Employees appreciate the collaborative work culture, opportunities to develop innovative apps, and exposure to international projects. Career development programs, supportive mentors, and regular training are highly valued. [cite: 11]
  </div>

  <h3 style="color: var(--text-dark); margin-top: 40px;">Perks and Benefits</h3>
  <ul class="perks-list">
    <li>Comprehensive medical, dental, and vision coverage [cite: 11]</li>
    <li>Learning support: sponsored training, workshops & certifications [cite: 11]</li>
    <li>Performance bonuses and annual salary adjustments [cite: 11]</li>
    <li>Vacation and sick leave credits above industry standard [cite: 11]</li>
    <li>Hybrid/flexible work setup (work-from-home options available) [cite: 11]</li>
    <li>Company-issued laptops, mobile devices, and licensed tools [cite: 11]</li>
  </ul>
</div>
</body>
</html>