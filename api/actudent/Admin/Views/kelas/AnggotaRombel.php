<!-- Modal -->
<div class="modal fade text-left" id="anggotaRombel" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true"
	data-backdrop="static">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header {modalHeaderColor} white">
				<h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i>
					{{ lang.kelas_group_member_title }} - <strong>{{ gradeName }}</strong>
				</h4>
				<button type="button" class="close" aria-label="Close" @click="closeAnggotaRombel">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body fix-height-500">
				<div class="row">
					<div class="col-12 float-element" v-if="addMemberProgress">
						<div class="loader-wrapper custom-loader-wrapper">
							<div class="loader-container">
								<div class="ball-rotate loader-danger">
									<div></div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-5 scroll-overheight">
						<button type="button" :disabled="helper.disableSaveButton"
							class="btn btn-outline-danger add-margin-bottom-5px" @click="emptyGroup">
							{{ lang.kelas_kosongkan_rombel }}</button>
						<div class="table-responsive">
							<table class="table table-hover mb-0 cursor-pointer">
								<thead>
									<tr>
										<th>#</th>
										<th colspan="2">{+ lang AdminSiswa.siswa_nama +}</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(item, index) in studentGroup" :key="index" class="soft-dark">
										<td>{{ index + 1 }}</td>
										<td>{{ item.student_name }}</td>
										<td>
											<button type="button" class="btn btn-icon btn-danger mr-1" data-toggle="tooltip"
												data-placement="top" @click="removeGroupMember(item.student_id)"
												title="{+ lang AdminKelas.kelas_hapus_member_title +}">
												<i class="la la-minus"></i>
											</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<p v-if="studentGroup.length === 0"><br>{+ lang Admin.no_data +}</p>
					</div>
					<div class="col-7 grid-border-left scroll-overheight">
						<div class="input-group">
							<input type="text" class="form-control" @keyup.enter="filter" v-model="search"
								:placeholder="lang.kelas_group_member_search" aria-describedby="button-addon2">
							<div class="input-group-append">
								<button class="btn btn-primary" type="button" @click="filter">Go</button>
							</div>
						</div>
						<div class="table-responsive add-margin-top-5px">
							<table class="table table-hover mb-0 cursor-pointer">
								<thead>
									<tr>
										<th>{+ lang AdminSiswa.siswa_nis +}</th>
										<th colspan="2">{+ lang AdminSiswa.siswa_nama +}</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(item, index) in data" :key="index" class="soft-dark">
										<td>{{ item.student_nis }}</td>
										<td>{{ item.student_name }}</td>
										<td>
											<button type="button" class="btn btn-icon btn-info mr-1" data-toggle="tooltip"
												data-placement="top" :title="lang.kelas_add_member_title"
												@click="addGroupMember(item.student_id)">
												<i class="la la-plus"></i>
											</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<pager :show-paging="showPaging" :link-class="linkClass" :page-links="pageLinks" :num-links="numLinks"
							:active-link="activeLink" :nav="nav" :first="first" :prev="prev" :next="next" :last="last"
							:row-range="rowRange" />
					</div>
				</div>


			</div>
			<div class="modal-footer">
				<button type="button" :disabled="helper.disableSaveButton" @click="closeAnggotaRombel"
					class="btn btn-outline-success"> {+ lang Admin.tutup +}</button>
			</div>
		</div>
	</div>

</div>
