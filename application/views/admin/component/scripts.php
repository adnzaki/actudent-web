<script src="{appAssets}vendors/js/vendors.min.js" type="text/javascript"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="{appAssets}vendors/js/charts/chart.min.js" type="text/javascript"></script>
  <script src="{appAssets}vendors/js/charts/echarts/echarts.js" type="text/javascript"></script>
  <script src="{appAssets}vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>
  <script src="{appAssets}vendors/js/forms/validation/jqBootstrapValidation.js"
  type="text/javascript"></script>
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN MODERN JS-->
  <script src="{appAssets}js/core/app-menu.js" type="text/javascript"></script>
  <script src="{appAssets}js/core/app.js" type="text/javascript"></script>
  <script src="{appAssets}js/scripts/customizer.js" type="text/javascript"></script>
  <!-- END MODERN JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <script src="{appAssets}js/scripts/pages/dashboard-crypto.js" type="text/javascript"></script>
  <script src="{appAssets}js/scripts/forms/form-login-register.js" type="text/javascript"></script>
  <script src="{assets}js/ss-paging.js" type="text/javascript"></script>
  
  <script>
    var baseURL = "<?= base_url() ?>";
    var admin = "<?= $admin ?>";
    var warnaTema = "<?= $theme ?>";
    Vue.component('form-error', {
        props: ['msg'],
        template: '<p class="error-text">{{ msg }}</p>'
    })
  </script>