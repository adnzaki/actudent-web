<div class="row">
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
					<p>{+ lang AdminFeedback.app_feedback_type +}</p>
					<div class="row">
						<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
							<div class="form-group">	
						
								<select class="select2 form-control block" id="selectStaff" name="staff_type" style="width: 100%">
                    			<option selected value="null">Saran</option>
                    			<option value="teacher">Bug</option>
                    			<option value="staff">Bantuan</option>
                				</select>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
                            	<label for="userinput6">{{ lang.feedback_label_desc }}</label>
                           		<textarea class="form-control border-primary" type="text" :placeholder="lang.feedback_input_desc" name="agenda_description"></textarea>
                            	<!-- <form-error :msg="error.agenda_description" /> -->
                        	</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label>{{ lang.feedback_label_att }}</label>
								<form action="" name="upload-file" id="upload-file" method="post" enctype="multipart/form-data">
								<input class="form-control border-primary" type="file" accept="application/pdf" name="agenda_attachment">
								</form>
								<!-- <form-error :msg="error.agenda_attachment" /> -->
                			</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<p></p>
								<button type="button" class="btn btn-outline-info btn-min-width mr-1 mb-1"
								@click="setTheme">{+ lang Admin.kirim +}</button>
							</div>
						</div>						
					</div>
				</div>
			</div>
			{# Tambah content di sini #}
		</div>
	</div>
</div>
