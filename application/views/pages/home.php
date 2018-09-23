<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <title>Actudent - {title}</title>
  <?php $this->view('component/head') ?>
</head>
<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar"
data-open="click" data-menu="vertical-menu" data-col="2-columns">
  <!-- fixed-top-->
  <?php $this->view('component/fixed-navbar') ?>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  
  <!-- Menu -->
  <?php $this->view('component/menu') ?>
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
  <?php $this->view('component/footer') ?>
  <!-- BEGIN VENDOR JS-->
  <?php $this->view('component/scripts') ?>
  <!-- END PAGE LEVEL JS-->
</body>
</html>