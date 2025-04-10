  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
      body {
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        font-family: Arial, sans-serif;
        margin: 0;
        background-position: center;
        background-size: cover;
        background-attachment: fixed;
      }

      body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(1, 52, 18, 0.73);
        z-index: -1;
      }

      .logo-image {
        width: 150px;
        margin-bottom: 20px;
        opacity: 0;
        animation: fadeIn 0.8s forwards;
      }

      @keyframes fadeIn {
        0% { opacity: 0; transform: scale(0.8); }
        100% { opacity: 1; transform: scale(1); }
      }

      .login-card {
        width: 90%;
        max-width: 400px;
        background: rgba(255, 255, 255, 0.85);
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.25);
        border: 2px solid rgba(255, 255, 255, 0.4);
        text-align: center;
      }

      .login-title {
        margin-bottom: 20px;
        font-weight: bold;
        font-size: 24px;
        color: #2d6a4f;
      }

      .form-control {
        border-radius: 10px;
        padding: 10px 15px;
        margin-bottom: 15px;
      }

      .btn-login {
        width: 100%;
        border-radius: 10px;
        background-color: #40916c;
        color: white;
        padding: 10px;
        font-weight: bold;
        transition: background-color 0.3s;
      }

      .btn-login:hover {
        background-color: #1b4332;
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

    <div class="text-center mb-4">
      <img src="<?= base_url('images/systemlogo.png') ?>" alt="Trash to Rice Logo" class="logo-image" />
    </div>

    <div class="login-card">
    <?php if (session()->getFlashdata('error')): ?>
              <div class="alert alert-danger">
                  <?= session()->getFlashdata('error') ?>
              </div>

            <?php elseif(session()->getFlashdata('msg')):?>
              <div class="alert alert-success">
                  <?= session()->getFlashdata('msg') ?>
              </div>

          <?php endif; ?>
      <div class="login-title">Login</div>
      <form action="<?= base_url('clientloginauth') ?>" method="post">
        <input type="text" class="form-control" name="email" id="email" placeholder="Enter Email" required>
        <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" required>
        <button type="submit" class="btn btn-login">Login</button>
        <a href="#" class="forgot-password" data-toggle="modal" data-target="#forgotPasswordModal" style="font-size:20px;">Forgot Password?</a>
        
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
              <div class="form-group">
                <label for="reset-email">Enter your email address</label>
                <input type="email" class="form-control" id="reset-email" name="email" placeholder="Enter email">
              </div>
              <a href="#" id="resetpassword" class="btn btn-login">Send Reset Code</a>
          </div>
        </div>
      </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
  $(document).ready(function() {
    $('#resetpassword').on('click', function(e) {
      e.preventDefault();

      const email = $('#reset-email').val().trim();

      if (!email) {
        alert("Please enter your email.");
        return;
      }

      const resetlink = "<?= base_url('/resetauth') ?>?email=" + encodeURIComponent(email);
      window.location.href = resetlink;
    });
  });
</script>

  
  </body>
  </html>