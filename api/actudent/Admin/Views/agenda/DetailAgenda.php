<!-- Success message -->
<alert-msg alert-class="bg-success" header="{+ lang Admin.sukses +}" :text="alert.text" v-if="alert.show">
</alert-msg>
<!-- Start modal form -->
<div class="modal fade text-left" id="editAgenda" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
	<!-- Error message -->
	<alert-msg :alert-class="alert.class" :header="alert.header" :text="alert.text" v-if="alert.show">
	</alert-msg>
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header {modalHeaderColor} white">
				<h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> {{ lang.agenda_detail_title }}</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form" id="formEditAgenda">
					<div class="form-body">
						<div class="form-group">
							<label>{{ lang.agenda_label_nama }}</label>
							<input class="form-control border-primary" v-model="eventDetail.data.agenda_name" type="text"
								:placeholder="lang.agenda_input_nama" name="agenda_name" disabled>
							<form-error :msg="error.agenda_name" />
						</div>

						<div class="row">
							<div class="col-12"><label>{{ lang.agenda_label_start }}</label></div>
						</div>

						<div class="row">
							<div class="col-md-7 col-sm-7 col-12">
								<div class="form-group">
									<input type="hidden" name="agenda_start" v-model="agendaStartEdit">
									<div class="input-group">
										<input type='text' name="agendaDateStartEdit" id="pickadate-edit-start"
											class="form-control border-primary pickadate-selectors" :placeholder="lang.agenda_input_start" />
										<div class="input-group-append">
											<span class="input-group-text border-primary">
												<span class="la la-calendar-o"></span>
											</span>
										</div>
									</div>
									<form-error :msg="error.agenda_start" />
								</div>
							</div>
							<div class="col-md-5 col-sm-5 col-12">
								<div class="form-group">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text border-primary">
												<span class="ft-clock"></span>
											</span>
										</div>
										<input type='text' name="timestartEdit" :disabled="helper.fullDayEvent" id="pickatime-edit-start"
											:class="['form-control border-primary pickatime-edit', timepickerStatus]"
											:placeholder="lang.agenda_label_timestart" />
									</div>
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-12"><label>{{ lang.agenda_label_end }}</label></div>
						</div>
						<div class="row">
							<div class="col-md-7 col-sm-7 col-12">
								<div class="form-group">
									<input type="hidden" name="agenda_end" v-model="agendaEndEdit">
									<div class="input-group">
										<input type='text' name="agendaDateEndEdit" id="pickadate-edit-end"
											class="form-control border-primary pickadate-selectors" :placeholder="lang.agenda_input_end" />
										<div class="input-group-append">
											<span class="input-group-text border-primary">
												<span class="la la-calendar-o"></span>
											</span>
										</div>
									</div>
									<form-error :msg="error.agenda_end" />
								</div>
							</div>
							<div class="col-md-5 col-sm-5 col-12">
								<div class="form-group">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text border-primary">
												<span class="ft-clock"></span>
											</span>
										</div>
										<input type='text' name="timeendEdit" :disabled="helper.fullDayEvent" id="pickatime-edit-end"
											:class="['form-control border-primary pickatime-edit', timepickerStatus]"
											:placeholder="lang.agenda_label_timeend" />
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="userinput6">{{ lang.agenda_label_desc }}</label>
							<textarea class="form-control border-primary" type="text" v-model="eventDetail.data.agenda_description"
								:placeholder="lang.agenda_input_desc" name="agenda_description" disabled></textarea>
							<form-error :msg="error.agenda_description" />
						</div>

						<div class="form-group">
							<label for="userinput6">{{ lang.agenda_label_prior }}</label>
							<div class="row">
								<div class="col-12">
									<div :class="['badge', priorityClass, 'add-margin-right-5px add-margin-top-5px']">
										{{ setPriority }}
									</div>
								</div>
							</div>
							<form-error :msg="error.agenda_priority" />
						</div>

						<div class="form-group">
							<label>{{ lang.agenda_label_loc }}</label>
							<input class="form-control border-primary" type="text" v-model="eventDetail.data.agenda_location"
								:placeholder="lang.agenda_input_loc" name="agenda_location" disabled>
							<form-error :msg="error.agenda_location" />
						</div>

						<div class="form-group" v-if="guestToDisplay.length > 0">
							<label for="userinput6">{{ lang.agenda_label_guest }} </label>
							<input type="hidden" name="agenda_guest" v-model="guestWrapper">
							<div class="row add-margin-bottom-5px">
								<div class="col-12">
									<div class="badge badge-primary add-margin-right-5px add-margin-top-5px
                                    cursor-pointer" v-for="tamu in guestToDisplay" :key="tamu.id">
										{{ tamu.name }}
									</div>
								</div>
							</div>
						</div>
					</div>
					<input type="hidden" name="file_uploaded" id="file_uploaded" v-model="helper.fileUploaded">
				</form>
				<div class="form-group">
					<label v-if="helper.hasAttachment">{{ lang.agenda_label_att_name }}
						<a target="_blank" class="text-primary" :href="agenda + 'display-attachment/' + eventDetail.data.agenda_id">
							<strong>{{ eventDetail.data.agenda_attachment }}</strong>
						</a>
					</label>
				</div>
			</div>
			<div class="modal-footer">
				<div class="col-12 text-right" v-if="helper.showSaveButton">
					<button type="button" class="btn btn-outline-warning" data-dismiss="modal"> {+ lang Admin.tutup +}</button>
				</div>
			</div>
		</div>
	</div>
</div>
