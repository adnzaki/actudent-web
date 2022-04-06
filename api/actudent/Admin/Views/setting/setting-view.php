<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <title>Actudent - {title}</title>
  {+ include Actudent\Core\Views\component\head +}
  <!-- END Custom CSS-->
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
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">{+ lang AdminSetting.app_setting_title +}</h3>
        </div>     
      </div>
      <div class="content-body" id="setting-content">
      {+ include Actudent\Admin\Views\dashboard\ExpirationWarning +} 
      {+ include Actudent\Admin\Views\setting\AppTheme +} 
      {+ include Actudent\Admin\Views\setting\AppLanguage +} 
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  {+ include Actudent\Core\Views\component\footer +} 
  <!-- BEGIN VENDOR JS-->
  {+ include Actudent\Core\Views\component\scripts +} 
  <script src="{assets}js/admin/ac-setting.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
</body>
</html>