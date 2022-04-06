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
  {else} 
    {+ include Actudent\Core\Views\component\MenuGuru +}
  {endif}
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body" id="feedback-content">
        {+ include Actudent\Admin\Views\dashboard\ExpirationWarning +} 
       {+ include Actudent\Admin\Views\feedback\feedbackForm +}
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  {+ include Actudent\Core\Views\component\footer +} 
  <!-- BEGIN VENDOR JS-->
  {+ include Actudent\Core\Views\component\scripts +} 
  <script src="{assets}js/admin/ac-feedback.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
</body>
</html>