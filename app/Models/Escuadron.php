<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Escuadron extends Model
{
    protected $table = 'escuadron';
    public static $tables = 'escuadron';
    protected $guarded = [];

    public static function getAll()
    {
        $users = DB::table(self::$tables);
        $users = $users->whereNull('deleted_at');
        return $users->get();
    }
}
