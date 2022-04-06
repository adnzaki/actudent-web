<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
	<title>Actudent - {title}</title>
	{+ include Actudent\Core\Views\component\head +}
	<link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/calendars/fullcalendar.min.css">
	<link rel="stylesheet" type="text/css" href="{appAssets}css/plugins/calendars/fullcalendar.css">
	<link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/pickers/daterange/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/pickers/pickadate/pickadate.css">
	<link rel="stylesheet" type="text/css" href="{appAssets}css/plugins/pickers/daterange/daterange.css">
	<link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/forms/toggle/bootstrap-switch.min.css">
	<link rel="stylesheet" type="text/css" href="{appAssets}vendors/css/forms/toggle/switchery.min.css">
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
			<div class="content-body" id="agenda-content">
				{+ include Actudent\Admin\Views\dashboard\ExpirationWarning +} 
				<div class="row">
					<div class="col-12">
						<div class="card {cardColor}">
							<div class="card-header {cardColor}">
								<h4 class="card-title {cardTitleColor}">{+ lang AdminAgenda.agenda_title +}</h4>
								<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
							</div>
							{+ include Actudent\Admin\Views\agenda\calendar +}
							{+ include Actudent\Admin\Views\agenda\FormTambahAgenda +}
							{if $_SESSION['userLevel'] === '1'}
							  {+ include Actudent\Admin\Views\agenda\FormEditAgenda +}
							{elseif $_SESSION['userLevel'] === '2'}
							  {+ include Actudent\Admin\Views\agenda\DetailAgenda +}
							{endif}
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
	<script src="{appAssets}vendors/js/extensions/fullcalendar.min.js" type="text/javascript"></script>
	<script src="{appAssets}vendors/js/pickers/pickadate/picker.js" type="text/javascript"></script>
	<script src="{appAssets}vendors/js/pickers/pickadate/picker.date.js" type="text/javascript"></script>
	<script src="{appAssets}vendors/js/pickers/pickadate/picker.time.js" type="text/javascript"></script>
	<script src="{appAssets}vendors/js/forms/toggle/bootstrap-switch.min.js" type="text/javascript"></script>
	<script src="{appAssets}vendors/js/forms/toggle/bootstrap-checkbox.min.js" type="text/javascript"></script>
	<script src="{appAssets}vendors/js/forms/toggle/switchery.min.js" type="text/javascript"></script>
	<!-- <script src="{appAssets}js/scripts/forms/switch.js" type="text/javascript"></script> -->
	{if $bahasa === 'indonesia'}
	<script src="{assets}js/admin/pickadate-id.js" type="text/javascript"></script>
	{endif}
	<!-- <script src="{appAssets}vendors/js/pickers/pickadate/legacy.js" type="text/javascript"></script> -->
	<!-- <script src="{appAssets}vendors/js/pickers/dateTime/moment-with-locales.min.js" -->
	<!-- <script src="{appAssets}js/scripts/pickers/dateTime/pick-a-datetime.js" -->
	<script src="{assets}js/admin/ac-agenda.js" type="text/javascript"></script>
	<script src="{assets}js/admin/locale-all.js" type="text/javascript"></script>
	<!-- END PAGE LEVEL JS-->
</body>

</html>
