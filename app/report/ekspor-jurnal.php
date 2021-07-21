<?php

require 'ApiLoader.php';

$loader = new ApiLoader;

$params = $loader->transformParams([
    $_GET['grade_id'],
    $_GET['day'],
    $_GET['date']
]);

echo $loader->run('admin/absensi/ekspor-jurnal/', $params);