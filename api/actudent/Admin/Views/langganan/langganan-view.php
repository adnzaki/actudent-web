<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <title>Actudent - {title}</title>
  {+ include Actudent\Core\Views\component\head +}
  <!-- END Custom CSS-->
  <link rel="stylesheet" type="text/css" href="{appAssets}fonts/simple-line-icons/style.min.css">
  <link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/cryptocoins/cryptocoins.css">
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
      <div class="content-body" id="langganan-content">
        {+ include Actudent\Admin\Views\dashboard\ExpirationWarning +} 
        <div class="row">
					<div class="col-12">
						<div class="card {cardColor}">
							<div class="card-header {cardColor}">
								<h4 class="card-title {cardTitleColor}">{+ lang AdminLangganan.subs_page_title +}</h4>
								<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
								<div class="heading-elements">
									<ul class="list-inline mb-0">
										<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
										<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
									</ul>
								</div>
							</div>
              {+ include Actudent\Admin\Views\langganan\DataLangganan +}
              {+ include Actudent\Admin\Views\langganan\FormLangganan +}
							{+ include Actudent\Admin\Views\ortu\alert +}
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
  <script src="{assets}js/admin/ac-langganan.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
</body>
</html>