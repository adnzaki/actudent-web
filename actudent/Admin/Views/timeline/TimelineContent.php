<section id="timeline" class="timeline-center timeline-wrapper">
	<h3 class="page-title text-center {cardTitleColor}">{+ lang AdminTimeline.timeline_subtitle +}</h3>
	<ul class="timeline">
		<li class="timeline-line"></li>
		<!-- <li class="timeline-group">
			<a href="#" class="btn btn-primary"><i class="la la-calendar-o"></i> Today</a>
		</li> -->
	</ul>
	<ul class="timeline">
		<li class="timeline-line"></li>
		<li v-for="(item, index) in posts" :key="index" :class="['timeline-item', evenOrOdd(index)]">
			<div class="timeline-badge">
				<span class="bg-red bg-lighten-1" data-toggle="tooltip" data-placement="right"
					:title="item.author"><i class="la la-plane"></i></span>
			</div>
			<div class="timeline-card card border-grey border-lighten-2 {cardColor}">
				<div class="card-header {cardColor}">
					<h4 class="card-title {cardTitleColor}"><a href="#">{{ item.timeline_title }}</a></h4>
					<p class="card-subtitle text-muted mb-0 pt-1">
						<span class="font-small-3">{{ item.timeline_date }}</span>
					</p>
					<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
				</div>
				<div class="card-content">
					<img class="img-fluid" src="{appAssets}images/portfolio/width-1200/portfolio-1.jpg"
						alt="Timeline Image 1">
					<div class="card-content">
						<div class="card-body">
							<p class="card-text">{{ item.timeline_content }}</p>
							<!-- <ul class="list-inline">
								<li class="pr-1">
									<a href="#" class="">
										<span class="la la-commenting-o"></span> {+ lang Admin.komentar +}</a>
								</li>
							</ul> -->
							<ul class="list-inline">
								<li>
									<strong>999 {+ lang Admin.view +}</strong>
								</li>
							</ul>
						</div>
					</div>
					<div class="card-footer px-0 py-0 {cardColor}">
						<div class="card-body reduce-card-body" v-for="(comment, index) in item.comments" :key="index">
							<div class="media">
								<div class="media-left pr-1">
									<a href="#">
										<span class="avatar avatar-online">
											<img src="{appAssets}images/portrait/small/avatar-s-1.png" alt="avatar">
										</span>
									</a>
								</div>
								<div class="media-body">
									<p class="text-bold-600 mb-0"><a href="#">{{ comment.commenter }}</a></p>
									<p class="m-0">{{ comment.comment_content }}</p>
									<ul class="list-inline mb-1">
										<li class="pr-1">
											<a href="#" class="">
												<span class="la la-commenting-o"></span> Replay</a>
										</li>
										<li class="pr-1">
											<a href="#" class="" v-if="comment.replies > 0">
											<u>{+ lang Admin.tampilkan +} {{ comment.replies }} {+ lang Admin.balasan +}</u>
											</a>
										</li>
									</ul>
									<!-- <div class="media">
										<div class="media-left pr-1">
											<a href="#">
												<span class="avatar avatar-online">
													<img src="{appAssets}images/portrait/small/avatar-s-18.png"
														alt="avatar">
												</span>
											</a>
										</div>
										<div class="media-body">
											<p class="text-bold-600 mb-0"><a href="#">Janice Johnston</a></p>
											<p>Gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</p>
											<ul class="list-inline mb-1">
												<li class="pr-1">
													<a href="#" class="">
														<span class="la la-thumbs-o-up"></span> Like</a>
												</li>
												<li class="pr-1">
													<a href="#" class="">
														<span class="la la-commenting-o"></span> Replay
													</a>
												</li>
											</ul>
										</div>
									</div> -->
								</div>
							</div>
						</div>
						<div class="card-body">
							<fieldset class="form-group position-relative has-icon-left mb-0">
								<input type="text" class="form-control" placeholder="Write comments...">
								<div class="form-control-position">
									<i class="la la-dashcube"></i>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
        </li>
	</ul>
	{+ include Actudent\Admin\Views\timeline\CreatePost +}
</section>
