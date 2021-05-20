<!-- Modal -->
<div class="modal fade text-left" id="editSiswaModal" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">

	<!-- Error message -->
	<alert-msg :alert-class="alert.class" :header="alert.header" :text="alert.text" v-if="alert.show">
	</alert-msg>
	<!-- #End error message -->

	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header {modalHeaderColor} white">
				<h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> {{ lang.siswa_edit_title }}</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form" id="formEditSiswa">
					<div class="form-body">
						<div class="form-group">
							<label for="userinput5">{{ lang.siswa_nis }}</label>
							<input class="form-control border-primary" type="text" v-model="detailSiswa.student_nis" minlength="9"
								maxlength="10" :placeholder="lang.siswa_nis" name="student_nis">
							<form-error :msg="error.student_nis" />
						</div>
						<div class="form-group">
							<label for="userinput6">{{ lang.siswa_nama }}</label>
							<input class="form-control border-primary" type="text" v-model="detailSiswa.student_name"
								:placeholder="lang.siswa_input_nama" name="student_name">
							<form-error :msg="error.student_name" />
						</div>
						<div class="form-group">
							<label for="userinput6">{{ lang.siswa_kk }}</label>
							<div class="input-group">
								<input class="form-control border-primary" type="text" v-model="searchParam"
									:placeholder="lang.siswa_input_kk" @keyup="searchFamily">
								<div class="input-group-append">
									<button class="btn btn-primary" type="button" @click="clearResult">{+ lang Admin.bersihkan +}</button>
								</div>
							</div>
							<div class="list-group list-group-custom add-margin-top-5px" v-if="searchResultWrapper">
								<a v-if="family.length === 0" href="javascript:void()" class="list-group-item list-group-item-action 
                                    list-group-item-custom">
									{+ lang Admin.no_search_result +} "{{ searchParam }}"
								</a>
								<a v-else href="javascript:void()" class="list-group-item list-group-item-action 
                                    list-group-item-custom" v-for="item in family" @click="selectParent(item)">
									{{ item.parent_father_name }} / {{ item.parent_mother_name }}
									({{item.parent_family_card}})
								</a>
							</div>
							<form-error :msg="error.parent_id" />
						</div>
						<div class="form-group">
							<label for="userinput6">{{ lang.siswa_label_ayah }}</label>
							<input class="form-control border-primary" disabled type="text" :placeholder="lang.siswa_input_ayah"
								v-model="selectedParent.father">
						</div>
						<div class="form-group">
							<label for="userinput6">{{ lang.siswa_label_ibu }}</label>
							<input class="form-control border-primary" disabled type="text" :placeholder="lang.siswa_input_ibu"
								v-model="selectedParent.mother">
							<input type="hidden" name="parent_id" v-model="selectedParent.id">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger" data-dismiss="modal"> {+ lang Admin.batal +}</button>
				<button type="button" :disabled="helper.disableSaveButton" class="btn btn-outline-primary"
					@click="save(true, detailSiswa.student_id)"> {+ lang Admin.simpan +}
				</button>
			</div>
		</div>
	</div>
</div>
