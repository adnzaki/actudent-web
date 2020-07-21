<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <title>Actudent - {title}</title>
  {+ include Actudent\Core\Views\component\head +}  
  <link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/forms/icheck/icheck.css">
  <link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/forms/icheck/custom.css">
  <link rel="stylesheet" type="text/css" href="{appAssets}css/pages/login-register.css">
</head>
<body class="vertical-layout vertical-menu 1-column   menu-expanded blank-page blank-page"
data-open="click" data-menu="vertical-menu" data-col="1-column" style="background-color: #52545C !important;">
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content" id="login-content" v-cloak>
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="flexbox-container">
          <div class="col-12 d-flex align-items-center justify-content-center" style="margin-top: -20px;">
            <div class="col-md-4 col-10 box-shadow-2 p-0">
              <div class="card border-grey border-lighten-3 m-0">
                <div class="card-header border-0">
                  <div class="card-title text-center">
                    <div class="p-1">
                      <img src="{images}logo/actudent-logo-full-precised.png" alt="branding logo" class="ac-logo">
                    </div>
                  </div>
                  <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2" v-if="!isSmallScreen">
                    <span>{+ lang AdminAuth.silakan_login +}</span>
                  </h6>
                  <h6 class="card-subtitle text-muted text-center font-small-3 pt-2" v-else>
                    <span>{+ lang AdminAuth.silakan_login +}</span>
                  </h6>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    <form class="form-horizontal form-simple" id="form-login" novalidate>
                      <fieldset class="form-group position-relative has-icon-left mb-0">
                        <input type="text" v-model="username" name="username" class="form-control form-control-lg input-lg" id="user-name" placeholder="Email"
                        @keyup.enter="validasi" required>
                        <div class="form-control-position">
                          <i class="ft-user"></i>
                        </div>
                      </fieldset>
                      <fieldset class="form-group position-relative has-icon-left">
                        <input type="password" v-model="password" name="password" class="form-control form-control-lg input-lg" id="user-password"
                        @keyup.enter="validasi" placeholder="Password" required>
                        <div class="form-control-position">
                          <i class="la la-key"></i>
                        </div>
                      </fieldset>
                      <div class="form-group row">
                        <div class="col-md-6 col-12 text-center text-md-left">
                          
                        </div>
                        <!-- <div class="col-md-6 col-12 text-center text-md-right"><a href="recover-password.html" class="card-link">{+ lang AdminAuth.lupa_password +}</a></div> -->
                      </div>
                      <p v-bind:class="msgClass" v-if="showMsg">{{ msg }}</p>
                      <button type="button" @click="validasi" class="btn btn-info btn-lg btn-block"><i class="ft-unlock"></i> {+ lang AdminAuth.login +}</button>
                    </form>
                  </div>
                </div>
                <!-- <div class="card-footer">
                  <div class="">
                    <p class="float-sm-left text-center m-0"><a href="recover-password.html" class="card-link">{+ lang AdminAuth.pulihkan_password +}</a></p>
                    <p class="float-sm-right text-center m-0">{+ lang AdminAuth.belum_daftar +} <a href="register-simple.html" class="card-link">{+ lang AdminAuth.daftar_disini +}</a></p>
                  </div>
                </div> -->
              </div>
            </div>
            <div :class="wolesLogo">
              <p class="center-align push-left">Powered by</p>
              <a href="https://wolestech.com" target="_blank" rel="noopener noreferrer">
                <img class="woles-img" src="{images}logo-woles-small.png" alt="branding logo"> 
              </a>                         
            </div>              
          </div>
        </section>
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <!-- BEGIN VENDOR JS-->
  {+ include Actudent\Core\Views\component\scripts +} 
  <script src="{assets}js/ac-login.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
</body>
</html>