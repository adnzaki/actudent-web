<div class="row">
    <div class="col-12">
        <div class="card {cardColor}">
            <div class="card-header {cardColor}">
                <h4 class="card-title {cardTitleColor}">Warna Tema</h4>
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
                    <p>Pilihan warna tema tampilan aplikasi untuk menyesuaikan suasana anda saat ini.</p>
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
                                <button type="button" class="btn btn-primary round btn-min-width mr-1 mb-1" @click="setTheme">Terapkan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php //$this->view('admin/pages/siswa/data-siswa') ?>
            <?php //$this->view('admin/pages/siswa/form-tambah-siswa') ?>
        </div>
    </div>
</div>

