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
                <i class="mdi mdi-home"></i>
              </span> Dashboard </h3>
          </div>
          <div class="row">
            <div class="col-lg-6 stretch-card grid-margin">
              <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                  <img src="img/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                  <h4 class="font-weight-normal mb-3">Total Staffs <i class="mdi mdi-contacts mdi-24px float-right"></i>
                  </h4>
                  <h2 class="dashboardcount" id="Staff">0</h2>
                </div>
              </div>
            </div>
            <div class="col-lg-6 stretch-card grid-margin">
              <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                  <img src="img/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                  <h4 class="font-weight-normal mb-3">Total Students <i class="mdi mdi-account-multiple mdi-24px float-right"></i>
                  </h4>
                  <h2 class="dashboardcount" id="Student">0</h2>
                </div>
              </div>
            </div>
            <div class="col-lg-6 stretch-card grid-margin">
              <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                  <img src="img/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                  <h4 class="font-weight-normal mb-3">Active ClassRooms <i class="mdi mdi-cast-education mdi-24px float-right"></i>
                  </h4>
                  <h2 class="dashboardcount" id="Active">0</h2>
                </div>
              </div>
            </div>
            <div class="col-lg-6 stretch-card grid-margin">
              <div class="card bg-gradient-primary card-img-holder text-white">
                <div class="card-body">
                  <img src="img/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                  <h4 class="font-weight-normal mb-3">Closed ClassRooms <i class="mdi mdi-cast-off mdi-24px float-right"></i>
                  </h4>
                  <h2 class="dashboardcount" id="Closed">0</h2>
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
      DoGetUserList();
    });

    function DoGetUserList() {
      $.ajax({
        url: 'helper/_room.php',
        type: "GET",
        dataType: 'json',
        data: ({
          getdashboard: true
        }),
      }).done(function(result) {
        console.log(result);
        $('#Staff').text(result.Staff);
        $('#Student').text(result.Student);
        $('#Active').text(result.Active);
        $('#Closed').text(result.Closed);
      })
    }
  </script>
</body>

</html>