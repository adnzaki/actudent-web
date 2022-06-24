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
					<th class="light-border center-align">Status</th>
				</tr>
			</thead>
			<tbody>				
				<?php $no = 1; foreach($data as $key): ?>
				<tr>
					<td class="center-align p-t-b-4" width="30"><?= $no ?></td>
					<td class="light-border p-t-b-4"><?= $key['dateStr'] ?></td>
					<td class="center-align light-border p-t-b-4"><?= $key['in'] ?></td>
					<td class="center-align light-border p-t-b-4"><?= $key['out'] ?></td>
					<td class="center-align light-border p-t-b-4"><?= $key['late'] ?></td>
					<td class="center-align light-border p-t-b-4"><?= $key['label'] ?></td>
				</tr>
				<?php $no++; endforeach; ?>
				<tr>
					<td class="center-align light-border" colspan="4"><strong>Total Keterlambatan</strong></td>
					<td class="center-align"><strong><?= $late ?></strong></td>
					<td class="light-border"></td>
				</tr>
				
			</tbody>
		</table>
	</div>
	<?= view_cell('\Actudent::gradeLeaderSign') ?>
</body>

</html>
