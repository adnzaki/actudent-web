
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="{+ lang Admin.meta_desc +}">
  <meta name="keywords" content="sekolah, aplikasi sekolah, aplikasi absensi, web absensi, modern web, aplikasi siswa, aplikasi orang tua">
  <meta name="author" content="PIXINVENT">
  <link rel="apple-touch-icon" href="{appAssets}images/ico/apple-icon-120.png">
  <link rel="shortcut icon" type="image/x-icon" href="{appAssets}images/ico/favicon.ico">
  <!-- Fonts -->
  <link href="{fonts}fonts.css" rel="stylesheet">
  <!-- Line Awesome -->
  <link href="{assets}line-awesome/css/line-awesome.min.css" rel="stylesheet">
  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="{appAssets}css/vendors.css">
  <link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/forms/selects/select2.min.css">
  <link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/forms/icheck/icheck.css">
  <link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/forms/icheck/custom.css">
  <!-- END VENDOR CSS-->
  <!-- BEGIN MODERN CSS-->
  <link rel="stylesheet" type="text/css" href="{appAssets}css/app.css">
  <!-- END MODERN CSS-->
  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="{appAssets}css/core/menu/menu-types/vertical-menu.css">
  <link rel="stylesheet" type="text/css" href="{appAssets}css/core/colors/palette-gradient.css">
  <link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/cryptocoins/cryptocoins.css">
  <!-- END Page Level CSS-->
  <!-- BEGIN Custom CSS-->
  <link rel="stylesheet" type="text/css" href="{assets}css/animate.css">
  <link rel="stylesheet" type="text/css" href="{assets}css/style.css">
  <link rel="stylesheet" type="text/css" href="{assets}css/actudent.css">
  <link rel="stylesheet" type="text/css" href="{appAssets}css/plugins/loaders/loaders.min.css">
  <link rel="stylesheet" type="text/css" href="{appAssets}css/core/colors/palette-loader.css">
  {if $theme === 'night-vision'}
    <link rel="stylesheet" type="text/css" href="{assets}css/actudent-night.css">
  {endif}
  <!-- END Custom CSS-->
  {if ENVIRONMENT === 'development'}
    <script src="{assets}js/vue.js" type="text/javascript"></script>
  {elseif ENVIRONMENT === 'production'}
    <script src="{assets}js/vue.min.js" type="text/javascript"></script>
  {endif}

  <script src="{assets}js/vue-material-checkbox.js" type="text/javascript"></script>