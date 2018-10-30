<div class="main-menu menu-fixed {menuColor} menu-accordion    menu-shadow " data-scroll-to-active="true">
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
      <li class="<?= menu_active('home', 'active') ?> nav-item">
        <a href="{admin}home"><i class="la la-home"></i><span class="menu-title" data-i18n="nav.dash.main">Dashboard</span></a>
      </li>
      <li class="<?= menu_active('siswa', 'active') ?> nav-item">
        <a href="{admin}siswa"><i class="la la-group"></i><span class="menu-title" data-i18n="nav.dash.main">Data Siswa</span></a>
      </li>
      <li class="<?= menu_active('aaa', 'active') ?> nav-item">
        <a href="{admin}siswa"><i class="la la-check-square"></i><span class="menu-title" data-i18n="nav.dash.main">Kehadiran</span></a>
      </li>
      <li class="<?= menu_active('aaa', 'active') ?> nav-item">
        <a href="{admin}siswa"><i class="la la-calendar-o"></i><span class="menu-title" data-i18n="nav.dash.main">Agenda Sekolah</span></a>
      </li>
      <li class="<?= menu_active('aaa', 'active') ?> nav-item">
        <a href="{admin}siswa"><i class="la la-book"></i><span class="menu-title" data-i18n="nav.dash.main">Jadwal Pelajaran</span></a>
      </li>
      <li class="<?= menu_active('aaa', 'active') ?> nav-item">
        <a href="{admin}siswa"><i class="la la-comments"></i><span class="menu-title" data-i18n="nav.dash.main">Pesan</span></a>
      </li>
      <li class="<?= menu_active('aaa', 'active') ?> nav-item">
        <a href="{admin}siswa"><i class="la la-clipboard"></i><span class="menu-title" data-i18n="nav.dash.main">Nilai</span></a>
      </li>
      <li class=" nav-item"><a href="#"><i class="la la-gears"></i><span class="menu-title" data-i18n="nav.icons.main">Pengaturan</span></a>
        <ul class="menu-content">
          <li class="<?= menu_active('aaa', 'active') ?>"><a class="menu-item" href="#" data-i18n="nav.icons.icons_feather">Pengguna</a>
          </li>
          <li class="<?= menu_active('pengaturan-aplikasi', 'active') ?>"><a class="menu-item" href="{admin}pengaturan-aplikasi" data-i18n="nav.icons.icons_line_awesome">Aplikasi</a>
          </li>
        </ul>
      </li>
      <?php if(ENVIRONMENT === 'development'): ?>
      <li class=" nav-item"><a href="#"><i class="la la-puzzle-piece"></i><span class="menu-title" data-i18n="nav.icons.main">Template</span></a>
        <ul class="menu-content">
          <li class="<?= menu_active('ikon', 'active') ?>"><a class="menu-item" href="{base_url}template/ikon" data-i18n="nav.icons.icons_line_awesome">Icons</a>
          </li>
          <li class="<?= menu_active('button', 'active') ?>"><a class="menu-item" href="{base_url}template/button" data-i18n="nav.icons.icons_feather">Button</a>
          </li>
        </ul>
      </li>
      <?php endif; ?>
    </ul>
  </div>
</div>