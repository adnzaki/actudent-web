<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <title>Actudent - {title}</title>
  {+ include Actudent\Core\Views\component\head +} 
  <link rel="stylesheet" type="text/css" href="{appAssets}vendors/js/gallery/photo-swipe/photoswipe.css">
  <link rel="stylesheet" type="text/css" href="{appAssets}vendors/js/gallery/photo-swipe/default-skin/default-skin.css">
  <link rel="stylesheet" type="text/css" href="{appAssets}css/pages/timeline.css">
  <!-- <link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/editors/summernote.css"> -->
  <link rel="stylesheet" type="text/css" href="{assets}js/lib/summernote/summernote.css">
  <link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/editors/codemirror.css">
  <link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/editors/theme/monokai.css">
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
      <div class="content-body" id="timeline-content">
        {+ include Actudent\Admin\Views\siswa\alert +}
        {+ include Actudent\Admin\Views\timeline\TimelineContent +}
        <div class="loader-layer" v-if="spinner">
            <div class="loader-wrapper">
                <div class="loader-container">
                    <div class="ball-rotate loader-danger">
                        <div></div>
                    </div>
                </div>
            </div>            
        </div>
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  {+ include Actudent\Core\Views\component\footer +} 
  <!-- BEGIN VENDOR JS-->
  {+ include Actudent\Core\Views\component\scripts +} 
  <script src="{appAssets}vendors/js/extensions/moment.min.js" type="text/javascript"></script>
  <script src="{appAssets}vendors/js/gallery/masonry/masonry.pkgd.min.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
  <script src="{appAssets}js/scripts/pages/timeline.js" type="text/javascript"></script>
  <script src="{assets}js/admin/ac-timeline.js" type="text/javascript"></script>
  <script src="{assets}js/locales.min.js" type="text/javascript"></script>
</body>
</html>