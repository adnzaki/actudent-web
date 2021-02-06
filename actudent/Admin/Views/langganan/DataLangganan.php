<div class="card-content collapse show">
	<div class="card-body">
		<div class="row">
			<div class="col-12 col-md-4 col-lg-6 col-xl-6">
				<div class="form-group">
					<button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#ajuanLanggananModal">
						{+ lang Admin.tambah +}
					</button>
				</div>
			</div>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table table-hover mb-0 cursor-pointer">
			<thead>
				<tr>
					<th class="decrease-col-size">#</th>
					<th>{+ lang AdminLangganan.subs_package_type +}</th>
					<th class="text-center">{+ lang AdminLangganan.subs_student_limit +}</th>
					<th>{+ lang AdminLangganan.subs_active_period +}</th>
					<th>{+ lang Admin.aksi +}</th>
				</tr>
			</thead>
			<tbody>
				<tr class="soft-dark">
					<td scope="row" class="decrease-col-size">1</td>
					<td>{{ package.name }}</td>
					<td class="text-center">{{ package.limit }}</td>
					<td>{{ package.expiration }}</td>
					<td>
						<a href="https://actudent.com/#pricing" target="_blank">
							<button type="button" class="btn btn-icon btn-info mr-1" data-toggle="tooltip" data-placement="top"
								title="{+ lang AdminLangganan.subs_view_more +}">
								<i class="la la-eye"></i>
							</button>
						</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
