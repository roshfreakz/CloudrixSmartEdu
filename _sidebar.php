<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="index.php">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>
    <?php if ($_SESSION["UserType"] == "Admin") { ?>
    <li class="nav-item">
      <a class="nav-link" href="user.php">
        <span class="menu-title">Users</span>
        <i class="mdi mdi-contacts menu-icon"></i>
      </a>
    </li>   
    <li class="nav-item">
      <a class="nav-link" href="staff.php">
        <span class="menu-title">Staffs</span>
        <i class="mdi mdi-account-box menu-icon"></i>
      </a>
    </li>
    <?php } if ($_SESSION["UserType"] == "Staff" || $_SESSION["UserType"] == "Admin") { ?>
      <li class="nav-item">
        <a class="nav-link" href="student.php">
          <span class="menu-title">Students</span>
          <i class="mdi mdi-account-multiple menu-icon"></i>
        </a>
      </li>
    <?php }
    if ($_SESSION["UserType"] == "Admin" || $_SESSION["UserType"] == "Student" || $_SESSION["UserType"] == "Staff") { ?>
      <li class="nav-item">
        <a class="nav-link" href="room.php">
          <span class="menu-title">Classrooms</span>
          <i class="mdi mdi-cast-education menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="video.php">
          <span class="menu-title">Videos</span>
          <i class="mdi mdi-monitor-dashboard menu-icon"></i>
        </a>
      </li>
    <?php }
    ?>
  </ul>
</nav>