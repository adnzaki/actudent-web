<!DOCTYPE html>
<html>

<head>
	<title><?= $title ?></title>
	<?= view_cell('\Actudent::reportStyle') ?>
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
				<?php $rowspan = $colspan > 0 ? 2 : 1 ?>
				<tr style="text-transform: capitalize;" class="grey-shading">
					<th width="20" rowspan="<?= $rowspan ?>" class="p-t-b-3">No.</th>
					<th class="light-border p-t-b-3" rowspan="<?= $rowspan ?>">Nama Siswa</th>
					<th class="light-border p-t-b-3" rowspan="<?= $rowspan ?>">NIS</th>
					<?php if($colspan > 0): ?>
					<th class="light-border p-t-b-3" colspan="<?= $colspan ?>">Mata Pelajaran</th>
					<?php endif; ?>
				</tr>
				<?php if($colspan > 0): ?>
				<tr class="grey-shading">
					<?php foreach($column as $val): ?>
					<th class="light-border p-t-b-3"><?= $val ?></th>
					<?php endforeach; ?>
				</tr>
				<?php endif; ?>
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
	<?= view_cell('\Actudent::masterSign') ?>
</body>

</html>
