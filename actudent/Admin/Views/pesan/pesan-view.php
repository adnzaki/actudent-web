<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <title>Actudent - {title}</title>
  {+ include Actudent\Core\Views\component\head +}
  <link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/pickers/daterange/daterangepicker.css">
  <link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/pickers/pickadate/pickadate.css">
  <link rel="stylesheet" type="text/css" href="{appAssets}css/plugins/pickers/daterange/daterange.css">
  <link rel="stylesheet" type="text/css" href="{assets}css/custom-spinner.css">
  <link rel="stylesheet" type="text/css" href="{assets}css/chat.css">
</head>
<body class="vertical-layout vertical-menu 2-columns {bodyColor} menu-expanded fixed-navbar"
data-open="click" data-menu="vertical-menu" data-col="2-columns">
  <!-- fixed-top-->
  {+ include Actudent\Core\Views\component\fixednavbar +} 
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  
  <!-- Menu -->
  {if $_SESSION['userLevel'] === '1'}
    {+ include Actudent\Core\Views\component\menu +}
  {else} 
    {+ include Actudent\Core\Views\component\MenuGuru +}
  {endif}
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body" id="pesan-content">
        {+ include Actudent\Admin\Views\pesan\ChatWrapper +}
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  {+ include Actudent\Core\Views\component\footer +} 
  <!-- BEGIN VENDOR JS-->
  {+ include Actudent\Core\Views\component\scripts +} 
  <script src="{appAssets}js/scripts/modal/components-modal.js" type="text/javascript"></script>
  <script src="{appAssets}vendors/js/extensions/moment.min.js" type="text/javascript"></script>
  <script src="{appAssets}vendors/js/pickers/pickadate/picker.js" type="text/javascript"></script>
  <script src="{appAssets}vendors/js/pickers/pickadate/picker.date.js" type="text/javascript"></script>
  <script src="{appAssets}vendors/js/pickers/pickadate/picker.time.js" type="text/javascript"></script>
  
  {if $bahasa === 'indonesia'}
    <script src="{assets}js/admin/pickadate-id.js" type="text/javascript"></script>
  {endif}
  <script src="{assets}js/admin/ac-pesan.js" type="text/javascript"></script>
  <script src="{assets}js/locales.min.js" type="text/javascript"></script>
  <script>
    var userID = "{userID}";
  </script>
  <!-- END PAGE LEVEL JS-->
</body>
</html>