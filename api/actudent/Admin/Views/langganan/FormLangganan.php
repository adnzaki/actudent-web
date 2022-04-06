<!-- Modal -->
<div class="modal fade text-left" id="ajuanLanggananModal" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
	<!-- Error message -->
	<alert-msg :alert-class="alert.class" :header="alert.header" :text="alert.text" v-if="alert.show">
	</alert-msg>
	<!-- #End error message -->

	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header {modalHeaderColor} white">
				<h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> {{ lang.subs_extension_title }}</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form" id="formLangganan">
					<div class="form-body">
						<div class="row">
							<div class="col-12 col-lg-6">
								<div class="form-group">
									<label>{+ lang AdminFeedback.feedback_label_email +}</label>
									<input class="form-control border-primary" type="email" 
										placeholder="{+ lang AdminFeedback.feedback_input_email +}" name="package_email">
									<form-error :msg="error.package_email" />					
								</div>
							</div>						
						</div>
						<div class="row">
							<div class="col-12 col-lg-6">
								<div class="form-group">
									<label>{{ lang.subs_package_type }}</label>	
									<select class="select2 form-control block" id="selectPackage" name="package_type" style="width: 100%">
										<option value="free">Free</option>
										<option value="starter">Starter</option>
										<option selected value="standard">Standard</option>
										<option value="enhanced">Enhanced</option>
										<option value="enterprise">Enterprise</option>
									</select>					
								</div>
							</div>						
						</div>
						<div class="row">
							<input type="hidden" name="package_duration" v-model="selectedPackage.duration">
							<div class="col-12 col-lg-4" v-for="(item, index) in packageDetails" :key="index">
								<div class="form-group" @click="choosePackage(index)">
									<div :class="['card', item.bgColor, 'cursor-pointer']">
										<div class="card-content">
											<div class="card-body">
												<div class="media d-flex">
													<div class="align-self-center">
														<i class="icon-tag text-white font-large-2 float-left"></i>
													</div>
													<div class="media-body text-white text-right">
														<h3 class="text-white">{{ item.price | numberFormat }}</h3>
														<span> {{ item.duration }} </span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>								
							</div>						
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger" data-dismiss="modal"> {+ lang Admin.batal +}</button>
				<button type="button" :disabled="helper.disableSaveButton" @click="send" class="btn btn-outline-primary"> 
					{+ lang Admin.kirim +}
				</button>
			</div>
		</div>
	</div>
</div>
