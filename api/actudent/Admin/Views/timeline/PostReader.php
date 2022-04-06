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
							<span class="success-text" v-if="timelineDetail.timeline_status === 'draft'">[Draft]</span>
							{{ timelineDetail.timeline_title }}
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
							</div>
						</div>
					</div>
				</div>
			</div>
		</li>
	</ul>
</section>
