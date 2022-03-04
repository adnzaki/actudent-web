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
				<tr style="text-transform: capitalize;">
					<th width="30">No.</th>
					<th class="force-left">Mata Pelajaran</th>
					<th class="force-left">Isi Materi</th>
					<th class="force-left">Nama Guru</th>
					<th class="force-left" colspan="2">Catatan Kehadiran</th>
				</tr>
			</thead>
			<tbody>				
				<?php $no = 1; foreach($journals as $key => $val): ?>
				<tr>
					<td class="center-align" width="30"><?= $no ?></td>
					<td class="force-left"><?= $val->lesson_name ?></td>
					<td class="force-left"><?= $val->description ?></td>
					<td class="force-left"><?= $val->staff_name ?></td>
					<td class="force-left">
						Hadir: <?= ($presence[$key]['present'] > 0) ? $presence[$key]['present'] : '-' ?><br>
						Tidak hadir: <?= ($presence[$key]['absent'] > 0) ? $presence[$key]['absent'] : '-' ?><br>
						Jumlah:
						<?php 
                            $jumlah = $presence[$key]['present'] + $presence[$key]['absent']; 
                            echo ($jumlah > 0) ? $jumlah : '-';
                        ?>
					</td>
					<td>
						Siswa tidak hadir: <br>
						<?php foreach($absence[$key] as $val): ?>
						<li><?= $val['name'] ?> (<?= $val['status'] ?>)</li>
						<?php endforeach; ?>
					</td>
				</tr>
				<?php $no++; endforeach; ?>
				
			</tbody>
		</table>
	</div>
	<?= view_cell('\Actudent::masterSign') ?>
</body>

</html>
