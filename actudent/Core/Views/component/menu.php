<div class="main-menu menu-fixed {menuColor} menu-accordion    menu-shadow " data-scroll-to-active="true">
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
      <li class="{+ menu_active uri=home +} nav-item">
        <a href="{admin}home"><i class="la la-home"></i><span class="menu-title" data-i18n="nav.dash.main">{+ lang Admin.menu_dashboard +}</span></a>
      </li>
      <li class=" nav-item"><a href="#"><i class="la la-database"></i><span class="menu-title" data-i18n="nav.icons.main">{+ lang Admin.menu_master +}</span></a>
        <ul class="menu-content">
          <li class="{+ menu_active uri=siswa +}"><a class="menu-item" href="{admin}siswa" data-i18n="nav.icons.icons_line_awesome">{+ lang Admin.menu_siswa +}</a>
          </li>
          <li class="{+ menu_active uri=aaa +}"><a class="menu-item" href="#" data-i18n="nav.icons.icons_line_awesome">{+ lang Admin.menu_parent +}</a>
          </li>
          <li class="{+ menu_active uri=kelas +}"><a class="menu-item" href="{admin}siswa" data-i18n="nav.icons.icons_line_awesome">{+ lang Admin.menu_kelas +}</a>
          </li>
          <li class="{+ menu_active uri=aaa +}"><a class="menu-item" href="#" data-i18n="nav.icons.icons_line_awesome">{+ lang Admin.menu_guru +}</a>
          </li>
        </ul>
      </li>
      <li class="{+ menu_active uri=aaa +} nav-item">
        <a href="{admin}siswa"><i class="la la-check-square"></i><span class="menu-title" data-i18n="nav.dash.main">{+ lang Admin.menu_kehadiran +}</span></a>
      </li>
      <li class="{+ menu_active uri=aaa +} nav-item">
        <a href="{admin}siswa"><i class="la la-book"></i><span class="menu-title" data-i18n="nav.dash.main">{+ lang Admin.menu_jadwal +}</span></a>
      </li>
      <li class="{+ menu_active uri=agenda +} nav-item">
        <a href="{admin}agenda"><i class="la la-calendar-o"></i><span class="menu-title" data-i18n="nav.dash.main">{+ lang Admin.menu_agenda +}</span></a>
      </li>
      <li class="{+ menu_active uri=timeline +} nav-item">
        <a href="{admin}timeline"><i class="la la-history"></i><span class="menu-title" data-i18n="nav.dash.main">{+ lang Admin.menu_timeline +}</span></a>
      </li>
      <li class="{+ menu_active uri=aaa +} nav-item">
        <a href="{admin}siswa"><i class="la la-comments"></i><span class="menu-title" data-i18n="nav.dash.main">{+ lang Admin.menu_pesan +}</span></a>
      </li>
      <li class="{+ menu_active uri=aaa +} nav-item">
        <a href="{admin}siswa"><i class="la la-clipboard"></i><span class="menu-title" data-i18n="nav.dash.main">{+ lang Admin.menu_nilai +}</span></a>
      </li>
      <li class=" nav-item"><a href="#"><i class="la la-gears"></i><span class="menu-title" data-i18n="nav.icons.main">{+ lang Admin.menu_pengaturan +}</span></a>
        <ul class="menu-content">
          <li class="{+ menu_active uri=aaa +}"><a class="menu-item" href="#" data-i18n="nav.icons.icons_feather">{+ lang Admin.menu_pengguna +}</a>
          </li>
          <li class="{+ menu_active uri=PengaturanAplikasi +}"><a class="menu-item" href="{admin}pengaturan-aplikasi" data-i18n="nav.icons.icons_line_awesome">{+ lang Admin.menu_aplikasi +}</a>
          </li>
        </ul>
      </li>
      {if ENVIRONMENT === 'development'}
      <li class=" nav-item"><a href="#"><i class="la la-puzzle-piece"></i><span class="menu-title" data-i18n="nav.icons.main">Template</span></a>
        <ul class="menu-content">
          <li class="{+ menu_active uri=icons +}"><a class="menu-item" href="{admin}template/icons" data-i18n="nav.icons.icons_line_awesome">Icons</a>
          </li>
          <li class="{+ menu_active uri=buttons +}"><a class="menu-item" href="{admin}template/buttons" data-i18n="nav.icons.icons_feather">Button</a>
          </li>
        </ul>
      </li>
      {endif}
    </ul>
  </div>
</div>