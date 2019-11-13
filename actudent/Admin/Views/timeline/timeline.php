<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <title>Actudent - {title}</title>
  {+ include Actudent\Core\Views\component\head +} 
  <link rel="stylesheet" type="text/css" href="{appAssets}vendors/js/gallery/photo-swipe/photoswipe.css">
  <link rel="stylesheet" type="text/css" href="{appAssets}vendors/js/gallery/photo-swipe/default-skin/default-skin.css">
  <link rel="stylesheet" type="text/css" href="{appAssets}css/pages/timeline.css">
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
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">{+ lang AdminTimeline.timeline_title +}</h3>
        </div> 
      </div>
      <div class="content-body" id="timeline-content">
        {+ include Actudent\Admin\Views\timeline\TimelineContent +}
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  {+ include Actudent\Core\Views\component\footer +} 
  <!-- BEGIN VENDOR JS-->
  {+ include Actudent\Core\Views\component\scripts +} 
  <script src="{appAssets}vendors/js/gallery/masonry/masonry.pkgd.min.js" type="text/javascript"></script>
  <script src="{appAssets}vendors/js/gallery/photo-swipe/photoswipe.min.js" type="text/javascript"></script>
  <script src="{appAssets}vendors/js/gallery/photo-swipe/photoswipe-ui-default.min.js" type="text/javascript"></script>
  <script src="{appAssets}vendors/js/charts/echarts/echarts.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
  <script src="{appAssets}js/scripts/charts/echarts/bar-column/stacked-column.js" type="text/javascript"></script>
  <script src="{appAssets}js/scripts/charts/echarts/radar-chord/non-ribbon-chord.js" type="text/javascript"></script>
  <script src="{appAssets}js/scripts/gallery/photo-swipe/photoswipe-script.js" type="text/javascript"></script>
  <script src="{appAssets}js/scripts/pages/timeline.js" type="text/javascript"></script>
  <script src="{assets}js/admin/ac-timeline.js" type="text/javascript"></script>
</body>
</html>