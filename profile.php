<!DOCTYPE html>
<html lang="en">
<?php require_once('_header.php'); ?>

<body>
    <div class="container-scroller">
        <?php require_once('_navbar.php'); ?>
        <div class="container-fluid page-body-wrapper">
            <?php require_once('_sidebar.php'); ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                                <i class="mdi mdi-contacts menu-icon"></i>
                            </span>
                            My Profile
                        </h3>
                        <button type="button" class="btn btn-gradient-primary" onclick="ToggleChangePassword()">Change Password</button>
                    </div>
                    <div class="row" id="divChangePassword" style="display: none;">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <form class="form-sample" id="ChangePasswordForm">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="label">Password</label>
                                                    <input type="password" class="form-control" id="Password" name="Password" placeholder="Strong Password" />
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="label">Confirm Password</label>
                                                    <input type="password" class="form-control" id="CPassword" placeholder="Confirm Password" />
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-right">
                                                <label class="d-block">&nbsp;</label>
                                                <input type="hidden" name="UserId" value="<?php echo $_SESSION["UserId"]; ?>">
                                                <input type="hidden" name="changepassword" value="1">
                                                <button type="submit" class="btn btn-gradient-success">Change</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="divAddUser">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">

                                    <form class="form-sample" id="UpdateUserForm">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Full Name</label>
                                                    <input type="text" class="form-control" name="FullName" placeholder="Your Full Name" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Gender</label>
                                                    <div class="row">
                                                        <div class="col-lg-4 col-12">
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input type="radio" class="form-check-input" name="Gender" id="Male" value="Male" checked>
                                                                    Male
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-12">
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label">Email</label>
                                                    <input class="form-control" name="Email" placeholder="Your Email" disabled />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label">Mobile</label>
                                                    <input class="form-control" name="Mobile" placeholder="Your Mobile" />
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <input type="hidden" name="UserId" value="<?php echo $_SESSION["UserId"]; ?>">
                                                <input type="hidden" name="updateuser" value="1">
                                                <button type="submit" class="btn btn-gradient-success">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once('_footer.php'); ?>
    <script>
        $(function() {
            DoGetUserDetailsList();
        });

        $(function() {
            $('#UpdateUserForm').on('submit', function(e) {
                e.preventDefault();
                $('#UpdateUserForm .form-control').removeClass('is-invalid');
                var FullName = $("input[name=FullName]").val();
                var Mobile = $("input[name=Mobile]").val();
                if (!FullName || !Mobile) {
                    $('#UpdateUserForm .form-control').addClass('is-invalid');
                } else {
                    var formData = new FormData(this);
                    $.ajax({
                        url: 'helper/_user.php',
                        type: 'POST',
                        datatype: 'json',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                    }).done(function(result) {
                        if (result == "1") {
                            DoGetUserDetailsList();
                            alert("User details Updated");
                        } else {
                            console.log(result);
                        }
                    });
                }
            });
        });

        $(function() {
            $('#ChangePasswordForm').on('submit', function(e) {
                e.preventDefault();
                $('#ChangePasswordForm .form-control').removeClass('is-invalid');
                var Password = $("#Password").val();
                var CPassword = $("#CPassword").val();
                if (!Password || !CPassword || Password != CPassword) {
                    $('#ChangePasswordForm .form-control').addClass('is-invalid');
                } else {
                    var formData = new FormData(this);
                    $.ajax({
                        url: 'helper/_user.php',
                        type: 'POST',
                        datatype: 'json',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                    }).done(function(result) {
                        if (result == "1") {
                            $('#ChangePasswordForm .form-control').val('');
                            ToggleChangePassword();
                            alert("Password Updated");
                        } else {
                            console.log(result);
                        }
                    });
                }
            });
        });

        function ToggleChangePassword() {
            $("#divChangePassword").slideToggle();
        }

        function DoGetUserDetailsList() {
            $.ajax({
                url: 'helper/_user.php',
                type: "GET",
                dataType: 'json',
                data: ({
                    getusers: true,
                    getuserdetails: true,
                    UserId: "<?php echo $_SESSION["UserId"]; ?>"
                }),
            }).done(function(result) {
                var data = result[0];
                $('input[name="FullName"]').val(data.FullName);
                if (data.Gender == "Female") $('#Female').attr('checked', true);
                else $('#Male').attr('checked', true);
                $('input[name="Mobile"]').val(data.Mobile);
                $('input[name="Email"]').val(data.Email);
            }).fail(function(result) {
                console.log(result.responseText);
            })
        }
    </script>
</body>

</html>