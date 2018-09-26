<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <title>Actudent - {title}</title>
  <?php $this->view('admin/component/head') ?>
</head>
<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar"
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
      <div class="content-body">
        <!-- App Content Here -->
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <?php $this->view('admin/component/footer') ?>
  <!-- BEGIN VENDOR JS-->
  <?php $this->view('admin/component/scripts') ?>
  <!-- END PAGE LEVEL JS-->
</body>
</html>