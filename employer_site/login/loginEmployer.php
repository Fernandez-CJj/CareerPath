<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CareerPath | Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
    }

    .login-wrapper {
      display: flex;
      height: 100vh;
    }

    /* LEFT SIDE */
    .login-left {
      flex: 1;
      background-color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 50px;
    }

    .login-left img {
      width: 500px;
      max-width: 100%;
    }

    .login-left p {
      margin-top: 20px;
      font-size: 16px;
      color: #333;
      text-align: center;
      max-width: 400px;
      line-height: 1.6;
    }

    /* RIGHT SIDE */
    .login-right {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #ffffff;
    }

    .login-card {
      width: 360px;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 40px;
    }

    .logo img {
      width: 80%;
    }

  
    .form-group {
      display: flex;
      flex-direction: column;
      margin-bottom: 20px;
    }

    .form-group label {
      font-size: 14px;
      font-weight: 600;
      color: #0c4a86;
      margin-bottom: 5px;
    }

    .form-group input {
      height: 45px;
      padding: 0 15px;
      border: 2px solid #0c4a86;
      border-radius: 5px;
      font-size: 14px;
    }

    .form-group input:focus {
      outline: none;
      box-shadow: 0 0 0 2px rgba(12, 74, 134, 0.2);
    }

    .options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 12px;
      margin-bottom: 25px;
      color: #0c4a86;
    }

    .options a {
      text-decoration: none;
      color: #0c4a86;
      font-weight: 600;
    }

    .options a:hover {
      text-decoration: underline;
    }

    .login-btn {
      width: 100%;
      height: 45px;
      background-color: #0c4a86;
      color: white;
      border: none;
      border-radius: 5px;
      font-weight: 600;
      cursor: pointer;
      transition: opacity 0.3s ease;
    }

    .login-btn:hover {
      opacity: 0.85;
    }

    .signup-text {
      margin-top: 20px;
      font-size: 12px;
      text-align: center;
      color: #333;
    }

    .signup-text a {
      color: #0c4a86;
      font-weight: 600;
      text-decoration: none;
    }

    .signup-text a:hover {
      text-decoration: underline;
    }

    /* RESPONSIVE */
    @media (max-width: 900px) {
      .login-wrapper {
        flex-direction: column;
      }

      .login-left {
        display: none;
      }
    }
  </style>
</head>

<body>

  <div class="login-wrapper">

    <!-- LEFT SECTION -->
    <div class="login-left">
      <img src="/CAREERPATH/assets/images/login-illustration.png" alt="Illustration">
      <p>
        “Your smart companion for building professional resumes and discovering job opportunities tailored to your skills and goals.”
      </p>
    </div>

    <!-- RIGHT SECTION -->
    <div class="login-right">
      <div class="login-card">

        <div class="logo">
          <img src="/CAREERPATH/assets/images/logo.png">
         
        </div>

        <form>
          <div class="form-group">
            <label>Email</label>
            <input type="email" placeholder="Enter your email" required>
          </div>

          <div class="form-group">
            <label>Password</label>
            <input type="password" placeholder="Enter your password" required>
          </div>

       

          <button type="submit" class="login-btn">Sign In</button>
        </form>

        <div class="signup-text">
          Don’t have an account? <a href="register.html">Sign up free!</a>
        </div>

      </div>
    </div>

  </div>

</body>
</html>
