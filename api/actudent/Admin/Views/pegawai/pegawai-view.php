<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
	<title>Actudent - {title}</title>
	{+ include Actudent\Core\Views\component\head +}
	<link rel="stylesheet" type="text/css" href="{appAssets}css/pages/gallery.css">
	<link rel="stylesheet" type="text/css" href="{appAssets}css/plugins/images/cropper/cropper.css">
</head>

<body class="vertical-layout vertical-menu 2-columns {bodyColor} menu-expanded fixed-navbar" data-open="click"
	data-menu="vertical-menu" data-col="2-columns">
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
			<div class="content-body" id="pegawai-content">
				{+ include Actudent\Admin\Views\dashboard\ExpirationWarning +} 
				<div class="row">
					<div class="col-12">
						<div class="card {cardColor}">
							<div class="card-header {cardColor}">
								<h4 class="card-title {cardTitleColor}">{+ lang AdminPegawai.staff_title +}</h4>
								<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
								<div class="heading-elements">
									<ul class="list-inline mb-0">
										<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
										<li><a data-action="reload" @click="reloadData"><i class="ft-rotate-cw"></i></a></li>
										<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
										<li><a data-action="close"><i class="ft-x"></i></a></li>
									</ul>
								</div>
							</div>
							{+ include Actudent\Admin\Views\pegawai\DataPegawai +}
							{+ include Actudent\Admin\Views\pegawai\alert +}
							{+ include Actudent\Admin\Views\pegawai\DeleteConfirm +}
							{+ include Actudent\Admin\Views\pegawai\FormTambahPegawai +}
							{+ include Actudent\Admin\Views\pegawai\FormEditPegawai +}
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
	<script>
		var domainSekolah = "{domainSekolah}"

	</script>

	<script src="{appAssets}js/core/app-menu.js" type="text/javascript"></script>
	<script src="{appAssets}js/core/app.js" type="text/javascript"></script>
	<script src="{appAssets}js/scripts/customizer.js" type="text/javascript"></script>
	<script src="{appAssets}js/scripts/modal/components-modal.js" type="text/javascript"></script>
	<script src="{assets}js/admin/ac-pegawai.js" type="module"></script>
	<!-- <script src="{appAssets}js/scripts/extensions/image-cropper.js" type="text/javascript"></script> -->
	<!-- END PAGE LEVEL JS-->
</body>

</html>
