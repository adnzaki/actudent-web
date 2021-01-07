<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
	<title>Actudent - {title}</title>
	{+ include Actudent\Core\Views\component\head +}
	<link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/pickers/daterange/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/pickers/pickadate/pickadate.css">
	<link rel="stylesheet" type="text/css" href="{appAssets}css/plugins/pickers/daterange/daterange.css">
	<link rel="stylesheet" type="text/css" href="{assets}css/custom-spinner.css">
</head>

<body class="vertical-layout vertical-menu 2-columns {bodyColor} menu-expanded fixed-navbar" data-open="click"
	data-menu="vertical-menu" data-col="2-columns">
	<!-- fixed-top-->
	{+ include Actudent\Core\Views\component\fixednavbar +}
	<!-- ////////////////////////////////////////////////////////////////////////////-->

	<!-- Menu -->
	{if $_SESSION['userLevel'] === '1'}
	{+ include Actudent\Core\Views\component\menu +}
	{else}
	{+ include Actudent\Core\Views\component\MenuGuru +}
	{endif}
	<!-- ////////////////////////////////////////////////////////////////////////////-->
	<div class="app-content content">
		<div class="content-wrapper">
			<div class="content-header row">
			</div>
			<div class="content-body" id="nilai-content">
				<div class="row">
					<div class="col-12">
						<div class="card {cardColor}">
							<div class="card-header {cardColor}">
								<h4 class="card-title {cardTitleColor}">{+ lang AdminNilai.nilai_title +}</h4>
								<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
								<div class="heading-elements">
									<ul class="list-inline mb-0">
										<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
										<li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
										<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
									</ul>
								</div>
							</div>
							<div class="loader-layer" v-if="spinner">
								<div class="loader-wrapper">
									<div class="loader-container">
										<div class="ball-rotate loader-danger">
											<div></div>
										</div>
									</div>
								</div>
							</div>
							{+ include Actudent\Admin\Views\siswa\alert +}
							<div class="card-content collapse show" v-if="helper.daftarNilai" v-cloak>
                {+ include Actudent\Admin\Views\nilai\NilaiSiswa +}
                {+ include Actudent\Admin\Views\nilai\ListNilai +}
							</div>
							{+ include Actudent\Admin\Views\nilai\FormTambahNilai +}
							{+ include Actudent\Admin\Views\nilai\FormEditNilai +}
							{+ include Actudent\Admin\Views\nilai\DeleteConfirm +}
							{+ include Actudent\Admin\Views\nilai\KelolaNilai +}
							{+ include Actudent\Guru\Views\nilai\DaftarPelajaran +}
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
	<script src="{appAssets}js/scripts/modal/components-modal.js" type="text/javascript"></script>
	<script src="{appAssets}vendors/js/extensions/moment.min.js" type="text/javascript"></script>
	<script src="{appAssets}vendors/js/pickers/pickadate/picker.js" type="text/javascript"></script>
	<script src="{appAssets}vendors/js/pickers/pickadate/picker.date.js" type="text/javascript"></script>
	<script src="{appAssets}vendors/js/pickers/pickadate/picker.time.js" type="text/javascript"></script>

	{if $bahasa === 'indonesia'}
	<script src="{assets}js/admin/pickadate-id.js" type="text/javascript"></script>
	{endif}
	<script src="{assets}js/admin/ac-nilai.js" type="text/javascript"></script>
	<script src="{assets}js/locales.min.js" type="text/javascript"></script>
	<!-- END PAGE LEVEL JS-->
</body>

</html>
