<div class="row">
    <div class="col-12">
        <div class="card {cardColor}">
            <div class="card-header {cardColor}">
                <h4 class="card-title {cardTitleColor}">{{ lang.app_setting_lang }}</h4>
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
                    <p>{{ lang.app_lang_desc }}</p>
                    <div class="row">
                      	<div class="col-md-12 col-sm-12 skin skin-square" id="lang-option">
							<fieldset>
								<input type="radio" name="input-radio-5" id="indonesia" value="indonesia" v-model="appLang">
								<label for="input-radio-18">{+ lang Admin.indonesia +}</label>
							</fieldset>
							<fieldset>
								<input type="radio" name="input-radio-5" id="english" value="english" v-model="appLang">
								<label for="input-radio-19">{+ lang Admin.english +}</label>
							</fieldset>
                    	</div>
                        <div class="col-12">
                            <div class="form-group">
                                <p></p>
                                <button type="button" class="btn btn-outline-info btn-min-width mr-1 mb-1" @click="setBahasa">{+ lang Admin.terapkan +}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

