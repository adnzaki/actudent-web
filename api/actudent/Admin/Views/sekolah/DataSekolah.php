<div class="card-content collapse show">
	<div class="card-body">
		<div class="row">
			<div class="col-12">
				<div class="form-group">
					<button type="button" class="btn btn-outline-info" data-toggle="modal">
						{+ lang Admin.perbarui +}
					</button>
				</div>
			</div>
		</div>
	</div>
	<div class="table-responsive" v-cloak>
		<table class="table table-hover mb-0 cursor-pointer">
			<tbody>
				<tr class="soft-dark" v-for="(value, key) in school">
					<td width="200">{{ key }}</td>
					<td>: {{ value }}</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
