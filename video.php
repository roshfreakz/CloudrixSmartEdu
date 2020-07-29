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
                                <i class="mdi mdi-video"></i>
                            </span> Videos
                        </h3>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Videos of Closed Class Rooms</h4>
                                    <div class="row mt-3" id="VideoSection">

                                    </div>
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
                url: 'helper/_video.php',
                type: "GET",
                dataType: 'json',
                data: ({
                    "getfiles": true
                }),
            }).always(function(result) {                
                var dhtml = '';
                for (let i = 0; i < result.length; i++) {
                    if (result[i].VideoPath != null) {
                        dhtml += '<div class="col-lg-4 col-sm-6 col-12">';
                        dhtml += '<video src="' + result[i].VideoPath + '" class="videodisplay" controls />';                      
                        dhtml += '<label class="badge badge-gradient-danger d-block"><p>Class Name: ' + result[i].VideoName + '</p>';
                        dhtml += '<p>Staff Name: ' + result[i].FullName + '</p>';
                        dhtml += '<p>Class Type: ' + result[i].RoomType + '</p></label>';
                        dhtml += '</div>';
                    }
                }
                $('#VideoSection').html(dhtml);
            });
        }
    </script>
</body>

</html>