<!DOCTYPE html>
<html>

<head>
	<title><?= $title ?></title>
	<link rel="stylesheet" href="<?= $assets.'css/laporan.css'?>">
</head>

<body>
	<?= view_cell('\Actudent::reportHeader') ?>
	<div class="pdf-content">
		<div class="judul-laporan center-align"><?= $title ?></div>
		<table class="no-border sub-judul">
			<tr>
				<td class="no-border no-padding-top-bottom" width="30"><?= lang('AdminAbsensi.absensi_jurnal_kelas') ?></td>
				<td class="no-border no-padding-top-bottom">: <?= $grade->grade_name ?></td>
			</tr>
			<tr>
				<td class="no-border p-t-b-3" width="30"><?= lang('AdminAbsensi.absensi_jurnal_hari') ?></td>
				<td class="no-border text-capitalize p-t-b-3">: <?= $day ?></td>
			</tr>
			<tr>
				<td class="no-border no-padding-top-bottom" width="30"><?= lang('AdminAbsensi.absensi_jurnal_tanggal') ?></td>
				<td class="no-border no-padding-top-bottom">: <?= $date ?></td>
			</tr>
		</table>
		<br>
		<table>
			<thead>
				<tr style="text-transform: capitalize;" class="grey-shading">
					<th width="20" rowspan="3" class="p-t-b-3">No.</th>
					<th class="light-border p-t-b-3" rowspan="3">Nama Siswa</th>
					<th class="light-border p-t-b-3" rowspan="3">NIS</th>
					<th class="light-border p-t-b-3" colspan="<?= $colspan ?>">Jam Ke</th>
				</tr>
				<tr class="grey-shading">
					<?php foreach($column as $key): ?>
					<th class="light-border p-t-b-3"><?= $key['lesson_hour'] ?></th>
					<?php endforeach; ?>
				</tr>
				<tr class="grey-shading">
					<?php foreach($column as $key): ?>
					<th class="light-border p-t-b-3"><?= $key['time'] ?></th>
					<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
				<?php $no = 1; ?>
				<?php foreach($presence as $key => $val): ?>
				<tr>
					<td class="center-align border-right p-t-b-3" width="30"><?= $no ?></td>
					<td class="border-right p-t-b-3"><?= $val['students']->student_name ?></td>
					<td class="center-align border-right p-t-b-3"><?= $val['students']->student_nis ?></td>
					<?php foreach($column as $key => $res): ?>
					<td class="center-align border-right p-t-b-3"><?= $val['data'][$key]['status'] ?? '-' ?></td>
					<?php endforeach; ?>
				</tr>
				<?php $no++; endforeach; ?>
			</tbody>
		</table>
	</div>
	<?= view_cell('\Actudent::homeroomSign') ?>
</body>

</html>
