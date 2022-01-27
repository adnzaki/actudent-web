<?php namespace Actudent\Sync\Controllers;

class Test extends \Actudent
{
    public function getFile()
    {
       $condition = ['huhu'];
       $check = true;
       if($condition === null OR count($condition) === 0 OR ! $check )
       {
            $condition = ['baba', 'bibi', 'bubu'];
       }

       print_r($condition);

    }
}