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
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 col-md-6 col-12 ml-auto">
                        <div class="auth-form-light text-left">
                            <div class="brand-logo">
                                <img src="img/logo.png">
                            </div>
                            <h4>Student Registration</h4>
                            <form class="pt-3" id="RegisterForm">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="label-control">Name</label>
                                            <input type="text" class="form-control form-control-lg" name="FullName" placeholder="Your Name">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="label-control">Email</label>
                                            <input type="text" class="form-control form-control-lg" name="Email" placeholder="Your Email">
                                        </div>
                                    </div>                                   
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="label-control">Password</label>
                                            <input type="password" class="form-control form-control-lg" name="Password" placeholder="Strong Password">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="label-control">Confirm Password</label>
                                            <input type="password" class="form-control form-control-lg" name="CPassword" placeholder="Repeat the Password">
                                            <div class="invalid-feedback">
                                                Passwords doesn't match!
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <input type="hidden" name="registeruser" value="1">
                                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" href="login.php">Register</button>
                                </div>
                                <div class="text-center mt-4 font-weight-light"> Already have an account? <a href="login.php">Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <script src="js/base.js"></script>
    <script src="js/app.js"></script>
    <script>
        $(function() {          

            $('#RegisterForm').on('submit', function(e) {
                e.preventDefault();
                var FullName = $("input[name=FullName]").val();
                var Email = $("input[name=Email]").val();
                var Password = $("input[name=Password]").val();
                var CPassword = $("input[name=CPassword]").val();
                if (!FullName || !Email || !Password || !CPassword || Password != CPassword) {
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
                        HideLoadingBtn("Register");
                        console.log(result);
                        if (result == "1") {
                            alert('User Registered Successfully!');
                            window.location.href = "login.php";
                        } else {
                            console.log(result);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>