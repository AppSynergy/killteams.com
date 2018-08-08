<?php

namespace App\Console\Base;

trait DeployCommand
{
    /**
     * Find the id of an existing row, given it's name.
     */
    public function getIdByName($table, $value)
    {
        $row = \DB::table($table)->select('id')->where('name', $value)->first();
        if ($row) {
            return $row->id;
        }
        return false;
    }

}
