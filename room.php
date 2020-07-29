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
                                                        <option>Video Class</option>
                                                        <option>Screen Class</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 d-none">
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
                                                    <label class="form-label">Schedule Date</label>
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
                                        <table class="table table-sm table-hover" id="RoomTable">
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
                                    <div class="row">
                                        <div class="col">
                                            <h3 class="page-title d-inline-block">
                                                <p>Students for: <span class="card-title" id="RoomTitle"></span> </p>
                                            </h3>
                                        </div>
                                    </div>


                                    <?php if ($_SESSION["UserType"] != "Student") { ?>
                                        <form class="form-sample w-100 d-inline-block" id="AddAssignForm">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <input type="hidden" id="RoomId">
                                                    <select class="form-control" name="UserId" id="UserRoom">
                                                        <option value="">Select Student</option>
                                                    </select>
                                                    <div class="invalid-feedback">Invalid Data</div>
                                                    <div class="small text-danger" style="display: none;" id="dupuser">Student Already exists</div>
                                                </div>
                                                <div class="col">
                                                    <button type="submit" class="btn btn-gradient-primary">Add Student</button>
                                                </div>
                                            </div>
                                        </form>
                                    <?php } ?>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover " id="userTable">
                                            <thead>
                                                <tr>
                                                    <th style="width: 15%;"> </th>
                                                    <th> Student Name </th>
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
    <?php require_once('_footer.php'); ?>
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
                        url: 'helper/_room.php',
                        type: 'POST',
                        datatype: 'json',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                    }).always(function(result) {
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
                        var varData = {
                            RoomId: RoomId,
                            UserId: UserId,
                            PeerId: PeerId,
                            addassign: 1
                        };
                        $.ajax({
                            url: 'helper/_assign.php',
                            type: 'POST',
                            datatype: 'json',
                            data: varData,
                        }).always(function(result) {
                            if (result == "1") {
                                $('select[name=UserId]').val('');
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

        var dtable;

        function ToggleAddRoom() {
            $('#divAddRoom').slideToggle();
        }
      
        function DoGetRoomList() {
            $.ajax({
                url: 'helper/_room.php',
                type: "GET",
                dataType: 'json',
                data: ({
                    "getroom": true
                }),
            }).always(function(result) {
                dtable = $('#RoomTable').DataTable({
                    aaData: result,
                    autoWidth: false,
                    destroy: true,
                    lengthChange: false,
                    pageLength: 5,
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
                                var dhtml = '';
                                if (row.Status == "1") {
                                    dhtml += '<form method="POST" action="join.php">';
                                    dhtml += '<input type="hidden" name="RoomId" value="' + row.RoomId + '" />';
                                    dhtml += '<input type="hidden" name="RoomName" value="' + row.RoomName + '" />';
                                    dhtml += '<input type="hidden" name="RoomType" value="' + row.RoomType + '" />';
                                    dhtml += '<input type="hidden" name="StaffId" value="' + row.PeerId + '" />';
                                    dhtml += '<input type="hidden" name="StaffName" value="' + row.FullName + '" />';
                                    dhtml += '<button class="btn btn-sm btn-gradient-primary" type="submit"> Join </button>';
                                    dhtml += '</form>';
                                }
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
            });
        }
       
        function DoGetUserDropdown() {
            $.ajax({
                url: 'helper/_user.php',
                type: "GET",
                dataType: 'json',
                data: ({
                    "getusers": true,
                    "getstudent": true
                }),
            }).always(function(result) {
                var dhtml = '<option value="">Select Student</option>';
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
            $('select[name=UserId]').removeClass('is-invalid');
            $.ajax({
                url: 'helper/_assign.php',
                type: "GET",
                dataType: 'json',
                data: ({
                    getassign: 1,
                    RoomId: RoomId
                }),
            }).always(function(result) {
                console.log(result);
                $('#userTable').DataTable({
                    aaData: result,
                    autoWidth: false,
                    destroy: true,
                    lengthChange: false,
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
                                return '<button class="btn btn-sm btn-gradient-danger" type="button" onclick="DoDeleteRoomUser(' + row.AssignId + ',' + row.RoomId + ')"> Remove </button>';
                            }
                        },
                        {
                            render: function(data, type, row, meta) {
                                if (row.Gender == "Male") {
                                    return '<img src="img/male.png" class="mr-2" alt="image"> ' + row.FullName;
                                } else {
                                    return '<img src="img/female.png" class="mr-2" alt="image"> ' + row.FullName;
                                }
                            }
                        }
                    ]
                })
            })
        }

        function DoDeleteRoomUser(AssignId, RoomId) {
            var cnfm = confirm("Are you sure you want to delete this student from this class?");
            if (cnfm) {
                $.ajax({
                    url: 'helper/_assign.php',
                    type: "GET",
                    dataType: 'json',
                    data: ({
                        deleteRoomUser: 1,
                        AssignId: AssignId
                    }),
                }).always(function(result) {
                    alert('User Deleted Successfully');
                    DoGetUserListforRoom(RoomId);
                })
            }
        }
    </script>
</body>

</html>