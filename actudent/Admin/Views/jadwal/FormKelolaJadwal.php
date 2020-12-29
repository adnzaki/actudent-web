<!-- Modal -->
<div class="modal fade text-left" id="kelolaJadwalModal" role="dialog" aria-labelledby="myModalLabel2"
	aria-hidden="true">

	<!-- Error message -->
	<alert-msg :alert-class="alert.class" :header="alert.header" :text="alert.text" v-if="alert.show">
	</alert-msg>
	<!-- #End error message -->

	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header {modalHeaderColor} white">
				<h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> {{ lang.jadwal_add_title }}</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form" id="formJadwal">
					<div class="form-body">
						<!-- ################## Lessons list ################## -->
						<div id="daftar-mapel" v-if="!scheduleManager.showInput">
							<p v-if="scheduleManager.lessonsInput.length === 0">{{ lang.jadwal_kosong }}</p>
							<div class="form-group" style="margin-bottom: 0.5rem;" v-else
								v-for="(item, index) in scheduleManager.lessonsInput" :key="index">
								<div class="input-group">
									<input class="form-control border-primary" v-model="item.text" type="text" disabled>
									<input type="hidden" name="lessons_grade_id" v-model="item.val">
									<input type="hidden" name="duration" v-model="item.duration">
									<div class="input-group-append">
										<button class="btn btn-danger" type="button" @click="removeLesson(item.id)">
											<span>
												<i class="la la-trash"></i>
											</span>
										</button>
									</div>
								</div>
							</div>
						</div>
						<!-- ################## END Lessons lsit ################## -->

						<!-- ################## This is the form ################## -->
						<div id="input-jadwal" v-else>
							<div v-if="!scheduleManager.isBreak">
								<div class="form-group">
									<label for="userinput6">{{ lang.jadwal_label_pilih_mapel }}</label>
									<div class="row">
										<div class="col-12">
											<select class="select2-mapel" style="width: 100%;" id="pilih-mapel">
											</select>
										</div>
									</div>
									<form-error :msg="error.lesson_id" />
								</div>
								<div class="form-group">
									<label for="userinput6">{{ lang.jadwal_label_pilih_ruang }}</label>
									<div class="row">
										<div class="col-12">
											<select class="select2-ruang" style="width: 100%;" id="pilih-ruang">
											</select>
										</div>
									</div>
									<form-error :msg="error.room_id" />
								</div>
								<div class="form-group">
									<label for="userinput6">{{ lang.jadwal_durasi }}</label>
									<div class="row">
										<div class="col-12">
											<select style="width: 100%;" id="durasi">
												<option value="1">1 {{ lang.jadwal_jam_pelajaran }}</option>
												<option value="2">2 {{ lang.jadwal_jam_pelajaran }}</option>
												<option value="3">3 {{ lang.jadwal_jam_pelajaran }}</option>
												<option value="4">4 {{ lang.jadwal_jam_pelajaran }}</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group" v-else>
								<label for="userinput6">{{ lang.jadwal_istirahat }} ({{ lang.jadwal_menit }})</label>
								<input class="form-control border-primary" v-model="scheduleManager.breakDuration"
									@keyup="forceInteger('breakDuration')" type="text" name="break">
							</div>
							<div class="form-group">
								<label for="jenis-jadwal">{{ lang.jadwal_tipe }}</label>
								<div class="row">
									<div class="col-md-12 col-sm-12 skin skin-square" id="jenis-jadwal">
										<div class="row">
											<div class="col-12">
												<fieldset>
													<input type="radio" name="agenda_priority" id="lesson" value="lesson" checked>
													<label>{{ lang.jadwal_belajar }}</label>
												</fieldset>
												<fieldset>
													<input type="radio" name="agenda_priority" id="break" value="break">
													<label>{{ lang.jadwal_istirahat }}</label>
												</fieldset>
												<fieldset>
													<input type="radio" name="agenda_priority" id="inactive" value="inactive">
													<label>{{ lang.jadwal_opsi_inaktif }}</label>
												</fieldset>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- ################## END Form ################## -->

					</div>
				</form>
				<button type="button" class="btn btn-outline-success center-btn full-circle" @click="closeInputJadwal"
					v-if="scheduleManager.showInput">
					<span><i class="la la-check"></i></span>
				</button>
				<button type="button" class="btn btn-outline-info center-btn full-circle" @click="showInputJadwal" v-else>
					<span><i class="la la-plus"></i></span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger" data-dismiss="modal"> {+ lang Admin.batal +}</button>
				<button type="button" :disabled="helper.disableSaveButton" class="btn btn-outline-primary" @click="saveJadwal">
					{+ lang Admin.simpan +}</button>
			</div>
		</div>
	</div>
</div>
