<!-- Modal -->
<div class="modal fade text-left" id="tambahMapelModal" role="dialog" aria-labelledby="myModalLabel2"
	aria-hidden="true">
	<!-- Error message -->
	<alert-msg :alert-class="alert.class" :header="alert.header" :text="alert.text" v-if="alert.show">
	</alert-msg>
	<!-- #End error message -->

	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header {modalHeaderColor} white">
				<h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> {{ lang.mapel_form_add_title }}
				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form" id="formTambahMapel">
					<div class="form-body skin skin-square">
						<div class="form-group">
							<label for="userinput5">{{ lang.mapel_kode }}</label>
							<input class="form-control border-primary" type="text" minlength="3" maxlength="6"
								:placeholder="lang.mapel_input_kode" name="lesson_code">
							<form-error :msg="error.lesson_code" />
						</div>

						<div class="form-group">
							<label for="userinput6">{{ lang.mapel_nama }}</label>
							<input class="form-control border-primary" type="text" :placeholder="lang.mapel_input_nama"
								name="lesson_name">
							<form-error :msg="error.lesson_name" />
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger" data-dismiss="modal"> {+ lang Admin.batal +}</button>
				<button type="button" :disabled="helper.disableSaveButton" class="btn btn-outline-primary" @click="save()"> {+
					lang Admin.simpan +}</button>
			</div>
		</div>
	</div>
</div>
