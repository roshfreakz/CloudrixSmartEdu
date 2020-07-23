<!DOCTYPE html>
<html lang="en">
<?php require('header.php'); ?>

<body>
    <div class="container-scroller">
        <?php require('navbar.php'); ?>
        <div class="container-fluid page-body-wrapper">
            <?php require('sidebar.php'); ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                                <i class="mdi mdi-contacts menu-icon"></i>
                            </span>
                            My Profile
                        </h3>                      
                    </div>
                    <div class="row" id="divAddUser">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <form class="form-sample" id="AddUserForm">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" class="form-control" name="FullName" placeholder="Your Full Name" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Gender</label>
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label">Mobile</label>
                                                    <input class="form-control" name="Mobile" placeholder="Your Mobile" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label">Email</label>
                                                    <input class="form-control" name="Email" placeholder="Your Email" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label">User Type</label>
                                                    <select class="form-control" name="UserType">
                                                        <option value="">Select Type</option>
                                                        <option>Admin</option>
                                                        <option>Staff</option>
                                                        <option>Student</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                       
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <input type="hidden" name="registeruser" value="1">
                                                <button type="submit" class="btn btn-gradient-success mr-2">Update</button>
                                                <button class="btn btn-light" onclick="ToggleAddUser()">Cancel</button>
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
    <?php require('footer.php'); ?>
    <script>
      

        $(function() {
            $('#AddUserForm').on('submit', function(e) {
                e.preventDefault();
                var FullName = $("input[name=FullName]").val();
                var Mobile = $("input[name=Mobile]").val();
                var Email = $("input[name=Email]").val();
                var UserType = $("select[name=UserType]").val();
                var Username = $("input[name=Username]").val();
                var Password = $("input[name=Password]").val();
                var CPassword = $("input[name=CPassword]").val();
                if (!FullName || !Email || !Mobile || !UserType || !Username || !Password || !CPassword || Password != CPassword) {
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
                            $('.form-control').val('');
                            $('input:radio[id=Male]').prop('checked', true);
                            ToggleAddUser();
                            DoGetUserList();
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