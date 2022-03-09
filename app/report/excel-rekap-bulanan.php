<?php

require 'ApiLoader.php';

$loader = new ApiLoader;

$params = $loader->transformParams([
    $_GET['month'],
    $_GET['year'],
    $_GET['grade_id']
]);

echo $loader->get('admin/absensi/excel-rekap-bulanan/', $params);