  <script>
    var baseURL = "{base_url}"
    var admin = "{admin}";
    var guru = "{guru}";
    var warnaTema = "{theme}";
    var modalHeaderColor = "{modalHeaderColor}";
    var public = "{public}";
    var bahasa = "{bahasa}";
    var xhr = new XMLHttpRequest();

    let path = window.location.pathname,
        findSection = path.search('admin'),
        actudentSection
    (findSection === -1) ? actudentSection = 'guru' : actudentSection = 'admin'
  </script>
<script src="{appAssets}vendors/js/vendors.min.js" type="text/javascript"></script>
<script src="{assets}js/select2.full.min_c.js" type="text/javascript"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="{appAssets}vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>
  <!-- END PAGE VENDOR JS -->
  <!-- BEGIN MODERN JS-->
  <script src="{appAssets}js/core/app-menu.js" type="text/javascript"></script>
  <script src="{appAssets}js/core/app.js" type="text/javascript"></script>
  <script src="{appAssets}js/scripts/customizer.js" type="text/javascript"></script>
  <!-- END MODERN JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <!-- <script src="{appAssets}js/scripts/forms/form-login-register.js" type="text/javascript"></script>   -->
  <script src="{assets}js/plugin.js" type="text/javascript"></script>
  <script src="{assets}js/ss-paging-template.js" type="text/javascript"></script>
  <script src="{assets}js/ss-paging.js" type="text/javascript"></script>
  <script src="{assets}js/components.js" type="text/javascript"></script>
  