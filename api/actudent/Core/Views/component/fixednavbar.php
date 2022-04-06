<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top {navbarColor} bg-info navbar-shadow">
    <div class="navbar-wrapper">
      <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
          <li class="nav-item">
            {if $_SESSION['userLevel'] === '1'}
            <a class="navbar-brand" href="{admin}home">
              <img class="brand-logo" alt="modern admin logo" src="{images}logo/actudent-logo-only.png">
              <h3 class="brand-text">Actudent</h3>
            </a>
            {elseif $_SESSION['userLevel'] === '2'}
            <a class="navbar-brand" href="{guru}home">
              <img class="brand-logo" alt="modern admin logo" src="{images}logo/actudent-logo-only.png">
              <h3 class="brand-text">Actudent</h3>
            </a>
            {endif}
          </li>
          <li class="nav-item d-md-none">
            <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a>
          </li>
        </ul>
      </div>
      <div class="navbar-container content {navbarContainerColor}">
        <div class="collapse navbar-collapse" id="navbar-mobile">
          <ul class="nav navbar-nav mr-auto float-left">
            <li class="nav-item d-none d-md-block"><a class="nav-link {navlinkColor} nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
            <li class="nav-item d-none d-md-block"><a class="nav-link {navlinkColor} nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
            <li class="dropdown nav-item mega-dropdown"><a class="dropdown-toggle nav-link {navlinkColor}" href="#" data-toggle="dropdown">{namaSekolah}</a></li>            
          </ul>
          <ul class="nav navbar-nav float-right">
            <li class="dropdown dropdown-user nav-item">
              <a class="dropdown-toggle nav-link {navlinkColor} dropdown-user-link" href="#" data-toggle="dropdown">
                <span class="mr-1">{+ lang Admin.navbar_halo +},
                  <span class="user-name text-bold-700">{namaPengguna}</span>
                </span>
                <span class="avatar avatar-online">
                  <img src="{appAssets}images/portrait/small/avatar-s-19.png" alt="avatar"><i></i></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#"><i class="ft-user"></i> {+ lang Admin.navbar_profil +}</a>
                <a class="dropdown-item" href="{admin}sekolah"><i class="ft-layers"></i> {+ lang Admin.navbar_sekolah +}</a>
                <div class="dropdown-divider"></div>
                {if $_SESSION['userLevel'] === '1'}
                  <a class="dropdown-item" href="javascript:void(0)" id="logout-btn"><i class="ft-power"></i> {+ lang Admin.navbar_keluar +}</a>
                {elseif $_SESSION['userLevel'] === '2'}
                  <a class="dropdown-item" href="javascript:void(0)" id="logout-btn"><i class="ft-power"></i> {+ lang Admin.navbar_keluar +}</a>
                {endif}
              </div>
            </li>
            {if $isDashboard === true}
            <li class="dropdown dropdown-notification nav-item" id="show-changelog">
              <a class="nav-link {navlinkColor} nav-link-label" href="#"><i class="ficon ft-alert-circle"></i>
                <span class="badge badge-pill badge-default badge-danger badge-default badge-up badge-glow">{countChangelog}</span>
              </a>
            </li>
            {endif}
          </ul>
        </div>
      </div>
    </div>
  </nav>