<!-- Modal -->
<div class="modal fade text-left" id="kelolaNilaiModal" role="dialog" aria-labelledby="myModalLabel2"
	aria-hidden="true">
	<!-- Error message -->
	<alert-msg :alert-class="alert.class" :header="alert.header" :text="alert.text" v-if="alert.show">
	</alert-msg>
	<!-- #End error message -->

	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header {modalHeaderColor} white">
				<h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> {{ lang.nilai_kelola_title }}</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body fix-height-500">
				<div class="row">
					<div class="col-12 float-element" v-if="saveScoreProgress">
						<div class="loader-wrapper custom-loader-wrapper left-35-loader">
							<div class="loader-container">
								<div class="ball-rotate loader-danger">
									<div></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive scroll-overheight">
					<table class="table table-hover mb-0 cursor-pointer">
						<thead>
							<tr>
								<th class="decrease-col-size">
									No.
								</th>
								<th class="small-pad-left">{+ lang AdminSiswa.siswa_nama +}</th>
								<th>{+ lang AdminNilai.page_title +}</th>
								<th>{+ lang AdminNilai.nilai_score_note +}</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(item, index) in studentList" :key="index" class="soft-dark">
								<td scope="row" class="decrease-col-size">
									{{ index + 1 }}
								</td>
								<td class="small-pad-left">{{ item.student }}</td>
								<td>
									<input class="form-control border-primary lineless-input" type="text" v-model="item.score"
										@keyup="forceFloat(item.score)">
								</td>
								<td><input class="form-control border-primary lineless-input" type="text" v-model="item.note"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger" data-dismiss="modal"> {+ lang Admin.batal +}</button>
				<button type="button" :disabled="helper.disableSaveButton" class="btn btn-outline-primary" @click="saveScores">
					{+ lang Admin.simpan +}</button>
			</div>
		</div>
	</div>
</div>
