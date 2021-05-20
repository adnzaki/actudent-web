<div class="modal fade text-left" id="tambahPenggunaModal" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">

	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header {modalHeaderColor} white">
				<h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> Info</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p class="text-center"><i>
					<strong class="warning-text">{+ lang AdminUser.user_attention +}!</strong>
					{+ lang AdminUser.user_manage_info +}
				</i></p>
			</div>
			<div class="modal-footer" v-if="!helper.deleteProgress">
				<button type="button" class="btn btn-outline-info" data-dismiss="modal"> OK</button>
			</div>
		</div>
	</div>

</div>
