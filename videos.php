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
                                <i class="mdi mdi-video"></i>
                            </span> Videos
                        </h3>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Closed Classrooms</h4>
                                    <div class="row mt-3" id="VideoSection">
                                        <!-- <div class="col-6 pr-1">
                                            <video src="uploads/blob.webm" class="mb-2 mw-100 w-100 rounded" controls>
                                        </div> -->
                                    </div>
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
            DoGetUserList();
        });

        function DoGetUserList() {
            $.ajax({
                url: 'postupload.php',
                type: "GET",
                dataType: 'json',
                data: ({
                    "getfiles": true
                }),
            }).done(function(result) {
                var dhtml = '';
                for (let i = 0; i < result.length; i++) {
                    if (result[i].VideoPath != null) {
                        dhtml += '<div class="col-lg-4 col-12">';
                        dhtml += '<video src="' + result[i].VideoPath + '" class="w-100 rounded" controls />';                        
                        dhtml += '<p class="text-center">' + result[i].VideoName + '</p>';
                        dhtml += '</div>';
                    }
                }
                $('#VideoSection').html(dhtml);
            }).fail(function(res) {
                console.log(res.responseText);

            })
        }
    </script>
</body>

</html>