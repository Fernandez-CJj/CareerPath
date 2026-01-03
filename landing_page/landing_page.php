<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CareerPath - Your Smart Companion for Career Success</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      color: #333;
      line-height: 1.6;
    }

    /* Navigation */
    .navbar {
      background: white;
      padding: 20px 50px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logo img {
      height: 60px;
    }

    .nav-buttons {
      display: flex;
      gap: 15px;
    }

    .btn {
      padding: 12px 30px;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      font-size: 15px;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-block;
    }

    .btn-login {
      background: white;
      color: #0c4a86;
      border: 2px solid #0c4a86;
    }

    .btn-login:hover {
      background: #0c4a86;
      color: white;
    }

    .btn-primary {
      background: #0c4a86;
      color: white;
    }

    .btn-primary:hover {
      background: #083560;
    }

    /* Hero Section */
    .hero {
      background: linear-gradient(135deg, #0c4a86 0%, #1565c0 100%);
      color: white;
      padding: 100px 50px;
      text-align: center;
    }

    .hero h1 {
      font-size: 48px;
      margin-bottom: 20px;
      font-weight: 700;
    }

    .hero .tagline {
      font-size: 22px;
      margin-bottom: 40px;
      opacity: 0.95;
    }

    .hero-buttons {
      display: flex;
      gap: 20px;
      justify-content: center;
      flex-wrap: wrap;
    }

    .btn-hero {
      padding: 15px 40px;
      font-size: 18px;
    }

    .btn-seeker {
      background: white;
      color: #0c4a86;
    }

    .btn-seeker:hover {
      background: #f0f0f0;
    }

    .btn-employer {
      background: #28a745;
      color: white;
    }

    .btn-employer:hover {
      background: #218838;
    }

    /* Features Section */
    .features {
      padding: 80px 50px;
      background: #f8f9fa;
    }

    .features h2 {
      text-align: center;
      font-size: 36px;
      color: #0c4a86;
      margin-bottom: 50px;
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 40px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .feature-card {
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .feature-card:hover {
      transform: translateY(-10px);
    }

    .feature-icon {
      font-size: 50px;
      margin-bottom: 20px;
    }

    .feature-card h3 {
      color: #0c4a86;
      font-size: 24px;
      margin-bottom: 15px;
    }

    .feature-card p {
      color: #666;
      font-size: 16px;
    }

    /* User Types Section */
    .user-types {
      padding: 80px 50px;
      background: white;
    }

    .user-types h2 {
      text-align: center;
      font-size: 36px;
      color: #0c4a86;
      margin-bottom: 50px;
    }

    .types-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
      gap: 40px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .type-card {
      background: linear-gradient(135deg, #0c4a86 0%, #1565c0 100%);
      color: white;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    }

    .type-card.employer {
      background: linear-gradient(135deg, #28a745 0%, #34c759 100%);
    }

    .type-card h3 {
      font-size: 28px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .type-card ul {
      list-style: none;
      margin: 20px 0;
    }

    .type-card ul li {
      padding: 12px 0;
      font-size: 16px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .type-card ul li::before {
      content: "✓";
      font-weight: bold;
      font-size: 20px;
    }

    .type-card .btn {
      margin-top: 20px;
      width: 100%;
      background: white;
      color: #0c4a86;
    }

    .type-card.employer .btn {
      color: #28a745;
    }

    /* How It Works Section */
    .how-it-works {
      padding: 80px 50px;
      background: #f8f9fa;
    }

    .how-it-works h2 {
      text-align: center;
      font-size: 36px;
      color: #0c4a86;
      margin-bottom: 50px;
    }

    .steps {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .step {
      text-align: center;
      padding: 30px;
    }

    .step-number {
      width: 60px;
      height: 60px;
      background: #0c4a86;
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      font-weight: bold;
      margin: 0 auto 20px;
    }

    .step h3 {
      color: #0c4a86;
      margin-bottom: 15px;
      font-size: 20px;
    }

    .step p {
      color: #666;
      font-size: 15px;
    }

    /* Stats Section */
    .stats {
      padding: 60px 50px;
      background: #0c4a86;
      color: white;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 40px;
      max-width: 1200px;
      margin: 0 auto;
      text-align: center;
    }

    .stat-item h3 {
      font-size: 48px;
      margin-bottom: 10px;
    }

    .stat-item p {
      font-size: 18px;
      opacity: 0.9;
    }

    /* CTA Section */
    .cta {
      padding: 80px 50px;
      background: white;
      text-align: center;
    }

    .cta h2 {
      font-size: 36px;
      color: #0c4a86;
      margin-bottom: 20px;
    }

    .cta p {
      font-size: 20px;
      color: #666;
      margin-bottom: 40px;
    }

    /* Footer */
    .footer {
      background: #1a1a1a;
      color: white;
      padding: 40px 50px;
      text-align: center;
    }

    .footer p {
      margin: 10px 0;
      opacity: 0.8;
    }

    @media (max-width: 768px) {
      .navbar {
        padding: 15px 20px;
      }

      .hero h1 {
        font-size: 32px;
      }

      .hero .tagline {
        font-size: 18px;
      }

      .features,
      .user-types,
      .how-it-works,
      .cta {
        padding: 50px 20px;
      }

      .types-container {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>
  <!-- Navigation -->
  <nav class="navbar">
    <div class="logo">
      <img src="../assets/images/logo.png" alt="CareerPath Logo">
    </div>
    <div class="nav-buttons">
      <a href="../seeker_site/login_modules/login.php" class="btn btn-login">Login</a>
      <a href="../seeker_site/login_modules/register.php" class="btn btn-primary">Sign Up</a>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <h1>Welcome to CareerPath</h1>
    <p class="tagline">Your smart companion for building professional resumes and discovering job opportunities tailored to your skills and goals.</p>
    <div class="hero-buttons">
      <a href="../seeker_site/login_modules/register.php" class="btn btn-hero btn-seeker">I'm Looking for a Job</a>
      <a href="../employer_site/login_modules_employer/register.php" class="btn btn-hero btn-employer">I'm Hiring</a>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features">
    <h2>What Makes CareerPath Special?</h2>
    <div class="features-grid">
      <div class="feature-card">
        <div class="feature-icon">📝</div>
        <h3>Smart Resume Builder</h3>
        <p>Create professional, ATS-friendly resumes with our intelligent builder. Multiple templates, real-time preview, and PDF export.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">🔍</div>
        <h3>Advanced Job Search</h3>
        <p>Find opportunities that match your skills. Filter by location, job type, salary, and more. Apply with one click.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">📊</div>
        <h3>Career Insights</h3>
        <p>Track your applications, get personalized recommendations, and stay organized throughout your job search journey.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">💼</div>
        <h3>For Employers</h3>
        <p>Post jobs, manage applications, and find the perfect candidates. Simple tools to streamline your hiring process.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">🎯</div>
        <h3>Skill Matching</h3>
        <p>Our algorithm matches job seekers with positions that align with their skills and experience for better fit.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">🚀</div>
        <h3>Fast & Easy</h3>
        <p>Simple interface, intuitive design. Get started in minutes and focus on what matters - your career.</p>
      </div>
    </div>
  </section>

  <!-- User Types Section -->
  <section class="user-types">
    <h2>Choose Your Path</h2>
    <div class="types-container">
      <div class="type-card">
        <h3>👤 For Job Seekers</h3>
        <ul>
          <li>Create stunning professional resumes</li>
          <li>Browse active job postings</li>
          <li>Apply to jobs instantly with your resume</li>
          <li>Track your application status</li>
          <li>Receive updates from employers</li>
          <li>Build your professional profile</li>
          <li>Save and download multiple resume versions</li>
        </ul>
        <a href="../seeker_site/login_modules/register.php" class="btn">Get Started as Job Seeker</a>
      </div>
      <div class="type-card employer">
        <h3>🏢 For Employers</h3>
        <ul>
          <li>Post job openings easily</li>
          <li>Manage all your job listings</li>
          <li>Review applications efficiently</li>
          <li>Contact qualified candidates</li>
          <li>Build your company profile</li>
          <li>Track hiring progress</li>
          <li>Find the best talent quickly</li>
        </ul>
        <a href="../employer_site/login_modules_employer/register.php" class="btn">Get Started as Employer</a>
      </div>
    </div>
  </section>

  <!-- How It Works Section -->
  <section class="how-it-works">
    <h2>How It Works</h2>
    <div class="steps">
      <div class="step">
        <div class="step-number">1</div>
        <h3>Create Your Account</h3>
        <p>Sign up in seconds as a job seeker or employer. It's completely free to get started.</p>
      </div>
      <div class="step">
        <div class="step-number">2</div>
        <h3>Build Your Profile</h3>
        <p>Job seekers: Create your resume. Employers: Set up your company profile and post jobs.</p>
      </div>
      <div class="step">
        <div class="step-number">3</div>
        <h3>Connect & Apply</h3>
        <p>Seekers browse and apply to jobs. Employers review applications and contact candidates.</p>
      </div>
      <div class="step">
        <div class="step-number">4</div>
        <h3>Success!</h3>
        <p>Land your dream job or find the perfect candidate. Track everything in one place.</p>
      </div>
    </div>
  </section>

  <!-- Stats Section -->
  <section class="stats">
    <div class="stats-grid">
      <div class="stat-item">
        <h3>100%</h3>
        <p>Free to Use</p>
      </div>
      <div class="stat-item">
        <h3>24/7</h3>
        <p>Available</p>
      </div>
      <div class="stat-item">
        <h3>∞</h3>
        <p>Opportunities</p>
      </div>
      <div class="stat-item">
        <h3>🎯</h3>
        <p>Career Success</p>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="cta">
    <h2>Ready to Take the Next Step?</h2>
    <p>Join CareerPath today and unlock your career potential.</p>
    <div class="hero-buttons">
      <a href="../seeker_site/login_modules/register.php" class="btn btn-hero btn-seeker">Sign Up as Job Seeker</a>
      <a href="../employer_site/login_modules_employer/register.php" class="btn btn-hero btn-employer">Sign Up as Employer</a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <p>&copy; 2026 CareerPath. All rights reserved.</p>
    <p>Your smart companion for career success.</p>
  </footer>
</body>

</html>