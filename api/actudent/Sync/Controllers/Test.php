<?php namespace Actudent\Sync\Controllers;

class Test extends \Actudent\Core\Controllers\Actudent
{
    public function getFile()
    {
        $gtkFile = file_get_contents(PUBLICPATH . 'extras/' . 'GtkTemp.json');

        $gtkArray = json_decode($gtkFile);

        $waliKelas = array_filter($gtkArray, function($item) {
            return $item->ptk_id === '73fc6584-28c9-11e4-9a32-3b0cb38dde46';
        });

        echo '<pre>';
        print_r($waliKelas);
        echo '</pre>';

        // return $this->response->setJSON($gtkArray);
    }
}