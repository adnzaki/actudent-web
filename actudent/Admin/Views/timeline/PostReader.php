<section id="timeline" class="timeline-left timeline-wrapper col-lg-8 col-12 reduce-right-position">
	<!-- <ul class="timeline">
		<li class="timeline-line"></li>
	</ul> -->
	<ul class="timeline" id="post-reader">
		<li class="timeline-item timeline-item-without-arrow">
			<div class="timeline-card card border-grey border-lighten-2 {cardColor}">
				<div class="card-header {cardColor}">
					<h4 class="card-title {cardTitleColor}">
						<a href="javascript:void(0)">
							<span class="success-text" v-if="timelineDetail.timeline_status === 'draft'">[Draft]</span> {{ timelineDetail.timeline_title }}
						</a>
					</h4>
					<p class="card-subtitle text-muted mb-0 pt-1">
						<span class="font-small-3">
							{{ timelineDetail.created | formatDate('D MMMM YYYY | HH:mm') }} - 
							{+ lang AdminTimeline.timeline_posted_by +}: {{ timelineDetail.author }} 
						</span>
					</p>
				</div>
				<div class="card-content">
					<div class="card-body">
						<div class="row">
							<div class="col-12">
								<img class="img-thumbnail img-fluid" src="{appAssets}images/portfolio/width-1200/portfolio-1.jpg"
									itemprop="thumbnail" alt="Timeline Image 1" v-if="timelineDetail.timeline_image === null">
								<img class="img-thumbnail img-fluid" :src="helper.imageURL + timelineDetail.timeline_image"
									itemprop="thumbnail" alt="timelineDetail.timeline_title" v-else>
								<p class="card-text">
									{{ timelineDetail.timeline_content }}
								</p>
								<!-- <ul class="list-inline mb-1">
									<li class="pr-1">
										<a href="#" class="text-muted">
											<span class="la la-heart-o"></span> Like</a>
									</li>
									<li class="pr-1">
										<a href="#" class="text-muted">
											<span class="la la-comments-o"></span> Comment</a>
									</li>
								</ul>
								<div class="media" v-for="(comment, index) in timelineDetail.comments" :key="index">
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
									</div>
								</div>
								<div class="card-body" v-if="!isSmallScreen || timelineDetail.comments.length === 0">
									<fieldset class="form-group position-relative has-icon-left mb-0">
										<input type="text" class="form-control" placeholder="Write comments...">
										<div class="form-control-position">
											<i class="la la-dashcube"></i>
										</div>
									</fieldset>
								</div> -->
							</div>
						</div>
					</div>
				</div>
			</div>
        </li>
	</ul>
</section>
