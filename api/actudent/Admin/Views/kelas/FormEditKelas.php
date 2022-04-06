<!-- Modal -->
<div class="modal fade text-left" id="editKelasModal" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">

	<!-- Error message -->
	<alert-msg :alert-class="alert.class" :header="alert.header" :text="alert.text" v-if="alert.show">
	</alert-msg>
	<!-- #End error message -->

	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header {modalHeaderColor} white">
				<h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> {{ lang.kelas_edit_title }}</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form" id="formEditKelas">
					<div class="form-body">
						<div class="form-group">
							<label for="userinput6">{{ lang.kelas_label_nama }}</label>
							<input class="form-control border-primary" type="text" v-model="detailKelas.grade_name"
								:placeholder="makeSentenceCase(lang.kelas_label_nama)" name="grade_name">
							<form-error :msg="error.grade_name" />
						</div>
						<div class="form-group">
							<label for="userinput6">{{ lang.kelas_wali }}</label>
							<div class="input-group">
								<input class="form-control border-primary" type="text" v-model="searchParam"
									:placeholder="lang.kelas_input_wali" @keyup="searchTeacher">
								<div class="input-group-append">
									<button class="btn btn-primary" type="button" @click="clearResult">{+ lang Admin.bersihkan +}</button>
								</div>
							</div>
							<div class="list-group list-group-custom add-margin-top-5px" v-if="searchResultWrapper">
								<a v-if="teachers.length === 0" href="javascript:void(0)" class="list-group-item list-group-item-action 
                                    list-group-item-custom">
									{+ lang Admin.no_search_result +} "{{ searchParam }}"
								</a>
								<a v-else href="javascript:void(0)" class="list-group-item list-group-item-action 
                                    list-group-item-custom" v-for="item in teachers" @click="selectTeacher(item)">
									{{ item.staff_name }} ({{item.staff_nik}})
								</a>
							</div>
						</div>
						<div class="form-group">
							<label for="userinput6">{{ lang.kelas_label_walikelas }}</label>
							<input class="form-control border-primary" disabled type="text" :placeholder="lang.kelas_input_walikelas"
								v-model="selectedTeacher.name">
							<input type="hidden" name="teacher_id" v-model="selectedTeacher.id">
							<form-error :msg="error.teacher_id" />
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger" data-dismiss="modal"> {+ lang Admin.batal +}</button>
				<button type="button" :disabled="helper.disableSaveButton" class="btn btn-outline-primary"
					@click="save(true, detailKelas.grade_id)"> {+ lang Admin.simpan +}</button>
			</div>
		</div>
	</div>
</div>
