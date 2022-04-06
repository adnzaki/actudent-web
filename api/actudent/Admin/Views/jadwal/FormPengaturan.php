<!-- Modal -->
<div class="modal fade text-left" id="pengaturanModal" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">

	<!-- Error message -->
	<alert-msg :alert-class="alert.class" :header="alert.header" :text="alert.text" v-if="alert.show">
	</alert-msg>
	<!-- #End error message -->

	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header {modalHeaderColor} white">
				<h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> {+ lang Admin.menu_pengaturan +}
				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form" id="formPengaturan">
					<div class="form-body">
						<div class="form-group">
							<label for="userinput6">{{ lang.jadwal_label_alokasi }} ({{ lang.jadwal_menit }})</label>
							<input class="form-control border-primary" v-model="scheduleManager.allocation"
								@keyup="forceInteger('allocation')" type="text" name="lesson_hour"
								:placeholder="lang.jadwal_input_alokasi">
							<form-error :msg="error.lesson_hour" />
						</div>
						<div class="form-group">
							<label for="userinput6">{{ lang.jadwal_label_mulai }}</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text border-primary">
										<span class="ft-clock"></span>
									</span>
								</div>
								<input type='text' name="start_time" class="form-control border-primary pickatime"
									:placeholder="lang.jadwal_input_mulai" />
							</div>
							<form-error :msg="error.start_time" />
						</div><br>
						<div class="form-group">
							<label class="warning-text text-bold"><i>{+ lang Admin.peringatan +}</i></label>
							<p><i>{{ lang.jadwal_warning_pengaturan }}</i></p>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger" data-dismiss="modal"> {+ lang Admin.batal +}</button>
				<button type="button" :disabled="helper.disableSaveButton" class="btn btn-outline-primary"
					@click="savePengaturan"> {+ lang Admin.simpan +}</button>
			</div>
		</div>
	</div>
</div>
