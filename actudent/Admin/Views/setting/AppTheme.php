<div class="row">
	<div class="col-12">
		<div class="card {cardColor}">
			<div class="card-header {cardColor}">
				<h4 class="card-title {cardTitleColor}">{+ lang AdminSetting.app_setting_theme +}</h4>
				<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
						<li><a data-action="close"><i class="ft-x"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content">
				<div class="card-body">
					<p>{+ lang AdminSetting.app_setting_desc +}</p>
					<div class="row">
						<div class="col-md-12 col-sm-12 skin skin-square" id="theme-option">
							<fieldset>
								<input type="radio" name="input-radio-4" id="light-blue" value="light-blue"
									v-model="theme">
								<label for="input-radio-15">Light Blue</label>
							</fieldset>                            
							<fieldset>
								<input type="radio" name="input-radio-4" id="semi-dark" value="semi-dark"
									v-model="theme">
								<label for="input-radio-16">Semi Dark</label>
							</fieldset>
							<fieldset>
								<input type="radio" name="input-radio-4" id="night-vision" value="night-vision"
									v-model="theme">
								<label for="input-radio-17">Night Vision</label>
							</fieldset>
						</div>
						<div class="col-12">
							<div class="form-group">
								<p></p>
								<button type="button" class="btn btn-outline-info btn-min-width mr-1 mb-1"
									@click="setTheme">{+ lang Admin.terapkan +}</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			{# Tambah content di sini #}
		</div>
	</div>
</div>
