<div class="col-lg-4 col-12 reduce-right-position add-top-position">
	<div class="card {cardColor}">
		<div class="card-header {cardColor}">
			<h4 class="card-title {cardTitleColor}">{+ lang AdminTimeline.timeline_other_post_title +}</h4>
		</div>
		<div class="card-content collapse show">
			<div class="card-body">
				<div class="list-group">
					<a href="javascript:void()" class="list-group-item list-group-item-action" v-for="(item, index) in posts"
						v-if="index < 10 && item.timeline_id !== helper.timelineID" @click="readPost(item, true)">
						{{ item.timeline_title }}
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
