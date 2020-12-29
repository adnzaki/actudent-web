<!-- Modal -->
<div class="modal fade text-left" id="editRuangModal" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
	<!-- Error message -->
	<alert-msg :alert-class="alert.class" :header="alert.header" :text="alert.text" v-if="alert.show">
	</alert-msg>
	<!-- #End error message -->

	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header {modalHeaderColor} white">
				<h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> {{ lang.ruang_form_add_title }}
				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form" id="formEditRuang">
					<div class="form-body skin skin-square">
						<div class="form-group">
							<label for="userinput5">{{ lang.ruang_kode }}</label>
							<input class="form-control border-primary" type="text" v-model="roomDetail.room_code" minlength="3"
								maxlength="6" :placeholder="lang.ruang_input_kode" name="room_code">
							<form-error :msg="error.room_code" />
						</div>

						<div class="form-group">
							<label for="userinput6">{{ lang.ruang_nama }}</label>
							<input class="form-control border-primary" type="text" v-model="roomDetail.room_name"
								:placeholder="lang.ruang_input_nama" name="room_name">
							<form-error :msg="error.room_name" />
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger" data-dismiss="modal"> {+ lang Admin.batal +}</button>
				<button type="button" :disabled="helper.disableSaveButton" class="btn btn-outline-primary"
					@click="save(true, roomDetail.room_id)"> {+ lang Admin.simpan +}</button>
			</div>
		</div>
	</div>
</div>
