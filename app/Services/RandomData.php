<?php

namespace App\Services;

use DB;
use Illuminate\Support\Str;

class RandomData
{
    /**
     * Generate Random UUID
     *
     * @param [type] $table
     * @return string
     */
    public function uuid($table) {
        $uuid = Str::random(20);
        $cData = DB::table("$table")->where('uuid', $uuid)->count();
        if($cData != 0) {
            $this->uuid($table);
        }
        else{
            return $uuid;
        }
    }
}