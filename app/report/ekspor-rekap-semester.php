<?php

require 'ApiLoader.php';

$loader = new ApiLoader;

$params = $loader->transformParams([
    $_GET['grade_id'],
    $_GET['period'],
    $_GET['year']
]);

echo $loader->get('admin/absensi/ekspor-rekap-semester/', $params, true);