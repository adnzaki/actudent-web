<!DOCTYPE html>
<html>

<head>
	<title><?= $title ?></title>
	<!-- <link rel="stylesheet" type="text/css" href="<?//= $assets.'css/laporan.css'?>"> -->
	<?= view_cell('\Actudent::reportStyle') ?>
</head>

<body>
	<?= view_cell('\Actudent::reportHeader') ?>
	<div class="pdf-content">
		<div class="judul-laporan center-align"><?= $title ?></div>
		<div class="judul-laporan center-align n-mt-15"><?= $year ?></div>
		<table>
			<thead class="grey-shading">
				<tr style="text-transform: capitalize;">
					<th class="light-border center-align" width="20" rowspan="2">No.</th>
					<th class="light-border center-align" rowspan="2" width="50">Nomor Induk Karyawan</th>
					<th class="light-border center-align" rowspan="2">Nama Pegawai</th>
					<th class="light-border center-align" colspan="3">Keterangan</th>
				</tr>
				<tr>
					<th class="light-border p-t-b-3" width="45">Hadir</th>
					<th class="light-border p-t-b-3" width="45">Izin</th>
					<th class="light-border p-t-b-3" width="45">Alfa</th>
				</tr>
			</thead>
			<tbody>				
				<?php $no = 1; foreach($data as $key): ?>
				<tr>
					<td class="center-align" width="30"><?= $no ?></td>
					<td class="force-left light-border "><?= $key['nip'] ?></td>
					<td class="force-left light-border "><?= $key['name'] ?></td>
					<td class="center-align light-border "><?= $key['present'] ?></td>
					<td class="center-align light-border "><?= $key['permit'] ?></td>
					<td class="center-align light-border "><?= $key['absent'] ?></td>
				</tr>
				<?php $no++; endforeach; ?>
				
			</tbody>
		</table>
	</div>
	<?= view_cell('\Actudent::gradeLeaderSign') ?>
</body>

</html>
