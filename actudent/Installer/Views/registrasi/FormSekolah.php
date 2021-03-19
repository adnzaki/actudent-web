<div class="card-content">				
	<div class="card-body">		
		<form class="form" id="sendFeedback">
			<div class="col-12">
				<div class="form-group">
					<label>{+ lang AdminFeedback.feedback_label_email +}</label>
					<input class="form-control border-primary" type="text" 
						placeholder="{+ lang AdminFeedback.feedback_input_email +}" name="feedback_email">
					<form-error :msg="error.feedback_email" />
				</div>
			</div>
			<div class="col-12">
				<div class="form-group">
					<label for="userinput6">{{ lang.feedback_label_desc }}</label>
					<textarea class="form-control border-primary" type="text" minlength="10" :placeholder="lang.feedback_input_desc" name="feedback_description"></textarea>
					<form-error :msg="error.feedback_description" />
				</div>
			</div>
			<div class="col-12">
				<div class="form-group">
					<label>{+ lang AdminFeedback.feedback_label_email +}</label>
					<input class="form-control border-primary" type="email" 
						placeholder="{+ lang AdminFeedback.feedback_input_email +}" name="feedback_email">
					<form-error :msg="error.feedback_email" />
				</div>
			</div>
			<div class="col-12">
				<div class="form-group">
					<label>{{ lang.feedback_label_att }}</label>
					<form action="" name="upload-file" id="upload-file" method="post" enctype="multipart/form-data">
						<input name="feedback_image" class="form-control border-primary" type="file" accept="image/*">
						<p class="text-bold success-text" v-if="helper.uploadProgress">{+ lang AdminTimeline.timeline_upload_progress +}</p>
						<form-error :msg="error.feedback_image" />
					</form>
				</div>
			</div>
			<div class="col-12">
				<div class="form-group">
					<p></p>
					<button type="button" class="btn btn-outline-info btn-min-width mr-1 mb-1"
					@click="send" :disabled="helper.disableSaveButton">{+ lang Admin.kirim +}</button>
				</div>
			</div>						
		</form>
	</div>
</div>