<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trash to Bigas Login</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      position: relative;
      display: flex;
      flex-direction: column; /* Stack the logo and form vertically */
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: Arial, sans-serif;
      margin: 0;
      background-image: url('<?= base_url('images/cityhall.jpg') ?>'); /* Adjust path if needed */
      background-position: center;
      background-size: cover;
      background-attachment: fixed;
    }

    /* Purple overlay */
    body::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(1, 52, 18, 0.73); /* Semi-transparent purple */
      z-index: -1; /* Send the overlay behind the content */
    }

    .logo-image {
      width: 200px; /* Resize the logo to make it smaller */
      margin-bottom: 30px; /* Space between logo and login form */
      opacity: 0; /* Start with the logo hidden */
      animation: fadeIn 0.8s forwards; /* Apply fadeIn animation on page load */
    }

    /* Define the fade-in animation */
    @keyframes fadeIn {
      0% {
        opacity: 0; /* Start hidden */
        transform: scale(0.8); /* Slightly smaller */
      }
      100% {
        opacity: 1; /* Fully visible */
        transform: scale(1); /* Normal size */
      }
    }

    .login-card {
      max-width: 500px;
      width: 100%;
      background: rgba(255, 255, 255, 0.75); /* Slight transparency for the card */
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.25);
      border: 2px solid rgba(255, 255, 255, 0.4);
      text-align: center;
      transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .login-title {
      text-align: center;
      margin-bottom: 30px;
      font-weight: bold;
      font-size: 26px;
      color: #2d6a4f; /* Dark green */
    }

    .form-control {
      border-radius: 10px;
      padding: 10px 15px;
    }

    .btn-login {
      width: 100%;
      border-radius: 10px;
      background-color: #40916c; /* Medium green */
      color: white;
      padding: 10px;
      font-weight: bold;
      transition: background-color 0.3s;
    }

    .btn-login:hover {
      background-color: #1b4332; /* Darker green */
    }

    .forgot-password {
      display: block;
      text-align: right;
      margin-top: 10px;
      font-size: 14px;
      color: #40916c;
      text-decoration: none;
    }

    .forgot-password:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <!-- Logo above the form, centered -->
  <div class="text-center mb-4">
    <img src="<?= base_url('images/systemlogo.png') ?>" alt="Trash to Rice Logo" class="logo-image" />
  </div>

  <!-- Login Card -->
  <div class="login-card">
    <div class="login-title">Trash to Bigas Login</div>
  <form action="<?= base_url('auth/login')?>" method="post">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username"id="username" placeholder="Enter username">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Enter password">
      </div>
      <button type="submit" class="btn btn-login">Login</button>
      <a href="#" class="forgot-password" data-toggle="modal" data-target="#forgotPasswordModal">Forgot Password?</a>
    </form>
  </div>

  <!-- Forgot Password Modal -->
  <div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="reset-email">Enter your email address</label>
              <input type="email" class="form-control" id="reset-email" placeholder="Enter email">
            </div>
            <button type="submit" class="btn btn-login">Send Reset Code</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
