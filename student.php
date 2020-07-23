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
                            Students
                        </h3>
                       
                    </div>
                 
                    <div class="row">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover " id="userTable">
                                            <thead>
                                                <tr>
                                                    <th> Name </th>
                                                    <th> Gender </th>
                                                    <th> Mobile </th>
                                                    <th> Email </th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
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
                url: 'helper/postuser.php',
                type: "GET",
                dataType: 'json',
                data: ({
                    "getstudent": true
                }),
            }).done(function(result) {
                $('#userTable').DataTable({
                    aaData: result,
                    autoWidth: false,
                    destroy: true,
                    language: {
                        search: '',
                        searchPlaceholder: "Search..."
                    },
                    // order: [],                    
                    columns: [
                        {
                            render: function(data, type, row, meta) {
                                if (row.Gender == "Male") {
                                    return '<img src="img/male.png" class="mr-2" alt="image"> ' + row.FullName;
                                } else {
                                    return '<img src="img/female.png" class="mr-2" alt="image"> ' + row.FullName;
                                }
                            }
                        },
                       
                        {
                            data: "Gender",
                            name: "Gender"
                        },
                        {
                            data: "Mobile",
                            name: "Mobile"
                        },
                        {
                            data: "Email",
                            name: "Email"
                        },
                      
                    ]
                })
            })
        }
    </script>
</body>

</html>