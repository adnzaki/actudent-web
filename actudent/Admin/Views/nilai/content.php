<div class="row">
	<div class="col-12">
		<div class="card {cardColor}">
			<div class="card-header {cardColor}">
				<h4 class="card-title {cardTitleColor}">{+ lang AdminNilai.nilai_title +}</h4>
				<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li><a data-action="reload" @click="reloadData"><i class="ft-rotate-cw"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					</ul>
				</div>
			</div>
            <div class="loader-layer" v-if="spinner">
                <div class="loader-wrapper">
                    <div class="loader-container">
                        <div class="ball-rotate loader-danger">
                            <div></div>
                        </div>
                    </div>
                </div>            
            </div>
			{+ include Actudent\Admin\Views\siswa\alert +}
			{+ include Actudent\Admin\Views\nilai\NilaiSiswa +}
			{+ include Actudent\Admin\Views\nilai\FormTambahNilai +}
			{+ include Actudent\Admin\Views\nilai\FormEditNilai +}
		</div>
	</div>
</div>
