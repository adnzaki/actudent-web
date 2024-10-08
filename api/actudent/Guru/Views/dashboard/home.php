<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <title>Actudent - {title}</title>
  {+ include Actudent\Core\Views\component\head +} 
</head>
<body class="vertical-layout vertical-menu 2-columns {bodyColor} menu-expanded fixed-navbar"
data-open="click" data-menu="vertical-menu" data-col="2-columns">
  <!-- fixed-top-->
  {+ include Actudent\Core\Views\component\fixednavbar +} 
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  
  <!-- Menu -->
  {+ include Actudent\Core\Views\component\MenuGuru +} 
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body" id="dashboard-content">
        {+ include Actudent\Admin\Views\dashboard\ExpirationWarning +} 
        {+ include Actudent\Admin\Views\dashboard\changelog +} 
        <!-- App Content Here -->
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  {+ include Actudent\Core\Views\component\footer +} 
  <!-- BEGIN VENDOR JS-->
  {+ include Actudent\Core\Views\component\scripts +} 
  <script>
    var changelog = `{changelog}`;
  </script>
  <script src="{appAssets}js/scripts/pages/dashboard-crypto.js" type="text/javascript"></script>
  <script src="{assets}js/admin/ac-dashboard.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
</body>
</html>