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
  {+ include Actudent\Core\Views\component\menu +} 
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body" id="ortu-content">
      {+ include Actudent\Admin\Views\ortu\content +} 
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  {+ include Actudent\Core\Views\component\footer +} 
  <!-- BEGIN VENDOR JS-->
  {+ include Actudent\Core\Views\component\scripts +} 
  <script>
    var domainSekolah = "{domainSekolah}"
  </script>
  <script src="{appAssets}js/scripts/modal/components-modal.js" type="text/javascript"></script>
  <script src="{assets}js/admin/ac-ortu.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
</body>
</html>