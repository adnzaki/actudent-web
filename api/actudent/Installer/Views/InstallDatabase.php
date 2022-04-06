<div class="card-content collapse show">
	<div class="card-body">
		<div class="row">
			<div class="col-12">
				<h4 class="{cardTitleColor}"><strong>{+ lang Setup.install_welcome +}</strong></h4>
				<p>{+ lang Setup.install_to_database +}: <strong>{dbName}</strong></p>
				<p v-if="helper.showPleaseWait">{+ lang Admin.mohon_tunggu +}</p>
				<p v-if="helper.disableSaveButton">
					<strong>{{ progressText }}</strong>
				</p>
				<p v-if="helper.showSuccessText">{{ successText }}</p>
				<br>
				<div class="form-group">
					<button type="button" :disabled="helper.disableSaveButton" 
						class="btn btn-outline-info" data-toggle="modal"
						@click="createUserModule">
						{{ confirmInstall }}
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
