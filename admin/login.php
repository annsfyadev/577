<!--/*This is Admin Login Page -->


<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
  <?php require_once('inc/header.php') ?>
<body class="hold-transition login-page">
  <script>
    start_loader()
  </script>
  <style>
      body{
          width:calc(100%);
          height:calc(100%);
          /* background-image:url('<?= validate_image($_settings->info('cover')) ?>'); */
          background-repeat: no-repeat;
          background-size:cover;
      }
      #logo-img{
          width:15em;
          height:15em;
          object-fit:scale-down;
          object-position:center center;
      }
      #system_name{
        color:#fff;
        text-shadow: 3px 3px 3px #000;
      }
  </style>
   <?php if($_settings->chk_flashdata('success')): ?>
      <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
      </script>
    <?php endif;?>
  <center><img src="<?= validate_image($_settings->info('logo')) ?>" alt="System Logo" class="img-thumbnail rounded-circle" id="logo-img"></center>
<h1 class="text-center" id="system_name"><?= $_settings->info('name') ?></h1>
  <div class="clear-fix my-2"></div>
<div class="login-box">

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
