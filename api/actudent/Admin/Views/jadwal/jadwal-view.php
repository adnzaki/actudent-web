<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
	<title>Actudent - {title}</title>
	{+ include Actudent\Core\Views\component\head +}
	<link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/pickers/daterange/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/pickers/pickadate/pickadate.css">
	<link rel="stylesheet" type="text/css" href="{appAssets}css/plugins/pickers/daterange/daterange.css">
	<link rel="stylesheet" type="text/css" href="{assets}css/jadwal.css">
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
			<div class="content-body" id="jadwal-content">
				{+ include Actudent\Admin\Views\dashboard\ExpirationWarning +} 
				<div class="row">
					<div class="col-12">
						<div class="card {cardColor}">
							<div class="card-header {cardColor}" v-cloak>
								<h4 class="card-title {cardTitleColor}">{{ cardTitle }}</h4>
								<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
								<div class="heading-elements">
									<ul class="list-inline mb-0">
										<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
										<li><a data-action="reload" @click="showJadwal(gradeID, false)" v-if="helper.showJadwalMapel"><i
													class="ft-rotate-cw"></i></a></li>
										<li><a data-action="reload" @click="reloadData" v-if="!helper.showJadwalMapel"><i
													class="ft-rotate-cw"></i></a></li>
										<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
										<li><a v-if="helper.showJadwalMapel" @click="close('jadwal')"><i class="ft-x"></i></a></li>
									</ul>
								</div>
							</div>
							<div class="loader-wrapper" v-if="spinner">
								<div class="loader-container">
									<div class="ball-rotate loader-danger">
										<div></div>
									</div>
								</div>
							</div>
							{+ include Actudent\Admin\Views\siswa\alert +}
							{+ include Actudent\Admin\Views\jadwal\DataKelas +}
							{+ include Actudent\Admin\Views\jadwal\DataMapel +}
							{+ include Actudent\Admin\Views\jadwal\FormTambahMapel +}
							{+ include Actudent\Admin\Views\jadwal\FormEditMapel +}
							{+ include Actudent\Admin\Views\jadwal\JadwalPelajaran +}
							{+ include Actudent\Admin\Views\jadwal\FormKelolaJadwal +}
							{+ include Actudent\Admin\Views\jadwal\FormPengaturan +}
							{+ include Actudent\Admin\Views\jadwal\DeleteConfirm +}
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
	<script src="{appAssets}vendors/js/pickers/pickadate/picker.js" type="text/javascript"></script>
	<script src="{appAssets}vendors/js/pickers/pickadate/picker.date.js" type="text/javascript"></script>
	<script src="{appAssets}vendors/js/pickers/pickadate/picker.time.js" type="text/javascript"></script>
	{if $bahasa === 'indonesia'}
	<script src="{assets}js/admin/pickadate-id.js" type="text/javascript"></script>
	{endif}
	<script src="{assets}js/admin/ac-jadwal.js" type="module"></script>
	<!-- END PAGE LEVEL JS-->
</body>

</html>
