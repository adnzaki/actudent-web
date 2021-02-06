<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
	<title>Actudent - {title}</title>
	{+ include Actudent\Core\Views\component\head +}
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
			<div class="content-body" id="ortu-content">
				{+ include Actudent\Admin\Views\dashboard\ExpirationWarning +} 
				<div class="row">
					<div class="col-12">
						<div class="card {cardColor}">
							<div class="card-header {cardColor}">
								<h4 class="card-title {cardTitleColor}">{+ lang AdminOrtu.ortu_title +}</h4>
								<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
								<div class="heading-elements">
									<ul class="list-inline mb-0">
										<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
										<li><a data-action="reload" @click="reloadData"><i class="ft-rotate-cw"></i></a></li>
										<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
									</ul>
								</div>
							</div>
							{+ include Actudent\Admin\Views\ortu\DataOrtu +}
							{+ include Actudent\Admin\Views\ortu\alert +}
							{+ include Actudent\Admin\Views\ortu\DeleteConfirm +}
							{+ include Actudent\Admin\Views\ortu\FormTambahOrtu +}
							{+ include Actudent\Admin\Views\ortu\FormEditOrtu +}
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
	<script src="{appAssets}js/scripts/modal/components-modal.js" type="text/javascript"></script>
	<script src="{assets}js/admin/ac-ortu.js" type="module"></script>
	<!-- END PAGE LEVEL JS-->
</body>

</html>
