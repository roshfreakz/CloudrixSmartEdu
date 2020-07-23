<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Cloudrix SmartEdu</title>
  <link rel="shortcut icon" href="img/logo-mini.png" />
  <link rel="stylesheet" href="css/mdi.min.css">
  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/custom.css">
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row flex-grow">
          <div class="col-lg-4 col-md-6 col-12 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo">
                <img src="img/logo.png">
              </div>
              <h4>Hello! let's get started</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form class="pt-3" id="LoginForm">
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" class="form-control form-control-lg" name="Username" id="Username" placeholder="Username">
                  <div class="invalid-feedback">Invalid Username</div>
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control form-control-lg" name="Password" id="Password" placeholder="Password">
                  <div class="invalid-feedback">Invalid Password</div>
                </div>
                <div class="mt-3">
                  <input type="hidden" name="checklogin" value="1">
                  <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" href="index.php">SIGN IN</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input"> Keep me signed in </label>
                  </div>
                  <a href="#" class="auth-link text-black">Forgot password?</a>
                </div>
                <div class="text-center mt-4 font-weight-light"> Don't have an account? <a href="register.php" class="text-primary">Create</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="js/base.js"></script>
  <script src="js/app.js"></script>
  <script>
    $(function() {
      $('#LoginForm').on('submit', function(e) {
        e.preventDefault();
        $('#Username').removeClass('is-invalid');
        $('#Password').removeClass('is-invalid');
        var Username = $('#Username').val();
        var Password = $('#Password').val();
        if (!Username || !Password) {
          $('.form-control').addClass('is-invalid');
        } else {
          var formData = new FormData(this);
          $.ajax({
            url: 'helper/postuser.php',
            type: 'POST',
            datatype: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
          }).done(function(result) {
            if (result == "1") {
              alert('Login Success!');
              window.location.href = "index.php";
            } else {
              console.log(result);
              alert('Login Failed!');
              if (result == "2") {
                $('#Password').addClass('is-invalid');
              } else if (result == "3") {
                $('#Username').addClass('is-invalid');
              }
            }
          });
        }
      });
    });
  </script>
</body>

</html>