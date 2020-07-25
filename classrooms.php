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
                        <?php if ($_SESSION["UserType"] != "Student") { ?>
                            <nav aria-label="breadcrumb">
                                <button class="btn btn-gradient-primary" onclick="ToggleAddRoom()">Add Room</button>
                            </nav>
                        <?php } ?>
                    </div>
                    <div class="row" id="divAddRoom" style="display: none;">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Add Room</h4>
                                    <form class="form-sample" id="AddRoomForm">
                                        <p class="card-description"> Personal info </p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Room Name</label>
                                                    <input type="text" class="form-control" name="RoomName" placeholder="Room Name" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label">Room Type</label>
                                                    <select class="form-control" name="RoomType">
                                                        <option value="">Select Type</option>
                                                        <option>Class</option>
                                                        <option>Counselling</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label">Status</label>
                                                    <select class="form-control" name="Status">
                                                        <option value="1">Active</option>
                                                        <option value="0">Closed</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Schdeule Date</label>
                                                    <input type="datetime-local" class="form-control" name="SDate" placeholder="Schdeule Date" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <input type="hidden" name="addroom" value="1">
                                                <button type="submit" class="btn btn-gradient-success mr-2">Save</button>
                                                <button class="btn btn-light" onclick="ToggleAddRoom()">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover " id="RoomTable">
                                            <thead>
                                                <tr>
                                                    <th></th>
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
                                        <?php if ($_SESSION["UserType"] != "Student") { ?>
                                            <nav aria-label="breadcrumb">
                                                <button class="btn btn-gradient-info" onclick="ToggleAddAssign()">Add Users</button>
                                            </nav>
                                        <?php } ?>
                                    </div>
                                    <form class="form-sample" id="AddAssignForm" style="display: none;">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <input type="hidden" id="RoomId">
                                                    <select class="form-control" name="UserId" id="UserRoom">
                                                        <option value="">Select User</option>
                                                    </select>
                                                    <div class="invalid-feedback">Invalid Data</div>
                                                    <div class="small text-danger" style="display: none;" id="dupuser">User Already exists</div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <button type="submit" class="btn btn-gradient-success mr-2">Add</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover " id="userTable">
                                            <thead>
                                                <tr>
                                                    <th> Name </th>
                                                    <th> Username </th>
                                                    <th> UserType </th>
                                                    <th> Last Update </th>
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
            DoGetUserDropdown();
        });

        $(function() {
            $('#AddRoomForm').on('submit', function(e) {
                e.preventDefault();
                var RoomName = $("input[name=RoomName]").val();
                var RoomType = $("select[name=RoomType]").val();
                var SDate = $("input[name=SDate]").val();
                if (!RoomName || !RoomType || !SDate) {
                    $('.form-control').addClass('is-invalid');
                } else {
                    var formData = new FormData(this);
                    $.ajax({
                        url: 'postroom.php',
                        type: 'POST',
                        datatype: 'json',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                    }).done(function(result) {
                        if (result == "1") {
                            $('.form-control').val('');
                            ToggleAddRoom();
                            DoGetRoomList();
                        } else {
                            console.log(result);
                        }
                    });
                }
            });
        });

        $(function() {
            $('#AddAssignForm').on('submit', function(e) {
                e.preventDefault();
                $('#dupuser').hide();
                $('select[name=UserId]').remove('is-invalid');
                var RoomId = $("#RoomId").val();
                var Userrawdata = $("select[name=UserId]").val();
                if (Userrawdata) {
                    var Userdata = Userrawdata.split("-");
                    var UserId = Userdata[0];
                    var PeerId = Userdata[1];
                    if (!RoomId || !UserId || !PeerId) {
                        $('#select[name=UserId]').addClass('is-invalid');
                    } else {
                        var formData = {
                            RoomId: RoomId,
                            UserId: UserId,
                            PeerId: PeerId,
                            addassign: 1
                        };
                        $.ajax({
                            url: 'postassign.php',
                            type: 'POST',
                            datatype: 'json',
                            data: formData,
                        }).done(function(result) {
                            if (result == "1") {
                                $('select[name=UserId]').val('');
                                ToggleAddAssign();
                                DoGetUserListforRoom(RoomId);
                            } else {
                                console.log(result);
                                if (result == "2") {
                                    $('#dupuser').show();
                                }
                            }
                        });
                    }
                } else {
                    $('select[name=UserId]').addClass('is-invalid');
                }
            });
        });

        function ToggleAddRoom() {
            $('#divAddRoom').slideToggle();
        }

        function ToggleAddAssign() {
            $('#AddAssignForm').slideToggle();
        }

        var dtable;

        function DoGetRoomList() {
            $.ajax({
                url: 'postroom.php',
                type: "GET",
                dataType: 'json',
                data: ({
                    "getroom": true
                }),
            }).done(function(result) {
                dtable = $('#RoomTable').DataTable({
                    aaData: result,
                    autoWidth: false,
                    destroy: true,
                    language: {
                        search: '',
                        searchPlaceholder: "Search..."
                    },
                    order: [],
                    columnDefs: [{
                        targets: 0,
                        orderable: false
                    }],
                    columns: [{
                            render: function(data, type, row, meta) {
                                var dhtml = '<form method="POST" action="join.php">';
                                dhtml += '<input type="hidden" name="RoomId" value="' + row.RoomId + '" />';
                                dhtml += '<input type="hidden" name="StaffPeerId" value="' + row.PeerId + '" />';
                                dhtml += '<input type="hidden" name="StaffName" value="' + row.FullName + '" />';
                                dhtml += '<button class="btn btn-sm btn-gradient-primary" type="submit"> Join </button>';
                                dhtml += '</form>';
                                return dhtml;
                            }
                        },
                        {
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
            }).fail(function(data) {
                console.log(data.responseText);
            })
        }

        function JoinRoom(arg) {
            window.location.href = "join.php?RoomId=" + arg;
        }

        function DoGetUserDropdown() {
            $.ajax({
                url: 'postuser.php',
                type: "GET",
                dataType: 'json',
                data: ({
                    "getusers": true
                }),
            }).done(function(result) {
                var dhtml = '<option value="">Select User</option>';
                for (var i = 0; i < result.length; i++) {
                    dhtml += '<option value="' + result[i].UserId + '-' + result[i].PeerId + '">' + result[i].FullName + '</option>';
                }
                $('#UserRoom').html(dhtml);
            })
        }

        function DoGetUserListforRoom(RoomId) {
            $('#divuserRoom').show();
            $('#RoomId').val(RoomId);
            $('select[name=UserId]').val('');
            $('#dupuser').hide();
            $('select[name=UserId]').remove('is-invalid');
            $.ajax({
                url: 'postassign.php',
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
                        {
                            data: "Username",
                            name: "Username"
                        },
                        {
                            render: function(data, type, row, meta) {
                                if (row.UserType == "Admin") {
                                    return '<label class="badge badge-gradient-primary"> ' + row.UserType + ' </label>';
                                } else if (row.UserType == "Staff") {
                                    return '<label class="badge badge-gradient-success"> ' + row.UserType + ' </label>';
                                } else {
                                    return '<label class="badge badge-gradient-warning"> ' + row.UserType + ' </label>';
                                }
                            }
                        },
                        {
                            render: function(data, type, row, meta) {
                                return row.CDate;
                            }
                        },
                    ]
                })
            })
        }
    </script>
</body>

</html>