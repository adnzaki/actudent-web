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
		<div class="judul-laporan center-align n-mt-15"><?= $period ?></div>
		<table class="no-border sub-judul">
			<tr>
				<td class="no-border no-padding-top-bottom" width="100"><?= lang('AdminPegawai.staff_nama') ?></td>
				<td class="no-border no-padding-top-bottom">: <?= $name ?></td>
			</tr>
			<tr>
				<td class="no-border p-t-b-4" width="100"><?= lang('AdminPegawai.staff_id') ?></td>
				<td class="no-border text-capitalize p-t-b-4">: <?= $nip ?></td>
			</tr>
		</table>
		<table>
			<thead class="grey-shading">
				<tr style="text-transform: capitalize;">
					<th class="light-border center-align" width="20">No.</th>
					<th class="light-border center-align">Hari, Tanggal</th>
					<th class="light-border center-align">Datang</th>
					<th class="light-border center-align">Pulang</th>
					<th class="light-border center-align">Keterlambatan</th>
					<th class="light-border center-align">Waktu Kerja</th>
					<th class="light-border center-align">Lembur</th>
					<th class="light-border center-align">Status</th>
				</tr>
			</thead>
			<tbody>				
				<?php $no = 1; foreach($data as $key): ?>
				<tr>
					<td class="center-align" width="30"><?= $no ?></td>
					<td class="light-border"><?= $key['dateStr'] ?></td>
					<td class="center-align light-border"><?= $key['in'] ?></td>
					<td class="center-align light-border"><?= $key['out'] ?></td>
					<td class="center-align light-border"><?= $key['late'] ?></td>
					<td class="center-align light-border"><?= $key['work'] ?></td>
					<td class="center-align light-border"><?= $key['over'] ?></td>
					<td class="center-align light-border"><?= $key['label'] ?></td>
				</tr>
				<?php $no++; endforeach; ?>
				<tr>
					<td class="center-align light-border" colspan="4"><strong>Rekapitulasi Waktu</strong></td>
					<td class="center-align light-border"><strong><?= $late ?></strong></td>
					<td class="center-align light-border"><strong><?= $work ?></strong></td>
					<td class="center-align"><strong><?= $over ?></strong></td>
					<td class="light-border"></td>
				</tr>
				
			</tbody>
		</table>
		<br>
		<table class="no-border sub-judul">
			<tr>
				<td class="no-border p-t-b-4" colspan="2"><strong><i>Rekapitulasi Kehadiran:</i></strong></td>
			</tr>
			<tr>
				<td class="no-border p-t-b-4" width="50">Hadir</td>
				<td class="no-border p-t-b-4">: <strong><?= $hadir ?> Hari</strong></td>
			</tr>
			<tr>
				<td class="no-border p-t-b-4" width="50">Izin</td>
				<td class="no-border text-capitalize p-t-b-4">: <strong><?= $izin ?> Hari</strong></td>
			</tr>
			<tr>
				<td class="no-border p-t-b-4" width="50">Alfa</td>
				<td class="no-border text-capitalize p-t-b-4">: <strong><?= $alfa ?> Hari</strong></td>
			</tr>
		</table>
	</div>
	<?= view_cell('\Actudent::gradeLeaderSign') ?>
</body>

</html>
