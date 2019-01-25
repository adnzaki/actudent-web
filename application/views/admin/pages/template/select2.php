<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <title>Actudent - {title}</title>
  <?php $this->view('admin/component/head') ?>
  <!-- END Custom CSS-->
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
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Ikon Aplikasi</h3>
        </div>     
      </div>
      <div class="content-body">
       <?php $this->view('admin/pages/template/select2-content'); ?>
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <?php $this->view('admin/component/footer') ?>
  <!-- BEGIN VENDOR JS-->
  <?php $this->view('admin/component/scripts') ?>
  <script src="{assets}js/admin/ac-setting.js" type="text/javascript"></script>
  <script src="{appAssets}js/scripts/forms/select/form-select2.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
</body>
</html>