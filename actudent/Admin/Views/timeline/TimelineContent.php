<section id="timeline" class="timeline-center timeline-wrapper" v-cloak>
	<h3 class="page-title text-center {cardTitleColor}">{+ lang AdminTimeline.timeline_subtitle +}</h3>
	<ul class="timeline">
		<li class="timeline-line"></li>
	</ul>
	<ul class="timeline">
		<li class="timeline-line" v-if="!isSmallScreen"></li>
		<li v-for="(item, index) in posts" :key="index" :class="['timeline-item', evenOrOdd(index)]">
			<div class="timeline-badge" v-if="!isSmallScreen">
				<span class="bg-red bg-lighten-1" data-toggle="tooltip" data-placement="right"
					:title="item.author"><i class="la la-plane"></i></span>
			</div>
			<div class="timeline-card card border-grey border-lighten-2 {cardColor} cursor-pointer">
				<div class="card-header {cardColor}">
					<h4 class="card-title {cardTitleColor}">
						<a href="#">
							<span class="success-text" v-if="item.timeline_status === 'draft'">[Draft]</span> {{ item.timeline_title }}
						</a>
					</h4>
					<p class="card-subtitle text-muted mb-0 pt-1">
						<span class="font-small-3">
							{{ item.created | formatDate('D MMMM YYYY | HH:mm') }} - 
							{+ lang AdminTimeline.timeline_posted_by +}: {{ item.author }} 
						</span>
					</p>
					<div class="heading-elements bg-transparent">
						<div class="btn-group mb-1">
							<button type="button" class="btn btn-outline-primary more-action"
								data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="la la-ellipsis-v"></i></button>
							<div class="dropdown-menu">
								<a class="dropdown-item action-list" href="javascript:void(0)" @click="getPostDetail(item.timeline_id)">{+ lang Admin.perbarui +}</a>
								<a class="dropdown-item action-list" href="javascript:void(0)">{+ lang Admin.hapus +}</a>
							</div>
						</div>
					</div>
				</div>
				<div class="card-content">
					<img class="img-fluid" src="{appAssets}images/portfolio/width-1200/portfolio-1.jpg"
						alt="Timeline Image 1" v-if="item.timeline_image === null">
					<img class="img-fluid" :src="helper.imageURL + item.timeline_image"
						alt="Timeline Image 1" v-else>
					<div class="card-content">
						<div class="card-body">
							<p class="card-text">
								{{ item.timeline_content | substr(100) }} 
								<a href="javascript:void(0)">
									<strong v-if="item.timeline_content.length > 100">{+ lang AdminTimeline.timeline_readmore +}</strong>								
								</a>
							</p>
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
								</div>
							</div>
						</div>
						<div class="card-body" v-if="!isSmallScreen || item.comments.length === 0">
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
	<ul class="timeline" id="view-more" v-if="loadMoreButton">
		<li class="timeline-line" v-if="!isSmallScreen"></li>
		<li class="timeline-group">
			<a href="#view-more" class="btn btn-primary" @click="loadMorePosts"> {+ lang AdminTimeline.timeline_loadmore +}</a>
		</li>
	</ul>
	{+ include Actudent\Admin\Views\timeline\CreatePost +}
	{+ include Actudent\Admin\Views\timeline\EditPost +}
</section>
