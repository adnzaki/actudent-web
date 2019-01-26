<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <title>Actudent - {title}</title>
  <?php $this->view('admin/component/head') ?>
</head>
<body class="vertical-layout vertical-menu 2-columns {bodyColor} menu-expanded fixed-navbar"
data-open="click" data-menu="vertical-menu" data-col="2-columns">
  <!-- fixed-top-->
  <?php $this->view('admin/component/fixed-navbar') ?>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  
  <!-- Menu -->
  <?php $this->view('admin/component/menu') ?>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body" id="siswa-content">
      <?php $this->view('admin/pages/kelas/content'); ?>
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <?php $this->view('admin/component/footer') ?>
  <!-- BEGIN VENDOR JS-->
  <?php $this->view('admin/component/scripts') ?>
  <script src="{appAssets}js/scripts/modal/components-modal.js" type="text/javascript"></script>
  <script src="{assets}js/admin/ac-siswa.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
</body>
</html>