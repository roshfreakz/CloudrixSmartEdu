<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo" href="index.php"><img src="img/logo.png" alt="logo" /></a>
    <a class="navbar-brand brand-logo-mini" href="index.php"><img src="img/logo-mini.png" alt="logo" /></a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-stretch">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="mdi mdi-menu"></span>
    </button>
    <div class="search-field d-none">
      <form class="d-flex align-items-center h-100" action="#">
        <div class="input-group">
          <div class="input-group-prepend bg-transparent">
            <i class="input-group-text border-0 mdi mdi-magnify"></i>
          </div>
          <input type="text" class="form-control bg-transparent border-0" placeholder="Search Rooms">
        </div>
      </form>
    </div>
    <ul class="navbar-nav navbar-nav-right">

      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
          <div class="nav-profile-img">
              <img src="img/male.png" alt="image">           
            <span class="availability-status online"></span>
          </div>
          <div class="nav-profile-text">
            <p class="mb-1 text-dark"> <?php echo htmlspecialchars($_SESSION["FullName"]); ?> </p>
          </div>
        </a>
        <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
          <a class="dropdown-item" href="profile.php">
            <i class="mdi mdi-cached mr-2 text-success"></i> My Profile </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="login.php">
            <i class="mdi mdi-logout mr-2 text-success"></i> Signout </a>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>