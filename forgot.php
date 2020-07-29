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
            <div class="auth-form-light text-left">
              <div class="brand-logo">
                <img src="img/logo.png">
              </div>
              <h4>Forgot Password</h4>
              <form class="pt-3" id="LoginForm">
                <div class="form-group">
                  <label>Email Id</label>
                  <input type="email" class="form-control form-control-lg" name="Email" id="Email" placeholder="Email Id">
                  <div class="invalid-feedback">Invalid Username</div>
                </div>
                <div class="mt-3">
                  <input type="hidden" name="checkemail" value="1">
                  <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" href="index.php">
                  Submit</button>
                </div>
                <div class="text-center mt-4 font-weight-light"> Remember Password? <a href="login.php" class="text-primary">Login</a>
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
        $('#Email').removeClass('is-invalid');
        var Email = $('#Email').val();
        if (!Email) {
          $('.form-control').addClass('is-invalid');
        } else {
          var formData = new FormData(this);
          $.ajax({
            url: 'helper/_login.php',
            type: 'POST',
            datatype: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: ShowLoadingBtn
          }).always(function(result) {
            HideLoadingBtn("Submit");
            console.log(result);
            if (result == "1") {
              alert('Check your mail for password reset.');
              window.location.href = "index.php";
            } else {              
              if (result == "2") {
                alert('Invalid Email');
              } else {
                alert(result);
              }
            }
          });
        }
      });

    });
  </script>
</body>

</html>