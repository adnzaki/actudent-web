<!DOCTYPE html>
<html lang="en">
<head>
	<title>Actudent - {title}</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
    <link rel="apple-touch-icon" sizes="180x180" href="{images}icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{images}icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{images}icon/favicon-16x16.png">
    <link rel="manifest" href="{images}icon/site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="{images}icon/favicon.ico">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{newLogin}vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{newLogin}fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{newLogin}fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{newLogin}vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{newLogin}vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{newLogin}vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{newLogin}css/util.css">
    <link rel="stylesheet" type="text/css" href="{newLogin}css/main.css">
    
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{newLogin}css/custom.css">
    <link href="{fonts}fonts.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{assets}css/actudent.css">
    {if ENVIRONMENT === 'development'}
        <script src="{assets}js/vue.js" type="text/javascript"></script>
    {elseif ENVIRONMENT === 'production'}
        <script src="{assets}js/vue.min.js" type="text/javascript"></script>
    {endif}
<!--===============================================================================================-->

</head>
<body>
	
	<div class="limiter" id="login-content">
		<div class="container-login100">
			<div class="wrap-login100 p-l-50 p-r-50 p-t-20 p-b-30">
				<form class="login100-form" id="form-login" novalidate>                    
                    <span class="login100-form-title p-b-20">
                        <img src="{images}logo/actudent-logo-full-precised.png" alt="branding logo" class="ac-logo">                        
                    </span>
                    <span class="login-text p-t-10 p-b-20">
                        {+ lang AdminAuth.silakan_login +}
                    </span>

					<div class="wrap-input100 validate-input m-b-16">
                        <input class="input100" type="text" v-model="username" name="username" 
                        placeholder="Email" @keyup.enter="validasi" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<span class="lnr lnr-envelope"></span>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-16">
                        <input class="input100" type="password" v-model="password" name="password" 
                        @keyup.enter="validasi" placeholder="Password" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<span class="lnr lnr-lock"></span>
						</span>
                    </div>
                    <div class="contact100-form-checkbox m-l-4">
						<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
						<label class="label-checkbox100" for="ckb1">
						{+ lang AdminAuth.remember_me +}
						</label>
					</div>
					<div class="contact100-form-checkbox m-l-4" style="width: 100%;">
						<p v-bind:class="msgClass" v-if="showMsg">{{ msg }}</p>
					</div>
					<div class="container-login100-form-btn p-t-25">
						<button type="button" class="login100-form-btn" @click="validasi">
                            {+ lang AdminAuth.login +}
						</button>
					</div>					
                </form>                
                 
            </div>
            <div :class="wolesLogo">
                <p class="center-align push-left">Powered by</p>
                <a href="https://wolestech.com" target="_blank" rel="noopener noreferrer">
                    <img class="woles-img" src="{images}LOGO-WOLES-white-small.png" alt="branding logo"> 
                </a>                         
            </div> 
		</div>
	</div>
	

	
<!--===============================================================================================-->	
	<script src="{newLogin}vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="{newLogin}vendor/bootstrap/js/popper.js"></script>
	<script src="{newLogin}vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="{newLogin}vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
    {+ include Actudent\Core\Views\component\scripts +}     
    <script src="{assets}js/ac-login.js" type="module"></script>

</body>
</html>