<!--/*This is Admin Login Page -->


<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
  <?php require_once('inc/header.php') ?>
<body class="hold-transition login-page">
  <script>
    start_loader()
  </script>
  
  <!-- Card containing the login form -->
  <div class="card card-outline card-primary" style="max-width: 500px; margin: 0 auto; padding: 40px;">
    <div class="card-header text-center">
      <a class="h1" style="font-size: 1.8em;">Admin Login</a>
    </div>
    
    <div class="card-body">
      <form id="login-frm" action="" method="post">
        
        <!-- Username input field -->
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" autofocus placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <!-- Password input field -->
        <div class="input-group mb-4">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <!-- Center the Log In button -->
        <div class="row justify-content-center mb-4">
          <div class="col-12 d-flex justify-content-center">
            <button type="submit" class="btn btn-primary" style="font-size: 0.8em; padding: 10px 20px; width: 50%; border-radius: 25px;">Log In</button>
          </div>
        </div>

        <!-- Back to site link -->
        <div class="row justify-content-center">
          <div class="col-12 text-center">
            <a href="<?= base_url ?>" style="font-size: 0.8em; color: #333;">Back to Site</a>
          </div>
        </div>

      </form>
    </div>
  </div>

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>

  <script>
    $(document).ready(function(){
      end_loader();
    })
  </script>
</body>
</html>
