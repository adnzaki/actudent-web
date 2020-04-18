<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <title>Actudent - {title}</title>
  {+ include Actudent\Core\Views\component\head +}
  <link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/pickers/daterange/daterangepicker.css">
  <link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/pickers/pickadate/pickadate.css">
  <link rel="stylesheet" type="text/css" href="{appAssets}css/plugins/pickers/daterange/daterange.css">
  <link rel="stylesheet" type="text/css" href="{appAssets}css/plugins/loaders/loaders.min.css">
  <link rel="stylesheet" type="text/css" href="{appAssets}css/core/colors/palette-loader.css">
  <link rel="stylesheet" type="text/css" href="{assets}css/jadwal.css">
</head>
<body class="vertical-layout vertical-menu 2-columns {bodyColor} menu-expanded fixed-navbar"
data-open="click" data-menu="vertical-menu" data-col="2-columns">
  <!-- fixed-top-->
  {+ include Actudent\Core\Views\component\fixednavbar +} 
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  
  <!-- Menu -->
  {+ include Actudent\Core\Views\component\menu +} 
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body" id="jadwal-content">
        {+ include Actudent\Admin\Views\jadwal\content +} 
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  {+ include Actudent\Core\Views\component\footer +} 
  <!-- BEGIN VENDOR JS-->
  {+ include Actudent\Core\Views\component\scripts +} 
  <script src="{appAssets}js/scripts/modal/components-modal.js" type="text/javascript"></script>
  <script src="{appAssets}vendors/js/pickers/pickadate/picker.js" type="text/javascript"></script>
  <script src="{appAssets}vendors/js/pickers/pickadate/picker.date.js" type="text/javascript"></script>
  <script src="{appAssets}vendors/js/pickers/pickadate/picker.time.js" type="text/javascript"></script>
  {if $bahasa === 'indonesia'}
    <script src="{assets}js/admin/pickadate-id.js" type="text/javascript"></script>
  {endif}
  <script src="{assets}js/admin/ac-jadwal.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
</body>
</html>