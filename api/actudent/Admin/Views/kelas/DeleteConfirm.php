<div class="modal fade text-left" id="hapusModal" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">

	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header {modalHeaderColor} white">
				<h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> {+ lang Admin.konfirmasi +}</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p v-if="helper.deleteProgress" class="text-center">
					<strong>{+ lang Admin.progress_hapus +}</strong>
				</p>
				<p v-else>{+ lang Admin.sure_to_delete +}</p>
			</div>
			<div class="modal-footer" v-if="!helper.deleteProgress">
				<button type="button" class="btn btn-outline-danger" data-dismiss="modal"> {+ lang Admin.batal +}</button>
				<button type="button" :disabled="helper.disableSaveButton" class="btn btn-outline-primary" @click="deleteGrade">
					{+ lang Admin.hapus +}</button>
			</div>
		</div>
	</div>

</div>
