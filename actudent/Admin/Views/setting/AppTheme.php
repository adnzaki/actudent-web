<div class="row">
    <div class="col-12">
        <div class="card {cardColor}">
            <div class="card-header {cardColor}">
                <h4 class="card-title {cardTitleColor}">{+ lang Admin.app_setting_theme +}</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload" @click="reloadData" ><i class="ft-rotate-cw"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                </div>
            </div>
			<div class="card-content">
                <div class="card-body">
                    <p>{+ lang Admin.app_setting_desc +}</p>
                    <div class="row">
                      	<div class="col-md-12 col-sm-12">
							<fieldset>
								<input type="radio" name="input-radio-4" id="input-radio-15" value="light-blue" v-model="theme">
								<label for="input-radio-15">Light Blue</label>
							</fieldset>
							<fieldset>
								<input type="radio" name="input-radio-4" id="input-radio-16" value="semi-dark" v-model="theme">
								<label for="input-radio-16">Semi Dark</label>
							</fieldset>
                            <fieldset>
								<input type="radio" name="input-radio-4" id="input-radio-17" value="night-vision" v-model="theme">
								<label for="input-radio-17">Night Vision</label>
							</fieldset>
                    	</div>
                        <div class="col-12">
                            <div class="form-group">
                                <p></p>
                                <button type="button" class="btn btn-outline-info btn-min-width mr-1 mb-1" @click="setTheme">{+ lang Admin.terapkan +}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {# Tambah content di sini #}
        </div>
    </div>
</div>

