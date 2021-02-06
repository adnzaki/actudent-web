<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
	<title>Actudent - {title}</title>
	{+ include Actudent\Core\Views\component\head +}
	<link rel="stylesheet" type="text/css" href="{appAssets}vendors/js/gallery/photo-swipe/photoswipe.css">
	<link rel="stylesheet" type="text/css" href="{appAssets}vendors/js/gallery/photo-swipe/default-skin/default-skin.css">
	<link rel="stylesheet" type="text/css" href="{appAssets}css/pages/timeline.css">
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
			<div class="content-body" id="timeline-content">
				{+ include Actudent\Admin\Views\dashboard\ExpirationWarning +} 
				{+ include Actudent\Admin\Views\siswa\alert +}
				<section id="timeline" class="timeline-center timeline-wrapper" v-cloak v-if="helper.postList">
					{+ include Actudent\Admin\Views\timeline\TimelineContent +}
					{+ include Actudent\Admin\Views\timeline\CreatePost +}
					{+ include Actudent\Admin\Views\timeline\EditPost +}
					{+ include Actudent\Admin\Views\timeline\DeleteConfirm +}
				</section>
				<div class="row" v-if="helper.postReader">
					{+ include Actudent\Admin\Views\timeline\PostReader +}
					{+ include Actudent\Admin\Views\timeline\OtherPosts +}
				</div>
				<button type="button" class="btn btn-warning box-shadow-4
        floating round btn-min-width mr-1 mb-1" v-if="helper.postReader" 
        @click="closePostReader">
					<strong>
						<span class="la la-arrow-left extend-la"></span>
					</strong>
				</button>
				<div class="loader-layer" v-if="spinner">
					<div class="loader-wrapper">
						<div class="loader-container">
							<div class="ball-rotate loader-danger">
								<div></div>
							</div>
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
	<script src="{appAssets}vendors/js/extensions/moment.min.js" type="text/javascript"></script>
	<script src="{appAssets}vendors/js/gallery/masonry/masonry.pkgd.min.js" type="text/javascript"></script>
	<!-- END PAGE LEVEL JS-->
	<script src="{appAssets}js/scripts/pages/timeline.js" type="text/javascript"></script>
	<script src="{assets}js/admin/ac-timeline.js" type="module"></script>
	<script src="{assets}js/locales.min.js" type="text/javascript"></script>
</body>

</html>
