<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <title>Actudent - {title}</title>
  {+ include Actudent\Core\Views\component\head +} 
  <link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/cryptocoins/cryptocoins.css">
</head>
<body class="vertical-layout vertical-menu 2-columns {bodyColor} menu-expanded fixed-navbar"
data-open="click" data-menu="vertical-menu" data-col="2-columns">
  <!-- fixed-top-->
  {+ include Actudent\Core\Views\component\fixednavbar +} 
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  
  <!-- Menu -->
  {if $_SESSION['userLevel'] === '1'}
    {+ include Actudent\Core\Views\component\menu +} 
  {elseif $_SESSION['userLevel'] === '2'}
    {+ include Actudent\Core\Views\component\MenuGuru +} 
  {endif}
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content" id="dashboard-content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        {+ include Actudent\Admin\Views\dashboard\changelog +} 
        {+ include Actudent\Admin\Views\dashboard\ChangelogMirror +}
        {+ include Actudent\Admin\Views\dashboard\FirstRow +}
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
  <script src="{appAssets}vendors/js/charts/chart.min.js" type="text/javascript"></script>
  <script src="{appAssets}vendors/js/charts/echarts/echarts.js" type="text/javascript"></script>
  <script src="{assets}js/admin/ac-dashboard.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
</body>
</html>