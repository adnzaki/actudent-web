<h3 class="page-title text-center {cardTitleColor}">{+ lang AdminTimeline.timeline_subtitle +}</h3>
<ul class="timeline">
	<li class="timeline-line"></li>
</ul>
<ul class="timeline">
	<li class="timeline-line" v-if="!isSmallScreen"></li>
	<li v-for="(item, index) in posts" :key="index" :class="['timeline-item', evenOrOdd(index)]">
		<div class="timeline-badge" v-if="!isSmallScreen">
			<span class="bg-red bg-lighten-1" data-toggle="tooltip" data-placement="right" :title="item.author"><i
					class="la la-plane"></i></span>
		</div>
		<div class="timeline-card card border-grey border-lighten-2 {cardColor} cursor-pointer">
			<div class="card-header {cardColor}">
				<h4 class="card-title {cardTitleColor}" @click="readPost(item)">
					<a href="#post-reader">
						<span class="success-text" v-if="item.timeline_status === 'draft'">[Draft]</span> {{ item.timeline_title }}
					</a>
				</h4>
				<p class="card-subtitle text-muted mb-0 pt-1">
					<span class="font-small-3">
						{{ item.created | formatDate('D MMMM YYYY | HH:mm') }} -
						{+ lang AdminTimeline.timeline_posted_by +}: {{ item.author }}
					</span>
				</p>
				{if $_SESSION['userLevel'] === '1'}
				<div class="heading-elements bg-transparent">
					<div class="btn-group mb-1">
						<button type="button" class="btn btn-outline-primary more-action" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="true"><i class="la la-ellipsis-v"></i></button>
						<div class="dropdown-menu">
							<a class="dropdown-item action-list" href="javascript:void(0)" @click="getPostDetail(item.timeline_id)">{+
								lang Admin.perbarui +}</a>
							<a class="dropdown-item action-list" href="javascript:void(0)" @click="deleteConfirm(item.timeline_id)">{+
								lang Admin.hapus +}</a>
						</div>
					</div>
				</div>
				{endif}
			</div>
			<div class="card-content" @click="readPost(item)">
				<img class="img-fluid" src="{appAssets}images/portfolio/width-1200/portfolio-1.jpg" alt="Timeline Image 1"
					v-if="item.timeline_image === null">
				<img class="img-fluid" :src="helper.imageURL + item.timeline_image" alt="Timeline Image 1" v-else>
				<div class="card-content">
					<div class="card-body">
						<p class="card-text">
							{{ item.timeline_content | substr(100) }}
							<a href="#post-reader" @click="readPost(item)">
								<strong v-if="item.timeline_content.length > 100">{+ lang AdminTimeline.timeline_readmore +}</strong>
							</a>
						</p>
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
