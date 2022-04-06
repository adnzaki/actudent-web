<!-- Modal -->
<div class="modal fade text-left" id="editOrtuModal" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
	<!-- Error message -->
	<alert-msg :alert-class="alert.class" :header="alert.header" :text="alert.text" v-if="alert.show">
	</alert-msg>
	<!-- #End error message -->

	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header {modalHeaderColor} white">
				<h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> {{ lang.ortu_edit_title }}</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form" id="formEditOrtu">
					<div class="form-body">
						<div class="form-group">
							<label for="userinput5">{{ lang.ortu_kk }}</label>
							<input class="form-control border-primary" type="text" v-model="parentDetail.parent_family_card"
								minlength="16" maxlength="16" :placeholder="lang.ortu_input_kk" name="parent_family_card">
							<form-error :msg="error.parent_family_card" />
						</div>
						<div class="form-group">
							<label for="userinput6">{{ lang.ortu_label_ayah }}</label>
							<input class="form-control border-primary" type="text" v-model="parentDetail.parent_father_name"
								:placeholder="lang.ortu_input_ayah" name="parent_father_name">
							<form-error :msg="error.parent_father_name" />
						</div>
						<div class="form-group">
							<label for="userinput6">{{ lang.ortu_label_ibu }}</label>
							<input class="form-control border-primary" type="text" v-model="parentDetail.parent_mother_name"
								:placeholder="lang.ortu_input_ibu" name="parent_mother_name">
							<form-error :msg="error.parent_mother_name" />
						</div>
						<div class="form-group">
							<label for="userinput6">{{ lang.ortu_label_telp }}</label>
							<input class="form-control border-primary" type="text" v-model="parentDetail.parent_phone_number"
								minlength="11" maxlength="13" :placeholder="lang.ortu_input_telp" name="parent_phone_number">
							<form-error :msg="error.parent_phone_number" />
						</div>
						<div class="form-group" v-if="children.length > 0">
							<label>{{ lang.ortu_daftar_anak }}:</label>
							<li v-for="(item, index) in children" :key="index">
								{{ index + 1 }}. {{ item.student_name }}
								<span v-if="item.deleted === '1'" class="text-danger">( {{ lang.ortu_anak_nonaktif }} )</span>
							</li>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger" data-dismiss="modal"> {+ lang Admin.batal +}</button>
				<button type="button" :disabled="helper.disableSaveButton" class="btn btn-outline-primary"
					@click="save(true, parentDetail.parent_id)"> {+ lang Admin.simpan +}
				</button>
			</div>
		</div>
	</div>
</div>
