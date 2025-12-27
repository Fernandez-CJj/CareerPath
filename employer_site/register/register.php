<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
   

body {
      font-family: Arial;
  
      margin: 0;
      height: 1500px;
    }
.form-container {
  background-color: white;
  width: 520px;
  margin: 80px auto;
  padding: 40px 50px;
  
 
}

.form-container h2 {
  color: #0c4a86;
  font-size: 30px;
  font-weight: 600;
  margin-bottom: 30px;
  text-align: center;
}

.form-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 25px;
}

.form-group label {
  color: #0c4a86;
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 5px;
}

.form-group input,
.form-group select {
  border: 2px solid #0c4a86;
  border-radius: 5px;
  height: 50px;
  padding: 0 20px;
  font-size: 16px;
}

.form-group input:focus,
.form-group select:focus {
  outline: none;
  box-shadow: 0 0 0 2px rgba(12, 74, 134, 0.2);
}

.btn-primary {
  background-color: #0c4a86;
  border: none;
  color: white;
  font-size: 16px;
  font-weight: 600;
  padding: 15px 0;
  border-radius: 5px;
  cursor: pointer;
  transition: opacity 0.3s ease;
}

.btn-primary:hover {
  opacity: 0.8;
}

.form-footer {
  margin-top: 20px;
  text-align: center;
  font-size: 15px;
  color: #0c4a86;
}

.form-footer a {
  color: #0c4a86;
  font-weight: 600;
  text-decoration: none;
}

.form-footer a:hover {
  text-decoration: underline;
}

.right-section {
  position: absolute;
  top: 20px;
  right: 30px;
}
    </style>
</head>
<body>
    <div class="right-section">
      <img src="../../assets/images/logo.png" />
    </div>
        <!-- Register Form -->
    <div class="form-container">
        <h2>Create Account</h2>
        <form >
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>
            </div>
            <div class="form-group">
                <label for="contactNumber">Contact Number</label>
                <input type="text" id="contactNumber" name="contactNumber" placeholder="Enter your contact number" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
          
             
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Create a password (min 6 characters)" required minlength="6">
            </div>
            <div class="form-group">
                <label for="confirmpassword">Confirm Password</label>
                <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm your password" required minlength="6">
            </div>
           
            
            <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">Create Account</button>
        </form>
        <p class="form-footer">
            Already have an account? <a href="login.html">Login here</a>
        </p>
    </div>
</body>
</html>