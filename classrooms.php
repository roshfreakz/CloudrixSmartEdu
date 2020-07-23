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
                            Class Rooms
                        </h3>

                    </div>

                    <div class="row">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover " id="RoomTable">
                                            <thead>
                                                <tr>
                                                    <th> Room Name </th>
                                                    <th> Room Type </th>
                                                    <th> Status </th>
                                                    <th> Schedule Date </th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="divuserRoom" style="display: none;">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="page-header">
                                        <h3 class="page-title">
                                            <p>Users for Room: <span class="card-title" id="RoomTitle"></span> </p>
                                        </h3>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover " id="userTable">
                                            <thead>
                                                <tr>
                                                    <th> Name </th>
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
            DoGetRoomList();
        });

        function DoGetRoomList() {
            $.ajax({
                url: 'helper/postroom.php',
                type: "GET",
                dataType: 'json',
                data: ({
                    "getroom": true
                }),
            }).done(function(result) {
                var dtable = $('#RoomTable').DataTable({
                    aaData: result,
                    autoWidth: false,
                    destroy: true,
                    pageLength: 5,
                    language: {
                        search: '',
                        searchPlaceholder: "Search..."
                    },
                    order: [],
                    columns: [{
                            data: "RoomName",
                            name: "RoomName"
                        },
                        {
                            data: "RoomType",
                            name: "RoomType"
                        },
                        {
                            render: function(data, type, row, meta) {
                                if (row.Status == "1") {
                                    return '<label class="badge badge-gradient-success"> Active </label>';
                                } else {
                                    return '<label class="badge badge-gradient-secondary"> Closed </label>';
                                }
                            }
                        },
                        {
                            render: function(data, type, row, meta) {
                                return row.SDate;
                            }
                        },
                        {
                            render: function(data, type, row, meta) {
                                var dhtml = '<form method="POST" action="join.php">';
                                dhtml += '<input type="hidden" name="RoomId" value="' + row.RoomId + '" />';
                                dhtml += '<button class="btn btn-gradient-primary" type="submit"> Join </button>';
                                dhtml += '</form>';
                                return dhtml;
                            }
                        },
                    ]
                });
                $('#RoomTable tbody').on('click', 'tr', function() {
                    var data = dtable.row(this).data();
                    DoGetUserListforRoom(data["RoomId"]);
                    $('#RoomTitle').text(data["RoomName"]);
                    if ($(this).hasClass('selected')) {
                        $(this).removeClass('selected');
                    } else {
                        dtable.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }
                });
            })
        }

        function JoinRoom(arg) {
            window.location.href = "join.php?RoomId=" + arg;
        }

        function DoGetUserListforRoom(RoomId) {
            $('#divuserRoom').show();
            $('#RoomId').val(RoomId);
            $('select[name=UserId]').val('');
            $('#dupuser').hide();
            $('select[name=UserId]').remove('is-invalid');
            $.ajax({
                url: 'helper/postassign.php',
                type: "GET",
                dataType: 'json',
                data: ({
                    getassign: 1,
                    RoomId: RoomId
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
                    columns: [{
                            render: function(data, type, row, meta) {
                                if (row.Gender == "Male") {
                                    return '<img src="img/male.png" class="mr-2" alt="image"> ' + row.FullName;
                                } else {
                                    return '<img src="img/female.png" class="mr-2" alt="image"> ' + row.FullName;
                                }
                            }
                        },

                    ]
                })
            })
        }
    </script>
</body>

</html>