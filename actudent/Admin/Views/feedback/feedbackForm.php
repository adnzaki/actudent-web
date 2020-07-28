<div class="row">
	<!-- Error message -->
    <alert-msg :alert-class="alert.class" 
        :header="alert.header" :text="alert.text" v-if="alert.show">
    </alert-msg>
    <!-- #End error message -->
	<div class="col-12">
		<div class="card {cardColor}">
			<div class="card-header {cardColor}">
				<h4 class="card-title {cardTitleColor}">{+ lang AdminFeedback.app_feedback_form +}</h4>
				<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li><a data-action="reload" @click="reloadData"><i class="ft-rotate-cw"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
						<li><a data-action="close"><i class="ft-x"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content">				
				<div class="card-body">
					
					<form class="form" id="sendFeedback">
						<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
							<div class="form-group">
								<label>{{ lang.app_feedback_type }}</label>				
								<select class="select2 form-control block" id="selectFeedback" name="feedback_type" style="width: 100%">
                    			<option selected value="Saran">Saran</option>
                    			<option value="Bug">Bug</option>
                    			<option value="Bantuan">Bantuan</option>
                				</select>
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
								<form action="" name="upload-file" id="upload-file" method="post" enctype="multipart/form-data"></form>
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
			{# Tambah content di sini #}
		</div>
	</div>
</div>
