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
                    <div class="col-lg-6 mx-auto">
                        <div class="auth-form-light text-left">
                            <div class="brand-logo">
                                <img src="img/logo.png">
                            </div>
                            <h4>New here?</h4>
                            <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                            <form class="pt-3" id="RegisterForm">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="label-control">Name</label>
                                            <input type="text" class="form-control form-control-lg" name="FullName" placeholder="Your Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="label-control">Gender</label>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" name="Gender" id="Male" value="Male" checked>
                                                            Male
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" name="Gender" id="Female" value="Female">
                                                            Female
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="label-control">Mobile</label>
                                            <input type="text" class="form-control form-control-lg" name="Mobile" placeholder="Your Mobile">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="label-control">Email</label>
                                            <input type="text" class="form-control form-control-lg" name="Email" placeholder="Your Email">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 d-none">
                                        <div class="form-group">
                                            <label class="label-control">UserType</label>
                                            <select class="form-control form-control-lg" name="UserType">                                             
                                                <option selected>Student</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="label-control">Username</label>
                                            <input type="text" class="form-control form-control-lg" name="Username" placeholder="Choose a Username">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="label-control">Password</label>
                                            <input type="password" class="form-control form-control-lg" name="Password" placeholder="Strong Password">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="label-control">Confirm Password</label>
                                            <input type="password" class="form-control form-control-lg" name="CPassword" placeholder="Repeat the Password">
                                            <div class="invalid-feedback">
                                                Passwords doesn't match!
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input"> I agree to all Terms & Conditions
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <input type="hidden" name="registeruser" value="1">
                                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" href="login.php">SIGN UP</button>
                                </div>
                                <div class="text-center mt-4 font-weight-light"> Already have an account? <a href="login.php" class="text-primary">Login</a>
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
                var Mobile = $("input[name=Mobile]").val();
                var Email = $("input[name=Email]").val();
                var UserType = $("select[name=UserType]").val();
                var Username = $("input[name=Username]").val();
                var Password = $("input[name=Password]").val();
                var CPassword = $("input[name=CPassword]").val();
                if (!FullName || !Email || !Mobile || !Username || !Password || !CPassword || Password != CPassword) {
                    $('.form-control').addClass('is-invalid');
                } else {
                    var formData = new FormData(this);
                    $.ajax({
                        url: 'postuser.php',
                        type: 'POST',
                        datatype: 'json',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                    }).done(function(result) {
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