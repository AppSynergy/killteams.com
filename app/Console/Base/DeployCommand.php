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

    public function dataExists($table, $selector)
    {
        $row = \DB::table($table)->where($selector)->first();
        if ($row) {
            return true;
        }
        return false;
    }

    public function getIdByData($table, $selector)
    {
        $row = \DB::table($table)->select('id')->where($selector)->first();
        if ($row) {
            return $row->id;
        }
        return false;
    }

}
